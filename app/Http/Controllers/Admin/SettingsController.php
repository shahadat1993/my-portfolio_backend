<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show()
    {
        return view('admin.settings.index', ['groups' => config('site.groups'), 'values' => Setting::map()]);
    }

    public function update(Request $r)
    {
        $fields = [];
        foreach (config('site.groups') as $g) foreach ($g['fields'] as $f) $fields[] = $f;
        foreach ($fields as $f) if ($f['type'] === 'image') $r->validate([$f['key'] => 'nullable|image|max:8192']);
        Setting::saveFields($fields, $r);
        return back()->with('ok', 'Settings saved.');
    }
}
