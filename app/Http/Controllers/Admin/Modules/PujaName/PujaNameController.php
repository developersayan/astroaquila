<?php

namespace App\Http\Controllers\Admin\Modules\PujaName;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PujaName;
use App\Models\Puja;
class PujaNameController extends Controller
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
    	$data['pujas'] = PujaName::orderBy('name','asc');
    	if (@$request->name) {
    		$data['pujas'] = $data['pujas']->where('name','LIKE','%'.request('name').'%');
    	}
    	$data['pujas'] = $data['pujas']->paginate(10);
    	return view('admin.modules.puja_name.manage_puja_name',$data);
    }

    public function addView()
    {
    	return view('admin.modules.puja_name.add_puja_name');
    }

    public function add(Request $request)
    {
    	$pujaname = new PujaName;
    	$pujaname->name = $request->name;
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/puja_name_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $pujaname->image = $img;
        }
    	$pujaname->save();
    	return redirect()->back()->with('success','Puja Name Added Successfully');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = PujaName::where('name',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = PujaName::where('name',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }


    public function delete($id)
    {
    	$check = PujaName::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
        $check2 = Puja::where('puja_id',$id)->where('status','!=','D')->first();
        if ($check2!=null) {
            return redirect()->back()->with('error','Puja Name Can Not Be Deleted As It Is Associated With Puja');
        }
    	$delete = PujaName::where('id',$id)->delete();
    	return redirect()->back()->with('success','Puja Name Deleted Successfully');
    }

    public function editView($id)
    {
    	$check = PujaName::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['data'] = $check;
    	return view('admin.modules.puja_name.edit_puja_name',$data);
    }

    public function update(Request $request)
    {
        $puja = PujaName::where('id',$request->id)->first();
        $upd = [];
    	$upd['name'] = @$request->name;
        if ($request->profile_picture) {

            @unlink(storage_path('app/public/puja_name_image/' . $puja->image));
            
            $destinationPath = "storage/app/public/puja_name_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
           }
           $update = PujaName::where('id',$request->id)->update($upd);
    	return redirect()->back()->with('success','Puja Name Updated Successfully');
    }

    public function deleteImage(Request $request)
    {
        PujaName::where('id',$request->id)->update(['image'=>'']);
        echo "success";
    }


}
