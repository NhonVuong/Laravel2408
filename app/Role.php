<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    
    function user(){
        return $this->belongsToMany('App\User','role_user','role_id','user_id');
    }
}
