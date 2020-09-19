@extends('Layouts.master')

@section('title','Reset')

@section('otherhead')
    <link rel="stylesheet" href="{{asset('assets/css/rest.css')}}"/>
@endsection

@section('class','rest-page')

@section('content')
    <div class="rest-page">
        <div class="main">
            <div class="side-left">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo3.png') }}" alt="">
                </div>
                <h3>Forgot Password</h3>
                <form>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" type="email">
                    </div>
                    <button>Reset Password</button>
                </form>
            </div>
            <div class="side-right">
                <div class="social-media">
                    <a href="{{URL::to('/register')}}" class="email"><i class="fas fa-envelope"></i> Sign up with Email</a>
                    <a href="{{URL::to('/login')}}" class="email"><i class="far fa-envelope"></i> Sign in with Email</a>
                    <a href="#" class="microsoft"><i class="fab fa-windows"></i> Sign in with Microsoft</a>
                    <a href="#" class="twitter"><i class="fab fa-twitter"></i> Sign in with Twitter</a>
                </div>
            </div>
        </div> 
    </div>
    
@endsection

@section('scripts')

@endsection
