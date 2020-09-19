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


Route::group(['namespace' => 'Api'], function () {
    Route::group([
        'middleware' => 'auth:api',
        'prefix'     => 'records'
    ],
        function () {
            Route::get('getUserAppointedRecords', 'RecordsController@getUserAppointedRecords');
            Route::get('getUserCompletedRecords', 'RecordsController@getUserCompletedRecords');
            Route::post('take', 'RecordsController@take');
            Route::post('done', 'RecordsController@done');
        });
});
