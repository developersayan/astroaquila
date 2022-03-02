<?php

namespace App\Http\Controllers\Admin\Modules\BlogCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Blog;
class BlogCatgeoryController extends Controller
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


     /**
     *   Method      : index
     *   Description : manage blog category
     *   Author      : Sayan
     *   Date        : 2021-JUL-12
     **/

     public function index(Request $request)
     {
     	$data = [];
     	$data['category'] = BlogCategory::where('status','!=','D');
     	if (@$request->category_name) {
     		$data['category'] = $data['category']->where('category','LIKE','%'.@$request->category_name.'%');
     	}
     	if(@$request->status){
            $data['category']= $data['category']->where('status', @$request->status);
        }
        $data['category'] = $data['category']->orderBy('id','desc')->paginate(10);
     	return view('admin.modules.blogCategory.manage_blog_category',$data);
     }

     public function addview(Request $request)
     {
     	return view('admin.modules.blogCategory.add_blog_category');
     }

     public function addCategory(Request $request)
     {
     	$request->validate([
     		'category_name'=>'required',
     	]);
     	$category = new BlogCategory;
     	$category->category = $request->category_name;
     	$category->status = 'A';
     	$category->save();
     	$update = BlogCategory::where('id',$category->id)->update([
            'slug'=> str_slug($request->category_name).'-'.$category->id,
        ]);
     	return redirect()->back()->with('success','Blog Catgeory Added Successfully');
     }

     public function check(Request $request)
     {
	     if (@$request->id) {
	      $check = BlogCategory::where('category',$request->category_name)->where('status','!=','D')->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = BlogCategory::where('category',$request->category_name)->where('status','!=','D')->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
     }

     public function status($id)
     {
     	$category = BlogCategory::where('status', '!=', 'D')->where('id', $id)->first();
        if (@$category) {
            if($category->status=='I'){
                $upd['status'] = 'A';
                BlogCategory::where('id', $category->id)->update($upd);
                session()->flash('success', 'Blog Category Activated Successfully');
            }
            if($category->status=='A'){
                $upd['status'] = 'I';
                BlogCategory::where('id', $category->id)->update($upd);
                session()->flash('success', 'Blog Category Deactivated Successfully');
            }
            return redirect()->back();
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
     }


     public function deleteCategory($id)
     {
     	$category = BlogCategory::where('status', '!=', 'D')->where('id', $id)->first();
        if (@$category) {
            $check = Blog::where('category_id',$id)->where('status','!=','D')->first();
            if ($check!="") {
                return redirect()->back()->with('error','Blog Category Can Not Be Deleted As It Is Associated With Blog');
            }
            $upd['status'] = 'D';
            BlogCategory::where('id', $category->id)->update($upd);
            session()->flash('success', 'Blog Category Deleted Successfully');
            return redirect()->back();
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
     }

     public function editView($id)
     {
     	$data = [];
     	$data['category'] = BlogCategory::where('status', '!=', 'D')->where('id', $id)->first();
     	return view('admin.modules.blogCategory.edit_blog_category',$data);
     }

     public function updateCategory(Request $request)
     {
     	$request->validate([
     		'category_name'=>'required',
     	]);
     	$update = BlogCategory::where('id', $request->cat_id)->update([
     		'category'=>$request->category_name,
     		'slug'=> str_slug($request->category_name).'-'.$request->cat_id,
     	]);
     	return redirect()->back()->with('success','Blog Category Updated Successfully');
     }

    
}
