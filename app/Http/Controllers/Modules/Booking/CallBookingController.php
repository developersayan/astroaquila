<?php

namespace App\Http\Controllers\Modules\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\CallPurchase;
use App\Models\OrderMaster;
use App\Models\Commission;
use App\Models\UserToAvailable;
use App\Models\CallHistory;
use App\Models\AstrologerPersonTemp;
use App\Models\CustomerAstrologerName;
use App\Models\CustomerPujaNames;
use App\Models\Rashi;
use App\Models\Nakshatras;
use App\Models\Gotra;
use App\Models\ZipMaster;
use App\Models\OrderPujaNames;
use App\Models\UserWallet;
use App\Models\Expertise;
use App\Models\AstrologerToExpertise;
use App\Models\UserRegistrationId;


class CallBookingController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : callBooking
     *   Description : Booking for astrologer consultation
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-14
     **/
    public function callBooking(Request $request, $slug=null){
          //dd(@$request->all());
          $astrologerData=User::where('slug', $slug)->first();
			$call_price=0;
			$video_call_price=0;
			$chat_price=0;
			$offline_price=0;
			if(session()->get('currency')==1)
			{
				if(@$astrologerData->call_discount_inr)
				{
					$call_price=(@$astrologerData->call_price-((@$astrologerData->call_price*@$astrologerData->call_discount_inr)/100));
				}
				else
				{
					$call_price=@$astrologerData->call_price;
				}

				if(@$astrologerData->video_call_discount_inr)
				{
					$video_call_price=(@$astrologerData->video_call_price_inr-((@$astrologerData->video_call_price_inr*@$astrologerData->video_call_discount_inr)/100));
				}
				else
				{
					$video_call_price=@$astrologerData->video_call_price_inr;
				}

				if(@$astrologerData->chat_discount_inr)
				{
					$chat_price=(@$astrologerData->chat_price_inr-((@$astrologerData->chat_price_inr*@$astrologerData->chat_discount_inr)/100));
				}
				else
				{
					$chat_price=@$astrologerData->chat_price_inr;
				}

				if(@$astrologerData->offline_discount_price_inr)
				{
					$chat_price=(@$astrologerData->astrologer_offline_price_inr-((@$astrologerData->astrologer_offline_price_inr*@$astrologerData->offline_discount_price_inr)/100));
				}
				else
				{
					$chat_price=@$astrologerData->astrologer_offline_price_inr;
				}
			}
			else
			{
				if(@$astrologerData->call_discount_usd)
				{
					$call_price=((@$astrologerData->call_price_usd-((@$astrologerData->call_price_usd*@$astrologerData->call_discount_usd)/100))*currencyConversionCustom());
				}
				else
				{
					$call_price=@$astrologerData->call_price_usd*currencyConversionCustom();
				}

				if(@$astrologerData->video_call_discount_usd)
				{
					$video_call_price=((@$astrologerData->video_call_price_usd-((@$astrologerData->video_call_price_usd*@$astrologerData->video_call_discount_usd)/100))*currencyConversionCustom());
				}
				else
				{
					$video_call_price=@$astrologerData->video_call_price_usd*currencyConversionCustom();
				}

				if(@$astrologerData->chat_discount_usd)
				{
					$chat_price=((@$astrologerData->chat_price_usd-((@$astrologerData->chat_price_usd*@$astrologerData->chat_discount_usd)/100))*currencyConversionCustom());
				}
				else
				{
					$chat_price=@$astrologerData->chat_price_usd*currencyConversionCustom();
				}

				if(@$astrologerData->offline_discount_price_usd)
				{
					$offline_price=((@$astrologerData->astrologer_offline_price_usd-((@$astrologerData->astrologer_offline_price_usd*@$astrologerData->offline_discount_price_usd)/100))*currencyConversionCustom());
				}
				else
				{
					$offline_price=@$astrologerData->astrologer_offline_price_usd*currencyConversionCustom();
				}
			}
		  if(@$request->instant_duration)
		  {
			$amount=0;
			$astro_rate=0;
			$conversionFactor=currencyConversionCustom();
			if(@$request->booking_type=='A')
			{
				$amount=$request->instant_duration*@$call_price;
				$astro_rate=$call_price;
			}
			elseif(@$request->booking_type=='V')
			{
				$amount=$request->instant_duration*@$video_call_price;
				$astro_rate=$video_call_price;
			}
			elseif(@$request->booking_type=='C')
			{
				$amount=$request->instant_duration*@$chat_price;
				$astro_rate=$chat_price;
			}
			$mintime = date('Y-m-d H:i:s');
			$endtime = date('H:i:s',strtotime('+'.$request->instant_duration.'minutes',strtotime($mintime)));
			$ins['from_time'] = date('H:i:s',strtotime($mintime));
			$ins['end_time'] = $endtime;
			$ins['customer_id']=auth()->user()->id;
			$ins['user_id']= $astrologerData->id;
			$ins['duration']= @$request->instant_duration;
			$ins['status']= 'T';
			$ins['payment_status']= 'I';
			$ins['date']= $mintime;
			$ins['currency_id'] = session()->get('currency');
			$ins['order_type'] = @$request->booking_type;
			$ins['subtotal']=$amount;
			$ins['total_rate']=$amount;
			$ins['rate']=$astro_rate;
			$createBooking= OrderMaster::create($ins);

			$code='';
			$idlength=strlen($createBooking->id);
			if($idlength>4)
			{
				$code=$createBooking->id;
			}
			else
			{
				for($i=0;$i<(4-$idlength);$i++)
				{
					$code.='0';
				}
				$code=$code.$createBooking->id;
			}
			$upd=[];
			$upd['order_id']='O'.date('y').date('m').date('d').$code;
			OrderMaster::where('id', $createBooking->id)->update($upd);
			$call_ins=[];
			$call_ins['user_id']=auth()->user()->id;
			$call_ins['astrologer_id']=$astrologerData->id;
			$call_ins['order_id']=$createBooking->id;
			$call_ins['call_date_time']=date('Y-m-d H:i:s');
			$call_ins['call_duration']=$request->instant_duration;
			$call_ins['call_type']=$request->booking_type;
			$call_ins['book_type']='I';
			$call_ins['call_status']='B';
			if($request->instant_duration==1)
			{
				$call_ins['is_per_minute']='Y';
			}
			CallHistory::create($call_ins);
		  }
		  else
		  {
				$ins=[];
				$array = $request->slot_name;
				$min =  min($array);
				$max =  max($array);
				$duration=count($array)*15;
				/*if(count($array)==1)
				  {
					$duration=15;
				  }
				  else
				  {
					$dateTimeObject1 = date_create(date('Y-m-d',strtotime($request->date)).' '.date('H:i:s',strtotime($min)));
					$dateTimeObject2 = date_create(date('Y-m-d',strtotime($request->date)).' '.date('H:i:s',strtotime($max)));
					$interval = date_diff($dateTimeObject1, $dateTimeObject2);
					$min = ($interval->h*60)+$interval->i;
					$duration=$min;
				  }*/
				$mintime = min($request->slot_name);
				$endtime = date('H:i:s',strtotime('+'.$duration.'minutes',strtotime($mintime)));
				$amount=0;
				$astro_rate=0;
				$conversionFactor=currencyConversionCustom();

				if(@$request->booking_type=='A')
				{
					$amount=$duration*@$call_price;
					$astro_rate=$call_price;
				}
				elseif(@$request->booking_type=='V')
				{
					$amount=$duration*@$video_call_price;
					$astro_rate=$video_call_price;
				}
				elseif(@$request->booking_type=='C')
				{
					$amount=$duration*@$chat_price;
					$astro_rate=$chat_price;
				}
				elseif(@$request->booking_type=='F')
				{
					$amount=$duration*@$offline_price;
					$astro_rate=$offline_price;
				}
				$ins['from_time'] = $mintime;
				$ins['end_time'] = $endtime;
				$ins['customer_id']=auth()->user()->id;
				$ins['user_id']= $astrologerData->id;
				$ins['duration']= $duration;
				$ins['status']= 'T';
				$ins['payment_status']= 'I';
				$ins['date']= date('Y-m-d');
				$ins['currency_id'] = session()->get('currency');
				$ins['order_type'] = @$request->booking_type;
				$ins['subtotal']=$amount;
				$ins['total_rate']=$amount;
				$ins['rate']=$amount;
				$createBooking= OrderMaster::create($ins);

				$code='';
				$idlength=strlen($createBooking->id);
				if($idlength>4)
				{
					$code=$createBooking->id;
				}
				else
				{
					for($i=0;$i<(4-$idlength);$i++)
					{
						$code.='0';
					}
					$code=$code.$createBooking->id;
				}
				$upd=[];
				$upd['order_id']='O'.date('y').date('m').date('d').$code;
				OrderMaster::where('id', $createBooking->id)->update($upd);
				$call_ins=[];
				$call_ins['user_id']=auth()->user()->id;
				$call_ins['astrologer_id']=$astrologerData->id;
				$call_ins['order_id']=$createBooking->id;
				$call_ins['call_date_time']=date('Y-m-d H:i:s',strtotime($request->date.' '.$mintime));
				$call_ins['call_duration']=$duration;
				$call_ins['call_type']=$request->booking_type;
				$call_ins['book_type']='S';
				$call_ins['call_status']='B';
				CallHistory::create($call_ins);
		  }
            if($createBooking){
                // $orderDetails = CallPurchase::where('id', $createBooking->id)->first();
                $orderDetails = OrderMaster::where('id', $createBooking->id)->first();
                //session()->flash('success', 'Booking completed. Please make payment');
                return redirect()->route('astrologer.booking.user.data',['order_id'=> $orderDetails->order_id]);
            }
        return redirect()->back();
    }
	/**
     *   Method      : callBookingUserInfo
     *   Description : call booking user data
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-14
     **/
    public function callBookingUserInfo(Request $request,$order_id=null){
        //dd($request->all());
        // $orderDetails=CallPurchase::where('order_id', $order_id)->with('astrologer')->where('customer_id', auth()->user()->id)->first();
        $orderDetails= OrderMaster::where('order_id', $order_id)->with('astrologer')->where('customer_id', auth()->user()->id)->where(function($query){
			$query->where('order_type','A')->orWhere('order_type','C')->orWhere('order_type','V')->orWhere('order_type','F');
		})->first();
		$call_details= CallHistory::where('order_id', $orderDetails->id)->first();
        if($orderDetails){
            $data['orderDetails'] = $orderDetails;
            $data['call_details'] = $call_details;
			$data['customers'] = CustomerPujaNames::where('user_id',auth()->user()->id)->get();
			$data['temps'] = AstrologerPersonTemp::where('user_id',auth()->user()->id)->where('astrologer_id',$call_details->astrologer_id)->get();
			$data['rashi'] = Rashi::get();
			$data['nakshatra'] = Nakshatras::get();
			$data['gotra'] = Gotra::get();
			$data['zips'] = ZipMaster::get();
			$data['expertise'] = AstrologerToExpertise::with('experties')
                                                    ->where('user_id',$call_details->astrologer_id)
                                                    ->get();
                                                    //dd($data['expertise']);
			if(@$request->all())
			{
				//dd(@$request->all());
				$filename='';
				if($request->astro_file){
					$file = $request->astro_file;
					$filename = time() . '-' . rand(1000, 9999) .'_'. $file->getClientOriginalName();
					\Storage::putFileAs('public/astro_attachment', $file, $filename);
				}
				$update=array();
				// if($request->consultancy_type=='O')
				// {
				// 	$update['consultany_type']=$request->consultancy_type_other;
				// }
				// else
				// {
				// 	$update['consultany_type']=$request->consultancy_type;
				// }
                $update['expertise']=$request->expertise;
				$update['measurement']=$request->measurement;
				$update['astro_attachment']=$filename;
				$update['order_description']=$request->order_description;
				if(@$call_details->is_per_minute=='Y')
				{
					$update['status']='N';
				}
				else
				{
					$update['status']='I';
				}
				OrderMaster::where('id',$orderDetails->id)->update($update);
				if(@$request->previous)
				{
					$getdata = CustomerPujaNames::where('id',@$request->previous)->first();
						 OrderPujaNames::create([
						   'ordermaster_id' =>$orderDetails->id,
						   'name' => @$getdata->name,
						   'dob' =>@$getdata->dob?date('Y-m-d',strtotime(@$getdata->dob)):null,
							'janama_nkshatra' => @$getdata->janam_nakshatra,
							'janam_rashi_lagna' => @$getdata->janam_rashi_lagna,
							'gotra'=>@$getdata->gotra,
							'place_of_residence'=>@$getdata->place_of_residence,
							'relation'=>@$getdata->relation
						]);
				}
				else
				{
					if(@$request->save)
					{
						if (@$request->dob!="") {
								$check = CustomerPujaNames::where('user_id',$request->user_id_puja)->where('name',$request->name)->where('dob',date('Y-m-d',strtotime(@$request->dob)))->where('janama_nkshatra',$request->nakshatra)->where('janam_rashi_lagna',$request->rashi)->where('gotra',$request->gotra)->where('relation',$request->residence)->where('relation',$request->relation)->first();
					   }else{
						$check = CustomerPujaNames::where('user_id',$request->user_id_puja)->where('name',$request->name)->where('janama_nkshatra',$request->nakshatra)->where('janam_rashi_lagna',$request->rashi)->where('gotra',$request->gotra)->where('place_of_residence',$request->residence)->where('relation',$request->relation)->first();
					   }
						if ($check=="" && @$request->name != '' && @$request->dob !='') {
							CustomerPujaNames::create([
							   'user_id' =>auth()->user()->id,
							   'name' => @$request->name,
							   'dob' =>@$request->dob?date('Y-m-d',strtotime(@$request->dob)):null,
								'janama_nkshatra' => @$request->nakshatra,
								'janam_rashi_lagna' => @$request->rashi,
								'gotra'=>@$request->gotra,
								'place_of_residence'=>@$request->residence,
								'relation'=>@$request->relation
							]);
						}
				    }
                    if(@$request->name != '' && @$request->dob !=''){
                        OrderPujaNames::create([
                            'ordermaster_id' =>$orderDetails->id,
                            'name' => @$request->name,
                            'dob' =>@$request->dob?date('Y-m-d',strtotime(@$request->dob)):null,
                            'janama_nkshatra' => @$request->nakshatra,
                            'janam_rashi_lagna' => @$request->rashi,
                            'gotra'=>@$request->gotra,
                            'place_of_residence'=>@$request->residence,
                            'relation'=>@$request->relation
                        ]);
                    }

				}
				if(@$call_details->book_type=='I')
				{
					$new_registrationIds = User::where('id',$call_details->astrologer_id)->pluck('firebaseToken_id')->toArray();
					//dd($new_registrationIds);
					if(@$new_registrationIds)
					{
						$title = auth()->user()->first_name." is about to book an instant schedule!";
						$message = "A new instant schedule booking is about be completed.";
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
						//return $result.' New Order placed! ';
						CallHistory::where('id',$call_details->id)->update(['firebase_response'=>$result]);
					}

				}

				if(@$call_details->is_per_minute=='Y')
				{

					if(@$call_details->call_type=='C')
					{
						session()->flash('success', 'Booking successfully completed. Start chatting');
						return redirect()->route('chat.with.astrologer',['id'=>$call_details->id]);
					}
					elseif(@$call_details->call_type=='A' || @$call_details->call_type=='V')
					{
						session()->flash('success', 'Booking successfully completed.');
						return redirect()->route('customer.call');
					}
				}
				else
				{
					session()->flash('success', 'Please make payment to proceed');
					return redirect()->route('astrologer.call.booking.payment',['order_id'=> $orderDetails->order_id]);
				}

			}
            return view('modules.call_booking.call_booking_user_info')->with($data);
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('customer.dashboard');
    }
    /**
     *   Method      : callBookingPaymentView
     *   Description : call booking payment page view
     *   Author      : Soumojit
     *   Date        : 2021-MAY-19
     **/
    public function callBookingPaymentView($order_id=null){
        // $orderDetails=CallPurchase::where('order_id', $order_id)->with('astrologer')->where('customer_id', auth()->user()->id)->first();
        $orderDetails= OrderMaster::where('order_id', $order_id)->with('astrologer','orderPujaNames')->where('customer_id', auth()->user()->id)->where(function($query){
			$query->where('order_type','A')->orWhere('order_type','C')->orWhere('order_type','V')->orWhere('order_type','F');
		})->first();
		$call_details= CallHistory::where('order_id', $orderDetails->id)->first();
        if($orderDetails){
            $data['orderDetails'] = $orderDetails;
            $data['call_details'] = $call_details;
            return view('modules.call_booking.call_booking_payment')->with($data);
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('customer.dashboard');
    }
    /**
     *   Method      : callBookingPayment
     *   Description : call booking payment submit
     *   Author      : Soumojit
     *   Date        : 2021-MAY-19
     **/
    public function callBookingPayment($order_id=null){
        $orderDetails = OrderMaster::where('order_id', $order_id)->where('customer_id',auth()->user()->id)->with('astrologer')->where(function($query){
			$query->where('order_type','A')->orWhere('order_type','C')->orWhere('order_type','V')->orWhere('order_type','F');
		})->first();
        if ($orderDetails) {
            $upd=[];
            $upd['status']='N';
            $upd['payment_status']='P';
            // $update = CallPurchase::where('order_id', $order_id)->where('customer_id', auth()->user()->id)->update($upd);
            $update = OrderMaster::where('order_id', $order_id)->where('customer_id', auth()->user()->id)->update($upd);
            if(@$update){
				if(@$orderDetails->callHistory->call_type=='C' && @$orderDetails->callHistory->book_type=='I')
				{
					session()->flash('success', 'Payment successfully done. start chatting');
					return redirect()->route('chat.with.astrologer',['id'=>$orderDetails->callHistory->id]);
				}
				else
				{
					session()->flash('success', 'Payment successfully done');
					return redirect()->route('customer.call');
				}

            }
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('customer.dashboard');
    }

    /**
     *   Method      : astrologerPublicProfile
     *   Description : Astrologer profile Data search
     *   Author      : Soumojit
     *   Date        : 2021-MAY-20
     **/

    public function astrologerPublicProfile($slug)
    {
        $response = [
            "jsonrpc" => "2.0"
        ];
        $day = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
        $day = implode(',', $day);
        $data['userData'] = User::where('slug', $slug)->with(['userAvailable']) ->where('status', 'A')->where('approve_by_admin', 'Y')->first();
        if ($data['userData'] == null) {
            $response['status'] = 1;
            return response()->json($response);
        }
        if ($data['userData']->userAvailable->count()==0) {
            $response['status'] = 2;
            return response()->json($response);
        }
        $response['status'] = 1;
        $response['result'] = $data;
        return response()->json($response);
    }
	public function addTempAdd(Request $request)
    {
        // return $request->gotra;
        $ins = [];
        $ins['user_id'] = $request->user_id_puja;
        $ins['astrologer_id'] = $request->astrologer_id;
        $ins['name'] = $request->name;
        $ins['dob'] = @$request->dob?date('Y-m-d',strtotime(@$request->dob)):null;
        $ins['janam_nakshatra'] = $request->nakshatra;
        $ins['janam_rashi'] = $request->rashi;
        $ins['gotra'] = $request->gotra;
        $ins['place_of_residence'] = $request->residence;
        $ins['relation'] = $request->relation;
        $create = AstrologerPersonTemp::create($ins);

        if ($request->check=="1") {
        $ins = [];
        $ins['user_id'] = $request->user_id_puja;
        $ins['name'] = $request->name;
        $ins['dob'] = @$request->dob?date('Y-m-d',strtotime(@$request->dob)):null;
        $ins['janama_nkshatra'] = $request->nakshatra;
        $ins['janam_rashi_lagna'] = $request->rashi;
        $ins['gotra'] = $request->gotra;
        $ins['place_of_residence'] = $request->residence;
        $ins['relation'] = $request->relation;
        $create = CustomerPujaNames::create($ins);
        }else{
        if (@$request->dob!="") {
                $check = CustomerPujaNames::where('user_id',$request->user_id_puja)->where('name',$request->name)->where('dob',date('Y-m-d',strtotime(@$request->dob)))->where('janama_nkshatra',$request->nakshatra)->where('janam_rashi_lagna',$request->rashi)->where('gotra',$request->gotra)->where('relation',$request->residence)->where('relation',$request->residence)->first();
       }else{
        $check = CustomerPujaNames::where('user_id',$request->user_id_puja)->where('name',$request->name)->where('janama_nkshatra',$request->nakshatra)->where('janam_rashi_lagna',$request->rashi)->where('gotra',$request->gotra)->where('place_of_residence',$request->residence)->where('relation',$request->relation)->first();
       }

        if ($check=="") {
            $ins = [];
            $ins['user_id'] = $request->user_id_puja;
            $ins['name'] = $request->name;
            $ins['dob'] = @$request->dob?date('Y-m-d',strtotime(@$request->dob)):null;
            $ins['janama_nkshatra'] = $request->nakshatra;
            $ins['janam_rashi_lagna'] = $request->rashi;
            $ins['gotra'] = $request->gotra;
            $ins['place_of_residence'] = $request->residence;
            $ins['relation'] = $request->relation;
            $create = CustomerPujaNames::create($ins);
        }else{
           echo "No";
        }

      }

        echo "Inserted";
    }


    public function showTempAdd(Request $request)
    {
        // return "Sayan";
        $data = AstrologerPersonTemp::where('user_id',$request->user_id)->where('astrologer_id',$request->astrologer_id)->with('nakshatras')->with('rashis')->with('gotras')->get();
        return response()->json($data);
    }

    public function deleteTempAdd(Request $request)
    {
        $getdata = AstrologerPersonTemp::where('id',$request->id)->first();
        $category = AstrologerPersonTemp::where('id',$request->id)->delete();
        return $getdata->check_box_id;
    }

    public function checkBoxInsert(Request $request)
    {
        $check = $request->id;

        $prvNames = CustomerPujaNames::where('id',$check)->first();
        // return $prvNames;
        AstrologerPersonTemp::create([
                   'user_id' =>$request->user_id,
                   'astrologer_id'=>$request->astrologer_id,
                   'name' => @$prvNames->name,
                   'dob' =>@$prvNames->dob?date('Y-m-d',strtotime(@$prvNames->dob)):null,
                   'janam_nakshatra' => @$prvNames->janama_nkshatra,
                   'janam_rashi' => @$prvNames->janam_rashi_lagna,
                    'gotra'=>@$prvNames->gotra,
                    'place_of_residence'=>@$prvNames->place_of_residence,
                    'relation'=>@$prvNames->relation,
                    'check_box_id'=>@$request->id,
                 ]);

        echo "updated";

        // return $check;
    }

    public function delCheckBox(Request $request)
    {
        $delete = AstrologerPersonTemp::where('check_box_id',$request->id)->delete();
        echo $request->id;
    }


    public function deleteTempTable(Request $request)
    {
        $explode = explode(',', $request->user_id);
        $data = AstrologerPersonTemp::whereIn('user_id',$explode)->delete();
        return response()->json($data);
    }

    public function checkTemp(Request $request)
    {
        $data = AstrologerPersonTemp::where('user_id',$request->id)->count();
        if ($data==0) {
            echo "false";
        }else{
			if($data>1)
			{
				echo "more";
			}
			else
			{
				echo "true";
			}

        }
    }


    /**
     *   Method      : callOrder
     *   Description : customer call booking
     *   Author      : Soumojit
     *   Date        : 2021-MAY-19
     **/
    public function callOrder(Request $request){
        // return $request;

        $response = [
            "jsonrpc"   =>  "2.0"
        ];
        $callHistory = CallHistory::where('order_id',$request->params['order_id'])->first();
        $upd['ParentCallSid']= $request->params['sid'];
        $upd['call_status'] = 'I';
        $update['twilio_response']= $request->params['sid'];
        if ($callHistory->call_start_time==null) {
            $update['call_start_time']= date('Y-m-d H:i:s');
        }
        OrderMaster::where('id',$request->params['order_id'])->update($upd);
        CallHistory::where('order_id',$request->params['order_id'])->update($update);
        return response()->json($response);
        // if($request->params['call_day']==null){
        //     return response()->json($response);
        // }
        // // if($request->time_duration==null){
        // //     return redirect()->back();
        // // }
        // // $astrologerData=User::where('slug', $slug)->first();
        // // if($astrologerData==null){
        //     $astrologerData = User::where('id', $request->params['astrologer_id'])->first();
        // // }
        // if(@$astrologerData){
        //     $ins=[];
        //     if($request->params['call_day'] =='SUNDAY'){
        //        $nextDay= strtotime('next sunday');
        //     }
        //     if($request->params['call_day'] =='MONDAY'){
        //         $nextDay= strtotime('next monday');
        //     }
        //     if($request->params['call_day'] =='TUESDAY'){
        //         $nextDay= strtotime('next tuesday');
        //     }
        //     if($request->params['call_day'] =='WEDNESDAY'){
        //         $nextDay= strtotime('next wednesday');
        //     }
        //     if($request->params['call_day'] =='THURSDAY'){
        //         $nextDay= strtotime('next thursday');
        //     }
        //     if($request->params['call_day'] =='FRIDAY'){
        //         $nextDay= strtotime('next friday');
        //     }
        //     if($request->params['call_day'] =='SATURDAY'){
        //         $nextDay= strtotime('next saturday');
        //     }
        //     $commission = Commission::first();

        //     $ins['customer_id']=auth()->user()->id;
        //     $ins['user_id']= $astrologerData->id;
        //     $ins['ParentCallSid']= $request->params['sid'];
        //     $ins['duration']= 0;
        //     $ins['rate']= $astrologerData->call_price;
        //     $ins['total_rate']= $astrologerData->call_price * 0;
        //     $ins['status']= 'I';
        //     $ins['payment_status']= 'I';
        //     $ins['date']= date('Y-m-d H:i:s');
        //     $ins['commission'] = $astrologerData->call_price * 0*($commission->call_comm/100);
        //     $ins['currency_id'] = 1;
        //     $ins['order_type'] = 'C';
        //     $ins['call_status'] = 'I';
        //     $createBooking= OrderMaster::create($ins);
        //     $upd=[];
        //     $upd['order_id']='A00'.$createBooking->id;
        //     // CallPurchase::where('id', $createBooking->id)->update($upd);
        //     OrderMaster::where('id', $createBooking->id)->update($upd);
        //     if($createBooking){
        //         // $orderDetails = CallPurchase::where('id', $createBooking->id)->first();
        //         $orderDetails = OrderMaster::where('id', $createBooking->id)->first();
        //         session()->put("order_no_call",$orderDetails->id);
        //         $response['result']['order_id'] = $createBooking->id;
        //         return response()->json($response);
        //     }
        //     return response()->json($response);
        // }
        // return response()->json($response);
    }

    public function orderStatusCheck(Request $request) {

        $response = [
            "jsonrpc"   =>  "2.0"
        ];
        $orderDetails = OrderMaster::where('id',$request->params['order_id'])->first(); // for the order detail's of this order
            // if($orderDetails->call_status=='IP'){
            //     $response['result']['call_status'] = 'initiated';
            // }
            if($orderDetails->call_status=='R'){
                $response['result']['call_status'] = 'ringing';
            }
            if($orderDetails->call_status=='IP'){
                $response['result']['call_status'] ='start';
                CallHistory::where('order_id',$request->params['order_id'])->increment('completed_call', 1);
                $callTiming = CallHistory::where('order_id',$request->params['order_id'])->first();
                if ($callTiming->caller_one=='') {
                	CallHistory::where('order_id',$request->params['order_id'])->update(['caller_one'=>60]);
                }
                $duration = $callTiming->completed_call;
                $order_duration = $orderDetails->duration*60;
                $update = [];
                $upd =[];
                if ($duration>=$order_duration && $callTiming->is_per_minute=="N") {
                    $update['status'] = 'C';
                }
                $data = CallHistory::where('order_id',$request->params['order_id'])->first();
                $data2 = OrderMaster::where('id',$request->params['order_id'])->first();

                if ($callTiming->call_start_time=='') {
                    $upd['call_start_time'] = date('Y-m-d H:i:s');
                }
                // for is per min yes
                if (@$data->caller_one==$data->completed_call && $callTiming->is_per_minute=="Y") {
                	CallHistory::where('order_id',$request->params['order_id'])->increment('caller_one',60);
                	UserWallet::where('user_id',$callTiming->user_id)->where('currency_id',2)->decrement('wallet_balance',$data2->rate);
                	$balance = UserWallet::where('user_id',$callTiming->user_id)->first();
                	if ($data2->rate>$balance->wallet_balance) {
                        $update['status'] = 'C';
                        OrderMaster::where('id',$request->params['order_id'])->update(['status'=>'C']);
                        $response['result']['call_status'] ='finish';
                    }
                }


                CallHistory::where('order_id',$request->params['order_id'])->update($upd);
                OrderMaster::where('id',$request->params['order_id'])->update($update);
            }



        // if(session()->get("order_no_call") != null) {
        //     $orderDetails = OrderMaster::where('id' ,session()->get("order_no_call"))->first(); // for the order detail's of this order
        //     if($orderDetails->call_status=='I'){
        //         $response['result']['call_status'] = 'initiated';
        //     }
        //     if($orderDetails->call_status=='R'){
        //         $response['result']['call_status'] = 'ringing';
        //     }
        //     if($orderDetails->call_status=='IP'){
        //         $response['result']['call_status'] ='start';
        //     }
        // }
        return response()->json($response);
    }
    public function checkAstrologerAvailable(Request $request){
        $response = [
            "jsonrpc"   =>  "2.0"
        ];
        $astrologerData= User::where('id',$request->params['astrologerId'])->first();
        if($astrologerData){
            $day=date('l');
            if($day=='Sunday'){
                $call_day ='SUNDAY';
            }
            if($day=='Monday'){
                $call_day ='MONDAY';
            }
            if($day=='Tuesday'){
                $call_day ='TUESDAY';
            }
            if($day=='Wednesday'){
                $call_day ='WEDNESDAY';
            }
            if($day=='Thursday'){
                $call_day ='THURSDAY';
            }
            if($day=='Friday'){
                $call_day ='FRIDAY';
            }
            if($day=='Saturday'){
                $call_day ='SATURDAY';
            }
            $userAvailable=UserToAvailable::where('user_id',$astrologerData->id)->where('day',$call_day)->first();
            if($userAvailable){
                $from_time= date($userAvailable->from_time);
                $to_time= date($userAvailable->to_time);
                $currentTime = date('H:i:s');

                $response['result']['from_time'] =$from_time;
                $response['result']['to_time'] =$to_time;
                $response['result']['currentTime'] =$currentTime;
                if ($currentTime >= $from_time && $currentTime <= $to_time) {
                    $response['result']['available'] ='N';
                    return response()->json($response);
                }else{
                    $response['result']['available'] ='N';
                    return response()->json($response);
                }
            }else{
                $response['result']['available'] ='N';
                return response()->json($response);
            }

        }else{
            $response['result']['available'] ='N';
        }
        return response()->json($response);
    }
}
