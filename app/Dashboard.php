<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $fillable=[
        'date_time',
        'user_id',
        'birthday_your',
        'birthday_friend',
        'comments',
        'posts'
    ];
}
