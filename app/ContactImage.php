<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactImage extends Model
{
    protected $fillable=[
        'user_id',
        'photo_id',
        'contact_id'
    ];
}
