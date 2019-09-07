<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';
    function product(){
       return $this->hasMany('App\Products','id_type','id');
   }
   function pageUrlCate(){
       return $this->belongsTo('App\PageUrl','id_url','id');
   }
}
