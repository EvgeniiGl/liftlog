<?php

//Route::group(['namespace' => 'API'], function () {
//
//    Route::group(
//        [
//            'prefix' => 'users'
//        ],
//        function () {
//            Route::get('/{id_user}', 'UsersController@getUser');
////            Route::get('/', 'UsersController@getUsers');
//        }
//    );
//});


Route::group(['namespace' => 'Api'], function () {
    Route::group(['middleware' => 'auth:api',
                  'prefix'     => 'users'], function () {
        Route::get('getuser', 'UsersController@getUser');
    });
});
