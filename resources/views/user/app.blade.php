<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('user/layouts/head')
    </head>
    <body>

        <!-- Start Header Area -->
        @include('user/layouts/header')
        <!-- End Header Area -->

        @section('main-content')
            
        @show
        
        <!-- start footer Area -->		
        @include('user/layouts/footer')
    </body>
</html>