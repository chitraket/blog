<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\user\post;
use App\Model\user\tag;
use App\Model\user\category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\user\favorite_post;
use App\Model\admin\admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App;
class PostController extends Controller
{
    //
    public function allpost(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $posts=post::where(['status'=>1,'language'=>$request->locale])->paginate(6);
        $user=Auth::user();
        if (count($posts) !=0 ) {
            $tagpost=tag::where('language',$request->locale)->get();
            $categorypost=category::where('language',$request->locale)->get();
            $categorys=post::where(['status'=>1,'language'=>$request->locale])->orderBy('created_at', 'desc')->take(4)->get();
            $post_top = post::withCount('comments')
                                ->withCount('favorite_post')
                                ->orderBy('view_count','desc')
                                ->orderBy('comments_count','desc')
                                ->orderBy('created_at', 'desc')
                                ->orderBy('favorite_post_count','desc')
                                ->take(4)->get();

            foreach ($categorys as $key => $items) {
                if ($key>0) {
                     $k="active-";
                } 
                else {
                    $k="";
                }
            }
            foreach($post_top as $key=>$items)
                    {
                        if($key>0)
                        {
                            $s="active-";
                        }
                        else
                        {
                            $s="";
                        }
                    }
            return view('user.allpost', compact('posts','tagpost','categorypost','categorys','k','post_top','s','user'));
        }
        else{
            return view('user.error');   
        }
    }
   public function post(Request $request)
   {
       App::setLocale($request->locale);
       session()->put('locale', $request->locale);
       $post=post::where(['slug'=>$request->post,'status'=>1,'language'=>$request->locale])->first();
       $user=Auth::user();
       $admin=admin::all();
       if ($post !="") {
           foreach ($post->categories as $item) {
               $category=post::join('category_posts', 'category_posts.post_id', '=', 'posts.id')
                    ->where(['category_posts.category_id'=> $item->id,'posts.status'=> 1,'posts.language'=>$request->locale ])
                    ->selectRaw('posts.*')
                    ->get();
                $categorys=post::join('category_posts', 'category_posts.post_id', '=', 'posts.id')
                    ->where(['category_posts.category_id'=> $item->id,'posts.status'=> 1 ,'posts.language'=>$request->locale])
                    ->whereNotNull('posts.image')
                    ->selectRaw('posts.*')
                    ->orderBy('posts.created_at', 'desc')
                    ->get();
                $post_top=post::join('category_posts', 'category_posts.post_id', '=', 'posts.id')
                    ->where(['category_posts.category_id'=> $item->id,'posts.status'=> 1 ,'posts.language'=>$request->locale])
                    ->withCount('comments')
                    ->withCount('favorite_post')
                    ->orderBy('view_count', 'desc')
                    ->orderBy('comments_count', 'desc')
                    ->orderBy('favorite_post_count', 'desc')
                    ->whereNotNull('posts.image')
                    ->selectRaw('posts.*')
                    ->orderBy('posts.created_at', 'desc')
                    ->take(4)
                    ->get();
           }
           $random = post::inRandomOrder()->where(['status'=>1,'language'=>$request->locale])->take(4)->get();
           $previous=$category->where('id', '<', $post->id)->first();
           $next=$category->where('id', '>', $post->id)->first();
           $dates=post::where(['status'=>1,'language'=>$request->locale])->select(DB::raw('count(id) as `data`'),DB::raw('YEAR(created_at) year, MONTHNAME(created_at) month_name , MONTH(created_at) AS month'))
               ->groupby('year','month','month_name')
               ->orderBy('year', 'desc')
               ->orderBy('month', 'desc')
               ->get();
           $tagpost=tag::where('language',$request->locale)->get();
           $categorypost=category::where('language',$request->locale)->get();
           $posts=$categorys->take(4);
           $blogKey = 'blog_' . $post->id;
          if (!Session::has($blogKey)) {
               $post->increment('view_count');
               Session::put($blogKey,1);
          }
           foreach($posts as $key => $items)
            {
                if($key>0)
                {
                        $k="active-";
                }
                else
                {
                        $k="";
                }
            }
            foreach($post_top as $key=>$items)
            {
                if($key>0)
                {
                    $s="active-";
                }
                else
                {
                    $s="";
                }
            }
            foreach($random as $key=>$items)
            {
                if($key>0)
                {
                    $r="active-";
                }
                else
                {
                    $r="";
                }
            } 
        return view('user.post', compact('post', 'previous', 'next', 'posts','k','categorypost','tagpost','user','post_top','s','random','r','dates'));  
    }
    
        else
        {
            return view('user.error');
        }
   }
   public function tag(Request $request)
    {
       App::setLocale($request->locale);
       session()->put('locale', $request->locale);
       $tag=tag::where(['slug'=>$request->tag,'language'=>$request->locale])->first();
       if ($tag!="") {
           $posts=$tag->posts()->paginate(6);
           $user=Auth::user();
           $tagpost=tag::where('language', $request->locale)->get();
           $categorypost=category::where('language', $request->locale)->get();
           $tags=$tag->posts()->where(['language'=> $request->locale,'status'=>1])->orderBy('created_at', 'desc')->take(4)->get();
           $post_top=$tag->posts()->where(['language'=> $request->locale,'status'=>1])
           ->withCount('comments')
           ->withCount('favorite_post')
           ->orderBy('view_count', 'desc')
           ->orderBy('comments_count', 'desc')
           ->orderBy('favorite_post_count', 'desc')
           ->orderBy('created_at', 'desc')
           ->take(4)
           ->get();
            foreach($post_top as $key=>$items)
                    {
                        if($key>0)
                        {
                            $s="active-";
                        }
                        else
                        {
                            $s="";
                        }
                    }
           foreach ($tags as $key => $items) {
               if ($key>0) {
                   $k="active-";
               } else {
                   $k="";
               }
           }
           return view('user.tag', compact('posts', 'tag', 'tags', 'tagpost', 'categorypost', 'k', 'user','post_top','s'));
       }
    else
    {
        return view('user.error');
    }
    }
    public function category(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $category=category::where(['slug'=>$request->category,'language'=>$request->locale])->first();
        if ($category!="") {
            $posts= $category->posts()->paginate(6);
            $user=Auth::user();
            $tagpost=tag::where('language', $request->locale)->get();
            $categorypost=category::where('language', $request->locale)->get();
            $categorys=$category->posts()->where(['language'=> $request->locale,'status'=>1])->orderBy('created_at', 'desc')->take(4)->get();
            $post_top=$category->posts()->where(['language'=> $request->locale,'status'=>1])
            ->withCount('comments')
            ->withCount('favorite_post')
            ->orderBy('view_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->orderBy('favorite_post_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            foreach ($categorys as $key => $items) {
                if ($key>0) {
                    $k="active-";
                } else {
                    $k="";
                }
            }
            foreach($post_top as $key=>$items)
            {
                if($key>0)
                {
                    $s="active-";
                }
                else
                {
                    $s="";
                }
            }
            return view('user.category', compact('posts', 'category', 'categorypost', 'tagpost', 'categorys', 'k', 'user','post_top','s'));
        }   
        else
        {
            return view('user.error');
        }

     }
     public function date(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        
        $posts=post::where(['status'=>1,'language'=>$request->locale])
        ->whereYear('created_at', '=',$request->year )
        ->whereMonth('created_at', '=', $request->month)
        ->paginate(6);
        $user=Auth::user();
        if(count($posts) !=0)
        {
            foreach ($posts as $postss) {
             foreach($postss->categories as $item){
              $categorys=post::join('category_posts', 'category_posts.post_id', '=', 'posts.id')
                     ->where(['category_posts.category_id'=> $item->id,'posts.status'=> 1 ,'posts.language'=>$request->locale])
                     ->whereNotNull('posts.image')
                     ->selectRaw('posts.*')
                     ->orderBy('posts.created_at', 'desc')
                     ->take(4)
                     ->get();
                $post_top=post::join('category_posts', 'category_posts.post_id', '=', 'posts.id')
                     ->where(['category_posts.category_id'=> $item->id,'posts.status'=> 1 ,'posts.language'=>$request->locale])
                     ->withCount('comments')
                     ->withCount('favorite_post')
                     ->orderBy('view_count', 'desc')
                     ->orderBy('comments_count', 'desc')
                     ->orderBy('favorite_post_count', 'desc')
                     ->whereNotNull('posts.image')
                     ->selectRaw('posts.*')
                     ->orderBy('posts.created_at', 'desc')
                     ->take(4)
                     ->get();
                }
            }
            $month=$request->month;
            $monthName= date('F',mktime(0,0,0,$month,10));
            $year=$request->year;
            $tagpost=tag::where('language',$request->locale)->get();
            $categorypost=category::where('language',$request->locale)->get();
            foreach($categorys as $key => $items)
            {
                if($key>0){
                        $k="active-";
                }
                else{
                        $k="";
                }
            }
            foreach($post_top as $key=>$items)
            {
                if($key>0)
                {
                    $s="active-";
                }
                else
                {
                    $s="";
                }
            }
            return view('user.date',compact('posts','month','year','monthName','tagpost','categorypost','categorys','k','post_top','s','user'));
        }
        else
        {
            return view('user.error');
        }
     }
}
