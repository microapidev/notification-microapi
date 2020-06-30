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

class NewPostNotify extends Notification
{
    use Queueable;
 
    public $post;
 
    public function __construct($post)
    {
       $this->post = $post; //Catching New Post
    }
 
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Hi user, New post availabe')
                    ->greeting('Hello' , 'Subscriber')
                    ->line('There is a new post , trust you will like it')
                    ->line('Post title : '.$this->post->title) //Send with post title
                    ->action('Read Post' , url(route('post' , $this->post->slug))) //Send with post url
                    ->line('Thank you for being there!');
    }
 
}