<?php

namespace App\Model\user;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    //
    public function posts()
    {
        return $this->belongsToMany('App\Model\user\post','category_posts')->where(['status'=>1,'language'=> session('locale')])->paginate(6);
    }
}
