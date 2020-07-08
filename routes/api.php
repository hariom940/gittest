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
 