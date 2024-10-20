<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Models\WebMenu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (Schema::hasTable('web_menus')) {
            $web_menus = WebMenu::tree();
            View::share('web_menus', $web_menus);
        }

        // Check if the 'site_settings' table exists
        if (Schema::hasTable('site_settings')) {
            // Site setting calling to cache in 5 hours refresh
            $siteSettings = Cache()->remember(
                'siteSettings',
                3600,
                fn() => SiteSetting::all()->keyBy('key')
            );
            View::share('siteSettings', $siteSettings);
        }
    }
}
