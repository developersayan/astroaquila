<?php

namespace App\Http\Controllers\Admin\Modules\FaqCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\Faq;
class FaqCategoryController extends Controller
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
    	$data['category'] = FaqCategory::where('parent_id',0)->get();
    	$data['allCategory'] = FaqCategory::orderBy('id','desc');
    	if (@$request->category) {
    		$data['allCategory'] = $data['allCategory']->where('parent_id',request('category'));
    	}
    	if (@$request->keyword) {
    		$data['allCategory'] = $data['allCategory']->where('faq_category','LIKE','%'.request('keyword').'%');
    	}
    	if (@$request->type) {
    		if(@$request->type=='C'){
    			// return @$request->type;
    		$data['allCategory'] = $data['allCategory']->where('parent_id','=',0);
    	    }else{
    	    	$data['allCategory'] = $data['allCategory']->where('parent_id','>',0);
    	    }
    	}
    	$data['allCategory'] = $data['allCategory']->paginate(10);
    	return view('admin.modules.faq_category.manage_faq_category',$data);
    }

    public function addCatView()
    {
    	return view('admin.modules.faq_category.add_faq_category');
    }

    public function addCat(Request $request)
    {
    	$category = new FaqCategory;
    	$category->faq_category = $request->category;
    	$category->parent_id = 0;
    	$category->save();
    	return redirect()->back()->with('success','Category Added Successfully');
    }

    public function checkCat(Request $request)
    {
    	if (@$request->id) {
	      $check = FaqCategory::where('faq_category',$request->category)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = FaqCategory::where('faq_category',$request->category)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }


    public function delete($id)
    {
    	$check = FaqCategory::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	if (@$check->parent_id==0) {
    		$parent_check = FaqCategory::where('parent_id',$id)->first();
    		if (@$parent_check!="") {
    			return redirect()->back()->with('error','Category Can Not Be Deleted As It Has Subcategory');
    		}
    		$delete = FaqCategory::where('id',$id)->delete();
    		return redirect()->back()->with('success','Category Deleted Successfully');
    	}else{
            $checksub = Faq::where('subcategory_id',$id)->first();
            if (@$checksub!="") {
                return redirect()->back()->with('error','Category Can Not Be Deleted As It Has Faq');
            }
    		$delete = FaqCategory::where('id',$id)->delete();
    		return redirect()->back()->with('success','Sub Category Deleted Successfully');
    	}
    }


    public function editView($id)
    {
    	$data = [];
    	$check = FaqCategory::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	if (@$check->parent_id==0) {
    		$data['data']  = $check;
    		return view('admin.modules.faq_category.edit_faq_category',$data);
        }else{
        	$data['category'] = FaqCategory::where('parent_id',0)->get();
        	$data['data']  = $check;
        	return view('admin.modules.faq_category.edit_faq_sub_category',$data);
        } 		
    }


    public function updateCat(Request $request)
    {
    	$update = FaqCategory::where('id',$request->id)->update(['faq_category'=>@$request->category]);
    	return redirect()->back()->with('success','Category Updated Successfully');
    }

    public function addSubCatView()
    {
    	$data = [];
    	$data['category'] = FaqCategory::where('parent_id',0)->get();
    	return view('admin.modules.faq_category.add_faq_sub_category',$data);
    }

    public function checkSubCat(Request $request)
    {
    	if (@$request->id){
            $check = FaqCategory::where('parent_id',$request->category)->where('faq_category',$request->sub_category)->where('id','!=',$request->id)->first();
            if ($check!="") {
            echo "found";
            }
        }else{
        $check = FaqCategory::where('parent_id',$request->category)->where('faq_category',$request->sub_category)->first();
            if ($check!="") {
                echo "found";
        }
     }
    }

    public function insertSubCategoy(Request $request)
    {
    	$category = new FaqCategory;
    	$category->faq_category = $request->sub_category;
    	$category->parent_id = $request->category;
    	$category->save();
    	return redirect()->back()->with('success','Sub Category Added Successfully');
    }

    public function updateSubCategoy(Request $request)
    {
    	$update = FaqCategory::where('id',$request->id)->update(['parent_id'=>$request->category,'faq_category'=>@$request->sub_category]);
    	return redirect()->back()->with('success','Sub Category Updated Successfully');
    }


}
