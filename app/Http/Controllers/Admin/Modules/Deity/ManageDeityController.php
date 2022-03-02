<?php

namespace App\Http\Controllers\Admin\Modules\Deity;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Deity;
use App\Models\Products;
use App\Models\ProductToDeity;
use App\Models\Puja;
use App\Models\PujaToDeity;

class ManageDeityController extends Controller
{
    //
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
    	$data['deity'] = Deity::orderBy('id','desc');
    	if (@$request->name) {
    		$data['deity'] = $data['deity']->where('name','LIKE','%'.request('name').'%');
    	}
    	$data['deity'] = $data['deity']->paginate(10);
       
    	return view('admin.modules.deity.manage_deity',$data);
    }

    public function addView()
    {
    	return view('admin.modules.deity.add_deity');
    }


    public function addDeity(Request $request)
    {
    	$deity = new Deity;
    	$check = Deity::where('name',$request->name)->first();
    	if ($check!="") {
    		return redirect()->back()->with('error','Deity Name Already Exists');
    	}
    	$deity->name = $request->name;
    	$deity->save();
    	return redirect()->back()->with('success','Deity Added Successfully');
    }

    public function checkDeity(Request $request)
    {
    	 if (@$request->id) {
	      $check = Deity::where('name',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = Deity::where('name',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function editView($id)
    {
    	$data = Deity::where('id',$id)->first();
    	if ($data==null) {
    		return redirect()->back();
    	}
    	return view('admin.modules.deity.edit_deity',compact('data'));
    }

    public function updateDeity(Request $request)
    {
    	$upd = [];
    	$upd['name'] = $request->name;
    	$update = Deity::where('id',$request->id)->update($upd);
    	return redirect()->back()->with('success','Deity Updated Successfully');
    }

    public function deletDeity($id)
    {
    	$data = Deity::where('id',$id)->first();
    	if ($data==null) {
    		return redirect()->back();
    	}
        $puja = puja::where('status','!=','D')->get();
        
        foreach ($puja as $key => $value) {
           $getdata = PujaToDeity::where('puja_id',$value->id)->where('deity_id',$id)->first();
           if ($getdata!="") {
            return redirect()->back()->with('error','Deity Can Not Be Deleted As It Is Associated With Puja');
          }
        }

        $check = Products::where('status','!=','D')->get();
        foreach ($check as $key => $value) {
           $getdata = ProductToDeity::where('product_id',$value->id)->where('deity_id',$id)->first();
           if ($getdata!="") {
            return redirect()->back()->with('error','Deity Can Not Be Deleted As It Is Associated With Products');
          }
        }
        
    	$delete = Deity::where('id',$id)->delete();
    	return redirect()->back()->with('success','Deity Deleted Successfully');
    }


}
