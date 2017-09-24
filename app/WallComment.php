<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WallComment extends Model
{
    protected $fillable=[
        'user_id',
        'wall_user_id',
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
