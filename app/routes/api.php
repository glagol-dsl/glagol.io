<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/** @var \Laravel\Lumen\Routing\Router $router */
$router->post('/api/sign-up', 'SignUpController@signUp');
$router->post('/api/sign-in', ['middleware' => 'with_client_credentials', 'uses' => 'SignInController@issueToken']);
