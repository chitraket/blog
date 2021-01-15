<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\admin\Permission;
use App\Model\admin\role;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('roles.create', 'roles.update', 'roles.delete')) {
            $roles=role::all();
            return view('admin.role.show', compact('roles'));
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
        if (Auth::user()->can('roles.create')) {
            $permissions=Permission::all();
            return view('admin.role.role', compact('permissions'));
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
            'name'=>'required|max:50|unique:roles',
        ]);
        $role = new role;
        $role->name=$request->name;
        if($role->save())
        {
            Toastr::success('Role Successfully Inserted', 'Success');
        }
        $role->permissions()->sync($request->permission);
        return redirect(route('role.index'));
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
        if (Auth::user()->can('roles.update')) {
            $permissions=Permission::all();
            $role=role::find($id);
            return view('admin.role.edit', compact('role', 'permissions'));
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
            'name'=>'required|max:50',
        ]);
        $role=role::find($id);
        $role->name=$request->name;
        $role->permissions()->sync($request->permission);
        if($role->save())
        {
            Toastr::success('Role Successfully Updated', 'Success');
        }
        return redirect(route('role.index'));

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
        if (Auth::user()->can('roles.delete')) {
        role::find($id)->delete();
        Toastr::success('Role Successfully Deleted', 'Success');
        return redirect()->back();
    }
        return redirect(route('admin.home'));
    }
}
