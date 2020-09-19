<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{	
	protected $table = 'emails';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function order_person(){
    	return $this->belongsTo('App\Models\OrderPerson','id','email_id');
    }

    static function storeOrderPersonEmail($email){
    	$emailObj = self::where('email',$email)->first();

    	if($emailObj != null){
    		return $emailObj->id;
    	}else{
    		$emailObj = new Email;
    		$emailObj->email = $email;
    		$emailObj->save();
    		return $emailObj->id;
    	}
    }

    static function editOrderPersonEmail($email,$id){
        $emailObj = self::where('email',$email)->first();
        if($emailObj != null){
            return $emailObj->id;
        }else{
            $emailObj = self::find($id);
            $emailObj->email = $email;
            $emailObj->save();
            return $emailObj->id;
        }
    }

}
