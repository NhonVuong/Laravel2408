<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';
    public $timestamps = false;
     function product(){
        return $this->belongsToMany('App\Products','bill_detail','id_bill','id_product');
    }
     function billDetail(){
        return $this->hasMany('App\BillDetail','id_bill');
    }
     function customer(){
        return $this->belongsTo('App\Customer','id_customer','id');
    }
}
