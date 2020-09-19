<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDates extends Model
{   
    protected $table = 'order_dates';
    protected $primaryKey = 'id';
    public $timestamps = false;
    

    static function storeOrderDates($id,$data){
    	$datesObj = self::where('order_id',$id)->first();
    	if($datesObj != null){
    		$datesObj->load_from = \Helper::formatDate(str_replace('.', '/', $data->load_from));
    		$datesObj->load_until = \Helper::formatDate(str_replace('.', '/', $data->load_to));
    		$datesObj->deliver_from = \Helper::formatDate(str_replace('.', '/', $data->deliver_from));
    		$datesObj->deliver_until = \Helper::formatDate(str_replace('.', '/', $data->deliver_to));
    		$datesObj->save();
    	}else{
    		$datesObj = new OrderDates;
            $datesObj->order_id = $id;
    		$datesObj->load_from = \Helper::formatDate(str_replace('.', '/', $data->load_from));
    		$datesObj->load_until = \Helper::formatDate(str_replace('.', '/', $data->load_to));
    		$datesObj->deliver_from = \Helper::formatDate(str_replace('.', '/', $data->deliver_from));
    		$datesObj->deliver_until = \Helper::formatDate(str_replace('.', '/', $data->deliver_to));
    		$datesObj->save();
    	}
    }

    static function getOrderDates($id){
        $datesObj = self::where('order_id',$id)->first();
        if($datesObj != null){
            $load = new \stdClass();
            $deliver = new \stdClass();
            $dataObj = new \stdClass();

            if(\Helper::formatDateForDisplay($datesObj->load_from) == \Helper::formatDateForDisplay($datesObj->load_until)){
                $load->day = \Helper::formatDateForDisplay($datesObj->load_from,false , true);
                $load->from = \Helper::getTimeFromDate($datesObj->load_from);
                $load->to = \Helper::getTimeFromDate($datesObj->load_until);
                $dataObj->load = $load;
            }else{
                $dataObj->load_from  = \Helper::formatDateForDisplay($datesObj->load_from , true , true);
                $dataObj->load_until  = \Helper::formatDateForDisplay($datesObj->load_until , true , true);
            }

            if(\Helper::formatDateForDisplay($datesObj->deliver_from) == \Helper::formatDateForDisplay($datesObj->deliver_until)){
                $deliver->day = \Helper::formatDateForDisplay($datesObj->deliver_from,false , true);
                $deliver->from = \Helper::getTimeFromDate($datesObj->deliver_from);
                $deliver->to = \Helper::getTimeFromDate($datesObj->deliver_until);
                $dataObj->deliver = $deliver;
            }else{
                $dataObj->deliver_from  = \Helper::formatDateForDisplay($datesObj->deliver_from , true , true);
                $dataObj->deliver_until  = \Helper::formatDateForDisplay($datesObj->deliver_until , true , true);
            }
            $dataObj->valid_until = $datesObj->valid_until;
            return $dataObj;
        }
    }

}
