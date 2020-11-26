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

            Route::resource('recursos', 'App\Http\Controllers\UserController', ['except' => 'show', 'create', 'edit']);
                
            Route::get('{id}', 'App\Http\Controllers\UserController@show') 
                ->where('id', '[0-9]+')
                ->name('show');

            Route::get('/usuarios/search', 'App\Http\Controllers\UserController@search')
                ->name('search');

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

            Route::get('', 'App\Http\Controllers\CompanyController@index')
                ->name('index');

            Route::get('{id}', 'App\Http\Controllers\CompanyController@show') 
                ->where('id', '[0-9]+')
                ->name('show');

            Route::get('search', 'App\Http\Controllers\CompanyController@search')
                ->name('search');

            Route::group(['middleware' => ['role:Administrador']], function () {

                Route::get('nuevo', 'App\Http\Controllers\CompanyController@create')
                    ->name('create');
                
                Route::post('', 'App\Http\Controllers\CompanyController@store')
                    ->name('store');

                Route::get('{id}/borrar', 'App\Http\Controllers\CompanyController@destroy') 
                    ->where('id', '[0-9]+')
                    ->name('destroy');

                Route::get('{id}/editar', 'App\Http\Controllers\CompanyController@edit') 
                    ->where('id', '[0-9]+')
                    ->name('edit');

                Route::put('{id}', 'App\Http\Controllers\CompanyController@update') 
                    ->where('id', '[0-9]+')
                    ->name('update');

            });

        });
    
    });

    Route::prefix('departamentos')->group(function () {

        Route::name('departments.')->group(function () {

            Route::get('', 'App\Http\Controllers\DepartmentController@index')
                ->name('index');

            Route::get('{id}', 'App\Http\Controllers\DepartmentController@show') 
                ->where('id', '[0-9]+')
                ->name('show');

            Route::get('search', 'App\Http\Controllers\DepartmentController@search')
                ->name('search');

            Route::group(['middleware' => ['role:Administrador']], function () {

                Route::get('nuevo', 'App\Http\Controllers\DepartmentController@create')
                    ->name('create');
                
                Route::post('', 'App\Http\Controllers\DepartmentController@store')
                    ->name('store');

                Route::get('{id}/borrar', 'App\Http\Controllers\DepartmentController@destroy') 
                    ->where('id', '[0-9]+')
                    ->name('destroy');

                Route::get('{id}/editar', 'App\Http\Controllers\DepartmentController@edit') 
                    ->where('id', '[0-9]+')
                    ->name('edit');

                Route::put('{id}', 'App\Http\Controllers\DepartmentController@update') 
                    ->where('id', '[0-9]+')
                    ->name('update');

            });

        });
    
    });
    
});

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home_auth');
