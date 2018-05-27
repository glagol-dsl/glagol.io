<?php

namespace App\Providers;

use GlagolCloud\Modules\User\AuthenticatedUser;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Hasher::class, function () {
            return $this->app->make(HashManager::class)->driver();
        });

        $this->app->singleton(AuthenticatedUser::class, function (Application $app) {
            $user = $app->make(Guard::class)->user();
            return AuthenticatedUser::query()->findOrFail($user->id);
        });
    }
}
