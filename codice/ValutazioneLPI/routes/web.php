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
    $router->get('/confirmation/{param}', 'LoginController@confirmation');
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

/**
 * Route che gestisce le chiamate a termine del login
 */
$router->group(['middleware' => 'jwt.auth', 'prefix' => 'login'], function() use ($router) {
    //route che mostra la pagina dopo il login
    $router->get('/login', 'LoginController@login');
});


/**
 * Gruppo di route che gestisce le chiamate della pagina teacher
 */
$router->group(['middleware' => 'jwt.auth', 'prefix' => 'teacher'], function() use ($router) {
    //route che mostra la pagina dopo il login
    $router->get('/', 'TeacherController@home');

    //route che ritorna tutti i formulari
    $router->get('/forms', 'TeacherController@getForms');
});

/**
 * Gruppo di route che gestisce le chiamate della pagina admin
 */
$router->group(['middleware' => 'jwt.auth', 'prefix' => 'admin'], function() use ($router) {
    //route che mostra la pagina di amministrazione chiamando URL/admin
    $router->get('/', 'AdminController@home');
    
    //route che ritorna tutti gli utenti chiamando URL/admin/users
    $router->get('/users', 'AdminController@getUsers');

    //route di aggiunta degli utenti
    $router->post('/user/add', 'AdminController@addUser');

    //route che ritorna l'utente con l'id passato
    $router->get('/user/{id}', 'AdminController@getUser');

    //route che consente di eliminare un utente
    $router->delete('/user/delete/{id}', 'AdminController@deleteUser');

    //route che consente di aggiornare un utente
    $router->put('/user/update/{id}', 'AdminController@updateUser');

    //route che ritorna tutte le motivazioni chiamando URL/admin/forms
    $router->get('/justifications', 'AdminController@getJustifications');

    //route che ritorna la motivazione con l'id passato
    $router->get('/justification/{id}', 'AdminController@getJustification');

    //route di aggiunta degli utenti
    $router->post('/justification/add', 'AdminController@addJustification');

    //route che consente di eliminare una motivazione
    $router->delete('/justification/delete/{id}', 'AdminController@deleteJustification');

    //route che consente di aggiornare una motivazione
    $router->put('/justification/update/{id}', 'AdminController@updateJustification');
});