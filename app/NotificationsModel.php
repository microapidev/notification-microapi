<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationsModel extends Model
{
    protected $table = 'tbl_notifications';

    protected $fillable = ['notification_unique_id', 'title', 'body', 'user_unique_id'];

    // Old NotificationsMicroAPI code
    // protected $fillable = ['notification_unique_id', 'title', 'body', 'icon', 'subscribed_users', 'user_unique_id'];
    // protected $casts = [
    //     'subscribed_users' => 'array'
    // ];
}
