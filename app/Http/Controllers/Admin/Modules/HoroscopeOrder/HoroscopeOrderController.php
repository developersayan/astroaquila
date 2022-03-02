<?php

namespace App\Http\Controllers\Admin\Modules\HoroscopeOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\Horoscope;
class HoroscopeOrderController extends Controller
{
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.auth:admin');
    }


    public function index(Request $request)
    {
    	$data = [];
    	$data['horoscope'] = Horoscope::where('status','A')->get();
    	$data['order'] = OrderMaster::where('order_type','H')->where('payment_status','P')->orderBy('id','desc');
    	if (@$request->order_id) {
    		$data['order'] = $data['order']->where('order_id','LIKE','%'.request('order_id').'%');
    	}
    	if(@$request->from_date && @$request->to_date){
                $data['order'] = $data['order']->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
        }
       if (@$request->keyword) {
    		$data['order'] = $data['order']->where(function($query){
    			$query->where('order_id','LIKE','%'.request('keyword').'%')
    				  ->orWhere('email','LIKE','%'.request('keyword').'%')
    				  ->orWhere('phone_no','LIKE','%'.request('keyword').'%')
    				  ->orWhere('total_rate','LIKE','%'.request('keyword').'%')
    				  ->orWhere('name','LIKE','%'.request('keyword').'%');	
    		});
    	}
       if (@$request->horoscope) {
       	   $data['order'] = $data['order']->where('horoscope_id',@$request->horoscope);
       }
       if (@$request->status) {
       	   $data['order'] = $data['order']->where('status',@$request->status);
       }
       $data['order'] = $data['order']->paginate(10);
    	return view('admin.modules.manage_horoscope_order.manage_horoscope_order',$data);
    }

    public function cancel($id)
    {
    	$cancel = OrderMaster::where('id',$id)->update(['status'=>'CA']);
    	return redirect()->back()->with('success','Horoscope Order Canceled Successfully');
    }

    public function view($id)
    {
    	$check = OrderMaster::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data =[];
    	$data['data'] = $check;
    	return view('admin.modules.manage_horoscope_order.view_horoscope_order',$data);
    }


}
