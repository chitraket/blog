<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\Admin\admin;

class ProfileController extends Controller
{
    //
    public function index()
    {
        return view('admin.profile.profile');
    }
    public function updateProfile(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|string|email|max:255|unique:admins,email,'.Auth::user()->id,
            'image' => 'image|mimes:jpeg,png,jpg',
            'phone'=>'required|numeric',
            'username'=>'required|unique:admins,username,'.Auth::user()->id
        ]);
      //  $user = admin::findOrFail(Auth::id());
        $user= admin::find(Auth::user()->id);
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
        if ($user->save()) {
            Toastr::success('Admin Successfully Updated ', 'Success');
        }
        return redirect()->back();
      // return redirect(route('post.index'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password,$hashedPassword))
        {
            if (!Hash::check($request->password,$hashedPassword))
            {
                $user = admin::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                Toastr::success('Password Successfully Changed','Success');
                Auth::logout();
                return redirect()->back();
            } else {
                Toastr::error('New password cannot be the same as old password.','Error');
                return redirect()->back();
            }
        } else {
            Toastr::error('Current password not match.','Error');
            return redirect()->back();
        }

    }
}
