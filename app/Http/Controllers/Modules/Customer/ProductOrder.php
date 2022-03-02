<?php

namespace App\Http\Controllers\Modules\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDetails;
use App\Models\Products;
use App\Models\Review;
use Mail;
use App\Mail\CancelProductOrderMail;

class ProductOrder extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : index
     *   Description : view all order Product
     *   Author      : Soumojit
     *   Date        : 2021-AUG-18
     **/

    public function index(Request $request){

        $allOrder = OrderMaster::where('order_type','PO')->where('customer_id',auth()->user()->id);
        if($request->all()){
            if(@$request->order_no){
                $allOrder = $allOrder->where('order_id',$request->order_no);
            }

            if(@$request->from_date && @$request->to_date){
                $allOrder = $allOrder->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
            }
        }
        $data['allOrder']=$allOrder->orderBy('id','desc')->paginate(10);
        $data['request'] = $request->all();
        return view('modules.product_order.order_list')->with($data);
    }

    /**
     *   Method      : viewDetails
     *   Description : view product order details
     *   Author      : Soumojit
     *   Date        : 2021-AUG-18
     **/
    public function viewDetails($slug=null){
        $order = OrderMaster::where('order_type','PO')->with(['orderDetails','country','state','billingCountry','billingState'])->where('customer_id',auth()->user()->id)->where('order_id',$slug)->first();
        if(@$order==null){
            return redirect()->route('customer.order')->with('error','Something went wrong');
        }
        $data['data']=$order;
        // return $data;
        return view('modules.product_order.view_order')->with($data);
    }
    /**
     *   Method      : viewReview
     *   Description : view Review Page
     *   Author      : Soumojit
     *   Date        : 2021-AUG-20
     **/
    public function viewReview($slug=null){
        $order = OrderMaster::where('order_type','PO')->with(['orderDetails','country','state','billingCountry','billingState'])->where('customer_id',auth()->user()->id)->where('order_id',$slug)->first();
        if(@$order==null){
            return redirect()->route('customer.order')->with('error','Something went wrong');
        }
        if(@$order->status!='D'){
            return redirect()->route('customer.order')->with('error','Something went wrong');
        }
        if($order->is_customer_review=='Y'){
            session()->flash('error', 'Review already given');
            return redirect()->route('customer.order');
        }
        $data['data']=$order;
        return view('modules.product_order.product_review')->with($data);
    }
    /**
     *   Method      : postReview
     *   Description : post Review
     *   Author      : Soumojit
     *   Date        : 2021-AUG-20
     **/
    public function postReview(Request $request){
        $order = OrderMaster::where('order_type','PO')->where('customer_id',auth()->user()->id)->where('id',$request->order_id)->first();
        if(@$order==null){
            return redirect()->route('customer.order')->with('error','Something went wrong');
        }
        if($order->is_customer_review=='Y'){
            session()->flash('error', 'Review already given');
            return redirect()->route('customer.order');
        }
        if(count($request->multi)>0){
            foreach($request->multi as $item){
                $ins=[];
                $ins['ordermaster_id']=@$request->order_id;
                $ins['from_user_id']=auth()->user()->id;
                $ins['ratting_number']=$item['rating'];
                $ins['review_message']=$item['review'];
                $ins['product_id']=$item['product_id'];
                $ins['review_type']='AP';
                Review::create($ins);
                $check =  Review::where('product_id',$item['product_id'])->get();
                $update=[];
                $update['tot_review']=$check->count();
                $update['avg_review']=$check->avg('ratting_number');
                Products::where('id',$item['product_id'])->update($update);
            }
            $upd = [];
            $upd["is_customer_review"] = "Y";
            $update=OrderMaster::where("id", $request->order_id)->update($upd);
            if($update){
                session()->flash('success', 'Review given successfully');
                return redirect()->route('customer.order');
            }
            session()->flash('error', \Lang::get('profile.something_went_wrong'));
            return redirect()->back();
        }
        session()->flash('error', \Lang::get('profile.something_went_wrong'));
        return redirect()->back();
    }
    /**
     *   Method      : orderCancel
     *   Description : orderCancel
     *   Author      : Soumojit
     *   Date        : 2021-SEP-07
     **/
    public function orderCancel($slug=null)
    {
        $order = OrderMaster::where('order_type','PO')->where('order_id',$slug)->first();
        if(@$order==null){
            return redirect()->back()->with('error','Something went wrong');
        }
        if( date('Y-m-d H:i:s') > date('Y-m-d H:i:s',strtotime($order->date."+48 hours"))){
            return redirect()->route('customer.order')->with('error','48 hours over order cancellation not possible');
        }
        if($order->status=='OD'){
            return redirect()->route('customer.order')->with('error','Order out for delivery cancellation not possible');
        }
           $upd = [];
           $upd['cancel_otp'] = mt_rand(100000, 999999);
           OrderMaster::where('order_id',$slug)->update($upd);
            $data = [];
            $data['data'] = OrderMaster::where('order_type','PO')->where('order_id',$slug)->first();
            return view('auth.cancel_otp',$data);

    }


    public function cancel(Request $request)
    {
        $upd = [];
        $upd['cancel_otp'] = null;
        $upd['status'] = 'CA';
        OrderMaster::where('id',$request->id)->update($upd);
        $order = OrderMaster::where('id', $request->id)->with(['orderDetails','country','state','billingCountry','billingState','currencyDetails'])->first();
        $data['data']=$order;
        Mail::send(new CancelProductOrderMail($data));
        session()->flash('success', 'Order Cancel successful');
        return redirect()->route('customer.order');

    }














}
