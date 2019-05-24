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

$router->group(['prefix' => 'api/v1/'], function () use ($router) {
    // 登入驗證
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('/login', 'UserController@login');


        $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
            $router->get('/', 'UserController@list');
            $router->post('/create', 'UserController@create');
            $router->put('/editUser', 'UserController@editUser');
            $router->delete('/delete', 'UserController@delete');
        });
    });
});

$router->group(['prefix' => 'api/login/'], function () use ($router) {
   //登入日誌
   $router->group(['prefix' => 'user_login'], function () use ($router) {
       $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
           $router->get('/', 'UserLoginController@list');
       });
   });
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});


