<?php
declare(strict_types=1);

namespace App\Auth\Passport;

use Dusterio\LumenPassport\LumenPassport;
use Dusterio\LumenPassport\RouteRegistrar;
use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Router;

class Passport extends LumenPassport
{
    /**
     * Get a Passport route registrar.
     *
     * @param  callable|Router|Application  $callback
     * @param  array  $options
     */
    public static function routes($callback = null, array $options = [])
    {
        if ($callback instanceof Application && preg_match('/5\.[56]\..*/', $callback->version()))
            $callback = $callback->router;

        $callback = $callback ?: function (RouteRegistrar $router) {
            $router->all();
        };

        $defaultOptions = [
            'prefix' => 'oauth',
            'namespace' => '\Laravel\Passport\Http\Controllers',
        ];

        $options = array_merge($defaultOptions, $options);

        app('router')->group(array_except($options, ['namespace']), function ($router) use ($callback, $options) {
            $callback(new RouteRegistrar($router, $options));
        });
    }
}
