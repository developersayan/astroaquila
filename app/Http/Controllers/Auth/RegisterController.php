<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\Gotra;
use Session;
use Mail;
use App\Mail\EmailVerification;
use App\Models\AstrologerToExpertise;
use App\Models\AstrologerToLanguages;
use App\Models\Expertise;
use App\Models\LanguageSpeak;
use Illuminate\Support\Facades\Storage;
use App\Models\SellersContact;
use Illuminate\Support\Facades\Auth;
use App\Models\Country;
use App\Models\State;
use App\Models\PunditToPuja;
use App\Models\Puja;
use App\Models\City;
use App\Models\Area;
use App\Models\ZipMaster;
use DB;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
        public $data;
      public function __construct()
    {

      $this->middleware(function ($request, $next) {
        if ( \request()->get( 'ref' )) {
           session()->put( 'customurl', \request()->get( 'ref' ));
           $this->data = Session::get('customurl');
        }
        return $next($request);
        });
       $this->middleware('guest')->except('resendOtp', 'verifyOTP', 'checkEmail', 'checkMobile', 'VerifyEmail');
    }
    // public function __construct()
    // {

    //     $this->middleware('guest')->except('resendOtp', 'verifyOTP', 'checkEmail', 'checkMobile', 'VerifyEmail');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore('D', 'status')],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    /**
     *   Method      : showRegistrationForm
     *   Description : Customer Registration from view
     *   Author      : Soumojit
     *   Date        : 2021-APR-20
     **/
    public function showRegistrationForm()
    {
        $allGotra = Gotra::get();
        return view('auth.register')->with(['allGotra'=> $allGotra]);
    }
    /**
     *   Method      : CustomerRegister
     *   Description : Customer Registration
     *   Author      : Soumojit
     *   Date        : 2021-APR-20
     **/
    public function CustomerRegister(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
        ]);
        $checkEmail = User::where('email', $request->email)->where('status','!=','D')->first();
        $checkMobile= User::where('mobile', $request->mobile)->where('status','!=','D')->first();
        if(@$checkEmail ){
            session()->flash('error', \Lang::get('auth.unique_email'));
            return redirect()->back()->withInput($request->input());
        }
        if(@$checkMobile ){
            session()->flash('error', \Lang::get('auth.unique_mobile'));
            return redirect()->back()->withInput($request->input());
        }
        $name= $request->first_name .' '.$request->last_name;
        $ins=[];
        $ins['first_name']=$request->first_name;
        $ins['last_name']=$request->last_name;
        $ins['email']=$request->email;
        $ins['password']= Hash::make($request->password);
        $ins['user_type']='C';
        $ins['status']='U';
        $ins['mobile']=$request->mobile;
        if(@$request->date_of_birth){
            $ins['dob']= date('Y-m-d', strtotime($request->date_of_birth));
        }
        $ins['time_of_birth']= @$request->time_of_birth;
        $ins['place_of_birth']= @$request->place_of_birth;
        $ins['latitude']= @$request->lat;
        $ins['longitude']= @$request->lng;
        $ins['gotra_id']= @$request->gotra;
        $ins['otp']= mt_rand(100000,999999);
        $ins['vcode']=str_random(60);
        if (Session::get('customurl')) {
            $ins['url_slug']=Session::get('customurl');
            // return Session::get('customurl');
            $type = explode('/', Session::get('customurl'));
            $reverse = array_reverse($type );
            $z = $reverse[1];
            $ins['url_type']=$z;
            Session::forget('customurl');
        }

        $user = User::create($ins);
        $slug= str_slug($name, "-");
        $upd['slug'] = $slug. "-".$user->id;
        $userUpdate = User::where('id',$user->id)->update($upd);
        if ($user) {
            Mail::to($request->email)->send(new EmailVerification($user));
            return redirect()->route('account.otp',['id'=> $user->id]);
            // return view('auth.success');
        }
        return redirect()->back()->withInput($request->input());
    }
    /**
     *   Method      : showRegistrationFormPundit
     *   Description : Pundit Registration from view
     *   Author      : Soumojit
     *   Date        : 2021-APR-20
     **/
    public function showRegistrationFormPundit(){
        $allCountry = Country::get();
        $data['allCountry'] = $allCountry;
        return view('auth.register_pundit')->with($data);
    }
    /**
     *   Method      : showRegistrationFormPundit
     *   Description : Pundit Registration from view
     *   Author      : Soumojit
     *   Date        : 2021-APR-20
     **/
    public function PunditRegister(Request $request){
        // return $request;
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            'experience' => 'required',
            'puja_type' => 'required',
            'address' => 'required',
            'pincode' => 'required',
            // 'gender' => 'required',
            // 'profile_pic' => 'required|mimes:jpeg,jpg,png',
        ]);
        $checkEmail = User::where('email', $request->email)->where('status','!=','D')->first();
        $checkMobile = User::where('mobile', $request->mobile)->where('status','!=','D')->first();
        if (@$checkEmail) {
            session()->flash('error', \Lang::get('auth.unique_email'));
            return redirect()->back()->withInput($request->input());
        }
        if (@$checkMobile) {
            session()->flash('error', \Lang::get('auth.unique_mobile'));
            return redirect()->back()->withInput($request->input());
        }
        $name = $request->first_name . ' ' . $request->last_name;
        $ins = [];
        $ins['first_name'] = $request->first_name;
        $ins['last_name'] = $request->last_name;
        $ins['email'] = $request->email;
        $ins['password'] = Hash::make($request->password);
        $ins['user_type'] = 'P';
        $ins['status'] = 'U';
        $ins['mobile'] = $request->mobile;
        // $ins['state'] = $request->state;
        $ins['city'] = $request->city;
        // $ins['country_id'] = $request->country;
        $ins['experience'] = $request->experience;
        $ins['puja_type'] = $request->puja_type;
        // $ins['gender'] = $request->gender;
        $ins['state'] = $request->state;
        // $ins['city'] = $request->city;
        $ins['country_id'] = $request->country;
        $ins['address'] = $request->address;
        $ins['pincode'] = $request->pincode;
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
                    $ins['area'] = @$check->id;
                }else{
                    $area_ins = Area::create($insArea);
                    $ins['area'] = @$area_ins->id;
                }
            }else{
                $ins['area'] = @$request->area_drop;
            }
        }
        // else{
        //     $area = trim(strtolower($request->area));
        //     $check = Area::where('state_id',$request->state)
        //             ->where('city_id',$request->city)
        //             ->where('postcode_id',@$post_id->id)
        //             ->where(DB::raw('trim(lower(area))'),$area)
        //             ->first();
        //     if($check){
        //         $ins['area'] = @$check->id;
        //     }else{
        //         $area_ins = Area::create($insArea);
        //         $ins['area'] = @$area_ins->id;
        //     }
        // }
        if (@$request->profile_picture) {
            // $image = $request->profile_picture;
            // $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            // Storage::putFileAs('public/profile_picture', $image, $filename);

            // $user = Auth::user();
            // $data = User::where('id', $user->id)->first();
            // if (@$data->image) {
            //     @unlink(storage_path('app/public/profile_picture/' . $data->image));
            // }
            $destinationPath = "storage/app/public/profile_picture/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $update['image'] = $img;
            $ins['profile_img'] = $img;
            // $ins['profile_img'] = $filename;
        }
        $ins['otp'] = mt_rand(100000, 999999);
        $ins['vcode'] = str_random(60);
        if (Session::get('customurl')) {
            $ins['url_slug']=Session::get('customurl');
            // return Session::get('customurl');
            $type = explode('/', Session::get('customurl'));
            $reverse = array_reverse($type );
            $z = $reverse[1];
            $ins['url_type']=$z;
            Session::forget('customurl');
        }
        $user = User::create($ins);
        $slug = str_slug($name, "-");
        $upd['slug'] = $slug . "-" . $user->id;
        $userUpdate = User::where('id', $user->id)->update($upd);
        if ($user) {
            Mail::to($request->email)->send(new EmailVerification($user));
            return redirect()->route('account.otp', ['id' => $user->id]);
            // return view('auth.success');
        }
        return redirect()->back()->withInput($request->input());
    }
    /**
     *   Method      : showRegistrationFormAstrologer
     *   Description : Astrologer Registration from view
     *   Author      : Soumojit
     *   Date        : 2021-APR-20
     **/
    public function showRegistrationFormAstrologer(){

        $allExpertise = Expertise::get();
        $allCountry = Country::get();

        $allLanguage = LanguageSpeak::get();
        $data['allExpertise'] = $allExpertise;
        $data['allCountry'] = $allCountry ;
        $data['allLanguage'] = $allLanguage;
        return view('auth.register_astrologer')->with($data);
    }
    /**
     *   Method      : AstrologerRegister
     *   Description : Astrologer Registration
     *   Author      : Soumojit
     *   Date        : 2021-APR-21
     **/
    public function AstrologerRegister(Request $request){
         //return $request;
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'state' => 'required',
            'city' => 'required',
            'country' => 'required',
            // 'call_price' => 'required',
            'experience' => 'required',
            'gender' => 'required',
            // 'profile_pic' => 'required|mimes:jpeg,jpg,png',
            'address'=> 'required',
            'language'=> 'required',
            'expertise'=> 'required',
            'pincode' => 'required',
        ]);
        $checkEmail = User::where('email', $request->email)->where('status','!=','D')->first();
        $checkMobile = User::where('mobile', $request->mobile)->where('status','!=','D')->first();
        if (@$checkEmail) {
            session()->flash('error', \Lang::get('auth.unique_email'));
            return redirect()->back()->withInput($request->input());
        }
        if (@$checkMobile) {
            session()->flash('error', \Lang::get('auth.unique_mobile'));
            return redirect()->back()->withInput($request->input());
        }
        $name = $request->first_name . ' ' . $request->last_name;
        $ins = [];
        $ins['first_name'] = $request->first_name;
        $ins['last_name'] = $request->last_name;
        $ins['email'] = $request->email;
        $ins['password'] = Hash::make($request->password);
        $ins['user_type'] = 'A';
        $ins['status'] = 'U';
        $ins['mobile'] = $request->mobile;
        $ins['state'] = $request->state;
        $ins['city'] = $request->city;
        $ins['astrologer_type'] = 3;
        $ins['country_id'] = $request->country;
        $ins['call_price'] = $request->call_price;
        $ins['experience'] = $request->experience;
        $ins['gender'] = $request->gender;
        $ins['address'] = $request->address;
        $ins['pincode'] = $request->pincode;

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
                    $ins['area'] = @$check->id;
                }else{
                    $area_ins = Area::create($insArea);
                    $ins['area'] = @$area_ins->id;
                }
            }else{
                $ins['area'] = @$request->area_drop;
            }
        }
        // else{
        //     $area = trim(strtolower($request->area));
        //     $check = Area::where('state_id',$request->state)
        //             ->where('city_id',$request->city)
        //             ->where('postcode_id',@$post_id->id)
        //             ->where(DB::raw('trim(lower(area))'),$area)
        //             ->first();
        //     if($check){
        //         $ins['area'] = @$check->id;
        //     }else{
        //         $area_ins = Area::create($insArea);
        //         $ins['area'] = @$area_ins->id;
        //     }
        // }
        if ($request->profile_pic) {
            // $image = $request->profile_pic;
            // $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            // Storage::putFileAs('public/profile_picture', $image, $filename);
            // $ins['profile_img'] = $filename;
            $destinationPath = "storage/app/public/profile_picture/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $update['image'] = $img;
            $ins['profile_img'] = $img;
        }

        $ins['otp'] = mt_rand(100000, 999999);
        $ins['vcode'] = str_random(60);
        if (Session::get('customurl')) {
            $ins['url_slug']=Session::get('customurl');
            // return Session::get('customurl');
            $type = explode('/', Session::get('customurl'));
            $reverse = array_reverse($type );
            $z = $reverse[1];
            $ins['url_type']=$z;
            Session::forget('customurl');
        }
        dd($ins);
        $user = User::create($ins);
        $slug = str_slug($name, "-");
        $upd['slug'] = $slug . "-" . $user->id;
        $userUpdate = User::where('id', $user->id)->update($upd);
        if ($user) {
            // $expertise = explode(",", $request->expertise);
            foreach ($request->expertise as $item) {
                $insExpertise = [];
                $insExpertise['user_id'] = $user->id;
                $insExpertise['expertise_id'] = $item;
                AstrologerToExpertise::create($insExpertise);
            }

            // $language = explode(",", $request->language);
            foreach ($request->language as $item2) {

                $insLanguage = [];
                $insLanguage['user_id'] = $user->id;
                $insLanguage['language_id'] = $item2;
                AstrologerToLanguages::create($insLanguage);
            }
            Mail::to($request->email)->send(new EmailVerification($user));
            return redirect()->route('account.otp', ['id' => $user->id]);
            // return view('auth.success');
        }
        return redirect()->back()->withInput($request->input());
    }
    /**
     *   Method      : showRegistrationFormAstrologer
     *   Description : Astrologer Registration from view
     *   Author      : Soumojit
     *   Date        : 2021-APR-21
     **/
    public function VerifyEmail($id=null,$vcode = null)
    {
        $userData=User::where('id',$id)->where('status','!=','D')->first();
        if(@$userData){
            if(@$userData->is_email_verify=='N'){
                if($userData->vcode== $vcode){
                    $upd=[];
                    if (@$userData->status == 'U') {
                        $upd['status'] = 'A';
                    }
                    if (@$userData->user_type =='C' && @$userData->user_unique_code==null) {
                        $allCustomer= User::where('user_unique_code','!=',null)->where('user_type','C')->get();
                        $code='CUS';
                        $sum=str_pad($allCustomer->count()+1, 7, '0', STR_PAD_LEFT);
                        $upd['user_unique_code']=$code.$sum;
                    }
                    if (@$userData->user_type =='P' && @$userData->user_unique_code==null) {
                        $allCustomer= User::where('user_unique_code','!=',null)->where('user_type','P')->get();
                        $code='PUN';
                        $sum=str_pad($allCustomer->count()+1, 7, '0', STR_PAD_LEFT);
                        $upd['user_unique_code']=$code.$sum;
                    }
                    if (@$userData->user_type =='A' && @$userData->user_unique_code==null) {
                        $allCustomer= User::where('user_unique_code','!=',null)->where('user_type','A')->get();
                        $code='AST';
                        $sum=str_pad($allCustomer->count()+1, 7, '0', STR_PAD_LEFT);
                        $upd['user_unique_code']=$code.$sum;
                    }
                    $upd['vcode'] = null;
                    $upd['is_email_verify'] = 'Y';
                    User::where('id', $userData->id)->update($upd);

                    // assign-pundit-pujas
                     $checkPundit = PunditToPuja::where('user_id',$userData->id)->first();
                    if (@$userData->user_type=="P" && $checkPundit=='') {
                       $allPuja = Puja::get();
                            foreach ($allPuja as $key => $value) {
                              PunditToPuja::create([
                                  'user_id' =>$userData->id,
                                  'puja_id' =>$value->id,
                              ]);
                            }

                    }
                    session()->flash('success', \Lang::get('auth.email_verify'));
                    if (@Auth::user()->user_type == 'A') {
                        return redirect()->route('astrologer.profile');
                    }
                    if (@Auth::user()->user_type == 'C') {
                        return redirect()->route('customer.profile');
                    }
                    if (@Auth::user()->user_type == 'P') {
                        return redirect()->route('pundit.profile');
                    }
                    return redirect()->route('login');
                }
                session()->flash('error', \Lang::get('auth.invalid_verification_link'));
                if (@Auth::user()->user_type == 'A') {
                    return redirect()->route('astrologer.profile');
                }
                if (@Auth::user()->user_type == 'C') {
                    return redirect()->route('customer.profile');
                }
                if (@Auth::user()->user_type == 'P') {
                    return redirect()->route('pundit.profile');
                }
                return redirect()->route('login');
            }
            session()->flash('error', \Lang::get('auth.user_already_verify'));
            if (@Auth::user()->user_type == 'A') {
                return redirect()->route('astrologer.profile');
            }
            if (@Auth::user()->user_type == 'C') {
                return redirect()->route('customer.profile');
            }
            if (@Auth::user()->user_type == 'P') {
                return redirect()->route('pundit.profile');
            }
            return redirect()->route('login');
        }
        session()->flash('error', \Lang::get('auth.invalid_verification_link'));
        if (@Auth::user()->user_type == 'A') {
            return redirect()->route('astrologer.profile');
        }
        if (@Auth::user()->user_type == 'C') {
            return redirect()->route('customer.profile');
        }
        if (@Auth::user()->user_type == 'P') {
            return redirect()->route('pundit.profile');
        }
        return redirect()->route('login');
    }
    /**
     *   Method      : showRegistrationFormSeller
     *   Description : Seller Registration from view
     *   Author      : Soumojit
     *   Date        : 2021-APR-27
     **/
    public function showRegistrationFormSeller()
    {
        return view('auth.seller_signup');
    }
    /**
     *   Method      : sellerRegister
     *   Description : seller Registration
     *   Author      : Soumojit
     *   Date        : 2021-APR-27
     **/
    public function sellerRegister(Request $request)
    {
        // dd( $request->file);
        $request->validate([
            'email' => 'required',
            'mobile' => 'required',
            'name' => 'required',
            'description' => 'required',
            'address' => 'required',
        ]);
        $ins = [];

        $ins['name'] = $request->name;
        $ins['email'] = $request->email;
        $ins['mobile'] = $request->mobile;
        $ins['address'] = $request->address;
        $ins['description'] = $request->description;
        if($request->hasFile('file')){
            $image = $request->file;
            $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
            Storage::putFileAs('public/seller_file', $image, $filename);
            $ins['file'] = $filename;
        }


        $user = SellersContact::create($ins);
        session()->flash('success', \Lang::get('auth.seller_success'));
        return redirect()->route('seller.register');
    }
    /**
     *   Method      : verifyOTP
     *   Description : verify otp
     *   Author      : Soumojit
     *   Date        : 2021-APR-27
     **/
    public function verifyOTP(Request $request,$id=null)
    {
        $otp= @$request->codeBox1 . @$request->codeBox2 . @$request->codeBox3 . @$request->codeBox4 . @$request->codeBox5 . @$request->codeBox6;
        // return $otp;

        $userData = User::where('id', $id)->where('status', '!=', 'D')->first();
        if (@$userData) {
            if (@$userData->is_mobile_verify == 'N') {
                if(@$userData->otp==$otp){
                    $upd = [];
                    if (@$userData->user_type =='C' && @$userData->user_unique_code==null) {
                        $allCustomer= User::where('user_unique_code','!=',null)->where('user_type','C')->get();
                        $code='CUS';
                        $sum=str_pad($allCustomer->count()+1, 7, '0', STR_PAD_LEFT);
                        $upd['user_unique_code']=$code.$sum;
                    }
                    if (@$userData->user_type =='P' && @$userData->user_unique_code==null) {
                        $allCustomer= User::where('user_unique_code','!=',null)->where('user_type','P')->get();
                        $code='PUN';
                        $sum=str_pad($allCustomer->count()+1, 7, '0', STR_PAD_LEFT);
                        $upd['user_unique_code']=$code.$sum;
                    }
                    if (@$userData->user_type =='A' && @$userData->user_unique_code==null) {
                        $allCustomer= User::where('user_unique_code','!=',null)->where('user_type','A')->get();
                        $code='AST';
                        $sum=str_pad($allCustomer->count()+1, 7, '0', STR_PAD_LEFT);
                        $upd['user_unique_code']=$code.$sum;
                    }
                    if (@$userData->status == 'U') {
                        $upd['status'] = 'A';
                    }
                    $upd['otp'] = null;
                    $upd['is_mobile_verify'] = 'Y';
                    User::where('id', $userData->id)->update($upd);
                    // assign-pundit-pujas
                    $checkPundit = PunditToPuja::where('user_id',$userData->id)->first();
                    if (@$userData->user_type=="P" && $checkPundit=='') {
                       $allPuja = Puja::get();
                            foreach ($allPuja as $key => $value) {
                              PunditToPuja::create([
                                  'user_id' =>$userData->id,
                                  'puja_id' =>$value->id,
                              ]);
                            }

                    }


                    session()->flash('success', \Lang::get('auth.mobile_verify'));
                    if(@Auth::user()->user_type=='A'){
                        return redirect()->route('astrologer.profile');
                    }
                    if(@Auth::user()->user_type=='C'){
                        return redirect()->route('customer.profile');
                    }
                    if(@Auth::user()->user_type=='P'){
                        return redirect()->route('pundit.profile');
                    }
                    return redirect()->route('login');
                }
                session()->flash('error', \Lang::get('auth.otp_wrong'));
                if (@Auth::user()->user_type == 'A') {
                    return redirect()->route('astrologer.profile');
                }
                if (@Auth::user()->user_type == 'C') {
                    return redirect()->route('customer.profile');
                }
                if (@Auth::user()->user_type == 'P') {
                    return redirect()->route('pundit.profile');
                }
                return redirect()->back()->withInput($request->input());
            }
            session()->flash('error', \Lang::get('auth.user_already_verify'));
            if (@Auth::user()->user_type == 'A') {
                return redirect()->route('astrologer.profile');
            }
            if (@Auth::user()->user_type == 'C') {
                return redirect()->route('customer.profile');
            }
            if (@Auth::user()->user_type == 'P') {
                return redirect()->route('pundit.profile');
            }
            return redirect()->route('login');
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        if (@Auth::user()->user_type == 'A') {
            return redirect()->route('astrologer.profile');
        }
        if (@Auth::user()->user_type == 'C') {
            return redirect()->route('customer.profile');
        }
        if (@Auth::user()->user_type == 'P') {
            return redirect()->route('pundit.profile');
        }
        return redirect()->route('login');
    }
    /**
     *   Method      : otp
     *   Description : otp view page
     *   Author      : Soumojit
     *   Date        : 2021-APR-27
     **/
    public function otp($id = null)
    {
        $userData = User::where('id', $id)->where('status', '!=', 'D')->first();
        if (@$userData) {
            if (@$userData->is_mobile_verify=='N') {
                return view('auth.otp_verify')->with(['data'=> $userData]);
            }
            session()->flash('error', \Lang::get('auth.user_already_verify'));
            return redirect()->route('login');
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('login');
    }
    /**
     *   Method      : resendOtp
     *   Description : resend otp
     *   Author      : Soumojit
     *   Date        : 2021-APR-27
     **/
    public function resendOtp($id = null)
    {
        $userData = User::where('id', $id)->where('status', '!=', 'D')->first();
        if (@$userData) {
            if (@$userData->is_mobile_verify=='N') {
                // $upd['otp'] = mt_rand(100000, 999999);
                $upd['otp'] = $userData->otp;
                $userUpdate = User::where('id', $userData->id)->update($upd);
                if ($userUpdate == null) {
                    $response['result']['error'] = \Lang::get('auth.resend_otp_error');

                } else {
                    $response['result']['success'] = \Lang::get('auth.resend_otp');
                }
                return response()->json($response);
                // return view('auth.otp_verify')->with(['data'=> $userData]);
            }
            // session()->flash('error', \Lang::get('auth.user_already_verify'));
            $response['result']['error'] = \Lang::get('auth.user_already_verify');
            // return redirect()->route('login');
            return response()->json($response);
        }
        // session()->flash('error', \Lang::get('profile.something_went_wrong'));
        $response['result']['error'] = \Lang::get('profile.something_went_wrong');
        // return redirect()->route('login');
        return response()->json($response);
    }
    public function checkEmail(Request $request)
    {
        if ($request->email) {
            $checkEmail = User::whereIn('status', ['A', 'I', 'U'])->where('email', $request->email)->count();
            if ($checkEmail > 0) {
                return response('false');
            } else {
                return response('true');
            }
        }
        return response('no email');
    }
    public function checkMobile(Request $request)
    {
        if ($request->mobile) {
            $checkMobile = User::whereIn('status', ['A', 'I', 'U'])->where('mobile', $request->mobile)->count();
            if ($checkMobile > 0) {
                return response('false');
            } else {
                return response('true');
            }
        }
        return response('no mobile');
    }
}
