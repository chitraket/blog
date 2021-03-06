<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Model\user\tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('tags.create', 'tags.update', 'tags.delete')) {
            $tags=tag::all();
            return view('admin.tag.show', compact('tags'));
        }
        return redirect(route('admin.home'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Auth::user()->can('tags.create')) {
        return view('admin.tag.tag');
        }
        return redirect(route('admin.home'));
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
            'title'=>'required',
            'language'=>'required'
        ]);
        $tag = new tag;
        $tag->name=$request->title;
        $tag->slug=str_slug($request->title);
        $tag->language=$request->language;
        if($tag->save())
        {
            Toastr::success('Tag Successfully Inserted', 'Success');
        }
        return redirect(route('tag.index'));
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
        if (Auth::user()->can('tags.update')) {
            $tag=tag::where('id', $id)->first();
            return view('admin.tag.edit', compact('tag'));
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
        $this->validate($request,[
            'title'=>'required',
            'language'=>'required',
        ]);
        $tag = tag::find($id);
        $tag->name=$request->title;
        $tag->slug=str_slug($request->title);
        $tag->language=$request->language;
        if($tag->save())
        {
            Toastr::success('Tag Successfully Updated', 'Success');
        }
        return redirect(route('tag.index'));
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
        if (Auth::user()->can('tags.delete')) {
            tag::find($id)->delete();
            Toastr::success('Tag Successfully Deleted', 'Success');
            return redirect()->back();
        }
        return redirect(route('admin.home'));
    }
}
