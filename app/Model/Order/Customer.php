<?php

namespace App\Model\Order;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $table = 'customer';
    

    public function order() {
        return $this->hasMany('App\Model\Order\Order', 'customer_id');
    }
}
