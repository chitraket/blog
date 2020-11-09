<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App;

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
    public function showLoginForm(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $urlPrevious = url()->previous();
        $urlBase = url()->to('/',$request->locale);
        if(($urlPrevious != $urlBase . '/login') && ($urlPrevious != $urlBase . '/register') && ($urlPrevious != $urlBase . '/password/reset')  && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)){
           $request->session()->put('url.intended', $urlPrevious);
        }
        return view('auth.login');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        //$this->redirectTo=redirect()->back();
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
          ]);
          $remember_me = $request->has('remember_me') ? true : false; 
          if (Auth::guard()->attempt(['email' => $request->email, 'password' => $request->password])) {
            Toastr::success('Login Successfully. :)');
            if (session()->has('url.intended')) {
                return redirect($request->session()->get('url.intended'));
            }
            else
            {
                return redirect('/',$request->locale);
            }
          }
          else
          {
            Toastr::error('Your email and password are wrong. :(');
            return back();
          }
         // return redirect()->back()->withInput($request->only('email', 'remember'));
    }
    public function logout(Request $request){
        Auth::guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->back();
    }

}
