<?php

namespace App\Http\Controllers\Admin\Modules\HoroscopeTitle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HoroscopeTitle;
use App\Models\Horoscope;
class HoroscopeTitleController extends Controller
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
    	$data['title'] = HoroscopeTitle::orderBy('id','desc');
      if (@$request->title) {
        $data['title']  = $data['title']->where('title','LIKE','%'.request('title').'%');
      }
      $data['title']  = $data['title']->paginate(10);
    	return view('admin.modules.horoscope_title.manage_horoscope_title',$data);
    }

    public function addView()
    {
    	return view('admin.modules.horoscope_title.add_horoscope_title');
    }

    public function add(Request $request)
    {
    	$title = new HoroscopeTitle;
    	$title->title = $request->title;
    	if ($request->profile_picture) {
           $destinationPath = "storage/app/public/horoscope_title/";
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
    	$update = HoroscopeTitle::where('id',$title->id)->update([
            'slug'=> str_slug($request->title).'-'.$title->id
        ]);
    	return redirect()->back()->with('success','Horoscope Title Added Successfully');

    }

    public function check(Request $request)
    {
          if (@$request->id) {
          $check = HoroscopeTitle::where('title',$request->title)->where('id','!=',$request->id)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
              
          }else{
             $check = HoroscopeTitle::where('title',$request->title)->first();
              if (!empty($check)) {
                   echo "false";
              }else{
                   echo "true";
              }
          }
    }



    public function editView($id)
    {
    	$check = HoroscopeTitle::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$data = [];
    	$data['data'] = $check ;
    	return view('admin.modules.horoscope_title.edit_horoscope_title',$data);
    }


    public function update(Request $request)
    {
    	    $title = HoroscopeTitle::where('id', $request->id)->first();
            $upd = [];
            $upd['title'] = $request->title;
            if ($request->profile_picture) {

            @unlink(storage_path('app/public/horoscope_title/' . $title->image));
            
            $destinationPath = "storage/app/public/horoscope_title/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
            }
            $upd['slug'] = str_slug($request->title).'-'.$request->id;
            HoroscopeTitle::where('id', $request->id)->update($upd);
            return redirect()->back()->with('success','Title Updated Successfully');
    }


    public function delete($id)
    {
    	$check = HoroscopeTitle::where('id',$id)->first();
    	if (@$check==null) {
    		return redirect()->back();
    	}
    	$check2 = Horoscope::where('title_id',$id)->where('status','!=','D')->first();
    	if (@$check2!="") {
    		return redirect()->back()->with('error','Horoscope Title Can Not Be Delete As It Is Associated With Horoscope');
    	}
    	@unlink(storage_path('app/public/horoscope_title/' . @$check->image));
    	HoroscopeTitle::where('id',$id)->delete();
    	return redirect()->back()->with('success','Horoscope Title Deleted Successfully');
    }

    public function deleteImage(Request $request)
    {
      $check = HoroscopeTitle::where('id',$request->id)->first();
      @unlink(storage_path('app/public/horoscope_title/' . @$check->image));
      HoroscopeTitle::where('id',$request->id)->update(['image'=>'']);
      echo "success";
    }


}
