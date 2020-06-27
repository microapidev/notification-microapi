<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userReg extends Model
{
    //
    protected $table = 'user';

    protected $fillable = ['email'];
}

