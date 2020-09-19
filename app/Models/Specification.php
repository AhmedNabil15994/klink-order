<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model{

    use \TraitsFunc;

    protected $table = 'shippings_specs';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Ship(){
        return $this->belongsTo('\App\Models\Shipping','ship_id');
    }

    static function getOne($id){
        $source = self::NotDeleted()
            ->where('id', $id)
            ->first();
        return self::getData($source);
    }

    static function getData($source) {
        $data = new  \stdClass();
        $data->id = $source->id;
        $data->min_load_time = $source->min_load_time;
        $data->max_load_time = $source->max_load_time;
        $data->cost_per_unit = $source->cost_per_unit;
        $data->min_person = $source->min_person;
        $data->max_person = $source->max_person;
        $data->cost_per_person = $source->cost_per_person;
        $data->ship = $source->Ship != null ? $source->Ship : '';
        $data->is_active = $source->is_active == 1 ? 'Yes' : 'No';

        return $data;
    }

}
