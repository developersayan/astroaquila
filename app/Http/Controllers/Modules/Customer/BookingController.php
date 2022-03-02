<?php

namespace App\Http\Controllers\Modules\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderMaster;
use App\Models\CallHistory;
class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : callBookingList
     *   Description : customer callBookingList
     *   Author      : Soumojit
     *   Date        : 2021-MAY-07
     **/
    public function callBookingList(Request $request){
        $orders = ['A','V','C','F'];
        $orderDetails=OrderMaster::whereIn('order_type',$orders)->with('astrologer')->where('payment_status','p')->where('customer_id',auth()->user()->id);
        // return date('Y-m-d',strtotime($request->to_date));
        // return $request->all();
        if(@$request->all()){
            if(@$request->status){
                $orderDetails=$orderDetails->where('status',@$request->status);
            }

            if(@$request->order_type){
                $orderDetails=$orderDetails->where('order_type',@$request->order_type);
            }


            if (@$request->type) {
                $data['call_hisory'] = $orderDetails->whereHas('callHistory',function($query){
                    $query->where('book_type',request('type'));
                });
            }
            if(@$request->keyword){
                $keyword=$request->keyword;
                $orderDetails=$orderDetails->
                whereHas('astrologer', function ($query)use ($keyword) {
                    $query->WhereRaw("concat(first_name, ' ', last_name) like '%" . $keyword. "%' ");
                })->orWhere(function($query) use ($keyword){
                    $query->where('order_id', 'like', '%'.$keyword.'%');
                });
            }
            if(@$request->from_date && @$request->to_date){
                $orderDetails=$orderDetails->whereHas('callHistory',function($query){
                   $date = date('Y-m-d',strtotime(request('to_date')));
                   $nextday = date('Y-m-d', strtotime("+1 day", strtotime($date)));
                   $query ->whereBetween('call_date_time',[date('Y-m-d',strtotime(request('from_date'))),$nextday]);
               });
            }

        }

        $data['orderDetails'] = $orderDetails->orderBy('id','desc')->paginate(6);
        $data['request'] = $request->all();
        return view('modules.customer.my_call')->with($data);
    }
    /**
     *   Method      : callBookingView
     *   Description : customer call detailsView
     *   Author      : Soumojit
     *   Date        : 2021-JUN-10
     **/
    public function callBookingView($slug){
        $callDetails = OrderMaster::with([
                                        'astrologer',
                                        'orderPujaNames.gotras',
                                        'orderPujaNames.rashis',
                                        'orderPujaNames.nakshatras'
                                    ])
                                    ->where('order_id',$slug)
                                    ->where('customer_id',auth()->user()->id)
                                    ->first();
        //dd($callDetails);

        if($callDetails){
            $callHistory = CallHistory::where('order_id',$callDetails->id)->first();
            if (@$callDetails->order_type=="V" && @$callDetails->status=="C" && $callHistory->is_per_minute=="N") {
                CallHistory::where('order_id',$callDetails->id)->update(['completed_call'=>$callDetails->duration*60]);
            }
            $data['callDetails'] =$callDetails;
            return view('modules.customer.my_call_view')->with($data);
        }
        return redirect()->route('customer.call')->with('error',\Lang::get('profile.unauthorized_access'));
    }

    public function complete($id)
    {
        OrderMaster::where('order_id',$id)->update(['status'=>'C']);
        return redirect()->back()->with('success','Order Marked As Completed Successfully');
    }


    public function cancel($id)
    {
        $upd = [];
        $upd['cancel_otp'] = mt_rand(100000, 999999);
        OrderMaster::where('id',$id)->update($upd);
        $data = [];
        $data['data'] = OrderMaster::where('id',$id)->first();
        return view('auth.cancel_otp',$data);
    }

    public function checkOtp(Request $request)
    {
       $otp = @$request->codeBox1 . @$request->codeBox2 . @$request->codeBox3 . @$request->codeBox4 . @$request->codeBox5 . @$request->codeBox6;
        // dd($otp);
        $userData = OrderMaster::where('id',$request->id)->first();
        if (@$userData) {
           if (@$userData->cancel_otp == $otp) {
                return response('true');
            } else{
                return response('false');
            }
        }
        return response('false'); 
    }

    public function cancelOrder(Request $request)
    {
        $upd = [];
        $upd['cancel_otp'] = null;
        $upd['status'] = 'CA';
        OrderMaster::where('id',$request->id)->update($upd);
        $detail = OrderMaster::where('id',$request->id)->first();
        if (auth()->user()->id==$detail->customer_id) {
            return redirect()->route('customer.call')->with('success','Order Canceled Successfully');
        }else{
            return redirect()->route('astrologer.call.history')->with('success','Order Canceled Successfully');
        }
        
    }

}
