@extends('user/app')
@section('title'){{ $query }}@endsection
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
                <div class="row justify-content-center align-items-center d-flex">
                    <div class="col-lg-8">
                        <div id="imaginary_container"> 
                            <form method="GET" action="{{ route('search',app()->getLocale()) }}">
                            <div class="input-group stylish-input-group">
                            <input type="text" class="form-control" value="{{ isset($query) ? $query : '' }}" name="query"  placeholder="{{ $query }}" onfocus="this.placeholder = ''" onblur="this.placeholder = '{{__('header.search')}} '" required="">
                                <span class="input-group-addon">
                                    <button type="submit">
                                        <span class="lnr lnr-magnifier"></span>
                                    </button>  
                                </span>
                            </div>
                        </form>
                        </div> 
                        <p class="mt-20 text-center text-white">{{ $posts->total() }}  {{__('search.resultsfound')}} “{{ $query }}”</p>
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
                                @forelse ($posts as $post)
                                <div class="single-posts col-lg-6 col-sm-6 pb-4">
                                    <img class="img-fluid" src=" {{ url('images/post_360X220/' . $post->image) }} " alt="{{ $post->image }}">
                                    <div class="date mt-20 mb-20">{{ $post->created_at->format('d M Y') }}</div>
                                    <div class="detail">
                                    <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$post->slug]) }}"><h4 class="pb-20">{{ $post->title }}<br>
                                    {{ $post->subtitle }}</h4></a>
                                    <p>{{Str::limit($post->meta_description, $limit =100, $end = '...')}}</p>
                                        <p class="footer">
                                            <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $post->comments->count() }} Comments 
                                            @if (Auth::guest())
                                   <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                       closeButton: true,
                                       progressBar: true,
                                   })" class="text-dark pl-4"><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $post->favorite_post->count() }} Likes</a>
                                   @else
                                   <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();" class="text-dark pl-4">
                                       @if ($user->favorite_post()->where('post_id', $post->id)->count() == 0)
                                       <i class="fa fa-heart-o"></i>
                                       @else
                                       <i class="fa fa-heart"></i> 
                                       @endif
                                       {{ $post->favorite_post->count() }} Likes</a> 
                                    <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',$post->id) }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="admin_id" id="admin_id" value="{{ $post->admin->id }}">
                                    </form>
                                   @endif
                                        </p>
                                    </div>
                                </div>
                                
                                @empty 
                                <div class="col-lg-12 col-md-12">
                                    <div class="single-post  p-4 text-center">
                                    <h3>{{__('search.error')}} :(</h3>
                                    </div><!-- single-post -->
                                </div><!-- col-lg-4 col-md-6 -->
                                @endforelse

                                <div class="justify-content-center d-flex col-lg-12 col-sm-12 pb-4">
                                   <div class="p-1">
                                   {!! $posts->links('pagination') !!}
                                   </div>
                                </div>  
                            </div> 
                        </div>
                    </div>                            
                </div>
                @if ($posts->count() > 0)
                <div class="col-lg-4 sidebar-area">
                    <div class="single_widget cat_widget">
                        <h4 class="text-uppercase pb-20">Category</h4>
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
                    <div class="single_widget tag_widget">
                        <h4 class="text-uppercase pb-20">Tag</h4>
                        <ul>
                            @foreach ($tagpost as $tagposts)
                            <li>
                            <a href="{{ route('tag',['locale'=>app()->getLocale(),'tag'=>$tagposts->slug]) }}">{{ $tagposts->name }}</a>
                            </li>
                            @endforeach  
                        </ul>
                    </div>         
                    <div class="single_widget recent_widget">
                        <h4 class="text-uppercase pb-20">Recent Posts</h4>
                        <div class="{{ $k }}recent-carusel">
                            @foreach ($tags as $item)
                            <div class="item">
                            <img  src=" {{ url('images/post_302X183/' . $item->image) }} " alt="{{ $item->image }}">
                                <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$item->slug]) }}"><p class="mt-20 title">{{ $item->title }}</p></a>
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
                                    <form id="favorite-form-{{ $item->id }}" method="POST" action="{{ route('post.favorite',$item->id) }}" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="admin_id" id="admin_id" value="{{ $item->admin->id }}">
                                    </form> 
                                    @endif 
                                </span></p>    
                            </div>  
                            @endforeach
                        </div>
                    </div>                                             
                </div>
                @endif
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