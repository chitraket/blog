@extends('admin.layouts.app')
@section('title')Admin @endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
            <h1>Admin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Admin</li>
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
                  <h3 class="card-title">Admin</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @include('includes.messages')
              <form role="form" action="{{ route('subadmin.store')}}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
                  <div class="card-body">
                      <div class="form-row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputtagtitel1">Name</label>
                            <input type="text" class="form-control" id="exampleInputtagtitle1" name="name" placeholder="Name" required>
                        </div>
                      <div class="form-group">
                        <label for="exampleInputtagslug1">Phone</label>
                        <input type="number" class="form-control" id="exampleInputtagslug1" name="phone" placeholder="Phone" required>
                    </div>
                        <div class="form-group">
                            <label for="exampleInputtagslug1">Email</label>
                            <input type="email" class="form-control" id="exampleInputtagslug1" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputtagslug1">Password</label>
                          <input type="password" class="form-control" id="exampleInputtagslug1" name="password" placeholder="Password" required>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputtagslug1">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                    </div> <!-- form-group// --> 

                    <div class="form-group">
                      <label for="exampleInputtagslug1">About</label>
                      <textarea class="text" placeholder="About" name="about"
                          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  </div>

                        <div class="form-group">
                          <label for="exampleInputFile">User Image</label>
                          <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png" >
                                <label class="custom-file-label" id="customFiles">Choose file</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                    
                          <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="status"  id="customCheckbox100" value="1" >
                          <label for="customCheckbox100" class="custom-control-label pl-4">Status</label>
                          </div> 
                        </div>
                        </div>
                        <div class="form-group">
                          @foreach ($roles as $role)
                          <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="role[]" value="{{ $role->id }}" id="customCheckbox{{$role->id}}">
                          <label for="customCheckbox{{$role->id}}" class="custom-control-label pl-4">{{ $role->name }}</label>
                          </div> 
                          @endforeach
                        </div>
                    </div>
              </div>
                </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('subadmin.index')}}" role="button">Back</a>
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
<!-- Select2 -->
<script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script> 
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
