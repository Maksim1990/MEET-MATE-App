<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    protected $fillable=[
        'requester',
        'user_requested',
        'status'
    ];
    public $with=['user'];
    public function user(){
        return $this->belongsTo('App\User','requester','id');
    }
}
