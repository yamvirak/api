<?php

namespace App\Model\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Stock extends Model
{
   	use SoftDeletes;
    

    protected $table = 'stock';

   
    public function product() { //M:1
        return $this->belongsTo('App\Model\Product\Product', 'product_id');
    }
    public function branch() { //M:1
        return $this->belongsTo('App\Model\Branch\Branch', 'branch_id');
    }

   
    
}
