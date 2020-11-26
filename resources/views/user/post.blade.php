@extends('user/app')
@section('title'){{$post->title}} @endsection
@section('keywords'){{$post->meta_keyword}}@endsection
@section('description'){{$post->meta_keyword }}@endsection
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
<!--prism-->
<link rel="stylesheet" href="{{ asset('user/css/prism.css') }}">
<style>
.tabcontent {
  display: none;
  padding: 6px 12px;
}
</style>
@endsection
@section('main-content')
@include('includes.messages')
    <!-- Start top-section Area -->
    <section class="top-section-area section-gap">
        <div class="container">
            <div class="row justify-content-between align-items-center d-flex">
                <div class="col-lg-8 top-left">
                    <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$post->slug]) }}">
                        <h1 class="text-white mb-20 ">{{ $post->title}}</h1>
                    </a>
                <ul>
                    <li><a href="{{ route('home',app()->getLocale())}}">{{__('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                    <li class="text-white">Category <span class="lnr lnr-arrow-right"></span></li>  
                        @foreach ($post->categories as $category)
                        @if ($loop->first) 
                        @else
                        <span class="fa fa-dot-circle-o" style="color:white"></span>
                        @endif
                        <li class="m-2"><a href="{{ route('category',['locale'=>app()->getLocale(),'category'=>$category->slug])}}">{{ $category->name }} </a></li>
                        @endforeach    
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
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="single-page-post">
                    @if (!empty($post->image))
                        <img class="img-fluid" src="{{  Storage::disk('local')->url('images/post_752X353/' . $post->image) }}" alt="{{ $post->image}} ">
                    @endif
                    <div class="top-wrapper ">
                        <div class="row d-flex justify-content-between">
                            <h2 class="col-lg-8 col-md-12 ">
                                {{ $post->title }}
                            </h2>
                        <p class="col-lg-8 col-md-12 date pt-2">{{ $post->subtitle }}</p>
                           
                            <div class="col-lg-4 col-md-12 right-side d-flex justify-content-end">
                                <div class="desc">
                                    <a href="{{ route('profile',['locale'=>app()->getLocale(),'username'=>$post->admin->username])}}"><h2>{{ $post->admin->name }}</h2></a>
                                <h3>{{ $post->created_at->diffForHumans() }}</h3>
                                </div>
                                <div class="user-img">
                                    <img  src="{{  Storage::disk('local')->url('images/admin_40X40/' . $post->admin->image) }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="single-post-content">
                        <div class="single-page-post lead col-md-12 panel-body">
                        {!! htmlspecialchars_decode($post->body) !!}
                        </div>
                    </div>
                    <div class="tags">
                        <ul>
                            <li>
                                @foreach ($post->tags as $tag)
                                <a href="{{ route('tag',['locale'=>app()->getLocale(),'tag'=>$tag->slug])}}">{{ $tag->name }} </a>
                                @endforeach    
                            </li>
                        </ul>
                    </div>
                    <div class="bottom-wrapper">
                        <div class="row">
                            <div class="col-lg-1 single-b-wrap col-md-12">

                                @if (Auth::guest())
                                <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                    closeButton: true,
                                    progressBar: true,
                                })" class="text-dark"><i class="fa fa-heart-o" aria-hidden="true"></i> {{ $post->favorite_post->count() }}</a>
                                @else
                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();" class="text-dark">
                                   
                                <i class="fa fa-heart{{$c}}"></i>
                                    {{ $post->favorite_post->count() }}</a>
                                 <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',['locale'=>app()->getLocale(),'post'=>$post->id]) }}" style="display: none;">
                                     @csrf
                                     <input type="hidden" name="admin_id" id="admin_id" value="{{ $post->admin->id }}">
                                 </form>
                                @endif
                            
                            </div>
                            <div class="col-lg-1 single-b-wrap col-md-12">
                                <i class="fa fa-comment-o" aria-hidden="true"></i> {{$post->comments()->count()}}
                            </div>
                            <div class="col-lg-2 single-b-wrap col-md-12">
                                <i class="fa  fa-eye" aria-hidden="true"></i> {{$post->view_count}}
                            </div>
                            <div class="col-lg-8 single-b-wrap col-md-12">
                                {{-- <ul class="social-icons">
                                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
                                </ul> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Start nav Area -->
                    @if ($previous!="" || $next!="")
                    <section class="nav-area pt-50 pb-100">
                        <div class="container">
                            <div class="row justify-content-between">
                                @if (isset($previous))
                                <div class="col-sm-6 nav-left justify-content-start d-flex">
                                    <div class="thumb">
                                        <img src="{{  Storage::disk('local')->url('images/post_62X62/' . $previous->image) }}" alt="">
                                    </div>
                                    <div class="details">
                                        <p>Prev Post</p>
                                    <h4><a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$previous->slug])}}">{{ $previous->title }}</a></h4>
                                    </div>
                                </div> 
                                   @else
                                   <div class="col-sm-6 nav-left justify-content-start d-flex">
                                   </div>
                                @endif

                                @if (isset($next))
                                <div class="col-sm-6 nav-right justify-content-end d-flex">
                                    <div class="details">
                                        <p>Next Post</p>
                                    <h4><a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$next->slug]) }}">{{ $next->title }}</a></h4>
                                    </div>             
                                    <div class="thumb">
                                    <img  src="{{  Storage::disk('local')->url('images/post_62X62/' . $next->image) }}" alt="{{ $next->image }}">
                                    </div>                         
                                </div>
                                    @else
                                    <div class="col-sm-6 nav-right justify-content-start d-flex">
                                    </div>
                                @endif
                            </div>
                        </div>    
                    </section>     
                    @else

                    @endif

                    <!-- End nav Area -->
                
                    <!-- Start comment-sec Area -->
                    @if ($post->comments->count() == 0)

                    @else
                    <section class="comment-sec-area pt-80 pb-80">
                        <div class="container">
                            <h5 class="text-uppercase pb-80">{{ $post->comments->count()}} {{__('post.comment')}}</h5>
                            <br>
                           @foreach ($post->comments  as $comment)
                           <div class="row flex-column">
                            <div class="comment-list">
                                <div class="single-comment justify-content-between d-flex">
                                    <div class="user justify-content-between d-flex">
                                        <div class="thumb">
                                            <img  src="{{  Storage::disk('local')->url('images/user_62X62/' . $comment->user->image) }}" alt="">
                                        </div>
                                        <div class="desc">
                                            <h5><a href="#">{{$comment->user->name}}</a></h5>
                                            <p class="date">{{ $comment->created_at->diffForHumans()}}</p>
                                            
                                            <p class="comment">
                                                {{ $comment->comment }}
                                            </p>
                                        </div>
                                    </div>
                                    @if (Auth::guest())
                                        
                                        @else
                                        <div class="reply-btn tab">
                                        <button class="btn-reply text-uppercase tablinks"  onclick="myFunction(event,'{{$comment->id}}')" type="submit">{{ __('post.reply')}}</button>
                                        </div>
                                    @endif 
                                </div>
                            @if (Auth::guest())
                                
                            @else
                            <div id="{{$comment->id}}" class="tabcontent">
                                <div class="col-sm-12">
                                    <form method="post" action="{{ route('reply.store',['locale'=>app()->getLocale(),'post'=>$post->id]) }}">
                                        @csrf
                                        
                                    <textarea name="reply" rows="2" class="text-area-messge form-control"
                                    placeholder="{{__('post.enteryourreply')}}" aria-required="true" aria-invalid="false" required></textarea >
                                <input type="hidden" class="cid" name="cid" value="{{ $comment->id }}">
                                <input type="hidden" name="admin_id" id="admin_id" value="{{ $post->admin->id }}">
                                </div><!-- col-sm-12 -->
                                <div class="col-sm-12 pt-2">
                                <button class="primary-btn load-more pbtn-2" type="submit" id="form-submit">{{__('post.submit')}}</button>
                                </div><!-- col-sm-12 -->
                            </form>
                            </div>
                        </div>      
                            @endif
                            
                            @foreach ($post->replys as $rep)
                                @if ($comment->id == $rep->comment_id)
                                <div class="comment-list left-padding">
                                    <div class="single-comment justify-content-between d-flex">
                                        <div class="user justify-content-between d-flex">
                                            <div class="thumb">
                                                <img  src="{{  Storage::disk('local')->url('images/user_62X62/' . $rep->user->image) }}" alt="">
                                            </div>
                                            <div class="desc">
                                            <h5><a href="#">{{ $rep->user->name }}</a></h5>
                                                <p class="date">{{ $rep->created_at->diffForHumans()}}</p>
                                                <p class="comment">
                                                    {{$rep->reply}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif                                
                            @endforeach 
                                                                                                                                                                                     
                        </div>
                           @endforeach
                        </div>    
                    </section>
                    @endif
                    
                      <!-- End comment-sec Area -->
                    @if (Auth::guest())


                    @else
                    <!-- Start commentform Area -->
                    <section class="commentform-area  pb-120 pt-80 mb-100">
                        <div class="container">
                        <h5 class="text-uppercas pb-50">{{__('post.addcomment')}}</h5>
                            <div class="row flex-row d-flex">
                                <div class="col-md-12">
                                    <form method="post" action="{{ route('comment.store',['locale'=>app()->getLocale(),'post'=>$post->id]) }}">
                                        @csrf
                                            <input type="hidden" name="admin_id" id="admin_id" value="{{ $post->admin->id }}">
                                            <div class="col-sm-12">
                                                <textarea name="comment" rows="2" class="text-area-messge form-control"
                                                          placeholder="{{__('post.enteryourcomment')}}" aria-required="true" aria-invalid="false"></textarea >
                                            </div><!-- col-sm-12 -->
                                            <div class="col-sm-12 pt-2">
                                                <button class="primary-btn load-more pbtn-2" type="submit" id="form-submit">{{__('post.submit')}}</button>
                                            </div><!-- col-sm-12 -->
                                        
                                    </form>
                                </div>
                            </div>
                        </div>    
                    </section>
                    <!-- End commentform Area -->
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4 sidebar-area ">
                <div class="single_widget about_widget">
                    <img  class="img-rounded" src="{{  Storage::disk('local')->url('images/admin_123X122/' . $post->admin->image) }}" alt="">
                    <a href="{{ route('profile',['locale'=>app()->getLocale(),'username'=>$post->admin->username])}}"> <h2 class="">{{ $post->admin->name }}</h2></a>
                    <p>
                        {{$post->admin->about}}
                    </p>
                    {{-- <div class="social-link">
                        <a href="#"><button class="btn"><i class="fa fa-facebook" aria-hidden="true"></i> Like</button></a>
                        <a href="#"><button class="btn"><i class="fa fa-twitter" aria-hidden="true"></i> follow</button></a>
                    </div> --}}
                </div>
                @if (isset($posts) && !$posts->isEmpty())
                <div class="single_widget recent_widget">
                    <h4 class="text-uppercase pb-20">{{__('post.recentposts')}}</h4>
                    <div class="{{ $k }}recent-carusel">
                        @foreach ($posts as $item)
                        <div class="item">
                            <img src="{{  Storage::disk('local')->url('images/post_302X183/' . $item->image) }}" alt="{{ $item->image }}">  
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
                @if (isset($categorypost) && !$categorypost->isEmpty())
                <div class="single_widget cat_widget">
                    <h4 class="text-uppercase pb-20">{{__('post.category')}}</h4>
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
                    <h4 class="text-uppercase pb-20">{{__('post.topposts')}}</h4>
                    <div class="{{ $s }}recent-carusel">
                        @foreach ($post_top as $item)
                        <div class="item">
                            <img src="{{  Storage::disk('local')->url('images/post_302X183/' . $item->image) }}" alt="{{ $item->image }}">  
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
                    <h4 class="text-uppercase pb-20">{{__('post.tag')}}</h4>
                    <ul>
                        @foreach ($tagpost as $tagposts)
                        <li>
                        <a href="{{ route('tag',['locale'=>app()->getLocale(),'tag'=>$tagposts->slug]) }}">{{ $tagposts->name }}</a>
                        </li>
                        @endforeach 
                    </ul>
                </div> 
                @endif   
                @if (isset($random) && !$random->isEmpty())
                <div class="single_widget recent_widget">
                    <h4 class="text-uppercase pb-20">{{__('post.recommendedposts')}}</h4>
                    <div class="{{ $r }}recent-carusel">
                        @foreach ($random as $item)
                        <div class="item">
                            <img src="{{  Storage::disk('local')->url('images/post_302X183/' . $item->image) }}" alt="{{ $item->image }}">  
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
                @if (isset($dates) && !$dates->isEmpty())
                <div class="single_widget cat_widget">
                    <h4 class="text-uppercase pb-20">{{__('post.category')}}</h4>
                    <ul>
                        @foreach ($dates as $date)
                                <li>
                                <a href="{{ route('date',['locale'=>app()->getLocale(),'year'=>$date->year,'month'=>$date->month]) }}">{{ $date->month_name }} , {{ $date->year }} <span> {{ $date->data }}</span></a>
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
<script src="{{ asset('user/js/prism.js') }}"></script>
<script>
    function myFunction(evt, cityName){
        var i, tabcontent, tablinks;
        tabcontent=document.getElementsByClassName('tabcontent');
        for(i = 0 ; i < tabcontent.length; i++)
        {
            tabcontent[i].style.display="none";
        }
        tablinks=document.getElementsByClassName('tablinks');
        for(i = 0;i < tablinks.length; i++)
        {
            tablinks[i].className=tablinks[i].className.replace(" active","");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className +="active";
    }
    </script>
@endsection