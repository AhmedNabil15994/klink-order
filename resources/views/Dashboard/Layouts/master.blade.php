<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        @include('Dashboard.Layouts.head')
        @yield('otherhead')
    </head>
    <body>
        
        <!--main wrapper-->
        <div class="main-wrapper view-profile">
                
            @include('Dashboard.Layouts.header')
    
            <div class="mainContent view-profile">
                @include('Dashboard.Layouts.sidebar')

                @include('Dashboard.Layouts.sidebar2')

                @yield('content')
               
                @include('Dashboard.Layouts.footer')
            </div>

            @include('Dashboard.Partials.notf_messages')

        </div>
    </body>
</html>
