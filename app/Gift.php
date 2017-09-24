<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'user_sender_id',
        'user_receiver_id',
        'gift_text',
        'gift_path',
        'read_already'
    ];
    public $with=['user'];
    public function user()
    {
        return $this->belongsTo('App\User','user_sender_id','id');
    }
    
}
