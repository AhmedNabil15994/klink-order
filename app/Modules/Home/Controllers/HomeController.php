<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;

class HomeController extends Controller
{
    public function index()
    {
        $this->data['myOrders'] = Order::myOrders(\Request::ip());
        $this->data['adverOrders'] = Order::selectAdvirtised();
        return view('Home.Views.home',$this->data);
    }

}
