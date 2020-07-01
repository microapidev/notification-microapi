<?php

namespace App\Http\Controllers;

use App\User;
use App\NotificationModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Notification;
use App\Notifications\SendMessage;

class SendController extends Controller
{

    public function sendNotification(Request $request){

        try {

            if ( $request->user_unique_id != "" && $request->notification_unique_id != "" ) {

                if ( User::where('user_unique_id', $request->user_unique_id)->exists() ) {

                    if ( NotificationModel::where('notification_unique_id', $request->notification_unique_id)->exists() ) {

                        $notification = NotificationModel::where('notification_unique_id', $request->notification_unique_id)->first();

                        if ( $request->user_unique_id == $notification->user_unique_id ) {

                            if ( $notification->subscribed_users == "" || $notification->subscribed_users == null ) {

                                return response()
                                    ->json([ "success" => "false", "message" => "This notification does not have any subscribed users to send message to" ], 404);
                                    exit(0);
                            } else {

                                $new_subscribed_users = $notification->subscribed_users;

                                for ($i=0; $i < sizeof($new_subscribed_users); $i++) {

                                    Notification::route('mail', $new_subscribed_users[$i])
                                                // ->route('nexmo', '5555555555')
                                                ->notify(new SendMessage());
                                }

                                return response()
                                    ->json([ "success" => "true", "message" => "Notification sent successful" ], 200);
                            }
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
}
