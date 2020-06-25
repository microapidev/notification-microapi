<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


    public function getAllNotifications() {
        $notifications = Notification::get()->toJson(JSON_PRETTY_PRINT);
        return response($notifications, 200);
    }

    public function createNotification(Request $request) {

        $notification = new Notification;
        $notification->title = $request->title;
        $notification->body = $request->body;
        $notification->icon = $request->icon;

        $notification->save();

        return response()->json([
            "message" => "Notification record created"
        ], 201);

    }

    public function getNotification($id) {
    // logic to get a Notification record goes here
    }

    public function updateNotification(Request $request, $id) {
    // logic to update a Notification record goes here
    }

    public function deleteNotification ($id) {
    // logic to delete a Notification record goes here
    }


}
