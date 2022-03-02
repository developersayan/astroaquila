<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
class HomeController extends Controller
{

    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('admin.home');
    }

    public function changepasswordview()
    {
      return view('admin.modules.changepassword.change_password');
    }

    public function checkold(Request $request)
    {
        $oldpassword = $request->input('oldpassword');
        if (!\Hash::check($oldpassword,auth()->guard('admin')->user()->password)) {
            $valid = "false";
        }else{
             $valid = "true";
        }
        return $valid;
    }

    public function newpassword(Request $request)
    {
        // checking old password matched or not 
        $oldpassword = $request->input('oldpassword');
        if (!\Hash::check($oldpassword,auth()->guard('admin')->user()->password)) {
            return redirect()->back()->with('error','You have entered wrong old password');
        }
        
        $updatepassword = Admin::where('id',auth()->guard('admin')->user()->id)->update([
        'password'=>\Hash::make($request->input('password'))
        ]);
            return redirect()->back()->with('success','Password updated successfully');
        
    }

    public function profile()
    {
        return view('admin.modules.profile.profile');
    }

    public function checkemail(Request $request)
    {
        $chk=Admin::where('id','!=',$request->id)->where('email',$request->email)->count();
        if ($chk>0) {
            $valid = "false";
        }else{
            $valid = "true";
        }
        return $valid;
    }

    public function updateprofile(Request $request)
    {
      $upd=[];
      $upd['name']=$request->name;
      $upd['email']=$request->email;
      if (@$request->profile_picture) {
            @unlink(storage_path('app/public/profile_picture/' . auth()->user()->profile_pic));
            $destinationPath = "storage/app/public/profile_picture/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['profile_pic'] = $img;
        }
        $update = Admin::where('id',auth()->guard('admin')->user()->id)->update($upd);
        return redirect()->back()->with('success','Profile updated successfully');
    }

    public function submenu()
    {
        return view('admin.modules.landing_page.landing_page');
    }




}
