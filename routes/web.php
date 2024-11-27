<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return $router->app->version();
});

$router->post('/init', 'InitController@init');

$router->post('/auth/login', ['middleware' => ['init'], 'uses' => 'AuthController@login']);

$router->group(['middleware' => ['init', 'auth']], function () use($router) {
    $router->post('/profile', 'AuthController@profile');
    // 超级管理员的后台管理
    $router->group(['prefix' => 'admin', 'middleware' => ['admin']], function () use($router) {
        $router->get('/', 'AdminController@index');
    });
    // 普通用户的后台管理
    $router->group(['prefix' => 'posts'], function () use ($router) {
        $router->get('/latest', 'PostController@latest');
        $router->get('/',  'PostController@index');
        $router->post('/', 'PostController@store');
        $router->put('/{id}', 'PostController@edit');
        $router->get('/{id}', 'PostController@show');
    });
});



