@extends('admin.layouts.app')
@section('title')Role @endsection
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
            <h1>Role</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Role</li>
            </ol>
          </div>
          <div class="col-sm-12">
            @can('roles.create', Auth::user())
          <a class="btn btn-success float-right" href="{{ route('role.create')}}" role="button">Add New Role</a>
          </div>
          @endcan
        </div>
        
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Role</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              @can('roles.update', Auth::user())
              <th>Edit</th>
              @endcan
              @can('roles.delete', Auth::user())
              <th>Delete</th>
              @endcan
            </tr>
            </thead>
            <tbody>
            
              @foreach ($roles as $role)
              <tr>
            <td>{{ $loop->index + 1}}</td>
              <td>{{ $role->name}}</td>
              @can('roles.update', Auth::user())
              <td><a href="{{ route('role.edit',$role->id)}}"><i class="nav-icon fas fa-edit"></i></a></td>
              @endcan
              @can('roles.delete', Auth::user())
              <td>
              <form id="delete-form-{{$role->id}}" action="{{ route('role.destroy',$role->id)}}" method="POST" style="display: none">
                 {{ csrf_field() }}
                 {{ method_field('DELETE') }}
              </form>
            <a href="" onclick="deletetag({{$role->id}})"><i class="nav-icon fas fa-trash"> </i></a>
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