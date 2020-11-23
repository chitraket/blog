<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\admin\admin;
use App\Model\user\post;
use App\Model\user\tag;
use App\Model\user\category;
use Illuminate\Support\Facades\Auth;
use App;
class AuthorController extends Controller
{
    //
    public function profile(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $author = admin::where('username', $request->username)->first();
        if ($author !="") {
            $posts = $author->posts()->paginate(6);
            $user=Auth::user();
            $tagpost=tag::all();
            $categorypost=category::all();
            $tags=$author->posts()->where(['language'=> $request->locale,'status'=>1])->orderBy('created_at', 'desc')->take(4)->get();
            $post_top=$author->posts()->where(['language'=> $request->locale,'status'=>1])
            ->withCount('comments')
            ->withCount('favorite_post')
            ->orderBy('view_count', 'desc')
            ->orderBy('comments_count', 'desc')
            ->orderBy('favorite_post_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
            foreach ($tags as $key => $items) {
                if ($key>0) {
                    $k="active-";
                } else {
                    $k="";
                }
            }
            foreach($post_top as $key=>$items)
            {
                if($key>0){
                    $s="active-";
                }
                else{
                    $s="";
                }
            }
            return view('user.profile', compact('author', 'posts', 'user', 'tagpost', 'categorypost', 'tags', 'k','post_top','s'));
        }
        else
        {
            
            return view('user.error');
        }
    }
}
