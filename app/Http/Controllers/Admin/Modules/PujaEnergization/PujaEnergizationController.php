<?php

namespace App\Http\Controllers\Admin\Modules\PujaEnergization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PujaEnergization;
use App\Models\EnergizationPuja;
use App\Models\Cart;
class PujaEnergizationController extends Controller
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
        $data['puja'] = PujaEnergization::orderBy('puja_id');
        if (@$request->name) {
             $data['puja'] =  $data['puja']->where('puja_id',request('name'));
        }
        if(@$request->amount1!="" && @$request->amount2){
            $data['puja'] = $data['puja']->whereBetween('price_inr',[$request->amount1,$request->amount2]);
        }

       if(@$request->amount1==null && @$request->amount2){
        $data['puja'] = $data['puja']->whereBetween('price_inr','<',$request->amount2);
       }
        $data['puja'] =  $data['puja']->paginate(10);
        $data['max_price']=PujaEnergization::max('price_inr');
        $data['pujas'] = EnergizationPuja::orderBy('puja','asc')->get();
        return view('admin.modules.puja_energization.manage_puja_energization',$data);
    }
    public function addView()
    {
        $data = [];
        $data['pujas'] = EnergizationPuja::orderBy('puja','asc')->get();
    	return view('admin.modules.puja_energization.add_puja_energization',$data);
    }

    public function add(Request $request)
    {
    	$puja = new PujaEnergization;
    	$puja->puja_id = $request->name;
    	$puja->price_inr = $request->price_inr;
    	$puja->price_usd = $request->price_usd;
        $puja->bp_inr_from = $request->from_inr;
        $puja->bp_inr_to = $request->to_inr;
        $puja->bp_usd_from = $request->from_usd;
        $puja->bp_usd_to = $request->to_usd;
    	$puja->save();
    	return redirect()->back()->with('success','Puja Energization Added Successfully');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = PujaEnergization::where('puja_id',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = PujaEnergization::where('puja_id',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function delete($id)
    {
        $check = PujaEnergization::where('id',$id)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        $check2 = Cart::where('puja_energization_id',$id)->first();
        if (@$check2!="") {
            return redirect()->back()->with('Puja Energization Can Not Be Deleted As Someone Added In Cart');
        }
        $delete = PujaEnergization::where('id',$id)->delete();
        return redirect()->back()->with('success','Puja Energization Deleted Successfully');
    }

    public function editView($id)
    {
        $check = PujaEnergization::where('id',$id)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        $data = [];
        $data['pujas'] = EnergizationPuja::orderBy('puja','asc')->get();
        $data['data'] = PujaEnergization::where('id',$id)->first();
        return view('admin.modules.puja_energization.edit_puja_energization',$data);
    }

    public function update(Request $request)
    {
        $update = PujaEnergization::where('id',$request->id)->update(['puja_id'=>$request->name,'price_inr'=>$request->price_inr,'price_usd'=>$request->price_usd,'bp_inr_from'=>$request->from_inr,'bp_inr_to'=>$request->to_inr,'bp_usd_from'=>$request->from_usd,'bp_usd_to'=>$request->to_usd]);
        return redirect()->back()->with('success','Puja Energization Updated Successfully');
    }

    public function checkPrice(Request $request)
    {
       
      if (@$request->from_inr>=$request->to_inr) {
           echo "greater_inr";
       }
       elseif (@$request->from_usd>=$request->to_usd) {
           echo "greater_usd";
       }else{

        // inr-check
        $inr_check1 = PujaEnergization::where('bp_inr_from','<=',$request->from_inr)->where('bp_inr_to','>=',$request->from_inr)->where('puja_id',$request->name)->first();
      
        $inr_check2 = PujaEnergization::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_to','>=',$request->to_inr)->where('puja_id',$request->name)->first();
        $inr_check3 = PujaEnergization::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_from','>=',$request->from_inr)->where('bp_inr_to','<=',$request->to_inr)->where('puja_id',$request->name)->first();

         // $inr_check4 = PujaEnergization::where('bp_inr_from','<',$request->from_usd)->where('bp_inr_to','>',$request->to_usd)->where('puja_id',$request->name)->first();

        // usd-check 
        $usd_check1 = PujaEnergization::where('bp_usd_from','<=',$request->from_usd)->where('bp_usd_to','>=',$request->from_usd)->where('puja_id',$request->name)->first();
      
        $usd_check2 = PujaEnergization::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_to','>=',$request->to_usd)->where('puja_id',$request->name)->first();
        $usd_check3 = PujaEnergization::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_from','>=',$request->from_usd)->where('bp_usd_to','<=',$request->to_usd)->where('puja_id',$request->name)->first();

         // $usd_check4 = PujaEnergization::where('bp_usd_from','<',$request->from_usd)->where('bp_usd_to','>',$request->to_usd)->where('puja_id',$request->name)->first();

        if (@$inr_check1!="") {
           echo "inr_exit";
        }
        elseif (@$inr_check2!="") {
            echo "inr_exit";
        }
        elseif (@$inr_check3!="") {
            echo "inr_exit";
        }
        

       elseif (@$usd_check1!="") {
           echo "usd_exit";
        }
        elseif (@$usd_check2!="") {
            echo "usd_exit";
        }
        elseif (@$usd_check3!="") {
            echo "usd_exit";
        }
         
        else{
            echo "clear";
        }
    }


        
    }




    public function checkPriceEdit(Request $request)
    {
       
      if (@$request->from_inr>=$request->to_inr) {
           echo "greater_inr";
       }
       elseif (@$request->from_usd>=$request->to_usd) {
           echo "greater_usd";
       }else{

        // inr-check
        $inr_check1 = PujaEnergization::where('bp_inr_from','<=',$request->from_inr)->where('bp_inr_to','>=',$request->from_inr)->where('puja_id',$request->name)->where('id','!=',$request->id)->first();
      
        $inr_check2 = PujaEnergization::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_to','>=',$request->to_inr)->where('puja_id',$request->name)->where('id','!=',$request->id)->first();
        $inr_check3 = PujaEnergization::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_from','>=',$request->from_inr)->where('bp_inr_to','<=',$request->to_inr)->where('puja_id',$request->name)->where('id','!=',$request->id)->first();

         // $inr_check4 = PujaEnergization::where('bp_inr_from','<',$request->from_usd)->where('bp_inr_to','>',$request->to_usd)->where('puja_id',$request->name)->where('id','!=',$request->id)->first();

        // usd-check 
        $usd_check1 = PujaEnergization::where('bp_usd_from','<=',$request->from_usd)->where('bp_usd_to','>=',$request->from_usd)->where('puja_id',$request->name)->where('id','!=',$request->id)->first();
      
        $usd_check2 = PujaEnergization::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_to','>=',$request->to_usd)->where('puja_id',$request->name)->where('id','!=',$request->id)->first();
        $usd_check3 = PujaEnergization::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_from','>=',$request->from_usd)->where('bp_usd_to','<=',$request->to_usd)->where('id','!=',$request->id)->where('puja_id',$request->name)->first();

         // $usd_check4 = PujaEnergization::where('bp_usd_from','<',$request->from_usd)->where('bp_usd_to','>',$request->to_usd)->where('puja_id',$request->name)->where('id','!=',$request->id)->first();

        if (@$inr_check1!="") {
           echo "inr_exit";
        }
        elseif (@$inr_check2!="") {
            echo "inr_exit";
        }
        elseif (@$inr_check3!="") {
            echo "inr_exit";
        }
        

       elseif (@$usd_check1!="") {
           echo "usd_exit";
        }
        elseif (@$usd_check2!="") {
            echo "usd_exit";
        }
        elseif (@$usd_check3!="") {
            echo "usd_exit";
        }
        
        else{
            echo "clear";
        }
    }


        
    }



}
