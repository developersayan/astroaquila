<?php

namespace App\Http\Controllers\Admin\Modules\ManagePujaOrder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\PunditToPuja;
use App\Models\PunditToZipcode;
use App\User;
use App\Models\ZipMaster;
use Mail;
use App\Mail\PujaAssignPundit;
use App\Mail\NotifyCustomer;
use App\Models\OrderPujaNames;
use App\Models\Puja;
class ManagePujaOrderController extends Controller
{
    //
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
    	$data['pujas'] = OrderMaster::where('payment_status','P')->where('order_type','P')->orderBy('id','desc');
    	if (@$request->keyword) {
    		$data['pujas'] = $data['pujas']->where(function($query){
    			$query->where('order_id','LIKE','%'.request('keyword').'%')
    				  ->orWhere('p_google_address','LIKE','%'.request('keyword').'%')
    				  ->orWhere('puja_zip','LIKE','%'.request('keyword').'%')
    				  ->orWhere('total_rate','LIKE','%'.request('keyword').'%');	
    		})->orWhereHas('customer',function($query){
    			$query->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" . request('keyword'). "%' "
                        )
                      ->orWhere('email','LIKE','%'.request('keyword').'%');
    		});
    	}

    	if (@$request->status) {
    		$data['pujas'] = $data['pujas']->where('status',request('status'));
    	}

    	if (@$request->puja) {
    		$data['pujas'] = $data['pujas']->where('puja_id',request('puja'));
    	}

    	if (@$request->order_id) {
    		$data['pujas'] = $data['pujas']->where('order_id','LIKE','%'.request('order_id').'%');
    	}
    	if (@$request->assigned) {
    		if(@$request->assigned=='Y'){
    		$data['pujas'] = $data['pujas']->where('user_id','!=','');
    		}else{
    		$data['pujas'] = $data['pujas']->where('user_id','=',null);
    		}
    	}

    	if (@$request->pundit_search) {
    		if (@$request->assigned=='N') {
    			$data['pujas'] = $data['pujas']->where('user_id','=',null);
    		}else{
    		$data['pujas'] = $data['pujas']->where('user_id',request('pundit_search'));
    	   }
    	}

    	if(@$request->from_date && @$request->to_date){
                $data['pujas'] = $data['pujas']->whereBetween('date',[date('Y-m-d',strtotime($request->from_date)),date('Y-m-d',strtotime($request->to_date))]);
         }
    	$data['pujas'] = $data['pujas']->paginate(10);
    	$data['puja_list'] = Puja::where('status','A')->orderBy('puja_name','asc')->get();
    	$data['pundits'] = User::where('user_type','P')->where('status','A')->get();
    	return view('admin.modules.managePujaOrder.manage_puja_order',$data);
    }

    public function punditList(Request $request)
    {
    	// return @$request->manner;
        $order = OrderMaster::where('id',$request->order_id)->first();
    	if(@$request->manner=="ONLINE"){
    	$pujaArray = [];
    	$punditPuja = PunditToPuja::where('puja_id',$request->puja_id)->get();
    	foreach ($punditPuja as $key => $value) {
    		 	array_push($pujaArray, $value->user_id);
    		}
        if (@$request->re) {
           $data = User::where('user_type','P')->where('status','A')->whereIn('id',$pujaArray)->where('id','!=',$order->user_id)->where('id','!=',$order->customer_id)->where('user_availability','Y');
            if (@$request->name_seach!="") {
                 $data =  $data->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" .@$request->name_seach. "%' "
                        );
            }
            if (@$request->code_seach!="") {
                 $data =  $data->where('user_unique_code','LIKE','%'.@$request->code_seach.'%');
            }
            if (@$request->address_seach!="") {
                 $data =  $data->where('address','LIKE','%'.@$request->address_seach.'%');
            }
            if (@$request->number_seach!="") {
                 $data =  $data->where('mobile','LIKE','%'.@$request->number_seach.'%');
            }
            $data =  $data->get();
        }else{
            $data = User::where('user_type','P')->where('status','A')->whereIn('id',$pujaArray)->where('id','!=',$order->customer_id)->where('user_availability','Y');
            if (@$request->name_seach!="") {
                 $data =  $data->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" .@$request->name_seach. "%' "
                        );
            }
            if (@$request->code_seach!="") {
                 $data =  $data->where('user_unique_code','LIKE','%'.@$request->code_seach.'%');
            }
            if (@$request->address_seach!="") {
                 $data =  $data->where('address','LIKE','%'.@$request->address_seach.'%');
            }
            if (@$request->number_seach!="") {
                 $data =  $data->where('mobile','LIKE','%'.@$request->number_seach.'%');
            }
            $data =  $data->get();
        }		
    	
		$response=array();
		$result ="<option value=''>Select a pundit</option>";
		if(@$data->isNotEmpty())
		{
			foreach($data as $rows)
			{
			$result.="<option value='".$rows->id."' >" .$rows->first_name."&nbsp;" . $rows->last_name.'(Code No:'.@$rows->user_unique_code.' | Address:'.$rows->address.' | Ph. No:'.$rows->mobile.")</option>";
			}
		}
		$response['pundit']=$result;
		
		return response()->json($response);
    	

    	}else{
    		// return $request->zip_id;
    		 $zipArray = [];
    		 $pujaArray = [];
    		 $punditIds = [];

    		 $zip =	ZipMaster::where('zipcode',$request->zip_id)->first();
    		 // return $zip;
    		 $punditZip = PunditToZipcode::where('zipcode_id',$zip->id)->get();
    		 // return $punditZip;
    		 $punditPuja = PunditToPuja::where('puja_id',$request->puja_id)->get();
    		 // return $punditPuja;
    		 foreach ($punditZip as $key => $value) {
    		 	array_push($zipArray, $value->pundit_id);
    		 }
    		 foreach ($punditPuja as $key => $value) {
    		 	array_push($pujaArray, $value->user_id);
    		 }
    		  // return $zipArray;

    		 $punditIds = array_intersect($zipArray,$pujaArray);


            if (@$request->re=="re") {
            $data = User::where('user_type','P')->whereIn('id',$punditIds)->where('id','!=',$order->user_id)->where('id','!=',$order->customer_id)->where('status','A')->where('user_availability','Y');
            if (@$request->name_seach!="") {
                 $data =  $data->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" .@$request->name_seach. "%' "
                        );
            }
            if (@$request->code_seach!="") {
                 $data =  $data->where('user_unique_code','LIKE','%'.@$request->code_seach.'%');
            }
            if (@$request->address_seach!="") {
                 $data =  $data->where('address','LIKE','%'.@$request->address_seach.'%');
            }
            if (@$request->number_seach!="") {
                 $data =  $data->where('mobile','LIKE','%'.@$request->number_seach.'%');
            }
            $data =  $data->get();
           }else{
            
            $data = User::where('user_type','P')->whereIn('id',$punditIds)->where('id','!=',$order->customer_id)->where('user_availability','Y')->where('status','A');
            

            if (@$request->name_seach!="") {
                 $data =  $data->WhereRaw(
                        "concat(first_name, ' ', last_name) like '%" .@$request->name_seach. "%' "
                        );
            }
            if (@$request->code_seach!="") {
                 $data =  $data->where('user_unique_code','LIKE','%'.@$request->code_seach.'%');
            }
            if (@$request->address_seach!="") {
                 $data =  $data->where('address','LIKE','%'.@$request->address_seach.'%');
            }
            if (@$request->number_seach!="") {
                 $data =  $data->where('mobile','LIKE','%'.@$request->number_seach.'%');
            }
            $data =  $data->get();

          }

	    	
			$response=array();
			$result ="<option value=''>Select a pundit</option>";
			if(@$data->isNotEmpty())
			{
				foreach($data as $rows)
				{
				$result.="<option value='".$rows->id."' >" .$rows->first_name."&nbsp;" . $rows->last_name.'(Code No:'.@$rows->user_unique_code.' | Address:'.$rows->address.'  | Ph. No:'.$rows->mobile.")</option>";
				}
			}
			$response['pundit']=$result;
			
			return response()->json($response);

		}
    }


    public function assignPundit(Request $request)
    {
        // return $request;
    	$update = OrderMaster::where('id',$request->id)->update(['user_id'=>$request->pundit_id,'status'=>'N','pundit_accepted'=>'N']);
    	$order = OrderMaster::with('mantraDetails')->where('id',$request->id)->first();
        $user = User::where('id',$order->customer_id)->first();
        $pundit = User::where('id',$order->user_id)->first();
        $names = OrderPujaNames::where('ordermaster_id',$request->id)->get();
        $pujaname = Puja::where('id',$order->puja_id)->first();
        $neworderDetails = OrderMaster::where('id',$request->id)->first();
    	$data = [
                'name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'email'=>$pundit->email,
                'date'=>date('d/m/Y',strtotime($order->date)),
                'order_total'=>$order->total_rate,
                'order_id'=>$order->order_id,
                'puja_name'=>$pujaname->puja_name,
                'puja_code'=>$pujaname->puja_code,
                'puja_details'=>$pujaname->puja_description,
                'puja_address'=>$order->p_google_address,
                'zip_code'=>$order->puja_zip,
                'landmark'=>$order->puja_landmark,
                'house_no'=>$order->puja_house_no,
                'customers'=>$names,
                'order_id'=>$order->order_id,
                'currency'=> $order->currency_id,
                'payment_status'=>$order->payment_status,
                'puja_type'=>$order->puja_type,
				'mantraDetails'=>@$order->mantraDetails,
				'is_homam'=>@$order->is_homam,
				'homam_price'=>@$order->homam_price,
                'subtotal'=>@$neworderDetails->subtotal,
                'neworderDetails'=>@$neworderDetails,
                'is_cd'=>@$order->is_cd,
                'cd_price'=>@$order->cd_price,
                'is_live_streaming'=>@$order->is_live_streaming,
                'live_streaming_price'=>@$order->live_streaming_price,
                'is_prasad'=>@$order->is_prasad,
                'prasad_price'=>@$order->prasad_price,
                'dakshina'=>@$order->dakshina,
                ];
         Mail::send(new PujaAssignPundit($data));
        return redirect()->back()->with('success','Pundit Assigned Successfully');
    }

    public function viewOrderPuja($id)
    {
    	$data = [];
    	$check = OrderMaster::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data['data'] = OrderMaster::with('mantraDetails')->where('id',$id)->first();
    	$data['pujaNames'] = OrderPujaNames::where('ordermaster_id',$id)->get();
    	return view('admin.modules.managePujaOrder.view_puja_order',$data);
    }


    public function assignLink(Request $request)
    {
        
        $update = OrderMaster::where('id',$request->id)->update(['final_puja_link'=>$request->link,'final_puja_notes'=>$request->note]);
        $data = OrderMaster::where('id',$request->id)->first();
        $puja = Puja::where('id',$data->puja_id)->first();
        $user = User::where('id',$data->customer_id)->where('user_type','C')->first();
        $data = [
                'name'=>$user->first_name,
                'last_name'=>$user->last_name,
                'email'=>$user->email,
                'puja_link'=>$data->final_puja_link,
                'puja_note'=>$data->final_puja_notes,
                'date'=>date('d/m/Y',strtotime($data->date)),
                'puja'=>$puja->puja_name,
                'order_id'=>$data->order_id,
         ];
         Mail::send(new NotifyCustomer($data));
         return redirect()->back()->with('success','Puja Link And Note Addded Successfully');
    }


}
