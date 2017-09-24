<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable=[

        'user_id',
        'content'
    ];
    public $with=['user','likes'];
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function likes(){
        return $this->hasMany('App\ArticleLike');
    }
}
