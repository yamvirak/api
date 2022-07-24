<?php

namespace App\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{

    protected $table = 'supplier';

   
    public function products() { //1:M
        return $this->hasMany('App\Model\Product\Product', 'supplier_id')
        //->select('id', 'name')
        ;

    }

   
    
}
