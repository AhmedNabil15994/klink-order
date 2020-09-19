<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Number;
use App\Models\Email;
class OrderPerson extends Model
{   
    use \TraitsFunc;

    protected $table = 'order_persons';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function address(){
    	return $this->hasOne('App\Models\Address','id','address_id');
    }

    public function number(){
    	return $this->hasOne('App\Models\Number','id','number_id');
    }

    public function email(){
    	return $this->hasOne('App\Models\Email','id','email_id');
    }

    public function name(){
        return $this->first_name.' '.$this->last_name;
    }

    static function storeOrderPerson($data){
        $number_id = Number::storeOrderPersonMobile($data->mobile);
        $email_id = $data->email != null ? Email::storeOrderPersonEmail($data->email) : null;

        $personObj = self::NotDeleted()
                        ->where([
                            ['first_name','=',$data->first_name],
                            ['last_name','=',$data->last_name],
                            ['number_id','=',$number_id],
                            // ['email_id','!=',null],
                            ['email_id','=',$email_id],
                        ])->first();

        if($personObj != null){
            return $personObj->id;
        }else{
            $personObj = new OrderPerson;
            $personObj->first_name = $data->first_name;
            $personObj->last_name = $data->last_name;
            $personObj->company = $data->company;
            $personObj->number_id = $number_id;
            if($email_id != null){
                $personObj->email_id = $email_id;
            }
            $personObj->save();

            return $personObj->id;
        }
    }
    static function getOne($id){
        $personObj = self::NotDeleted()->find($id);

        $dataObj = new \stdClass();
        $dataObj->id = $id;
        $dataObj->name = $personObj->name();
        $dataObj->phone = $personObj->number_id != null ? $personObj->number->mobile_number : '';
        $dataObj->email = $personObj->email_id != null ? $personObj->email->email : '';
        $dataObj->company = $personObj->company;
        return $dataObj;
    }

}
