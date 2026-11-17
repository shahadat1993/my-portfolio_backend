<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Post, Project, Setting};

/** /sitemap.xml and /robots.txt (public, generated from the database). */
class SeoController extends Controller
{
    protected function base(): string { return rtrim((string) (Setting::get('seo_canonical_base') ?: config('site.frontend_url')), '/'); }

    public function sitemap()
    {
        $b = $this->base(); $urls = [];
        if (Setting::get('seo_index') === '1') {
            foreach (['home' => '/', 'about' => '/about', 'projects' => '/projects', 'blogs' => '/blogs', 'contact' => '/contact'] as $page => $path) {
                if (Setting::get("{$page}_seo_noindex") !== '1') $urls[] = [$b . ($path === '/' ? '' : $path), now(), $path === '/' ? '1.0' : '0.8'];
            }
            foreach (Project::published()->get(['slug', 'updated_at']) as $p) $urls[] = [$b . '/projects/' . $p->slug, $p->updated_at, '0.7'];
            foreach (Post::published()->get(['slug', 'updated_at']) as $p) $urls[] = [$b . '/blogs/' . $p->slug, $p->updated_at, '0.7'];
        }
        $xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as [$loc, $mod, $pr]) $xml .= '<url><loc>' . e($loc) . '</loc><lastmod>' . $mod->toAtomString() . '</lastmod><priority>' . $pr . '</priority></url>';
        return response($xml . '</urlset>', 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $txt = "User-agent: *\n" . (Setting::get('seo_index') === '1' ? "Allow: /\nDisallow: /admin\n" : "Disallow: /\n") . 'Sitemap: ' . url('/sitemap.xml') . "\n";
        return response($txt, 200, ['Content-Type' => 'text/plain']);
    }
}
