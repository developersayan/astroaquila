<?php

namespace App\Http\Controllers\Modules\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pusher\Pusher;
use App\Models\CallHistory;
use App\Models\CallChatHistory;
use App\User;
use App\Models\OrderMaster;
use App\Models\UserWallet;
use App\Models\OrderPujaNames;

class ChatController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');

    }
    /**
    *   Method      : sendMessage
    *   Description : This is use to send message to the opposite user
    *   Author      : Madhuchandra
    *   Date        : 2021-DEC-06
    **/
    public function sendMessage(Request $request)
    {
		//dd(@$request->all());
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER')
        ]);
        $senderId = auth()->user()->id;
		$filename='';
		CallHistory::where('id',$request->booking_id)->update(['socket_id'=>$request->socket_id]);
        if($request->file){
            $file = $request->file;
            $filename = time() . '-' . rand(1000, 9999) .'_'. $file->getClientOriginalName();
            \Storage::putFileAs('public/astrologer_chat_image', $file, $filename);
        }


        $callhistory=CallHistory::where('id',$request->booking_id)->first();
        $order_details=OrderMaster::with('customer','astrologer')->where('id',$callhistory->order_id)->first();
        $link="<a href='".route('chat.with.astrologer',['id'=>$request->booking_id])."' target='_blank'>".@$order_details->order_id."</a>";
        if(@$callhistory->user_id==auth()->user()->id)
		{
			$to_id=$callhistory->astrologer_id;
		}
		else
		{
			$to_id=$callhistory->user_id;
		}

		$createData=array();
		$createData['call_history_id']  =  @$request->booking_id;
		$createData['user_id']            =  $callhistory->user_id;
		$createData['astrologer_id']            =  $callhistory->astrologer_id;
		$createData['sent_by']            =  auth()->user()->id;
		$createData['message']            =  @$request->message ? $request->message : null;
		$createData['file']               =  @$filename;
		$chat_data=CallChatHistory::create($createData);

		$chat_data=CallChatHistory::where('id',$chat_data->id)->first();

		$resultinterval=getDateTimeDiff($chat_data->created_at,date('Y-m-d H:i:s'));
        // $userCount=(count($to_id)-1);
        // if($userCount>0){
        //     $username.=' +'.$userCount;
        // }
        // $toDetails = User::find($userId);
		if($callhistory->chat_started == 0){
            
			
        }
		$chat_count1=CallChatHistory::where('call_history_id',$callhistory->id)->where('sent_by',$callhistory->astrologer_id)->count();
		$chat_count2=CallChatHistory::where('call_history_id',$callhistory->id)->where('sent_by',$callhistory->user_id)->count();
		if(@$callhistory->chat_started!=1 && @$chat_count1>=1 && @$chat_count2>=1)
		{
			$call_start = strtotime(date('Y-m-d H:i:s'))*1000;
            CallHistory::where('id',$callhistory->id)->update(['call_start_time' => date('Y-m-d H:i:s'),'chat_started' => 1]);			
		}
		$callhistory=CallHistory::where('id',$request->booking_id)->first();
		$call_start = strtotime($callhistory->call_start_time)*1000;
		if(@$callhistory->is_per_minute=='N')
		{
			$call_end_time=date('Y-m-d H:i:s',strtotime('+'.$callhistory->call_duration.' minutes ',strtotime($callhistory->call_start_time)));
			$call_end_time = strtotime($call_end_time)*1000;
		}		
        $response = $pusher->trigger('astroaquila', 'receive-event', [
            'to_id'         =>  $to_id,
            'from'          =>  auth()->user()->first_name." ".auth()->user()->last_name,
            'online_status' =>  'Y',
            'file'          =>  @$filename,
            'booking_id'    =>  (int)@$request->booking_id,
            'is_per_minute'    =>  @$callhistory->is_per_minute,
            'chat_started'    =>  @$callhistory->chat_started,
            'created_at'    =>  $resultinterval,
			'call_end_time' => @$call_end_time,
            'call_start_time' => @$call_start,
			'chat_count1' => @$chat_count1,
            'chat_count2' => @$chat_count2,
            'from_image'    =>  auth()->user()->profile_image,
            'token'         =>  @$order_details->order_id,
            'link'          =>  @$link,
            'message'       =>  @$request->message ? $request->message : null,
            'username'      =>  $order_details->astrologer->first_name." ".$order_details->astrologer->last_name,
            'pusher_message_master_id' => (int)@$request->booking_id,
            'image'         =>  auth()->user()->profile_img ? url('storage/app/public/profile_picture/'.auth()->user()->profile_img) : url('public/frontend/images/blank.png'),
        ], $request->socket_id);
        //dd($response);
        

        if ($response) {
            return response()->json([
                'result' => [
                    'code' => 200,
                    'file'=>@$filename,
                    'created_at'=>$resultinterval,
                    'call_end_time' => @$call_end_time,
                    'call_start_time' => @$call_start,
					'chat_count1' => @$chat_count1,
					'chat_count2' => @$chat_count2,
					'chat_started' => @$callhistory->chat_started,
					'profile_image'=>auth()->user()->profile_img ? url('storage/app/public/profile_picture/'.auth()->user()->profile_img) : url('public/frontend/images/blank.png')
                ]
            ]);
        } else {
            return response()->json([
                'error' => [
                    'message' => 'Cound\'nt send message.'
                ]
            ]);
        }
    }
	/**
    *   Method      : showChat
    *   Description : This is use to show message to the users
    *   Author      : Madhuchandra
    *   Date        : 2021-DEC-06
    **/
    public function showChat($id)
    {
		$data=array();
		$call_history=CallHistory::with('orderDetails.astrologer','orderDetails.customer')->where('id',$id)->where(function($query){
				$query->where('astrologer_id',auth()->user()->id)->orWhere('user_id',auth()->user()->id);
			})->first();
		if(!$call_history)
		{
			return redirect()->route('home');
		}
		if(@$call_history->call_type!='C')
		{
			return redirect()->route('home');
		}
		if(!$call_history->call_start_time)
		{
			CallHistory::where('id',$id)->update(['call_start_time'=>date('Y-m-d H:i:s'),'call_status'=>'I']);
		}
		$data['call_history']=$call_history=CallHistory::with('orderDetails.astrologer','orderDetails.customer','orderDetails.orderPujaNames')->where('id',$id)->first();
		$data['chat_history']=CallChatHistory::where('call_history_id',$id)->get();
		if(@$call_history->is_per_minute=='N')
		{
			$data['call_end_time']=date('Y-m-d H:i:s',strtotime('+'.$call_history->call_duration.' minutes '.$call_history->call_start_time));
		}
		return view('modules.chat.chat',$data);
	}
	/**
    *   Method      : typingAjax
    *   Description : This is use to show message typing to the opposite user
    *   Author      : Madhuchandra
    *   Date        : 2021-DEC-06
    **/
    public function typingAjax(Request $request)
    {
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER')
        ]);
        $params = $request->all();
        $chat_details=CallHistory::where('id',$params['message_master_id'])->first();
		if(@$chat_details->user_id==auth()->user()->id)
		{
			$to_id=$chat_details->astrologer_id;
		}
		else
		{
			$to_id=$chat_details->user_id;
		}
        $response = $pusher->trigger('astroaquila', 'start-end-typing', [
            'from_id'   =>  auth()->user()->id,
            'to_id' => $to_id,
            'from' => $params['from'],
            'typing' => $params['typing'],
            'message_master_id' => (int) @$params['message_master_id'],
        ], $params['socket_id']);
        if ($response) {
            return response()->json([
                'result' => [
                    'code' => 200
                ]
            ]);
        } else {
            return response()->json([
                'error' => [
                    'message' => 'Cound\'nt send message.'
                ]
            ]);
        }
    }
	public function closeChat(Request $request){
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), [
            'cluster' => env('PUSHER_APP_CLUSTER')
        ]);
        $message_master = CallHistory::where('id', $request->id)->first();

        if(@$message_master){
			if(@$message_master->call_status!='C')
			{
				$dateTimeObject1 = date_create(date('Y-m-d H:i:s',strtotime($message_master->call_start_time)));
				$dateTimeObject2 = date_create(date('Y-m-d H:i:s'));
				$interval = date_diff($dateTimeObject1, $dateTimeObject2);
				$min = ($interval->h*60)+($interval->i*60)+$interval->s;
				$message_master->call_status = "C";
				$message_master->completed_call = $min;
				$message_master->call_end_time = date('Y-m-d H:i:s');
				$message_master->save();
				OrderMaster::where('id',$message_master->order_id)->update(['status'=>'C']);
			}
            $response = $pusher->trigger('astroaquila', 'close-event', [
                'booking_id'         =>  $message_master->id,
                'message_master_id'  =>  $message_master->id,
            ], $request->socket_id);
            if($response){
                return response()->json([
                    'booking_id'         =>  $message_master->id,
                    'message_master_id'  =>  $message_master->id,
                    'status'             =>  'success',
                ]);
            } else {
                return response()->json([
                    'status' => 'failure',
                ]);
            }
        }
        return response()->json([
            'status' => 'failure',
        ]);
    }
	/**
    *   Method      : balanceDeductPerminute
    *   Description : This is use to deduct balance from wallet every minute
    *   Author      : Madhuchandra
    *   Date        : 2021-DEC-14
    **/
    public function balanceDeductPerminute(Request $request)
    {
        //dd($request->all());
        $call_id=$request->message_master_id;
		$call_details=CallHistory::where('id',$call_id)->first();
		$order_details=OrderMaster::where('id',$call_details->order_id)->first();
		$wallet_balance=UserWallet::where('user_id',$order_details->customer_id)->where('currency_id',2)->first();
		$update=array();
		$update['wallet_balance']=$wallet_balance->wallet_balance-$order_details->rate;
		UserWallet::where('user_id',$order_details->customer_id)->where('currency_id',2)->update($update);
		$wallet_balance=UserWallet::where('user_id',$order_details->customer_id)->where('currency_id',2)->first();
        if($wallet_balance->wallet_balance>$order_details->rate) {
            return response()->json([
                'result' => [
                    'code' => 200
                ]
            ]);
        }
		else
		{
			return response()->json([
				'status' => 'failure',
			]);
		}
    }
	/**
    *   Method      : chatSoundOff
    *   Description : This is use to update the sound indicator
    *   Author      : Madhuchandra
    *   Date        : 2021-DEC-30
    **/
    public function chatSoundOff(Request $request)
    {
		$call_details=CallHistory::where('id',$request->message_master_id)->update(['chat_audio_over'=>'Y']);        
		return response()->json([
			'result' => [
				'code' => 200
			]
		]);
        
		
    }
}
