<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\user\post;
use App\Model\user\category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App;
class HomeController extends Controller
{
    //
    public function index($locale)
    {

        App::setLocale($locale);
        session()->put('locale', $locale);
        $posts=post::where(['status'=>1,'language'=>$locale])->orderBy('id', 'desc')->take(10)->get();
        $user=Auth::user();
            $popular_posts = post::where(['status'=>1,'language'=>$locale])
                            ->withCount('comments')
                            ->withCount('favorite_post')
                            ->orderBy('view_count', 'desc')
                            ->orderBy('comments_count', 'desc')
                            ->orderBy('favorite_post_count', 'desc')
                            ->first();
            if (!empty($popular_posts)) {
                $category=$popular_posts->categories;
                foreach ($category as $categories) {
                    $categoriess=$categories->name;
                    $categorys= category::where('slug', $categories->slug)->first();
                    $postss=$categorys->posts()->take(4);
                }
                $one_week_ago = Carbon::now()->subDays(6)->format('Y-m-d');
                $dates = post::where(['created_at'=>'>='.$one_week_ago,'language'=>$locale])->take(10)->get();
                return view('user.home', compact('posts', 'user', 'popular_posts', 'postss', 'categoriess', 'dates'));
            }
            else
            {
                return view('user.error');
            }
            
    }
    
}
