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


$app->get('/', function () use ($app) {
	return $app->version();
});

//User
$app->get('v1/main/user','UserController@select');
$app->get('v1/main/user/{id}', 'UserController@selectById');
$app->post('v1/main/user',	'UserController@insert');
