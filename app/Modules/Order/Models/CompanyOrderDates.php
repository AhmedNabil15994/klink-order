<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyOrderDates extends Model
{   
    protected $table = 'company_order_dates';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function Company(){
        return $this->belongsTo('App\Models\User','company_id');
    }
    
}
