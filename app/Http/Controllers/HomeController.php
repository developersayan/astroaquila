<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\State;
use Illuminate\Support\Facades\Cookie;
use App\Models\CallStatus;
use App\Models\Commission;
use App\Models\OrderMaster;
use App\Models\CurrencyConversion;
use Pusher\Pusher;
use App\Models\CallHistory;
use App\Models\City;
use App\Models\WikiCategory;
use App\Models\WikiTitle;
use App\Models\AquilaWiki;
use App\Models\Area;
use App\Models\ZipMaster;
use App\Models\UserRegistrationId;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function gateState(Request $request)
    {
        $response = [
            "jsonrpc" => "2.0"
        ];
        if ($request->params['countryId']) {
            $state = State::where('country_id', $request->params['countryId'])->get();
            $response['status'] = 1;
            $response['result'] = $state;
            return response()->json($response);
        }
    }
    /**
     *   Method      : gateCity
     *   Description : to get city on state basis
     *   Author      : Argha
     *   Date        : 2021-Dec-13
     **/
    public function gateCity(Request $request)
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
     *   Description : to get area on pincode basis
     *   Author      : Argha
     *   Date        : 2021-Dec-13
     **/
    public function getArea(Request $request)
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
            if($postcode){
                $response['postcode'] = 1;
            }else{
                $response['postcode'] = 0;
            }
            $response['result'] = $area;
            return response()->json($response);
        }
    }
    /**
     *   Method      : lang
     *   Description : lang change
     *   Author      : Soumojit
     *   Date        : 2021-May-18
     **/
    public function lang($id)
    {
        session(['lang' => $id]);
        Cookie::queue('lang', $id);
        if ($id == 1) {
            // App::setLocale('en');
            session(['langCode' => 'en']);
            Cookie::queue('langCode', 'en');
        }
        if ($id == 2) {
            session(['langCode' => 'hi']);
            Cookie::queue('langCode', 'hi');
            // App::setLocale('ar');
        }
        $value = session()->get('lang');
        return redirect()->back();
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
            if (@$userData->is_mobile_verify == 'N') {
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

    /**
     *   Method      : currency
     *   Description : currency change
     *   Author      : Soumojit
     *   Date        : 2021-AUG-13
     **/
    public function currency($id)
    {
        session(['currency' => $id]);
        Cookie::queue('currency', $id);
        if ($id == 1) {
            // App::setLocale('en');
            session(['currencyCode' => 'inr']);
            session(['currency' => $id]);
            Cookie::queue('currencyCode', 'en');
            Cookie::queue('currency', $id);
        }
        if ($id == 2) {
            session(['currencyCode' => 'usd']);
            session(['currency' => $id]);
            Cookie::queue('currencyCode', 'hi');
            Cookie::queue('currency', $id);
            // App::setLocale('ar');
        }
        $value = session()->get('currency');
        return redirect()->back();
    }

    /**
    *   Method      : verifyEmail
    *   Description : Astrologer Check Duplicate Email And Verifiy Mail
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
            }else{
                $update_details = User::where('id',$id)->where('temp_vcode',$vcode)->update([
                    'email'=>$getdata->temp_email,
                    'temp_vcode'=>'',
                    'temp_email'=>'',
                    'is_email_verify'=>'Y',
                    'status'=>'A',
                ]);
                session()->flash('success', \Lang::get('profile.email_change_success'));
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
        }else{
            // check-only via id
            $id = User::where('id',$id)->first();
            if ($id) {
                session()->flash('error', \Lang::get('profile.something_went_wrong_email'));
                if(@Auth::user()->user_type=='A') {
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
        }
    }


    public function twilioCall(Request $request) {

        if($request['Direction'] == 'outbound-dial') {
            // $commission = Commission::first();
            $order = OrderMaster::where(['ParentCallSid' => $request['ParentCallSid']])->first();
            $callhistory = CallHistory::where(['twilio_response'=>$request['ParentCallSid']])->first();
            // update order master table
            // $update['call_status'] = $request['CallStatus'];
            // $update['client_call_s_id'] = $request['CallSid'];
            $update=[];
            if($request['CallStatus'] == 'completed') {
                // $duration = $callhistory->completed_call;
                // // covert time into min
                // $tot_duration = $duration+$request['CallDuration'];
                // $upd['completed_call'] = $tot_duration;
                // $order_duration = $order->duration*60;
                // if ($tot_duration>=$order_duration) {
                //    $update['status'] = 'C';
                // }




                // $update['status'] = 'C';
                // $update['call_status'] = 'C';
                // $update['duration'] = $request['CallDuration'];
                // $update['total_rate'] = ($order->rate/60)*$request['CallDuration'];
                // $update['commission'] = $update['total_rate']*($commission->call_comm/100);
                // $update['wallet_adjustment'] = $update['total_rate']*($commission->call_comm/100);
                // $update['payment_status'] = 'P';
            }
            if($request['CallStatus'] == 'no-answer') {
                // $update['status'] = 'CA';
                $update['call_status'] = 'N';
            }
            if($request['CallStatus'] == 'busy') {
                // $update['status'] = 'CA';
                $update['call_status'] = 'B';
            }
            if($request['CallStatus'] == 'in-progress') {
                if ($order->status!="C") {
                     $update['status'] = 'IP';
                }

                $update['call_status'] = 'IP';

                // $time = $history->completed_call;
                // CallHistory::where(['twilio_response'=>$request['ParentCallSid']])->update(['completed_call'=>$time+1]);
                // $callTiming = CallHistory::where(['twilio_response'=>$request['ParentCallSid']])->first();
                // $duration = $callTiming->completed_call;
                // $order_duration = $order->duration*60;
                // if ($duration>=$order_duration) {
                //     $update['status'] = 'C';
                // }

            }
            if($request['CallStatus'] == 'ringing') {
                $update['call_status'] = 'R';
            }

            OrderMaster::where(['ParentCallSid' => $request['ParentCallSid']])->update($update);
            CallHistory::where(['twilio_response' => $request['ParentCallSid']])->update($upd);
            // $order = OrderMaster::where(['ParentCallSid' => $request['ParentCallSid']])->first();

            // if($request['CallStatus'] == 'in-progress' || $request['CallStatus'] == 'ringing') {
            //     $update1['is_busy'] = 'Y';
            // } else {
            //     $update1['is_busy'] = 'N';
            // }
            // // update for astrologer busy or not
            // User::where(['id' => $order->astrologer_id])->update($update1);

        }
        // insert to call_status table
        CallStatus::create([
            'data'              => json_encode($request->all()),
            'parent_call_s_id'  => $request['ParentCallSid'],
            'call_s_id'         => $request['CallSid']
        ]);
    }


    public function currencyConversion()
    {
        $url = 'https://api.exchangerate-api.com/v4/latest/USD';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        $final = json_decode($result, true);
        curl_close($ch);
        $inr = CurrencyConversion::where('to_currency',1)->update(['conversion_factor'=>$final['rates']['INR']]);
        $usd = CurrencyConversion::where('to_currency',2)->update(['conversion_factor'=>$final['rates']['USD']]);
        $aud = CurrencyConversion::where('to_currency',3)->update(['conversion_factor'=>$final['rates']['AUD']]);
        $gbp = CurrencyConversion::where('to_currency',4)->update(['conversion_factor'=>$final['rates']['GBP']]);
        $euro = CurrencyConversion::where('to_currency',5)->update(['conversion_factor'=>$final['rates']['EUR']]);
    }


    public function termsCondtion()
    {
        return view('modules.privacy_policy.terms_condition');
    }

    public function privacyPolicy()
    {
        return view('modules.privacy_policy.privacy_policy');
    }

	public function testPusherMessage()
	{
		$options = array(
			'cluster' => 'ap2',
		  );
		$pusher = new Pusher(
			'98959e08c5fcd91e0413',
			'6a1d30bebad7609fb729',
			'1310552',
			$options
		  );

		  $data['message'] = 'This is my new message';
		  $pusher->trigger('astroaquila', 'eventnew', $data);
	}


    public function updateCall(Request $request)
    {
        // return $request->params['order_id'];
        $response = [
            "jsonrpc"   =>  "2.0"
        ];
        $callHistory = CallHistory::where('order_id',$request->params['order_id'])->first();
        $order = OrderMaster::where('id',$request->params['order_id'])->first();
        $second = $order->duration*60;
        OrderMaster::where('id',$request->params['order_id'])->update(['status'=>'C']);
        CallHistory::where('order_id',$request->params['order_id'])->update(['completed_call'=>$second]);
        return response()->json($response);

    }


    public function wiki(Request $request)
    {
        $data = [];
        $data['data'] = AquilaWiki::orderBy('id','desc');
        if (@$request->keyword) {
            $data['data'] = $data['data']->where(function($query){
                $query->where('article_title','LIKE','%'.request('keyword').'%')
                      ->orWhere('description','LIKE','%'.request('keyword').'%');
            });
        }
        if (@$request->title) {
            $data['data'] = $data['data']->where('title',@$request->title);
        }
        if (@$request->category) {
            $data['data'] = $data['data']->where('category',@$request->category);
        }
        if (@$request->subcategory) {
            $data['data'] = $data['data']->where('subcategory',@$request->subcategory);
        }
        if(@$request->sort_by)
        {

             if(@$request->sort_by==1)
               {
                   $data['data'] = $data['data']->orderBy('article_title','asc');
               }
        }
        if (@$request->show_result){

             $data['data']= $data['data']->paginate(@$request->show_result);
        }else{
            $data['data'] = $data['data']->paginate(12);
        }
        $title = $data['data']->pluck('title')->toArray();
        $category = $data['data']->pluck('category')->toArray();
        // return $category;
        $data['title'] = WikiTitle::whereIn('id',$title)->get();
        $data['category'] = WikiCategory::whereIn('id',$category)->where('parent_id',0)->get();
        if ($request->category) {
            $subcategory = $data['data']->pluck('subcategory')->toArray();
            $data['subcategory'] = WikiCategory::whereIn('id',$subcategory)->get();
        }
        $data['totaldata'] = $data['data']->count();
        return view('modules.wiki.search',$data);
    }

    public function wikidetails($slug)
    {
        $data =[];
        $data['data'] = AquilaWiki::where('slug',$slug)->first();
        $data['similar']=AquilaWiki::where('category',$data['data']->category)->where('id','!=',$data['data']->id)->paginate(5);
        return view('modules.wiki.details',$data);
    }

	/*
     * Method : changeDash
     * Description : Used Ajax call in user dashboard when notification of web in user dashboard comes change the value evrything in dashboard required.
     * Author : Madhuchandra
	 * Date:2021-DEC-27
     */
    public function changeDash(Request $request) {
        if(@$request->all()){
            // $response = ['jsonrpc'=>'2.0'];
            // $reqData = $request->json()->all();
            // $token = $reqData['data']['token'];
            // dd($token);
            // dd();
            // dd($token);
            $token = @$request->token;
			//dd($token);
            #reg web notify
            $this->updateUser($token);
        }


    }
	/*
    * Method: updateUser
    * Description: This method is used to update user
    * Author: Madhuchandra
	* Date:2021-DEC-27
    */
    private function updateUser($token){
        $token = $token;
        // dd($token);
        // $email = $request->data['email'];
        // $password = $request->data['password'];
        $user = User::where(['id'=>auth()->user()->id])->first();
        if(@$user){
            $firebaseToken_id['firebaseToken_id']   = $token;
            User::where('id',@$user->id)->update($firebaseToken_id);
            $this->updateUserMultipleToken($user,$token);
        }

    }
    /*
    * Method: updateUserMultipleToken
    * Description: This method is used to update multiple token
    * Author: Madhuchandra
	* Date:2021-DEC-27
    */
    private function updateUserMultipleToken($user,$token){
        $updateUser['reg_id'] = @$token;
        $updateUser['user_id'] = @$user->id;

        $regIds = UserRegistrationId::where(['reg_id' => @$token])->first();

        if(!@$regIds) {
            UserRegistrationId::create($updateUser);
        }else{
            $upd['user_id'] = @$user->id;
            UserRegistrationId::where(['reg_id'=>@$token])->update($upd);
        }
    }
	/*
    * Method: testFireBase
    * Description: For testing push notification sending
    * Author: Madhuchandra
	* Date:2021-DEC-27
    */
	public function testFireBase()
	{
		$new_registrationIds = UserRegistrationId::pluck('reg_id')->toArray();
		$username = "Customer placed order!";
		$title = $username." Recently customer placed an order!";
		$message = "New order Placed !";
		$fields = array (
			'registration_ids' => $new_registrationIds,
			'data' => array (
				"message"       => $message,
				"title"         => $title,
				"image"         => url('firebase-logo.png'),
			)

		);
		$fields = json_encode ( $fields );
		$API_ACCESS_KEY = env('FIREBASE_ACCESS_KEY');
		$headers = array(
			'Authorization: key=' . $API_ACCESS_KEY,
			'Content-Type: application/json',
		);
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
		$result = curl_exec ( $ch );
		curl_close ( $ch );
		return $result.' New Order placed! ';
	}

    public function video()
    {
        return view('modules.video_call.video_call');
    }










}
