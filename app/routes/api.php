<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->post('sign-up', 'SignUpController@signUp');
$router->post('sign-in', ['middleware' => 'with_client_credentials', 'uses' => 'SignInController@issueToken']);

$router->group(['prefix' => 'public-key', 'middleware' => ['auth:api']], function (\Laravel\Lumen\Routing\Router $router) {
    $router->get('/', 'PublicKeyController@index');
    $router->post('/', 'PublicKeyController@store');
});

