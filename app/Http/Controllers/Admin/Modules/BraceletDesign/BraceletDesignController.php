<?php

namespace App\Http\Controllers\Admin\Modules\BraceletDesign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BraceletDesign;
use App\Models\Metal;
use App\Models\Cart;
class BraceletDesignController extends Controller
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
    	$data['design'] = BraceletDesign::orderBy('id','desc');
    	if (@$request->keyword) {
    	 	$data['design'] = $data['design']->where('design_name','LIKE','%'.request('keyword').'%');
    	}
        if (@$request->metal) {
            $data['design'] = $data['design']->where('metal_type','LIKE','%'.request('metal').'%');
        }
        if(@$request->amount1!="" && @$request->amount2){
            $data['design'] = $data['design']->whereBetween('price_inr',[$request->amount1,$request->amount2]);
        }

       if(@$request->amount1==null && @$request->amount2){
        $data['design'] = $data['design']->whereBetween('price_inr','<',$request->amount2);
       }
    	 $data['design'] = $data['design']->paginate(10);
         $data['metal'] = Metal::get();
         $data['max_price']=BraceletDesign::max('price_inr');
    	return view('admin.modules.bracelet_design.manage_bracelet',$data);
    }

    public function addView()
    {
        $data = [];
        $data['metal'] = Metal::get();
    	return view('admin.modules.bracelet_design.add_bracelet',$data);
    }

    public function add(Request $request)
    {
    	$bracelet = new BraceletDesign;
    	$bracelet->design_name = $request->name;
        $bracelet->price_inr = $request->price_inr;
        $bracelet->price_usd = $request->price_usd;
        $bracelet->metal_type = $request->metal;
    	if ($request->profile_picture) {
            $destinationPath = "storage/app/public/bracelet_design/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $bracelet->design_picture = $img;
        }
        $bracelet->save();
        return redirect()->back()->with('success','Bracelet Design Added Successfully');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
          $check = BraceletDesign::where('design_name',$request->name)->where('metal_type',$request->metal)->where('id','!=',$request->id)->first();
            if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }
          
              
          }else{
             $check = BraceletDesign::where('design_name',$request->name)->where('metal_type',$request->metal)->first();
             if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }
              
          }
    }

    public function delete($id)
    {
    	$check = BraceletDesign::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
        $check2 = Cart::where('bracelet_design_id',$id)->first(); 
        if ($check2!="") {
            return redirect()->back()->with('error','Bracelet Design Can Not Be Deleted As It Is Associated With Cart');
        }
        unlink('storage/app/public/bracelet_design/' .$check->design_picture);
    	$del = BraceletDesign::where('id',$id)->delete();
    	return redirect()->back()->with('success','Bracelet Design Deleted Successfully');
    }

    public function edit($id)
    {
    	$check = BraceletDesign::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
        $data = [];
    	$data['data'] = BraceletDesign::where('id',$id)->first();
        $data['metal'] = Metal::get();
    	return view('admin.modules.bracelet_design.edit_bracelet',$data);
    }

    public function update(Request $request)
    {
    	$upd = [];
    	$details = BraceletDesign::where('id',$request->id)->first();
    	$upd['design_name'] = $request->name;
        $upd['price_inr'] = $request->price_inr;
        $upd['price_usd'] = $request->price_usd;
        $upd['metal_type'] = $request->metal;
    	if ($request->profile_picture) {
			@unlink(storage_path('app/public/bracelet_design/' . $details->design_picture));
            $destinationPath = "storage/app/public/bracelet_design/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['design_picture'] = $img;
        }
        BraceletDesign::where('id',$request->id)->update($upd);
        return redirect()->back()->with('success','Bracelet Design Updated Successfully');
    }

    public function deleteImage(Request $request)
    {
        $details = BraceletDesign::where('id',$request->id)->first();
        @unlink(storage_path('app/public/bracelet_design/' . $details->design_picture));
        BraceletDesign::where('id',$request->id)->update(['design_picture'=>'']);
        echo "success";
    }
}
