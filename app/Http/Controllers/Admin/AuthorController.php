<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\admin\admin;
use App\Model\admin\role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('subadmin.create', 'subadmin.update', 'subadmin.delete')) {
            $users=Admin::all();
            return view('admin.subadmin.show', compact('users'));
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
        if (Auth::user()->can('subadmin.create')) {
            $roles=role::all();
            return view('admin.subadmin.subadmin', compact('roles'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => 'image|mimes:jpeg,png,jpg',
            'phone'=>'required|numeric',
            'username'=>'required|unique:admins'
        ]);
        
        $user= new admin;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->phone=$request->phone;
        $user->about=$request->about;
        $user->username=$request->username;
        $user->status=$request->status? : $request['status']=0;
        
        $image = $request->file('image');
        if ($request->hasfile('image')) {
            if (isset($image)) {
                $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                $postImage = Image::make($image)->resize(123, 122)->encode();
                $postImage1 = Image::make($image)->resize(62, 62)->encode();
                Storage::disk('public')->put('images/admin_123X122/'.$imageName, $postImage);
                Storage::disk('public')->put('images/admin_40X40/'.$imageName, $postImage1);
            } else {
                $imageName = "default.png";
            }
        }
        $user->image=$imageName; 
       if ($user->save()) {
           Toastr::success('Admin Successfully Inserted', 'Success');
       }
       $user->roles()->sync($request->role);
        return redirect(route('subadmin.index'));

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
        if (Auth::user()->can('subadmin.update')) {
            $roles=role::all();
            $user=admin::where('id', $id)->first();
            return view('admin.subadmin.edit', compact('user', 'roles'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|email|max:255|unique:admins,email,'.$id,
            'image' => 'image|mimes:jpeg,png,jpg',
            'phone'=>'required|numeric',
            'username'=>'required|unique:admins,username,'.$id
        ]);
        $user= admin::find($id);
        $image = $request->file('image');
        if ($request->hasfile('image')) {
            if (isset($image)) {
                $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                if ($user->image != "default.png") {
                    if (Storage::disk('public')->exists('images/admin_123X122/'.$user->image)) {
                        Storage::disk('public')->delete('images/admin_123X122/'.$user->image);
                    }
                    if (Storage::disk('public')->exists('images/admin_40X40/'.$user->image)) {
                        Storage::disk('public')->delete('images/admin_40X40/'.$user->image);
                    }
                } 
                else {
                }
                $postImage = Image::make($image)->resize(123, 122)->encode();
                $postImage1 = Image::make($image)->resize(62, 62)->encode();
                Storage::disk('public')->put('images/admin_123X122/'.$imageName, $postImage);
                Storage::disk('public')->put('images/admin_40X40/'.$imageName, $postImage1);
            } 
            else {
                $imageName = $user->image;
            }
        }
        $user->image=$imageName;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->about=$request->about;
        $user->username=$request->username;
        $user->status=$request->status? : $request['status']=0;

        $user->roles()->sync($request->role);
        if ($user->save()) {
            Toastr::success('Admin Successfully Updated ', 'Success');
        }
        return redirect(route('subadmin.index'));
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
        $user=admin::where('id',$id)->first();
        if($user->image != "default.png")
        {
            if (Storage::disk('public')->exists('images/admin_123X122/'.$user->image)) {
                Storage::disk('public')->delete('images/admin_123X122/'.$user->image);
            }
            if (Storage::disk('public')->exists('images/admin_40X40/'.$user->image)) {
                Storage::disk('public')->delete('images/admin_40X40/'.$user->image);
            }
            $user->delete();
        }
        else
        {
            $user->delete();
        }
        Toastr::success('Admin Successfully Deleted', 'Success');
        return redirect()->back();
    }

    public function changeStatus(Request $request)
    {
        $user = admin::find($request->user_id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
}
