<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distance extends Model{

    use \TraitsFunc;

    protected $table = 'shippings_distance';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Cost(){
        return $this->hasMany('\App\Models\Cost','distance_id');
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
        $data->min = $source->min;
        $data->max = $source->max;
        $data->is_active = $source->is_active == 1 ? 'Yes' : 'No';

        return $data;
    }

}
