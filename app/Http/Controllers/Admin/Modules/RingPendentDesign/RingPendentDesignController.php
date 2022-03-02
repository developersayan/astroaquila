<?php

namespace App\Http\Controllers\Admin\Modules\RingPendentDesign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RingPendentDesign;
class RingPendentDesignController extends Controller
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
    	$data['design'] = RingPendentDesign::orderBy('id','desc');
    	if (@$request->keyword) {
    		$data['design'] = $data['design']->where('design_name','LIKE','%'.request('keyword').'%');
    	}
    	if (@$request->type) {
    		$data['design'] = $data['design']->where('type',$request->type);
    	}
    	$data['design'] = $data['design']->paginate(10);
    	return view('admin.modules.ring_pendent_design.manage_ring_pendent_design',$data);
    }

    public function addView()
    {
    	return view('admin.modules.ring_pendent_design.add_ring_pendent_design');
    }

    public function check(Request $request)
    {
    	 if (@$request->id) {
          $check = RingPendentDesign::where('design_name',$request->name)->where('type',$request->type)->where('id','!=',$request->id)->first();
            if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }
          
              
          }else{
             $check = RingPendentDesign::where('design_name',$request->name)->where('type',$request->type)->first();
             if ($check!="") {
                 echo "found";
             }else{
                echo "not found";
             }
              
          }
    }


    public function add(Request $request)
    {
    	$design = new RingPendentDesign;
    	$design->design_name = $request->name;
    	$design->type = $request->type;
    	if ($request->profile_picture) {
            $destinationPath = "storage/app/public/ring_pendent_design/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $design->design_image = $img;
        }
        $design->save();
        return redirect()->back()->with('success','Design Added Successfully');
    }


    public function delete($id)
    {
    	$check = RingPendentDesign::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
        @unlink('storage/app/public/ring_pendent_design/' .$check->design_image);
    	$delete = RingPendentDesign::where('id',$id)->delete();
    	return redirect()->back()->with('success','Design Deleted Successfully');
    }


    public function editView($id)
    {
    	$check = RingPendentDesign::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['data'] = $check;
    	return view('admin.modules.ring_pendent_design.edit_ring_pendent_design',$data);
    }

    public function update(Request $request)
    {
    	$upd = [];
    	$details = RingPendentDesign::where('id',$request->id)->first();
    	$upd['design_name'] = $request->name;
        $upd['type'] = $request->type;
    	if ($request->profile_picture) {
			@unlink(storage_path('app/public/ring_pendent_design/' . $details->design_image));
            $destinationPath = "storage/app/public/ring_pendent_design/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['design_image'] = $img;
        }
        RingPendentDesign::where('id',$request->id)->update($upd);
        return redirect()->back()->with('success','Design Updated Successfully');
    }

    public function deleteImage(Request $request)
    {
        $details = RingPendentDesign::where('id',$request->id)->first();
        @unlink(storage_path('app/public/ring_pendent_design/' . $details->design_image));
        RingPendentDesign::where('id',$request->id)->update(['design_image'=>'']);
        echo "success";
    }
}
