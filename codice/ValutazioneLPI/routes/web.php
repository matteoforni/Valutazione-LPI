<?php

/**
 * Route che mostra la pagina di login quando si apre la root del sito
 */
$router->get('/', function () use ($router) {
    return view('login/index');
});

/**
 * Gruppo di route che gestisce le chiamate alla pagina di login
 */
$router->group(['prefix' => 'login'], function () use ($router) {
    //route che richiama il metodo authenticate quando si chiama URL/login/authenticate
    $router->post('/authenticate', 'LoginController@authenticate');
});

/**
 * Gruppo di route che gestisce le chiamate alla pagina di registrazione
 */
$router->group(['prefix' => 'register'], function () use ($router) {
    //route che mostra la pagina di registrazione chiamando URL/register
    $router->get('/', 'RegisterController@home');

    //route che richiama il metodo register quando si chiama URL/register/register
    $router->post('/register', 'RegisterController@register');
});

//ROUTE DI TEST DEL MIDDLEWARE
$router->group(['middleware' => 'jwt.auth', 'prefix' => 'auth'], function() use ($router) {
    $router->get('/', 'LoginController@users');
});