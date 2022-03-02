<?php

namespace App\Http\Controllers\Admin\Modules\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Support\Str;
class ProductCategoryController extends Controller
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
     *   Description : manage Product Category
     *   Author      : Soumojit
     *   Date        : 2021-APR-28
     **/
    public function index(Request $request)
    {
        $data['category'] = ProductCategory::where('label','C')->where('status','A')->orderBy('name','asc')->get(); 
        $productCategory= ProductCategory::where('status','!=','D')->orderBy('id','desc');
        if(@$request->all()){
            if(@$request->status){
                $productCategory= $productCategory->where('status', @$request->status);
            }
            if(@$request->category){
                // return @$request->category;
                $productCategory= $productCategory->where('parent_id', @$request->category);
            }
            if(@$request->keyword){
                $productCategory= $productCategory->where('name', 'like','%'.@$request->keyword.'%');
            }
            $data['key']= @$request->all();
        }
        $data['AllProductCategory']=$productCategory->paginate(10);

        return view('admin.modules.productCategory.manage_product_category')->with($data);
    }
    /**
     *   Method      : addProductCategory
     *   Description : Product Category Add view page
     *   Author      : Soumojit
     *   Date        : 2021-APR-28
     **/
    public function addProductCategory()
    {
        return view('admin.modules.productCategory.add_product_category');
    }
    /**
     *   Method      : addProductCategorySave
     *   Description : Product Category save
     *   Author      : Soumojit
     *   Date        : 2021-APR-28
     **/
    public function addProductCategorySave(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
        $ins=[];
        $ins['name']=$request->category_name;
        $ins['parent_id']=0;
        $ins['label']='C';
        $ins['description']=$request->description;
        $ins['meta_title']=$request->meta_title;
        $ins['meta_description']=$request->meta_description;
        $ins['category_slug'] = Str::slug($request->category_name);
        $ins['status']='A';
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/product_category_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $ins['image'] = $img;
        }
        $create=ProductCategory::create($ins);
        if(@$create){
            session()->flash('success', 'Product category added successfully');
            return redirect()->route('admin.product.category.manage');
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back()->withInput($request->input());
    }
    /**
     *   Method      : editProductCategory
     *   Description : Product Category Edit view page
     *   Author      : Soumojit
     *   Date        : 2021-APR-28
     **/
    public function editProductCategory($id=null)
    {
        $productCategory = ProductCategory::where('status', '!=', 'D')->where('id',$id)->first();
        if(@$productCategory){
            $data['productCategory']= $productCategory;
            return view('admin.modules.productCategory.edit_product_category')->with($data);
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
    }
    /**
     *   Method      : editProductCategorySave
     *   Description : Product Category edit value update
     *   Author      : Soumojit
     *   Date        : 2021-APR-28
     **/
    public function editProductCategorySave(Request $request,$id = null)
    {
       
        $productCategory = ProductCategory::where('status', '!=', 'D')->where('id', $id)->first();
        if (@$productCategory) {
            $upd = [];
            $upd['name'] = $request->category_name;
            $upd['description'] = $request->description;
            $upd['meta_title'] = $request->meta_title;
            $upd['meta_description'] = $request->meta_description;
            $upd['category_slug'] = Str::slug($request->category_name);
            $upd['parent_id']=0;
            $upd['label']='C';
            if ($request->profile_picture) {

            @unlink(storage_path('app/public/product_category_image/' . $productCategory->image));
            
            $destinationPath = "storage/app/public/product_category_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
           }
            $create = ProductCategory::where('id', $productCategory->id)->update($upd);
            if (@$create) {
                session()->flash('success', 'Product category updated successfully');
                return redirect()->route('admin.product.category.edit',['id'=> $productCategory->id]);
            }
            session()->flash('error', 'Something went wrong');
            return redirect()->back()->withInput($request->input());
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
    }
    /**
     *   Method      : statusChangeProductCategory
     *   Description : Product Category status change
     *   Author      : Soumojit
     *   Date        : 2021-APR-28
     **/
    public function statusChangeProductCategory($id = null)
    {
        $productCategory = ProductCategory::where('status', '!=', 'D')->where('id', $id)->first();
        if (@$productCategory) {
            if($productCategory->status=='I'){
                $upd['status'] = 'A';
                ProductCategory::where('id', $productCategory->id)->update($upd);
                session()->flash('success', 'Product Category Activated Successfully');
            }
            if($productCategory->status=='A'){
                $upd['status'] = 'I';
                ProductCategory::where('id', $productCategory->id)->update($upd);
                session()->flash('success', 'Product Category Deactivated Successfully');
            }
            return redirect()->back();
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
    }
    /**
     *   Method      : deleteProductCategory
     *   Description : Product Category delete
     *   Author      : Soumojit
     *   Date        : 2021-APR-28
     **/
    public function deleteProductCategory($id = null)
    {
        $productCategory = ProductCategory::where('status', '!=', 'D')->where('id', $id)->first();

        if ( $productCategory==null) {
            return redirect()->back();
        }
        if ($productCategory->label=="C") {
             $check = Products::where('product_type','AP')->where('category_id',$id)->where('status','!=','D')->first();
             $check2 = ProductCategory::where('status', '!=', 'D')->where('parent_id', $productCategory->id)->first();
             if ($check2!="") {
                 return redirect()->back()->with('error','Product Category Can Not Be Deleted As It Is Associated With Sub Category');
             }
             if ($check!="") {
              return redirect()->back()->with('error','Product Category Can Not Be Deleted As It Is Associated With Product');
            }
            $upd['status'] = 'D';
            ProductCategory::where('id', $productCategory->id)->update($upd);
            session()->flash('success', 'Product Category Deleted Successfully');
            return redirect()->back();
        }

        if ($productCategory->label=="S") {
            $check = Products::where('product_type','AP')->where('sub_category_id',$id)->where('status','!=','D')->first();
            if ($check!="") {
                return redirect()->back()->with('error','Sub Category Can Not Be Deleted As It Is Associated With Product');
            }
            $upd['status'] = 'D';
            ProductCategory::where('id', $productCategory->id)->update($upd);
            session()->flash('success', 'Product Category Deleted Successfully');
            return redirect()->back();
        }
    }

     /**
     *   Method      : checkname
     *   Description : duplicate name checking
     *   Author      : Soumojit
     *   Date        : 2021-MAY-5
     **/
    public function checkname(Request $request)
    {
    
     if (@$request->id) {
      $check = ProductCategory::where('name',$request->category_name)->where('status','!=','D')->where('id','!=',$request->id)->first();
      if (!empty($check)) {
           echo "false";
      }else{
           echo "true";
      }
          
      }else{
         $check = ProductCategory::where('name',$request->category_name)->where('status','!=','D')->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
      }

   }

   public function addSubCategory()
   {
     $data = [];
     $data['category'] = ProductCategory::where('label','C')->where('status','A')->orderBy('name','asc')->get();
     return view('admin.modules.productCategory.add_product_sub_category',$data);
   }

   public function subcategoryRegister(Request $request)
   {
        $request->validate([
            'category' => 'required',
            'subcategory_name' => 'required',
        ]);
        $ins=[];
        $ins['name']=$request->subcategory_name;
        $ins['parent_id']=$request->category;
        $ins['label']='S';
        $ins['description']=$request->description;
        $ins['meta_title']=$request->meta_title;
        $ins['meta_description']=$request->meta_description;
        // $ins['category_slug'] = Str::slug($request->subcategory_name);
        $ins['status']='A';
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/product_category_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $ins['image'] = $img;
        }
        $create=ProductCategory::create($ins);
        // slug-update 
        $update = ProductCategory::where('id',$create->id)->update([
            'category_slug'=> str_slug($request->subcategory_name).'-'.$create->id,
        ]);
        if(@$create){
            session()->flash('success', 'Product sub category added successfully');
            return redirect()->route('admin.product.category.manage');
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back()->withInput($request->input());
   }

   public function editProductSubCategory($id)
   {
        $data = [];
        $productCategory = ProductCategory::where('status', '!=', 'D')->where('id',$id)->first();
        if(@$productCategory){
            $data['category'] = ProductCategory::where('label','C')->where('status','A')->orderBy('name','asc')->get();
            $data['productCategory']= $productCategory;
            return view('admin.modules.productCategory.edit_product_sub_category')->with($data);
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
   }

   public function subCategoryUpdate(Request $request)
   {
    // return $request->category_id;
    $productCategory = ProductCategory::where('status', '!=', 'D')->where('id', $request->category_id)->first();
        if (@$productCategory) {
            $upd = [];
            $upd['name'] = $request->subcategory_name;
            $upd['parent_id'] = $request->category;
            $upd['description'] = $request->description;
            $upd['meta_title'] = $request->meta_title;
            $upd['meta_description'] = $request->meta_description;
            $upd['category_slug'] = str_slug($request->subcategory_name).'-'.$request->category_id;
            $upd['label']='S';
            if ($request->profile_picture) {

            @unlink(storage_path('app/public/product_category_image/' . $productCategory->image));
            
            $destinationPath = "storage/app/public/product_category_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
           }
            $create = ProductCategory::where('id', $request->category_id)->update($upd);
            if (@$create) {
                session()->flash('success', 'Product sub category updated successfully');
                return redirect()->back();
            }
            session()->flash('error', 'Something went wrong');
            return redirect()->back()->withInput($request->input());
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
   }


    public function checksub(Request $request)
    {
        if (@$request->id){
            $check = ProductCategory::where('parent_id',$request->category)->where('name',$request->subcategory)->where('id','!=',$request->id)->where('status','!=','D')->first();
            if ($check!="") {
            echo "found";
            }
        }else{
        $check = ProductCategory::where('parent_id',$request->category)->where('status','!=','D')->where('name',$request->subcategory)->first();
            if ($check!="") {
                echo "found";
        }
    }
    
    }


    public function deleteImage(Request $request)
    {
        $productCategory = ProductCategory::where('status', '!=', 'D')->where('id', $request->id)->first();
        @unlink(storage_path('app/public/product_category_image/' . $productCategory->image));
        ProductCategory::where('id',$request->id)->update(['image'=>'']);
        echo "success";
    }




}
