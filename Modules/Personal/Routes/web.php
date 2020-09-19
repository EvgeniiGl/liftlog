<?php

Route::group(
    [
        'prefix' => 'personal',
        'middleware' => ['auth']

    ],
    function () {
        Route::get('/', 'PersonalController@index');
        Route::get('/getUserRecords', 'PersonalController@getUserRecords');
    }
);