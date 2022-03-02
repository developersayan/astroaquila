<?php

namespace App\Http\Controllers\Admin\Modules\RingSystem;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RingSystem;
use App\Models\RingSize;
class RingSystemController extends Controller
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
    	$data =[];
    	$data['rings'] = RingSystem::orderBy('id','desc');
    	if (@$request->keyword) {
    		$data['rings'] = $data['rings']->where('ring_size_system','LIKE','%'.request('keyword').'%');
    	}
    	$data['rings'] = $data['rings']->paginate(10);
    	return view('admin.modules.ring_system.manage_ring_system',$data);	
    }

    public function addView()
    {
    	return view('admin.modules.ring_system.add_ring_system');
    }

    public function check(Request $request)
    {
    	   if (@$request->id) {
	      $check = RingSystem::where('ring_size_system',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = RingSystem::where('ring_size_system',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function add(Request $request)
    {
    	$ring = new RingSystem;
    	$ring->ring_size_system = $request->name;
    	$ring->save();
    	return redirect()->back()->with('success','Ring System Added Successfully');
    }

    public function delete($id)
    {
    	$check = RingSystem::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
        $check2 = RingSize::where('ring_size_system_id',$id)->first();
        if ($check2!="") {
            return redirect()->back()->with('error','Ring System Can Not Be Deleted As It Has Ring Size');
        }
    	$delete = RingSystem::where('id',$id)->delete();
    	return redirect()->back()->with('success','Ring system deleted successfully');
    }

    public function edit($id)
    {
    	$check = RingSystem::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = RingSystem::where('id',$id)->first();
    	return view('admin.modules.ring_system.edit_ring_system',compact('data'));
    }

    public function update(Request $request)
    {
    	$update = RingSystem::where('id',$request->id)->update(['ring_size_system'=>$request->name]);
    	return redirect()->back()->with('success','Ring System Updated Successfully');
    }


}
