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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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
        $urlPrevious = url()->previous();
        $urlBase = url()->to('/',$request->locale);
        if(($urlPrevious != $urlBase . '/login') && ($urlPrevious != $urlBase . '/register') && ($urlPrevious != $urlBase . '/password/reset') && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)){
           $request->session()->put('url.intended', $urlPrevious);
        }
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
        $image = $request->file('profile_picture');
        if ($request->hasfile('profile_picture')) {
            if (isset($image)) {
                $imageName  = md5(time()).'.'.$image->getClientOriginalExtension();
                $postImage1 = Image::make($image)->resize(62, 62)->encode();
                Storage::disk('public')->put('images/user_62X62/'.$imageName, $postImage1);
            } else {
                $imageName = "default.png";
            }
        }
        $user->image=$imageName;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        if ($user->save()) {
               Toastr::success('Register Successfully. :)');
               Auth::guard()->login($user);
               if (session()->has('url.intended')) {
                   return redirect($request->session()->get('url.intended'));
               }
               else
               {
                   return redirect('/',$request->locale);
               }
           }
           return back();
          
    }
    
}
