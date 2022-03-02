<?php

namespace App\Http\Controllers\Admin\Modules\ManageTreatment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Treatment;
use App\Models\GemstoneToTreatment;
use Illuminate\Support\Str;
class TreatmentController extends Controller
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
    	$data['treatments'] = Treatment::orderby('id','desc');
    	if (@$request->name) {
    		$data['treatments'] = $data['treatments']->where('name','LIKE','%'.request('name').'%');
    	}
    	$data['treatments'] = $data['treatments']->paginate(10);
    	return view('admin.modules.treatment.manage_treatment',$data);
    }

    public function addView()
    {
    	return view('admin.modules.treatment.add_treatment');
    }

    public function add(Request $request)
    {
    	$treatment = new Treatment;
    	$treatment->name = $request->name;
    	$treatment->save();
        $update = Treatment::where('id',$treatment->id)->update([
            'slug'=> str_slug($request->name).'-'.$treatment->id
        ]);
    	return redirect()->back()->with('success','Treatment Added Successfully');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = Treatment::where('name',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = Treatment::where('name',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }


    public function editView($id)
    {
    	$check = Treatment::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
        }
        $data = Treatment::where('id',$id)->first();
        return view('admin.modules.treatment.edit_treatment',compact('data'));
    }

    public function update(Request $request)
    {
        $data = Treatment::where('id',$request->id)->first();

    	$upd = [];
        $upd['name'] = $request->name;
        if (@$data->slug=="N"){
            $upd['slug'] = 'N';
        }elseif (@$data->slug=="H") {
            $upd['slug'] = 'H';
        }
        elseif (@$data->slug=="T") {
            $upd['slug'] = 'T';
        }else{
            
           $upd['slug'] = str_slug($request->name).'-'.$data->id;
        }
        $update = Treatment::where('id',$request->id)->update($upd);
    	return redirect()->back()->with('success','Treatment Updated Successfully');
    }

    public function delete($id)
    {
    	$check = Treatment::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
        }

        $check2 = GemstoneToTreatment::where('treatment',$check->slug)->first();
        if (@$check2!="") {
           return redirect()->back()->with('error','Treatment Can Not Be Deleted As It Is Associated With Gemstone');
        }
        $delete = Treatment::where('id',$id)->delete();
        return redirect()->back()->with('success','Treatment Deleted Successfully');
    }


}
