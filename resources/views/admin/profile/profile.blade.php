@extends('admin.layouts.app')
@section('title')Settings @endsection
@section('head')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
@endsection
@section('main-content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ url('storage/images/admin_123X122/'.Auth::user()->image) }}"
                       alt="User profile picture">
                </div>

            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

            <p class="text-muted text-center">
                @foreach (Auth::user()->roles as $roles)
                    {{ $roles->name}}
                @endforeach
                </p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                  <b>Post</b> <a class="float-right">{{ Auth::user()->posts->count() }}</a>
                  </li>
                  <li class="list-group-item">
                  <b>Likes</b> <a class="float-right">{{ Auth::user()->favorite_post->count() }}</a>
                  </li>
                  <li class="list-group-item">
                  <b>Comment</b> <a class="float-right">{{ Auth::user()->comments->count() }}</a>
                  </li>
                </ul>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                {{-- <strong><i class="fas fa-book mr-1"></i> Education</strong> --}}

                <p class="text-muted">
                  {{Auth::user()->about}}
                </p>

                

                {{-- <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr> --}}

                {{-- <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> --}}
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#updateprofile" data-toggle="tab">Update Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="updateprofile">
                    @include('includes.messages')
                    <form method="POST" action="{{ route('profile.update') }}" class="form-horizontal" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                        <div class="form-group row">
                          <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputName" name="name" value="{{Auth::user()->name }}" placeholder="Name">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail" class="col-sm-2 col-form-label">Username</label>
                          <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputEmail" name="username" value="{{ Auth::user()->username }}" placeholder="Username">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputName2" class="col-sm-2 col-form-label">Email</label>
                          <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName2" name="email" value="{{ Auth::user()->email }}" placeholder="Email">
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputSkills" class="col-sm-2 col-form-label">Phone</label>
                            <div class="col-sm-10">
                              <input type="number" class="form-control" id="inputSkills" name="phone" value="{{ Auth::user()->phone }}" placeholder="Phone">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="inputSkills" class="col-sm-2 col-form-label">Image</label>
                            <div class="col-sm-10">
                              <div class="custom-file">
                                  <input type="file" name="image" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png" >
                                  <label class="custom-file-label" id="customFiles">Choose file</label>
                              </div>
                            </div>
                          </div>
                        <div class="form-group row">
                          <label for="inputExperience" class="col-sm-2 col-form-label">About</label>
                          <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" name="about" placeholder="Experience">{{ Auth::user()->about}}</textarea>
                          </div>
                        </div>
                        
                        <div class="form-group row">
                          <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Update</button>
                          </div>
                        </div>
                      </form>
                  </div>
                  <div class="tab-pane" id="settings">
                    <form method="POST" action="{{ route('passwords.update') }}" class="form-horizontal">
                      @csrf
                      @method('PUT')
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputName" placeholder="Enter your old password"  name="old_password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputEmail" placeholder="Enter your new password" name="password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="inputEmail" placeholder="Enter your new password again" name="password_confirmation">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-success">Update</button>
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
<script type="text/javascript">
    const realfileBtn=document.getElementById("customFile");
    const customTxt=document.getElementById("customFiles");
    realfileBtn.addEventListener("change",function(){
        if(realfileBtn.value)
        {
            customTxt.innerHTML=realfileBtn.value;
        }
        else{
            customTxt.innerHTML="Choose file";
        }
    });
</script>
@endsection