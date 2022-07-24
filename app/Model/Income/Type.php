<?php

namespace App\Model\Income;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{

    protected $table = 'income_type';
    
    public function incomes() {
        return $this->hasMany('App\Model\Income\Income', 'type_id');
    }
    
}
