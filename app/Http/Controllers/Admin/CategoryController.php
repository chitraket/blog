<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Model\user\category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('categorys.create', 'categorys.update', 'categorys.delete')) {
            $categorys=category::all();
            return view('admin.category.show', compact('categorys'));
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
        if (Auth::user()->can('categorys.create')) {
            return view('admin.category.category');
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
        $category = new category;
        $category->name=$request->title;
        $category->slug=str_slug($request->title);
        $category->language=$request->language;
        if($category->save())
        {
            Toastr::success('Category Successfully Inserted', 'Success');
        }
        return redirect(route('category.index'));
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
        if (Auth::user()->can('categorys.update')) {
            $category=category::where('id', $id)->first();
            return view('admin.category.edit', compact('category'));
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
            'language'=>'required'
        ]);
        $category = category::find($id);
        $category->name=$request->title;
        $category->slug=str_slug($request->title);
        $category->language=$request->language;
        if($category->save())
        {
            Toastr::success('Category Successfully Updated', 'Success');
        }
        return redirect(route('category.index'));
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
        if (Auth::user()->can('categorys.delete')) {
        category::find($id)->delete();
        Toastr::success('Category Successfully Deleted', 'Success');
        return redirect()->back();
        }
        return redirect(route('admin.home'));
    }
}
