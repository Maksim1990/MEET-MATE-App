<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $fillable=[
        'type_id',
        'type',
        'category',
        'category_id',
        'name',
        'user_id',
        'photo_id',
        'description'
    ];
    public $with=['category','type','user','photo'];
    public function category(){
        return $this->hasOne('App\Category','id','category_id');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function photo(){
        return $this->belongsTo('App\Photo');
    }
    
    public function type(){
        return $this->hasOne('App\CommunityType','id','type_id');
    }
    public function users(){
        return $this->hasMany('App\UserCommunity');
    }
   

    
}
