<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleLike extends Model
{
    protected $fillable=[
        'user_id',
        'article_id'
    ];
    public $with=['user'];
    public function article(){
        return $this->belongsTo('App\Article');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
