<?php

namespace App\Http\Controllers;

use App\User;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class NotificationController extends Controller
{

    // public function getAllNotifications() {
    //     $notifications = Notification::get()->toJson(JSON_PRETTY_PRINT);
    //     return response($notifications, 200);
    // }

    public function createNotification(Request $request) {

        try {

            if ( $request->title != "" && $request->body != "" && $request->icon != "" && $request->user_unique_id != "" ) {

                $notification = new Notification;
                $notification->title = $request->title;
                $notification->body = $request->body;
                $notification->icon = $request->icon;
                $notification->notification_unique_id = Str::random(70);

                if ( User::where('user_unique_id', $request->user_unique_id)->exists() ){

                    $notification->user_unique_id = $request->user_unique_id;

                    if ( $notification->save() ) {

                        return response()
                            ->json([ "success" => "true", "message" => "New Notification Created", "data" => $notification ], 201);
                    } else {

                        return response()
                            ->json([ "success" => "false", "message" => "Internal Server Error. Please try again" ], 500);
                    }
                } else {

                    return response()
                        ->json([ "success" => "false", "message" => "This user_unique_id does not exist" ], 400);
                }
            } else {

                return response()
                    ->json([ "success" => "false", "message" => "Required parameters not given" ], 400);
            }
        } catch (Exception $e) {

            return response()
                ->json([ "success" => "false", "message" => "Internal Server Error" ], 500);
        }
    }

    public function getAllNotifications($user_unique_id) {

        try {

            if ( $user_unique_id != "" ) {

                if ( User::where('user_unique_id', $user_unique_id)->exists() ){

                    $check_available_notifications = Notification::where('user_unique_id', $user_unique_id)->get();

                    if ( count($check_available_notifications) != 0 ) {

                        $notifications = Notification::where('user_unique_id', $user_unique_id)->get();
                    } else {

                        $notifications = "No notification created yet";
                    }

                    return response()
                        ->json([ "success" => "true", "message" => "Notifications Successfully Retrieved", "data" => $notifications ], 200);
                } else {

                    return response()
                        ->json([ "success" => "false", "message" => "This user_unique_id does not exist" ], 404);
                }
            } else {

                return response()
                    ->json([ "success" => "false", "message" => "Required parameter not given" ], 400);
            }
        } catch (Exception $e) {

            return response()
                ->json([ "success" => "false", "message" => "Internal Server Error" ], 500);
        }
    }

    public function updateNotification(Request $request, $notification_unique_id) {

        try {

            if ( $notification_unique_id != "" && $request->user_unique_id != "" ) {

                if ( User::where('user_unique_id', $request->user_unique_id)->exists() ){

                    if ( $request->title != "" || $request->body != "" || $request->icon != "" ) {

                        if ( Notification::where('notification_unique_id', $notification_unique_id)->exists() ) {

                            $notification = Notification::where('notification_unique_id', $notification_unique_id)->first();

                            if ( $request->user_unique_id == $notification->user_unique_id ) {

                                $notification->title = is_null($request->title) ? $notification->title : $request->title;
                                $notification->body = is_null($request->body) ? $notification->body : $request->body;
                                $notification->icon = is_null($request->icon) ? $notification->icon : $request->icon;

                                $notification->save();

                                return response()
                                    ->json([ "success" => "true", "message" => "Notification updated successfully", "data" => $notification ], 200);
                            } else {

                                return response()
                                    ->json([ "success" => "false", "message" => "This is not yours 😏" ], 400);
                            }
                        } else {

                            return response()
                                ->json([ "success" => "false", "message" => "Notification not found" ], 404);
                        }
                    } else {

                        return response()
                            ->json([ "success" => "false", "message" => "No parameter to update given" ], 400);
                    }
                } else {

                    return response()
                        ->json([ "success" => "false", "message" => "user_unique_id not found" ], 404);
                }
            } else {

                return response()
                    ->json([ "success" => "false", "message" => "Required parameter not given" ], 400);
            }
        } catch (Exception $e) {

            return response()
                ->json([ "success" => "false", "message" => "Internal Server Error" ], 500);
        }
    }

    // Not needed
    // public function deleteNotification ($id) {
    //     // logic to delete a Notification record goes here

    //     if (Notification::where('id', $id)->exists()) {

    //     $notification = Notification::find($id);

    //     $notification->delete();

    //     return response()->json([
    //         "message" => "Notification record deleted"
    //     ], 202);

    //     } else {
    //     return response()->json([
    //         "message" => "Notification not found"
    //     ], 404);
    //     }

    // }

}
