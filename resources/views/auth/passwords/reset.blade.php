@extends('user/app')
@section('title'){{ __('header.reset')}} @endsection
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
            <h1 class="text-white mb-20">{{ __('header.reset')}}</h1>
                <ul>
                <li><a href="{{ route('home',app()->getLocale()) }}">{{ __('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                <li><a href="{{ route('password.request',app()->getLocale())}}">{{ __('header.reset')}}</a></li>
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
                    @include('includes.messages')
                    <form method="POST" action="{{ route('password.update',app()->getLocale()) }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <label>{{__('reset.email')}}</label>
                            <input id="email" type="email" placeholder="{{__('reset.email')}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ??  old('email') }}"  autocomplete="email">
    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div> <!-- form-group// --> 
                        <div class="form-group">
                            <label>{{__('reset.password')}}</label>
                            <input id="password" type="password" placeholder="{{__('reset.password')}}" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">
    
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div> <!-- form-group// --> 
                        <div class="form-group">
                            <label>{{__('reset.confirmpassword')}}</label>
                            <input id="password-confirm" type="password" placeholder="{{__('reset.confirmpassword')}}" class="form-control" name="password_confirmation"  autocomplete="new-password">
                        </div> <!-- form-group// --> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="primary-btn load-more pbtn-2 ">
                                        {{ __('reset.resetbtn') }}
                                    </button>
                                </div> <!-- form-group// -->
                            </div>                                         
                        </div> 
                    </form>
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
