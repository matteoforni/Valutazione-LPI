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

$router->get('/', function () use ($router) {
    return view('login/index');
});

$router->group(['prefix' => 'login'], function () use ($router) {
    $router->get('/', 'LoginController@home');
    $router->post('/authenticate', 'LoginController@authenticate');
});

$router->group(['prefix' => 'register'], function () use ($router) {
    $router->get('/', 'RegisterController@home');
    $router->post('/register', 'RegisterController@register');
});

$router->group(['middleware' => 'jwt.auth', 'prefix' => 'auth'], function() use ($router) {
    $router->get('/', 'LoginController@users');
});