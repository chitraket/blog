<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Model\user\favorite_post;
use App;
class FavoriteController extends Controller
{
    //
    public function add(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $user = Auth::user();
        $isFavorite = $user->favorite_post()->where('post_id',$request->post)->count();

         if ($isFavorite == 0)
         {
            $reply = new favorite_post();
            $reply->post_id = $request->post;
            $reply->user_id = Auth::id();
            $reply->admin_id=$request->admin_id;
            $reply->save();
            Toastr::success('Post successfully added to your favorite list :)','Success');
            return redirect()->back();
         } else {
             $chit=favorite_post::where(['post_id'=>$request->post,'user_id'=>Auth::id()])->delete();
             Toastr::success('Post successfully removed form your favorite list :)', 'Success');
             return redirect()->back();
         }

    }
}
