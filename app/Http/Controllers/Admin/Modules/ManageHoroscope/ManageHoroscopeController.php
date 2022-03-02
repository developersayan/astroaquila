<?php

namespace App\Http\Controllers\Admin\Modules\ManageHoroscope;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Horoscope;
use App\Models\HoroscopeCategory;
use App\Models\OrderMaster;
use App\Models\HoroscopeTitle;
use App\Models\Expertise;
use App\Models\HoroscopeToExpertise;
class ManageHoroscopeController extends Controller
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
    	$data['data'] = Horoscope::where('status','!=','D');
        if (@$request->category_id) {
            $data['data'] = $data['data']->where('category_id',request('category_id'));
        }
        if(@$request->amount1!="" && @$request->amount2){
            $data['data'] = $data['data']->whereBetween('price_inr',[$request->amount1,$request->amount2]);
        }

      if(@$request->amount1==null && @$request->amount2){
        $data['data'] = $data['data']->whereBetween('price_inr','<',$request->amount2);
      }
      if (@$request->status) {
          $data['data'] = $data['data']->where('status',request('status'));
      }
      if (@$request->discount){
             
             $data['data']=$data['data']->whereBetween('discount_inr',[1,@$request->discount]);
      }
      if (@$request->title_id) {
        $data['data'] = $data['data']->where('title_id',request('title_id'));
      }

     if (@$request->expertise) {
          $data['data'] = $data['data']->whereHas('horoscopeExpertise',function($e) use ($request){
          $e->where('expertise_id',@$request->expertise);
          });

      }

      if (@$request->keyword) {
         $data['data']= $data['data']->where(function($query){
                    $query->where('name','LIKE','%'.request('keyword').'%')
                          ->orWhere('code','LIKE','%'.request('keyword').'%')
                           ->orWhere('heading_one','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_one','LIKE','%'.request('keyword').'%')
                           ->orWhere('heading_two','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_two','LIKE','%'.request('keyword').'%')
                            ->orWhere('heading_three','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_three','LIKE','%'.request('keyword').'%')
                            ->orWhere('heading_four','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_four','LIKE','%'.request('keyword').'%')
                            ->orWhere('heading_five','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_five','LIKE','%'.request('keyword').'%')
                            ->orWhere('heading_six','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_six','LIKE','%'.request('keyword').'%')
                            ->orWhere('heading_seven','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_seven','LIKE','%'.request('keyword').'%')
                            ->orWhere('heading_eight','LIKE','%'.request('keyword').'%')
                           ->orWhere('description_eight','LIKE','%'.request('keyword').'%')
                           ->orWhere('significance','LIKE','%'.request('keyword').'%')
                           ->orWhere('who_how_when','LIKE','%'.request('keyword').'%')
                            ->orWhere('related_mantra','LIKE','%'.request('keyword').'%')
                             ->orWhere('usages','LIKE','%'.request('keyword').'%');
                 });
         
      }
      $data['data'] =  $data['data']->orderBy('id','desc')->paginate(10);
    	$data['category'] = HoroscopeCategory::where('parent_id',0)->get();
      $data['title'] = HoroscopeTitle::get();
      $data['max_price']=Horoscope::max('price_inr');
      $data['horoscope_count'] = $data['data']->count();
      $data['expertise'] = Expertise::get();
      return view('admin.modules.horoscope.manage_horoscope',$data);
    }

    public function addView()
    {
    	$data = [];
    	$data['category'] = HoroscopeCategory::where('parent_id',0)->get();
      $data['title'] = HoroscopeTitle::get();
      $data['expertise'] = Expertise::get();
    	return view('admin.modules.horoscope.add_horoscope',$data);
    }

    public function add(Request $request)
    {
    	// return $request;
    	$ins =[];
    	$ins['code'] = $request->code;
    	$ins['name'] = $request->name;
    	$ins['category_id'] = $request->category_id;
      $ins['sub_category_id'] = $request->sub_category_id;
      $ins['title_id'] = $request->title_id;
    	$ins['about_report'] = $request->about_report;
    	$ins['price_inr'] = $request->price_inr;
    	$ins['price_usd'] = $request->price_usd;
      $ins['heading_one'] = $request->heading_one;
      $ins['description_one'] = $request->description_one;

      $ins['heading_two'] = $request->heading_two;
      $ins['description_two'] = $request->description_two;


      $ins['heading_three'] = $request->heading_three;
      $ins['description_three'] = $request->description_three;

      $ins['heading_four'] = $request->heading_four;
      $ins['description_four'] = $request->description_four;


      $ins['heading_five'] = $request->heading_five;
      $ins['description_five'] = $request->description_five;

      $ins['heading_six'] = $request->heading_six;
      $ins['description_six'] = $request->description_six;


      $ins['heading_seven'] = $request->heading_seven;
      $ins['description_seven'] = $request->description_seven;

      $ins['heading_eight'] = $request->heading_eight;
      $ins['description_eight'] = $request->description_eight;

      $ins['significance'] = $request->significance;
      $ins['who_how_when'] = $request->who_how_when;
      $ins['related_mantra'] = $request->related_mantra;
      $ins['usages'] = $request->usages;

      // delivery
      $ins['is_deliverable'] = $request->is_deliverable;

      if ($request->is_deliverable=="Y") {
        $ins['delivery_days_india'] = $request->delivery_days_india;
        $ins['delivery_days_outside_india'] = $request->delivery_days_outside_india;
        $ins['delivery_price_inr'] = $request->delivery_price_inr;
        $ins['delivery_price_usd'] = $request->delivery_price_usd;
      }else{
        $ins['delivery_days_india'] = '';
        $ins['delivery_days_outside_india'] = '';
        $ins['delivery_price_inr'] = 0;
        $ins['delivery_price_usd'] = 0;
      }
      


    	if ($request->discount_inr==null) {
           $ins['discount_inr'] = 0;
        }else{
             $ins['discount_inr'] = $request->discount_inr;
        }

        if ($request->discount_usd==null) {
           $ins['discount_usd'] = 0;
        }else{
            $ins['discount_usd'] = $request->discount_usd;
        }
        $ins['meta_title'] = $request->meta_title;
        $ins['meta_description'] = $request->meta_description;
        
        $ins['refundable'] = @$request->refundable;
        if (@$request->refundable=='Y') {
            $ins['refundable_status'] = $request->refundable_status;
        }else{
            $ins['refundable_status'] = null;
        }
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/horoscope_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $ins['image'] = $img;
        }
        $create = Horoscope::create($ins);
        $update = Horoscope::where('id',$create->id)->update([
            'slug'=> str_slug($request->name).'-'.$create->id
        ]);
        if ($request->expertise) {
        $expertise = $request->expertise;
        foreach ($expertise as $value) {

            $insExpertise = [];
            $insExpertise['horoscope_id'] = $create->id;
            $insExpertise['expertise_id'] = $value;
            HoroscopeToExpertise::create($insExpertise);
        }
      }
       return redirect()->back()->with('success','Horoscope Added Successfully');
    }



    public function checkCode(Request $request)
    {
       if(@$request->id){
        $code = Horoscope::where(['code' => trim($request->code)])->where('status', '!=', 'D')->where('id','!=',$request->id)->first();
        if(@$code) {
            return response('false');
        } else {
            return response('true');
        } 
      

       }else{
        $code = Horoscope::where(['code' => trim($request->code)])->where('status', '!=', 'D')->first();
        if(@$code) {
            return response('false');
        } else {
            return response('true');
        } 
        }    
    }


    public function changeStatus($id)
    {
        $check = Horoscope::where('id',$id)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        if (@$check->status=="A") {
            Horoscope::where('id',$id)->update(['status'=>'I']);
            return redirect()->back()->with('success','Status Inactivated Successfully');
        }else{
            Horoscope::where('id',$id)->update(['status'=>'A']);
            return redirect()->back()->with('success','Status Activated Successfully');
        }
    }

    public function delete($id)
    {
       $check = Horoscope::where('id',$id)->first();
        if (@$check==null) {
            return redirect()->back();
        }
        Horoscope::where('id',$id)->update(['status'=>'D']);
        return redirect()->back()->with('success','Horoscope Deleted Successfully');
         
    }


    public function edit($id)
    {
      $check = Horoscope::where('id',$id)->first();
      if (@$check==null) {
            return redirect()->back();
      }
      $data = [];
      $data['data'] = $check;
      $data['category'] = HoroscopeCategory::where('parent_id',0)->get();
      $data['subcategory'] = HoroscopeCategory::where('parent_id',$check->category_id)->get();
      $data['title'] = HoroscopeTitle::get();
      $data['expertise']  = Expertise::get();
      $data['selected_expertise']  = HoroscopeToExpertise::where('horoscope_id',$id)->pluck('expertise_id')->toArray();
      $order = OrderMaster::where('horoscope_id',$id)->first();
      if (@$order!="") {
        $data['dis'] = 'disable';
      }
      return view('admin.modules.horoscope.edit_horoscope',$data); 
    }


    public function update(Request $request)
    {
      $details = Horoscope::where('id',$request->id)->first();
      $upd =[];
      if (@$request->code) {
          $upd['code'] = $request->code; 
        }
      $upd['name'] = $request->name;
      $upd['category_id'] = $request->category_id;

      $upd['sub_category_id'] = $request->sub_category_id;
      $upd['title_id'] = $request->title_id;
      
      $upd['about_report'] = $request->about_report;


      $upd['heading_one'] = $request->heading_one;
      $upd['description_one'] = $request->description_one;

      $upd['heading_two'] = $request->heading_two;
      $upd['description_two'] = $request->description_two;


      $upd['heading_three'] = $request->heading_three;
      $upd['description_three'] = $request->description_three;

      $upd['heading_four'] = $request->heading_four;
      $upd['description_four'] = $request->description_four;


      $upd['heading_five'] = $request->heading_five;
      $upd['description_five'] = $request->description_five;

      $upd['heading_six'] = $request->heading_six;
      $upd['description_six'] = $request->description_six;


      $upd['heading_seven'] = $request->heading_seven;
      $upd['description_seven'] = $request->description_seven;

      $upd['heading_eight'] = $request->heading_eight;
      $upd['description_eight'] = $request->description_eight;

      $upd['significance'] = $request->significance;
      $upd['who_how_when'] = $request->who_how_when;
      $upd['related_mantra'] = $request->related_mantra;
      $upd['usages'] = $request->usages;
      $upd['price_inr'] = $request->price_inr;
      $upd['price_usd'] = $request->price_usd;
      $upd['slug'] = str_slug($request->name).'-'.$request->id;
      if ($request->discount_inr==null) {
           $upd['discount_inr'] = 0;
        }else{
             $upd['discount_inr'] = $request->discount_inr;
        }

        if ($request->discount_usd==null) {
           $upd['discount_usd'] = 0;
        }else{
            $upd['discount_usd'] = $request->discount_usd;
        }
        $upd['meta_title'] = $request->meta_title;
        $upd['meta_description'] = $request->meta_description;
        $upd['is_deliverable'] = $request->is_deliverable;

      if ($request->is_deliverable=="Y") {
        $upd['delivery_days_india'] = $request->delivery_days_india;
        $upd['delivery_days_outside_india'] = $request->delivery_days_outside_india;
        $upd['delivery_price_inr'] = $request->delivery_price_inr;
        $upd['delivery_price_usd'] = $request->delivery_price_usd;
      }else{
        $upd['delivery_days_india'] = null;
        $upd['delivery_days_outside_india'] = null;
        $upd['delivery_price_inr'] = 0;
        $upd['delivery_price_usd'] = 0;
      }
        $upd['refundable'] = @$request->refundable;
        if (@$request->refundable=='Y') {
            $upd['refundable_status'] = $request->refundable_status;
        }else{
            $upd['refundable_status'] = null;
        }
        
        if ($request->profile_picture) {
            @unlink(storage_path('app/public/horoscope_image/' . $details->image));
            $destinationPath = "storage/app/public/horoscope_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
        }
       $expertise = $request->expertise;
        if (@$request->expertise) {

        foreach ($expertise as $item) {
            $insExpertise  = [];
            $insExpertise ['horoscope_id'] = $request->id;
            $insExpertise ['expertise_id'] = $item;
            $checkAvailable = HoroscopeToExpertise::where('horoscope_id', $request->id)->where('expertise_id', $item)->first();
            if ($checkAvailable == null) {
                HoroscopeToExpertise::create($insExpertise);
            }
        }
      }
     if ($expertise) {
        HoroscopeToExpertise::where('horoscope_id', $request->id)->whereNotIn('expertise_id', $expertise)->delete();
      }else{
        HoroscopeToExpertise::where('horoscope_id', $request->id)->delete();
      } 
        Horoscope::where('id',$request->id)->update($upd);
        return redirect()->back()->with('success','Horoscope Updated Successfully');

    }

    public function getSubCategory(Request $request)
    {
       $data = HoroscopeCategory::where('parent_id',$request->category)->orderBy('name','asc')->get();
        $response=array();
        $result ="<option value=''>Select Sub Category</option>";
        if(@$data->isNotEmpty())
        {
                foreach($data as $rows)
            {
                if(@$request->id==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->name."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->name."</option>";
                }

            }
        }
        $response['subcategories']=$result;

        return response()->json($response);
    }


    // public function deleteImage(Request $request)
    // {
    //   $details = Horoscope::where('id',$request->id)->first();
    //   @unlink(storage_path('app/public/horoscope_image/' . $details->image));
    //   Horoscope::where('id',$request->id)->update(['image'=>'']);
    //   echo "success";
    // }
}
