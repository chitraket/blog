<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\user\post;
use App\Model\user\tag;
use App\Model\user\category;
use Illuminate\Support\Facades\Auth;
use App;
class SearchController extends Controller
{
    //
    public function search(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $locale=$request->locale;
        $this->validate($request,[
            'search'=>'required',
        ]);
        $query = $request->input('search');
       $posts=post::where(['status'=>1,'language'=>$locale])->where('title','like','%'.$query.'%')
        ->orwhereHas('tags', function($tag) use ($query,$locale) {
            $tag->where(['name'=>$query,'language'=>$locale]);
          })
        ->orwhereHas('categories', function($categories) use ($query,$locale) {
            $categories->where(['name'=>$query,'language'=>$locale]);
          })
        ->orwhereHas('admin', function($admin) use ($query) {
            $admin->where(['name'=>$query]);
          })
        ->orderBy('created_at', 'desc')
        ->paginate(6);
        $posts->appends($request->all());
        if (count($posts) !=0) {
            $user=Auth::user();
            $tagpost=tag::all();
            $categorypost=category::all();
    $post_top=post::where(['status'=>1,'language'=>session('locale')])
    ->withCount('comments')
    ->withCount('favorite_post')
    ->orderBy('view_count', 'desc')
    ->orderBy('comments_count', 'desc')
    ->orderBy('favorite_post_count', 'desc')
    ->orderBy('created_at', 'desc')
    ->take(4)->get();
            $tags=post::where(['status'=>1,'language'=>$request->locale])->orderBy('created_at', 'desc')->take(4)->get();
            foreach ($tags as $key => $items) {
                if ($key>0) {
                    $k="active-";
                } else {
                    $k="";
                }
            }
            foreach($post_top as $key=>$items){
                if($key>0){
                    $s="active-";
                }
                else{
                    $s="";
                }
            }
            return view('user.search', compact('posts', 'query', 'tagpost', 'categorypost', 'user', 'tags', 'k','post_top','s'));
        }
        else
        {
            return view('user.error');
        }
    }
}
