<?php

namespace App\Model\user;

use Illuminate\Database\Eloquent\Model;

class reply extends Model
{
    //
    public function posts()
    {
        return $this->belongsTo('App\Model\user\post');
    }
    public function user()
    {
        return $this->belongsTo('App\Model\user\User');
    }
    public function comments()
    {
        return $this->belongsTo('App\Model\user\comments');
    }
}
