<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCommunity extends Model
{
    protected $fillable=[
        'user_id',
        'user_inviter_id',
        'accepted',
        'community_id'
    ];
    public $with=['user','community','sender'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function community()
    {
        return $this->belongsTo('App\Community');
    }
    public function sender()
    {
        return $this->hasOne('App\User','id','user_inviter_id');
    }


}
