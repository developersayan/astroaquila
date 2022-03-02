<?php

namespace App\Http\Controllers\Admin\Modules\HoroscopeCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HoroscopeCategory;
use App\Models\Horoscope;
class HoroscopeCategoryController extends Controller
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
        $data['category'] = HoroscopeCategory::where('parent_id',0)->get();
        $data['data'] = HoroscopeCategory::orderBy('id','desc');
        if (@$request->name) {
         $data['data']  = $data['data']->where('name','LIKE','%'.request('name').'%');
        }
        if (@$request->category) {
          $data['data']  = $data['data']->where('parent_id',@$request->category);
        }
        $data['data']  = $data['data']->paginate(10);
        return view('admin.modules.horoscope_category.manage_category',$data);
    }

    public function addView()
    {
        return view('admin.modules.horoscope_category.add_category');
    }

    public function check(Request $request)
    {
          if (@$request->id) {
          $check = HoroscopeCategory::where('name',$request->name)->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
              
          }else{
             $check = HoroscopeCategory::where('name',$request->name)->first();
              if (!empty($check)) {
                   echo "false";
              }else{
                   echo "true";
              }
          }
    }


    public function add(Request $request)
    {
      $ins=[];
      $ins['name']=$request->name;
      $ins['parent_id'] = 0;
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/horoscope_category/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $ins['image'] = $img;
        }        
        $create=HoroscopeCategory::create($ins);
        $update = HoroscopeCategory::where('id',$create->id)->update([
            'slug'=> str_slug($request->name).'-'.$create->id
        ]);
        return redirect()->back()->with('success','Category Added Successfully');
    }

    public function delete($id)
    {
      $check = HoroscopeCategory::where('id',$id)->first();
      if (@$check==null) {
       return redirect()->back();
      }

      if ($check->parent_id==0) {
         $check2 = Horoscope::where('category_id',$id)->where('status','!=','D')->first();
        if (@$check2!="") {
          return redirect()->back()->with('error','Category Can Not Be Deleted As It Is Associated With Horoscope');
        }
        $check3  = HoroscopeCategory::where('parent_id',$id)->first();
        if ($check3!="") {
          return redirect()->back()->with('error','Category Can Not Be Deleted As It Is Associated With Sub Category');
        }
        @unlink(storage_path('app/public/horoscope_category/' . @$check->image));
        HoroscopeCategory::where('id',$id)->delete();
        return redirect()->back()->with('success','Category Deleted Successfully');
      }else{
        @unlink(storage_path('app/public/horoscope_category/' . @$check->image));
        HoroscopeCategory::where('id',$id)->delete();
        return redirect()->back()->with('success','Sub Category Deleted Successfully');
      }
      

      
    }

    public function edit($id)
    {
      $check = HoroscopeCategory::where('id',$id)->first();
      if (@$check==null) {
       return redirect()->back();
      }
      if ($check->parent_id==0) {
        $data = [];
        $data['data'] = $check;
        return view('admin.modules.horoscope_category.edit_category',$data);
      }else{
        $data = [];
        $data['category'] = HoroscopeCategory::where('parent_id',0)->get(); 
        $data['data'] = $check;
        return view('admin.modules.horoscope_category.edit_sub_category',$data);
      }
      
    }

    public function update(Request $request)
    {
            $category = HoroscopeCategory::where('id', $request->id)->first();
            $upd = [];
            $upd['name'] = $request->name;
            if ($request->profile_picture) {

            @unlink(storage_path('app/public/horoscope_category/' . $category->image));
            
            $destinationPath = "storage/app/public/horoscope_category/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
            }
            $upd['slug'] = str_slug($request->name).'-'.$request->id;
            HoroscopeCategory::where('id', $request->id)->update($upd);
            return redirect()->back()->with('success','Category Updated Successfully');
    }



    public function addSubCategory()
    {
      $data = [];
      $data['category'] = HoroscopeCategory::where('parent_id',0)->get();
      return view('admin.modules.horoscope_category.add_sub_category',$data);
    }


    public function insertSubCategory(Request $request)
    {
      $ins = [];
      $ins['name'] = $request->name;
      $ins['parent_id'] = $request->category;
      if ($request->profile_picture) {
           $destinationPath = "storage/app/public/horoscope_category/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $ins['image'] = $img;
        }
      $create=HoroscopeCategory::create($ins);
      $update = HoroscopeCategory::where('id',$create->id)->update([
            'slug'=> str_slug($request->name).'-'.$create->id
      ]);
      return redirect()->back()->with('success','Sub Category Added Successfully');
    }


    public function updateSubCategory(Request $request)
    {
           $category = HoroscopeCategory::where('id', $request->id)->first();
            $upd = [];
            $upd['name'] = $request->name;
            $upd['parent_id'] = $request->category;
            if ($request->profile_picture) {

            @unlink(storage_path('app/public/horoscope_category/' . $category->image));
            
            $destinationPath = "storage/app/public/horoscope_category/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
            }
            $upd['slug'] = str_slug($request->name).'-'.$request->id;
            HoroscopeCategory::where('id', $request->id)->update($upd);
            return redirect()->back()->with('success','Category Updated Successfully');
    }


    public function checkSubCategory(Request $request){
        if (@$request->id){
            $check = HoroscopeCategory::where('parent_id',$request->category)->where('name',$request->name)->where('id','!=',$request->id)->first();
            if ($check!="") {
            echo "found";
            }
        }else{
        $check = HoroscopeCategory::where('parent_id',$request->category)->where('name',$request->name)->first();
            if ($check!="") {
                echo "found";
        }
     }
    }


    public function deleteImage(Request $request)
    {
      $check = HoroscopeCategory::where('id',$request->id)->first();
      @unlink(storage_path('app/public/horoscope_category/' . @$check->image));
      HoroscopeCategory::where('id',$request->id)->update(['image'=>'']);
      echo "success";
    }

    
}
