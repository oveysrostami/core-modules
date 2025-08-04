<?php


namespace Oveys\CoreModules;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(\Nwidart\Modules\LaravelModulesServiceProvider::class);
    }

    public function boot()
    {
        // می‌تونی اگر نیاز بود اینجا ماژول‌ها رو boot کنی یا چیزی publish کنی
    }
}