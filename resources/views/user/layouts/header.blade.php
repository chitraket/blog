<header class="default-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
        <a class="navbar-brand" href="{{ route('home',app()->getLocale()) }}">
        <h3>{{__('header.logo')}}</h3>
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse justify-content-end align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                <li><a href="{{ route('home',app()->getLocale()) }}">{{__('header.home')}}</a></li>
                @foreach (config('app.available_locales') as $locale)
                {{-- <li><a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$locale)}}">{{ strtoupper($locale)}}</a></li> --}}
                @endforeach
                    {{-- 
                    <li><a href="#fashion">fashion</a></li> 
                    --}}
                    <!-- Dropdown -->
                    @if (Auth::guest())
                    <li class="dropdown">
                      <a class="dropdown-toggle disabled" href="#" id="navbardrop" data-toggle="dropdown">
                        <i class="fa fa-user-circle fa-lg" aria-hidden="true"></i>
                      </a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('login',app()->getLocale()) }}">{{__('header.login')}}</a>
                        <a class="dropdown-item" href="{{ route('register',app()->getLocale()) }}">{{__('header.register')}}</a>
                      </div>
                    </li>	
                    @else
                    <li class="dropdown mr-4">
                      <a class="dropdown-toggle disabled" id="navbardrop" data-toggle="dropdown">
                        <i class="fa fa-user-circle fa-lg pr-2" aria-hidden="true"></i>{{ Auth::user()->name }}
                      </a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('logout',app()->getLocale()) }}"
                        onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                         {{ __('Logout') }}
                     </a>
                     <form id="logout-form" action="{{ route('logout',app()->getLocale()) }}" method="POST" style="display: none;">
                         @csrf
                     </form>
                      </div>
                    </li>	
                    @endif
                </ul>
                <form method="GET" action="{{ route('search',app()->getLocale()) }}">
                  <div class="input-group stylish-input-group">
                    <input type="text" class="form-control"  value="{{ isset($query) ? $query : '' }}" name="query" type="text" placeholder="{{__('header.search')}}"  required="">
                    <span class="input-group-addon ">
                        <button type="submit" class="border-0 "><span class="lnr lnr-magnifier"></span></button>  
                    </span>
                </div>
                  </form>
              </div>						
        </div>
    </nav>
</header>