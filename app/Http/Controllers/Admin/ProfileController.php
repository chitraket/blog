<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Model\admin\admin;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
        ]);
      //  $user = admin::findOrFail(Auth::id());
        $user= admin::find(Auth::user()->id);
        $image = $request->file('image');
        
            if (isset($image)) {
                if ($request->hasfile('image')) {
                    $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                    if ($user->image != "default.png") {
                        if (Storage::disk('public')->exists('images/admin_123X122/'.$user->image)) {
                            Storage::disk('public')->delete('images/admin_123X122/'.$user->image);
                        }
                        if (Storage::disk('public')->exists('images/admin_40X40/'.$user->image)) {
                            Storage::disk('public')->delete('images/admin_40X40/'.$user->image);
                        }
                    } else {
                    }
                    $postImage = Image::make($image)->resize(123, 122)->encode();
                    $postImage1 = Image::make($image)->resize(62, 62)->encode();
                    Storage::disk('public')->put('images/admin_123X122/'.$imageName, $postImage);
                    Storage::disk('public')->put('images/admin_40X40/'.$imageName, $postImage1);
                }
            } else {
                $imageName = $user->image;
            }
        $user->image=$imageName;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone=$request->phone;
        $user->about=$request->about;
        $user->username=str_slug($request->name);
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
