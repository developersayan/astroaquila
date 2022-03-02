<?php

namespace App\Http\Controllers\Modules\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
class HoroscopeOrder extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	$data = [];
    	$data['data'] = OrderMaster::where('order_type','H')->where('payment_status','P')->where('customer_id',auth()->user()->id)->orderBy('id','desc');
    	if(@$request->order_no){
                $data['data']= $data['data']->where('order_id',$request->order_no);
            }

            if(@$request->from_date && @$request->to_date){
               $data['data'] =$data['data']->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
            }
            $data['data'] = $data['data']->paginate(6);
            $data['request'] = $request->all();
    	return view('modules.horoscope_order.order_list')->with($data);
    }

    public function details($id)
    {
    	$order = OrderMaster::where('order_type','H')->where('customer_id',auth()->user()->id)->where('order_id',$id)->first();
        if(@$order==null){
            return redirect()->route('customer.order')->with('error','Something went wrong');
        }
        $data['data']=$order;
        // return $data;
        return view('modules.horoscope_order.view_order')->with($data);
    }


}
