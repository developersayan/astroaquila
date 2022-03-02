<?php

namespace App\Http\Controllers\Admin\Modules\Pandit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Country;
use App\Models\State;
use App\Models\UserAccount;
use App\Models\UserToAvailable;
use App\Models\PunditToPuja;
use App\Models\Puja;
use App\Models\PunditToZipcode;
use App\Models\ZipMaster;
use Hash;
use Mail;
use App\Mail\UserResetPassword;

class PanditController extends Controller
{
    //
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
     *   Method      : index
     *   Description : show pandit manage view with serach funtionality
     *   Author      : Sayan
     *   Date        : 2021-MAY-3
     **/

    public function index(Request $request)
    {
        $data = [];
        $data['pundits'] = User::where('user_type','P')->where('status','!=','D')->orderBy('id', 'desc');
        if (@$request->keyword) {
            $data['pundits'] = $data['pundits']->where(function($query){
                $query->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' "
                        )
                      ->orWhere('email','LIKE','%'.request('keyword').'%')
                      ->orWhere('mobile','LIKE','%'.request('keyword').'%')
                      ->orWhere('user_unique_code','LIKE','%'.request('keyword').'%')
                      ->orWhere('address','LIKE','%'.request('keyword').'%');
            });
         }

        if (@$request->city) {
            $data['pundits'] = $data['pundits']->where('city','LIKE','%'.request('city').'%');
        }

      if (@$request->avail) {
        $data['pundits'] = $data['pundits']->where('user_availability',@$request->avail);
      }

        if (@$request->status) {
            $data['pundits'] = $data['pundits']->where(function($query){
                $query->where('status',request('status'))
                      ->orWhere('approve_by_admin',request('status'));
            });
        }

        if (@$request->type) {
            $data['pundits'] = $data['pundits']->where('puja_type',request('type'));
        }

        $data['pundits'] = $data['pundits']->paginate(10);
        return view('admin.modules.pandit.manage_pandit',$data);
    }

     /**
     *   Method      : status
     *   Description : pundit change status active/inactive
     *   Author      : Sayan
     *   Date        : 2021-MAY-3
     **/

    public function status($id)
    {
        $data = User::where('id',$id)->where('status','!=','D')->where('user_type','P')->first();
        if ($data==null) {
            return redirect()->back();
        }
        if ($data->status=="A") {
            $inactive = User::where('id',$id)->update(['status'=>'I']);
            return redirect()->back()->with('success','Pundit Status Deactivated Successfully');
        }

        if ($data->status=="I") {
            $inactive = User::where('id',$id)->update(['status'=>'A']);
            return redirect()->back()->with('success','Pundit Status Activated Successfully');
        }
    }

    /**
     *   Method      : approve
     *   Description : pundit account approval
     *   Author      : Sayan
     *   Date        : 2021-MAY-3
     **/

     public function approve($id)
     {
        $data = User::where('id',$id)->where('status','!=','D')->where('user_type','P')->first();
        if ($data==null) {
            return redirect()->back();
        }
        $upd=[];
        $upd['approve_by_admin']='Y';

        if($data->user_unique_code==null){
            $allPandit= User::where('user_unique_code','!=',null)->where('user_type','P')->get();
            $code='PUN';
            $sum=str_pad($allPandit->count()+1, 7, '0', STR_PAD_LEFT);
            $upd['user_unique_code']=$code.$sum;
        }
        $approval = User::where('id',$id)->where('status','!=','D')->update($upd);
        return redirect()->back()->with('success','Pundit account approved successfully');
     }

     /**
     *   Method      : delete
     *   Description : pundit delete account
     *   Author      : Sayan
     *   Date        : 2021-MAY-3
     **/

     public function delete($id)
     {
        $data = User::where('id',$id)->where('status','!=','D')->where('user_type','P')->first();
        if ($data==null) {
            return redirect()->back();
        }
        $delete = User::where('id',$id)->update(['status'=>'D']);
        return redirect()->back()->with('success','Pundit Deleted Successfully');
     }

     /**
     *   Method      : view
     *   Description : pundit view account
     *   Author      : Sayan
     *   Date        : 2021-MAY-3
     **/

     public function view($id)
     {
        $user = User::where('id',$id)->with('orderbookings.customer')->where('status','!=','D')->where('user_type','P')->first();
        if ($user=="") {
            return redirect()->back();
        }

        return view('admin.modules.pandit.view_pandit',compact('user'));
     }


     public function editview($id)
     {
       $data = [];
       $data['data'] = User::where('id',$id)->where('status','!=','D')->where('user_type','P')->first();
       if ($data['data']==null) {
            return redirect()->back();
       }

       $data['countries'] = Country::get();
       $data['states'] = State::where('country_id',$data['data']->country_id)->get();
       return view('admin.modules.pandit.edit_profile',$data);
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


     public function checkemail(Request $request)
     {
         $check = User::where('email',$request->email)->where('status','!=','D')->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
     }


     public function checkmobile(Request $request)
     {
        $check = User::where('mobile',$request->mobile)->where('status','!=','D')->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
        }
     }



     public function updateprofile(Request $request)
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
        $upd['email'] = $request->email;
        $upd['about'] = $request->about;
        $upd['city'] = $request->city;
        $upd['state'] = $request->state;
        $upd['address'] = $request->address;
        $upd['country_id'] = $request->country;
        $upd['puja_type'] = $request->puja_type;
        $upd['Ac_Type'] = $request->profile_type;
        $upd['pincode'] = $request->pincode;
        $upd['gst_no'] = $request->gst_no;
        $upd['user_availability'] = $request->availability;
        if ($request->profile_picture) {

            @unlink(storage_path('app/public/profile_picture/' . $user_details->profile_img));
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
        $upd['slug'] = $slug . "-" . $request->user_id;
        $user = User::where('id', $request->user_id)->update($upd);

        $account = UserAccount::where('user_id', $request->user_id)->first();
        $upd1 = [];
        $upd1['bank_name'] = $request->bank_name;
        $upd1['ac_no'] = $request->ac_no;
        $upd1['ifsc_code'] = $request->ifsc;
        $upd1['account_holder'] = $request->name_of_account_holder;
        if (@$account) {
            UserAccount::where('user_id', $request->user_id)->update($upd1);
        } else {
            $upd1['user_id'] = $request->user_id;
            UserAccount::create($upd1);
        }
        return redirect()->back()->with('success','Profile updated successfully');
     }


          public function editavail($id)
     {
        $data = [];
        $data['data'] = User::where('id',$id)->first();
        $data['monday'] = UserToAvailable::where('day', 'MONDAY')->where('user_id', $id)->first();
        $data['tuesday'] = UserToAvailable::where('day', 'TUESDAY')->where('user_id', $id)->first();
        $data['wednesday'] = UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', $id)->first();
        $data['thursday'] = UserToAvailable::where('day', 'THURSDAY')->where('user_id', $id)->first();
        $data['friday'] = UserToAvailable::where('day', 'FRIDAY')->where('user_id', $id)->first();
        $data['saturday'] = UserToAvailable::where('day', 'SATURDAY')->where('user_id', $id)->first();
        $data['sunday'] = UserToAvailable::where('day', 'SUNDAY')->where('user_id', $id)->first();
        return view('admin.modules.pandit.avail_edit',$data);
     }


     public function updateavail(Request $request)
     {
           $ins = [];
        $data = array();
        if (@$request->day1) {
            $ins['user_id'] = $request->user_id;
            $ins['from_time'] = $request->from_time_day1;
            $ins['to_time'] = $request->to_time_day1;
            $ins['day'] = 'MONDAY';
            array_push($data, 'MONDAY');
            $check1 = UserToAvailable::where('day', 'MONDAY')->where('user_id', $request->user_id)->first();
            if (@$check1) {
                UserToAvailable::where('day', 'MONDAY')->where('user_id', $request->user_id)->update($ins);
            } else {
                UserToAvailable::create($ins);
            }
        }
        if (@$request->day2) {
            $ins['user_id'] = $request->user_id;
            $ins['from_time'] = $request->from_time_day2;
            $ins['to_time'] = $request->to_time_day2;
            $ins['day'] = 'TUESDAY';
            array_push($data, 'TUESDAY');
            $check1 = UserToAvailable::where('day', 'TUESDAY')->where('user_id', $request->user_id)->first();
            if (@$check1) {
                UserToAvailable::where('day', 'TUESDAY')->where('user_id', $request->user_id)->update($ins);
            } else {
                UserToAvailable::create($ins);
            }
        }
        if (@$request->day3) {
            $ins['user_id'] = $request->user_id;
            $ins['from_time'] = $request->from_time_day3;
            $ins['to_time'] = $request->to_time_day3;
            $ins['day'] = 'WEDNESDAY';
            array_push($data, 'WEDNESDAY');
            $check1 = UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', $request->user_id)->first();
            if (@$check1) {
                UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', $request->user_id)->update($ins);
            } else {
                UserToAvailable::create($ins);
            }
        }
        if (@$request->day4) {
            $ins['user_id'] = $request->user_id;
            $ins['from_time'] = $request->from_time_day4;
            $ins['to_time'] = $request->to_time_day4;
            $ins['day'] = 'THURSDAY';
            array_push($data, 'THURSDAY');
            $check1 = UserToAvailable::where('day', 'THURSDAY')->where('user_id', $request->user_id)->first();
            if (@$check1) {
                UserToAvailable::where('day', 'THURSDAY')->where('user_id', $request->user_id)->update($ins);
            } else {
                UserToAvailable::create($ins);
            }
        }
        if (@$request->day5) {
            $ins['user_id'] = $request->user_id;
            $ins['from_time'] = $request->from_time_day5;
            $ins['to_time'] = $request->to_time_day5;
            $ins['day'] = 'FRIDAY';
            array_push($data, 'FRIDAY');
            $check1 = UserToAvailable::where('day', 'FRIDAY')->where('user_id', $request->user_id)->first();
            if (@$check1) {
                UserToAvailable::where('day', 'FRIDAY')->where('user_id', $request->user_id)->update($ins);
            } else {
                UserToAvailable::create($ins);
            }
        }
        if (@$request->day6) {
            $ins['user_id'] = $request->user_id;
            $ins['from_time'] = $request->from_time_day6;
            $ins['to_time'] = $request->to_time_day6;
            $ins['day'] = 'SATURDAY';
            array_push($data, 'SATURDAY');
            $check1 = UserToAvailable::where('day', 'SATURDAY')->where('user_id', $request->user_id)->first();
            if (@$check1) {
                UserToAvailable::where('day', 'SATURDAY')->where('user_id', $request->user_id)->update($ins);
            } else {
                UserToAvailable::create($ins);
            }
        }
        if (@$request->day7) {
            $ins['user_id'] = $request->user_id;
            $ins['from_time'] = $request->from_time_day7;
            $ins['to_time'] = $request->to_time_day7;
            $ins['day'] = 'SUNDAY';
            array_push($data, 'SUNDAY');
            $check1 = UserToAvailable::where('day', 'SUNDAY')->where('user_id', $request->user_id)->first();
            if (@$check1) {
                UserToAvailable::where('day', 'SUNDAY')->where('user_id', $request->user_id)->update($ins);
            } else {
                UserToAvailable::create($ins);
            }
        }
        UserToAvailable::whereNotIn('day', $data)->where('user_id', $request->user_id)->delete();
        return redirect()->back()->with('success','Availability updated successfully');
     }


     public function editpujaview($id)
     {
       $data = [];
       $data['data'] = User::where('id',$id)->where('status','!=','D')->where('user_type','P')->first();
       if ($data['data']==null) {
            return redirect()->back();
       }
        $data['pujalist'] = PunditToPuja::where('user_id',$id)->with('pujas')->orderBy('id','desc')->get();
        $addedPuja=array();
        foreach($data['pujalist'] as $item){
            array_push($addedPuja, $item->puja_id);
        }
        $data['pujas'] = Puja::whereNotIn('id', $addedPuja)->orderBy('puja_name','asc')->get();
       return view('admin.modules.pandit.edit_puja',$data);
     }

     public function addpuja(Request $request)
     {
        $request->validate([
            'puja' => 'required',
        ]);
        $ins=[];
        $ins['puja_id']= $request->puja;
        $ins['user_id']= $request->user_id;
        PunditToPuja::create($ins);
        return redirect()->back()->with('success','Puja added successfully');
     }


     public function deletepuja($id)
     {
        $check = PunditToPuja::where('id', $id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        PunditToPuja::where('id', $id)->delete();
        return redirect()->route('admin.pundit.edit-puja-view',['id'=>$check->user_id])->with('success','Puja deleted successfully');
     }

     public function editpuja($id)
     {
       $data = [];
        $data['pujaselect'] = PunditToPuja::where('id',$id)->with('pujas')->first();
        if ($data['pujaselect']==null) {
           return redirect()->back();
        }

        $data['pujalist'] = PunditToPuja::where('user_id', $data['pujaselect']->user_id)->orderBy('id','desc')->get();
        $addedPuja = array();
        foreach ($data['pujalist'] as $item) {
            if($data['pujaselect']->puja_id != $item->puja_id){
            array_push($addedPuja, $item->puja_id);
            }
        }
        $data['data'] = User::where('id',$data['pujaselect']->user_id)->where('status','!=','D')->where('user_type','P')->first();
        $data['pujas'] = Puja::whereNotIn('id', $addedPuja)->get();
        return view('admin.modules.pandit.edit_puja',$data);
     }

     public function updatepuja(Request $request)
     {
       // return $request;
       $request->validate([
          'price' => 'required',
        ]);
        $upd = [];
        $upd['price'] = $request->price;

        PunditToPuja::where('id', $request->puja_id)->where('user_id', $request->user_id)->update($upd);
        return redirect()->route('admin.pundit.edit-puja-view',['id'=>$request->user_id])->with('success','Puja updated successfully');
     }


     public function pujaList($id)
     {
       $data = [];  
       $data['user'] = User::where('id',$id)->with('orderbookings.customer')->where('status','!=','D')->where('user_type','P')->first();
        if ($data['user']=="") {
            return redirect()->back();
        }
        return view('admin.modules.pandit.view_puja',$data);

     }


     public function editZipcode($id)
     {
        // return $id;
        $data = [];
       $data['data'] = User::where('id',$id)->where('status','!=','D')->where('user_type','P')->first();
       if ($data['data']==null) {
            return redirect()->back();
       }
        $data['country'] = Country::get();
        $data['ziplist'] = PunditToZipcode::where('pundit_id',$id)->with('zip')->orderBy('id','desc')->get();
        $addedzip=array();
        foreach($data['ziplist'] as $item){
            array_push($addedzip, $item->zipcode_id);
        }
        $data['zips'] = ZipMaster::whereNotIn('id', $addedzip)->get();
       return view('admin.modules.pandit.zipcode_edit',$data);
     }

     public function getZipcode(Request $request)
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

     public function checkZipcode(Request $request)
     {
        // echo "hey";
        // return $request;
        $check = PunditToZipcode::where('zipcode_id',$request->zipcode)->where('country_id',$request->country)->where('pundit_id',$request->id)->first();
        // echo $check;
        if ($check!="") {
            echo "found";
        }
     }


     public function addZipCode(Request $request)
     {
        $ins=[];
        $ins['pundit_id']= $request->user_id;
        $ins['zipcode_id']= $request->zip;
        $ins['country_id']= $request->country;
        PunditToZipcode::create($ins);
        return redirect()->back()->with('success','Zipcode added successfully');
     }


     public function delZipcode($id)
     {
        $check = PunditToZipcode::where('id', $id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        PunditToZipcode::where('id', $id)->delete();
        return redirect()->back()->with('success','Zipcode deleted successfully');
     }
	 /**
     *   Method      : userResetPassword
     *   Description : To reset customer password
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-10
     **/

     public function userResetPassword($id)
     {
        $user = User::where('id',$id)->where('status','!=','D')->where('user_type','A')->first();
		if(!$user)
		{
			return redirect()->back();
		}
		$new_password=str_random(8);
		User::where('id',$id)->update(['password'=>Hash::make($new_password)]);
        $maildetails=array();
		$mail_details['new_password']=$new_password;
		$mail_details['full_name']=$user->first_name." ".$user->last_name;
		$mail_details['email']=$user->email;
		$mail_details['mobile']=$user->mobile;
		Mail::send(new UserResetPassword($mail_details));
		return redirect()->back()->with('success','New password sent successfully');
     }

}
