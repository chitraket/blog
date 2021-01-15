@extends('user/app')
@section('head')
<!--Toastr-->
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/toastr/toastr.min.css') }}">
@endsection
@section('title'){{$tag->name}} @endsection
@section('main-content')
@include('includes.messages')
        <!-- Start top-section Area -->
        <section class="top-section-area section-gap">
            <div class="container">
                <div class="row justify-content-between align-items-center d-flex">
                    <div class="col-lg-8 top-left">
                        <a href="{{ route('tag',['locale'=>app()->getLocale(),'tag'=>$tag->slug])}}">
                            <h1 class="text-white mb-20">{{ $tag->name }}</h1>
                        </a>
                        <ul>
                        <li><a href="{{ route('home',app()->getLocale()) }}">{{ __('header.home')}}</a><span class="lnr lnr-arrow-right"></span></li>
                        <li class="text-white">Tag</li>  
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
                                @foreach ($posts as $post)
                                <div class="single-posts col-lg-6 col-sm-6 pb-4">
                                    <img class="img-fluid"  src=" {{  Storage::disk('local')->url('images/post_360X220/' . $post->image) }} " alt="{{ $post->image }}">
                                    <div class="date mt-20 mb-20">{{ $post->created_at->format('d M Y') }}</div>
                                    <div class="detail">
                                    <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$post->slug]) }}"><h4>{{ $post->title }}</h4></a>
                                    <p>{{ $post->subtitle}}</p>
                                    <p>{{Str::limit($post->meta_description, $limit =100, $end = '...')}}</p>
                                        <p class="footer ">
                                            @if (Auth::guest())
                                                <a href="javascript:void(0);"  onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                                    closeButton: true,
                                                    progressBar: true,
                                                })" class="text-dark pl-1"><i class="fa fa-heart-o " aria-hidden="true"></i>  {{ $post->favorite_post->count() }} {{__('tag.like')}}</a>
                                            @else
                                                <a href="javascript:void(0);" id="addfavourites{{$post->id}}" onClick="addToFavourites({{$post->id}}, {{ $post->admin->id }}).submit();" name="addToFavourites" class="text-dark pl-1">
                                                <i id="heart{{$post->id}}" class="{{ $user->favorite_post()->where('post_id', $post->id)->count() == 0 ? 'fa fa-heart-o' : 'fa fa-heart'  }} "></i>
                                                <span id="price{{$post->id}}">{{ $post->favorite_post->count() }}</span> {{__('tag.like')}}</a>
                                            @endif
                                   <span class="pull-right">
                                    <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $post->comments->count() }} {{__('tag.comment')}}
                                    </span>    
                                        </p>
                                    </div>
                                </div>
                                @endforeach

                                <div class="justify-content-center d-flex col-lg-12 col-sm-12 pb-4">
                                   <div class="p-1">
                                   {!! $posts->links('pagination') !!}
                                   </div>
                                </div>  
                            </div> 
                        </div>
                    </div>                            
                </div>
                @if (isset($categorypost) && !$categorypost->isEmpty())
                <div class="col-lg-4 sidebar-area">
                    <div class="single_widget cat_widget">
                    <h4 class="text-uppercase pb-20">{{__('tag.category')}}</h4>
                        <ul>
                            @foreach ($categorypost as $categoryposts)
                            @if(!$categoryposts->posts()->count()==0)
                            <li>
                            <a href="{{ route('category',['locale'=>app()->getLocale(),'category'=>$categoryposts->slug]) }}">{{ $categoryposts->name }} <span>{{$categoryposts->posts()->count()}}</span></a>
                            </li>
                            @endif
                            @endforeach                                 
                        </ul>
                    </div>
                    @endif
                    @if (isset($tags) && !$tags->isEmpty())
                    <div class="single_widget recent_widget">
                        <h4 class="text-uppercase pb-20">{{__('tag.recentposts')}}</h4>
                        <div class="{{ $k }}recent-carusel">
                            @foreach ($tags as $item)
                            <div class="item">
                            <img class="h-100 w-100" src=" {{  Storage::disk('local')->url('images/post_302X183/' . $item->image) }} " alt="{{ $item->image }}">
                                <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$item->slug]) }}"><p class="mt-20 title">{{ $item->title }}</p></a>
                                <p>{{ $item->created_at->diffForHumans() }}
                                    <span> 
                                    <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $item->comments->count() }}
                                    @if (Auth::guest())
                                    <a href="javascript:void(0);"  onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                        closeButton: true,
                                        progressBar: true,
                                    })" class="text-dark"><i class="fa fa-heart-o " aria-hidden="true"></i>  {{ $item->favorite_post->count() }}</a>
                                    @else
                                    <a href="javascript:void(0);" id="addfavourites{{$item->id}}" onClick="addToFavourites({{$item->id}}, {{ $item->admin->id }}).submit();" name="addToFavourites" class="text-dark">
                                        <i id="heart{{$item->id}}" class="{{ $user->favorite_post()->where('post_id', $item->id)->count() == 0 ? 'fa fa-heart-o' : 'fa fa-heart'  }} "></i>
                                        <span id="price{{$item->id}}" class="pl-1"> {{ $item->favorite_post->count() }}</a>   
                                    @endif 
                                </span></p>    
                            </div>  
                            @endforeach
                        </div>
                    </div>  
                    @endif  
                    @if (isset($tagpost) && !$tagpost->isEmpty())
                    <div class="single_widget tag_widget">
                    <h4 class="text-uppercase pb-20">{{__('tag.tag')}}</h4>
                        <ul>
                            @foreach ($tagpost as $tagposts)
                            @if (!$tagposts->posts()->count()==0)
                            <li>
                            <a href="{{ route('tag',['locale'=>app()->getLocale(),'tag'=>$tagposts->slug]) }}">{{ $tagposts->name }}</a>
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
                            <img src="{{  Storage::disk('local')->url('images/post_302X183/' . $item->image) }}" alt="{{ $item->image }}">  
                        <a href="{{ route('post',['locale'=>app()->getLocale(),'post'=>$item->slug]) }}"><p class="mt-20 title ">{{ $item->title}} </p></a>    
                        <p>{{ $item->created_at->diffForHumans() }}
                                 <span>
                                    <i class="fa fa-comment-o" aria-hidden="true"></i> {{ $item->comments->count() }}
                                    @if (Auth::guest())
                                   
                                    <a href="javascript:void(0);"  onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                        closeButton: true,
                                        progressBar: true,
                                    })" class="text-dark"><i class="fa fa-heart-o " aria-hidden="true"></i>  {{ $item->favorite_post->count() }}</a>
                                    @else
                                    <a href="javascript:void(0);" id="addfavourites{{$item->id}}" onClick="addToFavourites({{$item->id}}, {{ $item->admin->id }}).submit();" name="addToFavourites" class="text-dark">
                                        <i id="heart{{$item->id}}" class="{{ $user->favorite_post()->where('post_id', $item->id)->count() == 0 ? 'fa fa-heart-o' : 'fa fa-heart'  }} "></i>
                                        <span id="price{{$item->id}}" class="pl-1"> {{ $item->favorite_post->count() }}</a>   
                                    @endif 
                                 </span>
                        </p>  
                        </div>  
                        @endforeach                                                                                          
                    </div>
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
<script>
    function addToFavourites(itemid, userid) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var post = itemid;
        var admin_id = userid;
        $.ajax({
            type: 'POST',
            url: '{{ route("post.favorite",["locale"=>app()->getLocale()]) }}',
            dataType: "json",
            data: {
                'post': post,
                'admin_id': admin_id,
            },
            success: function (data) {
                if(jQuery.isEmptyObject(data.success.attached)){
                    if(data.success==1){
                        $('span#price'+post).html( data.count );
                        $('i#heart'+post).removeClass('fa fa-heart-o');
                        $('i#heart'+post).addClass('fa fa-heart');
                    toastr.success('Post successfully added to your favorite list :)','Success',{
                        closeButton: true,
                        progressBar: true,
                    });
                    }
                    else{
                        $('span#price'+post).html( data.count );
                        $('i#heart'+post).addClass('fa fa-heart-o');
                        toastr.success('Post successfully removed form your favorite list :)', 'Success',{
                        closeButton: true,
                        progressBar: true,
                    });
                    }
                }
                else{
                    
                }
            },
            error: function (XMLHttpRequest) {
                // handle error
            }
        });
    }
</script>
@endsection