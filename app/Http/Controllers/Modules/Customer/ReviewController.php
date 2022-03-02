<?php

namespace App\Http\Controllers\Modules\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\Review;
use App\User;
use App\Models\Puja;
class ReviewController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('customer.access');
    }

    public function index($id)
    {
    	$data = [];
    	$data['data'] = OrderMaster::where('order_id',$id)->first();
        if ($data['data']) {
           return view('modules.customer.post_review',$data);
        }else{
            return redirect()->back();
        }

    }


    public function postReview(Request $request)
    {
    	$request->validate([
    		"review"	=>	"required",
    		"fair_value"		=>	"required"
    	]);

        if(@$request->type=="P"){
    	$data = [
    		"to_user_id"	=>	0,
    		"from_user_id"	=>	$request->from_user_id,
    		"ordermaster_id"=>	$request->order_id,
    		"review_message"=>	$request->review,
    		"ratting_number"=>	$request->fair_value,
            "review_type"=>'P'
    	];
       }else{
        $data = [
            "to_user_id"    =>  $request->to_user_id,
            "from_user_id"  =>  $request->from_user_id,
            "ordermaster_id"=>  $request->order_id,
            "review_message"=>  $request->review,
            "ratting_number"=>  $request->fair_value
        ];
       }

        // for create new row
    	Review::create($data);
    	// update-order-master-table
    	$upd = [];
    	$upd["is_customer_review"] = "Y";
    	OrderMaster::where("id", $request->order_id)->update($upd);
    	if(@$request->type=="P"){
            // if the request type is puja then do puja related calculation here
            $order = [];
            $ordermaster = OrderMaster::where('puja_id',$request->puja_id)->where('is_customer_review','Y')->get();
            foreach ($ordermaster as $key => $value) {
                array_push($order, $value->id);
            }
            $new['tot_review'] = Review::whereIn('ordermaster_id',$order)->count();;
            $new['avg_review'] = Review::whereIn('ordermaster_id',$order)->avg('ratting_number');
            Puja::where('id',$request->puja_id)->update($new);
        }else{

        // find user data
        $astro = User::find($request->to_user_id);

        // update astrologer data
        $new['tot_review'] = Review::where('to_user_id',$request->to_user_id)->count();;
        $new['avg_review'] = Review::where('to_user_id',$request->to_user_id)->avg('ratting_number');

        User::where('id', $astro->id)->update($new);
        }
        session()->flash("success", \Lang::get('profile.review_success'));
        $order = OrderMaster::where("id", $request->order_id)->first();

        if(@$order->order_type == 'A' || @$order->order_type == 'V' || @$order->order_type == 'C') {
            return redirect()->route('customer.call');
        }
        elseif(@$order->order_type == 'P'){
        	return redirect()->route('customer.puja.history');
        }
   }






}
