<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{   
    protected $table = 'order_details';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
