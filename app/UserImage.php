<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    protected $fillable=[
        'user_id',
        'photo_id'
    ];
    public $with=['photo'];
    public function photo(){
        return $this->belongsTo('App\Photo');
    }

}
