<?php

namespace App\Http\Controllers\Admin\Modules\ManageSellerMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SellerMaster;
use App\Models\Products;
class ManageSellerMasterController extends Controller
{
    //
    public function index(Request $request)
    {
    	$data = [];
    	$data['sellers'] = SellerMaster::orderBy('id','desc');
    	if (@$request->keyword) {
    		$data['sellers'] = $data['sellers']->where('seller_name','LIKE','%'.request('keyword').'%');
    	}
    	$data['sellers'] = $data['sellers']->paginate(10);
    	return view('admin.modules.manageSellerMaster.manage_seller',$data);
    }

    public function addView()
    {
    	return view('admin.modules.manageSellerMaster.add_seller');
    }

    public function registerSeller(Request $request)
    {
    	$seller = new SellerMaster;
    	$seller->seller_name = $request->name;
    	$seller->save();
    	return redirect()->back()->with('success','Seller Added Successfully');
    }

    public function editView($id)
    {
    	$data = SellerMaster::where('id',$id)->first();
    	if (@$data==null) {
    		return redirect()->back();
    	}
    	return view('admin.modules.manageSellerMaster.edit_seller',compact('data'));
    }


    public function updateSeller(Request $request)
    {
    	$update = SellerMaster::where('id',$request->id)->update([
    		'seller_name'=>$request->name,
    	]);
    	return redirect()->back()->with('success','Seller Updated Successfully');
    }

    public function deleteSeller($id)
    {
    	$data = SellerMaster::where('id',$id)->first();
    	if (@$data==null) {
    		return redirect()->back();
    	}
    	$check = Products::where('status','!=','D')->where('seller_id',$id)->first();
    	if ($check!="") {
    		return redirect()->back()->with('error','Seller Can Not Be Deleted As It Is Associated With Product');
    	}
    	$delete = SellerMaster::where('id',$id)->delete();
    	return redirect()->back()->with('success','Seller Deleted Successfully');
    }
}
