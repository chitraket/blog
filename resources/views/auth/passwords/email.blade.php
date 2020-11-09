@extends('user/app')
@section('title'){{ __('header.forgot')}} @endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
@endsection
@section('main-content')
<!-- Start top-section Area -->
<section class="top-section-area section-gap">
    <div class="container">
        <div class="row justify-content-between align-items-center d-flex">
            <div class="col-lg-8 top-left">
            <h1 class="text-white mb-20">{{ __('header.forgot')}}</h1>
                <ul>
                <li><a href="{{ route('home',app()->getLocale()) }}">{{ __('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                <li><a href="{{ route('password.request',app()->getLocale())}}">{{ __('header.forgot')}}</a></li>
                </ul>
            </div>
        </div>
    </div>  
</section>
<!-- End top-section Area -->
<div class="container">
    <div class="row justify-content-center p-4">
        <div class="col-md-8">

                <div class="card-body">
                    @if (session('status'))
                    {{Toastr::success(session('status')) }}
                    @endif
                    @include('includes.messages')
                    <form method="POST" action="{{ route('password.email',app()->getLocale()) }}">
                        @csrf

                        <div class="form-group">
                            <label>{{__('forgot.email')}}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{__('forgot.email')}}" required autocomplete="email" autofocus>
        
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div> <!-- form-group// -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="primary-btn load-more pbtn-2 ">
                                            {{ __('forgot.resetbtn') }}
                                        </button>
                                    </div> <!-- form-group// -->
                                </div>                                         
                            </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
<!--Toastr-->
<script src="{{ asset('admin/plugins/toastr/toastr.js.map') }}"></script>
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
@endsection
