<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable=[
        'user_id',
        'title',
        'description',
        'type_id',
        'category_id',
        'salary',
        'active_till',
        'show_to_friends',
        'photo_id',
        'active'
    ];
    public $with=['user','type','category','image'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function type(){
        return $this->belongsTo('App\CommunityType','type_id','id');
    }
    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function image()
    {
        return $this->hasOne('App\ImageAdvertisement','advertisement_id','id');
    }
}
