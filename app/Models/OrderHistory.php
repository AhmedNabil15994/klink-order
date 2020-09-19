<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{	
	protected $table = 'order_history';
    protected $primaryKey = 'id';
    public $timestamps = false;

    static function store($order_id,$status)
    {
        $historyObj = new OrderHistory;
        $historyObj->order_id = $order_id;
        $historyObj->status = $status;
        $historyObj->save();
    }
    
}
