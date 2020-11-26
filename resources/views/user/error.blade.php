@extends('user/app')
@section('title'){{__('header.error')}} @endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
@endsection
@section('main-content')
@include('includes.messages')
<section class="travel-area">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-10 col-lg-8">
                <div class="title text-center">
                <img class="img-fluid d-flex  mr-3" src="{{ asset('storage/images/error-not-found-page.png') }} " alt="error-not-found-page.png">
                <h1 class="mb-10 m-2">{{__('error.errors')}} :(</h1>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer')
<!--Toastr-->
<script src="{{ asset('admin/plugins/toastr/toastr.js.map') }}"></script>
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
@endsection