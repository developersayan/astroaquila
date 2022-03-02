<?php

namespace App\Http\Controllers\Admin\Modules\SecondBanner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BannerSettings;
use App\Models\BannerDetails;
use App\Models\Animation;
class SecondBannerController extends Controller
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

    public function index()
    {
    	$data = [];
    	$data['data'] = BannerSettings::where('id',2)->first();
    	$data['images'] = BannerDetails::where('image_type','S')->paginate(10);
         $data['animation'] = Animation::orderBy('name','asc')->get();
    	return view('admin.modules.second_banner.manage_banner',$data);
    }

    public function updateSettings(Request $request)
    {
    	$upd = [];
    	$upd['setting_type'] = $request->type;
        $upd['speed'] = $request->speed;
        $upd['transition_in'] = $request->transition_in;
        $upd['transition_out'] = $request->transition_out;
        if (@$request->disable_check) {
        	$upd['enable_disable'] = 'D';
        }else{
        	$upd['enable_disable'] = 'E';
        }
    	BannerSettings::where('id',2)->update($upd);
    	return redirect()->back()->with('success','Settings Updated Successfully');
    }


    public function videoUpload(Request $request)
    {
    	$check = BannerSettings::where('id',2)->first();
    	$upd = [];
    	$upd['heading'] = $request->heading;
    	$upd['sub_heading'] = $request->sub_heading;
    	$upd['button_link'] = $request->button_link;
    	$upd['button_caption'] = $request->button_caption;
    	if ($request->hasFile('video')) {
        $file = $request->file('video');
        $unicname = time().'.'.$file->getClientOriginalExtension();
        $file->move("storage/app/public/banner_video",$unicname);
        $upd['video'] = $unicname;
        @unlink(storage_path('app/public/banner_video/' . $check->puja_video));
       } 
       BannerSettings::where('id',2)->update($upd);
       return redirect()->back()->with('success','Video Banner Settings Updated Successfully');

    }



    public function addImageView()
    {
    	return view('admin.modules.second_banner.add_image');
    }

    public function addImage(Request $request)
    {
    	$ins = [];
    	$ins['heading'] = $request->heading;
    	$ins['sub_heading'] = $request->sub_heading;
    	$ins['button_link'] = $request->button_link;
    	$ins['button_caption'] = $request->button_caption;
    	$ins['image_type'] = 'S';
    	if ($request->hasFile('image')) {
    		$file = $request->file('image');
	        $unicname = time().'.'.$file->getClientOriginalExtension();
	        $file->move("storage/app/public/banner_image",$unicname);
	        $ins['image'] = $unicname;
        }		
        BannerDetails::create($ins);
        return redirect()->back()->with('success','Banner Image Inserted Successfully');
    }

    public function deleteImage($id)
    {
        $count = BannerDetails::where('image_type','S')->count();
        if (@$count==1) {
           return redirect()->back()->with('error','You must have 1 banner image before delete this image');
        }
    	$check = BannerDetails::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	@unlink(storage_path('app/public/banner_image/' . $check->image));
    	BannerDetails::where('id',$id)->delete();
    	return redirect()->back()->with('success','Image Deleted Successfully');
    }

    public function editView($id)
    {
    	$check = BannerDetails::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['data'] = $check;
    	return view('admin.modules.second_banner.edit_image',$data);
    }

    public function updateImage(Request $request)
    {
    	$check = BannerDetails::where('id',$request->id)->first();
    	$upd = [];
    	$upd['heading'] = $request->heading;
    	$upd['sub_heading'] = $request->sub_heading;
    	$upd['button_link'] = $request->button_link;
    	$upd['button_caption'] = $request->button_caption;
    	if ($request->hasFile('image')) {
        $file = $request->file('image');
        $unicname = time().'.'.$file->getClientOriginalExtension();
        $file->move("storage/app/public/banner_image",$unicname);
        $upd['image'] = $unicname;
        @unlink(storage_path('app/public/banner_image/' . $check->image));
       } 
       BannerDetails::where('id',$request->id)->update($upd);
       return redirect()->back()->with('success','Banner Image Updated Successfully');
    }
}
