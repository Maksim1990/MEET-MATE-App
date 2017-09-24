<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageJob extends Model
{
    protected $fillable=[
        'job_id',
        'photo_id'
    ];
    public $with=['photo'];
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
}
