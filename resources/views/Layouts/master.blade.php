<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        @include('Layouts.head')
        @yield('otherhead')
    </head>
    <body>
        
        <!--wrapper-->
        <div class="wrapper">
                
            @include('Layouts.header')

            @yield('content')
           
            @include('Layouts.footer')

            @include('Partials.notf_messages')

        </div>
    </body>
</html>
