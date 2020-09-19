<?php


Route::group(
    [
        'prefix' => 'address',
        'middleware' => ['auth']
    ],
    function () {
        Route::post('/loadAddress', 'AddressController@loadAddress');
//        Route::get('/recommendation', 'EventsController@recommendation');
//        Route::get('/similar/{id_event}', 'EventsController@similar');
//        Route::post('/{id_event}/subscribe', 'EventsController@subscribe');
//        Route::delete('/{id_event}/subscribe', 'EventsController@unsubscribe');
//        Route::get('/{id_event}/members', 'EventsController@members');
    }
);