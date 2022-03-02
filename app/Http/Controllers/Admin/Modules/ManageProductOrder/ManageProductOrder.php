<?php

namespace App\Http\Controllers\Admin\Modules\ManageProductOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\OrderMaster;
use Mail;
use App\Mail\ProductOrderEmail;
use App\Mail\ProductOrderShippingEmail;
class ManageProductOrder extends Controller
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
     /**
     *   Method      : index
     *   Description : manage Product order
     *   Author      : Soumojit
     *   Date        : 2021-AUG-18
     **/
    public function index(Request $request){

        $allOrder = OrderMaster::where('order_type','PO');
        if($request->all()){
            if(@$request->order_no){
                $allOrder = $allOrder->where('order_id',$request->order_no);
            }

            if(@$request->from_date && @$request->to_date){
                $allOrder = $allOrder->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
            }
            if(@$request->status){
                $allOrder = $allOrder->where('status',$request->status);
            }
            // if(@$request->keyword){
            //     $allOrder = $allOrder->where('status',$request->status);
            // }
            if (@$request->keyword) {
                $allOrder = $allOrder
                // ->where(function($query){
                //     $query->where('order_id','LIKE','%'.request('keyword').'%')
                //           ->orWhere('p_google_address','LIKE','%'.request('keyword').'%')
                //           ->orWhere('puja_zip','LIKE','%'.request('keyword').'%')
                //           ->orWhere('total_rate','LIKE','%'.request('keyword').'%');
                // })
                ->whereHas('customer',function($query){
                    $query->WhereRaw("concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' ")
                    ->orWhere('email','LIKE','%'.request('keyword').'%')
                    ->orWhere('mobile','LIKE','%'.request('keyword').'%');
                });
            }
        }
        $data['allOrder']=$allOrder->orderBy('id','desc')->paginate(10);
        $data['request'] = $request->all();
        return view('admin.modules.manage_product_order.manage_product_order')->with($data);
    }
     /**
     *   Method      : viewDetails
     *   Description : view product order details
     *   Author      : Soumojit
     *   Date        : 2021-AUG-18
     **/
    public function viewDetails($slug=null){
        $order = OrderMaster::where('order_type','PO')->with(['orderDetails','country','state','billingCountry','billingState'])->where('order_id',$slug)->first();
        if(@$order==null){
            return redirect()->route('admin.manage.product.order')->with('error','Something went wrong');
        }
        $data['data']=$order;
        // Mail::send(new ProductOrderEmail($data));
        // Mail::send(new ProductOrderShippingEmail($data));
        // return $data;
        return view('admin.modules.manage_product_order.view_order')->with($data);
    }
    /**
     *   Method      : orderStatusChange
     *   Description : status Change
     *   Author      : Soumojit
     *   Date        : 2021-AUG-18
     **/
    public function orderStatusChange($slug=null,$status){
        $order = OrderMaster::where('order_type','PO')->where('order_id',$slug)->first();
        if(@$order==null){
            return redirect()->route('admin.manage.product.order')->with('error','Something went wrong');
        }
        $upd=[];
        $upd['status']=$status;
        if($status=='CA'){
            OrderMaster::where('id',$order->id)->update($upd);
            session()->flash('success', 'Order Cancel successful');
        }
        if($status=='IP'){
            OrderMaster::where('id',$order->id)->update($upd);
            session()->flash('success', 'Order In Progress successful');
        }
        if($status=='OD'){
            OrderMaster::where('id',$order->id)->update($upd);
            session()->flash('success', 'Order Out of Delivery successful');
        }
        if($status=='D'){
            OrderMaster::where('id',$order->id)->update($upd);
            session()->flash('success', 'Order Delivered successful');
        }

        return redirect()->back();
    }
	/**
	*Method:gemstoneOrderMoreInfo
	*Description:For showing gemstone order details
	*Author:Madhuchandra
	*Date:2021-SEPT-27
	*/
	public function gemstoneOrderMoreInfo(Request $request)
	{
		$order_details_id=@$request->order_details_id;
		$gemstone_details=OrderDetails::where('id',$order_details_id)->first();
		$order_master_details=OrderMaster::where('id',$gemstone_details->order_master_id)->with('currencyDetails')->first();
		$html="";
		if(@$gemstone_details)
		{
			if(@$gemstone_details->jewellery_type=='OS')
			{
				$html.='<p><span>Gemstone Weight:</span> '.$gemstone_details->gemstone_weight.' Carat ('.(round($gemstone_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
                if(@$gemstone_details->certificate_name!=""){
                    $html.='<p><span>Cirtificate Name:</span> '.@$gemstone_details->certificate_name.' </p>';
                    $html.='<p><span>Cirtificate Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->certification_price.' </p>';
                }
                if(@$gemstone_details->puja_energization_name!=""){
                    $html.='<p><span>Puja Energization Name:</span> '.@$gemstone_details->puja_energization_name.' </p>';
                    $html.='<p><span>Puja Energization Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->puja_energization_price.' </p>';
                }
			}
			else
			{
				$html.='<p><span>Gemstone Weight:</span> '.$gemstone_details->gemstone_weight.' Carat ('.(round($gemstone_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
				if(@$gemstone_details->jewellery_type=='R')
				{
					if(@$gemstone_details->metal_type=='G')
					{
						$html.='<p><span>Gemstone purchased with:</span> Gold Ring</p>';	
						$html.='<p><span>Ring weight: </span>'.$gemstone_details->ring_weight.' Carat </p>';	
						$html.='<p><span>Ring size: </span>'.$gemstone_details->ring_size_system.' - '.$gemstone_details->ring_size.'</p>';
						$html.='<p><span>Ring price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->gold_purity_price.'</p>';				
					}
					elseif(@$gemstone_details->metal_type=='S')
					{
						$html.='<p><span>Gemstone purchased with:</span> Silver Ring</p>';
						$html.='<p><span>Ring weight: </span>'.$gemstone_details->ring_weight.' Gm</p>';	
						$html.='<p><span>Ring size: </span>'.$gemstone_details->ring_size_system.' - '.$gemstone_details->ring_size.'</p>';
						$html.='<p><span>Ring price: </span>'.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->ring_price.'</p>';
					}
					elseif(@$cart_details->metal_type=='P')
					{
						$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Ring</p>';
						$html.='<p><span>Ring weight: </span>'.$gemstone_details->ring_weight.' Gm</p>';	
						$html.='<p><span>Ring size:</span> '.$gemstone_details->ring_size_system.' - '.$gemstone_details->ring_size.'</p>';	
						$html.='<p><span>Ring price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->ring_price.'</p>';
					}
					if(@$gemstone_details->ring_pendant_design_name)
					{
						$img_url=\URL::to('/').'/storage/app/public/order_ring_pendant_design/'.$gemstone_details->ring_pendant_design_image;
						$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
						$html.='<p> '.$gemstone_details->ring_pendant_design_name.'</p>';
						
					}
					
				}
				elseif(@$gemstone_details->jewellery_type=='P')
				{
					
					if(@$gemstone_details->metal_type=='G')
					{
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with:</span> Gold Pendant - with chain</p>';
						}
						else
						{
							$html.='<p><span>Gemstone purchased with:</span> Gold Pendant - without chain</p>';
						}						
						$html.='<p><span>Pendant weight:</span> '.$gemstone_details->pendant_weight.' Carat</p>';
						$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->gold_purity_price.'</p>';
					}
					elseif(@$gemstone_details->metal_type=='S')
					{
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with:</span> Silver Pendant - with chain</p>';
						}
						else
						{
							$html.='<p><sapn>Gemstone purchased with:</span> Silver Pendant - without chain</p>';
						}
						$html.='<p><span>Pendant weight:</span> '.$gemstone_details->pendant_weight.' Gm</p>';
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_chain_price.'</p>';
						}
						else
						{								
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_price.'</p>';
						}
					}
					elseif(@$gemstone_details->metal_type=='P')
					{
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Pendant - with chain</p>';
						}
						else
						{
							$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Pendant - without chain</p>';
						}
						$html.='<p><span>Pendant weight:</span> '.$gemstone_details->pendant_weight.' Gm</p>';
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_chain_price.'</p>';
						}
						else
						{								
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_price.'</p>';
						}
					}
					if(@$gemstone_details->ring_pendant_design_name)
					{
						$img_url=\URL::to('/').'/storage/app/public/order_ring_pendant_design/'.$gemstone_details->ring_pendant_design_image;
						$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
						$html.='<p> '.$gemstone_details->ring_pendant_design_name.'</p>';
						
					}
				}
				elseif(@$gemstone_details->jewellery_type=='B')
				{
					if(@$gemstone_details->metal_type=='G')
					{
						$html.='<p><span>Gemstone purchased with:</span> Gold Bracelet</p>';	
						$html.='<p><span>Bracelet weight:</span> '.$gemstone_details->bracelet_weight.' Carat</p>';
						$html.='<p><span>Bracelet Size:</span> '.$gemstone_details->bracelet_size.'</p>';
						$html.='<p><span>Bracelet price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->gold_purity_price.'</p>';
						if(@$gemstone_details->bracelet_design_name)
						{
							$img_url=\URL::to('/').'/storage/app/public/order_bracelet_design/'.$gemstone_details->bracelet_design_image;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							$html.='<p><span>Bracelet design price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->bracelet_design_price.'</p>';
							
						}
					}
					elseif(@$gemstone_details->metal_type=='S')
					{
						$html.='<p><span>Gemstone purchased with:</span> Silver Bracelet</p>';
						$html.='<p><span>Bracelet Size:</span> '.$gemstone_details->bracelet_size.'</p>';
						if(@$gemstone_details->bracelet_design_name)
						{
							$img_url=\URL::to('/').'/storage/app/public/order_bracelet_design/'.$gemstone_details->bracelet_design_image;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							$html.='<p><span>Bracelet design price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->bracelet_design_price.'</p>';
							
						}					
					}
					elseif(@$gemstone_details->metal_type=='P')
					{
						$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Bracelet</p>';
						$html.='<p><span>Bracelet Size:</span> '.$gemstone_details->bracelet_size.'</p>';
						if(@$gemstone_details->bracelet_design_name)
						{
							$img_url=\URL::to('/').'/storage/app/public/order_bracelet_design/'.$gemstone_details->bracelet_design_image;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							$html.='<p>Bracelet design price: '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->bracelet_design_price.'</p>';
							
						}
					}
				}
                if(@$gemstone_details->certificate_name!=""){
                    $html.='<p><span>Cirtificate Name:</span> '.@$gemstone_details->certificate_name.' </p>';
                    $html.='<p><span>Cirtificate Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->certification_price.' </p>';
                }
                if(@$gemstone_details->puja_energization_name!=""){
                    $html.='<p><span>Puja Energization Name:</span> '.@$gemstone_details->puja_energization_name.' </p>';
                    $html.='<p><span>Puja Energization Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->puja_energization_price.' </p>';
                }

								
			}
			
		}
		$response['html']=$html;
		return response()->json($response);		
	}
}
