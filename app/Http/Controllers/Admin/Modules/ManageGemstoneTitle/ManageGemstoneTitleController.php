<?php

namespace App\Http\Controllers\Admin\Modules\ManageGemstoneTitle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GemstoneTitle;
use App\Models\Products;
class ManageGemstoneTitleController extends Controller
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
    	$data['alltitle'] = GemstoneTitle::orderBy('id','desc');
    	if (@$request->title) {
    		$data['alltitle'] = $data['alltitle']->where('parent_id',$request->title);
    	}
    	if (@$request->keyword) {
    		$data['alltitle'] = $data['alltitle']->where('title','LIKE','%'.request('keyword').'%');
    	}
    	if (@$request->type) {
    		if(@$request->type=='T'){
    			// return @$request->type;
    		$data['alltitle'] = $data['alltitle']->where('parent_id','=',0);
    	    }else{
    	    	$data['alltitle'] = $data['alltitle']->where('parent_id','>',0);
    	    }
    	}
    	$data['alltitle'] = $data['alltitle']->paginate(10);
    	$data['title'] = GemstoneTitle::where('parent_id',0)->orderBy('title','asc')->get();
    	return view('admin.modules.manage_gemstone_title.manage_gemstone_title',$data);
    }

    public function titleAddView()
    {	
    	return view('admin.modules.manage_gemstone_title.add_gemstone_title');
    }

    public function titleAdd(Request $request)
    {
    	$title = new GemstoneTitle;
    	$title->title = $request->title;
    	$title->parent_id = 0;
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/gemstone_title/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $title->image = $img;
        }
    	$title->save();
    	return redirect()->back()->with('success','Gemstone Title Added Successfully');
    }

    public function check(Request $request)
    {
    	  if (@$request->id) {
	      $check = GemstoneTitle::where('title',$request->title)->where('id','!=',$request->id)->first();
	      if (!empty($check)) {
	           echo "false";
	      }else{
	           echo "true";
	      }
	          
	      }else{
	         $check = GemstoneTitle::where('title',$request->title)->first();
	          if (!empty($check)) {
	               echo "false";
	          }else{
	               echo "true";
	          }
	      }
    }


    public function titleEditView($id)
    {
    	$check = GemstoneTitle::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['data'] = $check;
    	$data['title'] =  GemstoneTitle::where('parent_id',0)->orderBy('title','asc')->get();
    	if ($check->parent_id==0) {
    		return view('admin.modules.manage_gemstone_title.edit_gemstone_title',$data);
    	}else{
			return view('admin.modules.manage_gemstone_title.edit_gemstone_sub_title',$data);
    	}

    }


    public function titleUpdate(Request $request)
    {
        $title = GemstoneTitle::where('id',$request->id)->first();
    	$upd['title'] = $request->title;
        if ($request->profile_picture) {

            @unlink(storage_path('app/public/gemstone_title/' . $title->image));
            
            $destinationPath = "storage/app/public/gemstone_title/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
        }
        $update = GemstoneTitle::where('id',$request->id)->update($upd);
    	return redirect()->back()->with('success','Gemstone Title Updated Successfully');
    }

    public function subtitleAddView()
    {
    	$data = [];
    	$data['title'] = GemstoneTitle::where('parent_id',0)->orderBy('title','asc')->get();
    	return view('admin.modules.manage_gemstone_title.add_gemstone_sub_title',$data);
    }

    public function subtitleAdd(Request $request)
    {
    	$title = new GemstoneTitle;
    	$title->parent_id = $request->title;
    	$title->title = $request->subtitle;
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/gemstone_title/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $title->image = $img;
        }
    	$title->save();
    	return redirect()->back()->with('success','Gemstone Sub Title Added Successfully');
    }

    public function subtitleCheck(Request $request)
    {
    	if (@$request->id){
            $check = GemstoneTitle::where('parent_id',$request->title)->where('title',$request->subtitle)->where('id','!=',$request->id)->first();
            if ($check!="") {
            echo "found";
            }
        }else{
        $check = GemstoneTitle::where('parent_id',$request->title)->where('title',$request->subtitle)->first();
            if ($check!="") {
                echo "found";
        }
     } 
    
    }

    public function subtitleUpdate(Request $request)
    {
        $title = GemstoneTitle::where('id',$request->id)->first();
        $upd['parent_id'] = $request->title;
        $upd['title'] = @$request->subtitle;
    	if ($request->profile_picture) {

            @unlink(storage_path('app/public/gemstone_title/' . $title->image));
            
            $destinationPath = "storage/app/public/gemstone_title/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
        }
        $update = GemstoneTitle::where('id',$request->id)->update($upd);
    	return redirect()->back()->with('success','Gemstone Sub Title Updated Successfully');

    }

    public function delete($id)
    {
    	$check  = GemstoneTitle::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	if ($check->parent_id!=0) {
            $titlecheck = Products::where('subtitle_id',$id)->first();
            if ($titlecheck!="") {
               return redirect()->back()->with('error','Sub Title Can Not Be Deleted As It Is Associated With Gemstone.');
             } 
    		$delete = GemstoneTitle::where('id',$id)->delete();
    		return redirect()->back()->with('success','Sub Title Deleted Successfully');
    	}else{
    		$check2 = GemstoneTitle::where('parent_id',$id)->first();
    		if ($check2!="") {
    			return redirect()->back()->with('error','Title Can Not Be Deleted As It Is Associated With Sub Title');
    		}
             $titlecheck = Products::where('title_id',$id)->first();
            if ($titlecheck!="") {
               return redirect()->back()->with('error','Title Can Not Be Deleted As It Is Associated With Gemstone.');
             } 
    		$delete = GemstoneTitle::where('id',$id)->delete();
    		return redirect()->back()->with('success','Title Deleted Successfully');
    	}

    }

    public function deleteImage(Request $request)
    {
        $title = GemstoneTitle::where('id',$request->id)->first();
        @unlink(storage_path('app/public/gemstone_title/' . $title->image));
        GemstoneTitle::where('id',$request->id)->update(['image'=>'']);
        echo "success";
    }






}
