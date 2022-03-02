<?php

namespace App\Http\Controllers\Admin\Modules\Expertise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\AstrologerToExpertise;
class ExpertiseController extends Controller
{
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
    	$data['expertise'] = Expertise::orderBy('id','desc');
    	if (@$request->name) {
    		$data['expertise'] = $data['expertise']->where('expertise_name','LIKE','%'.request('name').'%');
    	}
    	$data['expertise'] = $data['expertise']->paginate(10);
    	return view('admin.modules.expertise.manage_expertise',$data);
    }

    public function addView()
    {
    	return view('admin.modules.expertise.add_expertise');
    }

    public function add(Request $request)
    {
    	$add = new Expertise;
    	$add->expertise_name = $request->name;
    	$add->save();
    	return redirect()->back()->with('success','Expertise Added Successfully');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = Expertise::where('expertise_name',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = Expertise::where('expertise_name',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function edit($id)
    {
    	$check = Expertise::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['data'] = $check;
    	return view('admin.modules.expertise.edit_expertise',$data);
    }

    public function update(Request $request)
    {
    	Expertise::where('id',$request->id)->update(['expertise_name'=>@$request->name]);
    	return redirect()->back()->with('success','Expertise updated successfully');
    }

    public function delete($id)
    {
    	$check = Expertise::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$check2 = AstrologerToExpertise::where('expertise_id',$id)->first();
    	if (@$check2!="") {
    		return redirect()->back()->with('error','Expertise Can Not Be Deleted As It Is Associated With Astrologer');
    	}
    	Expertise::where('id',$id)->delete();
    	return redirect()->back()->with('success','Expertise Deleted Successfully');
    }
}
