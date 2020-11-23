<?php

namespace App\Http\Controllers\Admin;

use App\Model\admin\Permission;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('permissions.create', 'permissions.update', 'permission.delete')) {
            $permission=Permission::all();
            return view('admin.permission.show', compact('permission'));
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
        if (Auth::user()->can('permissions.create')) {
            return view('admin.permission.permission');
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
            'name'=>'required|max:50|unique:permissions',
            'fors'=>'required'
        ]);
        $permission = new Permission;
        $permission->name=$request->name;
        $permission->fors=$request->fors;
        if($permission->save())
        {
            Toastr::success('Permission Successfully Inserted', 'Success');
        }
        return redirect(route('permission.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
        if (Auth::user()->can('permissions.update')) {
            $permissions=Permission::find($permission->id);
            return view('admin.permission.edit', compact('permissions'));
        }
        return redirect(route('permission.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //
        $this->validate($request,[
            'name'=>'required|max:50',
            'fors'=>'required'
        ]);
        $permission=Permission::find($permission->id);
        $permission->name=$request->name;
        $permission->fors=$request->fors;
        if($permission->save())
        {
            Toastr::success('Permission Successfully Updated', 'Success');
        }
        return redirect(route('permission.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
        Permission::find($permission->id)->delete();
        Toastr::success('Permission Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
