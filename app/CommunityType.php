<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityType extends Model
{
    protected $fillable=[
        'name',
        'user_id'
    ];
}
