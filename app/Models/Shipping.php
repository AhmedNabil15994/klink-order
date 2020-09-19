<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model{

    use \TraitsFunc;

    protected $table = 'shippings';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Cost(){
        return $this->hasMany('\App\Models\Cost','ship_id');
    }

    public function Specs(){
        return $this->hasOne('\App\Models\Specification','ship_id');
    }

    static function getPhotoPath($id, $photo) {
        return \ImagesHelper::GetImagePath('shipping', $id, $photo);
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
        $data->title = $source->title;
        $data->width = $source->width;
        $data->weight = $source->weight;
        $data->length = $source->length;
        $data->height = $source->height;
        $data->number_of_items = $source->number_of_items;
        $data->discount = $source->discount;
        $data->min_packets = $source->min_packets;
        $data->image = self::getPhotoPath($source->id , $source->image);
        $data->is_active = $source->is_active == 1 ? 'Yes' : 'No';

        return $data;
    }

}
