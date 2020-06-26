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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('notifications', 'NotificationController@getAllNotifications');
Route::get('notifications/{id}', 'NotificationController@getNotification');
Route::post('notifications', 'NotificationController@createNotification');
Route::put('notifications/{id}', 'NotificationController@updateNotification');
Route::delete('notifications/{id}','NotificationController@deleteNotification');
