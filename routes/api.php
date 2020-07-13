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



Route::middleware('auth:api')->get('/user', function (Request $request) {

   return $request->user();

});

Route::post('login', 'ApisController@login');
Route::post('register', 'ApisController@register');


Route::group(['middleware' => 'auth:api'], function(){
Route::post('get-details', 'ApisController@getDetails'); 
});

 // password_confirmation


/* Route::group([
   'prefix' => 'auth'
], function () {
   Route::post('login', 'AuthController@login');
   Route::post('signup', 'AuthController@signup');
 
   Route::group([
     'middleware' => 'auth:api'
   ], function() {
       Route::get('logout', 'AuthController@logout');
       Route::get('user', 'AuthController@user');
   });
}); */