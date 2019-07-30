<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class PortalGlobalVariables extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV') === 'prod') {
            /*
             * TODO add urls from Portal connections -- from database
             */
            View::share('portal_url', 'https://www.demo-postoj.crowdfundingtoolbox.news');
            View::share('portal_register_url', 'https://www.demo-postoj.crowdfundingtoolbox.news/registracia');
        } else {
            // urls for dev
            View::share('portal_url', 'http://www.postoj.local:8000');
            View::share('portal_register_url', 'http://registracia.postoj.local:8000');
        }
    }
}
