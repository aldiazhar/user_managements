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

Auth::routes();
// Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

// User Controller
Route::namespace('admin')->prefix('admin')->middleware('can:read')->group(function(){
	Route::get('/', 'adminController@index')->name('admin.index');

	Route::get('/users', 'userController@index')->name('users.index');
	Route::get('/users/create', 'userController@create')->name('users.create');
	Route::match(['GET','POST'],'/users/store', 'userController@store')->name('users.store');
	Route::get('/users/edit/{user}', 'userController@edit');
	Route::match(['GET','POST'], '/users/update/{user}', 'userController@update');
	Route::match(['GET','POST'], '/users/delete/{user}', 'userController@destroy');
});
