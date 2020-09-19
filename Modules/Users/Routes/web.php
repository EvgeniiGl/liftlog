<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::prefix('users')->group(function() {
//    Route::get('/', 'UsersController@index')->name('users');
//    Route::post('/destroy/{id}', 'UsersController@destroy');
//    Route::post('/access', 'UsersController@access');
//});

//Route::prefix('users')->group(function() {
//    Route::post('/register', 'UsersController@register')->name('register');
//});

Route::group(
    [
        'prefix'     => 'users',
        'middleware' => ['auth',
                         'user.admin']
    ],
    function () {
        Route::get('/', 'UsersController@index')->name('users');
        Route::post('/destroy/{id}', 'UsersController@destroy');
        Route::post('/access', 'UsersController@access');
        Route::post('/address', 'UsersController@address');
        Route::post('/create', 'UsersController@create')->name('users.create');
        Route::get('/token', 'UsersController@token');
        Route::post('/set_notificate/{userId}', 'UsersController@setNotificate');
    }
);
