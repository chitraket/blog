<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Model\user\user;
use Brian2694\Toastr\Facades\Toastr;
class SettingController extends Controller
{
    //
    public function index(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        if(Auth::guest()){
            return redirect()->route('login',$request->locale);
        }
        else{
            return view('auth.setting');
        }  
    }
    public function updateProfile(Request $request)
    {
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'image' => 'image|mimes:jpeg,png,jpg',
        ]);
      //  $user = admin::findOrFail(Auth::id());
        $user=user::find(Auth::user()->id);
        if ($request->hasfile('image')){
            if($user->image != "default.png")
            {
                $filenames[] = public_path().'/images/user_62X62/'.$user->image;
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
            $imgx->resize(62,62)->save($destinationPath.'/user_62X62/'.$filename);
            $user->image=$filename;
        } 
        $user->name=$request->name;
        if ($user->save()) {
            Toastr::success($user->name.' '.'Successfully Updated. :)', 'Success');
        }
        return redirect()->back();
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
                $user = user::find(Auth::id());
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
