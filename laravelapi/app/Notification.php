<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'tbl_notifications';

    protected $fillable = ['notification_unique_id', 'title', 'body', 'icon', 'subscribed_users', 'user_unique_id'];
}
