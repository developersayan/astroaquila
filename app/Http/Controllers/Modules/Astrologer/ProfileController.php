<?php

namespace App\Http\Controllers\Modules\Astrologer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Gotra;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserAccount;
use App\Models\Expertise;
use App\Models\AstrologerToExpertise;
use App\Models\LanguageSpeak;
use App\Models\AstrologerToLanguages;
use App\Models\UserToAvailable;
use App\Models\AstrologerToEducation;
use App\Models\AstrologerToExperience;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Mail\ChangeAstrologerEmail;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\OrderMaster;
use App\Models\AstroTip;
use App\Models\AstrologerExclusionDateList;
use App\Models\ZipMaster;
use App\Models\Area;
use DB;
class ProfileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except('verifyEmail');
        $this->middleware('astrologer.access')->except('verifyEmail');
    }
    /**
     *   Method      : profile
     *   Description : Astrologer profile
     *   Author      : Soumojit
     *   Date        : 2021-APR-22
     **/
    public function profile()
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount', 'astrologerExpertise', 'astrologerLanguage')->first();

        $allExpertise= Expertise::get();

        $allLanguage= LanguageSpeak::get();

        $data['countries'] = Country::get();
        $data['states'] = State::where('country_id',auth()->user()->country_id)->get();
        $data['cities'] = City::where('state_id',auth()->user()->state)->get();
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
        $data['allExpertise'] = $allExpertise;
        $data['allLanguage'] = $allLanguage;

        return view('modules.astrologer.profile')->with($data);
    }
    /**
     *   Method      : profileEdit
     *   Description : Astrologer profile
     *   Author      : Soumojit
     *   Date        : 2021-APR-22
     **/
    public function profileEdit(Request $request)
    {
        // return $request;
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address'=>'required',
            // 'about' => 'required',
            'bank_name' => 'required',
            'ac_no' => 'required',
            'ifsc' => 'required',
            'name_of_account_holder' => 'required',
            'expertise' => 'required',
            'language' => 'required',
            'experience' => 'required',
         ]);

        $name = $request->first_name . ' ' . $request->last_name;
        $upd = [];
        $upd['first_name'] = $request->first_name;
        $upd['last_name'] = $request->last_name;
        $upd['gender'] = $request->gender;
        $upd['about'] = $request->about;
        $upd['why_who'] = $request->why_who;
        $upd['city'] = $request->city;
        $upd['state'] = $request->state;
        $upd['address'] = $request->address;
        $upd['country_id'] = $request->country;
        // pricing-related
        if (@$request->audio_call_check) {
            $upd['is_audio_call'] = 'Y';
            $upd['call_price'] = $request->call_price;
            $upd['call_price_usd'] = $request->call_price_usd;
            if ($request->call_discount_inr==null) {
               $upd['call_discount_inr'] = 0;
            }else{
                $upd['call_discount_inr'] = $request->call_discount_inr;
            }

            if ($request->call_discount_usd==null) {
               $upd['call_discount_usd'] = 0;
            }else{
                $upd['call_discount_usd'] = $request->call_discount_usd;
            }

            $upd['call_discount_usd'] = $request->call_discount_usd;
            $upd['avail_now_audio_call'] = $request->avail_now_audio_call;
        }else{
            $upd['is_audio_call'] = 'N';
            $upd['call_price'] = 0;
            $upd['call_price_usd'] = 0;
            $upd['call_discount_inr'] = 0;
            $upd['call_discount_usd'] = 0;
            $upd['avail_now_audio_call'] = 'N';
        }



        if (@$request->video_call_check) {

            $upd['is_video_call'] = 'Y';
            $upd['video_call_price_inr'] = $request->video_call_price_inr;
            $upd['video_call_price_usd'] = $request->video_call_price_usd;

            if ($request->video_call_discount_inr==null) {
               $upd['video_call_discount_inr'] = 0;
            }else{
                $upd['video_call_discount_inr'] = $request->video_call_discount_inr;
            }

            if ($request->video_call_discount_usd==null) {
               $upd['video_call_discount_usd'] = 0;
            }else{
                $upd['video_call_discount_usd'] = $request->video_call_discount_usd;
            }



            $upd['avail_now_video_call'] = $request->avail_now_video_call;
        }else{
            $upd['is_video_call'] = 'N';
            $upd['video_call_price_inr'] = 0;
            $upd['video_call_price_usd'] = 0;
            $upd['video_call_discount_inr'] = 0;
            $upd['video_call_discount_usd'] = 0;
            $upd['avail_now_video_call'] = 'N';
        }



        if (@$request->chat_check) {
            $upd['is_chat'] = 'Y';
            $upd['chat_price_inr'] = $request->chat_price_inr;
            $upd['chat_price_usd'] = $request->chat_price_usd;

            if ($request->chat_discount_inr==null) {
               $upd['chat_discount_inr'] = 0;
            }else{
                $upd['chat_discount_inr'] = $request->chat_discount_inr;
            }

            if ($request->chat_discount_usd==null) {
               $upd['chat_discount_usd'] = 0;
            }else{
                $upd['chat_discount_usd'] = $request->chat_discount_usd;
            }

            $upd['avail_now_chat'] = $request->avail_now_chat;
        }else{
            $upd['is_chat'] = 'N';
            $upd['chat_price_inr'] = 0;
            $upd['chat_price_usd'] = 0;
            $upd['chat_discount_inr'] = 0;
            $upd['chat_discount_usd'] = 0;
            $upd['avail_now_chat'] = 'N';
        }

        $upd['experience'] = $request->experience;
        $upd['Ac_Type'] = $request->profile_type;
        $upd['pincode'] = $request->pincode;
        $upd['gst_no'] = $request->gst_no;
        $upd['user_availability'] = $request->user_availability;
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

        $account = UserAccount::where('user_id', Auth::user()->id)->first();

        $upd1 = [];
        $upd1['bank_name'] = $request->bank_name;
        $upd1['ac_no'] = $request->ac_no;
        $upd1['ifsc_code'] = $request->ifsc;
        $upd1['account_holder'] = $request->name_of_account_holder;
        if (@$account) {
            UserAccount::where('user_id', Auth::user()->id)->update($upd1);
        } else {
            $upd1['user_id'] = Auth::user()->id;
            UserAccount::create($upd1);
        }
        $expertise = explode(",", $request->expertise);
        foreach ($expertise as $item) {
            $insExpertise = [];
            $insExpertise['user_id'] = Auth::user()->id;
            $insExpertise['expertise_id'] = $item;
            $checkAvailable = AstrologerToExpertise::where('user_id', Auth::user()->id)->where('expertise_id', $item)->first();
            if ($checkAvailable == null) {
                AstrologerToExpertise::create($insExpertise);
            }
        }
        AstrologerToExpertise::where('user_id', Auth::user()->id)->whereNotIn('expertise_id', $expertise)->delete();

        $language = explode(",", $request->language);
        foreach ($language as $item2) {

            $insLanguage = [];
            $insLanguage['user_id'] = Auth::user()->id;
            $insLanguage['language_id'] = $item2;
            $checkAvailable = AstrologerToLanguages::where('user_id', Auth::user()->id)->where('language_id', $item2)->first();
            if ($checkAvailable == null) {
                AstrologerToLanguages::create($insLanguage);
            }
        }
        AstrologerToLanguages::where('user_id', Auth::user()->id)->whereNotIn('language_id', $language)->delete();


        session()->flash('success', \Lang::get('profile.profile_updated'));
        return redirect()->route('astrologer.profile');
    }
    /**
     *   Method      : dashboard
     *   Description : Astrologer profile
     *   Author      : Soumojit
     *   Date        : 2021-APR-22
     **/
    public function dashboard(Request $request)
    {
		if(@$request->all())
		{
			//dd(@$request->all());
			$update=array();
			if(@$request->avail_now_audio_call=='Y')
			{
				$update['avail_now_audio_call']='Y';
			}
			else
			{
				$update['avail_now_audio_call']='N';
			}
			if(@$request->avail_now_video_call=='Y')
			{
				$update['avail_now_video_call']='Y';
			}
			else
			{
				$update['avail_now_video_call']='N';
			}
			if(@$request->avail_now_chat=='Y')
			{
				$update['avail_now_chat']='Y';
			}
			else
			{
				$update['avail_now_chat']='N';
			}
			$current_details=User::where('id', Auth::user()->id)->first();
			if(strtotime(@$current_details->instant_booking_expiry)>time())
			{
				$update['instant_booking_expiry']=date('Y-m-d H:i:s',strtotime('+ '.$request->instant_booking_expiry.' minute',strtotime(@$current_details->instant_booking_expiry)));
			}
			else
			{
				$update['instant_booking_expiry']=date('Y-m-d H:i:s',strtotime('+ '.$request->instant_booking_expiry.' minute'));
			}			
			$update['instant_booking_duration']=$request->instant_booking_expiry;
			User::where('id', Auth::user()->id)->update($update);
			return redirect()->back()->with('success','Instant availability successfully added.');
		}
        $userData = User::where('id', Auth::user()->id)->with('userAccount', 'astrologerExpertise', 'astrologerLanguage')->first();

        $allExpertise = Expertise::get();

        $allLanguage = LanguageSpeak::get();


        $data['userData'] = $userData;
        $data['allExpertise'] = $allExpertise;
        $data['allLanguage'] = $allLanguage;
		$data['last_three_orders']=OrderMaster::where('customer_id',auth()->user()->id)->where('payment_status','p')->orderBy('id','desc')->limit(3)->get();
        return view('modules.astrologer.dashboard')->with($data);
    }
    /**
     *   Method      : availability
     *   Description : Astrologer availability view
     *   Author      : Soumojit
     *   Date        : 2021-APR-24
     **/
    public function availability()
    {
        $userData = User::where('id', Auth::user()->id)->with('userAccount')->first();
        $data['monday'] = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->get();
        $data['tuesday'] = UserToAvailable::where('day', 'TUESDAY')->where('user_id', Auth::user()->id)->get();
        $data['wednesday'] = UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', Auth::user()->id)->get();
        $data['thursday'] = UserToAvailable::where('day', 'THURSDAY')->where('user_id', Auth::user()->id)->get();
        $data['friday'] = UserToAvailable::where('day', 'FRIDAY')->where('user_id', Auth::user()->id)->get();
        $data['saturday'] = UserToAvailable::where('day', 'SATURDAY')->where('user_id', Auth::user()->id)->get();
        $data['sunday'] = UserToAvailable::where('day', 'SUNDAY')->where('user_id', Auth::user()->id)->get();
        $data['userData'] = $userData;
        $data['slots'] = array ();// Define output
        $starttime = '00:00';  // your start time
        $endtime = '24:00';
        $StartTime    = strtotime ($starttime); //Get Timestamp
        $EndTime      = strtotime ($endtime); //Get Timestamp

        $AddMins  = 15 * 60;

        while ($StartTime <= $EndTime) //Run loop
        {
            $ReturnArray[] = date ("H:i:s ", $StartTime);
            $StartTime += $AddMins; //Endtime check
        }
        $data['slots'] = array_slice($ReturnArray, 0, -1);
        return view('modules.astrologer.availability')->with($data);
    }
    /**
     *   Method      : availabilitySave
     *   Description : Astrologer availability save
     *   Author      : Soumojit
     *   Date        : 2021-APR-23
     **/
    public function availabilitySave(Request $request)
    {
        $ins = [];
        $data = array();
        if (@$request->day1) {
            array_push($data, 'MONDAY');
            $monday_id =array();
            foreach (@$request->monday_slot as  $value) {
                $c = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = Auth::user()->id;
                $ins['from_time'] = $value;
                $final = date('H:i:s',strtotime('+14 minutes +59 seconds',strtotime($value)));
                $ins['to_time'] = $final;
                $ins['day'] = 'MONDAY';
                $ins['day_id'] = '1';
                $monday = UserToAvailable::create($ins);
                array_push($monday_id, $monday->id);
              }else{
                 array_push($monday_id,$c->id);
              }
            }
            UserToAvailable::where('day','MONDAY')->whereNotIn('id',$monday_id)->delete();
            // $ins['user_id'] = Auth::user()->id;
            // $ins['from_time'] = $request->from_time_day1;
            // $ins['to_time'] = $request->to_time_day1;
            // $ins['day'] = 'MONDAY';
            // array_push($data, 'MONDAY');
            // $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            // if (@$check1) {
            //     UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            // } else {
            //     UserToAvailable::create($ins);
            // }
        }

         if (@$request->day2) {
            array_push($data, 'TUESDAY');

            $tuesday_id =array();

            foreach (@$request->tuesday_slot as  $value) {
                $c = UserToAvailable::where('day', 'TUESDAY')->where('user_id', Auth::user()->id)->where('from_time',$value)->first();
                if (@$c==null) {
                    $ins['user_id'] = Auth::user()->id;
                    $ins['from_time'] = $value;
                    $final = date('H:i:s',strtotime('+14 minutes +59 seconds',strtotime($value)));
                    $ins['to_time'] = $final;
                    $ins['day'] = 'TUESDAY';
                    $ins['day_id'] = '2';
                    $tuesday = UserToAvailable::create($ins);
                    array_push($tuesday_id, $tuesday->id);
                }else{
                array_push($tuesday_id, $c->id);
               }

            }
            UserToAvailable::where('day','TUESDAY')->whereNotIn('id',$tuesday_id)->delete();

            // $ins['user_id'] = Auth::user()->id;
            // $ins['from_time'] = $request->from_time_day1;
            // $ins['to_time'] = $request->to_time_day1;
            // $ins['day'] = 'MONDAY';
            // array_push($data, 'MONDAY');
            // $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            // if (@$check1) {
            //     UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            // } else {
            //     UserToAvailable::create($ins);
            // }
        }

        if (@$request->day3) {
            array_push($data, 'WEDNESDAY');
            $wednesday_id =array();
            foreach (@$request->wednesday_slot as  $value) {
                $c = UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', Auth::user()->id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = Auth::user()->id;
                $ins['from_time'] = $value;
                $final = date('H:i:s',strtotime('+14 minutes +59 seconds',strtotime($value)));
                $ins['to_time'] = $final;
                $ins['day'] = 'WEDNESDAY';
                $ins['day_id'] = '3';
                $wednesday = UserToAvailable::create($ins);
                array_push($wednesday_id, $wednesday->id);
               }else{
                array_push($wednesday_id, $c->id);
               }
            }
            UserToAvailable::where('day','WEDNESDAY')->whereNotIn('id',$wednesday_id)->delete();
            // $ins['user_id'] = Auth::user()->id;
            // $ins['from_time'] = $request->from_time_day1;
            // $ins['to_time'] = $request->to_time_day1;
            // $ins['day'] = 'MONDAY';
            // array_push($data, 'MONDAY');
            // $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            // if (@$check1) {
            //     UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            // } else {
            //     UserToAvailable::create($ins);
            // }
        }


        if (@$request->day4) {
            array_push($data, 'THURSDAY');
            $thursday_id =array();
            foreach (@$request->thursday_slot as  $value) {
                $c = UserToAvailable::where('day', 'THURSDAY')->where('user_id', Auth::user()->id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = Auth::user()->id;
                $ins['from_time'] = $value;
                $final = date('H:i:s',strtotime('+14 minutes +59 seconds',strtotime($value)));
                $ins['to_time'] = $final;
                $ins['day'] = 'THURSDAY';
                $ins['day_id'] = '4';
                UserToAvailable::create($ins);
                $thursday = UserToAvailable::create($ins);
                array_push($thursday_id, $thursday->id);
               }else{
                array_push($thursday_id, $c->id);
               }
            }
             UserToAvailable::where('day','THURSDAY')->whereNotIn('id',$thursday_id)->delete();
            // $ins['user_id'] = Auth::user()->id;
            // $ins['from_time'] = $request->from_time_day1;
            // $ins['to_time'] = $request->to_time_day1;
            // $ins['day'] = 'MONDAY';
            // array_push($data, 'MONDAY');
            // $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            // if (@$check1) {
            //     UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            // } else {
            //     UserToAvailable::create($ins);
            // }
        }


        if (@$request->day5) {
            array_push($data, 'FRIDAY');
            $firday_id =array();
            foreach (@$request->friday_slot as  $value) {
                 $c = UserToAvailable::where('day', 'FRIDAY')->where('user_id', Auth::user()->id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = Auth::user()->id;
                $ins['from_time'] = $value;
                $final = date('H:i:s',strtotime('+14 minutes +59 seconds',strtotime($value)));
                $ins['to_time'] = $final;
                $ins['day'] = 'FRIDAY';
                $ins['day_id'] = '5';
                UserToAvailable::create($ins);
                $friday = UserToAvailable::create($ins);
                array_push($firday_id, $friday->id);
             }else{
                array_push($firday_id, $c->id);
             }
            }
            UserToAvailable::where('day','FRIDAY')->whereNotIn('id',$firday_id)->delete();
            // $ins['user_id'] = Auth::user()->id;
            // $ins['from_time'] = $request->from_time_day1;
            // $ins['to_time'] = $request->to_time_day1;
            // $ins['day'] = 'MONDAY';
            // array_push($data, 'MONDAY');
            // $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            // if (@$check1) {
            //     UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            // } else {
            //     UserToAvailable::create($ins);
            // }
        }

          if (@$request->day6) {
            array_push($data, 'SATURDAY');
            $saturday_id =array();
            foreach (@$request->saturday_slot as  $value) {
                 $c = UserToAvailable::where('day', 'SATURDAY')->where('user_id', Auth::user()->id)->where('from_time',$value)->first();
                 if (@$c==null) {
                $ins['user_id'] = Auth::user()->id;
                $ins['from_time'] = $value;
                $final = date('H:i:s',strtotime('+14 minutes +59 seconds',strtotime($value)));
                $ins['to_time'] = $final;
                $ins['day'] = 'SATURDAY';
                $ins['day_id'] = '6';
                UserToAvailable::create($ins);
                $saturday = UserToAvailable::create($ins);
                array_push($saturday_id, $saturday->id);
              }else{
                array_push($saturday_id, $c->id);
             }
            }
            UserToAvailable::where('day','SATURDAY')->whereNotIn('id',$saturday_id)->delete();
            // $ins['user_id'] = Auth::user()->id;
            // $ins['from_time'] = $request->from_time_day1;
            // $ins['to_time'] = $request->to_time_day1;
            // $ins['day'] = 'MONDAY';
            // array_push($data, 'MONDAY');
            // $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            // if (@$check1) {
            //     UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            // } else {
            //     UserToAvailable::create($ins);
            // }
        }

         if (@$request->day7) {
            array_push($data, 'SUNDAY');
             $sunday_id =array();
            foreach (@$request->sunday_slot as  $value) {
                $c = UserToAvailable::where('day', 'SUNDAY')->where('user_id', Auth::user()->id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = Auth::user()->id;
                $ins['from_time'] = $value;
                $final = date('H:i:s',strtotime('+14 minutes +59 seconds',strtotime($value)));
                $ins['to_time'] = $final;
                $ins['day'] = 'SUNDAY';
                $ins['day_id'] = '0';
                UserToAvailable::create($ins);
                $sunday = UserToAvailable::create($ins);
                array_push($sunday_id, $sunday->id);
             }else{
                array_push($sunday_id, $c->id);
             }
            }
            UserToAvailable::where('day','SUNDAY')->whereNotIn('id',$sunday_id)->delete();
            // $ins['user_id'] = Auth::user()->id;
            // $ins['from_time'] = $request->from_time_day1;
            // $ins['to_time'] = $request->to_time_day1;
            // $ins['day'] = 'MONDAY';
            // array_push($data, 'MONDAY');
            // $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->first();
            // if (@$check1) {
            //     UserToAvailable::where('day', 'MONDAY')->where('user_id', Auth::user()->id)->update($ins);
            // } else {
            //     UserToAvailable::create($ins);
            // }
        }

        UserToAvailable::whereNotIn('day', $data)->where('user_id', Auth::user()->id)->delete();
        session()->flash('success', \Lang::get('profile.availability_update'));
        return redirect()->route('astrologer.availability');
    }

    /**
     *   Method      : educationList
     *   Description : Astrologer education list
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function educationList()
    {
        $data['educationList'] = AstrologerToEducation::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('modules.astrologer.education')->with($data);
    }
    /**
     *   Method      : educationAdd
     *   Description : Astrologer education add
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function educationAdd(Request $request)
    {
        // return $request;
        $request->validate([
            'education_title' => 'required',
            'institute' => 'required',
            'year_of_passing' => 'required',
        ]);

        $ins=[];
        $ins['year_of_passing'] = $request->year_of_passing;
        $ins['education_title'] = $request->education_title;
        $ins['institute'] = $request->institute;
        $ins['user_id'] = Auth::user()->id;
        if(@$request->image){
            if(@$request->astro_image && file_exists('storage/app/public/education_image/'.@$request->astro_image)){
                unlink('storage/app/public/education_image/'.@$request->astro_image);
            }
            $image = $request->image;
            $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $image->move('storage/app/public/education_image/',$filename);
            $ins['image'] = $filename;
        }
        AstrologerToEducation::create($ins);
        session()->flash('success', \Lang::get('profile.education_added'));
        return redirect()->route('astrologer.education');
    }
    /**
     *   Method      : educationEdit
     *   Description : Astrologer education edit
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function educationEdit($id=null)
    {
        $data['educationList'] = AstrologerToEducation::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        $data['education'] = AstrologerToEducation::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($data['education'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('astrologer.education');
        }
        return view('modules.astrologer.education')->with($data);
    }
    /**
     *   Method      : educationUpdate
     *   Description : Astrologer education update
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function educationUpdate(Request $request,$id = null)
    {
        // return $request;
        $request->validate([
            'education_title' => 'required',
            'institute' => 'required',
            'year_of_passing' => 'required',
        ]);

        $upd=[];
        $upd['year_of_passing'] = $request->year_of_passing;
        $upd['education_title'] = $request->education_title;
        $upd['institute'] = $request->institute;
        $upd['user_id'] = Auth::user()->id;
        if(@$request->image){
            if(@$request->astro_image && file_exists('storage/app/public/education_image/'.@$request->astro_image)){
                unlink('storage/app/public/education_image/'.@$request->astro_image);
            }
            $image = $request->image;
            $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $image->move('storage/app/public/education_image/',$filename);
            $upd['image'] = $filename;
        }
        $data['education'] = AstrologerToEducation::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($data['education'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('astrologer.education');
        }
        AstrologerToEducation::where('user_id', Auth::user()->id)->where('id', $id)->update($upd);
        session()->flash('success', \Lang::get('profile.profile_updated'));
        return redirect()->route('astrologer.education');
    }
    /**
     *   Method      : educationEdit
     *   Description : Astrologer education list
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function educationDelete($id = null)
    {
        $data['education'] = AstrologerToEducation::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($data['education'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('astrologer.education');
        }
        AstrologerToEducation::where('user_id', Auth::user()->id)->where('id', $id)->delete();
        session()->flash('success', \Lang::get('profile.education_deleted'));
        return redirect()->route('astrologer.education');
    }




    /**
     *   Method      : educationList
     *   Description : Astrologer experience list
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function experienceList()
    {
        $data['experienceList'] = AstrologerToExperience::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        return view('modules.astrologer.experience')->with($data);
    }
    /**
     *   Method      : experienceAdd
     *   Description : Astrologer experience Add
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function experienceAdd(Request $request)
    {
        // return $request;
        $request->validate([
            'experience_title' => 'required',
            'description' => 'required',
            'year_of_experience' => 'required',
        ]);

        $ins = [];
        $ins['year_of_experience'] = $request->year_of_experience;
        $ins['experience_title'] = $request->experience_title;
        $ins['description'] = $request->description;
        $ins['user_id'] = Auth::user()->id;
        if(@$request->image){
            if(@$request->astro_image && file_exists('storage/app/public/experience_image/'.@$request->astro_image)){
                unlink('storage/app/public/experience_image/'.@$request->astro_image);
            }
            $image = $request->image;
            $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $image->move('storage/app/public/experience_image/',$filename);
            $ins['image'] = $filename;
        }
        AstrologerToExperience::create($ins);
        session()->flash('success', \Lang::get('profile.experience_added'));
        return redirect()->route('astrologer.experience');
    }
    /**
     *   Method      : educationEdit
     *   Description : Astrologer experience edit
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function experienceEdit($id = null)
    {
        $data['experienceList'] = AstrologerToExperience::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
        $data['experience'] = AstrologerToExperience::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($data['experience'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('astrologer.experience');
        }
        return view('modules.astrologer.experience')->with($data);
    }
    /**
     *   Method      : educationUpdate
     *   Description : Astrologer experience update
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function experienceUpdate(Request $request, $id = null)
    {
        // return $request;
        $request->validate([
            'experience_title' => 'required',
            'description' => 'required',
            'year_of_experience' => 'required',
        ]);

        $upd = [];
        $upd['year_of_experience'] = $request->year_of_experience;
        $upd['experience_title'] = $request->experience_title;
        $upd['description'] = $request->description;
        $upd['user_id'] = Auth::user()->id;
        if(@$request->image){
            if(@$request->astro_image && file_exists('storage/app/public/experience_image/'.@$request->astro_image)){
                unlink('storage/app/public/experience_image/'.@$request->astro_image);
            }
            $image = $request->image;
            $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $image->move('storage/app/public/experience_image/',$filename);
            $upd['image'] = $filename;
        }
        $data['experience'] = AstrologerToExperience::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($data['experience'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('astrologer.experience');
        }
        AstrologerToExperience::where('user_id', Auth::user()->id)->where('id', $id)->update($upd);
        session()->flash('success', \Lang::get('profile.experience_updated'));
        return redirect()->route('astrologer.experience');
    }
    /**
     *   Method      : experienceDelete
     *   Description : Astrologer experience delete
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function experienceDelete($id = null)
    {
        $data['experience'] = AstrologerToExperience::where('user_id', Auth::user()->id)->where('id', $id)->first();
        if ($data['experience'] == null) {
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->route('astrologer.experience');
        }
        AstrologerToExperience::where('user_id', Auth::user()->id)->where('id', $id)->delete();
        session()->flash('success', \Lang::get('profile.experience_deleted'));
        return redirect()->route('astrologer.experience');
    }
    /**
     *   Method      : changePassword
     *   Description : Astrologer change password
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function changePassword(){
        return view('modules.astrologer.change_password');
    }
    /**
     *   Method      : changePassword
     *   Description : Astrologer change password save
     *   Author      : Soumojit
     *   Date        : 2021-APR-26
     **/
    public function changePasswordSave(Request $request){
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
        return redirect()->route('astrologer.change.password');
    }
    /**
     *   Method      : mobileChange
     *   Description : Astrologer Mobile number change and store temp mobile section
     *   Author      : Soumojit
     *   Date        : 2021-MAY-07
     **/
    public function mobileChange(Request $request)
    {
        $userData = User::where('id', auth()->user()->id)->where('status', '!=', 'D')->first();
        if (@$userData) {
            $upd['temp_otp'] = mt_rand(100000, 999999);
            $upd['temp_mobile'] =$request->mobile;
            $userUpdate = User::where('id', $userData->id)->update($upd);
            $userData= User::where('id', $userData->id)->first();
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
     *   Description : Astrologer Wrong Temp OTP Check for Change mobile number
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

            } else{
                return response('false');
            }
        }
        return response('false');
    }
    /**
     *   Method      : mobileChangeSubmit
     *   Description : Astrologer Mobile Change
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
                if($checkMobile>0){
                    session()->flash('error', \Lang::get('profile.mobile_number_unique'));
                    return redirect()->route('astrologer.profile');
                }
                $upd=[];
                $upd['mobile']= $userData->temp_mobile;
                $upd['temp_otp']= null;
                $upd['temp_mobile']= null;
                $upd['is_mobile_verify']= 'Y';
                $userUpdate = User::where('id', $userData->id)->update($upd);
                session()->flash('success', \Lang::get('profile.mobile_number_change'));
                return redirect()->route('astrologer.profile');
            } else {
                session()->flash('error', \Lang::get('profile.mobile_number_not_change'));
                return redirect()->route('astrologer.profile');
            }
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('astrologer.profile');
    }

     /**
     *   Method      : checkemail
     *   Description : Astrologer Check Duplicate Email
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
     *   Description : Astrologer send mail
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
        Mail::send(new ChangeAstrologerEmail($data));
        return redirect()->back()->with('success',\Lang::get('profile.change_email_message'));
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

    public function checkedu(Request $request)
    {
         if (@$request->id) {
            $check = AstrologerToEducation::where('education_title',$request->education_title)->where('user_id',auth()->user()->id)->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
        }else{
        $check = AstrologerToEducation::where('education_title',$request->education_title)->where('user_id',auth()->user()->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
      }
    }

    public function checkexp(Request $request)
    {
        if (@$request->id) {
            $check = AstrologerToExperience::where('experience_title',$request->experience_title)->where('user_id',auth()->user()->id)->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
        }else{
        $check = AstrologerToExperience::where('experience_title',$request->experience_title)->where('user_id',auth()->user()->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
      }
    }
	/**
     *   Method      : dateExclusionList
     *   Description : Astrologer date exclusion list
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-11
     **/
    public function dateExclusionList(Request $request)
    {
		if(@$request->all())
		{
			$insert=array();
            $date_form = strtotime(date('Y-m-d', strtotime($request->exclusion_from_date)));
            $date_to = strtotime(date('Y-m-d',strtotime($request->exclusion_to_date)));
            $day_array = array();

            if($request->exclusion_to_date == null){
                $insert['astrologer_id']=Auth::user()->id;
                $insert['date']=date('Y-m-d',strtotime($request->exclusion_from_date));
                $check_duplicate=AstrologerExclusionDateList::where($insert)->first();
                if(@$check_duplicate)
                {
                	return redirect()->back()->with('error','The date already added in exclusion list');
                }
                else
                {
                	AstrologerExclusionDateList::create($insert);
                }
            }else{
                // Use for loop to store dates into array
                // 86400 sec = 24 hrs
                for ($currentDate = $date_form; $currentDate <= $date_to;
                    $currentDate += (86400)) {

                    $date = date('Y-m-d', $currentDate);

                    $insert['astrologer_id']=Auth::user()->id;
                    $insert['date']=$date;
                    $check_duplicate=AstrologerExclusionDateList::where($insert)->first();
                    if(@$check_duplicate)
                    {
                        array_push($day_array, date('d/m/Y',strtotime($date)) .' already added in exclusion list');
                    }
                    else
                    {
                        AstrologerExclusionDateList::create($insert);
                    }
                }
            }

            if(count($day_array) > 0){
                $errors = implode(' <br> ',$day_array);

                return redirect()->back()->with('error',$errors);
            }else{
                return redirect()->back()->with('success','Exclusion date successfully added');
            }
			// $insert['astrologer_id']=Auth::user()->id;
			// $insert['date']=date('Y-m-d',strtotime($request->exclusion_date));
			// $check_duplicate=AstrologerExclusionDateList::where($insert)->first();
			// if(@$check_duplicate)
			// {
			// 	return redirect()->back()->with('error','The date already added in exclusion list');
			// }
			// else
			// {
			// 	AstrologerExclusionDateList::create($insert);
			// }
			// return redirect()->back()->with('success','Exclusion date successfully added');
		}
        $data['datelist'] = AstrologerExclusionDateList::where('astrologer_id',Auth::user()->id)->orderBy('id','desc')->get();
        return view('modules.astrologer.exclusion_date')->with($data);
    }
	/**
     *   Method      : dateExclusionDelete
     *   Description : Astrologer exclusion date delete
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-11
     **/
    public function dateExclusionDelete($id)
    {
        $datedetails=AstrologerExclusionDateList::where('id',$id)->first();
		if(!$datedetails)
		{
			return redirect()->back()->with('error','Something went wrong');
		}
        AstrologerExclusionDateList::where('id',$id)->delete();
		return redirect()->back()->with('success','Exclusion date successfully deleted');
    }

    /**
     *   Method      : manageAstroTips
     *   Description : manage astrologer tips
     *   Author      : Argha
     *   Date        : 2021-DEC-14
     **/

     public function manageAstroTips(Request $request,$id = null)
     {
        $data = array();
        if($id){
            $data['tip'] = AstroTip::where('id',$id)->first();
        }
        if($request->all()){
            $arr['heading'] = $request->heading;
            $arr['astrologer_id'] = Auth::user()->id;
            $arr['description'] = $request->description;
            if(@$request->tip_id){
                AstroTip::where('id',$request->tip_id)->update($arr);
                session()->flash('success','Astro tip updated successfully.');
                return redirect()->back();
            }else{
                AstroTip::create($arr);
                session()->flash('success','Astro tip added successfully.');
                return redirect()->back();
            }
        }
        $data['tips'] = AstroTip::where('astrologer_id',Auth::user()->id)->get();
        return view('modules.astrologer.edit_astro_tips')->with($data);
     }

     /**
     *   Method      : deleteAstroTips
     *   Description : delete astrologer tips
     *   Author      : Argha
     *   Date        : 2021-DEC-14
     **/

    public function deleteAstroTips($id)
    {
        AstroTip::where('id',$id)->delete();
        session()->flash('success','Astro tip deleted successfully.');
        return redirect()->route('manage.astro.tips');
    }

    public function checkAudioMobile(Request $request)
    {
      if ($request->mobile) {
            $checkMobile = User::whereIn('status', ['A', 'I', 'U'])->where('audio_mobile_no', $request->mobile)->count();
            if ($checkMobile > 0) {
                return response('false');
            } else {
                return response('true');
            }
        }
        return response('no mobile');
    }


    public function changeAudioMobile(Request $request)
    {
        $userData = User::where('id',auth()->user()->id)->where('status', '!=', 'D')->first();
        if (@$userData) {
            $upd['audio_temp_otp'] = mt_rand(100000, 999999);
            $upd['audio_temp_mobile'] =$request->mobile;
            $userUpdate = User::where('id', $userData->id)->update($upd);
            $userData= User::where('id', $userData->id)->first();
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


    public function checkOtpAudioMobile(Request $request)
    {
        $otp = @$request->otpBox1 . @$request->otpBox2 . @$request->otpBox3 . @$request->otpBox4 . @$request->otpBox5 . @$request->otpBox6;
        // dd($otp);
        $userData = User::where('id', auth()->user()->id)->first();
        if (@$userData) {
           if (@$userData->audio_temp_otp == $otp) {
                return response('true');
            } else{
                return response('false');
            }
        }
        return response('false');
    }



    public function changeAudioMobileSubmit(Request $request)
    {
        $userData = User::where('id',auth()->user()->id)->first();
        $upd=[];
        $upd['audio_mobile_no']= $userData->audio_temp_mobile;
        $upd['audio_temp_otp']= null;
        $upd['audio_temp_mobile']= null;
        $userUpdate = User::where('id', $userData->id)->update($upd);
        session()->flash('success','Audio Mobile Number Changed Successfully');
        return redirect()->back();
    }


    public function suggestion($id)
    {
        $data = [];
        $data['order'] = OrderMaster::where('order_id',$id)->first();
        return view('modules.astrologer.suggestion',$data);
    }

    public function submitSuggestion(Request $request)
    {   

            if ($request->astro_suggestion=='' && $request->astro_suggestion_attachment=='') {
                return redirect()->route('astrologer.call.history');
            }

            $upd = [];

            $upd['astro_suggestion'] = $request->astro_suggestion;

            if($request->astro_suggestion_attachment){
                    $file = $request->astro_suggestion_attachment;
                    $filename = time() . '-' . rand(1000, 9999) .'_'. $file->getClientOriginalName();
                    \Storage::putFileAs('public/astro_suggestion_attachment', $file, $filename);
                    $upd['astro_suggestion_attachment'] = $filename;
            }

            OrderMaster::where('id',$request->id)->update($upd);
            
            return redirect()->route('astrologer.call.history')->with('success','Feedback/Suggestion Submitted Successfully');
        
    }





}
