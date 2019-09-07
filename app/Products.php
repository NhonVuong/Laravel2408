<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    public $timestamps = false; 

     function pageUrl(){
        return $this->belongsTo('App\PageUrl','id_url','id');
    }
    function categories(){
        return $this->belongsTo('App\Categories','id_type','id');
    }
    
    function bill(){
        return $this->belongsToMany('App\Bill','bill_detail','id_product','id_bill');
    }
}
