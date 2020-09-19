<link rel="stylesheet" href="{{asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css')}}"/>
<link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/ico">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:300,500" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet">
<!--fonts-->

<!-- css file -->
<link rel="stylesheet" href="{{asset('assets/css/normalize.css')}}"/>
<link rel="stylesheet" href="{{asset('assets/production/css/toastr.min.css')}}"/>
<link rel="stylesheet" href="{{ asset('assets/production/css/swiper.min.css') }}">

<link href="{{asset('assets/css/footer-style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/slick.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/number.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/nav.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/nav_style.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/main2.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/css/main_Color.css')}}" rel="stylesheet"  data-type="themes" type="text/css">
<link href="{{asset('assets/css/fontawesome-all.min.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('assets/production/css/roundslider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/iCheck/skins/all.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">


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
