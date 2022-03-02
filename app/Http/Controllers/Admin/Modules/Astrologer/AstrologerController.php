<?php

namespace App\Http\Controllers\Admin\Modules\Astrologer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Expertise;
use App\Models\LanguageSpeak;
use App\Models\Country;
use App\Models\State;
use App\Models\AstrologerToLanguages;
use App\Models\AstrologerToExpertise;
use App\Models\UserAccount;
use App\Models\AstrologerToEducation;
use App\Models\UserToAvailable;
use App\Models\AstrologerToExperience;
use App\Models\City;
use Hash;
use Mail;
use App\Mail\UserResetPassword;
use App\Models\AstrologerExclusionDateList;
use App\Models\ZipMaster;
use App\Models\Area;
use DB;
class AstrologerController extends Controller
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
     *   Description : astrologer view
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

    public function index(Request $request)
    {
    	$data = [];
    	$data['users'] = User::with('getCity')->where('user_type','A')->where('status','!=','D')->orderBy('id', 'desc');
    	if (@$request->status) {
    		$data['users'] = $data['users']->where(function($query){
    			$query->where('status',request('status'))
    				  ->orWhere('approve_by_admin',request('status'));
    		});
    	}

      if (@$request->avail) {
          if(@$request->avail == 'Y'){
            $data['users'] = $data['users']->where('user_availability','N');
          }else{
            $data['users'] = $data['users']->where('user_availability','Y');
          }

      }

    	if(@$request->keyword){
    		$data['users'] = $data['users']->where(function($query){
    			$query->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' "
                        )
                      ->orWhere('email','LIKE','%'.request('keyword').'%')
                      ->orWhere('mobile','LIKE','%'.request('keyword').'%')
                      ->orWhere('user_unique_code','LIKE','%'.request('keyword').'%')
                      ->orWhere('address','LIKE','%'.request('keyword').'%')
                      ;
    	    });
    	}

    	if (@$request->expertise) {
    		$data['users'] = $data['users']->whereHas('astrologerExpertise.experties',function($query){
    			$query->where('expertise_name','LIKE','%'.request('expertise').'%');
    		});
    	}


		$data['users'] = $data['users']->paginate(10);
    	return view('admin.modules.astrologer.manage_astrologer',$data);
    }

    /**
     *   Method      : status
     *   Description : astrologer change status active/inactive
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

    public function status($id)
    {
    	$data = User::where('id',$id)->where('status','!=','D')->where('user_type','A')->first();
        if ($data==null) {
            return redirect()->back();
        }
        if ($data->status=="A") {
            $inactive = User::where('id',$id)->update(['status'=>'I']);
            return redirect()->back()->with('success','Astrologer Status Deactivated Successfully');
        }

        if ($data->status=="I") {
            $inactive = User::where('id',$id)->update(['status'=>'A']);
            return redirect()->back()->with('success','Astrologer Status Activated Successfully');
        }
    }

     /**
     *   Method      : approve
     *   Description : astrologer account approval
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

     public function approve($id)
     {
     	$data = User::where('id',$id)->where('status','!=','D')->where('user_type','A')->first();
        if ($data==null) {
            return redirect()->back();
        }
        $upd=[];
        $upd['approve_by_admin']='Y';

        if($data->user_unique_code==null){
            $allAstrologer= User::where('user_unique_code','!=',null)->where('user_type','A')->get();
            $code='AST';
            $sum=str_pad($allAstrologer->count()+1, 7, '0', STR_PAD_LEFT);
            $upd['user_unique_code']=$code.$sum;
        }
        $approval = User::where('id',$id)->where('status','!=','D')->update($upd);
        return redirect()->back()->with('success','Astrologer account approved successfully');
     }

      /**
     *   Method      : delete
     *   Description : astrologer delete account
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

     public function delete($id)
     {
     	$data = User::where('id',$id)->where('status','!=','D')->where('user_type','A')->first();
        if ($data==null) {
            return redirect()->back();
        }
        $delete = User::where('id',$id)->update(['status'=>'D']);
        return redirect()->back()->with('success','Astrologer Deleted Successfully');
     }


      /**
     *   Method      : view
     *   Description : astrologer view account
     *   Author      : Sayan
     *   Date        : 2021-APR-30
     **/

     public function view($id)
     {
      $data = [];
     	$data = User::where('id',$id)->where('status','!=','D')->where('user_type','A')->with('astrologerLanguage.languages','getCity','getArea')->first();
     	if ($data==null) {
            return redirect()->back();
        }
        $data['user'] = User::where('id',$id)->first();
        $data['avail']= UserToAvailable::where('user_id',$id)->get();
        $data['monday'] = UserToAvailable::where('user_id',$id)->where('day','MONDAY')->get();
        $data['tuesday'] = UserToAvailable::where('user_id',$id)->where('day','TUESDAY')->get();
        $data['wednesday'] = UserToAvailable::where('user_id',$id)->where('day','WEDNESDAY')->get();
        $data['thursday'] = UserToAvailable::where('user_id',$id)->where('day','THURSDAY')->get();
        $data['friday'] = UserToAvailable::where('user_id',$id)->where('day','FRIDAY')->get();
        $data['saturday'] = UserToAvailable::where('user_id',$id)->where('day','SATURDAY')->get();
        $data['sunday'] = UserToAvailable::where('user_id',$id)->where('day','SUNDAY')->get();
      return view('admin.modules.astrologer.view_astrologer',$data);
     }


     public function editview($id)
     {
       $data = [];
       $data['data'] = User::where('id',$id)->where('status','!=','D')->where('user_type','A')->first();
       if ($data['data']==null) {
            return redirect()->back();
       }
       $data['allExpertise'] = Expertise::orderBy('expertise_name','asc')->get();
       $data['allLanguage'] = LanguageSpeak::orderBy('language_name','asc')->get();
       $data['countries'] = Country::get();
       $data['states'] = State::where('country_id',$data['data']->country_id)->get();
       $data['cities'] = City::where('state_id',$data['data']->state)->get();
       $post_id = ZipMaster::where([
                        'country_id' => $data['data']->country_id,
                        'state_id' => $data['data']->state,
                        'city_id' => $data['data']->city,
                        'zipcode'=>$data['data']->pincode,
                    ])->first();
        $data['areas'] = Area::where([
            'country_id' => $data['data']->country_id,
            'state_id' => $data['data']->state,
            'city_id' => $data['data']->city,
            'postcode_id'=>@$post_id->id,
        ])
        ->get();
       return view('admin.modules.astrologer.edit_astrologer',$data);

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

    /**
     *   Method      : gateCity
     *   Description : to get city on state basis
     *   Author      : Argha
     *   Date        : 2021-Dec-15
     **/
    public function getCity(Request $request)
    {
        $response = [
            "jsonrpc" => "2.0"
        ];
        if ($request->params['state_id']) {
            $city = City::where('state_id', $request->params['state_id'])->get();
            $response['status'] = 1;
            $response['result'] = $city;
            return response()->json($response);
        }
    }
    /**
     *   Method      : gateArea
     *   Description : to get area city ,state and pincode basis
     *   Author      : Argha
     *   Date        : 2021-Dec-28
     **/
    public function gateArea(Request $request)
    {
        $response = [
            "jsonrpc" => "2.0"
        ];
        if ($request->params['pincode']) {
            $postcode = ZipMaster::where([
                'country_id' => $request->params['country'],
                'state_id' => $request->params['state'],
                'city_id' => $request->params['city'],
                'zipcode'=>$request->params['pincode'],
            ])->first();
            //dd($postcode);
            $area = Area::where('postcode_id', @$postcode->id)
                        ->where([
                            'country_id' => $request->params['country'],
                            'state_id' => $request->params['state'],
                            'city_id' => $request->params['city'],
                        ])
                        ->orderBy('area')
                        ->get();
            $response['status'] = 1;
            $response['result'] = $area;
            if($postcode){
                $response['postcode'] = 1;
            }else{
                $response['postcode'] = 0;
            }
            return response()->json($response);
        }
    }
    public function updateprofile(Request $request)
    {
                // return $request;
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'astrologer_type' => 'required',
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
        $user_details = User::where('id',$request->id)->first();
        $name = $request->first_name . ' ' . $request->last_name;
        $upd = [];
        $upd['first_name'] = $request->first_name;
        $upd['last_name'] = $request->last_name;
        $upd['gender'] = $request->gender;
        $upd['about'] = $request->about;
        $upd['heading_one'] = @$request->heading_one;
        $upd['description_one'] = @$request->description_one;
        $upd['heading_two'] = $request->heading_two;
        $upd['description_two'] = $request->description_two;
        $upd['heading_three'] = $request->heading_three;
        $upd['description_three'] = $request->description_three;
        $upd['about'] = $request->about;
        $upd['why_who'] = @$request->why_who;
        $upd['city'] = $request->city;
        $upd['state'] = $request->state;
        $upd['address'] = $request->address;
        $upd['country_id'] = $request->country;
        $upd['astrologer_type'] = $request->astrologer_type;

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
        if (@$request->offline_check) {
            $upd['is_astrologer_offer_offline'] = 'Y';
            $upd['astrologer_offline_price_inr'] = $request->offline_price_inr;
            $upd['astrologer_offline_price_usd'] = $request->offline_price_usd;

            if ($request->offline_discount_price_inr==null) {
               $upd['offline_discount_price_inr'] = 0;
            }else{
                $upd['offline_discount_price_inr'] = $request->offline_discount_price_inr;
            }

            if ($request->offline_discount_price_usd==null) {
               $upd['offline_discount_price_usd'] = 0;
            }else{
                $upd['offline_discount_price_usd'] = $request->offline_discount_price_usd;
            }

        }else{
            $upd['is_astrologer_offer_offline'] = 'N';
            $upd['astrologer_offline_price_inr'] = 0;
            $upd['astrologer_offline_price_usd'] = 0;
            $upd['offline_discount_price_inr'] = 0;
            $upd['offline_discount_price_usd'] = 0;
        }


        $upd['experience'] = $request->experience;
        $upd['Ac_Type'] = $request->profile_type;
        $upd['pincode'] = $request->pincode;
        $upd['email'] = $request->email;
        $upd['mobile'] = $request->mobile;
        $upd['gst_no'] = $request->gst_no;
        $upd['user_availability'] = $request->availability;
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
        //dd($upd);
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
        $expertise = explode(",", $request->expertise);
        foreach ($expertise as $item) {
            $insExpertise = [];
            $insExpertise['user_id'] = $request->user_id;
            $insExpertise['expertise_id'] = $item;
            $checkAvailable = AstrologerToExpertise::where('user_id', $request->user_id)->where('expertise_id', $item)->first();
            if ($checkAvailable == null) {
                AstrologerToExpertise::create($insExpertise);
            }
        }
        AstrologerToExpertise::where('user_id', $request->user_id)->whereNotIn('expertise_id', $expertise)->delete();

        $language = explode(",", $request->language);
        foreach ($language as $item2) {

            $insLanguage = [];
            $insLanguage['user_id'] = $request->user_id;
            $insLanguage['language_id'] = $item2;
            $checkAvailable = AstrologerToLanguages::where('user_id', $request->user_id)->where('language_id', $item2)->first();
            if ($checkAvailable == null) {
                AstrologerToLanguages::create($insLanguage);
            }
        }
        AstrologerToLanguages::where('user_id', $request->user_id)->whereNotIn('language_id', $language)->delete();
        return redirect()->back()->with('success','Profile updated successfully');
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


    public function editeduview($id, $edu=null)
    {
        $data = [];
        $data['educations'] = AstrologerToEducation::where('user_id',$id)->orderBy('id','desc')->get();
        $data['data'] = User::where('id',$id)->first();
        return view('admin.modules.astrologer.edit_education',$data);
    }

    public function addedu(Request $request)
    {
         $request->validate([
            'education_title' => 'required',
            'institute' => 'required',
            'year_of_passing' => 'required',
        ]);

        $ins=[];
        $ins['year_of_passing'] = $request->year_of_passing;
        $ins['education_title'] = $request->education_title;
        $ins['institute'] = $request->institute;
        $ins['user_id'] = $request->user_id;
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
        return redirect()->back()->with('success','Education added successfully');
    }

    public function editedu($edu)
    {
        $data = [];
        $data['edu'] = AstrologerToEducation::where('id',$edu)->first();
        $data['educations'] = AstrologerToEducation::where('user_id',$data['edu']->user_id)->orderBy('id','desc')->get();
        $data['data'] = User::where('id',$data['edu']->user_id)->first();
        return view('admin.modules.astrologer.edit_education',$data);
    }

    public function update_education(Request $request)
    {
        $request->validate([
            'education_title' => 'required',
            'institute' => 'required',
            'year_of_passing' => 'required',
        ]);

        $upd=[];
        $upd['year_of_passing'] = $request->year_of_passing;
        $upd['education_title'] = $request->education_title;
        $upd['institute'] = $request->institute;
        $upd['user_id'] = $request->user_id;
        if(@$request->image){
            if(@$request->astro_image && file_exists('storage/app/public/education_image/'.@$request->astro_image)){
                unlink('storage/app/public/education_image/'.@$request->astro_image);
            }
            $image = $request->image;
            $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $image->move('storage/app/public/education_image/',$filename);
            $upd['image'] = $filename;
        }
        AstrologerToEducation::where('user_id', $request->user_id)->where('id', $request->edu_id)->update($upd);
        return redirect()->route('admin.astrologer.edit-education-view',['id'=>$request->user_id])->with('success','Education updated successfully');
    }

    public function delete_education($edu)
    {
        $check = AstrologerToEducation::where('id',$edu)->first();
        if ($check==null) {
           return redirect()->back();
        }
        $delete = AstrologerToEducation::where('id',$edu)->delete();
        return redirect()->route('admin.astrologer.edit-education-view',['id'=>$check->user_id])->with('success','Education deleted successfully');
    }

    public function checkedu(Request $request)
    {
        if (@$request->id) {
            $check = AstrologerToEducation::where('education_title',$request->education_title)->where('user_id',$request->user_id)->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
        }else{
        $check = AstrologerToEducation::where('education_title',$request->education_title)->where('user_id',$request->user_id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
      }
    }


    public function editexpview($id)
    {
        $data = [];
        $data['experiences'] = AstrologerToExperience::where('user_id',$id)->orderBy('id','desc')->get();
        $data['data'] = User::where('id',$id)->first();
        return view('admin.modules.astrologer.edit_experience',$data);
    }


    public function addexp(Request $request)
    {
         $request->validate([
            'experience_title' => 'required',
            'description' => 'required',
            'year_of_experience' => 'required',
        ]);

        $ins = [];
        $ins['year_of_experience'] = $request->year_of_experience;
        $ins['experience_title'] = $request->experience_title;
        $ins['description'] = $request->description;
        $ins['user_id'] = $request->user_id;
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
        return redirect()->back()->with('success','Experience added successfully');
    }

    public function delete_exp($exp)
    {
        $check = AstrologerToExperience::where('id',$exp)->first();
        if ($check=="") {
            return redirect()->back();
        }
        $delete = AstrologerToExperience::where('id',$exp)->delete();
        return redirect()->route('admin.astrologer.edit-exp-view',['id'=>$check->user_id])->with('success','Experience deleted successfully');
    }

    public function edit_exp($exp)
    {
        $data = [];
        $data['exp'] = AstrologerToExperience::where('id',$exp)->first();
        $data['experiences'] = AstrologerToExperience::where('user_id',$data['exp']->user_id)->orderBy('id','desc')->get();
        $data['data'] = User::where('id',$data['exp']->user_id)->first();
        return view('admin.modules.astrologer.edit_experience',$data);
    }

    public function update_exp(Request $request)
    {
         $request->validate([
            'experience_title' => 'required',
            'description' => 'required',
            'year_of_experience' => 'required',
        ]);

        $upd = [];
        $upd['year_of_experience'] = $request->year_of_experience;
        $upd['experience_title'] = $request->experience_title;
        $upd['description'] = $request->description;
        $upd['user_id'] = $request->user_id;
        if(@$request->image){
            if(@$request->astro_image && file_exists('storage/app/public/experience_image/'.@$request->astro_image)){
                unlink('storage/app/public/experience_image/'.@$request->astro_image);
            }
            $image = $request->image;
            $filename = time().'-'.rand(1000,9999).'.'.$image->getClientOriginalExtension();
            $image->move('storage/app/public/experience_image/',$filename);
            $upd['image'] = $filename;
        }
        AstrologerToExperience::where('user_id', $request->user_id)->where('id', $request->exp_id)->update($upd);
        return redirect()->route('admin.astrologer.edit-exp-view',['id'=>$request->user_id])->with('success','Experience updated successfully');
    }

    public function check_exp(Request $request)
    {
       if (@$request->id) {
            $check = AstrologerToExperience::where('experience_title',$request->experience_title)->where('user_id',$request->user_id)->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
        }else{
        $check = AstrologerToExperience::where('experience_title',$request->experience_title)->where('user_id',$request->user_id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
      }
    }

    public function editavailview($id)
    {
        $userData = User::where('id', $id)->with('userAccount')->first();
        $data['monday'] = UserToAvailable::where('day', 'MONDAY')->where('user_id', $id)->get();
        $data['tuesday'] = UserToAvailable::where('day', 'TUESDAY')->where('user_id', $id)->get();
        $data['wednesday'] = UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', $id)->get();
        $data['thursday'] = UserToAvailable::where('day', 'THURSDAY')->where('user_id', $id)->get();
        $data['friday'] = UserToAvailable::where('day', 'FRIDAY')->where('user_id', $id)->get();
        $data['saturday'] = UserToAvailable::where('day', 'SATURDAY')->where('user_id', $id)->get();
        $data['sunday'] = UserToAvailable::where('day', 'SUNDAY')->where('user_id', $id)->get();
        $data['userData'] = $userData;
        $data['data'] = $userData;
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
        return view('admin.modules.astrologer.edit_avail',$data);
    }


    public function updateavail(Request $request)
    {
        $ins = [];
        $data = array();
          if (@$request->day1) {
            array_push($data, 'MONDAY');
            $monday_id =array();
            foreach (@$request->monday_slot as  $value) {
                $c = UserToAvailable::where('day', 'MONDAY')->where('user_id', $request->user_id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = $request->user_id;
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

        }

         if (@$request->day2) {
            array_push($data, 'TUESDAY');

            $tuesday_id =array();

            foreach (@$request->tuesday_slot as  $value) {
                $c = UserToAvailable::where('day', 'TUESDAY')->where('user_id', $request->user_id)->where('from_time',$value)->first();
                if (@$c==null) {
                    $ins['user_id'] = $request->user_id;
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

        }

        if (@$request->day3) {
            array_push($data, 'WEDNESDAY');
            $wednesday_id =array();
            foreach (@$request->wednesday_slot as  $value) {
                $c = UserToAvailable::where('day', 'WEDNESDAY')->where('user_id', $request->user_id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = $request->user_id;
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

        }


        if (@$request->day4) {
            array_push($data, 'THURSDAY');
            $thursday_id =array();
            foreach (@$request->thursday_slot as  $value) {
                $c = UserToAvailable::where('day', 'THURSDAY')->where('user_id', $request->user_id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = $request->user_id;
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

        }


        if (@$request->day5) {
            array_push($data, 'FRIDAY');
            $firday_id =array();
            foreach (@$request->friday_slot as  $value) {
                 $c = UserToAvailable::where('day', 'FRIDAY')->where('user_id', $request->user_id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = $request->user_id;
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

        }

          if (@$request->day6) {
            array_push($data, 'SATURDAY');
            $saturday_id =array();
            foreach (@$request->saturday_slot as  $value) {
                 $c = UserToAvailable::where('day', 'SATURDAY')->where('user_id', $request->user_id)->where('from_time',$value)->first();
                 if (@$c==null) {
                $ins['user_id'] = $request->user_id;
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

        }

         if (@$request->day7) {
            array_push($data, 'SUNDAY');
             $sunday_id =array();
            foreach (@$request->sunday_slot as  $value) {
                $c = UserToAvailable::where('day', 'SUNDAY')->where('user_id', $request->user_id)->where('from_time',$value)->first();
                if (@$c==null) {
                $ins['user_id'] = $request->user_id;
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

        }

        UserToAvailable::whereNotIn('day', $data)->where('user_id', $request->user_id)->delete();
        return redirect()->back()->with('success','Availability updated successfully');
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


     public function dateExclusion(Request $request,$id)
     {
      // return $request;
            $userData = User::where('id', $id)->with('userAccount')->first();
            $data['data'] = $userData;
            $data['datelist'] = AstrologerExclusionDateList::where('astrologer_id',$id)->orderBy('id','desc')->get();
            return view('admin.modules.astrologer.date_exclusion')->with($data);
     }

    public function dateInsert(Request $request)
    {
        $insert=array();
        $date_form = strtotime(date('Y-m-d', strtotime($request->exclusion_from_date)));
        $date_to = strtotime(date('Y-m-d',strtotime($request->exclusion_to_date)));
        $day_array = array();

        if($request->exclusion_to_date == null){
            $insert['astrologer_id']=$request->user_id;
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

                $insert['astrologer_id']=$request->user_id;
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
    }

     public function deleteDate($id)
     {
        AstrologerExclusionDateList::where('id',$id)->delete();
        return redirect()->back()->with('success','Exclusion date successfully deleted');
     }

     public function showHome($id)
     {
       $user = User::where('id',$id)->first();
       if (@$user->show_at_home=="Y") {
         User::where('id',$id)->update(['show_at_home'=>'N']);
         return redirect()->back()->with('success','Astrologer removed from home page successfully');
       }else{
         User::where('id',$id)->update(['show_at_home'=>'Y']);
         return redirect()->back()->with('success','Astrologer shwo at home page successfully');
       }
     }

     public function deleteEducationImage(Request $request)
     {
        AstrologerToEducation::where('id',$request->id)->update(['image'=>'']);
        echo "success";
     }

     public function deleteExperienceImage(Request $request)
     {
       AstrologerToExperience::where('id',$request->id)->update(['image'=>'']);
       echo "success";
     }

     public function delProfilePicture(Request $request)
     {
        User::where('id',$request->id)->update(['profile_img'=>'']);
        echo "success";
     }




}
