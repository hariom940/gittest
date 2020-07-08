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

  Route::get('login', 'UserController@index')->name('login');
  Route::post('post-login', 'UserController@postLogin'); 
  Route::get('registration', 'UserController@registration');
  Route::post('post-registration', 'UserController@postRegistration'); 
  Route::get('dashboard', 'UserController@dashboard')->name('dashboard'); 
  Route::get('logout', 'UserController@logout');

Route::get('create','UserController@create_form')->name('create');
Route::post('insert','UserController@insert')->name('insert');
Route::delete('delete/{id}','UserController@destroy')->name('delete');
Route::get('edit/{id}','UserController@edit')->name('edit');
Route::get('view/{id}','UserController@view')->name('view');
Route::get('update/{id}','UserController@update')->name('update');

//====task user route===/
Route::get('user_login','Taskcontroller@index')->name('user_login');
Route::post('user_post-login', 'Taskcontroller@userlogin'); 
Route::get('user_logout', 'Taskcontroller@logout');
Route::post('show{id}', 'Taskcontroller@create')->name('show');