<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', 'App\Http\Controllers\Auth\LoginController@loginForm')
        ->name('auth.login.form');
    Route::post('/auth/login', 'App\Http\Controllers\Auth\LoginController@login')
        ->name('auth.login');
    Route::get('/auth/register', 'App\Http\Controllers\Auth\RegisterController@registerForm')
        ->name('auth.register.form');
    Route::post('/auth/register', 'App\Http\Controllers\Auth\RegisterController@register')
        ->name('auth.register');
});

Route::group(['prefix' => 'panel', 'middleware' => 'role:admin'], function () {
    Route::get('users', 'App\Http\Controllers\UserController@index')->name('users.index');
    Route::get('users/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('users.edit');
    Route::post('users/{id}/update', 'App\Http\Controllers\UserController@update')->name('users.update');
    Route::get('roles', 'App\Http\Controllers\RoleController@index')->name('roles.index');
    Route::post('roles', 'App\Http\Controllers\RoleController@store')->name('roles.store');
    Route::get('roles/{id}/edit', 'App\Http\Controllers\RoleController@edit')->name('roles.edit');
    Route::post('roles/{id}/update', 'App\Http\Controllers\RoleController@update')->name('roles.update');

});
