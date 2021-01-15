<?php

namespace App\Model\admin;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class admin extends Authenticatable
{
    //
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone','image','about','status','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany('App\Model\user\post')->where(['status'=>1,'language'=> session('locale')]);
    }
    public function roles()
    {
        return $this->belongsToMany('App\Model\admin\role','admin_roles')->withTimestamps();
    }
    public function comments()
    {
        return $this->hasMany('App\Model\user\comments');
    }
    public function replys()
    {
        return $this->hasMany('App\Model\user\reply');
    }
    public function favorite_post()
    {
        return $this->hasMany('App\Model\user\favorite_post');
    }
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
}
