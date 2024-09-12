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

// 超级管理员的后台管理
$router->group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () use($router) {
    $router->get('/', 'AdminController@index');
});

// 普通用户的后台管理
$router->group(['prefix' => 'posts', 'middleware' => ['auth']], function () use ($router) {
    $router->get('/',  'PostController@index');
    $router->get('/{id}', 'PostController@show');
    $router->get('/latest', 'PostController@latest');
});

