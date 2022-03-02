<?php

namespace App\Http\Controllers\Admin\Modules\Purpose;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Purpose;
use App\Models\Products;
use App\Models\Puja;
use App\Models\PujaToPurpose;
class PurposeController extends Controller
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
        $data['purpose'] = Purpose::orderBy('id','desc');
        if (@$request->name) {
            $data['purpose'] = $data['purpose']->where('name','LIKE','%'.request('name').'%');
        }
        $data['purpose'] = $data['purpose']->paginate(10);
        return view('admin.modules.purpose.manage_purpose',$data);
    }
    public function addView()
    {
		return view('admin.modules.purpose.add_purpose');
    }

    public function addPurpose(Request $request)
    {
    	$purpose = new Purpose;
    	$check = Purpose::where('name',$request->name)->first();
    	if ($check!="") {
    		return redirect()->back()->with('error','Purpose Name Already Exists');
    	}
    	$purpose->name = $request->name;
    	$purpose->save();
    	return redirect()->back()->with('success','Purpose Added Successfully');
    }

    public function checkPurpose(Request $request)
    {
    	if (@$request->id) {
	      $check = Purpose::where('name',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = Purpose::where('name',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function editView($id)
    {
        $data = Purpose::where('id',$id)->first();
        if ($data==null) {
            return redirect()->back();
        }
        return view('admin.modules.purpose.edit_purpose',compact('data'));
    }

    public function updatePurpose(Request $request)
    {
        $upd = [];
        $upd['name'] = $request->name;
        $update = Purpose::where('id',$request->id)->update($upd);
        return redirect()->back()->with('success','Purpose Updated Successfully');
    }


    public function delPurpose($id)
    {

        $data = Purpose::where('id',$id)->first();
        if ($data==null) {
            return redirect()->back();
        }
        $puja = puja::where('status','!=','D')->get();
        
        foreach ($puja as $key => $value) {
           $getdata = PujaToPurpose::where('puja_id',$value->id)->where('purpose_id',$id)->first();
           if ($getdata!="") {
            return redirect()->back()->with('error','Purpose Can Not Be Deleted As It Is Associated With Puja');
          }
        }

        $check = Products::where('status','!=','D')->where('purpose_id',$id)->first();
        if ($check!="") {
             return redirect()->back()->with('error','Purpose Can Not Be Deleted As It Is Asscoiated With Product');
        }
        
        $delete = Purpose::where('id',$id)->delete();
        return redirect()->back()->with('success','Purpose Deleted Successfully');
    }
}
