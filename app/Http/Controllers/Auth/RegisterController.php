<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use App\Model\user\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use App;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    
    public function showRegistrationForm(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        session()->put('getback', url()->previous());
        return view('auth.register');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request){
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_picture'=>['required','mimes:jpeg,png,jpg'],
        ]);
        $user=new User;
        if ($request->hasfile('profile_picture')) {
            $filename = md5(time()).'.'.$request->file('profile_picture')->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $imgx = Image::make($request->file('profile_picture')->path());
            $imgx->resize(62,62)->save($destinationPath.'/user_62X62/'.$filename);
            $user->image=$filename;
        }
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=$request->password;
        if ($user->save()) {
               Toastr::success('Register Successfully', 'Success');
               Auth::guard()->login($user);
           }
           return redirect(session()->get('getback'));
    }
    
}
