<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	public $timestamps = false;
    protected $table = 'addresses';

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'country_id', 'country_id');
    }

    public function addressForm()
    {
        $country = $this->country->name;
        $address = $this->street.' '.$this->home.'<br>'.$this->postal_code.' '.$this->city.'<br>'.$country;
        return $address ? $address : '';
    }
    public function getCountryNameAttribute()
    {
        return $this->country->name;
    }

    public function fullAddress()
    {
        $country = $this->country->name;
        $address = $this->street.' '.$this->home.' '.$this->postal_code.' '.$this->city.' '.$country;
        return $address ? $address : '';
    }

    static function checkAddressByLatLng($place){
        $addressObj = self::where('postal_code',$place->postal_code)->where('home',$place->home)->where('street',$place->street)->where('city',$place->city)->where('lat_lng',serialize($place->latlng))->first();
        if($addressObj != null){
            return $addressObj->id;
        }else{
            $countryObj = Country::where('code',$place->country)->first();
            $addressObj = new self;
            $addressObj->postal_code = $place->postal_code;
            $addressObj->home = $place->home;
            $addressObj->city = $place->city;
            $addressObj->street = $place->street;
            $addressObj->country_id = $countryObj->country_id;
            $addressObj->lat_lng = serialize($place->latlng);
            $addressObj->created_at = date('Y-m-d H:i:s');
            $addressObj->save();
            return $addressObj->id;
        }
    }
}
