<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

/** Edit every text / image / switch of one page (or one section of a page) of the website. */
class PagesController extends Controller
{
    protected function load(string $page, ?string $section): array
    {
        $cfg = config("pages.pages.$page");
        abort_unless($cfg, 404);
        if ($section) abort_unless(isset($cfg['sections'][$section]), 404);
        return [$cfg, $section ? [$section => $cfg['sections'][$section]] : $cfg['sections']];
    }

    public function show(string $page, ?string $section = null)
    {
        [$cfg, $sections] = $this->load($page, $section);
        return view('admin.pages.show', ['page' => $page, 'cfg' => $cfg, 'sections' => $sections, 'only' => $section, 'values' => Setting::map()]);
    }

    public function update(Request $r, string $page, ?string $section = null)
    {
        [, $sections] = $this->load($page, $section);
        $fields = [];
        foreach ($sections as $s) foreach ($s['fields'] as $f) $fields[] = $f;
        foreach ($fields as $f) if ($f['type'] === 'image') $r->validate([$f['key'] => 'nullable|image|max:8192']);
        Setting::saveFields($fields, $r);
        return back()->with('ok', 'Saved. The website shows the change immediately.');
    }
}
