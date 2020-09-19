@extends('Layouts.master')

@section('title','Sign In')

@section('otherhead')
    <link rel="stylesheet" href="{{asset('assets/css/sign-in.css')}}"/>
@endsection

@section('class','sign-in')

@section('content')
    <div class="sign-in">
        <div class="main">
            <div class="side-left">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo3.png') }}" alt="">
                </div>
                <h3>Sign In</h3>
                <form method="post" action="{{URL::to('/login')}}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" name="email" type="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password">
                    </div>
                    <button>Sign In</button>
                </form>
                <div>
                    <a href="{{URL::to('password/reset')}}" class="rest">Forgot Password?</a>
                </div>
            </div>
            <div class="side-right">
                <div class="social-media">
                    <a href="{{URL::to('register')}}" class="email"><i class="far fa-envelope"></i> Sign up with Email</a>
                    <a href="#" class="microsoft"><i class="fab fa-windows"></i> Sign in with Microsoft</a>
                    <a href="#" class="twitter"><i class="fab fa-twitter"></i> Sign in with Twitter</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
