@extends('admin.layouts.app')
@section('title')Home @endsection
@section('main-content')

{{-- <div id="app">
  <example-component />
</div> --}}

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Home</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Home</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          @if (isset($posts))
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Posts</span>
                <span class="info-box-number">
                  {{ $posts->count() }} 
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          @endif
          <!-- /.col -->
          @if (isset($tag))
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tag</span>
              <span class="info-box-number">{{ $tag->count() }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          @endif
          <!-- /.col -->
          @if (isset($category))
          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="nav-icon fas fa-th"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Category</span>
              <span class="info-box-number">{{ $category->count() }}</span>
              </div>
              
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          @endif
          <!-- /.col -->
          @if (isset($user))
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">User</span>
              <span class="info-box-number">{{ $user->count() }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div> 
          @endif
          
          <!-- /.col -->
        </div>
        <!-- /.row -->

       
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Best Post</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Rank</th>
                      <th>Title</th>
                      @foreach (Auth::user()->roles as $role)
                        @if ($role->id == 4)
                        <th>Author</th>
                        @endif
                      @endforeach
                      <th>Views</th>
                      <th>Favorite</th>
                      <th>Comments</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      @foreach($popular_posts as $key=>$post)
                      <tr>
                          <td>{{ $key + 1 }}</td>
                          <td>{{ $post->title }}</td>
                          <td>
                          @foreach (Auth::user()->roles as $roles)
                          @if ($roles->id == 4)
                          @foreach ($post->admin->roles as $role)
                            @if ($role->id == 4)
                            <i class="nav-icon fas fa-user-shield mr-2"></i>  
                            @else
                            <i class="nav-icon fas fa-user mr-2"></i> 
                            @endif
                          @endforeach
                          @endif
                          @endforeach
                          {{ $post->admin->name }}</td>
                          <td>{{ $post->view_count }}</td>
                          <td>{{ $post->favorite_post_count }}</td>
                          <td>{{ $post->comments_count }}</td>
                          <td>
                          @if($post->status == 1)
                          <span class="badge badge-success">Published</span>
                                                @else
                          <span class="badge badge-danger">Pending</span>
                                                @endif
                          </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                @can('posts.create', Auth::user())
                <a href="{{ route('post.create')}}" class="btn btn-sm btn-success float-left">New Post</a>
                @endcan
                @can('posts.create','posts.update','posts.delete',Auth::user())
                <a href="{{ route('post.index') }}" class="btn btn-sm btn-secondary float-right">View Post</a>
                @endcan
              </div>
              <!-- /.card-footer -->
            </div>
            @if (isset($admin))
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Best Author</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Rank</th>
                      <th>Author</th>
                      <th>Post</th>
                      <th>Favorite</th>
                      <th>Comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      @foreach($admin as $key=>$admins)
                      <tr>
                          <td>{{ $key + 1 }}</td>
                          <td>
                          @foreach ($admins->roles as $role)
                            @if ($role->id == 4)
                            <i class="nav-icon fas fa-user-shield mr-2"></i>  
                            @else
                            <i class="nav-icon fas fa-user mr-2"></i> 
                            @endif
                          @endforeach
                          {{ $admins->name }}</td>
                          <td>{{ $admins->posts_count }}</td>
                          <td>{{ $admins->favorite_post_count }}</td>
                          <td>{{ $admins->comments_count }}</td> 
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
              </div>
              <!-- /.card-footer -->
            </div>
            @endif
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            @if (isset($total_pending_posts))
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-file"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pending Post</span>
              <span class="info-box-number">{{ $total_pending_posts }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            @endif
            <!-- /.info-box -->
            @if (isset($author_count))
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Admin</span>
              <span class="info-box-number">{{ $author_count }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            @endif
            <!-- /.info-box -->
            @if (isset($new_authors_today))
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-user-plus"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New admin</span>
              <span class="info-box-number">{{ $new_authors_today }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            @endif
            <!-- /.info-box -->
            @if (isset($comments))
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Comment</span>
              <span class="info-box-number">{{ $comments }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            @endif
            
            <!-- /.info-box -->
            <!-- /.info-box -->
            @if (isset($favorite_post))
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Favorite</span>
              <span class="info-box-number">{{ $favorite_post }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
                
            @endif
           
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection