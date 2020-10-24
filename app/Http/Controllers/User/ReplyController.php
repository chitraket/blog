<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Model\user\reply;
use App;
class ReplyController extends Controller
{
    //
    public function store(Request $request)
    {
         $this->validate($request,[
             'reply' => 'required'
         ]);
         App::setLocale($request->locale);
         session()->put('locale', $request->locale);
         $reply = new reply();
         $reply->post_id = $request->post;
         $reply->user_id = Auth::id();
         $reply->comment_id = $request->cid;
         $reply->admin_id=$request->admin_id;
         $reply->reply = $request->reply;
         $reply->save();
         Toastr::success('Comment Successfully Published :)','Success');
         return redirect()->back();
    }
}
