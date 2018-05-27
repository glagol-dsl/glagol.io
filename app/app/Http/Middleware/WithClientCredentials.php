<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WithClientCredentials
{
    public function handle(Request $request, Closure $next): Response
    {
        $email = $request->input('email');
        $password = $request->input('password');


        $request->request->replace([]);
        foreach (config('auth.defaults.client_credentials') as $key => $value) {
            $request->request->set($key, $value);
        }

        $request->request->set('username', $email);
        $request->request->set('password', $password);

        return $next($request);
    }
}