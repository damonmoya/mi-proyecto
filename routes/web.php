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

/**
* Home Page
*/

Route::get('/', 'App\Http\Controllers\Controller@home')
    ->name('home');

Route::middleware('auth')->group(function () {  

    Route::prefix('usuarios')->group(function () {

        Route::name('users.')->group(function () {

            Route::get('', function () {
                return view('users.index')
                ->with('title', 'Listado de usuarios'); 
            })->name('index');

            Route::resource('recursos', 'App\Http\Controllers\UserController', ['except' => 'show', 'create', 'edit'])
                ->name('resources');
                
            Route::get('{id}', 'App\Http\Controllers\UserController@show') 
                ->where('id', '[0-9]+')
                ->name('show');

            Route::get('search', 'App\Http\Controllers\UserController@search')
                ->name('search');

            Route::get('send_email', 'App\Http\Controllers\UserController@send_email')
                ->name('send_email');

            //Route::group(['middleware' => ['role:Administrador']], function () {

                //Route::get('{id}/editar', 'App\Http\Controllers\UserController@edit') 
                //    ->where('id', '[0-9]+')
                //    ->name('edit');

                //Route::get('nuevo', 'App\Http\Controllers\UserController@create')
                //    ->name('create');

                //Route::post('', 'App\Http\Controllers\UserController@store')
                //    ->name('store');

                //Route::put('{id}', 'App\Http\Controllers\UserController@update') 
                //    ->where('id', '[0-9]+')
                //    ->name('update');

            //});

        });
    });

    Route::prefix('empresas')->group(function () {

        Route::name('companies.')->group(function () {

            Route::get('', function () {
                return view('companies.index')
                ->with('title', 'Listado de empresas'); 
            })->name('index');

            Route::resource('recursos', 'App\Http\Controllers\CompanyController', ['except' => 'show', 'create', 'edit'])
                ->name('resources');

            Route::get('{id}', 'App\Http\Controllers\CompanyController@show') 
                ->where('id', '[0-9]+')
                ->name('show');

            Route::get('search', 'App\Http\Controllers\CompanyController@search')
                ->name('search');

            Route::get('dependents', 'App\Http\Controllers\CompanyController@dependents')
                ->name('dependents');

            Route::get('send_email', 'App\Http\Controllers\CompanyController@send_email')
                ->name('send_email');

            //Route::group(['middleware' => ['role:Administrador']], function () {

            //    Route::get('nuevo', 'App\Http\Controllers\CompanyController@create')
            //        ->name('create');
            //    
            //    Route::post('', 'App\Http\Controllers\CompanyController@store')
            //        ->name('store');

            //    Route::get('{id}/editar', 'App\Http\Controllers\CompanyController@edit') 
            //        ->where('id', '[0-9]+')
            //        ->name('edit');

            //    Route::put('{id}', 'App\Http\Controllers\CompanyController@update') 
            //        ->where('id', '[0-9]+')
            //        ->name('update');

            //});

        });
    
    });

    Route::prefix('departamentos')->group(function () {

        Route::name('departments.')->group(function () {

            Route::get('', function () {
                return view('departments.index')
                ->with('title', 'Listado de departamentos'); 
            })->name('index');

            Route::resource('recursos', 'App\Http\Controllers\DepartmentController', ['except' => 'show', 'create', 'edit'])
                ->name('resources');

            Route::get('{id}', 'App\Http\Controllers\DepartmentController@show') 
                ->where('id', '[0-9]+')
                ->name('show');

            Route::get('search', 'App\Http\Controllers\DepartmentController@search')
                ->name('search');

            Route::get('send_email', 'App\Http\Controllers\DepartmentController@send_email')
                ->name('send_email');

            //Route::group(['middleware' => ['role:Administrador']], function () {
//
            //    Route::get('nuevo', 'App\Http\Controllers\DepartmentController@create')
            //        ->name('create');
            //    
            //    Route::post('', 'App\Http\Controllers\DepartmentController@store')
            //        ->name('store');
//
            //    Route::get('{id}/borrar', 'App\Http\Controllers\DepartmentController@destroy') 
            //        ->where('id', '[0-9]+')
            //        ->name('destroy');
//
            //    Route::get('{id}/editar', 'App\Http\Controllers\DepartmentController@edit') 
            //        ->where('id', '[0-9]+')
            //        ->name('edit');
//
            //    Route::put('{id}', 'App\Http\Controllers\DepartmentController@update') 
            //        ->where('id', '[0-9]+')
            //        ->name('update');
//
            //});

        });
    
    });

    Route::prefix('profesiones')->group(function () {

        Route::name('professions.')->group(function () {

            Route::get('', function () {
                return view('professions.index')
                ->with('title', 'Listado de profesiones'); 
            })->name('index');

            Route::resource('recursos', 'App\Http\Controllers\ProfessionController', ['except' => 'show', 'create', 'edit'])
                ->name('resources');

            Route::get('{id}', 'App\Http\Controllers\ProfessionController@show') 
                ->where('id', '[0-9]+')
                ->name('show');

            Route::get('search', 'App\Http\Controllers\ProfessionController@search')
                ->name('search');

        });
    
    });
    
});

Route::prefix('admin')->group(function () {

    Route::name('admin.')->group(function () {

        Route::group(['middleware' => ['role:Administrador']], function () {

            Route::get('', function () {
                return view('admin.index')
                ->with('title', 'Panel de Administración'); 
            })->name('index');

            //Route::get('search', 'App\Http\Controllers\DepartmentController@search')
            //    ->name('search');

            //Route::get('{id}/borrar', 'App\Http\Controllers\DepartmentController@destroy') 
            //    ->where('id', '[0-9]+')
            //    ->name('destroy');

            //Route::put('{id}', 'App\Http\Controllers\DepartmentController@update') 
            //    ->where('id', '[0-9]+')
            //    ->name('update');

        });

    });

});

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home_auth');
