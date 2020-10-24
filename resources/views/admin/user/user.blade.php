@extends('admin.layouts.app')
@section('title')User @endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
@section('main-content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">User</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @include('includes.messages')
              <form role="form" action="{{ route('user.store')}}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
                  <div class="card-body">
                      <div class="form-row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputtagtitel1">User Name</label>
                            <input type="text" class="form-control" id="exampleInputtagtitle1" name="name" placeholder="User Name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtagslug1">User Email</label>
                            <input type="email" class="form-control" id="exampleInputtagslug1" name="email" placeholder="User Email" required>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputtagslug1">User Password</label>
                          <input type="password" class="form-control" id="exampleInputtagslug1" name="password" placeholder="User Password" required>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputtagslug1">User Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="User Confirm Password" required autocomplete="new-password">
                    </div> <!-- form-group// --> 
                        <div class="form-group">
                          <label for="exampleInputFile">User Image</label>
                          <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png" >
                                <label class="custom-file-label" id="customFiles">Choose file</label>
                            </div>
                          </div>
                        </div>
                    </div>
              </div>
                </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('user.index')}}" role="button">Back</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- ./row -->
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
