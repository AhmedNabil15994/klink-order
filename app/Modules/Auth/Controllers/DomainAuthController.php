<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DomainAuthController extends Controller
{

    public function getLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect('/dashboard');
        } else {
            return view('Auth.Views.login');
        }
    }

    public function postLogin()
    {
        $input = \Input::all();
        $rules = array(
            'email' => 'required',
            'password' => 'required',
        );

        $message = array(
            'email.required' => "Sorry Email Required",
            'password.required' => "Sorry Password Required",
        );

        $validate = \Validator::make($input, $rules,$message);

        if($validate->fails()){

            \Session::flash('error', $validate->messages()->first());
            return redirect('/login');
        }

        $userObj = User::where('email',$input['email'])->first();

        if($userObj->profile->group_id == 1){
            \Session::flash('error', "Invalid Username Or Password!");
            return redirect('/login');
        }

        if (Auth::guard('web')->attempt(['email'=> $input['email'], 'password' => $input['password']])) {
            \Session::flash('success', "Welcome To Rayagate");
            return redirect('/dashboard');
        } else {
            \Session::flash('error', "Invalid Username Or Password!");
            return redirect('/login');
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/login');
    }

    public function getReset()
    {
        return view('Auth.Views.reset');
    }

    public function getRegister()
    {
        return view('Auth.Views.register');
    }

    public function index()
    {   
        $this->data['user'] = Auth::user();
        dd(Auth::user());
        //return view('welcome',$this->data);
    }

}
