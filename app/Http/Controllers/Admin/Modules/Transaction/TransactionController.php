<?php

namespace App\Http\Controllers\Admin\Modules\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
class TransactionController extends Controller
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
		$data['transactions'] = OrderMaster::with('customer','astrologer','pundit');
        if(@$request->from_date && @$request->to_date=="")
        {
            $data['transactions'] = $data['transactions']->where('date',[date('Y-m-d',strtotime($request->from_date))]);
        }
       

    if(@$request->from_date && @$request->to_date)
    { 
       $data['transactions'] = $data['transactions']->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
           
    }
        if (@$request->keyword) {
        	$data['transactions'] = $data['transactions']->where('order_id','LIKE','%'.request('keyword').'%');
        }
        $data['transactions'] = $data['transactions']->orderBy('id','desc')->paginate(10);
    	return view('admin.modules.transaction.manage_transaction',$data);
    }
}
