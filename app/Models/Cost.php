<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model{

    use \TraitsFunc;

    protected $table = 'shippings_cost';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Ship(){
        return $this->belongsTo('\App\Models\Shipping','ship_id');
    }

    public function Distance(){
        return $this->belongsTo('\App\Models\Distance','distance_id');
    }

    static function getOne($id){
        $source = self::NotDeleted()
            ->where('id', $id)
            ->first();
        return self::getData($source);
    }

    static function getOneByDistance($id,$distance){
        $source = self::NotDeleted()
            ->where('id', $id)
            ->first();
        return self::getAllData($source,$distance);
    }

    static function getOneByDistanceAndShip($distance_id,$ship_id,$distance){
        $source = self::NotDeleted()
            ->where('ship_id', $ship_id)
            ->where('distance_id', $distance_id)
            ->first();
        return self::getAllData($source,$distance);
    }

    static function getShipsByType($type_id,$distance){
        $source = self::NotDeleted()
            ->where('distance_id', $type_id)
            ->get();
        return self::getTypeData($source,$distance);
    }

    static function getTypeData($source,$distance){
        $list = [];
        foreach ($source as $key => $value) {
            $list[$key] = new \stdClass();
            $list[$key] = self::getAllData($value,$distance);
        }
        return $list;
    }

    static function getAllData($source,$distance){
        
        $data = new  \stdClass();
        $data->id = $source->id;
        $data->distance_id = $source->distance_id;
        $data->cost_per_kilo = $source->cost_per_kilo;
        $data->min_cost = $source->min_cost;
        $data->cost = self::getCost($source , $distance);
        $data->ship = $source->Ship != null ? \App\Models\Shipping::getOne($source->ship_id) : '';
        $data->weight = $source->Ship != null ? \App\Models\Shipping::getOne($source->ship_id)->weight : 0;
        $data->width = $source->Ship != null ? \App\Models\Shipping::getOne($source->ship_id)->width : 0;
        $data->length = $source->Ship != null ? \App\Models\Shipping::getOne($source->ship_id)->length : 0;
        $data->height = $source->Ship != null ? \App\Models\Shipping::getOne($source->ship_id)->height : 0;
        return $data;
    }

    static function getCost($source , $distance){
        if ($source->cost_per_kilo * $distance < $source->min_cost) {
            $cost = $source->min_cost;
            $cost =  number_format($cost, 2,'.','');
        } else {
            $cost = $source->cost_per_kilo * $distance;
            $cost =  number_format($cost, 2,'.','');
        }
        return $cost;
    }

    static function getData($source) {
        $data = new  \stdClass();
        $data->id = $source->id;
        $data->min_cost = $source->min_cost;
        $data->cost_per_kilo = $source->cost_per_kilo;
        $data->distance = $source->Distance != null ? $source->Distance : '';
        $data->ship = $source->Ship != null ? $source->Ship : '';
        $data->is_active = $source->is_active == 1 ? 'Yes' : 'No';

        return $data;
    }

}
