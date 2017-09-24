<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable=[
        'user_id',
        'user_sender_id',
        'module_name',
        'module_id',
        'module_item_id'
    ];
    public $with=['sender'];
    public function sender()
    {
        return $this->hasOne('App\User','id','user_sender_id');
    }

}
