@extends('admin.layouts.app')
@section('title')Permission @endsection
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
              <h1>Permission</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                <li class="breadcrumb-item active">Permission</li>
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
                    <h3 class="card-title">Permission</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  @include('includes.messages')
                <form role="form" action="{{ route('permission.update',$permissions->id)}}" method="POST" enctype="multipart/form-data">
                 {{ csrf_field() }}
                 {{ method_field('PATCH') }}
                    <div class="card-body">
                        <div class="form-row">
                          <div class="col-md-12">
                          <div class="form-group">
                              <label for="exampleInputtagtitel1">Permission</label>
                          <input type="text" class="form-control" id="exampleInputtagtitle1" name="name" placeholder="Permission"  value="{{ $permissions->name }}"required>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Permission For</label>
                          <select class="form-control select2" name="fors" style="width: 100%;">
                            <option selected disabled>Select Permission For</option>
                            <option value="user">User</option>
                            <option value="post">Post</option>
                            <option value="other">Other</option>
                          </select>
                        </div>
                        </div>
                </div>
                  </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <div class="float-right">
                      <a class="btn btn-secondary" href="{{ route('permission.index')}}" role="button">Back</a>
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
