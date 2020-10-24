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
        $query = $request->input('query');
        $posts = post::where('title','LIKE','%'.$query.'%')->paginate(6);
        $posts->appends($request->all());
        $user=Auth::user();
        $tagpost=tag::all();
        $categorypost=category::all();
        $tags=post::where('status',1)->orderBy('created_at','desc')->take(4)->get();
        foreach($tags as $key => $items)
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
        return view('user.search',compact('posts','query','tagpost','categorypost','user','tags','k'));
    }
}
