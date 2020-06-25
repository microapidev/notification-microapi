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

        if (Notification::where('id', $id)->exists()) {

            $notification = Notification::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($notification, 200);

        } else {
            return response()->json([
                "message" => "Notification not found"
            ], 404);
        }

    }

    public function updateNotification(Request $request, $id) {

        // logic to update a Notification record goes here
        if (Notification::where('id', $id)->exists()) {

            $notification = Notification::find($id);

            $notification->title = is_null($request->title) ? $notification->title : $request->title;
            $notification->body = is_null($request->body) ? $notification->body : $request->body;
            $notification->icon = is_null($request->icon) ? $notification->icon : $request->icon;

            $notification->save();

            return response()->json([
                "message" => "Notification records updated successfully"
            ], 200);

        } else {
            return response()->json([
                "message" => "Notification not found"
            ], 404);
        }

    }

    public function deleteNotification ($id) {
        // logic to delete a Notification record goes here

        if (Notification::where('id', $id)->exists()) {

        $notification = Notification::find($id);

        $notification->delete();

        return response()->json([
            "message" => "Notification record deleted"
        ], 202);

        } else {
        return response()->json([
            "message" => "Notification not found"
        ], 404);
        }

    }


}
