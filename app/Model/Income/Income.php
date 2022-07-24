<?php

namespace App\Model\Income;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Income extends Model
{
   	use SoftDeletes;
    

    protected $table = 'income';

   
    public function accountant() { //M:1
        return $this->belongsTo('App\Model\User\Main', 'user_id');
    }

    public function type() {  //M:1
        return $this->belongsTo('App\Model\Income\Type', 'type_id')
        ->select('id', 'name');
    }

}
