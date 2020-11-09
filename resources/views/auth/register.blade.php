@extends('user/app')
@section('title'){{ __('header.register')}} @endsection
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
            <h1 class="text-white mb-20">{{ __('header.register')}}</h1>
                <ul>
                <li><a href="{{ route('home',app()->getLocale()) }}">{{ __('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                <li><a href="{{ route('register',app()->getLocale())}}">{{ __('header.register')}}</a></li>
                </ul>
            </div>
        </div>
    </div>  
</section>
<!-- End top-section Area -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0">
                <article class="card-body">
                    @include('includes.messages')
                     <form method="POST" action="{{ route('register',app()->getLocale()) }}" enctype="multipart/form-data">
                        @csrf
                    <div class="form-group">
                        <label>{{__('register.name')}}</label>
                        <input id="name" type="text" placeholder="{{__('register.name')}}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                        @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <label>{{__('register.email')}}</label>
                        <input id="email" type="email" placeholder="{{__('register.email')}}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// --> 
                    <div class="form-group">
                        <label>{{__('register.profilepicture')}}</label>
                        <input id="profile-picture" type="file" class="form-control @error('profile_picture') is-invalid @enderror" name="profile_picture"  autocomplete="profile-picture">
                        @error('profile_picture')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// --> 
                    <div class="form-group">
                        <label>{{__('register.password')}}</label>
                        <input id="password" type="password" placeholder="{{__('register.password')}}" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// --> 
                    <div class="form-group">
                        <label>{{__('register.confirmpassword')}}</label>
                        <input id="password-confirm" type="password" placeholder="{{__('register.confirmpassword')}}" class="form-control" name="password_confirmation"  autocomplete="new-password">
                    </div> <!-- form-group// --> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="primary-btn load-more pbtn-2 ">
                                    {{ __('header.register')}}
                                </button>
                            </div> <!-- form-group// -->
                        </div>                                          
                    </div>                                                        
                </form>
                </article>
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