<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'user_id',
        'active_left_sidebar',
        'instagram_accaunt'
    ];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
