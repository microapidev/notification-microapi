<?php

namespace App\Http\Controllers;

use App\User;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SendController extends Controller
{

    public function sendNotification(Request $request){
        // Write your code here for this endpoint
        
        // send email to subscribers
        
        $subscribers = Subscriber::all(); //Retrieving all subscribers
 
        foreach($subscribers as $subscriber){
            Notification::route('mail' , $subscriber->email) //Sending mail to subscriber
                          ->notify(new NewPostNotify($posts)); //With new post
 
        return redirect()->back();
      }
    }
}
