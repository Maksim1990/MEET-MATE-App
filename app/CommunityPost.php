<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $fillable=[
        'user_id',
        'photo_id',
        'text',
        'community_id'
    ];
    public $with=['user','comments','image'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function comments(){
        return $this->hasMany('App\Comment','post_id','id');
    }
    public function image()
    {
        return $this->hasOne('App\ImageCommunityPost','post_id','id');
    }
}
