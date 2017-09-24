<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable=[
        'user_id',
        'item_id',
        'module_id',
        'like',
        'module_name'
    ];
    public $with=['user','post','community'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function post(){
        return $this->belongsTo('App\Post');
    }

    public function community(){
        return $this->belongsTo('App\CommunityPost');
    }

}
