<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWall extends Model
{
    protected $fillable=[
        'user_post_id',
        'photo_id',
        'text',
        'wall_user_id'
    ];
    public $with=['user','comments','image'];
    public function user(){
        return $this->belongsTo('App\User','user_post_id');
    }
    public function comments(){
        return $this->hasMany('App\WallComment','post_id','id');
    }
    public function image()
    {
        return $this->hasOne('App\ImageUserWall','post_id','id');
    }
}
