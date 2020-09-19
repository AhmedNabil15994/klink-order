<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderComments extends Model
{   
    protected $table = 'order_comments';
    protected $primaryKey = 'id';
    public $timestamps = false;
    

    public function User(){
    	return $this->belongsTo('\App\Models\User','user_id');
    }

}
