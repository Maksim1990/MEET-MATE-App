<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    protected $fillable=[
        'user_id',
        'advertisement_id',
        'title',
        'company_name',
        'type_id',
        'category_id',
        'description',
        'salary',
        'active_till',
        'show_to_friends',
        'active',
        'photo_id',
        'country',
        'city'
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
    public function advertisement(){
        return $this->belongsTo('App\Advertisement');
    }
    public function image()
    {
        return $this->hasOne('App\ImageJob','job_id','id');
    }
}
