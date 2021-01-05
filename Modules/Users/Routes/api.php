<?php
namespace  Modules\Users\Routes;
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

use Illuminate\Support\Facades\Route;

class api extends Route{

}

api::group(['namespace' => 'Api'], function () {
    api::group(['middleware' => 'auth:api',
                  'prefix'     => 'users'], function () {
        api::get('getuser', 'UsersController@getUser');
    });
});
