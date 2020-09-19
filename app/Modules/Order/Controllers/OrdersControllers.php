<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Hochstrasser\Wirecard\Context;
use Hochstrasser\Wirecard\Helper\WirecardHelper;
use Hochstrasser\Wirecard\Model\Common\PaymentType;
use Hochstrasser\Wirecard\Request\Seamless\Frontend\InitPaymentRequest;
use Hochstrasser\Wirecard\Model\Common\Basket;
use Hochstrasser\Wirecard\Model\Common\BasketItem;
use Hochstrasser\Wirecard\Model\Common\ShippingInformation;
use Hochstrasser\Wirecard\Model\Common\BillingInformation;
use Hochstrasser\Wirecard\Request\CheckoutPage\InitCheckoutPageRequest;
use Hochstrasser\Wirecard\Request\Seamless\Frontend\InitDataStorageRequest;
use GuzzleHttp\Client;
use Hochstrasser\Wirecard\Request\Seamless\Frontend\ReadDataStorageRequest;

use App\Models\Order;
use App\Models\Address;
use App\Models\Distance;
use App\Models\Shipping;
use App\Models\Cost;
use App\Models\OrderDetails;
use App\Models\OrderPerson;
use App\Models\OrderOffers;
use App\Models\Email;
use App\Models\Number;
use App\Models\OrderDates;
use App\Models\Variables;
use App\Models\EmailTemplates;
use App\Models\OrderHistory;
use App\Mail\MailSender;

class OrdersControllers extends Controller {

    use \TraitsFunc;

    public function checkOrderForEmail($order_id,$status){
        $emailMode = Variables::getVar('ORDER_EMAILS');
        $orderObj = Order::NotDeleted()->find($order_id);
        if($orderObj == null){
            abort(404);
        }
        if($emailMode == 'on'){
            if ($status == 1) {
                OrderHistory::store($order_id, 'Order Created');
                $this->sendAdminEmail($orderObj, trans('frontend/order.emailStore'));
            }else if ($status == 2) {
                OrderHistory::store($order_id, 'Sender & Receiver Information');
                $this->sendAdminEmail($orderObj, trans('frontend/order.emailStoreTwo'));
            }else if ($status == 3) {
                OrderHistory::store($order_id, 'LOOKING FOR OFFERS');
                $this->sendAdminEmail($orderObj, trans('frontend/order.emailStoreFour'));
            }
        }
    }

    public function sendAdminEmail(Order $order, $description='')
    {
        $RegisterEmail = EmailTemplates::where('title', '=', 'AdminStatusEmail')->first();

        $email = Variables::getVar('ORDER_SENDING_EMAIL');
        
        $data = [
            'orderStatus'=>$order->status,
            'orderId'=>$order->id,
            'description'=>$description
            
        ];
        $GeneratedEmail = $RegisterEmail->parse($data);
        \Mail::to($email, 'Kurier Link Admin')
        ->send(new MailSender($GeneratedEmail[1], $GeneratedEmail[0], [0=>['address'=>'admin@kurier-link.com','name'=>'Kurier Link']]));
        return 1;
    }

    public function create(){
        $input = Input::all();

        $source = json_decode($input['from']);
        $destination = json_decode($input['to']);
        $source_id = Address::checkAddressByLatLng($source);
        $destination_id = Address::checkAddressByLatLng($destination);
        $details_id = '';
        
        $details = json_decode($input['details']);
        
        $detObj = OrderDetails::where([
                'distance' => $details->distance->value,
                'duration' => $details->duration->value,
        ])->first();

        if($detObj == null){
            $detailsObj = new OrderDetails;
            $detailsObj->distance = $details->distance->value;
            $detailsObj->duration = $details->duration->value;
            $detailsObj->save();
            $details_id = $detailsObj->id;
        }else{
            $details_id = $detObj->id;
        }

        $order = Order::NotDeleted()->where([
            'source_id'=>$source_id,
            'destination_id' => $destination_id,
            'details_id' => $details_id,
            'ip_address' => \Request::ip(),
        ])->first();

        if($order != null){
            return redirect()->to('/orders/create_new/'.$order->code);
        }

        $orderObj = new Order;
        $orderObj->source_id = $source_id;
        $orderObj->destination_id = $destination_id;
        $orderObj->ip_address = \Request::ip();
        $orderObj->details_id = $details_id;
        $orderObj->save();

        $code = Order::generateOrderCode('order',$orderObj->id);
        
        return redirect()->to('/orders/create_new/'.$code);
    }

    public function getOrder($code){

        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null || $orderObj->status > 4){
            abort(404);
        }

        if($orderObj->status == 1){
            return redirect()->to('/orders/complete_order/' . $code);
        }else if($orderObj->status == 2){
            return redirect()->to('/orders/lastSteps/' . $code);
        }else if($orderObj->status == 4){
            return redirect()->to('/orders/lastSteps/' . $code);
        }


        $custOrderObj = Order::getOne($code);
        $orderDistance = (float) $custOrderObj->distance;

        $this->data['sourceLatLng'] = json_encode(unserialize($orderObj->Source->lat_lng));
        $this->data['destinationLatLng'] = json_encode(unserialize($orderObj->Destination->lat_lng));
        $this->data['order'] = $custOrderObj;
        $this->data['allShips'] = $this->mainData($orderDistance);
        $this->data['source'] = str_replace("<br>", ", ", $orderObj->Source->addressForm());
        $this->data['destination'] = str_replace("<br>", ", ", $orderObj->Destination->addressForm());
        return view('Order.Views.index',$this->data);
    }

    public function changeDetails($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();
        $input = Input::all();

        $source = json_decode($input['from']);
        $destination = json_decode($input['to']);
        $source_id = Address::checkAddressByLatLng($source);
        $destination_id = Address::checkAddressByLatLng($destination);
        $details = json_decode($input['details']);
        
        $detailsObj = OrderDetails::find($orderObj->details_id);
        $detailsObj->distance = $details->distance->value;
        $detailsObj->duration = $details->duration->value;
        $detailsObj->save();

        $orderObj->source_id = $source_id;
        $orderObj->destination_id = $destination_id;
        $orderObj->save();

        return 1;
    }   

    public function mainData($distance){

        $availableShippingType = Distance::NotDeleted()->where('min', '<=', $distance)
            ->where('max', '>=', $distance)->first();

        $allShips = Cost::getShipsByType($availableShippingType->id,$distance);

        return $allShips;
    }

    public function filterShips($allShips,$weight,$dimensionsArray){
        $filteredShips = array_filter($allShips,function($key) use ($weight,$dimensionsArray){

            return  $key->ship->weight >= $weight &&  
                    $key->ship->width >= $dimensionsArray[0] && 
                    $key->ship->length >= $dimensionsArray[1] && 
                    $key->ship->height >= $dimensionsArray[2];
        });
        array_multisort(array_column($filteredShips, 'weight'),SORT_ASC,$filteredShips);

        return $filteredShips;
    }

    public function getShipsByWeight($code){
        $orderObj = Order::getOne($code);
        $allShips = $this->mainData((float) $orderObj->distance);
        $input = \Request::all();
        $dimensionsArray = [
            isset($input['width']) ? $input['width'] * 10 : 0,
            isset($input['length']) ? $input['length'] * 10 : 0,
            isset($input['height']) ? $input['height'] * 10 : 0,
        ];

        $this->data['allShips'] = $this->filterShips($allShips,$input['weight'],$dimensionsArray);

        return view('Order.Views.Ajax.swiper',$this->data)->render();
    }

    public function getShipsSpec($code){
        $input = \Request::all();
        $orderObj = Order::NotDeleted()->where('code',$code)->first();
        $distance = round(\Helper::calcDistance($orderObj->Details->distance));

        if(isset($input['ship_id'])){
            $shipObj = Shipping::find((int) $input['ship_id']);
            $shipCost = Cost::getOneByDistance( (int) $input['cost_id'] , $distance);
            $load_time_input = $input['load_time'];
            $persons_input = $input['persons'];
        }else{
            $shipObj = Shipping::find($orderObj->ship_id);
            $availableShippingType = Distance::NotDeleted()->where('min', '<=', $distance)
            ->where('max', '>=', $distance)->first();
            $shipCost = Cost::getOneByDistanceAndShip($availableShippingType->id,$orderObj->ship_id,$distance);
            $load_time_input = $orderObj->Details->loading_time;
            $persons_input = $orderObj->Details->person;
        }

        if($shipObj->Specs != null){

            $loadTime = $load_time_input - $shipObj->Specs->min_load_time;
            $cost_per_unit = $loadTime * $shipObj->Specs->cost_per_unit;

            $cost_per_person = ($persons_input - 1) * ($loadTime + ($orderObj->Details->duration / 60)) * $shipObj->Specs->cost_per_person;
          
            if ($shipCost->cost_per_kilo * $distance < $shipCost->min_cost) {
                $cost = ($shipCost->min_cost + $cost_per_unit + $cost_per_person);
                $cost =  number_format($cost, 2,'.','');
            } else {
                $cost = (($shipCost->cost_per_kilo * $distance) + $cost_per_unit + $cost_per_person);
                $cost =  number_format($cost, 2,'.','');
            }
            return $cost;
        }else{
            return $shipCost->cost;
        }
        
    }

    protected function validateOrder() {
        $input = Input::all();

        $rules = [
            'weight'=>'required|numeric',
            'items'=>'required|numeric',
            'length'=>'required|numeric',
            'width'=>'required|numeric',
            'height'=>'required|numeric',
            'persons'=>'required|numeric',
            'load_time'=>'required|numeric',
            'ship_id'=>'required|numeric|exists:shippings,id',
            'description'=>'required'
        ];

        $message = [
            'weight.required' => "Sorry Weight Required",
            'items.required' => "Sorry Number Of Items Required",
            'length.required' => "Sorry Length Required",
            'width.required' => "Sorry Width Required",
            'height.required' => "Sorry Height Required",
            'load_time.required' => "Sorry Load Time Required",
            'persons.required' => "Sorry Number Of Person Required",
            'ship_id.required' => "Sorry Shipping Required",
            'description.required' => "Sorry Description Required",
        ];

        return \Validator::make($input, $rules, $message);
    }

    protected function validatePerson($type,$data) {
        $rules = [
            'first_name'=>'required',
            'last_name'=>'required',
            'mobile'=>'required|phone_number',
        ];

        $message = [
            'first_name.required' => "Sorry ".$type." First Name Required",
            'last_name.required' => "Sorry ".$type." Last Name Required",
            'mobile.required' => "Sorry ".$type." Mobile Required",
            'mobile.phone_number' => "Sorry ".$type." Mobile Must Be German",
        ];

        return \Validator::make((array) $data, $rules, $message);
    }

    protected function validateDates($data) {
        $input = Input::all();

        $rules = [
            'load_from'=>'required',
            'load_to'=>'required',
            'deliver_from'=>'required',
            'deliver_to'=>'required',
        ];

        $message = [
            'load_from.required' => "Sorry Load From Required",
            'load_to.required' => "Sorry Load To Required",
            'deliver_from.required' => "Sorry Deliver From Required",
            'deliver_to.required' => "Sorry Deliver To Required",
        ];

        return \Validator::make( (array) $data, $rules, $message);
    }

    protected function validateData($data,$type,$attr) {
        $rules = [
            'value'=>'required',
        ];

        $message = [
            'value.required' => "Sorry ".$type." ".$attr." Required",
        ];

        return \Validator::make( (array) $data, $rules, $message);
    }

    public function storeDetails($orderObj,$input,$code){
        $orderObj->Details()->update([
            'weight' => (double) $input['weight'],
            'width' => (double) $input['width'],
            'length' => (double) $input['length'],
            'height' => (double) $input['height'],
            'items' => (int) $input['items'],
            'loading_time' => (int) $input['load_time'],
            'person' => (int) $input['persons'],
            'description' => (string) $input['description'],
        ]);

        $orderObj->ship_id = (int) $input['ship_id'];
        $orderObj->min_cost = $this->getShipsSpec($code);
        $orderObj->status = 1;
        $orderObj->save();
    }

    public function storeOrderDetails($code){
        $orderObj =  Order::NotDeleted()->where('code',$code)->first();
        $input = \Request::all();

        $validate = $this->validateOrder();
        if($validate->fails()){
            \Session::flash('error', $validate->messages()->first());
            return redirect()->back();
        }


        $this->storeDetails($orderObj,$input,$code);
        $this->checkOrderForEmail($orderObj->id,1);

        \Session::flash('success', "Alert! Saved Successfully");
        return redirect()->to('/orders/complete_order/' . $code);
    }

    public function completeOrder($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null || $orderObj->status > 4){
            abort(404);
        }
        if($orderObj->status == 0){
            return redirect()->to('/orders/create_new/' . $code);
        }else if($orderObj->status == 2 || $orderObj->status == 4){
            return redirect()->to('/orders/lastSteps/' . $code);
        }

        $custOrderObj = Order::getOne($code);
        $orderDistance = (float) $custOrderObj->distance;

        $this->data['sourceLatLng'] = json_encode(unserialize($orderObj->Source->lat_lng));
        $this->data['destinationLatLng'] = json_encode(unserialize($orderObj->Destination->lat_lng));
        $this->data['order'] = $custOrderObj;
        $this->data['allShips'] = $this->mainData($orderDistance);
        $this->data['source'] = str_replace("<br>", ", ", $orderObj->Source->addressForm());
        $this->data['destination'] = str_replace("<br>", ", ", $orderObj->Destination->addressForm());
        return view('Order.Views.completeOrder',$this->data);
    }

    public function saveOrder($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null){
            abort(404);
        }
        
        $input = \Request::all();
        
        /**** Store Other Biller ****/
        if((int) $input['bill_to'] == 2){
            $validate = $this->validatePerson('Other Biller',json_decode($input['other_biller']));
            if($validate->fails()){
                \Session::flash('error', $validate->messages()->first());
                return redirect()->back()->withInput();
            }
            $other_biller_id = OrderPerson::storeOrderPerson(json_decode($input['other_biller']));
            $orderObj->other_biller_id = $other_biller_id;
            $orderObj->save();
        }

        /**** Store Sender ****/
        $validate = $this->validatePerson('Sender',json_decode($input['sender']));
        if($validate->fails()){
            \Session::flash('error', $validate->messages()->first());
            return redirect()->back()->withInput();
        }
        $sender_id = OrderPerson::storeOrderPerson(json_decode($input['sender']));

        /**** Store Receiver ****/
        $validate = $this->validatePerson('Receiver',json_decode($input['receiver']));
        if($validate->fails()){
            \Session::flash('error', $validate->messages()->first());
            return redirect()->back()->withInput();
        }
        $receiver_id = OrderPerson::storeOrderPerson(json_decode($input['receiver']));

        /**** Store Dates ****/
        $validate = $this->validateDates(json_decode($input['dates']));
        if($validate->fails()){
            \Session::flash('error', $validate->messages()->first());
            return redirect()->back()->withInput();
        }
        OrderDates::storeOrderDates($orderObj->id , json_decode($input['dates']));

        if((int) $input['ship_id'] > 0 && (int) $input['cost_id'] > 0){
            /**** Store Details ****/
            $validate = $this->validateOrder();
            if($validate->fails()){
                \Session::flash('error', $validate->messages()->first());
                return redirect()->back()->withInput();
            }
            $this->storeDetails($orderObj,$input,$code);
        }
        
        
        /**** Store Order Data ****/
        $orderObj->sender_id = $sender_id;
        $orderObj->receiver_id = $receiver_id;
        $orderObj->bill_to = $input['bill_to'];
        $orderObj->status = 2;
        $orderObj->save();  

        $this->checkOrderForEmail($orderObj->id,2);

        \Session::flash('success', "Alert! Saved Successfully");
        return redirect()->to('/orders/lastSteps/' . $code);
    }

    public function lastSteps($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null || $orderObj->status > 4){
            abort(404);
        }

        $now = date("Y-m-d H:i:s");
        if($orderObj->Dates->valid_until != null && $now > $orderObj->Dates->valid_until){
            // Order Expired
            $orderObj->status = 3;
            $orderObj->save();
            abort(404);
        }

        if(count($orderObj->newOffers) == 0){
            $this->checkOrderForEmail($orderObj->id ,3);
        }

        if($orderObj->status == 0){
            return redirect()->to('/orders/create_new/' . $code);
        }elseif($orderObj->status == 1){
            return redirect()->to('/orders/complete_order/' . $code);
        }elseif($orderObj->status == 3){
            abort(404);
        }

        $order = Order::getOne($code);

        $wireCardMode = Variables::getVar('WIRECARD_MODE');
        $language = Variables::getVar('WIRECARD_LANGUAGE') != null ? Variables::getVar('WIRECARD_LANGUAGE'): 'de';
        if($wireCardMode == 'live'){
            $customer_id = Variables::getVar('WIRECARD_LIVE_CUSTOMER_ID');
            $secret = Variables::getVar('WIRECARD_LIVE_SECRET');
        }else if($wireCardMode == 'test'){
            $customer_id = Variables::getVar('WIRECARD_TEST_CUSTOMER_ID');
            $secret = Variables::getVar('WIRECARD_TEST_SECRET');
        }

        $context = new Context([
            'customer_id' => $customer_id,
            'secret' => $secret,
            'language' => $language,
        ]);


        $request = InitCheckoutPageRequest::with()
                ->setPaymentType(PaymentType::Select)
                ->setContext($context)
                ->setAmount($order->price)
                ->setCurrency('EUR')
                ->setOrderDescription(trans('frontend/order.invoice').' #'.$code)
                ->setSuccessUrl(\URL::to('/orders/lastSteps/'.$code.'/payment_success'))
                ->setFailureUrl(\URL::to('/404'))
                ->setCancelUrl(\URL::to('/404'))
                ->setServiceUrl(\URL::to('/503'));

        $this->data['request'] = $request;

        $order = Order::getOne($code);
        $this->data['order'] = $order;
        $this->data['offers'] = $order->offers;
        return view('Order.Views.unCompletedOrder',$this->data);
    }

    public function changePerson($id){
        $input = \Request::all();
        $input['order_id'] = (int) decrypt($id);
        $orderObj = Order::NotDeleted()->find($input['order_id']);
        $property = '';
        $title = '';

        if($orderObj == null){
            abort(404);
        }

        if($input['person'] == 'sen'){
            $property = 'sender_id';
            $title = 'Sender';
        }elseif ($input['person'] == 'rec') {
            $property = 'receiver_id';
            $title = 'Receiver';
        }elseif ($input['person'] == 'oth') {
            $property = 'other_biller_id';
            $title = 'Other Bill';
        }

        if($input['type'] == 'name'){
            $validate = $this->validateData($input,$title,'Name');
            if($validate->fails()){
                return \Response::json([
                    'errors' => $validate->getMessageBag()->toArray()
                ]);
            }
            $name = explode(' ', $input['value'], 2);
            $personObj = OrderPerson::NotDeleted()->find($orderObj->$property);
            $personObj->first_name = $name[0];
            $personObj->last_name = $name[1] != null ? $name[1] : '';
            $personObj->save();
            return 1;
        }

        if($input['type'] == 'phone'){
            $validate = $this->validateData($input,$title,'Phone');
            if($validate->fails()){
                return \Response::json([
                    'errors' => $validate->getMessageBag()->toArray()
                ]);
            }
            $personObj = OrderPerson::NotDeleted()->find($orderObj->$property);
            $personObj->number_id = Number::editOrderPersonPhone($input['value'],$personObj->number_id);
            $personObj->save();
            return 1;
        }

        if($input['type'] == 'email'){
            $validate = $this->validateData($input,$title,'Email');
            if($validate->fails()){
                return \Response::json([
                    'errors' => $validate->getMessageBag()->toArray()
                ]);
            }

            $personObj = OrderPerson::NotDeleted()->find($orderObj->$property);
            $personObj->email_id = Email::editOrderPersonEmail($input['value'],$personObj->email_id);
            $personObj->save();
            return 1;
        }

        if($input['type'] == 'company'){
            $personObj = OrderPerson::NotDeleted()->find($orderObj->$property);
            $personObj->company = $input['value'];
            $personObj->save();
            return 1;
        }
    }

    public function changeDescription($id){
        $input = \Request::all();
        $input['order_id'] = (int) decrypt($id);
        $orderObj = Order::NotDeleted()->find($input['order_id']);

        if($orderObj == null){
            abort(404);
        }

        $rules = ['description'=>'required'];
        $message = ['description.required' => "Sorry Description Required"];
        $validate = \Validator::make( (array) $input, $rules, $message);
        if($validate->fails()){
            return \Response::json([
                'errors' => $validate->getMessageBag()->toArray()
            ]);
        } 
        $detailsObj = OrderDetails::find($orderObj->details_id);
        $detailsObj->description = $input['description'];
        $detailsObj->save();

        return 1;
    }

    public function getOrderOffers($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null){
            abort(404);
        }

        if(!$orderObj->acceptedOffer){
            $this->data['offers'] = OrderOffers::getOrderOffers($orderObj->id,5);
            if(!empty($this->data['offers'])){
                return view('Order.Views.Ajax.offers',$this->data)->render();
            }else{
                return 1;
            }
        }
    }

    public function acceptOffer($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null){
            abort(404);
        }
        
        $input = \Request::all();
        $offer_id = decrypt($input['id']);
        $offerObj = OrderOffers::NotDeleted()->find($offer_id);
        $offerObj->user_accepted = 1;
        $offerObj->save();

        $total = $offerObj->offer;
        $ship_discount = round($orderObj->Ship->discount/100 ,2);
        $x = round($total / 119 * 100 ,2);
        $n = round($x * (1 + $ship_discount)  ,2);
        $newDisc = round($ship_discount * $n ,2);
        $newTotal = round($n * (119 / 100) ,2);
        $newVat = round($newTotal - $n ,2);

        $orderObj->min_cost = $n;
        $orderObj->cost = $newTotal;
        $orderObj->status = 4;
        $orderObj->save();

        $date = date("Y-m-d H:i:s", strtotime('+24 hours'));
        $dates = OrderDates::where('order_id',$orderObj->id)->first();
        $dates->valid_until = $date;
        $dates->save();

        return [$n , $newVat, $newTotal,$date];        
    }

    public function refuseOffer($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null){
            abort(404);
        }
        
        $input = \Request::all();
        $offer_id = decrypt($input['id']);
        $offerObj = OrderOffers::NotDeleted()->find($offer_id);
        $offerObj->user_accepted = 2;
        $offerObj->save();

        return 1;
    }

    public function payment($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null){
            abort(404);
        }

        $input = \Request::all();
        $orderObj->paid = 0;
        $orderObj->status = 5;
        $orderObj->save();

        $detailsObj = OrderOffers::where('order_id',$orderObj->id)->where('user_accepted',1)->first();
        $detailsObj->payment_type = 8;
        $detailsObj->save();

        \Session::flash('success', 'Payment Done Successfully \n Invoice Sent To your Mail');
        return redirect()->to("/");
    }

    public function payment_success($code){
        $orderObj = Order::NotDeleted()->where('code',$code)->first();
        if($orderObj == null){
            abort(404);
        }

        $orderObj->paid = $orderObj->cost;
        $orderObj->status = 5;
        $orderObj->save();

        $detailsObj = OrderOffers::where('order_id',$orderObj->id)->where('user_accepted',1)->first();
        $detailsObj->payment_type = 7;
        $detailsObj->save();

        \Session::flash('success', 'Payment Done Successfully \n Invoice Sent To your Mail');
        return redirect()->to("/");
    }

    public function deleteOrder($id){
        $order_id = (int) decrypt($id);
        $orderObj = Order::Mine()->find($order_id);

        OrderDetails::find($orderObj->details_id)->delete();
        $orderObj->delete();

        return 1;
    }

    public function orderIcon()
    {
        $price = request()->input('price', '0,00');
        $distance = request()->input('distance', '0');
        return view('Home.Views.orderPriceEuroIcon')->with(compact('price', 'distance'), header('content-type', 'image/svg'));
    }
    
}
