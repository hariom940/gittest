<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/allList', 'ApisController@getAllList'); 
Route::get('getTaskInfo/{id}','ApisController@getTaskInfo');
Route::post('addTask','ApisController@addTask');

 Route::post('delete','ApisController@delete');
Route::post('update/{id}','ApisController@update');
Route::post('login', 'ApisController@login');

Route::any('register', 'ApisController@register');

Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'ApisController@details');
});