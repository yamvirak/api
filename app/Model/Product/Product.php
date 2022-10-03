<?php

namespace App\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
   	use SoftDeletes;
    

    protected $table = 'product';

   
    public function type() { //M:1
        return $this->belongsTo('App\Model\Product\Type', 'type_id')
        ->select('id', 'name');
    }
    public function supplier() { //M:1
        return $this->belongsTo('App\Model\Product\Supplier', 'supplier_id')
        ->select('id', 'name');
    }
    public function branch() { //M:1
        return $this->belongsTo('App\Model\Branch\Branch', 'branch_id')
        ->select('id', 'name');
    }
    public function stock() { //1:M
        return $this->hasMany('App\Model\Product\Stock', 'product_id');
    }

   
    
}
