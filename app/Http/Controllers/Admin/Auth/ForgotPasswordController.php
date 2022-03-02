<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Mail;
use App\Mail\ResetPassword;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('admin.guest:admin');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    public function index()
    {
        return view('admin.modules.forgetpassword.forget_password');
    }

    public function forgetpassword(Request $request)
    {
        $getdata = Admin::where('email',$request->email)->first();
        if ($getdata === null) {
           return back()->with('error','This email is not registered yet');
        }else{
            $update_vcode = Admin::where('email',$request->email)->update(['email_vcode'=>time()]);
            $get_vcode = Admin::where('email',$request->email)->first();
             $data = [
                'email'=>$request->email,
                'name'=>$get_vcode->name,
                'email_vcode'=>$get_vcode->email_vcode,
                'id'=>$get_vcode->id,
            ];
            Mail::send(new ResetPassword($data));
            return back()->with('success','A reset password link send to your email');
        }
    }

    public function resetPassowrd($id,$vcode)
    {
       $data = Admin::where('email_vcode',$vcode)->where('id',$id)->first();
       if ($data===null) {
           return redirect()->route('admin.login')->with('error','Link expired');
       }
       return view('admin.modules.forgetpassword.resetpassword',compact('data'));
    }

    public function newPassword(Request $request)
    {
        $password = $request->input('password'); 
        $updatepassword = Admin::where('id',$request->id)->update([
            'password'=>Hash::make($password),
            'email_vcode'=>''
        ]); 

        return redirect()->route('admin.login')->with('success','Password changed successfully');
    }

}
