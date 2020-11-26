<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
<a href="{{ route('admin.home')}}" class="brand-link">
      
      <span class="brand-text font-weight-light d-flex justify-content-center">Blogger Loop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="{{ Storage::disk('local')->url('images/admin_40X40/'.Auth::user()->image) }}" class="img-circle elevation-2" alt="{{ Auth::user()->image }}">
        </div>
        <div class="info text-center">
        <a href="{{ route('settings') }}" class="d-block">{{ Auth::user()->name }}
        </a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item {{ Request::is('admin/home*') ? 'has-treeview menu-open' : ''}}">
                <a href="{{ route('admin.home') }}" class="nav-link {{ Request::is('admin/home*') ? 'active' : ''}}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                      Home
                    </p>
                  </a>
                </li>
                @can('posts.create','posts.update','posts.delete',Auth::user())
                <li class="nav-item {{ Request::is('admin/post*') ? 'has-treeview menu-open' : ''}}">
                  <a href="{{ route('post.index') }}" class="nav-link {{ Request::is('admin/post*') ? 'active' : ''}}">
                      <i class="nav-icon fas fa-file"></i>
                      <p>
                        Post
                      </p>
                    </a>
                  </li>
                @endcan
                @can('categorys.create','categorys.update','categorys.delete',Auth::user())
          <li class="nav-item {{ Request::is('admin/category*') ? 'has-treeview menu-open' : ''}}">
            <a href="{{ route('category.index') }}" class="nav-link {{ Request::is('admin/category*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Category
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          @endcan
          @can('tags.create','tags.update','tags.delete',Auth::user())
          <li class="nav-item {{ Request::is('admin/tag*') ? 'has-treeview menu-open' : ''}}">
            <a href="{{ route('tag.index') }}" class="nav-link {{ Request::is('admin/tag*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-tag"></i>
              <p>
                Tag
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>
          @endcan
          @can('comment.delete',Auth::user())
          <li class="nav-item {{ Request::is('admin/comment*') ? 'has-treeview menu-open' : ''}}">
            <a href="{{ route('comment.index') }}" class="nav-link {{ Request::is('admin/comment*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-comment"></i>
              <p>
                Comment
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>  
          @endcan 
          @can('users.create','users.update','users.delete',Auth::user())
          <li class="nav-item {{ Request::is('admin/user*') ? 'has-treeview menu-open' : ''}}">
            <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('admin/user*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>  
          @endcan 
          @can('subadmin.create','subadmin.update','subadmin.delete','roles.create','roles.update','roles.delete','permissions.create','permissions.update','permissions.delete',Auth::user())
          <li class="nav-item {{ Request::is('admin/subadmin*') ? 'has-treeview menu-open' : ''}} {{ Request::is('admin/role*') ? 'has-treeview menu-open' : ''}} {{ Request::is('admin/permission*') ? 'has-treeview menu-open' : ''}}">
            <a href="#" class="nav-link {{ Request::is('admin/subadmin*') ? 'active' : ''}} {{ Request::is('admin/role*') ? 'active' : ''}} {{ Request::is('admin/permission*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Admin
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @can('subadmin.create','subadmin.update','subadmin.delete',Auth::user())
              <li class="nav-item">
                <a href="{{ route('subadmin.index') }}" class="nav-link {{ Request::is('admin/subadmin*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin</p>
                </a>
              </li>
              @endcan
              @can('roles.create','roles.update','roles.delete',Auth::user())
              <li class="nav-item">
                <a href="{{ route('role.index') }}" class="nav-link {{ Request::is('admin/role*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Role</p>
                </a>
              </li>
              @endcan
              @can('permissions.create','permissions.update','permissions.delete',Auth::user())
              <li class="nav-item">
                <a href="{{ route('permission.index') }}" class="nav-link {{ Request::is('admin/permission*') ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permissions</p>
                </a>
              </li>
              @endcan
            </ul>
          </li>
          @endcan
          @can('users.create','users.update','users.delete',Auth::user())
          <li class="nav-item {{ Request::is('admin/settings*') ? 'has-treeview menu-open' : ''}}">
            <a href="{{ route('settings') }}" class="nav-link {{ Request::is('admin/settings*') ? 'active' : ''}}">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <!--<span class="right badge badge-danger">New</span>-->
              </p>
            </a>
          </li>  
          @endcan 
          <li class="nav-item">
            <a href="{{ route('admin.logout') }}" class="nav-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="nav-icon fa fa-power-off"></i>
              <p>Logout</p>
            </a>
            <form id="logout-form" action="{{ route('admin.logout')}}" method="POST" style="display: none;">
              @csrf
          </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>