<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Paypal\Rest\ApiContext;
use \Paypal\Auth\OAuthTokenCredential;
use \PayPal\Api\Amount;
use \PayPal\Api\Details;
use \PayPal\Api\Item;
use \PayPal\Api\ItemList;
use \PayPal\Api\Payer;
use \PayPal\Api\Payment;
use \PayPal\Api\RedirectUrls;
use \PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

use App\Models\Order;
use App\Models\OrderOffers;
use App\Models\Variables;

class PaypalController extends Controller
{
    private $apiContext;
    private $secret;
    private $client_id;

    public function __construct()
    {
        $payPalMode = Variables::getVar('PAYPAL_MODE');
        if($payPalMode == 'live'){
            $this->client_id = Variables::getVar('PAYPAL_LIVE_CLIENT_ID');
            $this->secret = Variables::getVar('PAYPAL_LIVE_SECRET');
        }else if($payPalMode == 'sandbox'){
            $this->client_id = Variables::getVar('PAYPAL_SANDBOX_CLIENT_ID');
            $this->secret = Variables::getVar('PAYPAL_SANDBOX_SECRET');
        }

        $paypal_setting = [
            'mode'  => env('PAYPAL_MODE', $payPalMode),
            'http.ConnectionTimeOut'    => 3000,
            'log.LongEnabled'   => true,
            'log.FileName'  => storage_path().'/logs/paypal.log',
            'log.LogLevel'  => 'DEBUG',
        ];

        $this->apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($this->client_id, $this->secret));
        $this->apiContext->setConfig($paypal_setting);
    }

    public function createUser($email)
    {
        $user = User::where('email', $email)->first();
        $sender = Senders::where('email', $email)->first();

        if (!isset($user)) {
            $newUser = User::create([
                'email' => $email,
                'password' => bcrypt('user123456'),
                'name'=> $sender->first_name.' '.$sender->nick_name

            ]);
            $id = $newUser->id;
            $expireDate = Carbon::today()->addWeeks(1)->toDateString();


            $charset = "0123456789";
            $base = strlen($charset);
            $result = '';

            $now = explode(' ', microtime())[1];
            while ($now >= $base) {
                $i = $now % $base;
                $result = $charset[$i] . $result;
                $now /= $base;
            }
            $code = substr($result, -5);

            $role = Role::where('name', 'user')->first();
            Userroles::create([
                'role_id'=> $role->id,
                'user_id'=> $id
            ]);
            Profile::create([
                'user_id' => $id,
                'first_name' => $sender->first_name,
                'last_name' => $sender->nick_name,
                'company' => $sender->company,
                'phone' => $sender->phone,
                'address' => $sender->street.' '.$sender->home,
                'district' => $sender->town,
                'postal_code' => $sender->postal_code,
                'country' => $sender->country,
                'status' => 'User',
                'user_status_id' => 1,  // active
                'expire_date' => $expireDate,
                'pin' => $code,
            ]);

            Userlinks::create(['user_id' => $id]);
            Userbanks::create(['user_id' => $id]);
        }
    }
    public function sendInvoice($id)
    {
        //$id = $request->id;
        $order_id = Crypt::decrypt($id);
        $sender = Senders::where('order_id', $order_id)->first();
        $email = $sender->email;
        $name = $sender->first_name.' '.$sender->nick_name;
        
        $RegisterEmail = Emails::where('title', '=', 'Invoice')->first();

        $data = [
            'name' => $name,
            'id'=> $id,
            'order_id'=> $order_id,
            
        ];
        $GeneratedEmail = $RegisterEmail->parse($data);

        $data = [
            'no-reply' => 'admin@kurier-link.com',
            'name'     => 'Kurier link click to transport',
            'subject'    => $GeneratedEmail[0],
            'content'    => $GeneratedEmail[1],
            'email'    => $email,
            'order_id'    => $id,
            'url'     => url('/order/invoice/download_pdf', $id),
        ];
        \Mail::send(
            'frontend.emails.mail2',
            ['data' => $data],
            function ($message) use ($data) {
                $message
                    ->from($data['no-reply'], $data['name'])
                    ->to($data['email'])->subject($data['subject']);
            }
        );

        return 1;
    }

    public function pay($code)
    {   
        $orderObj = \App\Models\Order::getOne($code);
        
        if($orderObj == null){
            abort(404);
        }
        
        $cost = $orderObj->price;
        $input = \Request::all();

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        $item1 = new Item();
        $item1->setName('Invoice Nr: '.$code)
            ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice($cost);

        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($cost);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription('Invoice Nr: '.$code);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(\URL::to('/orders/lastSteps/'.$code.'/paypal_success/'.(int)$input['payment_type']))
                    ->setCancelUrl(\URL::to('/orders/lastSteps/'.$code.'/paypal_failure'));

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));
            

        try {
            $payment->create($this->apiContext);
        } catch (Exception $ex) {
            exit(1);
        }

        $approvalUrl = $payment->getApprovalLink();

        return redirect($approvalUrl);
    }


    public function paypal_success(Request $request, $code,$type)
    {
        if (empty($request->input('PayerID')) || empty($request->input('token'))) {
            die('Payment Failed');
        }
        $orderObj = Order::NotDeleted()->where('code',$code)->first();

        if($orderObj == null){
            abort(404);
        }

        $payment_id  = $request->get('paymentId');

        $payment = Payment::get($payment_id, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));
        $result = $payment->execute($execution, $this->apiContext);

        if ($result->getState() == 'approved') {

            $orderObj->paid = $orderObj->cost;
            $orderObj->status = 5;
            $orderObj->save();

            $detailsObj = OrderOffers::where('order_id',$orderObj->id)->where('user_accepted',1)->first();
            $detailsObj->payment_type = $type;
            $detailsObj->save();

            \Session::flash('success', 'Payment Done Successfully \n Invoice Sent To your Mail');
            return redirect()->to("/");

            // //$this->sendInvoice($encrypt);
            // $sender = Senders::where('order_id', $id)->first();
            // $email = $sender->email;
            // $this->createUser($email);
            // $user = User::where('email', $email)->first();
            // Session::flash('message', "Success \n Payment Done Successfully \n Invoice was Sent To your Mail");
            // return redirect()->route("forceLogin", ['user'=>$user]);
        }

        echo 'Payment Failed';

        die($result);
    }

    public function paypal_cancel(Request $request)
    {
        return 'Payment Cancelled, No Worries !! :)';
    }

    public function sendCode($id)
    {
        //$id = $request->id;
        $order_id = Crypt::decrypt($id);
        $offer = Offer::where('order_id', $order_id)->where('is_accepted', 1)->first();
        $user = $offer->user_id;
        $profile = Profile::where('user_id', $user)->first();
        $name = $profile->first_name.' '.$profile->last_name;
        $RegisterEmail = Emails::where('title', '=', 'ReferenceCode')->first();
        $normal = User::find($user);
        $email = $normal->email;
        $data = [
            'name' => $name,
            'id'=> $id,
            'order_id'=> $order_id,
            
        ];
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base) {
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        $code = substr($result, -5);
        $GeneratedEmail = $RegisterEmail->parse($data);

        $order = Order::find($order_id);
        $order->code = $code;
        $order->save();

        $data = [
            'no-reply' => 'admin@kurier-link.com',
            'name'     => 'Kurier link click to transport',
            'subject'    => $GeneratedEmail[0],
            'content'    => $GeneratedEmail[1],
            'email'    => $email,
            'code'    => $code,
            'order_id'    => $id,
            'url'     => url('/order/reference/download_pdf', $id),
        ];
        \Mail::send(
            'frontend.emails.mail2',
            ['data' => $data],
            function ($message) use ($data) {
                $message
                    ->from($data['no-reply'], $data['name'])
                    ->to($data['email'])->subject($data['subject']);
            }
        );

        return 1;
    }
}
