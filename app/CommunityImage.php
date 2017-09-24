<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityImage extends Model
{
    protected $fillable=[
        'user_id',
        'photo_id',
        'community_id'
    ];
}
