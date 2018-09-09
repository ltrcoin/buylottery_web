<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Locale;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Locale::class, function ($app) {
            return new Locale($app);
        });
    }
}
