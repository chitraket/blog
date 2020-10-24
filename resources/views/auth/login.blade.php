@extends('user/app')
@section('title'){{ __('header.login')}} @endsection
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
            <h1 class="text-white mb-20">{{ __('header.login')}}</h1>
                <ul>
                <li><a href="{{ route('home',app()->getLocale()) }}">{{ __('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                <li><a href="{{ route('login',app()->getLocale())}}">{{ __('header.login')}}</a></li>
                </ul>
            </div>
        </div>
    </div>  
</section>
<!-- End top-section Area -->

<div class="container">
    <div class="row justify-content-center p-4">
        <div class="col-md-8">
            <div class="card border-0">
                <article class="card-body">
                    @include('includes.messages')
                     <form method="POST" action="{{ route('login',app()->getLocale()) }}">
                        @csrf
                    <div class="form-group">
                    <label>{{__('login.email')}}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="{{__('login.email')}}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <label>{{__('login.password')}}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{__('login.password')}}" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div> <!-- form-group// --> 
                    <div class="form-group"> 
                    <div class="checkbox">
                      
                        <label class="form-check-label" for="remember">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{__('login.rememberme')}}
                        </label>
                      
                    </div> <!-- checkbox .// -->
                    </div> <!-- form-group// -->  
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="primary-btn load-more pbtn-2 ">
                                    {{ __('header.login') }}
                                </button>
                            </div> <!-- form-group// -->
                        </div>
                        {{-- <div class="col-md-6 text-right">
                            
                            @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                        </div>                                             --}}
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