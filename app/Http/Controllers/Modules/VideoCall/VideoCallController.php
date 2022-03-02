<?php

namespace App\Http\Controllers\Modules\VideoCall;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use App\Models\CallHistory;
use App\Models\OrderMaster;
use App\Models\UserWallet;
use App\User;
use Mail;
use Session;
use DateTime;
use App\Models\OrderPujaNames;
class VideoCallController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('modules.video_call.video_call');
    }

   

    /**
     * Method: getTwilioToken
     * Description: This method is used to get twilio token
     * Author: Sayan
     * date:6-DECEMBER-2021
     */
    public function getTwilioToken(Request $request)
    {
        $accountSid = env('ACCOUNT_SID');
        $apiKeySid = env('TWILIO_API_KEY_SID');
        $apiKeySecret = env('TWILIO_API_KEY_SECRET');

        $identity = Auth::user()->name . '(#' . Auth::user()->id . ')';

        // Create an Access Token
        $token = new AccessToken(
            $accountSid,
            $apiKeySid,
            $apiKeySecret,
            3600,
            $identity
        );
        // Grant access to Video
        $grant = new VideoGrant();
        $grant->setRoom($request->roomName);
        $token->addGrant($grant);

        // Serialize the token as a JWT
        $response = [
            'token'     => $token->toJWT(),
            'identity'  => $identity
        ];
        return response()->json($response, 200);
    }
    /**
     * Method: updateCallTime
     * Description: This method is used to update video status to initiated
     * Author: Sayan
     * date:6-DECEMBER-2021
     */
    public function updateCallTime(Request $request)
    {
        
            $response = [
                'jsonrpc'   => '2.0'
            ];
            // $data = OrderMaster::where('order_id', $request->params['token'])->first();
            if ($request->params['token']) {
                // get old-call history 
                $oldCallHistory = CallHistory::where('order_id', $request->params['token'])->first();



                if ($request->params['user_type'] == 'C') {
                    CallHistory::where('order_id', $request->params['token'])->increment('caller_one',1);
                }
                if ($request->params['user_type'] == 'P') {
                    CallHistory::where('order_id', $request->params['token'])->increment('caller_two',1);
                }
                $data = CallHistory::where('order_id', $request->params['token'])->first();
                // if (@$data->caller_one > @$data->caller_two) {
                //     CallHistory::where('order_id', $request->params['token'])->update(['completed_call' => $data->caller_two]);
                // }
                // if (@$data->caller_one < @$data->caller_two) {
                //     CallHistory::where('order_id', $request->params['token'])->update(['completed_call' => $data->caller_one]);
                // }
                // if ($data->caller_one == $data->caller_two) {
                //     CallHistory::where('order_id', $request->params['token'])->update(['completed_call' => $data->caller_one]);
                // }



                CallHistory::where('order_id', $request->params['token'])->update(['call_end_time'=>date('Y-m-d H:i:s')]);
                
                

               
                $data2 = OrderMaster::where('id',$request->params['token'])->first();
                $data3 = CallHistory::where('order_id', $request->params['token'])->first();
                
                if ($oldCallHistory->is_per_minute=="N") {
                
                // if ($data3->completed_call == $data2->duration*60) {
                //    CallHistory::where('order_id', $request->params['token'])->update(['completed_call' => $data->caller_one]);
                //    CallHistory::where('order_id', $request->params['token'])->update(['call_status'=>'C']);
                //    OrderMaster::where('id', $request->params['token'])->update(['status'=>'C']);
                //    $response['result']['call_complete'] = 1;

                // }

            }else{
                if (@$data3->caller_one>@$oldCallHistory->caller_one) {
                    UserWallet::where('user_id',$oldCallHistory->user_id)->where('currency_id',2)->decrement('wallet_balance',$data2->rate);
                    $balance = UserWallet::where('user_id',$oldCallHistory->user_id)->first();
                    if ($data2->rate>$balance->wallet_balance) {
                        CallHistory::where('order_id', $request->params['token'])->update(['call_status'=>'C']);
                        OrderMaster::where('id', $request->params['token'])->update(['status'=>'C']);
                        $response['result']['call_complete'] = 1;
                    }

                }
            }

            
               
               $response['result']['status'] = 'success';
            }
            return response()->json($response);
        }
    /**
     * Method: startCall
     * Description: This method is used to update Call time
     * Author: Sayan
     * date:6-DECEMBER-2021
     */
    public function startCall(Request $request)
    {
        $response = [
            'jsonrpc'   => '2.0'
        ];
        $data = OrderMaster::where('id', $request->params['token'])->first();
        OrderMaster::where('id', $request->params['token'])->update(['status'=>'IP']);
        $data2 = CallHistory::where('order_id', $request->params['token'])->first();
       
        if ($request->params['token']) {
            CallHistory::where('order_id', $request->params['token'])->update([
                'caller_one'=> @$data2->completed_call,
                'caller_two'=> @$data2->completed_call
            ]);
            if ($data2->call_start_time=='') {
            CallHistory::where('order_id',$request->params['token'])->update(['call_start_time'=>date('Y-m-d H:i:s')]);
            $response['result']['status'] = 'success';
            }

            $response['result']['status'] = 'success';
        }
        $response['result']['status'] = 'success';
        return response()->json($response);
    }



    public function redirectUser($id)
    {
        // dd (Session::get('order_id'));

        $order = OrderMaster::where('id',$id)->first();
        $CallHistory = CallHistory::where('order_id',$id)->first();
        
        if (@$CallHistory->twilio_response!='updated') {
            $endtime = strtotime(date('Y-m-d h:i:s'));
        $start_time = strtotime($CallHistory->twilio_response);


        $sec = ($endtime - $start_time);

        // return $CallHistory->twilio_response; 
        $time = $CallHistory->completed_call+$sec-3;
        CallHistory::where('order_id',$id)->update(['completed_call'=>$time,'twilio_response'=>'updated']);
        }
        
        
        // return $data->completed_call;
        if (@$order->customer_id==auth()->user()->id) {
            if (@$order->status=="C") {
                return redirect()->route('customer.call');
            }else{
            return redirect()->route('customer.call')->with('error','Please call the astrologer again to complete the call');
          }
        }else {
            return redirect()->route('astrologer.call.history');
        }
    }


    public function videopage()
    {
        return view('modules.video_call.video_call');
    }

    public function callComplete($id)
    {

        $order = OrderMaster::where('id',$id)->first();
        OrderMaster::where('id',$id)->update(['status'=>'C']);
         $time = $order->duration*60;
        
        CallHistory::where('order_id',$order->id)->update(['completed_call'=>$time,'twilio_response'=>'complete']);
        if (@$order->customer_id==auth()->user()->id) {
            return redirect()->route('customer.call');
        }else {
            return redirect()->route('astrologer.call.history');
        }
    }

    public function startTimeUpdate(Request $request)
    {
        // return $request->time;
        $time = $request->time;
        $order = OrderMaster::where('id',$request->id)->first();
        CallHistory::where('order_id',$order->id)->update(['twilio_response'=>$time]);
        echo "success";
    }


    public function get_details(Request $request)
    {
        $response=array();

        $OrderPujaNames = OrderPujaNames::where('ordermaster_id',$request->id)->first();
        $order = OrderMaster::where('id',$request->id)->first();
        $html ='';
        if (@$OrderPujaNames->name) {
            $html.="<p class='order_ajax_details'><span>Name:</span>" .@$OrderPujaNames->name."</p>";
        }
        if(@$OrderPujaNames->dob){
            $html.="<p class='order_ajax_details'><span>DOB:</span>" .@$OrderPujaNames->dob."</p>";
        }
        if(@$OrderPujaNames->janama_nkshatra){
            $html.="<p class='order_ajax_details'><span>Nakshatra:</span>" .@$order->orderPujaNames->nakshatras->name."</p>";
        }
        if(@$OrderPujaNames->janam_rashi_lagna){
            $html.="<p class='order_ajax_details'><span>Rashi:</span>" .@$order->orderPujaNames->rashis->name."</p>";
        }

        if(@$OrderPujaNames->gotra){
            $html.="<p class='order_ajax_details'><span>Gotra:</span>" .@$order->orderPujaNames->gotra."</p>";
        }

        if(@$OrderPujaNames->place_of_residence){
            $html.="<p class='order_ajax_details'><span>Birth Place:</span>" .@$OrderPujaNames->place_of_residence."</p>";
        }

        if(@$order->relation){
            $html.="<p class='order_ajax_details'><span>Relation:</span>" .@$order->relation."</p>";
        }
        if (@$order->measurement) {
            $html.="<p class='order_ajax_details'><span>Measurement:</span>" .@$order->measurement."</p>";
        }

        if (@$order->expertise) {
            $html.="<p class='order_ajax_details'><span>Expertise:</span>" .@$order->expertise_name->expertise_name."</p>";
        }

       //  if (@$order->order_description) {
           
       //      if(strlen(@$order->order_description) >10){
       //      $html.= "<p class='order_ajax_details order_ajax_details_description aboutRemaove-review'>Description:" .substr(@$order->order_description, 0,10)."</p>
       //      <p class='moretext-review order_ajax_details order_ajax_details_description' style='display: none'>Description:".@$order->order_description."</p>
       //      <span class='moreless-button-review' style='color: #e8a173;cursor: pointer;'>Read More +</span>
       //      ";
       //  }else{
       //      $html.="<p class='order_ajax_details order_ajax_details_description'>Description:" .@$order->order_description."</p>";
       //  }
                                        
       // }
        if (@$order->astro_attachment) {
            $html.="<p class='order_ajax_details'><span>Attachment :</span> <a download class='download_video' href='".asset('storage/app/public/astro_attachment').'/'.@$order->astro_attachment."' alt='product'> Download</a></p>";
        }

        if (@$order->order_description) {
            $html.="<p class='order_ajax_details' style='word-break: break-all;'><span>Description:</span>" .substr(@$order->order_description,0,50)."..</p>";
         }   


        

        $response['details']=$html;
        return response()->json($response);
    }


}
