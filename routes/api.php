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

// User Endpoints
// ====================================================
Route::post('user/create', 'UsersController@createUser'); // works well and done by: @eni4sure

// Notification Endpoints
// ===================================================
Route::post('notification/new', 'NotificationsController@createNotification'); // works well and done by: @eni4sure

Route::get('notification/get/{user_unique_id}', 'NotificationsController@getAllNotifications'); // works well and done by: @eni4sure

Route::put('notification/update/{notification_unique_id}', 'NotificationsController@updateNotification'); // works well and done by: @eni4sure

Route::delete('notification/delete/{notification_unique_id}', 'NotificationsController@deleteNotification'); // works well and done by: @eni4sure
