<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BCustomerController extends Controller
{
    public function index()
    {
        return view('BCustomer.Views.index');
    }

}
