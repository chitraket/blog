@extends('user/app')
@section('title'){{ __('header.setting')}} @endsection
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
            <h1 class="text-white mb-20">{{ __('header.setting')}}</h1>
                <ul>
                <li><a href="{{ route('home',app()->getLocale()) }}">{{ __('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                <li><a href="{{ route('user.setting',app()->getLocale())}}">{{ __('header.setting')}}</a></li>
                </ul>
            </div>
        </div>
    </div>  
</section>
<!-- End top-section Area -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content p-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ url('images/user_62X62/' . Auth::user()->image) }}"
                       alt="User profile picture">
                </div>

            <h3 class="profile-username text-center pt-2">{{ Auth::user()->name }}</h3>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="">
              <div class="p-2">
                <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#updateprofile" data-toggle="tab">{{__('setting.updateprofile')}}</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">{{__('setting.changepassword')}}</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="updateprofile">
                    @include('includes.messages')
                    <form method="POST" action="{{ route('user.profile.update',app()->getLocale()) }}" class="form-horizontal" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                      <div class="form-group">
                        <label>{{__('login.email')}}</label>
                      <h4>{{ Auth::user()->email }}</h4>
                        </div> <!-- form-group// -->
                      <div class="form-group">
                        <label>{{__('register.name')}}</label>
                        <input id="name" type="text" placeholder="{{__('register.name')}}" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ Auth::user()->name }}"  autocomplete="name" autofocus>
                        @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// -->
                        <div class="form-group">
                            <label>{{__('register.profilepicture')}}</label>
                            <input id="profile-picture" type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept=".jpg,.jpeg,.png"  autocomplete="profile-picture">
                            @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                        </div> <!-- form-group// --> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="submit" class="primary-btn load-more pbtn-2 ">
                                        {{__('setting.updateprofile')}}</
                                    </button>
                                </div> <!-- form-group// -->
                            </div>                                          
                        </div> 

                      </form>
                  </div>
                  <div class="tab-pane" id="settings">
                    <form method="POST" action="{{ route('user.passwords.update',app()->getLocale()) }}" class="form-horizontal">
                      @csrf
                      @method('PUT')
                      <div class="form-group">
                        <label>{{__('setting.oldpassword')}}</label>
                        <input id="old_passwords" type="password" placeholder="{{__('setting.oldpassword')}}" class="form-control @error('old_passwords') is-invalid @enderror" name="old_password"  autocomplete="new-password">

                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// --> 
                    <div class="form-group">
                        <label>{{__('setting.newpassword')}}</label>
                        <input id="password" type="password" placeholder="{{__('setting.newpassword')}}" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// --> 
                    <div class="form-group">
                        <label>{{__('setting.confirmpassword')}}</label>
                        <input id="password_confirmation" type="password" placeholder="{{__('setting.confirmpassword')}}" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"  autocomplete="confirmation-password">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div> <!-- form-group// --> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="primary-btn load-more pbtn-2 ">
                                    {{__('setting.updatepassword')}}
                                </button>
                            </div> <!-- form-group// -->
                        </div>                                          
                    </div> 
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.nav-tabs-custom -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection
@section('footer')
<!--Toastr-->
<script src="{{ asset('admin/plugins/toastr/toastr.js.map') }}"></script>
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
@endsection