<?php
namespace App\Models;

use App\Support\Uploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    /** Every editable field: key => definition (from config/site.php + config/pages.php). */
    public static function schema(): array
    {
        static $s = null;
        if ($s !== null) return $s;
        $s = [];
        foreach (config('site.groups') as $g) foreach ($g['fields'] as $f) $s[$f['key']] = $f;
        foreach (config('pages.pages') as $p) foreach ($p['sections'] as $sec) foreach ($sec['fields'] as $f) $s[$f['key']] = $f;
        return $s;
    }

    /** key => value (DB value or schema default). list/repeater fields come back as PHP arrays. */
    public static function map(): array
    {
        return Cache::rememberForever('settings.map', function () {
            $db = static::query()->pluck('value', 'key')->all();
            $out = [];
            foreach (static::schema() as $k => $f) {
                if ($f['type'] === 'note') continue;
                $raw = $db[$k] ?? null;
                $def = $f['default'] ?? null;
                if (in_array($f['type'], ['list', 'repeater'], true)) {
                    $v = $raw !== null ? json_decode($raw, true) : null;
                    $out[$k] = is_array($v) ? $v : (is_array($def) ? $def : []);
                } else {
                    $out[$k] = $raw !== null ? $raw : $def;
                }
            }
            return $out;
        });
    }

    public static function get(string $key, $default = null)
    {
        $v = static::map()[$key] ?? null;
        return ($v === null || $v === '' || $v === []) ? $default : $v;
    }

    public static function put(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        static::forgetCache();
    }

    public static function forgetCache(): void { Cache::forget('settings.map'); }

    /** Settings safe for the public website (images → URLs, plus a CORS-enabled URL for canvas use). */
    public static function publicMap(): array
    {
        $map = static::map();
        $out = [];
        foreach (static::schema() as $k => $f) {
            if ($f['type'] === 'note' || ($f['public'] ?? true) === false) continue;
            $v = $map[$k] ?? null;
            if ($f['type'] === 'image') {
                $out[$k] = Media::url($v);
                $out[$k . '_cors'] = $v ? url('/api/image/' . ltrim($v, '/')) : null;
            } else {
                $out[$k] = $v;
            }
        }
        return $out;
    }

    /** Save the submitted values of the given fields (used by Site settings and by every Pages form). */
    public static function saveFields(array $fields, Request $r): void
    {
        $current = static::map();
        foreach ($fields as $f) {
            $k = $f['key'];
            switch ($f['type']) {
                case 'note': break;
                case 'image':
                    if ($r->hasFile($k)) { Uploader::delete($current[$k] ?? null); static::put($k, Uploader::store($r->file($k), 'site')); }
                    elseif ($r->boolean('remove_' . $k)) { Uploader::delete($current[$k] ?? null); static::put($k, null); }
                    break;
                case 'toggle': static::put($k, $r->boolean($k) ? '1' : '0'); break;
                case 'list':
                    $lines = array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string) $r->input($k))), fn ($x) => $x !== ''));
                    static::put($k, json_encode($lines, JSON_UNESCAPED_UNICODE)); break;
                case 'repeater':
                    $rows = [];
                    foreach ((array) $r->input($k, []) as $row) {
                        $row = array_map(fn ($v) => is_string($v) ? trim($v) : $v, (array) $row);
                        if (collect($row)->filter(fn ($v) => $v !== null && $v !== '')->isNotEmpty()) $rows[] = $row;
                    }
                    static::put($k, json_encode($rows, JSON_UNESCAPED_UNICODE)); break;
                default: static::put($k, $r->input($k));
            }
        }
        static::forgetCache();
    }
}
