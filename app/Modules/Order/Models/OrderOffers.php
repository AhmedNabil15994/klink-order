<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderOffers extends Model
{   
    use \TraitsFunc;

    protected $table = 'order_offers';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Company(){
        return $this->belongsTo('App\Models\User','company_id');
    }
    public function Driver(){
        return $this->belongsTo('App\Models\User','driver_id');
    }
    public function Order(){
        return $this->belongsTo('App\Models\Order','order_id');
    }

    static function getPhotoPath($user_id, $photo) {
        return \ImagesHelper::GetImagePath('user', $user_id, $photo);
    }

 	static function getOrderOffers($order_id,$limit){
 		$data = self::where('order_id',$order_id)->where('user_accepted',0)->orderBy('id','DESC')->get()->take($limit); 		
 		return self::getData($data);
 	}

 	static function getData($data){
 		$list=[];
 		foreach ($data as $key => $value) {
 			$list[$key] = new \stdClass();
 			$list[$key] = self::generateObj($value);
 		}
 		return $list;
 	}

 	static function generateObj($source){
        $total = $source->offer;
        $ship_discount = round($source->Order->Ship->discount/100 ,2);
        $x = round($total / 119 * 100 ,2);
        $n = round($x * (1 + $ship_discount)  ,2);

 		$dataObj = new \stdClass();
 		$dataObj->id = $source->id;
        $dataObj->decID = encrypt($source->id);
 		$dataObj->company = $source->Company->Profile->company != null ? $source->Company->Profile->company : $source->Company->Profile->name();
 		$dataObj->offer = $source->offer;
        $dataObj->image = self::getPhotoPath($source->Company->Profile->user_id , $source->Company->Profile->image);
        $dataObj->display_price = $n;
 		return $dataObj;
 	}

}
