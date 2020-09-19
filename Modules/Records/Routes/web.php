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

//Route::prefix('/records')->group(function() {
//    Route::get('/', 'RecordsController@index');
//});

//Route::get('{all?}', function(){
//    return view('../../public/js/build/index');
//})->where('all', '([A-z\d-\/_.]+)?');

Route::group(
    [
        'prefix' => 'records',
        'middleware' => ['auth']

    ],
    function () {
        Route::get('/', 'RecordsController@index');
        Route::get('/getRecords/{firstRecord?}', 'RecordsController@getRecords');
        Route::get('/searchRecordsByIdAddress/{id_address}', 'RecordsController@searchRecordsByIdAddress');
        Route::get('/prependRecords/{firstRecord?}', 'RecordsController@prependRecords');
        Route::post('/store', 'RecordsController@store');
        Route::post('/update', 'RecordsController@update');
        Route::post('/sent', 'RecordsController@sent');
        Route::post('/take', 'RecordsController@take');
        Route::post('/set_time_evacuation','RecordsController@setTimeEvacuation');
        Route::post('/set_done','RecordsController@done');
        Route::get('/remove/{id}', 'RecordsController@remove');
//        Route::post('/getRecords', 'RecordsController@getRecords');
//        Route::get('/recommendation', 'EventsController@recommendation');
//        Route::get('/similar/{id_event}', 'EventsController@similar');
//        Route::post('/{id_event}/subscribe', 'EventsController@subscribe');
//        Route::delete('/{id_event}/subscribe', 'EventsController@unsubscribe');
//        Route::get('/{id_event}/members', 'EventsController@members');
    }
);
