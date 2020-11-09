<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Brian2694\Toastr\Facades\Toastr;
use App\Model\Admin\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
          ]);
          $remember_me = $request->has('remember_me') ? true : false; 
          if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            Toastr::success('Login Successfully. :)');
                return redirect(route('admin.home'));
          }
          else
          {
            Toastr::error('Your email and password are wrong. :(');
            return back();
          }
        // $this->validateLogin($request);

        // if ($this->attemptLogin($request)) {
        //     return $this->sendLoginResponse($request);
        // }

        // return $this->sendFailedLoginResponse($request);
    }

    protected function credentials(Request $request)
    {
        return ['email'=>$request->email,'password'=>$request->password,'status'=>1];
        //return $request->only($this->username(),'password');
    }

    public function __construct()
    {
        //$this->redirectTo=redirect()->route('admin.login');
        $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->back();
    }
}
