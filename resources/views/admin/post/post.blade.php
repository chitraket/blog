@extends('admin.layouts.app')
@section('title')Post @endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

@endsection

@section('main-content')
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1>Post</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
              <li class="breadcrumb-item active">Post</li>
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
                  <h3 class="card-title">Post</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @include('includes.messages')
              <form role="form" action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data" id="quickForm">
                {{ csrf_field()}}
                  <div class="card-body">
                      <div class="form-row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputtitel1">Post Title</label>
                            <input type="text" class="form-control" id="exampleInputtitle1" name="title" placeholder="Title" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputsubtitel1">Post Sub Title</label>
                            <input type="text" class="form-control" id="exampleInputsubtitle1" name="subtitle" placeholder="Sub Title">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputFile">Post Image</label>
                          <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="customFile" accept=".jpg,.jpeg,.png" >
                                <label class="custom-file-label" id="customFiles">Choose file</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputsubtitel1">Meta Keywords</label>
                          <input type="text" class="form-control" id="exampleInputsubtitle1" name="metakeyword" placeholder="Meta Keywords">
                      </div>
                      @can('posts.view', Auth::user())
                      <div class="form-group">
                        <div class="custom-control custom-checkbox pt-2">
                          <input class="custom-control-input" type="checkbox" name="publish" id="customCheckbox1" value="1">
                          <label for="customCheckbox1" class="custom-control-label pl-4">Publish</label>
                        </div>
                      </div>
                      @endcan
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                          <label>Post Language</label>
                          <select class="form-control" name="language" style="width: 100%;" id="sub_category_name" >
                            <option selected="selected" disabled>Select Language</option>
                            <option value="en">English</option>
                            <option value="hi">Hindi</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Post Category</label>
                          <select class="select2" multiple="multiple" id="sub_category" data-placeholder="Post Category" name="categories[]" style="width: 100%;" >
                            {{-- @foreach ($categories as $category)
                          <option value="{{$category->id}}">{{ $category->name}}</option>
                            @endforeach --}}
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Post Tags</label>
                          <select class="select2" multiple="multiple" id="sub_tag" data-placeholder="Post Tags" name="tags[]" style="width: 100%;" >
                            {{-- @foreach ($tags as $tag)
                          <option value="{{$tag->id}}">{{ $tag->name}}</option>
                            @endforeach --}}
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputsubtitel1">Meta Description</label>
                          <textarea class="text" placeholder="Meta Description" name="metadescription"
                          style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="exampleInputsubtitel1">Blog</label>
                       <textarea class="textarea" placeholder="Blog" name="body"
                          style="width: 100px; height:50px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
              </div>
              <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('post.index')}}" role="button">Back</a>
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
<script src="{{ asset('admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
{!! Toastr::message() !!}
<!-- Select2 -->
<script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
<!--ck editor-->
<script src="{{ asset('admin/plugins/ckeditor/ckeditor.js') }}"></script>
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
    $('.select2').select2();
    CKEDITOR.replace('body', {
        filebrowserUploadUrl: "{{route('post.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });

    $(document).ready(function () {
                $('#sub_category_name').on('change', function () {
                let id = $(this).val();
                $('#sub_category').empty();
                $('#sub_tag').empty();
                $.ajax({
                type: 'GET',
                url: '/postselect',
                data: {'select_id': id},
                success: function (data) {
                  var response= data.category;
                  var responses=data.tag;
                  $('#sub_category').empty();
                  $('#sub_tag').empty();
                  response.forEach(element => {
                     $('#sub_category').append(`<option value="${element['id']}">${element['name']}</option>`);
                  });
                  responses.forEach(element => {
                     $('#sub_tag').append(`<option value="${element['id']}">${element['name']}</option>`);
                  });
                  }
                  });
                });
    });
</script>
@endsection
