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
Route::post('user/new', 'UserController@createUser'); // working done by: @eni4sure

Route::get('user/retrieve/{email}/{recovery_password}', 'UserController@getUser'); // working done by: @eni4sure

// Notification Endpoints
// ===================================================
Route::post('notification/new', 'NotificationController@createNotification'); // working done by: @eni4sure

Route::get('notification/retrieve/{user_unique_id}', 'NotificationController@getAllNotifications'); // working done by: @eni4sure

Route::put('notification/update/{notification_unique_id}', 'NotificationController@updateNotification'); // working done by: @eni4sure

// Subscribe Notification Users Endpoints
// =====================================================
Route::post('subscribe/new', 'SubscribeController@subscribeUser'); // working done by: @Teemak

Route::post('unsubscribe/new', 'SubscribeController@unsubscribeUser'); // not yet working

// Send Notification Endpoints
// =====================================================
Route::post('send', 'SendController@sendNotification'); // not yet working
