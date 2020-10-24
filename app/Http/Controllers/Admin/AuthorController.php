<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\admin;
use App\Model\admin\role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Image;
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
        
        if ($request->hasfile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = md5(time()).'.'.$extension;
            $destinationPath = public_path('/images');
            $imgx = Image::make($file->path());
            $imgx->resize(123,122)->save($destinationPath.'/admin_123X122/'.$filename);
            $imgx->resize(62,62)->save($destinationPath.'/admin_40X40/'.$filename);
            $user->image=$filename;
        }
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
        if ($request->hasfile('image')){
            if($user->image != "default.png")
            {
                $filenames[] = public_path().'/images/admin_123X122/'.$user->image;
                $filenames[] = public_path().'/images/admin_40X40/'.$user->image;
                File::delete($filenames);
            }
            else
            {
                
            }
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = md5(time()).'.'.$extension;
            $destinationPath = public_path('/images');
            $imgx = Image::make($file->path());
            $imgx->resize(123,122)->save($destinationPath.'/admin_123X122/'.$filename);
            $imgx->resize(40,40)->save($destinationPath.'/admin_40X40/'.$filename);
           // $file->move(public_path().'\images',$filename);
            $user->image=$filename;
        } 
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
            $filenames[] = public_path().'/images/admin_123X122/'.$user->image;
            $filenames[] = public_path().'/images/admin_40X40/'.$user->image;
            File::delete($filenames);
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
