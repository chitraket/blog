<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\user\favorite_post;
use Brian2694\Toastr\Facades\Toastr;
use App\Model\admin\role;
use App\Model\user\post;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('favorite.delete')) {
            foreach (Auth::user()->roles as $role) {
                if ($role->id == 4) {
                    $favorite_post=favorite_post::all();
                }
                else
                {
                    $user_id=Auth::user()->id;
                    $favorite_post=favorite_post::where('admin_id', $user_id)->get();
            }
            return view('admin.favorite.show', compact('favorite_post'));
        }
        return redirect(route('admin.home'));
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        if (Auth::user()->can('favorite.delete')) {
            favorite_post::find($id)->delete();
            Toastr::success('Favorite Post Successfully Deleted', 'Success');
            return redirect()->back();
        }
        return redirect(route('admin.home'));
    }
}
