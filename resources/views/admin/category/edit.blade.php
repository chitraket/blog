@extends('admin.layouts.app')
@section('title')Category @endsection
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
            <h1>Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
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
                  <h3 class="card-title">Category</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @include('includes.messages')
              <form role="form" action="{{ route('category.update',$category->id) }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('PATCH') }}
                  <div class="card-body">
                      <div class="form-row">
                        <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputcategorytitel1">Category Title</label>
                            <input type="text" class="form-control" id="exampleInputcategorytitle1" name="title" placeholder="Category Title" value="{{$category->name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputcategoryslug1">Category Slug</label>
                        <input type="text" class="form-control" id="exampleInputcategoryslug1" name="slug" placeholder="Category Slug" value="{{ $category->slug}}">
                        </div>
                        <div class="form-group">
                          <label>Category Language</label>
                          <select class="form-control"  name="language" style="width: 100%;" id="sub_category_name">
                            <option value="en"
                            @if ($category->language=="en")
                                selected
                            @endif>en</option>
                            <option value="hi"
                            @if ($category->language=="hi")
                                selected
                            @endif>hi</option>
                          </select>
                        </div>
                    </div>
                    
              </div>
              <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('category.index')}}" role="button">Back</a>
                <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </div>
                  <!-- /.card-body -->
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