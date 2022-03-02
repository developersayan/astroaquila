<?php

namespace App\Http\Controllers\Admin\Modules\Cirtificate;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cirtificate;
use App\Models\CertificationName;
use App\Models\Cart;
class CirtificateController extends Controller
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
     *   Description : show manage cirtificate
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/
    public function index(Request $request)
    {
    	$data = [];
    	$data['cirtificate'] = Cirtificate::orderBy('certificate_id');
    	if (@$request->name) {
             $data['cirtificate'] =  $data['cirtificate']->where('certificate_id',request('name'));
        }
        if(@$request->amount1!="" && @$request->amount2){
            $data['cirtificate'] = $data['cirtificate']->whereBetween('price_inr',[$request->amount1,$request->amount2]);
        }

       if(@$request->amount1==null && @$request->amount2){
        $data['cirtificate'] = $data['cirtificate']->whereBetween('price_inr','<',$request->amount2);
       }
        $data['cirtificate'] =  $data['cirtificate']->paginate(10);
    	$data['max_price']=Cirtificate::max('price_inr');
        $data['certificate'] = CertificationName::orderBy('cert_name','asc')->get();
    	return view('admin.modules.cirtificate.manage_cirtificate',$data);
    }

   /**
     *   Method      : addView
     *   Description : show add cirtificate form
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

   	public function addView()
   	{
        $data= [];
        $data['certificate'] = CertificationName::orderBy('cert_name','asc')->get();
   		return view('admin.modules.cirtificate.add_cirtificate',$data);
   	}

   /**
     *   Method      : checkPrice
     *   Description : check price range base price range of cirtification
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

    public function checkPrice(Request $request)
    {
       
      if (@$request->from_inr>=$request->to_inr) {
           echo "greater_inr";
       }
       elseif (@$request->from_usd>=$request->to_usd) {
           echo "greater_usd";
       }else{

        // inr-check
        $inr_check1 = Cirtificate::where('bp_inr_from','<=',$request->from_inr)->where('bp_inr_to','>=',$request->from_inr)->where('certificate_id',$request->name)->first();
      
        $inr_check2 = Cirtificate::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_to','>=',$request->to_inr)->where('certificate_id',$request->name)->first();
        $inr_check3 = Cirtificate::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_from','>=',$request->from_inr)->where('bp_inr_to','<=',$request->to_inr)->where('certificate_id',$request->name)->first();

         // $inr_check4 = Cirtificate::where('bp_inr_from','<',$request->from_usd)->where('bp_inr_to','>',$request->to_usd)->where('name',$request->name)->first();

        // usd-check 
        $usd_check1 = Cirtificate::where('bp_usd_from','<=',$request->from_usd)->where('bp_usd_to','>=',$request->from_usd)->where('certificate_id',$request->name)->first();
      
        $usd_check2 = Cirtificate::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_to','>=',$request->to_usd)->where('certificate_id',$request->name)->first();
        $usd_check3 = Cirtificate::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_from','>=',$request->from_usd)->where('bp_usd_to','<=',$request->to_usd)->where('certificate_id',$request->name)->first();

         // $usd_check4 = Cirtificate::where('bp_usd_from','<',$request->from_usd)->where('bp_usd_to','>',$request->to_usd)->where('name',$request->name)->first();

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

   /**
     *   Method      : add
     *   Description : cirtification add
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

    public function add(Request $request)
    {
    	// return $request;
    	$cirtificate = new Cirtificate;
    	$cirtificate->certificate_id = $request->name;
    	$cirtificate->price_inr = $request->price_inr;
    	$cirtificate->price_usd = $request->price_usd;
        $cirtificate->bp_inr_from = $request->from_inr;
        $cirtificate->bp_inr_to = $request->to_inr;
        $cirtificate->bp_usd_from = $request->from_usd;
        $cirtificate->bp_usd_to = $request->to_usd;
    	$cirtificate->save();
    	return redirect()->back()->with('success','Cirtificate Price Added Successfully');
    }

   /**
     *   Method      : editView
     *   Description : cirtification edit view
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

    public function editView($id)
    {
    	$check = Cirtificate::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
        $data['certificate'] = CertificationName::orderBy('cert_name','asc')->get();
    	$data['data'] = Cirtificate::where('id',$id)->first();
    	return view('admin.modules.cirtificate.edit_cirtificate',$data);
    }
   
   /**
     *   Method      : editCheckPrice
     *   Description : check price range base price range of cirtification edit
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

    public function editCheckPrice(Request $request)
    {
       if (@$request->from_inr>=$request->to_inr) {
           echo "greater_inr";
       }
       elseif (@$request->from_usd>=$request->to_usd) {
           echo "greater_usd";
       }else{

        // inr-check
        $inr_check1 = Cirtificate::where('bp_inr_from','<=',$request->from_inr)->where('bp_inr_to','>=',$request->from_inr)->where('certificate_id',$request->name)->where('id','!=',$request->id)->first();
      
        $inr_check2 = Cirtificate::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_to','>=',$request->to_inr)->where('certificate_id',$request->name)->where('id','!=',$request->id)->first();
        $inr_check3 = Cirtificate::where('bp_inr_from','<=',$request->to_inr)->where('bp_inr_from','>=',$request->from_inr)->where('bp_inr_to','<=',$request->to_inr)->where('certificate_id',$request->name)->where('id','!=',$request->id)->first();

         // $inr_check4 = Cirtificate::where('bp_inr_from','<',$request->from_usd)->where('bp_inr_to','>',$request->to_usd)->where('name',$request->name)->where('id','!=',$request->id)->first();

        // usd-check 
        $usd_check1 = Cirtificate::where('bp_usd_from','<=',$request->from_usd)->where('bp_usd_to','>=',$request->from_usd)->where('certificate_id',$request->name)->where('id','!=',$request->id)->first();
      
        $usd_check2 = Cirtificate::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_to','>=',$request->to_usd)->where('certificate_id',$request->name)->where('id','!=',$request->id)->first();
        $usd_check3 = Cirtificate::where('bp_usd_from','<=',$request->to_usd)->where('bp_usd_from','>=',$request->from_usd)->where('bp_usd_to','<=',$request->to_usd)->where('certificate_id',$request->name)->where('id','!=',$request->id)->first();

         // $usd_check4 = Cirtificate::where('bp_usd_from','<',$request->from_usd)->where('bp_usd_to','>',$request->to_usd)->where('name',$request->name)->where('id','!=',$request->id)->first();

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

   /**
     *   Method      : update
     *   Description : update cirtification
     *   Author      : Sayan
     *   Date        : 2021-SEPT-17
    **/

    public function update(Request $request)
    {
      $update = Cirtificate::where('id',$request->id)->update(['certificate_id'=>$request->name,'price_inr'=>$request->price_inr,'price_usd'=>$request->price_usd,'bp_inr_from'=>$request->from_inr,'bp_inr_to'=>$request->to_inr,'bp_usd_from'=>$request->from_usd,'bp_usd_to'=>$request->to_usd]);
        return redirect()->back()->with('success','Cirtificate Price Updated Successfully');
    }



    public function delete($id)
    {
    	$check = Cirtificate::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
         $check2 = Cart::where('certificate_id',$id)->first();
         if (@$check2!="") {
            return redirect()->back()->with('Certificate Price Can Not Be Deleted As Someone Added In Cart');
        }
    	$delete = Cirtificate::where('id',$id)->delete();
    	return redirect()->back()->with('success','Cirtificate Price Deleted Successfully');
    }




}
