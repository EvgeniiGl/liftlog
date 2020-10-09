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

Route::get('/', function () {
    return view('auth.login');
});

//Auth::routes();

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Auth::routes();

Route::group(
    [
        'prefix' => 'statistic',
        'middleware' => ['auth']
    ],
    function () {
        Route::get('/', 'StatisticController@index')->name('statistic');
        Route::get('/filter', 'StatisticController@filter');
    }
);

Route::group(
    [
        'prefix' => 'register'
    ],
    function () {
        Route::get('/menu', 'Auth\RegisterController@menu')->name('register-menu');
    }
);

Route::group(
    [
        'prefix' => 'company'
    ],
    function () {
        Route::get('/registerForm', 'CompanyController@registerForm')->name('company-register-form');
        Route::post('/register', 'CompanyController@register')->name('company-register');
    }
);

Route::group(
    [
        'prefix' => 'service',
        'namespace' => 'service',
        'middleware' => ['auth']
    ],
    function () {
        Route::get('/', 'MainController@index')
            ->name('service_main_index')
            ->middleware('can:isAdmin,App\Models\Type');

        Route::group(
            [
                'prefix' => 'records',
            ],
            function ($router) {
                Route::match(['get', 'post'], '{action}/{id?}',
                    function ($action, $id = []) use ($router) {
                        $app = app();
                        $controller = $app->make('App\Http\Controllers\Service\RecordsController');
                        $parameters = [
                            'request' => $router->getCurrentRequest(),
                            'id' => $id
                        ];
                        return $controller->callAction($action, $parameters);
                    })
                    ->where('params', '.*')
                    ->middleware('can:isAdmin');
            });
    });




