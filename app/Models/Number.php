<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    public $timestamps = true;
    protected $fillable = ['mobile_number','mobile_number2','home_number'];
    
    static function storeOrderPersonMobile($mobile){
        $mobileObj = self::where('mobile_number',$mobile)->orWhere('mobile_number2',$mobile)->first();
        if($mobileObj != null){
            return $mobileObj->id;
        }else{
            $mobileObj = new self;
            $mobileObj->mobile_number = $mobile;
            $mobileObj->created_at = date('Y-m-d H:i:s');
            $mobileObj->save();
            return $mobileObj->id;
        }
    }
}
