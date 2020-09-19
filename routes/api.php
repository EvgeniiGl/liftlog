<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'Api\AuthController@login');
//        Route::post('signup', 'Api\AuthController@signup');
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'Api\AuthController@logout');
    });
});

Route::group(['namespace' => 'Api'], function () {
    Route::group(['middleware' => 'auth:api',
                  'prefix'     => 'devices'],
        function () {
            Route::post('register', 'DeviceController@register');
        });
});
