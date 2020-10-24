<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    //
    public function permissions()
    {
        return $this->belongsToMany('App\Model\Admin\Permission');
    }
    public function admin()
    {
        return $this->belongsToMany('App\Model\Admin\admin','admin_roles');
    }
}
