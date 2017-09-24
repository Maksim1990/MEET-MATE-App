<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageUserWall extends Model
{
    protected $fillable=[
        'user_id',
        'photo_id',
        'user_wall_id',
        'post_id'
    ];
    public $with=['photo'];
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
}
