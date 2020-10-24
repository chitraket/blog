@extends('admin.layouts.app')
@section('title')Tag @endsection
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
            <h1>Tag</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Tag</li>
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
                  <h3 class="card-title">Tag</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @include('includes.messages')
              <form role="form" action="{{ route('tag.update',$tag->id)}}" method="POST">
               {{ csrf_field() }}
               {{ method_field('PATCH') }}
                  <div class="card-body">
                      <div class="form-row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputtagtitel1">Tag Title</label>
                            <input type="text" class="form-control" id="exampleInputtagtitle1" name="title" placeholder="Tag Title" value="{{$tag->name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputtagslug1">Tag Slug</label>
                        <input type="text" class="form-control" id="exampleInputtagslug1" name="slug" placeholder="Tag Slug" value="{{$tag->slug}}">
                        </div>
                        <div class="form-group">
                          <label>Tag Language</label>
                          <select class="form-control"  name="language" style="width: 100%;" id="sub_category_name">
                            <option value="en"
                            @if ($tag->language=="en")
                                selected
                            @endif>en</option>
                            <option value="hi"
                            @if ($tag->language=="hi")
                                selected
                            @endif>hi</option>
                          </select>
                        </div>
                    </div>
                    
              </div>
                </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <div class="float-right">
                    <a class="btn btn-secondary" href="{{ route('tag.index')}}" role="button">Back</a>
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
@endsection