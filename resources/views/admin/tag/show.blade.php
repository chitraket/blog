@extends('admin.layouts.app')
@section('title')Tag @endsection
@section('head')
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
@endsection
@section('main-content')
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
          <div class="col-sm-12">
          @can('tags.create', Auth::user())
            <a class="btn btn-success float-right" href="{{ route('tag.create')}}" role="button">Add New Tag</a>
          @endcan
          </div>
        </div>
        
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Tag</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No</th>
              <th>Tag Name</th>
              <th>Slug</th>
              @can('tags.update', Auth::user())
              <th>Edit</th>
              @endcan
              @can('tags.delete', Auth::user())
              <th>Delete</th>
              @endcan
            </tr>
            </thead>
            <tbody>
            
              @foreach ($tags as $tag)
              <tr>
            <td>{{ $loop->index + 1}}</td>
              <td>{{ $tag->name}}</td>
              <td>{{ $tag->slug}}</td>
              @can('tags.update', Auth::user())
              <td><a href="{{ route('tag.edit',$tag->id)}}"><i class="nav-icon fas fa-edit"></i></a></td>
                @endcan
                @can('tags.delete', Auth::user())
                <td>
                  <form id="delete-form-{{$tag->id}}" action="{{ route('category.destroy',$tag->id)}}" method="POST" style="display: none">
                     {{ csrf_field() }}
                     {{ method_field('DELETE') }}
                  </form>
                  <a href="" onclick="deletetag({{$tag->id}})"><i class="nav-icon fas fa-trash"></i></a>
                  </td>
                @endcan 
            </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
@endsection
@section('footer')
    <!-- DataTables -->
<script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin/plugins/toastr/toastr.js.map') }}"></script>
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
  function deletetag(id) {
    event.preventDefault();
    swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    event.preventDefault();
    document.getElementById('delete-form-'+id).submit();
   
  } else {
    swal("Cancelled","Your data is safe!",{
      icon: "error",
    });
  }
});
  }
</script>
@endsection