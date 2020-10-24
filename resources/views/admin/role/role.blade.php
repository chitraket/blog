@extends('admin.layouts.app')
@section('title')Role @endsection
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
            <h1>Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Role</li>
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
                  <h3 class="card-title">Role</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @include('includes.messages')
              <form role="form" action="{{ route('role.store')}}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
                  <div class="card-body">
                      <div class="form-row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputtagtitel1">Role Name</label>
                            <input type="text" class="form-control" id="exampleInputtagtitle1" name="name" placeholder="Role Name" required>
                        </div>
                        @foreach ($permissions as $permission)
                        <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="permission[]" value="{{ $permission->id }}" id="customCheckbox{{$permission->id}}">
                        <label for="customCheckbox{{$permission->id}}" class="custom-control-label">{{ $permission->name }}</label>
                        </div> 
                        @endforeach
                    </div>
                    

              </div>
                </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('role.index')}}" role="button">Back</a>
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

@endsection
