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
use App;
class PostController extends Controller
{
    //
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
           }

           $previous=$category->where('id', '<', $post->id)->first();
           $next=$category->where('id', '>', $post->id)->first();
           $tagpost=tag::where('language',$request->locale)->get();
           $categorypost=category::where('language',$request->locale)->get();
           $posts=$category->take(4);
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
            if (Auth::guest()) {
                 $c="";
            }
            else
            {
                if ($user->favorite_post()->where('post_id', $post->id)->count() == 0) {
                    $c="-o";
                } else {
                    $c="";
                }
            }    
        return view('user.post', compact('post', 'previous', 'next', 'posts','k','categorypost','tagpost','c','user'));  
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
           $posts=$tag->posts();
           $user=Auth::user();
           $tagpost=tag::where('language', $request->locale)->get();
           $categorypost=category::where('language', $request->locale)->get();
           $tags=$tag->posts()->where('language', $request->locale)->take(4);
           foreach ($tags as $key => $items) {
               if ($key>0) {
                   $k="active-";
               } else {
                   $k="";
               }
           }
           return view('user.tag', compact('posts', 'tag', 'tags', 'tagpost', 'categorypost', 'k', 'user'));
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
            $posts= $category->posts();
            $user=Auth::user();
            $tagpost=tag::where('language', $request->locale)->get();
            $categorypost=category::where('language', $request->locale)->get();
            $categorys=$category->posts()->take(4);
            foreach ($categorys as $key => $items) {
                if ($key>0) {
                    $k="active-";
                } else {
                    $k="";
                }
            }
            return view('user.category', compact('posts', 'category', 'categorypost', 'tagpost', 'categorys', 'k', 'user'));
        }   
        else
        {
            return view('user.error');
        }
     }
}
