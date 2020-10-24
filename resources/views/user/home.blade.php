@extends('user/app')
@section('title'){{__('header.home')}} @endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
@endsection
@section('main-content')
    <!-- start banner Area -->
    @if (isset($popular_posts) && !empty($popular_posts))
    <section class="banner-area relative" id="home" data-parallax="scroll" data-image-src="{{ url('images/post_1920X820/' . $popular_posts->image) }}">
        <div class="overlay-bg overlay"></div>
        <div class="container">
            <div class="row fullscreen">
                <div class="banner-content d-flex align-items-center col-lg-12 col-md-12">
                    <h1>
                        {{$popular_posts->title }} <br>
                        {{$popular_posts->subtitle}}								
                    </h1>
                </div>	
                <div class="head-bottom-meta d-flex justify-content-between align-items-end col-lg-12">
                    <div class="col-lg-6 flex-row d-flex meta-left no-padding">
                        <p >
                        @if (Auth::guest())
                        <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                            closeButton: true,
                            progressBar: true,
                        })" class="text-white pl-1"><i class="fa fa-heart-o text-white" aria-hidden="true"></i>  {{ $popular_posts->favorite_post_count }} {{__('main.like')}}</a>
                        @else
                        <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $popular_posts->id }}').submit();" class="text-white pl-1">
                       @if ($user->favorite_post()->where('post_id', $popular_posts->id)->count() == 0)
                       <i class="fa fa-heart-o text-white"></i>
                       @else
                       <i class="fa fa-heart text-white"></i>  
                       @endif
                       {{ $popular_posts->favorite_post_count }} {{__('main.like')}}</a>
                       <form id="favorite-form-{{ $popular_posts->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$popular_posts->id]) }}" style="display: none;">
                        @csrf
                        <input type="hidden" name="admin_id" id="admin_id" value="{{ $popular_posts->admin->id }}">
                    </form> 
                       @endif
                        </p>
                        <p><span class="lnr lnr-bubble"></span> {{ $popular_posts->comments_count }} {{__('main.comment')}}</p>
                    </div>
                    <div class="col-lg-6 flex-row d-flex meta-right no-padding justify-content-end">
                        <div class="user-meta">
                        <h4 class="text-white">{{ $popular_posts->admin->name }}</h4>
                            <p>{{ $popular_posts->created_at->format('d M Y H:i:s')}}</p>
                        </div>
                        <img class="img-fluid user-img "  src="{{ url('images/admin_40X40/' . $popular_posts->admin->image) }}" alt="">
                    </div>
                </div>												
            </div>
        </div>
    </section>
    @endif
    

<!-- End banner Area -->	
<!-- Start category Area -->
@if (isset($posts) && !$posts->isEmpty())
<section class="category-area section-gap" id="news">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-70 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">{{__('main.latestblog')}}</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua.</p>
                </div>
            </div>
        </div>						
        <div class="active-cat-carusel">
            
            @foreach ($posts as $post)
            <div class="item single-cat">
            <img class="thumbnail"  src="{{ url('images/post_360X220/' . $post->image) }}" alt="{{$post->image}}">
                <p class="date">{{ $post->created_at->format('d M Y')}}</p>
            <h4><a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$post->slug]) }}">{{ $post->title }}</a></h4>
            <p>{{Str::limit($post->meta_description, $limit =100, $end = '...')}}</p>
            <p>{{ $post->created_at->diffForHumans() }}
                <span class="pull-right">
                    <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $post->comments->count() }} {{__('main.comment')}}
                    @if (Auth::guest())
                    <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                        closeButton: true,
                        progressBar: true,
                    })" class="text-dark pl-1"><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $post->favorite_post->count() }} {{__('main.like')}}</a>
                    @else
                    <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();" class="text-dark pl-1">
                   @if ($user->favorite_post()->where('post_id', $post->id)->count() == 0)
                   <i class="fa fa-heart-o"></i>
                   @else
                   <i class="fa fa-heart"></i>  
                   @endif
                   {{ $post->favorite_post->count() }} {{__('main.like')}}</a>
                    <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$post->id]) }}" style="display: none;">
                        @csrf
                        <input type="hidden" name="admin_id" id="admin_id" value="{{ $post->admin->id }}">
                    </form> 
                    @endif 
                 </span>
            </p>
            </div>				
            @endforeach  
        </div>												
    </div>	
</section>
@endif
<!-- End category Area -->
<!-- Start travel Area -->
@if (isset($postss) && !$postss->isEmpty())
<section class="travel-area section-gap" id="travel">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-70 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">Hot topics from {{$categoriess }} </h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua.</p>
                </div>
            </div>
        </div>						
        <div class="row">
            <div class="col-lg-6 travel-left">
                @foreach ($postss as $post)
                <div class="single-travel media pb-70">
                        <img class="img-fluid d-flex  mr-3"  src="{{ url('images/post_195X180/' . $post->image) }}" alt="">
                    <div class="dates">
                        <span>{{ $post->created_at->format('d')}}</span>
                        <p>{{ $post->created_at->format('M')}}</p>
                    </div>
                    <div class="media-body align-self-center">
                      <h4 class="mt-0"><a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$post->slug]) }}">{{$post->title}}</a></h4>
                      <p>{{Str::limit($post->meta_description, $limit =150, $end = '...')}}</p>
                      <div class="meta-bottom d-flex justify-content-between">
                        <p><span class="lnr lnr-bubble"></span> {{ $post->comments->count() }} {{__('main.comment')}}</p>
                          <p> @if (Auth::guest())
                            <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                closeButton: true,
                                progressBar: true,
                            })" class="text-dark pl-1"><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $post->favorite_post->count() }} {{__('main.like')}}</a>
                            @else
                            <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();" class="text-dark pl-1">
                           @if ($user->favorite_post()->where('post_id', $post->id)->count() == 0)
                           <i class="fa fa-heart-o"></i>
                           @else
                           <i class="fa fa-heart"></i>  
                           @endif
                           {{ $post->favorite_post->count() }} {{__('main.like')}}</a>
                            <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$post->id]) }}" style="display: none;">
                                @csrf
                                <input type="hidden" name="admin_id" id="admin_id" value="{{ $post->admin->id }}">
                            </form> 
                            @endif </p>
                      </div>							 
                    </div>
                </div>	
                @endforeach 
            </div>								
            {{-- <a href="#" class="primary-btn load-more pbtn-2 text-uppercase mx-auto mt-60">Load More </a>		 --}}
        </div>
    </div>					
</section>
@endif
<!-- End travel Area -->

<!-- Start fashion Area -->
@if(isset($dates) && !$dates->isEmpty())
<section class="fashion-area section-gap" id="fashion">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-70 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">{{__('main.latestblogthisweek')}}</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore  et dolore magna aliqua.</p>
                </div>
            </div>
        </div>					
        <div class="row">
            @foreach ( $dates as $posts)
            <div class="col-lg-3 col-md-6 single-fashion">
            <img class="img-fluid" src="{{ url('images/post_263X180/' . $posts->image) }}" alt="{{ $posts->image }}">
                <p class="date">{{ $posts->created_at->format('d M y')}}</p>
                <h4><a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$posts->slug]) }}">{{ $posts->title }}<br>{{ $posts->subtitle}}</a></h4>
                <p>
                    {{Str::limit($posts->meta_description, $limit =50, $end = '...')}}
                </p>
                <div class="meta-bottom d-flex justify-content-between">
                    <p><span class="lnr lnr-bubble"></span> {{ $post->comments->count() }} {{__('main.comment')}}</p>
                    <p> @if (Auth::guest())
                        <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                            closeButton: true,
                            progressBar: true,
                        })" class="text-dark pl-1"><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $posts->favorite_post->count() }} {{__('main.like')}}</a>
                        @else
                        <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $posts->id }}').submit();" class="text-dark pl-1">
                       @if ($user->favorite_post()->where('post_id', $posts->id)->count() == 0)
                       <i class="fa fa-heart-o"></i>
                       @else
                       <i class="fa fa-heart"></i>  
                       @endif
                       {{ $posts->favorite_post->count() }} {{__('main.like')}}</a>
                        <form id="favorite-form-{{ $posts->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$posts->id]) }}" style="display: none;">
                            @csrf
                            <input type="hidden" name="admin_id" id="admin_id" value="{{ $posts->admin->id }}">
                        </form> 
                        @endif </p>
                </div>									
            </div>
            @endforeach
            {{-- <a href="#" class="primary-btn load-more pbtn-2 text-uppercase mx-auto mt-60">Load More </a>						 --}}
        </div>
    </div>	
</section>
@endif
<!-- End fashion Area -->

<!-- Start team Area -->
{{-- <section class="team-area section-gap" id="team">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-70 col-lg-8">
                <div class="title text-center">
                    <h1 class="mb-10">About Blogger Team</h1>
                    <p>Who are in extremely love with eco friendly system.</p>
                </div>
            </div>
        </div>						
        <div class="row justify-content-center d-flex align-items-center">
            <div class="col-lg-6 team-left">
                <p>
                    inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards especially in the workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach. inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards especially in the workplace. That’s why it’s crucial that.
                </p>
                <p>
                    inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards especially in the workplace. That’s why it’s crucial that, as women.
                </p>
            </div>
            <div class="col-lg-6 team-right d-flex justify-content-center">
                <div class="row active-team-carusel">
                    <div class="single-team">
                        <div class="thumb">
                            <img class="img-fluid" src="{{ asset('user/img/team1.jpg') }}" alt="">
                            <div class="align-items-center justify-content-center d-flex">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="meta-text mt-30 text-center">
                            <h4>Dora Walker</h4>
                            <p>Senior Core Developer</p>									    	
                        </div>
                    </div>
                    <div class="single-team">
                        <div class="thumb">
                            <img class="img-fluid" src="{{ asset('user/img/team2.jpg') }}" alt="">
                            <div class="align-items-center justify-content-center d-flex">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="meta-text mt-30 text-center">
                            <h4>Lena Keller</h4>
                            <p>Creative Content Developer</p>			    	
                        </div>
                    </div>													
                </div>
            </div>
        </div>
    </div>	
</section> --}}
<!-- End team Area -->
@if (isset($notfound) && !empty($notfound))
<section class="travel-area">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-10 col-lg-8">
                <div class="title text-center">
                <img class="img-fluid d-flex  mr-3" src="{{ url('images/error-not-found-page.png') }}" alt="">
                <h1 class="mb-10 m-2">{{__('main.error')}} :(</h1>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endsection
@section('footer')
<!--Toastr-->
<script src="{{ asset('admin/plugins/toastr/toastr.js.map') }}"></script>
<script src="{{ asset('admin/plugins/toastr/toastr.min.js') }}"></script>
{!! Toastr::message() !!}
@endsection