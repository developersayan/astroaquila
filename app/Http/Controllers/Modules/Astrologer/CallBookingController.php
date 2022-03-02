<?php

namespace App\Http\Controllers\Modules\Astrologer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\CallHistory;
use App\Models\Rejection;
class CallBookingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except('verifyEmail');
        $this->middleware('astrologer.access')->except('verifyEmail');
    }


    public function callhistory(Request $request)
    {
        $data=[];
        $orders = ['A','V','C','F'];
        $data['call_hisory'] = OrderMaster::where('user_id',auth()->user()->id)->where('payment_status','p')->whereIn('order_type',$orders);
        if (@$request->keyword) {
           $data['call_hisory'] = $data['call_hisory']->where(function($query){
             $query->where('order_id','LIKE','%'.request('keyword').'%')
                   ->orWhereHas('customer',function($q){
                    $q->WhereRaw(
                            "concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' "
                            );
                   });
           });
        }
        if(@$request->from_date && @$request->to_date)
        {
            $data['call_hisory'] = $data['call_hisory']->whereHas('callHistory',function($query){
                   $date = date('Y-m-d',strtotime(request('to_date')));
                   $nextday = date('Y-m-d', strtotime("+1 day", strtotime($date)));
                   $query ->whereBetween('call_date_time',[date('Y-m-d',strtotime(request('from_date'))),$nextday]);
               });
        }


    // if(@$request->from_date && @$request->to_date)
    // {
    //    $data['call_hisory'] = $data['call_hisory']->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);

    // }
    if (@$request->status) {
        $data['call_hisory'] = $data['call_hisory']->where('status',request('status'));
    }

    if (@$request->order_type) {
        $data['call_hisory'] = $data['call_hisory']->where('order_type',request('order_type'));
    }

    if (@$request->type) {
        $data['call_hisory'] = $data['call_hisory']->whereHas('callHistory',function($query){
            $query->where('book_type',request('type'));
        });
    }
    $data['call_hisory'] =  $data['call_hisory']->orderBy('id','desc')->paginate(6);
    $data['rejection'] = Rejection::get();
    return view('modules.astrologer.call_history',$data);
    }


    public function callhistory_del($id)
    {
        $check = OrderMaster::where('id',$id)->where('user_id',auth()->user()->id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        $del = OrderMaster::where('id',$id)->where('user_id',auth()->user()->id)->delete();

        return redirect()->back()->with('success',\Lang::get('profile.delete_call_history'));
    }
    /**
     *   Method      : callBookingView
     *   Description : customer call detailsView
     *   Author      : Soumojit
     *   Date        : 2021-JUN-10
     **/
    public function callBookingView($slug){
        $data = [];
        $data['callDetails'] = OrderMaster::with([
            'customer',
            'orderPujaNames.gotras',
            'orderPujaNames.rashis',
            'orderPujaNames.nakshatras'
        ])->where('order_id',$slug)
        ->where('user_id',auth()->user()->id)
        ->first();
        if($data['callDetails']){
            $callHistory = CallHistory::where('order_id',$data['callDetails']->id)->first();
            if ($data['callDetails']->order_type=="V" && $data['callDetails']->status=="C" && $data['callDetails']->is_per_minute=="N") {
                CallHistory::where('order_id',$callDetails->id)->update(['completed_call'=>$callDetails->duration*60]);
            }
            $data['rejection'] = Rejection::get();
            return view('modules.astrologer.call_history_view')->with($data);
        }
        return redirect()->route('astrologer.call.booking')->with('error',\Lang::get('profile.unauthorized_access'));
    }


    public function cancelOtp(Request $request)
    {
        $upd = [];
        if (@$request->type=="other_reason_select") {
           $upd['reason'] = $request->reason;
        }else{
            $upd['reason'] = $request->type;
        }
        $upd['cancel_otp'] = mt_rand(100000, 999999);
        OrderMaster::where('id',$request->order_id)->update($upd);
        $data = [];
        $data['data'] =  OrderMaster::where('id',$request->order_id)->first();
        return view('auth.cancel_otp',$data);
    }


    






}
