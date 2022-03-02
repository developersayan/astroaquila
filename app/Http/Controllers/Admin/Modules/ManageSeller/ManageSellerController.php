<?php

namespace App\Http\Controllers\Admin\Modules\ManageSeller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SellersContact;
class ManageSellerController extends Controller
{
    //
    public function index(Request $request)
    {
    	$data = [];
    	$data['sellers'] = SellersContact::orderBy('id','desc');
    	if (@$request->keyword) {
    		$data['sellers'] =$data['sellers']->where(function($query){
    			$query->where('name','LIKE','%'.request('keyword').'%')
    				->orWhere('email','LIKE','%'.request('keyword').'%')
    				->orWhere('address','LIKE','%'.request('keyword').'%')
    				->orWhere('mobile','LIKE','%'.request('keyword').'%')
    				->orWhere('description','LIKE','%'.request('keyword').'%');
    		});
    	}
    	$data['sellers'] =$data['sellers']->paginate(10);
    	return view('admin.modules.seller.manage_seller',$data);
    }
    
    public function download($file)
    {
	    $file_path = @storage_path() . "/app/public/seller_file/".$file;
	    return response()->download( $file_path);
    }

    public function delete($id)
    {
    	$data = SellersContact::where('id',$id)->first();
        if ($data==null) {
            return redirect()->back();
        }
        $delete = SellersContact::where('id',$id)->delete();
        return redirect()->back()->with('success','Seller Account Deleted Successfully');
    }

    public function view($id)
    {
    	$check = SellersContact::where('id',$id)->first();
        if ($check==null) {
            return redirect()->back();
        }
        $data = SellersContact::where('id',$id)->where('status','!=','D')->first();
        // return $data;
        return view('admin.modules.seller.view_seller',compact('data'));    
    }

}
