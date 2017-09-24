<?php

namespace App;
use App\Traits\Friendable;
use Laravel\Scout\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use Friendable;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $with=['photo','profile'];
    protected $fillable = [
        'name', 'email', 'password','role_id','is_active','photo_id','online'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    public function profile(){
        return $this->hasOne('App\Profile');
    }
    public function setting(){
        return $this->hasOne('App\Setting');
    }
    /**
     * @return array
     */

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    public function articles()
    {
        return $this->hasMany('App\Article');
    }
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    public function messages()
    {
        return $this->hasMany('App\Message');
    }
    public function images()
    {
        return $this->hasMany('App\UserImage');
    }
   
    /**
     * @return array
     */
//    public function isAdmin(){
//
//        if(isset($this->role) && $this->role->name=='administrator' && isset($this->is_active) && $this->is_active==1 ){
//            return true;
//        }
//        return false;
//
//
//    }



}
