<?php

namespace App\Http\Controllers;

use App\UsersModel;
use App\NotificationsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class NotificationsController extends Controller
{

    public function createNotification(Request $request) {

        try {

            if ( $request->title != "" && $request->body != "" && $request->user_unique_id != "" ) {

                $notification = new NotificationsModel;
                $notification->title = $request->title;
                $notification->body = $request->body;
                $notification->notification_unique_id = Str::random(50);

                if ( UsersModel::where('user_unique_id', $request->user_unique_id)->exists() ){

                    $notification->user_unique_id = $request->user_unique_id;

                    if ( $notification->save() ) {

                        return response()
                            ->json([
                                "success" => "true",
                                "message" => "New Notification Created",
                                "data" => $notification
                            ], 201);
                    } else {

                        return response()
                            ->json([
                                "success" => "false",
                                "message" => "Internal Server Error. Please try again",
                                "error" => [
                                    "status_code" => "500",
                                    "message" => "Internal Server Error. Please try again"
                                ]
                            ], 500);
                    }
                } else {

                    return response()
                        ->json([
                            "success" => "false",
                            "message" => "This user_unique_id does not exist",
                            "error" => [
                                "status_code" => "400",
                                "message" => "This user_unique_id does not exist"
                            ]
                        ], 400);
                }
            } else {

                return response()
                    ->json([
                        "success" => "false",
                        "message" => "Required parameters not given",
                        "error" => [
                            "status_code" => "400",
                            "message" => "Required parameters not given"
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

    public function getAllNotifications($user_unique_id) {

        try {

            if ( $user_unique_id != "" ) {

                if ( UsersModel::where('user_unique_id', $user_unique_id)->exists() ){

                    $check_available_notifications = NotificationsModel::where('user_unique_id', $user_unique_id)->get();

                    if ( count($check_available_notifications) != 0 ) {

                        $notifications = NotificationsModel::where('user_unique_id', $user_unique_id)->get();
                    } else {

                        $notifications = [
                            "message" => "No notification created yet"
                        ];
                    }

                    return response()
                        ->json([
                            "success" => "true",
                            "message" => "Notifications Successfully Retrieved",
                            "data" => $notifications
                        ], 200);
                } else {

                    return response()
                        ->json([
                            "success" => "false",
                            "message" => "This user_unique_id does not exist",
                            "error" => [
                                "status_code" => "404",
                                "message" => "This user_unique_id does not exist"
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

    public function updateNotification(Request $request, $notification_unique_id) {

        try {

            if ( $notification_unique_id != "" && $request->user_unique_id != "" ) {

                if ( UsersModel::where('user_unique_id', $request->user_unique_id)->exists() ){

                    if ( $request->title != "" || $request->body != "" ) {

                        if ( NotificationsModel::where('notification_unique_id', $notification_unique_id)->exists() ) {

                            $notification = NotificationsModel::where('notification_unique_id', $notification_unique_id)->first();

                            if ( $request->user_unique_id == $notification->user_unique_id ) {

                                $notification->title = is_null($request->title) ? $notification->title : $request->title;
                                $notification->body = is_null($request->body) ? $notification->body : $request->body;

                                $notification->save();

                                return response()
                                    ->json([
                                        "success" => "true",
                                        "message" => "Notification updated successfully",
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
                                "message" => "No parameter to update given",
                                "error" => [
                                    "status_code" => "400",
                                    "message" => "No parameter to update given"
                                ]
                            ], 400);
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

    public function deleteNotification(Request $request, $notification_unique_id) {
        try {

            if ( $notification_unique_id != "" && $request->user_unique_id != "" ) {

                if ( UsersModel::where('user_unique_id', $request->user_unique_id)->exists() ){

                    if ( NotificationsModel::where('notification_unique_id', $notification_unique_id)->exists() ) {

                        $notification = NotificationsModel::where('notification_unique_id', $notification_unique_id)->first();

                        if ( $request->user_unique_id == $notification->user_unique_id ) {

                            $notification->delete();

                            return response()
                                ->json([
                                    "success" => "true",
                                    "message" => "Notification deleted successfully",
                                    "data" => $notification
                                ], 202);
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
