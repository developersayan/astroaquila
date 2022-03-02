<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CallHistory;
use App\Models\CallChatHistory;
use App\Models\OrderMaster;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      // exchangerate-api///////////
    // $currency_input = 10;
    // //currency codes : http://en.wikipedia.org/wiki/ISO_4217
    // $currency_from = "INR";
    // $currency_to = "USD";
    // $url = 'https://api.exchangerate-api.com/v4/latest/USD';
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_URL, $url);
    // $result = curl_exec($ch);
    // $final = json_decode($result, true);
    // curl_close($ch);
    // dd($final['rates']);
	$data=array();
	//dd(Auth::user());

	//dd($data['cart_data']);
        \View::composer('includes.*', function ($view) use($data) {
			if(Auth::check())
			{
				$chat_audio_over='N';
				$call_history=CallHistory::with('orderDetails.astrologer','orderDetails.customer','orderDetails.orderPujaNames')->where(function($query){
					$query->where('astrologer_id',Auth::user()->id)->orWhere('user_id',Auth::user()->id);
				})->where('call_status','I')->where('call_type','C')->first();
				$data['call_history']=@$call_history;
				$data['chat_history']=$callChatHistory=CallChatHistory::where('call_history_id',@$call_history->id)->get();
				$message_count=CallChatHistory::where('call_history_id',@$call_history->id)->count();
				$chat_count1=CallChatHistory::where('call_history_id',@$call_history->id)->where('sent_by',@$call_history->astrologer_id)->count();
				$chat_count2=CallChatHistory::where('call_history_id',@$call_history->id)->where('sent_by',@$call_history->user_id)->count();
				if(@$message_count==1 && @$call_history->chat_audio_over=='N' && ($call_history->user_id==Auth::user()->id || $call_history->astrologer_id==Auth::user()->id) && $callChatHistory[0]->sent_by!=Auth::user()->id)
				{
					$chat_audio_over='Y';
				}
				if(@$call_history)
				{
					if(@$call_history->is_per_minute=='N')
					{
						$data['call_end_time']=$call_end_time=date('Y-m-d H:i:s',strtotime('+'.$call_history->call_duration.' minutes '.$call_history->call_start_time));
						//dd($call_end_time);
						if($call_end_time<=$call_history->call_start_time)
						{
							$dateTimeObject1 = date_create(date('Y-m-d H:i:s',strtotime($call_history->call_start_time)));
							$dateTimeObject2 = date_create(date('Y-m-d H:i:s',strtotime($call_end_time)));
							$interval = date_diff($dateTimeObject1, $dateTimeObject2);
							$min = ($interval->h*60)+($interval->i*60)+$interval->s;
							$update=array();
							$update['call_status']='C';
							$update['completed_call']=$min;
							$update['call_end_time']=date('Y-m-d H:i:s');
							CallHistory::where('id',$call_history->id)->update($update);
							OrderMaster::where('id',$call_history->order_id)->update(['status'=>'C']);
						}
					}

				}
				$data['chat_audio_over']=$chat_audio_over;
				$data['chat_count1']=@$chat_count1;
				$data['chat_count2']=@$chat_count2;
			}
            $view->with($data);
        });





    }
}
