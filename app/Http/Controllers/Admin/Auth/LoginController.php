<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;

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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest:admin', ['except' => 'logout']);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $currencyCode = session()->get('currencyCode');
        $currency = session()->get('currency');
        $this->guard()->logout();

        $request->session()->invalidate();
        session(['currencyCode' => $currencyCode]);
        session(['currency' => $currency]);

        return redirect()->route('admin.login');
    }
    protected function authenticated(Request $request, $user)
    {
        if (@$request->remember) {
            Cookie::queue('astroquila_admin_user_email', $request->email);
            Cookie::queue('astroquila_admin_user_password', $request->password);
        } else {
            Cookie::queue(Cookie::forget('astroquila_admin_user_email'));
            Cookie::queue(Cookie::forget('astroquila_admin_user_password'));
        }
    }

}
