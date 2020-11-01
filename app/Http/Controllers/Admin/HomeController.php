<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Model\user\user;
use App\Model\Admin\admin;
use App\Model\Admin\role;
use Illuminate\Http\Response;
use App\Model\user\post;
use App\Model\user\favorite_post;
use App\Model\user\comments;
use App\Model\user\category;
use Carbon\Carbon;
use App\Model\user\tag;

class HomeController extends Controller
{
    public function index()
    {
    
        foreach(Auth::user()->roles as $role)
        {
          if($role->id == 4)
          {
            $posts=post::all();
            $tag=tag::all();
            $category=category::all();
            $user=user::all();
            $popular_posts = post::withCount('comments')
                                ->withCount('favorite_post')
                                ->orderBy('view_count','desc')
                                ->orderBy('comments_count','desc')
                                ->orderBy('favorite_post_count','desc')
                                ->take(5)->get();
            $total_pending_posts = post::where('status',0)->count();
            $author_count = admin::count();
            $new_authors_today=admin::where('created_at','>=',Carbon::today())->count();
            $favorite_post=favorite_post::count();
            $comments=comments::count();
            $admin=admin::withCount('posts')
                  ->withCount('comments')
                  ->withCount('favorite_post')
                  ->orderBy('posts_count','desc')
                  ->orderBy('comments_count','desc')
                  ->orderBy('favorite_post_count','desc')
                  ->take(5)->get();
            return view('admin.home',compact('posts','tag','category','popular_posts','user','total_pending_posts','author_count','new_authors_today','favorite_post','comments','admin'));
          }
          else
          {
            $user_id=Auth::user()->id;
            $popular_posts = post::where('admin_id',$user_id)
                     ->withCount('comments')
                     ->withCount('favorite_post')
                     ->orderBy('view_count','desc')
                     ->orderBy('comments_count','desc')
                     ->orderBy('favorite_post_count','desc')
                     ->take(5)->get();
            $posts=post::where('admin_id',$user_id);
            $favorite_post=post::where('admin_id',$user_id)->withCount('favorite_post')->orderBy('favorite_post_count','desc')->count();
            $comments=post::where('admin_id',$user_id)->withCount('comments')->orderBy('comments_count','desc')->count();
             return view('admin.home',compact('popular_posts','posts','favorite_post','comments'));
          }

        }
        
    }
}
