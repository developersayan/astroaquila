<?php

namespace App\Http\Controllers\Admin\Modules\ManageColor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GemstoneColor;
use App\Models\Products;
class ManageColorController extends Controller
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
    	$data['colors'] = GemstoneColor::orderby('id','desc');
    	if (@$request->name) {
    		$data['colors'] = $data['colors']->where('color','LIKE','%'.request('name').'%');
    	}
    	$data['colors'] = $data['colors']->paginate(10);
    	return view('admin.modules.manage_color.manage_color',$data);
    }

    public function addView()
    {
    	return view('admin.modules.manage_color.add_color');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = GemstoneColor::where('color',$request->name)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = GemstoneColor::where('color',$request->name)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }


    public function add(Request $request)
    {
    	$color = new GemstoneColor;
    	$color->color = $request->name;
    	$color->save();
    	return redirect()->back()->with('success','Color Added Successfully');
    }

    public function delete($id)
    {
    	$check = GemstoneColor::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
        $check2 = Products::where('color_id',$id)->first();
        if (@$check2!="") 
        {
            return redirect()->back()->with('error','Color Can Not Be Deleted As It Is Associated With Gemstone');
        }
    	$delete = GemstoneColor::where('id',$id)->delete();
    	return redirect()->back()->with('success','Color Deleted Successfully');
    }

    public function edit($id)
    {
    	$check = GemstoneColor::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['data'] = $check;
    	return view('admin.modules.manage_color.edit_color',$data); 
    }

    public function updated(Request $request)
    {
    	$check = GemstoneColor::where('id',$request->id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$updated = GemstoneColor::where('id',$request->id)->update(['color'=>$request->name]);
    	return redirect()->back()->with('success','Color Updated Successfully');
    }






}
