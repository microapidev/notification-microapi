<?php

namespace App\Http\Controllers;
use App\User;
use App\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SubscribeController extends Controller
{
    public function subscribeUser(Request $request)
    {
        try {

            if ( $request->user_unique_id != "" && $request->notification_unique_id != "" && $request->email != "" ) {

                if ( User::where('user_unique_id', $request->user_unique_id)->exists() ) {

                    if ( NotificationModel::where('notification_unique_id', $request->notification_unique_id)->exists() ) {

                        $notification = NotificationModel::where('notification_unique_id', $request->notification_unique_id)->first();

                        if ( $request->user_unique_id == $notification->user_unique_id ) {

                            $new_subscribed_users = array();

                            if ( $notification->subscribed_users == "" || $notification->subscribed_users == null ) {

                                $new_subscribed_users[] = $request->email;
                            } else {

                                $new_subscribed_users = $notification->subscribed_users;

                                // Linear Search
                                for ( $i=0; $i < sizeof($new_subscribed_users); $i++ ) {
                                    if ($new_subscribed_users[$i] == $request->email) {
                                        return response()
                                            ->json([
                                                "success" => "false",
                                                "message" => "This Email is already subscribed to this notification",
                                                "error" => [
                                                    "status_code" => "400",
                                                    "message" => "This Email is already subscribed to this notification"
                                                ]
                                            ], 400);
                                        exit(0);
                                    }
                                }

                                array_push($new_subscribed_users, $request->email);
                            }

                            $notification->subscribed_users = $new_subscribed_users;

                            $notification->save();

                            return response()
                                ->json([
                                    "success" => "true",
                                    "message" => "Email subscribed to this notification successful",
                                    "data" => $notification
                                ], 200);
                        } else {
                            return response()
                                ->json([
                                    "success" => "false",
                                    "message" => "This is not yours 😏",
                                    "error" => [
                                        "status_code" => "400",
                                        "message" => "This is not yours 😏"
                                    ]
                                ], 400);
                        }
                    } else {
                        return response()
                            ->json([
                                "success" => "false",
                                "message" => "Notification not found",
                                "error" => [
                                    "status_code" => "404",
                                    "message" => "Notification not found"
                                ]
                            ], 404);
                    }
                } else {
                    return response()
                        ->json([
                            "success" => "false",
                            "message" => "user_unique_id not found",
                            "error" => [
                                "status_code" => "404",
                                "message" => "user_unique_id not found"
                            ]
                        ], 404);
                }
            } else {
                return response()
                    ->json([
                        "success" => "false",
                        "message" => "Required parameter not given",
                        "error" => [
                            "status_code" => "400",
                            "message" => "Required parameter not given"
                        ]
                    ], 400);
            }
        } catch (Exception $e) {
            return response()
                ->json([
                    "success" => "false",
                    "message" => "Internal Server Error",
                    "error" => [
                        "status_code" => "500",
                        "message" => "Internal Server Error"
                    ]
                ], 500);
        }
    }

    public function unsubscribeUser(Request $request)
    {
        try {

            if ( $request->user_unique_id != "" && $request->notification_unique_id != "" && $request->email != "" ) {

                if ( User::where('user_unique_id', $request->user_unique_id)->exists() ) {

                    if ( NotificationModel::where('notification_unique_id', $request->notification_unique_id)->exists() ) {

                        $notification = NotificationModel::where('notification_unique_id', $request->notification_unique_id)->first();

                        if ( $request->user_unique_id == $notification->user_unique_id ) {

                            $new_subscribed_users = array();

                            if ( $notification->subscribed_users == "" || $notification->subscribed_users == null ) {

                                return response()
                                    ->json([
                                        "success" => "false",
                                        "message" => "This notification does not have any subscribed users",
                                        "error" => [
                                            "status_code" => "404",
                                            "message" => "This notification does not have any subscribed users"
                                        ]
                                    ], 404);
                                    exit(0);
                            } else {

                                $new_subscribed_users = $notification->subscribed_users;

                                // Linear Search
                                for ( $i=0; $i < sizeof($new_subscribed_users); $i++ ) {
                                    if ($new_subscribed_users[$i] == $request->email) {

                                        unset($new_subscribed_users[$i]);

                                        sort($new_subscribed_users);

                                        if ( count($notification->subscribed_users) == 0 ) {

                                            $notification->subscribed_users = NULL;
                                        } else {

                                            $notification->subscribed_users = $new_subscribed_users;
                                        }

                                        $notification->save();

                                        return response()
                                            ->json([
                                                "success" => "true",
                                                "message" => "Email unsubscribed from this notification successful",
                                                "data" => $notification
                                            ], 200);
                                        exit(0);
                                    }
                                }

                                return response()
                                    ->json([
                                        "success" => "false",
                                        "message" => "This email was not found in the subscribed users",
                                        "error" => [
                                            "status_code" => "404",
                                            "message" => "This email was not found in the subscribed users"
                                        ]
                                    ], 404);
                            }
                        } else {
                            return response()
                                ->json([
                                    "success" => "false",
                                    "message" => "This is not yours 😏",
                                    "error" => [
                                        "status_code" => "400",
                                        "message" => "This is not yours 😏"
                                    ]
                                ], 400);
                        }
                    } else {
                        return response()
                            ->json([
                                "success" => "false",
                                "message" => "Notification not found",
                                "error" => [
                                    "status_code" => "404",
                                    "message" => "Notification not found"
                                ]
                            ], 404);
                    }
                } else {
                    return response()
                        ->json([
                            "success" => "false",
                            "message" => "user_unique_id not found",
                            "error" => [
                                "status_code" => "404",
                                "message" => "user_unique_id not found"
                            ]
                        ], 404);
                }
            } else {
                return response()
                    ->json([
                        "success" => "false",
                        "message" => "Required parameter not given",
                        "error" => [
                            "status_code" => "400",
                            "message" => "Required parameter not given"
                        ]
                    ], 400);
            }
        } catch (Exception $e) {
            return response()
                ->json([
                    "success" => "false",
                    "message" => "Internal Server Error",
                    "error" => [
                        "status_code" => "500",
                        "message" => "Internal Server Error"
                    ]
                ], 500);
        }
    }
}
