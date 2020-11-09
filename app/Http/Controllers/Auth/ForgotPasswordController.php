<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm(Request $request)
    {
        App::setLocale($request->locale);
        session()->put('locale', $request->locale);
        $urlPrevious = url()->previous();
        $urlBase = url()->to('/',$request->locale);
        if(($urlPrevious != $urlBase . '/login') && ($urlPrevious != $urlBase . '/register') && ($urlPrevious != $urlBase . '/password/reset')  && (substr($urlPrevious, 0, strlen($urlBase)) === $urlBase)){
           $request->session()->put('url.intended', $urlPrevious);
        }
        return view('auth.passwords.email');
    }

}
