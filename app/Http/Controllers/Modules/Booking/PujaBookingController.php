<?php

namespace App\Http\Controllers\Modules\Booking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\PujaOrder;
use App\Models\PunditToPuja;
use App\Models\OrderMaster;
use App\Models\Commission;
use App\Models\Puja;
use App\Models\OrderPujaNames;
use App\Models\CustomerPujaNames;
use Mail;
use App\Mail\PujaOrderMail;
use App\Models\TempPujaPerson;
use App\Models\OrderPujaMantra;
use App\Models\MantraPrice;
use App\Models\CurrencyConversion;
use App\Models\PujaName;
class PujaBookingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('customer.access');
    }

    /**
     *   Method      : pujaBooking
     *   Description : customer booking puja
     *   Author      : Soumojit
     *   Date        : 2021-MAY-20
     **/
    public function pujaBooking(Request $request)
    {
        // return $request;
        @$get = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
        // @$customers = $request->addmore;
        // $count = count($customers);
        // return $count;
        // return count(@$customers);
        $data = Puja::where('id',$request->puja_id)->first();

        // if ($request->puja_day == null) {
        //     return redirect()->back();
        // }
        // if ($request->puja_name == null) {
        //     return redirect()->back();
        // }
        // if ($request->puja_type== null) {
        //     return redirect()->back();
        // }
        // $punditData = User::where('slug', $slug)->first();
        // if ($punditData == null) {
        //     $punditData = User::where('id', $request->pundit_id)->first();
        // }
        // if (@$punditData) {
            // $pujaData= PunditToPuja::where('puja_id', $request->puja_name)->where('user_id', $punditData->id)->first();
            // $ins = [];
            // if ($request->puja_day == 'SUNDAY') {
            //     $nextDay = strtotime('next sunday');
            // }
            // if ($request->puja_day == 'MONDAY') {
            //     $nextDay = strtotime('next monday');
            // }
            // if ($request->puja_day == 'TUESDAY') {
            //     $nextDay = strtotime('next tuesday');
            // }
            // if ($request->puja_day == 'WEDNESDAY') {
            //     $nextDay = strtotime('next wednesday');
            // }
            // if ($request->puja_day == 'THURSDAY') {
            //     $nextDay = strtotime('next thursday');
            // }
            // if ($request->puja_day == 'FRIDAY') {
            //     $nextDay = strtotime('next friday');
            // }
            // if ($request->puja_day == 'SATURDAY') {
            //     $nextDay = strtotime('next saturday');
            // }
            // $commission = Commission::first();
            $ins['customer_id'] = auth()->user()->id;
            $ins['puja_id'] = $request->puja_id;
            $ins['puja_type'] = $request->manner_of_puja;
            if(@session()->get('currency')==1){
                $ins['total_rate'] = $request->puja_price;
            }else{
                $ins['total_rate'] = $request->puja_price;
            }

            $ins['is_homam'] = $request->homam_status;
            if(@session()->get('currency')==1){
                $ins['homam_price'] = $data->homam_price_inr;
            }else{
                $ins['homam_price'] = round($get->conversion_factor * $data->homam_price_usd,2);
            }

            // cd
            $ins['is_cd'] = $request->cd_status;
            if(@session()->get('currency')==1){
                $ins['cd_price'] = $data->cd_price_inr;
            }else{
                $ins['cd_price'] = round($get->conversion_factor * $data->cd_price_usd,2);
            }

            $ins['is_live_streaming'] = $request->live_streaming_status; 
            if(@session()->get('currency')==1){
                $ins['live_streaming_price'] = $data->liver_streaming_inr;
            }else{
                $ins['live_streaming_price'] = round($get->conversion_factor * $data->liver_streaming_usd,2);
            }


            $ins['is_prasad'] = $request->prasad_status;
            $ins['delivery_of_prasad'] = $request->delivery_of_prasad;
            if(@session()->get('currency')==1){
                $ins['prasad_price'] = $data->prasad_inr;
            }else{
                $ins['prasad_price'] = round($get->conversion_factor * $data->prasad_usd,2);
            }

            $ins['dakshina'] = $request->priest_dakshina;

            
            $ins['subtotal'] = $request->puja_sub_total;
            
               
            





            // $ins['total_rate'] = $data->;
            $ins['status'] = 'I';
            $ins['payment_status'] = 'I';
            $ins['date'] =  date('Y-m-d',strtotime($request->puja_date));
            // $ins['commission'] = $pujaData->price * ($commission->puja_comm / 100);
            if(@session()->get('currency')==1){
                $ins['currency_id'] = '1';
            }else{
                $ins['currency_id'] = @session()->get('currency');
            }

            $ins['puja_zip'] = @$request->zipcode;
            $ins['p_google_address'] = @$request->offline_puja_location;

            $ins['puja_landmark'] = @$request->landmark_name;
            $ins['puja_house_no'] = @$request->house_name;
            $ins['order_type'] = 'P';
            // $createBooking = PujaOrder::create($ins);
            $createBooking = OrderMaster::create($ins);
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
			$upd['order_id']='P'.date('y').date('m').date('d').$code;
			OrderMaster::where('id', $createBooking->id)->update($upd);
            $ids = explode(',', auth()->user()->id);
            $getdata = TempPujaPerson::where('user_id',$ids)->get();
            // return $getdata;
             foreach(@$getdata as $key => $value) {
                 OrderPujaNames::create([
                   'ordermaster_id' =>$createBooking->id,
                   'name' => @$value->name,
                   'dob' =>@$value->dob?date('Y-m-d',strtotime(@$value->dob)):null,
                    'janama_nkshatra' => @$value->janam_nakshatra,
                    'janam_rashi_lagna' => @$value->janam_rashi,
                    'gotra'=>@$value->gotra,
                    'place_of_residence'=>@$value->place_of_residence,
                ]);
              }
            TempPujaPerson::where('user_id',$ids)->delete();


            $orderDetails =  OrderMaster::where('id', $createBooking->id)->first();


            // update-mantra-table
            $mantra = OrderPujaMantra::where('user_id',auth()->user()->id)->where('puja_id',$request->puja_id)->where('order_master_id',0)->get();
            if (count($mantra)>0) {
                $arrayId = [];
                foreach ($mantra as $key => $value) {
                    array_push($arrayId, $value->id);
                }
                $update = OrderPujaMantra::whereIn('id',$arrayId)->update(['order_master_id'=>$createBooking->id]);
            }





            // // if ($createBooking) {
            // //     // $orderDetails = PujaOrder::where('id', $createBooking->id)->first();
            // //     $orderDetails = OrderMaster::where('id', $createBooking->id)->first();
            // // }

            // // if checkboxes have value
            // $previous = count($request->previous);
            // // return $previous;
            // if ($previous>0) {
            //     $prvNames = CustomerPujaNames::whereIn('id',$request->previous)->get();
            //     foreach ($prvNames as $key => $value) {
            //         OrderPujaNames::create([
            //        'ordermaster_id' =>$createBooking->id,
            //        'name' => @$value->name,
            //         'dob' => date('Y-m-d',strtotime(@$value->dob)),
            //         'janama_nkshatra' => @$value->janama_nkshatra,
            //         'janam_rashi_lagna' => @$value->janam_rashi_lagna,
            //         'gotra'=>@$value->gotra,
            //         'place_of_residence'=>@$value->place_of_residence,
            //      ]);
            //     }
            // }
            // // save details  order_puja_user_names table

            //     foreach(@$customers as $key => $value) {
            //      OrderPujaNames::create([
            //        'ordermaster_id' =>$createBooking->id,
            //        'name' => @$value['name'],
            //         'dob' => date('Y-m-d',strtotime($value['dob'])),
            //         'janama_nkshatra' => @$value['nakshatra'],
            //         'janam_rashi_lagna' => @$value['rashi'],
            //         'gotra'=>$value['gotra'],
            //         'place_of_residence'=>@$value['residence'],
            //     ]);
            //   }

            //    foreach(@$customers as $key => $value) {
            //     $check = CustomerPujaNames::where('user_id',auth()->user()->id)->where('name',@$value['name'])->where('dob',date('Y-m-d',strtotime($value['dob'])))->where('janama_nkshatra',@$value['nakshatra'])->where('janam_rashi_lagna',@$value['rashi'])->where('gotra',$value['gotra'])->where('place_of_residence',@$value['residence'])->first();
            //     if (@$check==null) {

            //      CustomerPujaNames::create([
            //        'user_id' =>auth()->user()->id,
            //        'name' => @$value['name'],
            //         'dob' => date('Y-m-d',strtotime($value['dob'])),
            //         'janama_nkshatra' => @$value['nakshatra'],
            //         'janam_rashi_lagna' => @$value['rashi'],
            //         'gotra'=>$value['gotra'],
            //         'place_of_residence'=>@$value['residence'],
            //     ]);
            //  }else{
            //     continue;
            //  }
            //   }

              return redirect()->route('puja.booking.payment.view',['order_id'=>$orderDetails->order_id]);

    }
    /**
     *   Method      : pujaBookingPaymentView
     *   Description : pundit puja booking payment page view
     *   Author      : Soumojit
     *   Date        : 2021-MAY-20
     **/
    public function pujaBookingPaymentView($order_id = null)
    {
        // $orderDetails = PujaOrder::where('order_id', $order_id)->with('pundit', 'pujas')->where('customer_id', auth()->user()->id)->first();
        $orderDetails = OrderMaster::with('mantraDetails')->where('order_id', $order_id)->with('pundit', 'pujas')->where('customer_id', auth()->user()->id)->where('order_type', 'P')->first();
        if ($orderDetails) {
            $data['orderDetails'] = $orderDetails;
            return view('modules.puja_booking.puja_booking')->with($data);
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('customer.dashboard');
    }
    /**
     *   Method      : pujaBookingPayment
     *   Description : pundit puja booking payment submit
     *   Author      : Soumojit
     *   Date        : 2021-MAY-20
     **/
    public function pujaBookingPayment($order_id = null)
    {
        // $orderDetails = PujaOrder::where('order_id', $order_id)->where('customer_id', auth()->user()->id)->with('pundit')->first();
        $orderDetails = OrderMaster::where('order_id', $order_id)->where('customer_id', auth()->user()->id)->with('pundit')->where('order_type', 'P')->first();
        $user = User::where('id',$orderDetails->customer_id)->first();
        $puja= Puja::where('id',$orderDetails->puja_id)->first();
        if (@$puja->puja_id!="") {
            $get_puja_name = PujaName::where('id',@$puja->puja_id)->first();
            $puja_name_actual = $get_puja_name->name;
        }else{
            $puja_name_actual = 'null';
        }
        
        $names = OrderPujaNames::where('ordermaster_id',$orderDetails->id)->get();
        if ($orderDetails) {
            $upd = [];
            $upd['status'] = 'N';
            $upd['payment_status'] = 'P';
            if($orderDetails->currency_id==1){
                if (@$puja->delivery_days_india!="") {
                    $Date = date('Y-m-d');
                    $days = $puja->delivery_days_india+1;
                    $upd['delivery_prasad'] = date('Y-m-d', strtotime($Date. ' + '.$days.' days'));
                }else{
                    $upd['delivery_prasad'] = null;
                }
            }else{
                if (@$puja->delivery_days_outside_india!="") {
                    $Date = date('Y-m-d');
                    $days = @$puja->delivery_days_outside_india+1;
                    $upd['delivery_prasad'] = date('Y-m-d', strtotime($Date. ' + '.$days.' days'));
                }else{
                    $upd['delivery_prasad'] = null;
                }
            
            }

            
            // $update = PujaOrder::where('order_id', $order_id)->where('customer_id', auth()->user()->id)->update($upd);
            $update = OrderMaster::where('order_id', $order_id)->where('customer_id', auth()->user()->id)->update($upd);
            $neworderDetails = OrderMaster::with('mantraDetails')->where('order_id', $order_id)->where('customer_id', auth()->user()->id)->with('pundit')->where('order_type', 'P')->first();
            if (@$update) {
                $data = [
                'name'=>$user->first_name,
                'puja_name_actual'=>@$puja_name_actual,
                'last_name'=>$user->last_name,
                'email'=>$user->email,
                'date'=>date('d/m/Y',strtotime($orderDetails->date)),
                'order_total'=>$orderDetails->total_rate,
                'order_id'=>$orderDetails->order_id,
                'puja_name'=>$puja->puja_name,
                'puja_code'=>$puja->puja_code,
                'puja_details'=>$puja->puja_description,
                'puja_address'=>$orderDetails->p_google_address,
                'landmark'=>$orderDetails->puja_landmark,
                'house_no'=>$orderDetails->puja_house_no,
                'zip_code'=>$orderDetails->puja_zip,
                'customers'=>$names,
                'order_id'=>$order_id,
                'currency'=> $orderDetails->currency_id,
                'payment_status'=>$neworderDetails->payment_status,
                'puja_type'=>$orderDetails->puja_type,
				'mantraDetails'=>@$neworderDetails->mantraDetails,
				'is_homam'=>@$neworderDetails->is_homam,
				'homam_price'=>@$neworderDetails->homam_price,
                'is_cd'=>@$neworderDetails->is_cd,
                'cd_price'=>@$neworderDetails->cd_price,
                'is_live_streaming'=>@$neworderDetails->is_live_streaming,
                'live_streaming_price'=>@$neworderDetails->live_streaming_price,
                'is_prasad'=>@$neworderDetails->is_prasad,
                'prasad_price'=>@$neworderDetails->prasad_price,
                'dakshina'=>@$neworderDetails->dakshina,
                'subtotal'=>@$neworderDetails->subtotal,
                'neworderDetails'=>@$neworderDetails,
                ];
                Mail::send(new PujaOrderMail($data));
                session()->flash('success', 'Payment successfully done');
                return redirect()->route('pundit.puja.booking.payment', ['order_id' => $orderDetails->order_id]);
            }
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->route('customer.dashboard');
    }

    public function checkOnlinePuja(Request $request){
        $response = [
            "jsonrpc"   =>  "2.0"
        ];
        $userData = User::where('id',$request->params['panditId'])->first();

        $lat = $request->params['lat'];
        $lng = $request->params['lng'];

        $latitudeTo 	= $userData->offline_lat;
        $longitudeTo 	= $userData->offline_long;

        $nearByDistance = $this->haversineGreatCircleDistance($lat, $lng, $latitudeTo, $longitudeTo);
        $distance = $this->fnToGetCalculatedDistamce($nearByDistance);
        $response['result']['1'] =$nearByDistance;
        $response['result']['2'] =$distance;


        if($distance > $userData->offline_puja_radius){
            $response['result']['error'] = 'Service available for '. $userData->offline_puja_radius.' km only';
        }else{
            $response['result']['success'] = 'Service available';
        }
        // $response['result']['3'] =$lat;
        // $response['result']['4'] =$lng;
        // $response['result']['5'] =$latitudeTo;
        // $response['result']['6'] =$longitudeTo;
        // $response['result']['7'] =$userData;
        return response()->json($response);
    }

    /*
    *Method : haversineGreatCircleDistance
    *Description : for nearby location by latitude and longitude
    *Author : Soumojit
    */
    private function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371) {
		// convert from degrees to radians
		$latFrom = deg2rad($latitudeFrom);
		$lonFrom = deg2rad($longitudeFrom);
		$latTo = deg2rad($latitudeTo);
		$lonTo = deg2rad($longitudeTo);
		$latDelta = $latTo - $latFrom;
		$lonDelta = $lonTo - $lonFrom;
		// dd($latitudeFrom,$longitudeFrom,$latitudeTo,$longitudeTo, $latFrom, $lonFrom, $latTo, $lonTo, $latDelta, $lonDelta);
		$angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
			cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
		// dd($angle * $earthRadius);
		return $angle * $earthRadius;
	}

    /*
    *Method : fnToGetCalculatedDistamce
    *Description : for calculate distance in km or m
    *Author : Soumojit
    */
	private function fnToGetCalculatedDistamce($distanceInKm) {
		// dd($distanceInKm);
		$distanceInMeter = $distanceInKm * 1000;
		if ($distanceInMeter <= 1000) {
			$distanceInMeter = floor(100 + ($distanceInMeter - $distanceInMeter % 100));
			$distanceInMeter = 'Within ' . $distanceInMeter . 'm';
		} else {
			$distanceInMeter = floor((1000 + ($distanceInMeter - $distanceInMeter % 1000)) / 1000);
			// $distanceInMeter = 'Within ' . $distanceInMeter . 'km';
		}
		return $distanceInMeter;
	}


    public function addTempAdd(Request $request)
    {
        // return $request->gotra;
        $ins = [];
        $ins['user_id'] = $request->user_id_puja;
        $ins['puja_id'] = $request->puja_name_id;
        $ins['name'] = $request->name;
        $ins['dob'] = @$request->dob?date('Y-m-d',strtotime(@$request->dob)):null;
        $ins['janam_nakshatra'] = $request->nakshatra;
        $ins['janam_rashi'] = $request->rashi;
        $ins['gotra'] = $request->gotra;
        $ins['place_of_residence'] = $request->residence;
        $create = TempPujaPerson::create($ins);

        if ($request->check=="1") {
        $ins = [];
        $ins['user_id'] = $request->user_id_puja;
        $ins['name'] = $request->name;
        $ins['dob'] = @$request->dob?date('Y-m-d',strtotime(@$request->dob)):null;
        $ins['janama_nkshatra'] = $request->nakshatra;
        $ins['janam_rashi_lagna'] = $request->rashi;
        $ins['gotra'] = $request->gotra;
        $ins['place_of_residence'] = $request->residence;
        $create = CustomerPujaNames::create($ins);
        }else{
        if (@$request->dob!="") {
                $check = CustomerPujaNames::where('user_id',$request->user_id_puja)->where('name',$request->name)->where('dob',date('Y-m-d',strtotime(@$request->dob)))->where('janama_nkshatra',$request->nakshatra)->where('janam_rashi_lagna',$request->rashi)->where('gotra',$request->gotra)->where('place_of_residence',$request->residence)->first();
       }else{
        $check = CustomerPujaNames::where('user_id',$request->user_id_puja)->where('name',$request->name)->where('janama_nkshatra',$request->nakshatra)->where('janam_rashi_lagna',$request->rashi)->where('gotra',$request->gotra)->where('place_of_residence',$request->residence)->first();
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
        $data = TempPujaPerson::where('user_id',$request->user_id)->where('puja_id',$request->puja_id)->with('nakshatras')->with('rashis')->with('gotras')->get();
        return response()->json($data);
    }

    public function deleteTempAdd(Request $request)
    {
        $getdata = TempPujaPerson::where('id',$request->id)->first();
        $category = TempPujaPerson::where('id',$request->id)->delete();
        return $getdata->check_box_id;
    }

    public function checkBoxInsert(Request $request)
    {
        $check = $request->id;

        $prvNames = CustomerPujaNames::where('id',$check)->first();
        // return $prvNames;
        TempPujaPerson::create([
                   'user_id' =>$request->user_id,
                   'puja_id'=>$request->puja_id,
                   'name' => @$prvNames->name,
                   'dob' =>@$prvNames->dob?date('Y-m-d',strtotime(@$prvNames->dob)):null,
                   'janam_nakshatra' => @$prvNames->janama_nkshatra,
                   'janam_rashi' => @$prvNames->janam_rashi_lagna,
                    'gotra'=>@$prvNames->gotra,
                    'place_of_residence'=>@$prvNames->place_of_residence,
                    'check_box_id'=>@$request->id,
                 ]);

        echo "updated";

        // return $check;
    }

    public function delCheckBox(Request $request)
    {
        $delete = TempPujaPerson::where('check_box_id',$request->id)->delete();
        echo $request->id;
    }


    public function deleteTempTable(Request $request)
    {
        $explode = explode(',', $request->user_id);
        $data = TempPujaPerson::whereIn('user_id',$explode)->delete();
        $del = OrderPujaMantra::whereIn('user_id',$explode)->where('order_master_id',0)->delete();
        return response()->json($data);
    }

    public function checkTemp(Request $request)
    {
        $data = TempPujaPerson::where('user_id',$request->id)->first();
        if ($data==null) {
            echo "false";
        }else{
            echo "true";
        }
    }


    public function getRecitals(Request $request)
    {
        $data = MantraPrice::where('mantra_master_id',$request->mantra)->get();
        $response=array();
        $result="<option value=''>Select No Of Recitals</option>";
        $symbol = @session()->get('currencySym');
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
             if(@session()->get('currency')==1){
             $result.="<option value='".$rows->price_in_inr.'-'.$rows->no_of_recitals."'  >".$rows->no_of_recitals.'('.$rows->price_in_inr.' ' .$symbol. ")</option>";
             }else{
               @$get = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
               $price =  round($rows->price_in_usd * @$get->conversion_factor,2);  
               $result.="<option value='".$price.'-'.$rows->no_of_recitals."'  >".$rows->no_of_recitals.'('.$price.' ' .$symbol. ")</option>";
             }


            }
        }
        $response['recitals']=$result;
        return response()->json($response);
    }

    public function addMantra(Request $request)
    {
        $response = [];
        $explode = explode('-', $request->recitals);
        $check = OrderPujaMantra::where('order_master_id',0)->where('user_id',auth()->user()->id)->where('puja_id',$request->puja)->where('mantra_id',$request->mantra)->where('no_of_recital',$explode[1])->first();
        if (@$check!="") {
           $response['message'] = "duplicate";
        }else{
        $ins = [];
        $ins['order_master_id'] = 0;
        $ins['puja_id'] = $request->puja;
        $ins['user_id'] = auth()->user()->id;
        $ins['mantra_id'] = $request->mantra;
        $ins['no_of_recital'] = $explode[1];
        $ins['price'] = $explode[0];
        $save = OrderPujaMantra::create($ins);
        $price =  OrderPujaMantra::where('id',$save->id)->first();
        $response['message'] = "inserted";
        $response['price'] = $price->price;
        }
        return response()->json($response);


    }


    public function mantraList(Request $request)
    {
        // return $request;
        $data = OrderPujaMantra::where('user_id',$request->user_id)->where('puja_id',$request->puja_id)->with('mantra')->where('order_master_id',0)->get();
        return $data;
        return response()->json($data);
    }


    public function delMantraList(Request $request)
    {
        $price =  OrderPujaMantra::where('id',$request->id)->first();
        $delete = OrderPujaMantra::where('id',$request->id)->delete();
        echo $price->price;
    }
}
