<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPostComment extends Model
{
    protected $fillable=[
        'user_id',
        'post_id',
        'comment',
        'module_id',
        'module_name'
    ];

    public $with=['user'];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
