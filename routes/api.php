<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::prefix('v1')->group(function(){
    /*Without auth*/
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');

    /*With auth*/
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('getuser', 'Api\AuthController@getUser');
        Route::post('user/updateprofile', 'Api\AuthController@updateProfile');
        Route::post('event/store', 'Api\EventController@store');
        Route::get('event/getall', 'Api\EventController@getAll');
        Route::get('user/getall', 'Api\AuthController@getAll');
        Route::get('event/{id}/messages', 'ChatController@fetchMessages');
        Route::post('event/{id}/messages', 'ChatController@sendMessage');
    });
   });