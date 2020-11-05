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

/**
* Páginas de usuarios
*/

Route::get('/usuarios', 'App\Http\Controllers\UserController@index')
    ->name('users.index');

Route::get('/usuarios/{id}', 'App\Http\Controllers\UserController@show') 
    ->where('id', '[0-9]+')
    ->name('users.show');

Route::put('/usuarios/{id}', 'App\Http\Controllers\UserController@update') 
    ->where('id', '[0-9]+');

Route::get('/usuarios/{id}/borrar', 'App\Http\Controllers\UserController@destroy') 
    ->where('id', '[0-9]+')
    ->name('users.destroy');

Route::get('/usuarios/{id}/editar', 'App\Http\Controllers\UserController@edit') 
    ->where('id', '[0-9]+')
    ->name('users.edit');

Route::get('/usuarios/nuevo', 'App\Http\Controllers\UserController@create')
    ->name('users.create');

Route::post('/usuarios', 'App\Http\Controllers\UserController@store');

/**
* Páginas de empresas
*/

Route::get('/empresas', 'App\Http\Controllers\CompanyController@index')
    ->name('companies.index');

/**
* Búsqueda de usuarios
*/

Route::get('/usuarios/search', 'App\Http\Controllers\UserController@search')
    ->name('users.search');

/**
* Búsqueda de empresas
*/

Route::get('/empresas/search', 'App\Http\Controllers\CompanyController@search')
    ->name('companies.search');

Auth::routes(['register' => false]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home_auth');
