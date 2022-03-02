<?php

namespace App\Http\Controllers\Admin\Modules\RingSize;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RingSystem;
use App\Models\RingSize;
class RingSizeController extends Controller
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
    	$data['system'] = RingSystem::orderBy('ring_size_system','asc')->get();
    	$data['rings'] = RingSize::orderBy('id','desc');
    	if (@$request->ring) {
    		$data['rings'] = $data['rings']->where('ring_size_system_id',request('ring'));
    	}
    	if (@$request->keyword) {
    		$data['rings'] = $data['rings']->where('ring_size','LIKE','%'.request('keyword').'%');
    	}
    	$data['rings'] = $data['rings']->paginate(10);
    	return view('admin.modules.ring_size.manage_ring_size',$data);
    }

    public function addView(Request $request)
    {
       $data = [];
       $data['rings'] = RingSystem::orderBy('ring_size_system','asc')->get();
       return view('admin.modules.ring_size.add_ring_size',$data);
    }

    public function add(Request $request)
    {
    	$ring = new RingSize;
    	$ring->ring_size_system_id = $request->ring;
    	$ring->ring_size = $request->name;
    	$ring->save();
    	return redirect()->back()->with('success','Ring Size Added Successfully');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
          $check = RingSize::where('ring_size_system_id',$request->ring)->where('ring_size',$request->name)->where('id','!=',$request->id)->first();
            if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }
          
              
          }else{
             $check = RingSize::where('ring_size_system_id',$request->ring)->where('ring_size',$request->name)->first();
             if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }
              
          }
    }

    public function delete($id)
    {
    	$check = RingSize::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$del = RingSize::where('id',$id)->delete();
    	return redirect()->back()->with('success','Ring Size Deleted Successfully');
    }

    public function edit($id)
    {
    	$check = RingSize::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['rings'] = RingSystem::orderBy('ring_size_system','asc')->get();
    	$data['data'] = RingSize::where('id',$id)->first();
    	return view('admin.modules.ring_size.edit_ring_size',$data); 
    }

    public function update(Request $request)
    {
    	$update = RingSize::where('id',$request->id)->update(['ring_size_system_id'=>$request->ring,'ring_size'=>$request->name]);
    	return redirect()->back()->with('success','Ring Size Updated Successfully');
    }



}
