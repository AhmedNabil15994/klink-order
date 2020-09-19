<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{

    use \TraitsFunc;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function Cost(){
        return $this->hasMany('\App\Models\Cost','ship_id');
    }

    public function Source(){
        return $this->belongsTo('App\Models\Address','source_id');
    }
    public function Destination(){
        return $this->belongsTo('App\Models\Address','destination_id');
    }
    public function Ship(){
        return $this->belongsTo('App\Models\Shipping','ship_id');
    }
    public function Sender(){
        return $this->belongsTo('App\Models\OrderPerson','sender_id');
    }
    public function Receiver(){
        return $this->belongsTo('App\Models\OrderPerson','receiver_id');
    }
    public function OtherBiller(){
        return $this->belongsTo('App\Models\OrderPerson','other_biller_id');
    }
    public function Details(){
        return $this->hasOne('App\Models\OrderDetails','id','details_id');
    }
    public function Comments(){
        return $this->hasMany('App\Models\OrderComments','order_id');
    }
    public function Dates(){
        return $this->hasOne('App\Models\OrderDates','order_id');
    }
    public function CompanyOrderDates(){
        return $this->hasOne('App\Models\CompanyOrderDates','order_id');
    }
    public function Trackings(){
        return $this->hasOne('App\Models\OrderLiveTrackings','order_id');
    }
    public function Offers(){
        return $this->hasMany('App\Models\OrderOffers','order_id');
    }
    public function acceptedOffer(){
        return $this->hasOne('App\Models\OrderOffers','order_id')->where('user_accepted',1);
    }
    public function newOffers(){
        return $this->hasMany('App\Models\OrderOffers','order_id')->where('user_accepted',0);
    }

    static function getOrdersType($type){
        $data = '';
        if($type == 'newOrders'){
            $data = self::newOrders();

        }elseif($type == 'decidingOrders'){
            $data = self::decidingOrders();
        
        }elseif($type == 'acceptedOrders'){
            $data = self::acceptedOrders();
        
        }elseif($type == 'notCompletedOrders'){
            $data = self::notCompletedOrders();

        }elseif($type == 'expiredOrders'){
            $data = self::expiredOrders();
        
        }elseif($type == 'refusedOrders'){
            $data = self::refusedOrders();
        
        }elseif($type == 'cancelledOrders'){
            $data = self::cancelledOrders();
        
        }elseif($type == 'activeOrders'){
            $data = self::activeOrders();
        
        }elseif($type == 'completedOrders'){
            $data = self::completedOrders();
        
        }elseif($type == 'reclamationOrders'){
            $data = self::reclamationOrders();
        }

        return $data;

    }

    static function SelectAdvirtised()
    {
        $source = self::where('delivered', true)
        ->with('Ship')->take(10)->get();
        return self::generateObj($source);
    }

    static function myOrders($ip_address)
    {
        $source = self::where('ip_address', $ip_address)->take(10)->get();
        return self::generateObj($source);
    }

    static function getOne($code){
        $orderObj = self::NotDeleted()
            ->where('code', $code)
            ->first();
        return self::getData($orderObj);
    }

    static function generateObj($source){
        $list = [];
        foreach($source as $key => $value) {
            $list[$key] = new \stdClass();
            $list[$key] = self::getData($value);
        }
        return $list;
    }

    static function getData($source) {
        $data = new  \stdClass();
        $data->id = encrypt($source->id);
        $data->code = $source->code;
        $data->from = str_replace('<br>', ", ", $source->source->addressForm());
        $data->to = str_replace('<br>', ", ", $source->destination->addressForm());
        $data->ship = $source->ship_id != null ? Shipping::getOne($source->Ship->id) : '';
        $data->distance = $source->Details != null ? \Helper::calcDistance($source->Details->distance) : '';
        $data->duration = $source->Details != null ? \Helper::calcDuration($source->Details->duration) : '';
        $data->weight = $source->Details != null ? (int)$source->Details->weight : 0; 
        $data->width = $source->Details != null ? (int)$source->Details->width : 0; 
        $data->length = $source->Details != null ? (int)$source->Details->length : 0; 
        $data->height = $source->Details != null ? (int)$source->Details->height : 0; 
        $data->items = $source->Details != null ? $source->Details->items : 0; 
        $data->load_time = $source->Details != null ? $source->Details->loading_time : 0; 
        $data->person = $source->Details != null ? $source->Details->person : 0; 
        $data->description = $source->Details != null ? $source->Details->description : ''; 
        $data->price = $source->paid != null ? $source->paid : '';
        $data->cost = self::getCost($source);
        $data->sender = $source->sender_id != null ? \App\Models\OrderPerson::getOne($source->sender_id) : '';
        $data->receiver = $source->receiver_id != null ? \App\Models\OrderPerson::getOne($source->receiver_id) : '';
        $data->minutes =  $source->Details != null ? \Helper::calcDurationMinutes($source->Details->duration) : 0;
        $data->status = $source->status;
        $data->price = self::getPrice($source);
        $data->Biller = self::getBiller($source);
        if($source->bill_to == 2){
            $data->other_biller = \App\Models\OrderPerson::getOne($source->other_biller_id);
        }

        if($source->Dates){
            $data->dates = \App\Models\OrderDates::getOrderDates($source->id);
        }

        if($source->newOffers){
            $data->offers = \App\Models\OrderOffers::getOrderOffers($source->id,5);
        }

        return $data;
    }

    static function generateOrderCode($slug, $id) {
        $orderObj = self::NotDeleted()
            ->find($id);

        if ($orderObj == null) {
            return false;
        }

        $encode = rand('10000', '1000000');
        $str = $slug . '-' . $encode;

        $orderCheck = self::NotDeleted()
            ->where('code', $str)
            ->first();

        if ($orderCheck != null) {
            return self::generateOrderCode($slug, $id);
        }

        $orderObj->code = $str;
        $orderObj->save();

        return $orderObj->code;
    }

    static function getCost($source){
        $cost = $source->min_cost;
        return $cost != null ? $cost : 0;
    }

    static function getPrice($source){
        $cost = 0 ;
        if($source->cost != null){
            $cost = $source->cost;
        }else{
            if($source->acceptedOffer != null){
                $cost = $source->acceptedOffer->offer;
            }else{
                $cost = self::getCost($source);
            }
            $cost = round( $cost + ($cost * 19/100 ),2);
        }
        return $cost;
    }

    static function getPaymentType($type){
        $data = '';
        if($type == 1){
            $data = 'Paypal';
        }elseif ($type == 0) {
            $data = 'Bar';
        }
        return $data;
    }

    static function getStatus($orderStatus){
        
        $status = [
            [
                'id' => 0,
                'status' => 'New Order',
                'progress' => '10',
                'color' => 'dark'
            ],
            [
                'id' => 1,
                'status' => 'Deciding Order',
                'progress' => '60',
                'color' => 'info'
            ],
            [
                'id' => 2,
                'status' => 'Accepted Order',
                'progress' => '70',
                'color' => 'info'
            ],
            [
                'id' => 3,
                'status' => 'Not Completed Order',
                'progress' => '20',
                'color' => 'danger'
            ],
            [
                'id' => 4,
                'status' => 'Expired Order',
                'progress' => '40',
                'color' => 'danger'
            ],
            [
                'id' => 5,
                'status' => 'Refused Order',
                'progress' => '30',
                'color' => 'danger'
            ],
            [
                'id' => 6,
                'status' => 'Cancelled Order',
                'progress' => '25',
                'color' => 'danger'
            ],
            [   
                'id' => 7,
                'status' => 'Active Order',
                'progress' => '90',
                'color' => 'primary'
            ],
            [
                'id' => 8,
                'status' => 'Completed Order',
                'progress' => '100',
                'color' => 'success'
            ],
            [
                'id' => 9,
                'status' => 'Reclamation Order',
                'progress' => '95',
                'color' => 'warning'
            ],
        ];

        $data = array_filter($status, function ($var) use($orderStatus) {
                    return ($var['id'] == $orderStatus);
                });
        return array_values($data);
    }

    static function getBiller($source){

        $data = '';

        if($source->bill_to == '0'){
            $data = $source->Sender;
        }elseif ($source->bill_to == '1') {
            $data = $source->Receiver;
        }elseif ($source->bill_to == '2') {
            $data = $source->OtherBiller;
        }

        return $data;
    }

    // Order Status 
    // 0 => new Order
    // 1 => order details created
    // 2 => order person created
    // 3 => order expired
    // 4 => accepted Order 
    // 5 => Paid Order 


    // Payment Types 
    // 0 => Paypal
    // 1 => Visa 
    // 2 => Master Card
    // 3 => Maestro
    // 4 => Klarna
    // 5 => Sofort
    // 6 => Sepa
    // 7 => Vorkasse
    // 8 => Bar

}
