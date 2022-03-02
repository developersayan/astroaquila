<?php

namespace App\Http\Controllers\Admin\Modules\PujaCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PujaCategory;
use App\Models\Puja;
class PujaCategoryController extends Controller
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
        $data['parent'] = PujaCategory::where('status','!=','D')->orderBy('name','asc')->where('parent_id',0)->get();
    	$data['category'] = PujaCategory::where('status','!=','D')->orderBy('id','desc');
    	if (@$request->category_name) {
    		$data['category'] = $data['category']->where('name','LIKE','%'.@$request->category_name.'%');
    	}
        if (@$request->category) {
            $data['category'] = $data['category']->where('parent_id',@$request->category);
        }
    	$data['category'] = $data['category']->paginate(10);
    	return view('admin.modules.pujaCategory.manage_category',$data);
    }

    public function addView()
    {
    	return view('admin.modules.pujaCategory.add_puja_category');
    }

    public function check(Request $request)
    {
    	if (@$request->id) {
	      $check = PujaCategory::where('name',$request->category_name)->where('status','!=','D')->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = PujaCategory::where('name',$request->category_name)->where('status','!=','D')->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }

    public function addPujaCat(Request $request)
    {
    	$cat = new PujaCategory;
    	$cat->name = $request->category_name;
    	$cat->status = 'A';
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/puja_cat_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $cat->image = $img;
        }
    	$cat->save();
    	$update = PujaCategory::where('id',$cat->id)->update([
            'slug'=> str_slug($request->category_name).'-'.$cat->id,
        ]);
        return redirect()->back()->with('success','Puja Catgeory Added Successfully');
    }


    public function editView($id)
    {
        $data = [];
    	$data['data'] = PujaCategory::where('id',$id)->first();
    	if (@$data==null) {
    		return redirect()->back();
    	}
        if ($data['data']->parent_id==0) {
            return view('admin.modules.pujaCategory.edit_puja_category',$data);
        }else{
           
            $data['category'] = PujaCategory::where('parent_id',0)->get();
            // return $data['data'];
            return view('admin.modules.pujaCategory.edit_puja_sub_category',$data);
        }
    	
    }

    public function updateCat(Request $request)
    {
        $cat = PujaCategory::where('id', $request->id)->first();
    	$request->validate([
     		'category_name'=>'required',
     	]);
     	$update = PujaCategory::where('id', $request->id)->update([
     		'name'=>$request->category_name,
     		'slug'=> str_slug($request->category_name).'-'.$request->id,
     	]);
        if ($request->profile_picture) {
            $upd =[];
            @unlink(storage_path('app/public/puja_cat_image/' . $cat->image));
            $destinationPath = "storage/app/public/puja_cat_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
            PujaCategory::where('id', $request->id)->update($upd);
           }

     	return redirect()->back()->with('success','Puja Category Updated Successfully');
    }

    public function deletePuja($id)
    {
    	$data = PujaCategory::where('id',$id)->first();
    	if (@$data==null) {
    		return redirect()->back();
    	}
        if ($data->parent_id==0) {
        $subcheck =  PujaCategory::where('parent_id',$id)->first();
        if ($subcheck!="") {
            return redirect()->back()->with('error','Puja Category Can Not Be Deleted As It Is Associated With Sub Category');
        }
        $check = Puja::where('puja_category',$id)->where('status','!=','D')->first();
        if ($check!="") {
            return redirect()->back()->with('error','Puja Category Can Not Be Deleted As It Is Associated With Puja');
        }
        $delete = PujaCategory::where('id',$id)->update(['status'=>'D']);
        return redirect()->back()->with('success','Puja Category Deleted Successfully');

        }else{
            $getdata = Puja::where('puja_sub_category',$id)->first();
            if (@$getdata!="") {
               return redirect()->back()->with('error','Puja Sub Category Can Not Be Deleted As It Is Associated With Puja');
            }
             $delete = PujaCategory::where('id',$id)->update(['status'=>'D']);
             return redirect()->back()->with('success','Puja Sub Category Deleted Successfully');

        }
    }


    public function subCatAddView()
    {
        $data['category'] = PujaCategory::where('parent_id',0)->get();
        return view('admin.modules.pujaCategory.add_puja_sub_category',$data);
    }

    public function subCatCheck(Request $request)
    {
       if (@$request->id){
            $check = PujaCategory::where('parent_id',$request->category)->where('name',$request->name)->where('id','!=',$request->id)->where('status','!=','D')->first();
            if ($check!="") {
            echo "found";
            }
        }else{
        $check = PujaCategory::where('parent_id',$request->category)->where('name',$request->name)->where('status','!=','D')->first();
            if ($check!="") {
                echo "found";
        }
      }
    }

    public function subCatAdd(Request $request)
    {
        $pujaCat = new PujaCategory;
        $pujaCat->parent_id = $request->category;
        $pujaCat->name = $request->name;
        $pujaCat->status = 'A';
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/puja_cat_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $pujaCat->image = $img;
        }
        $pujaCat->save();
        $update = PujaCategory::where('id',$pujaCat->id)->update([
            'slug'=> str_slug($request->name).'-'.$pujaCat->id,
        ]);
        return redirect()->back()->with('success','Sub Category Added Successfully');
    }

    public function subCatUpdate(Request $request)
    {
        // return $request;
        $upd = [];
        $upd['name'] = $request->name;
        $upd['parent_id'] = $request->category;
         $upd['slug']= str_slug($request->name).'-'.$request->id;
         if ($request->profile_picture) {
            @unlink(storage_path('app/public/puja_cat_image/' . $cat->image));
            $destinationPath = "storage/app/public/puja_cat_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
        }
        PujaCategory::where('id',$request->id)->update($upd);
        return redirect()->back()->with('success','Sub Category Updated Successfully');
    }

    public function deleteImage(Request $request)
    {
        PujaCategory::where('id',$request->id)->update(['image'=>'']);
        echo "success";
    }



}
