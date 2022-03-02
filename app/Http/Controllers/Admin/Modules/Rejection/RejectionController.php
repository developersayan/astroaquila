<?php

namespace App\Http\Controllers\Admin\Modules\Rejection;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rejection;
class RejectionController extends Controller
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
    	$data['data'] = Rejection::orderBy('id','desc');
    	if (@$request->name) {
    		$data['data'] = $data['data']->where('title','LIKE','%'.request('name').'%');
    	}
    	$data['data'] = $data['data']->paginate(10);
    	return view('admin.modules.rejection.manage_rejection',$data);
    }

    public function addView(Request $request)
    {
    	return view('admin.modules.rejection.add');
    }

    public function check(Request $request)
    {
    	   if (@$request->id) {
	      $check = Rejection::where('title',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = Rejection::where('title',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function add(Request $request)
    {
    	$insert = new Rejection;
    	$insert->title = $request->name;
    	$insert->save();
    	return redirect()->back()->with('success','Reason Added Successfully');
    }

    public function edit($id)
    {
    	$data = [];
    	$data['data'] = Rejection::where('id',$id)->first();
    	return view('admin.modules.rejection.edit',$data);
    }

    public function update(Request $request)
    {
    	Rejection::where('id',$request->id)->update(['title'=>@$request->name]);
    	return redirect()->back()->with('success','Reason Updated Successfully');
    }

    public function delete($id)
    {
    	Rejection::where('id',$id)->delete();
    	return redirect()->back()->with('success','Reason Deleted Successfully');
    }


}
