<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageCommunityPost extends Model
{
    protected $fillable=[
        'user_id',
        'photo_id',
        'community_id',
        'post_id'
    ];
    public $with=['photo'];
    public function photo(){
        return $this->belongsTo('App\Photo');
    }
}
