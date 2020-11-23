<?php
namespace App\Model\user;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
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
    public function replys()
    {
        return $this->hasMany('App\Model\user\reply');
    }
    public function admin()
    {
        return $this->belongsTo('App\Model\admin\admin');
    }
}
