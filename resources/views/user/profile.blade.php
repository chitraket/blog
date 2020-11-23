@extends('user/app')
@section('title'){{ $author->name }}@endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
@endsection
@section('main-content')
@include('includes.messages')
        <!-- Start top-section Area -->
        <section class="top-section-area section-gap">
            <div class="container">
                <div class="row justify-content-between align-items-center d-flex">
                    <div class="col-lg-8 top-left">
                    <a href="{{ route('profile',['locale'=>app()->getLocale(),'username'=>$author->username]) }}">
                    <h1 class="text-white mb-20">{{ $author->name }}</h1>
                    </a>
                        <ul>
                        <li><a href="{{ route('home',app()->getLocale()) }}">{{ __('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                        <li class="text-white">Profile</li> 
                        </ul>
                    </div>
                </div>
            </div>  
        </section>
        <!-- End top-section Area -->

<!-- Start post Area -->
<div class="post-wrapper pt-100">
    <!-- Start post Area -->
    <section class="post-area">
        <div class="container">
            <div class="row justify-content-center d-flex">
                <div class="col-lg-8">                   
                    <div class="top-posts">
                        <div class="container">
                            <div class="row justify-content-center">
                                @if($posts->count() > 0)
                                @foreach ($posts as $post)
                                <div class="single-posts col-lg-6 col-sm-6 pb-4">
                                    <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$post->slug]) }}">
                                    <img class="img-fluid"  src=" {{ url('images/post_360X220/' . $post->image) }} " alt="{{ $post->image }}"></a>
                                    <div class="date mt-20 mb-20">{{ $post->created_at->format('d M Y') }}</div>
                                    <div class="detail">
                                    <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$post->slug]) }}"><h4>{{ $post->title }}<br></h4></a>
                                    <p>{{ $post->subtitle}}</p>
                                    <p>{{Str::limit($post->meta_description, $limit =100, $end = '...')}}</p>    
                                    <p class="footer">
                                            <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $post->comments->count() }} {{__('profile.comment')}}
                                            @if (Auth::guest())
                                   <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                       closeButton: true,
                                       progressBar: true,
                                   })" class="text-dark pl-4"><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $post->favorite_post->count() }} {{__('profile.like')}}</a>
                                   @else
                                   <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();" class="text-dark pl-4">
                                       @if ($user->favorite_post()->where('post_id', $post->id)->count() == 0)
                                       <i class="fa fa-heart-o"></i>
                                       @else
                                       <i class="fa fa-heart"></i> 
                                       @endif
                                   {{ $post->favorite_post->count() }} {{__('profile.like')}}</a> 
                                    <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$post->id]) }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="admin_id" id="admin_id" value="{{ $post->admin->id }}">
                                    </form>
                                   @endif
                                           
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-lg-12 col-md-12">
                                    <div class="single-post  p-4 text-center">
                                    <h3>{{__('profile.error')}} :(</h3>
                                    </div><!-- single-post -->
                                </div><!-- col-lg-4 col-md-6 -->
                                @endif
                                <div class="justify-content-center d-flex col-lg-12 col-sm-12 pb-4">
                                   <div class="p-1">
                                   {!! $posts->links('pagination') !!}
                                   </div>
                                </div>  
                            </div> 
                        </div>
                    </div>                            
                </div>
                <div class="col-lg-4 sidebar-area">
                    <div class="single_widget about_widget">
                        <img  class="img-rounded" src="{{ url('images/admin_123X122/' . $author->image) }}" alt="">
                    <h2>{{ $author->name }}</h2>
                    <p>
                            {{$author->about}}
                        </p>
                        {{-- <div class="social-link">
                            <a href="#"><button class="btn"><i class="fa fa-facebook" aria-hidden="true"></i> Like</button></a>
                            <a href="#"><button class="btn"><i class="fa fa-twitter" aria-hidden="true"></i> follow</button></a>
                        </div> --}}
                    </div>
                    @if (isset($tags) && !$tags->isEmpty())      
                    <div class="single_widget recent_widget">
                    <h4 class="text-uppercase pb-20">{{__('profile.recentposts')}}</h4>
                        <div class="{{ $k }}recent-carusel">
                            @foreach ($tags as $item)
                            <div class="item">
                            <img  src=" {{ url('images/post_302X183/' . $item->image) }} " alt="{{ $item->image }}">
                                <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$item->slug]) }}"><p class="mt-20 title ">{{ $item->title }}</p></a>
                                <p>{{ $item->created_at->diffForHumans() }}
                                    <span> 
                                    <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $item->comments->count() }}
                                    @if (Auth::guest())
                                    <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                        closeButton: true,
                                        progressBar: true,
                                    })" class="text-dark "><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $item->favorite_post->count() }}</a>
                                    @else
                                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $item->id }}').submit();" class="text-dark ">
                                   @if ($user->favorite_post()->where('post_id', $item->id)->count() == 0)
                                   <i class="fa fa-heart-o"></i>
                                   @else
                                   <i class="fa fa-heart"></i> 
                                   @endif
                                   {{ $item->favorite_post->count() }}</a>
                                    <form id="favorite-form-{{ $item->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$item->id]) }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="admin_id" id="admin_id" value="{{ $item->admin->id }}">
                                    </form> 
                                    @endif 
                                </span></p>    
                            </div>  
                            @endforeach
                        </div>
                    </div>  
                    @endif
                    @if (isset($categorypost) && !$categorypost->isEmpty())
                    <div class="single_widget cat_widget">
                    <h4 class="text-uppercase pb-20">{{__('profile.category')}}</h4>
                        <ul>
                            @foreach ($categorypost as $categoryposts)
                            @if (!$categoryposts->posts()->count()==0)
                            <li>
                            <a href="{{ route('category',['locale'=>app()->getLocale(),'category'=>$categoryposts->slug]) }}">{{ $categoryposts->name }} <span>{{$categoryposts->posts()->count()}}</span></a>
                            </li>
                            @endif
                            @endforeach                                 
                        </ul>
                    </div>
                    @endif
                    @if (isset($post_top) && !$post_top->isEmpty())
                    <div class="single_widget recent_widget">
                        <h4 class="text-uppercase pb-20">{{__('category.topposts')}}</h4>
                        <div class="{{ $s }}recent-carusel">
                            @foreach ($post_top as $item)
                            <div class="item">
                                <img src="{{ url('images/post_302X183/' . $item->image) }}" alt="{{ $item->image }}">  
                            <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$item->slug]) }}"><p class="mt-20 title ">{{ $item->title}} </p></a>    
                            <p>{{ $item->created_at->diffForHumans() }}
                                     <span>
                                        <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $item->comments->count() }}
                                        @if (Auth::guest())
                                        <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                            closeButton: true,
                                            progressBar: true,
                                        })" class="text-dark "><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $item->favorite_post->count() }}</a>
                                        @else
                                        <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $item->id }}').submit();" class="text-dark ">
                                       @if ($user->favorite_post()->where('post_id', $item->id)->count() == 0)
                                       <i class="fa fa-heart-o"></i> {{ $item->favorite_post->count() }}</a>
                                       @else
                                       <i class="fa fa-heart"></i> {{ $item->favorite_post->count() }}</a> 
                                       @endif
                                        <form id="favorite-form-{{ $item->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$item->id]) }}" style="display: none;">
                                            @csrf
                                            <input type="hidden" name="admin_id" id="admin_id" value="{{ $item->admin->id }}">
                                        </form> 
                                        @endif 
                                     </span>
                            </p>  
                            </div>  
                            @endforeach                                                                                          
                        </div>
                    </div>   
                    @endif
                    @if (isset($tagpost) && !$tagpost->isEmpty())
                    <div class="single_widget tag_widget">
                    <h4 class="text-uppercase pb-20">{{__('profile.tag')}}</h4>
                        <ul>
                            @foreach ($tagpost as $tagposts)
                            <li>
                            <a href="{{ route('tag',['locale'=>app()->getLocale(),'tag'=>$tagposts->slug]) }}">{{ $tagposts->name }}</a>
                            </li>
                            @endforeach  
                        </ul>
                    </div>   
                    @endif                                           
                </div>
            </div>
        </div>    
    </section>
    <!-- End post Area -->  
</div>
<!-- End post Area -->


@endsection
@section('footer')
<!--Toastr-->
<script src="{{ asset('admin/plugins/toastr/toastr.js.map') }}"></script>
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
{!! Toastr::message() !!}

@endsection