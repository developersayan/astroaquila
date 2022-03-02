<?php

namespace App\Http\Controllers\Modules\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gotra;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Mail\ChangeEmail;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\OrderMaster;
use App\Models\ZipMaster;
use App\Models\Area;
use DB;
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : profile
     *   Description : customer profile
     *   Author      : Soumojit
     *   Date        : 2021-APR-21
     **/
    public function profile(){
        $userData=User::where('id', Auth::user()->id)->first();
        $allGotra = Gotra::get();
        $data['countries'] = Country::get();
        $data['states'] = State::where('country_id', auth()->user()->country_id)->get();
        $data['cities'] = City::where('state_id', auth()->user()->state)->get();

        $post_id = ZipMaster::where([
            'country_id' => auth()->user()->country_id,
            'state_id' => auth()->user()->state,
            'city_id' => auth()->user()->city,
            'zipcode'=>auth()->user()->pincode,
        ])->first();
        $data['areas'] = Area::where([
            'country_id' => auth()->user()->country_id,
            'state_id' => auth()->user()->state,
            'city_id' => auth()->user()->city,
            'postcode_id'=>@$post_id->id,
        ])
        ->get();
        $data['userData']= $userData;
        $data['allGotra']= $allGotra;
        //dd($userData);
        return view('modules.customer.profile')->with($data);
    }
    /**
     *   Method      : profileEdit
     *   Description : customer profile
     *   Author      : Soumojit
     *   Date        : 2021-APR-21
     **/
    public function profileEdit(Request $request){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'time_of_birth' => 'required',
            'place_of_birth' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address'=>'required',
            'pincode'=>'required',
        ]);

        $name = $request->first_name . ' ' . $request->last_name;
        $upd = [];
        $upd['first_name'] = $request->first_name;
        $upd['last_name'] = $request->last_name;
        $upd['gender'] = $request->gender;
        if (@$request->date_of_birth) {
            $upd['dob'] = date('Y-m-d', strtotime($request->date_of_birth));
        }
        $upd['time_of_birth'] = @$request->time_of_birth;
        $upd['place_of_birth'] = @$request->place_of_birth;
        $upd['latitude'] = @$request->lat;
        $upd['longitude'] = @$request->lng;
        $upd['gotra_id'] = @$request->gotra;
        $upd['city'] = $request->city;
        $upd['gst_no'] = $request->gst_no;
        $upd['state'] = $request->state;
        $upd['address'] = $request->address;
        $upd['country_id'] = $request->country;
        $upd['pincode'] = $request->pincode;

        $post_id = ZipMaster::where([
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'zipcode'=>$request->pincode,
        ])->first();

        $insArea['country_id'] = $request->country;
        $insArea['state_id'] = $request->state;
        $insArea['city_id'] = $request->city;
        $insArea['postcode_id'] = @$post_id->id;
        $insArea['area'] = $request->area;
        if($request->area_drop){
            if($request->area_drop == 'O'){
                $area = trim(strtolower($request->area));
                $check = Area::where('state_id',$request->state)
                     ->where('city_id',$request->city)
                     ->where('postcode_id',@$post_id->id)
                     ->where(DB::raw('trim(lower(area))'),$area)
                     ->first();
                if($check){
                    $upd['area'] = @$check->id;
                }else{
                    $area_ins = Area::create($insArea);
                    $upd['area'] = @$area_ins->id;
                }
            }else{
                $upd['area'] = @$request->area_drop;
            }
        }
        if ($request->profile_picture) {
            // $image = $request->profile_pic;
            // $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            // Storage::putFileAs('public/profile_picture', $image, $filename);
            // $upd['profile_img'] = $filename;
            @unlink(storage_path('app/public/profile_picture/' . auth()->user()->profile_img));
            $destinationPath = "storage/app/public/profile_picture/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['profile_img'] = $img;
        }

        $slug = str_slug($name, "-");
        $upd['slug'] = $slug . "-" . Auth::user()->id;
        //dd($upd);
        $user = User::where('id', Auth::user()->id)->update($upd);
        session()->flash('success', \Lang::get('profile.profile_updated'));
        return redirect()->route('customer.profile');
    }
    /**
     *   Method      : dashboard
     *   Description : customer dashboard
     *   Author      : Soumojit
     *   Date        : 2021-APR-22
     **/
    public function dashboard()
    {
        $userData = User::where('id', Auth::user()->id)->first();
        $allGotra = Gotra::get();
        $data['userData'] = $userData;
        $data['allGotra'] = $allGotra;
        $data['allOrder']=OrderMaster::where('order_type','PO')->where('customer_id',auth()->user()->id)->orderBy('id','desc')->limit(5)->get();
		$data['last_three_orders']=OrderMaster::where('customer_id',auth()->user()->id)->where('payment_status','p')->orderBy('id','desc')->limit(3)->get();
        return view('modules.customer.dashboard')->with($data);
    }
    /**
     *   Method      : changePassword
     *   Description : Astrologer change password
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function changePassword()
    {
        return view('modules.customer.change_password');
    }
    /**
     *   Method      : changePassword
     *   Description : Astrologer change password save
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function changePasswordSave(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required',
        ]);
        $check_user = User::where('id', auth()->user()->id)->first();
        if (!Hash::check($request->old_password, $check_user->password)) {
            session()->flash('error', \Lang::get('profile.old_password_wrong'));
            return redirect()->back();
        } else {
            $upd['password'] = \Hash::make($request->new_password);
            session()->flash('success', \Lang::get('profile.password_reset_success'));
        }
        $user_update = User::where('id', auth()->user()->id)->update($upd);
        return redirect()->route('customer.change.password');
    }
     /**
     *   Method      : checkemail
     *   Description : Customer Check Duplicate Email
     *   Author      : Sayan
     *   Date        : 2021-MAY-7
     **/

    public function checkemail(Request $request)
    {
         $check = User::where('email',$request->change_email_id)->where('status','!=','D')->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
    }

    /**
     *   Method      : changemail
     *   Description : Customer send mail
     *   Author      : Sayan
     *   Date        : 2021-MAY-7
     **/

    public function changemail(Request $request)
    {
        $email_update = User::where('id',$request->user_id)->update([
            'temp_email'=>$request->change_email,
            'temp_vcode'=>time(),
        ]);
        $get_user_data = User::where('id',$request->user_id)->first();
        $data = [
                'id'=>$get_user_data->id,
                'email'=>$get_user_data->temp_email,
                'first_name'=>$get_user_data->first_name,
                'temp_vcode'=>$get_user_data->temp_vcode
        ];
        Mail::send(new ChangeEmail($data));
        return redirect()->back()->with('success',\Lang::get('profile.change_email_message'));
    }

     /**
     *   Method      : verifyEmail
     *   Description : Customer Check Duplicate Email And Verifiy Mail
     *   Author      : Sayan
     *   Date        : 2021-MAY-7
     **/

    public function verifyEmail($id,$vcode)
    {
        $getdata = User::where('id',$id)->where('temp_vcode',$vcode)->first();
        if ($getdata) {
            // check if someone is already use this or not
            $check = User::where('email',$getdata->temp_email)->where('status','!=','D')->first();
            if ($check) {

            // null the fields
            $null = User::where('id',$id)->update([
                'temp_email'=>'',
                'temp_vcode'=>'',
            ]);

            session()->flash('error', \Lang::get('profile.something_went_wrong_email'));
            if($getdata->user_type=='C'){
                return redirect()->route('customer.dashboard');
             }
                 if($getdata->user_type=='A'){
                return redirect()->route('astrologer.dashboard');
            }
                 if($getdata->user_type=='P'){
                return redirect()->route('pundit.dashboard');
            }

        }else{

        $update_details = User::where('id',$id)->where('temp_vcode',$vcode)->update([
            'email'=>$getdata->temp_email,
            'temp_vcode'=>'',
            'temp_email'=>'',
            'is_email_verify'=>'Y',
            'status'=>'A',
        ]);
        session()->flash('success', \Lang::get('profile.email_change_success'));
        if($getdata->user_type=='C'){
                return redirect()->route('customer.dashboard');
        }
        if($getdata->user_type=='A'){
                return redirect()->route('astrologer.dashboard');
            }
        if($getdata->user_type=='P'){
                return redirect()->route('pundit.dashboard');
            }
      }
     }else{

     // check-only via id
     $id = User::where('id',$id)->first();
     if ($id) {
        session()->flash('error', \Lang::get('profile.something_went_wrong_email'));
        if($id->user_type=='C'){
                return redirect()->route('customer.dashboard');
        }
        if($id->user_type=='A'){
                return redirect()->route('astrologer.dashboard');
            }
        if($id->user_type=='P'){
                return redirect()->route('pundit.dashboard');
            }
     }
}

}
    /**
     *   Method      : mobileChange
     *   Description : Customer Mobile number change and store temp mobile section
     *   Author      : Soumojit
     *   Date        : 2021-MAY-07
     **/
    public function mobileChange(Request $request)
    {
        $userData = User::where('id', auth()->user()->id)->where('status', '!=', 'D')->first();
        if (@$userData) {
            $upd['temp_otp'] = mt_rand(100000, 999999);
            $upd['temp_mobile'] = $request->mobile;
            $userUpdate = User::where('id', $userData->id)->update($upd);
            $userData = User::where('id', $userData->id)->first();
            if ($userUpdate == null) {
                $response['result']['error'] = \Lang::get('auth.resend_otp_error');
            } else {
                $response['result']['success'] = \Lang::get('auth.resend_otp');
                $response['result']['data'] = $userData;
            }
            return response()->json($response);
        }
        $response['result']['error'] = \Lang::get('profile.something_went_wrong');
        // return redirect()->route('login');
        return response()->json($response);
    }
    /**
     *   Method      : wrongOTPCheck
     *   Description : Customer Wrong Temp OTP Check for Change mobile number
     *   Author      : Soumojit
     *   Date        : 2021-MAY-07
     **/
    public function wrongOTPCheck(Request $request)
    {
        $otp = @$request->otpBox1 . @$request->otpBox2 . @$request->otpBox3 . @$request->otpBox4 . @$request->otpBox5 . @$request->otpBox6;
        // dd($otp);
        $userData = User::where('id', auth()->user()->id)->first();
        if (@$userData) {
            // $checkEmail = User::whereIn('status', ['A', 'I', 'U'])->where('email', $request->email)->count();
            // if ($checkEmail > 0) {
            //     return response('false');
            // } else {
            //     return response('true');
            // }
            if (@$userData->temp_otp == $otp) {
                return response('true');
            } else {
                return response('false');
            }
        }
        return response('false');
    }
    /**
     *   Method      : mobileChangeSubmit
     *   Description : Customer Mobile Change
     *   Author      : Soumojit
     *   Date        : 2021-MAY-07
     **/
    public function mobileChangeSubmit(Request $request)
    {
        $otp = @$request->otpBox1 . @$request->otpBox2 . @$request->otpBox3 . @$request->otpBox4 . @$request->otpBox5 . @$request->otpBox6;
        $userData = User::where('id', auth()->user()->id)->first();
        if (@$userData) {
            if (@$userData->temp_otp == $otp) {
                $checkMobile = User::whereIn('status', ['A', 'I', 'U'])->where('mobile', $userData->temp_mobile)->count();
                if ($checkMobile > 0) {
                    session()->flash('error', \Lang::get('profile.mobile_number_unique'));
                    return redirect()->route('customer.profile');
                }
                $upd = [];
                $upd['mobile'] = $userData->temp_mobile;
                $upd['temp_otp'] = null;
                $upd['temp_mobile'] = null;
                $upd['is_mobile_verify'] = 'Y';
                $userUpdate = User::where('id', $userData->id)->update($upd);
                session()->flash('success', \Lang::get('profile.mobile_number_change'));
                return redirect()->route('customer.profile');
            } else {
                session()->flash('error', \Lang::get('profile.mobile_number_not_change'));
                return redirect()->route('customer.profile');
            }
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('customer.profile');
    }

}
