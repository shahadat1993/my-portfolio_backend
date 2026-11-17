<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        // Contact form + newsletter: max 5 requests / minute / IP
        RateLimiter::for('contact', fn (Request $r) => Limit::perMinute(5)->by($r->ip()));
        // প্রোডাকশন এনভায়রনমেন্টে জোর করে HTTPS ব্যবহার করার জন্য
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
