<?php

namespace App\Model\user;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    //
    public function admin()
    {
        return $this->belongsTo('App\Model\Admin\admin');
    }
    public function tags()
    {
        return $this->belongsToMany('App\Model\user\tag','post_tags')->withTimestamps();
    }
    public function categories()
    {
        return $this->belongsToMany('App\Model\user\category','category_posts')->withTimestamps();
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
    
}
