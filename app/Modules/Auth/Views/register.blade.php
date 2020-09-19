@extends('Layouts.master')

@section('title','Sign Up')

@section('otherhead')
    <link rel="stylesheet" href="{{asset('assets/css/sign-up.css')}}"/>
@endsection

@section('class','sign-up')

@section('content')
    <div class="sign-up">
        <div class="main">
            <div class="side-left">
                <div class="logo">
                    <img src="{{ asset('assets/images/logo3.png') }}" alt="">
                </div>
                <div class="social-media">
                    <a href="{{URL::to('login')}}" class="email"><i class="far fa-envelope"></i> Sign in with Email</a>
                    <a href="#" class="microsoft"><i class="fab fa-windows"></i> Sign in with Microsoft</a>
                    <a href="#" class="twitter"><i class="fab fa-twitter"></i> Sign in with Twitter</a>
                </div>
            </div>
            <div class="side-right">
                <h3>Sign Up</h3>
                <form>
                    <div class="col">
                        <div class="form-group">
                            <label for="fname">Frist name</label>
                            <input id="fname" type="text">
                        </div>
                        <div class="form-group">
                            <label for="lname">Last name</label>
                            <input id="lname" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" type="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Mobile</label>
                        <input id="password" type="tel">
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="input-group">
                                <input type="radio" name="gender" value="male" id="gender-male"/>
                                <label for="gender-male">Male</label>
                                <input type="radio" name="gender" value="female" id="gender-female"/>
                                <label for="gender-female">Female</label>
                            </div>
                        </div>
                        <div class="form-group select-state">
                            <label for="gender">State</label>
                            <div class="input-group">
                                <input type="radio" name="selectpick" value="company" id="company"/>
                                <label for="company">Company</label>
                                <input type="radio" name="selectpick" value="user" id="user"/>
                                <label for="user">User</label>
                                <input type="radio" name="selectpick" value="driver" id="driver"/>
                                <label for="driver">Driver</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input id="password" type="password">
                    </div>
                    <div class="checkagree">
                        <section title=".roundedOne">
                            <div class="roundedOne">
                                <input type="checkbox" value="None" id="roundedOne" name="check" checked />
                                <label for="roundedOne"></label>
                            </div>
                        </section>
                        <label for="agree">Agree to our Terms, Data Policy and Cookie Policy.</label>
                    </div>
                    <button>Sign Up</button>
                    <div>
                        <a href="{{URL::to('password/reset')}}" class="rest">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
