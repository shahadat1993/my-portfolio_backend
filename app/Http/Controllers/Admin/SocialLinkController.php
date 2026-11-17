<?php
namespace App\Http\Controllers\Admin;

use App\Models\SocialLink;

class SocialLinkController extends CrudController
{
    protected function model(): string { return SocialLink::class; }
    protected function meta(): array { return ['title' => 'Social links', 'singular' => 'Social link', 'route' => 'social', 'icon' => 'bx-share-alt']; }
    protected function searchable(): array { return ['platform', 'label', 'url']; }
    protected function order($q) { return $q->orderBy('sort_order')->orderBy('id'); }
    protected function columns(): array
    {
        return [['key' => 'platform', 'label' => 'Platform', 'type' => 'title', 'sub' => 'url'], ['key' => 'label', 'label' => 'Label'], ['key' => 'is_active', 'label' => 'Shown', 'type' => 'bool'], ['key' => 'sort_order', 'label' => 'Order']];
    }
    protected function fields(): array
    {
        return [
            ['name' => 'platform', 'label' => 'Platform (decides the icon)', 'type' => 'select', 'options' => config('site.platforms'), 'col' => 4, 'rules' => 'required|in:' . implode(',', array_keys(config('site.platforms')))],
            ['name' => 'label', 'label' => 'Text next to the icon (optional)', 'type' => 'text', 'col' => 4],
            ['name' => 'sort_order', 'label' => 'Order', 'type' => 'number', 'col' => 2, 'default' => 0, 'rules' => 'nullable|integer'],
            ['name' => 'is_active', 'label' => 'Show on website', 'type' => 'toggle', 'col' => 2, 'default' => true],
            ['name' => 'url', 'label' => 'Link (full URL, mailto:…, tel:…)', 'type' => 'text', 'col' => 12, 'rules' => 'required|string|max:500', 'help' => 'Examples: https://facebook.com/yourpage · https://wa.me/8801XXXXXXXXX · mailto:you@mail.com · tel:+8801XXXXXXXXX'],
        ];
    }
}
