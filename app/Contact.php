<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable=[
        'user_id',
        'name',
        'lastname',
        'phone',
        'phone2',
        'email',
        'email2',
        'country',
        'city',
        'company',
        'job_position',
        'birthday',
        'photo_id'
    ];
    public $with=['user'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

}
