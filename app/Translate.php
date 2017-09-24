<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    protected $fillable=[
        'user_id',
        'input_lang',
        'output_lang',
        'input_word',
        'output_word'
    ];
    public $with=['user'];
    public function user(){
        return $this->belongsTo('App\User');
    }
}
