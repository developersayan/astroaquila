<?php

namespace App\Http\Controllers\Admin\Modules\CirtificateName;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CertificationName;
use App\Models\Cirtificate;
use App\Models\Products;
class CirtificateNameController extends Controller
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
    	$data['cirtificate'] = CertificationName::orderBy('id','desc');
    	if (@$request->cirtificate_name) {
    		$data['cirtificate'] = $data['cirtificate']->where('cert_name','LIKE','%'.request('cirtificate_name').'%');
    	}
    	$data['cirtificate'] = $data['cirtificate']->paginate(10);
    	return view('admin.modules.cirtificate_name.manage_cirtificate_name',$data);
    }

    public function addView()
    {
    	return view('admin.modules.cirtificate_name.add_cirtificate_name');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = CertificationName::where('cert_name',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = CertificationName::where('cert_name',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }


    public function add(Request $request)
    {
    	$cirtificate = new CertificationName;
    	$cirtificate->cert_name = $request->name;
        $cirtificate->no_of_days = $request->days;
    	$cirtificate->save();
    	return redirect()->back()->with('success','Cirtificate  Added Successfully');
    }

    public function delete($id)
    {
    	$check = CertificationName::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$check2 = Cirtificate::where('certificate_id',$id)->first();
    	if (@$check2!="") {
    		return redirect()->back()->with('error','Cirtificate  Can Not Be Deleted As It Has Price In It');
    	}
        $check3 = Products::where('laboratory_name',$id)->first();
        if (@$check3!="") {
            return redirect()->back()->with('error','Cirtificate  Can Not Be Deleted As It Is Associated With Product');
        }
    	$delete = CertificationName::where('id',$id)->delete();
    	return redirect()->back()->with('success','Cirtificate  Deleted Successfully');
    }


    public function editView($id)
    {
    	$check = CertificationName::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = CertificationName::where('id',$id)->first();
    	return view('admin.modules.cirtificate_name.edit_cirtificate_name',compact('data'));
    }


    public function update(Request $request)
    {
    	$update = CertificationName::where('id',$request->id)->update(['cert_name'=>$request->name,'no_of_days'=>$request->days]);
    	return redirect()->back()->with('success','Cirtificate Updated Successfully'); 
    }


}
