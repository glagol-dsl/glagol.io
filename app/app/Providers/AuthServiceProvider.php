<?php

namespace App\Providers;

use App\Auth\Passport\Passport;
use Carbon\Carbon;
use Dusterio\LumenPassport\RouteRegistrar;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        Passport::tokensExpireIn(Carbon::now()->addMinutes(10));
    }
}
