<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable=[
        'user_id',
        'status',
        'country',
        'city',
        'lastname',
        'user_gender'
    ];



    public function user(){
        return $this->belongsTo('App\User');
    }
}
