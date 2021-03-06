<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\admin\role;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Model\user\comments;
use App\Model\user\reply;
class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('comment.delete')) {
            foreach (Auth::user()->roles as $role) {
                if ($role->id == 4) {
                    $comment=comments::all();
                    
                }
                else
                {
                    $user_id=Auth::user()->id;
                    $comment=comments::where('admin_id', $user_id)->get();
                }
            }
            return view('admin.comment.show', compact('comment'));
        }
        return redirect(route('admin.home'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'reply'=>'required'
        ]);
        $comment = new reply();
        $comment->post_id = $request->post_id;
        $comment->user_id = $request->user_id;
        $comment->comment_id =$request->comment_id;
        $comment->admin_id=Auth::user()->id;
        $comment->reply = $request->reply;
        $comment->reply_status= 1;
        if($comment->save())
        {
            Toastr::success('Comment Successfully', 'Success');
        }
        return redirect(route('comment.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (Auth::user()->can('comment.delete')) {
        $reply=comments::where('id',$id)->get();
            foreach($reply as $replys)
            {
                $post_id=$replys->post_id;
                $user_id=$replys->user_id;
                $comment_id=$replys->id;
            }
        return view('admin.comment.add', compact('post_id','user_id','comment_id'));
        }
        return redirect(route('admin.home'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (Auth::user()->can('comment.delete')) {
            comments::find($id)->delete();
            Toastr::success('Comment Successfully Deleted', 'Success');
            return redirect()->back();
        }
        return redirect(route('admin.home'));
    }
}
