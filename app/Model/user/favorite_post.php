<?php

namespace App\Model\user;

use Illuminate\Database\Eloquent\Model;

class favorite_post extends Model
{
    //
    public function post()
    {
        return $this->belongsTo('App\Model\user\post');
    }
    public function user()
    {
        return $this->belongsTo('App\Model\user\User');
    }
    public function admin()
    {
        return $this->belongsTo('App\Model\admin\admin');
    }
}
