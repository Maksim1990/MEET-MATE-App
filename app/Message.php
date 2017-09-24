<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable=[
        'user_id',
        'message',
        'photo_id',
        'receiver_id',
        'path'
    ];
    public $with=['user'];
    public function user(){
    return $this->belongsTo('App\User');
}
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
    
    
}
