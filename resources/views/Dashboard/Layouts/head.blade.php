<link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/ico">
<link rel="stylesheet" href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}"/>
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fa-solid.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fa-brands.min.css') }}">
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:300,500" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Rubik:400,500" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,500" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
<!--fonts-->

<!-- css file -->
<link rel="stylesheet" href="{{asset('assets/css/userDashboard.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/view_profile.css')}}">
<link rel="stylesheet" href="{{asset('assets/production/css/toastr.min.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/css/main_order.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/login_style.css')}}">
<link rel="stylesheet" href="{{ asset('assets/vendors/iCheck/skins/all.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap-editable.css')}}"/>

<style> 
  html{
      font-size:62.5%  !important;
  }
  @font-face {
    font-family: myNumberFont;
    src: url({{asset('fonts/CalibreTest-Bold.woff')}});
  }
  .myNumberFont {
      font-family: myNumberFont;
      font-weight: bold;
      letter-spacing: 1px;
  }
  .faq-page{
      padding-top: 20px;
      padding-bottom: 20px;
  }
</style>

@yield('styles')
