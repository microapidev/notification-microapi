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


// User Routes
// ====================================================
Route::post('user/new', 'UserController@createUser');
Route::post('register/add', 'UserController@registerUser');
Route::get('user/retrieve/{email}/{recovery_password}', 'UserController@getUser');


// Notification Routes
// ==================================================
Route::post('notification/new', 'NotificationController@createNotification');

Route::get('notification/retrieve/{email}', 'NotificationController@getAllNotifications');

Route::put('notification/update/{notification_unique_id}', 'NotificationController@updateNotification');
