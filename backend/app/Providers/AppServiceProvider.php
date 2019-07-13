<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Passport::routes();
//        Passport::tokensExpireIn(now()->addDay(1));
//        Passport::refreshTokensExpireIn(now()->addDays(16));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
