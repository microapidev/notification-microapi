<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMessage extends Notification implements ShouldQueue
{
    use Queueable;

    // Making the notification usable everywhere
    public $notification_details;
    public $currrent_email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( $notification_details, $currrent_email)
    {
        // Catching the notification details
        $this->notification_details = $notification_details;

        // Who's been sent this email now
        $this->currrent_email = $currrent_email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    // ->from('notification-microapi@example.com', 'MicroDev Notification')
                    ->subject( $this->notification_details->title )
                    ->greeting('Hello '. $this->currrent_email .',' )
                    ->line( 'You have a new notification:' )
                    ->line( '<b>'.$this->notification_details->body.'</b>' )
                    ->line('Thank you for using Notification @ MicroAPI.dev');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
