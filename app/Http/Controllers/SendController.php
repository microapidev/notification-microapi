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
                                    ->json([
                                        "success" => "false",
                                        "message" => "This notification does not have any subscribed users to send message to",
                                        "error" => [
                                            "status_code" => "404",
                                            "message" => "This notification does not have any subscribed users to send message to"
                                        ]
                                    ], 404);
                                    exit(0);
                            } else {

                                $new_subscribed_users = $notification->subscribed_users;

                                for ($i=0; $i < sizeof($new_subscribed_users); $i++) {

                                    // For offline usage.
                                    // Notification::route('mail', $new_subscribed_users[$i])
                                    //             // ->route('nexmo', '5555555555')
                                    //             ->notify(new SendMessage( $notification, $new_subscribed_users[$i] ));

                                    $curl = curl_init();

                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => "https://email.microapi.dev/v1/sendmail/",
                                        CURLOPT_RETURNTRANSFER => true,
                                        CURLOPT_ENCODING => "",
                                        CURLOPT_MAXREDIRS => 10,
                                        CURLOPT_TIMEOUT => 0,
                                        CURLOPT_FOLLOWLOCATION => true,
                                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                        CURLOPT_CUSTOMREQUEST => "POST",
                                        CURLOPT_POSTFIELDS =>"{\r\n    \"recipient\": \"".$new_subscribed_users[$i]."\",\r\n    \"sender\": \"femiadenuga@mazzacash.com\",\r\n    \"subject\": \"".$notification->title."\",\r\n    \"body\": \"".$notification->body."\",\r\n    \"bcc\": \"\",\r\n    \"cc\": \"\"\r\n}",
                                        CURLOPT_HTTPHEADER => array(
                                            "Content-Type: application/json"
                                        ),
                                    ));

                                    $response = curl_exec($curl);

                                    curl_close($curl);
                                }

                                return response()
                                    ->json([
                                        "success" => "true",
                                        "message" => "Notification sent successful"
                                    ], 200);
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

