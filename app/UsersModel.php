<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'tbl_users';

    protected $fillable = ['user_unique_id'];

    // Old NotificationsMicroAPI code
    // protected $fillable = ['user_unique_id' ,'email', 'recovery_password'];
}
