<?php

namespace App\Http\Controllers\Modules\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\OrderMaster;
use App\Models\OrderPujaNames;
class PujaOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : pujaOrderList
     *   Description : customer pujaOrderList
     *   Author      : Soumojit
     *   Date        : 2021-JUN-08
     **/
    public function pujaOrderList(Request $request){
        $pujaDetails = OrderMaster::where('order_type','P')->where('payment_status','P')->with(['pundit','pujas'])->where('customer_id',auth()->user()->id);
        if(@$request->all()){
            if(@$request->status){
                $pujaDetails=$pujaDetails->where('status',@$request->status);
            }
            if(@$request->keyword){
                $keyword=$request->keyword;
                $pujaDetails = $pujaDetails->whereHas('pundit', function ($query)use ($keyword) {
                    $query->WhereRaw("concat(first_name, ' ', last_name) like '%" . $keyword. "%' ");
                })->orWhereHas('pujas', function ($query)use ($keyword) {
                    $query->where('puja_name','like', '%'.$keyword.'%');
                })
                ->orWhere(function($query) use ($keyword){
                    $query->where('order_id', 'like', '%'.$keyword.'%');
                });
            }
            if(@$request->from_date && @$request->to_date){
                $pujaDetails = $pujaDetails->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
            }

        }

        $data['pujaDetails'] = $pujaDetails->orderBy('id','desc')->paginate(6);
        $data['request'] = $request->all();
        return view('modules.customer.puja_order')->with($data);
    }
    /**
     *   Method      : pujaOrderView
     *   Description : customer puja Order View
     *   Author      : Soumojit
     *   Date        : 2021-JUN-10
     **/
    public function pujaOrderView($slug){
        $pujaDetails = OrderMaster::with('mantraDetails')->where('order_type','P')->with(['pundit','pujas'])->where('order_id',$slug)->where('customer_id',auth()->user()->id)->first();
        if($pujaDetails){
            $data['pujaDetails'] =$pujaDetails;
             $data['pujaNames'] = OrderPujaNames::where('ordermaster_id',$pujaDetails->id)->get();
            return view('modules.customer.puja_order_view')->with($data);
        }
        return redirect()->route('customer.puja.history')->with('error',\Lang::get('profile.unauthorized_access'));
    }

}
