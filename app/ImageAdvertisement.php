<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageAdvertisement extends Model
{
    protected $fillable=[
        'advertisement_id',
        'photo_id'
    ];
    public $with=['photo'];
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
}
