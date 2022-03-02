<?php

namespace App\Http\Controllers\Modules\Pundits;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gotra;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use  App\Models\UserAccount;
use App\Models\UserToAvailable;
use App\Models\Puja;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\PunditToPuja;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\ChangeEmailPandit;
use App\Models\OrderMaster;
use App\Models\ZipMaster;
use App\Models\PunditToZipcode;
use App\Models\Area;
use DB;
class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('pundits.access');
    }
    /**
     *   Method      : profile
     *   Description : Pundits profile
     *   Author      : Soumojit
     *   Date        : 2021-APR-22
     **/
    public function profile()
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        $allGotra = Gotra::get();
        $data['countries'] = Country::get();
        $data['states'] = State::where('country_id',auth()->user()->country_id)->get();
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
        $data['userData'] = $userData;
        $data['allGotra'] = $allGotra;
        return view('modules.pundit.profile')->with($data);
    }
    /**
     *   Method      : profileEdit
     *   Description : Pundits profile
     *   Author      : Soumojit
     *   Date        : 2021-APR-22
     **/
    public function profileEdit(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'state' => 'required',
            'address'=>'required',
            'city' => 'required',
            'about' => 'required',
            'puja_type' => 'required',
            'bank_name' => 'required',
            'ac_no' => 'required',
            'ifsc' => 'required',
            'name_of_account_holder' => 'required',
        ]);

        $name = $request->first_name . ' ' . $request->last_name;
        $upd = [];
        $upd['first_name'] = $request->first_name;
        $upd['last_name'] = $request->last_name;
        $upd['gender'] = $request->gender;
        $upd['about'] = $request->about;
        $upd['city'] = $request->city;
        $upd['state'] = $request->state;
        $upd['address'] = $request->address;
        $upd['country_id'] = $request->country;
        $upd['puja_type'] = $request->puja_type;
        $upd['gst_no'] = $request->gst_no;
        $upd['Ac_Type'] = $request->profile_type;
        $upd['pincode'] = $request->pincode;
        $upd['offline_puja_location'] = @$request->offline_puja_location;
        $upd['offline_lat'] = @$request->lat;
        $upd['offline_long'] = @$request->lng;
        $upd['offline_puja_radius'] = @$request->offline_puja_radius;
        $upd['user_availability'] = @$request->user_availability;
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
            // @unlink(storage_path('app/public/profile_picture/' . auth()->user()->profile_img));
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
        $user = User::where('id', Auth::user()->id)->update($upd);

        $account = UserAccount::where('user_id',Auth::user()->id)->first();

        $upd1=[];
        $upd1['bank_name'] = $request->bank_name;
        $upd1['ac_no'] = $request->ac_no;
        $upd1['ifsc_code'] = $request->ifsc;
        $upd1['account_holder'] = $request->name_of_account_holder;
        if(@$account){
            UserAccount::where('user_id', Auth::user()->id)->update($upd1);
        }else{
            $upd1['user_id'] = Auth::user()->id;
            UserAccount::create($upd1);
        }


        session()->flash('success', \Lang::get('profile.profile_updated'));
        return redirect()->route('pundit.profile');
    }

    /**
     *   Method      : dashboard
     *   Description : Pundits dashboard
     *   Author      : Soumojit
     *   Date        : 2021-APR-22
     **/
    public function dashboard()
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        $allGotra = Gotra::get();
        $data['userData'] = $userData;
        $data['allGotra'] = $allGotra;
        $data['pujas'] = OrderMaster::where('user_id',auth()->user()->id)->orderBy('id','desc')->where('order_type','P')->limit(5)->get();
		$data['last_three_orders']=OrderMaster::where('customer_id',auth()->user()->id)->where('payment_status','p')->orderBy('id','desc')->limit(3)->get();
        return view('modules.pundit.dashboard')->with($data);
    }
    /**
     *   Method      : availability
     *   Description : Pundits availability view
     *   Author      : Soumojit
     *   Date        : 2021-APR-23
     **/
    public function availability()
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        $data ['monday'] = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
        $data ['tuesday'] = UserToAvailable::where('day', 'TUESDAY')->where('user_id', Auth::user()->id)->first();
        $data ['wednesday'] = UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', Auth::user()->id)->first();
        $data ['thursday'] = UserToAvailable::where('day', 'THURSDAY')->where('user_id', Auth::user()->id)->first();
        $data ['friday'] = UserToAvailable::where('day', 'FRIDAY')->where('user_id', Auth::user()->id)->first();
        $data ['saturday'] = UserToAvailable::where('day', 'SATURDAY')->where('user_id', Auth::user()->id)->first();
        $data ['sunday'] = UserToAvailable::where('day', 'SUNDAY')->where('user_id', Auth::user()->id)->first();
        $data['userData'] = $userData;
        return view('modules.pundit.availability')->with($data);
    }
    /**
     *   Method      : availabilitySave
     *   Description : Pundits availability save
     *   Author      : Soumojit
     *   Date        : 2021-APR-23
     **/
    public function availabilitySave(Request $request)
    {
        $ins=[];
        $data=array();
        if(@$request->day1){
            $ins['user_id'] = Auth::user()->id;
            $ins['from_time'] = $request->from_time_day1;
            $ins['to_time'] = $request->to_time_day1;
            $ins['day'] = 'MONDAY';
            array_push($data, 'MONDAY');
            $check1=UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            if(@$check1){
                UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            }
            else{
                UserToAvailable::create($ins);
            }
        }
        if(@$request->day2){
            $ins['user_id'] = Auth::user()->id;
            $ins['from_time'] = $request->from_time_day2;
            $ins['to_time'] = $request->to_time_day2;
            $ins['day'] = 'TUESDAY';
            array_push($data, 'TUESDAY');
            $check1=UserToAvailable::where('day', 'TUESDAY')->where('user_id', Auth::user()->id)->first();
            if(@$check1){
                UserToAvailable::where('day', 'TUESDAY')->where('user_id', Auth::user()->id)->update($ins);
            }
            else{
                UserToAvailable::create($ins);
            }
        }
        if(@$request->day3){
            $ins['user_id'] = Auth::user()->id;
            $ins['from_time'] = $request->from_time_day3;
            $ins['to_time'] = $request->to_time_day3;
            $ins['day'] = 'WEDNESDAY';
            array_push($data, 'WEDNESDAY');
            $check1=UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', Auth::user()->id)->first();
            if(@$check1){
                UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', Auth::user()->id)->update($ins);
            }
            else{
                UserToAvailable::create($ins);
            }
        }
        if(@$request->day4){
            $ins['user_id'] = Auth::user()->id;
            $ins['from_time'] = $request->from_time_day4;
            $ins['to_time'] = $request->to_time_day4;
            $ins['day'] = 'THURSDAY';
            array_push($data, 'THURSDAY');
            $check1=UserToAvailable::where('day', 'THURSDAY')->where('user_id', Auth::user()->id)->first();
            if(@$check1){
                UserToAvailable::where('day', 'THURSDAY')->where('user_id', Auth::user()->id)->update($ins);
            }
            else{
                UserToAvailable::create($ins);
            }
        }
        if(@$request->day5){
            $ins['user_id'] = Auth::user()->id;
            $ins['from_time'] = $request->from_time_day5;
            $ins['to_time'] = $request->to_time_day5;
            $ins['day'] = 'FRIDAY';
            array_push($data, 'FRIDAY');
            $check1=UserToAvailable::where('day', 'FRIDAY')->where('user_id', Auth::user()->id)->first();
            if(@$check1){
                UserToAvailable::where('day', 'FRIDAY')->where('user_id', Auth::user()->id)->update($ins);
            }
            else{
                UserToAvailable::create($ins);
            }
        }
        if(@$request->day6){
            $ins['user_id'] = Auth::user()->id;
            $ins['from_time'] = $request->from_time_day6;
            $ins['to_time'] = $request->to_time_day6;
            $ins['day'] = 'SATURDAY';
            array_push($data, 'SATURDAY');
            $check1=UserToAvailable::where('day', 'SATURDAY')->where('user_id', Auth::user()->id)->first();
            if(@$check1){
                UserToAvailable::where('day', 'SATURDAY')->where('user_id', Auth::user()->id)->update($ins);
            }
            else{
                UserToAvailable::create($ins);
            }
        }
        if(@$request->day7){
            $ins['user_id'] = Auth::user()->id;
            $ins['from_time'] = $request->from_time_day7;
            $ins['to_time'] = $request->to_time_day7;
            $ins['day'] = 'SUNDAY';
            array_push($data, 'SUNDAY');
            $check1=UserToAvailable::where('day', 'SUNDAY')->where('user_id', Auth::user()->id)->first();
            if(@$check1){
                UserToAvailable::where('day', 'SUNDAY')->where('user_id', Auth::user()->id)->update($ins);
            }
            else{
                UserToAvailable::create($ins);
            }
        }
        UserToAvailable::whereNotIn('day', $data)->where('user_id', Auth::user()->id)->delete();
        session()->flash('success', \Lang::get('profile.availability_update'));
        return redirect()->route('pundit.availability');
    }
    /**
     *   Method      : pujaList
     *   Description : Pundits all puja data
     *   Author      : Soumojit
     *   Date        : 2021-APR-24
     **/
    public function pujaList()
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        $data['pujalist'] = PunditToPuja::where('user_id',Auth::user()->id)->orderBy('id','desc')->with('pujas')->get();
        $addedPuja=array();
        foreach($data['pujalist'] as $item){
            array_push($addedPuja, $item->puja_id);
        }
        $data['allPuja'] = Puja::whereNotIn('id', $addedPuja)->get();

        $data['userData'] = $userData;
        return view('modules.pundit.puja')->with($data);
    }
    /**
     *   Method      : pujAdd
     *   Description : Pundits puja data save
     *   Author      : Soumojit
     *   Date        : 2021-APR-24
     **/
    public function pujAdd(Request $request)
    {
        $request->validate([
            'puja' => 'required',
            // 'price' => 'required',
        ]);
        $ins=[];
        $ins['puja_id']= $request->puja;
        $ins['user_id']= Auth::user()->id;
        // $ins['price']= $request->price;
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        PunditToPuja::create($ins);
        session()->flash('success', \Lang::get('profile.puja_add_success'));
        return redirect()->route('pundit.puja');
    }
    /**
     *   Method      : pujaEdit
     *   Description : Pundits puja edit view
     *   Author      : Soumojit
     *   Date        : 2021-APR-24
     **/
    public function pujaEdit($id=null)
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        $data['pujalist'] = PunditToPuja::where('user_id', Auth::user()->id)->with('pujas')->orderBy('id','desc')->get();
        $data['selectPuja'] = PunditToPuja::where('id',$id)->where('user_id', Auth::user()->id)->with('pujas')->first();
        if($data['selectPuja']==null){
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('pundit.puja');
        }
        $addedPuja = array();
        foreach ($data['pujalist'] as $item) {
            if($data['selectPuja']->puja_id != $item->puja_id){

                array_push($addedPuja, $item->puja_id);
            }
        }
        $data['allPuja'] = Puja::whereNotIn('id', $addedPuja)->get();

        $data['userData'] = $userData;
        return view('modules.pundit.puja')->with($data);
    }
    /**
     *   Method      : pujaEditSave
     *   Description : Pundits puja price update
     *   Author      : Soumojit
     *   Date        : 2021-APR-24
     **/
    public function pujaEditSave(Request $request,$id=null)
    {
        $request->validate([
            'price' => 'required',
        ]);
        $upd = [];
        $upd['price'] = $request->price;
        $data['selectPuja'] = PunditToPuja::where('id', $id)->where('user_id', Auth::user()->id)->with('pujas')->first();
        if ($data['selectPuja'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('pundit.puja');
        }
        PunditToPuja::where('id', $id)->where('user_id', Auth::user()->id)->update($upd);
        session()->flash('success', \Lang::get('profile.puja_edit_success'));
        return redirect()->route('pundit.puja');
    }
    /**
     *   Method      : pujaDelete
     *   Description : Pundits puja delete
     *   Author      : Soumojit
     *   Date        : 2021-APR-24
     **/
    public function pujaDelete($id=null)
    {
        $data['selectPuja'] = PunditToPuja::where('id', $id)->where('user_id', Auth::user()->id)->with('pujas')->first();
        if ($data['selectPuja'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('pundit.puja');
        }
        PunditToPuja::where('id', $id)->where('user_id', Auth::user()->id)->delete();
        session()->flash('success', \Lang::get('profile.puja_delete_success'));
        return redirect()->route('pundit.puja');
    }
    /**
     *   Method      : changePassword
     *   Description : Pundits change password
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function changePassword()
    {
        return view('modules.pundit.change_password');
    }
    /**
     *   Method      : changePassword
     *   Description : Pundits change password save
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
        return redirect()->route('pundit.change.password');
    }

    /**
     *   Method      : mobileChange
     *   Description : Pundits Mobile number change and store temp mobile section
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
     *   Description : Pundits Wrong Temp OTP Check for Change mobile number
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
     *   Description : Pundits Mobile Change
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
                    return redirect()->route('pundit.profile');
                }
                $upd = [];
                $upd['mobile'] = $userData->temp_mobile;
                $upd['temp_otp'] = null;
                $upd['temp_mobile'] = null;
                $upd['is_mobile_verify'] = 'Y';
                $userUpdate = User::where('id', $userData->id)->update($upd);
                session()->flash('success', \Lang::get('profile.mobile_number_change'));
                return redirect()->route('pundit.profile');
            } else {
                session()->flash('error', \Lang::get('profile.mobile_number_not_change'));
                return redirect()->route('pundit.profile');
            }
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('pundit.profile');
    }


    /**
     *   Method      : checkemail
     *   Description : Pudnit Check Duplicate Email And Verifiy Mail
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
     *   Description : Pundit send mail
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
        Mail::send(new ChangeEmailPandit($data));
        return redirect()->back()->with('success',\Lang::get('profile.change_email_message'));
    }

    /**
     *   Method      : serviceZipCodeList
     *   Description : Pundits all service ZipCode List
     *   Author      : Soumojit
     *   Date        : 2021-AUG-05
     **/
    public function serviceZipCodeList()
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        $data['zipCodeList'] = PunditToZipcode::where('pundit_id',Auth::user()->id)->with('zip')->orderBy('id','desc')->get();
        $data['country'] = Country::get();
        $addedZipCode=array();
        foreach($data['zipCodeList'] as $item){
            array_push($addedZipCode, $item->zipcode_id);
        }
        $data['allZipCode'] = ZipMaster::whereNotIn('id', $addedZipCode)->get();

        $data['userData'] = $userData;
        return view('modules.pundit.service_zip_code')->with($data);
    }

    public function getZip(Request $request)
    {
        $data = ZipMaster::where('country_id',$request->country)->get();
        $response=array();
        $result="<option value=''>Select Zipcode</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
             $result.="<option value='".$rows->id."'>".$rows->zipcode."</option>";
            }
        }
        $response['zipcode']=$result;
        return response()->json($response);
    }

    public function checkZip(Request $request)
    {
        $check = PunditToZipcode::where('zipcode_id',$request->zipcode)->where('country_id',$request->country)->where('pundit_id',auth()->user()->id)->first();
        if ($check!="") {
            echo "found";
        }
    }

    /**
     *   Method      : serviceZipCodeAdd
     *   Description : Pundits service ZipCode data save
     *   Author      : Soumojit
     *   Date        : 2021-AUG-05
     **/
    public function serviceZipCodeAdd(Request $request)
    {
        $request->validate([
            'zipcode' => 'required',
            'country'=>"required",
        ]);
        $ins=[];
        $ins['zipcode_id']= $request->zipcode;
        $ins['country_id']= $request->country;
        $ins['pundit_id']= Auth::user()->id;
        PunditToZipcode::create($ins);
        session()->flash('success','Service Zip Code Added successfully');
        return redirect()->route('pundit.puja.service');
    }


    /**
     *   Method      : serviceZipCodeDelete
     *   Description : Pundits  service ZipCode delete
     *   Author      : Soumojit
     *   Date        : 2021-AUG-05
     **/
    public function serviceZipCodeDelete($id=null)
    {
        $data['selectZipCode'] = PunditToZipcode::where('id', $id)->where('pundit_id', Auth::user()->id)->first();
        if ($data['selectZipCode']== null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('pundit.puja.service');
        }
        PunditToZipcode::where('id', $id)->where('pundit_id', Auth::user()->id)->delete();
        session()->flash('success', 'Service Zip Code Deleted Successfully');
        return redirect()->route('pundit.puja.service');
    }

     /**
     *   Method      : verifyEmail
     *   Description : Pundit Check Duplicate Email And Verifiy Mail
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

 public function getstate(Request $request)
    {
        $data = State::where('country_id',$request->country)->get();
        $response=array();
        $result="<option value=''>Select State</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request->id==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->name."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->name."</option>";
                }

            }
        }
        $response['state']=$result;
        return response()->json($response);
    }







}
