<?php

namespace App\Http\Controllers\Admin;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\user\user;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (Auth::user()->can('users.create', 'users.update', 'user.delete')) {
            $users=user::all();
            return view('admin.user.show', compact('users'));
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
        if (Auth::user()->can('users.create')) {
            return view('admin.user.user');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => 'image|mimes:jpeg,png,jpg'
        ]);
        $user= new user;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $image = $request->file('image');
        if ($request->hasfile('image')) {
            if (isset($image)) {
                $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                $postImage1 = Image::make($image)->resize(62, 62)->encode();
                Storage::disk('public')->put('images/user_62X62/'.$imageName, $postImage1);
            } else {
                $imageName = "default.png";
            }
        }
        $user->image=$imageName;
       if ($user->save()) {
           Toastr::success('User Successfully Inserted', 'Success');
       }
        return redirect(route('user.index'));
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
        if (Auth::user()->can('users.update')) {
            $user=user::where('id', $id)->first();
            return view('admin.user.edit', compact('user'));
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
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => ['required', 'string', 'min:8'],
            'image' => 'image|mimes:jpeg,png,jpg'
        ]);
        $user= user::find($id);


        $image = $request->file('image');
        if ($request->hasfile('image')) {
            if (isset($image)) {
                $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                if ($user->image != "default.png") {
                    if (Storage::disk('public')->exists('images/user_62X62/'.$user->image)) {
                        Storage::disk('public')->delete('images/user_62X62/'.$user->image);
                    }
                } 
                else {
                }
                $postImage1 = Image::make($image)->resize(62, 62)->encode();
                Storage::disk('public')->put('images/user_62X62/'.$imageName, $postImage1);
            } 
            else {
                $imageName = $user->image;
            }
        }
        $user->image=$imageName;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        if ($user->save()) {
            Toastr::success('User Successfully Updated ', 'Success');
        }
        return redirect(route('user.index'));
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
        $user=user::where('id',$id)->first();
        if($user->image != "default.png")
        {
            $filenames[] = public_path().'/images/user_62X62/'.$user->image;
            File::delete($filename);
            $user->delete();
        }
        else
        {
            $user->delete();
        }
        Toastr::success('User Successfully Deleted', 'Success');
        return redirect()->back();
    }
}
