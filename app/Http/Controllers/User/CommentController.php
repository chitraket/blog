<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Model\user\comments;
use App;
class CommentController extends Controller
{
    //
    public function store(Request $request)
    {
        $this->validate($request,[
            'comment' => 'required'
        ]);
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $comment = new comments();
        $comment->post_id = $request->post;
        $comment->user_id = Auth::id();
        $comment->admin_id=$request->admin_id;
        $comment->comment = $request->comment;
        $comment->save();
        Toastr::success('Comment Successfully Published :)','Success');
        return redirect()->back();
    }
}
