<?php

namespace App\Http\Controllers\Admin\Modules\Puja;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Puja;
use Illuminate\Support\Str;
use App\Models\PunditToPuja;
use App\Models\PujaCategory;
use Image;
use App\Providers\Libraries\ImageResize;
use App\Models\Deity;
use App\Models\Purpose;
use App\Models\PujaToDeity;
use App\Models\PujaToPurpose;
use App\User;
use App\Models\Nakshatras;
use App\Models\Rashi;
use App\Models\Planets;
use App\Models\PujaToPlanet;
use App\Models\PujaToRashi;
use App\Models\PujaToNakshatra;
use App\Models\OrderMaster;
use App\Models\PujaName;
class PujaController extends Controller
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
     *   Description : Show and search filters of manage puja
     *   Author      : Sayan
     *   Date        : 2021-MAY-29
    **/
    public function index(Request $request)
    {
      // return $request;
    	$data = [];
    	$data['pujas'] = Puja::orderBy('id','desc');
      if (@$request->category_id) {
        $data['pujas'] = $data['pujas']->where('puja_category',@$request->category_id);
        $data['sub_categories']=PujaCategory::where('status','A')->orderBy('name','asc')->where('parent_id',@$request->category_id)->get();
      }
      if (@$request->sub_category_id) {
        $data['pujas'] = $data['pujas']->where('puja_sub_category',@$request->sub_category_id);
      }
      if (@$request->type) {
        $data['pujas'] = $data['pujas']->where('manner_of_puja',@$request->type);
      }
      if (@$request->avail) {
        $data['pujas'] = $data['pujas']->where('availability',@$request->avail);
      }
    	if (@$request->name) {
    		$data['pujas']= $data['pujas']->where(function($query){
                    $query->where('puja_name','LIKE','%'.request('name').'%')
                          ->orWhere('puja_description','LIKE','%'.request('name').'%')
                          ->orWhere('importance_significance','LIKE','%'.request('name').'%')
                          ->orWhere('facts_mythology','LIKE','%'.request('name').'%')
                          ->orWhere('who_when_how','LIKE','%'.request('name').'%')
                          ->orWhere('puja_code','LIKE','%'.request('name').'%')
                          ->orWhere('puja_mantra','LIKE','%'.request('name').'%');
                 })->orWhereHas('pujaRashi.rashis',function($query){
                $query->where('name','LIKE','%'.request('name').'%');
            })->orWhereHas('pujaPlanet.planets',function($query){
                $query->where('planet_name','LIKE','%'.request('name').'%');
            })->orWhereHas('pujaNakshatra.nakshatras',function($query){
                $query->where('name','LIKE','%'.request('name').'%');
            })->orWhereHas('pujaDeity.deity',function($query){
                $query->where('name','LIKE','%'.request('name').'%');
            })->orWhereHas('pujaPurpose.purpose',function($query){
                $query->where('name','LIKE','%'.request('name').'%');
            });
    	}
    	if(@$request->amount1!="" && @$request->amount2){
    		$data['pujas'] = $data['pujas']->whereBetween('price_inr',[$request->amount1,$request->amount2]);
    	}

      if(@$request->amount1==null && @$request->amount2){
        $data['pujas'] = $data['pujas']->whereBetween('price_inr','<',$request->amount2);
      }
      // return $request;
	  

      if (@$request->deity) {
        $deity =  $request->deity;
       
        // return $deity;
                // return @$request->deity;
         $data['pujas']= $data['pujas']->whereHas('pujaDeity', function ($query) use ($deity) {
                    $query->whereIn('deity_id', $deity);
                });
         
      }

      if (@$request->purpose) {
        // return @$request->purpose;
        $purpose =  $request->purpose;
        $data['pujas']= $data['pujas']->whereHas('pujaPurpose', function ($query) use ( $purpose) {
                    $query->whereIn('purpose_id',  $purpose);
                });
      }

      if (@$request->rashi) {
        $rashi =  $request->rashi;
        $data['pujas']= $data['pujas']->whereHas('pujaRashi', function ($query) use ( $rashi) {
                    $query->whereIn('rashi_id',  $rashi);
                });
      }

      if (@$request->nakshatra) {
        $nakshatra =  $request->nakshatra;
        $data['pujas']= $data['pujas']->whereHas('pujaNakshatra', function ($query) use ( $nakshatra) {
                    $query->whereIn('nakshatra_id',  $nakshatra);
                });
      }

      if (@$request->planets) {
        $planets =  $request->planets;
        $data['pujas']= $data['pujas']->whereHas('pujaPlanet', function ($query) use ( $planets) {
                    $query->whereIn('planet_id',  $planets);
                });
      }



      if (@$request->puja_id) {
         $data['pujas'] = $data['pujas']->where('puja_id',$request->puja_id);
      }

      $data['puja_count'] = $data['pujas']->count();
      $data['pujas'] = $data['pujas']->paginate(10);
    	$data['request'] = $request->all();
      $data['category'] = PujaCategory::where('status','A')->orderBy('name','asc')->where('parent_id',0)->get();
      $data['deity'] = Deity::orderBy('name','asc')->get();
      $data['purpose'] = Purpose::orderBy('name','asc')->get();
      $data['rashi'] = Rashi::orderBy('name','asc')->get();
      $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
      $data['puja_name'] = PujaName::orderBy('name','asc')->get();
      $data['request'] = $request->all();
      

      


	  $data['max_price']=Puja::max('price_inr');
     
      // return $data['request'];
	  $data['planets']=Planets::orderBy('planet_name','asc')->get();
    return view('admin.modules.puja.manage_puja',$data);
    }


    public function addview()
    {
      $data = [];
      $data['category'] = PujaCategory::where('status','A')->orderBy('name','asc')->where('parent_id',0)->get();
      $data['deity'] = Deity::orderBy('name','asc')->get();
      $data['purpose'] = Purpose::orderBy('name','asc')->get();
	  $data['planets'] = Planets::orderBy('planet_name','asc')->get();
      $data['rashi'] = Rashi::orderBy('name','asc')->get();
	  $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
    $data['pujas'] = PujaName::orderBy('name','asc')->get();
      return view('admin.modules.puja.add_puja',$data);
    }
	/**
    * Method: pujaCodeDuplicate
    * Description: To check the puja code is duplicate or not by ajax call
    * Author: Madhuchandra
    * Date: 2021-AUGUST-31
    */
    public function pujaCodeDuplicate(Request $request)
    {

      if(@$request->id){
        $products = Puja::where(['puja_code' => trim($request->puja_code)])->where('status', '!=', 'D')->where('id','!=',$request->id)->first();
        if(@$products) {
            return response('false');
        } else {
            return response('true');
        } 
      

       }else{
        $products = Puja::where(['puja_code' => trim($request->puja_code)])->where('status', '!=', 'D')->first();
        if(@$products) {
            return response('false');
        } else {
            return response('true');
        } 
        }         
    }

    public function add(Request $request)
    {
        // return $request;	
    	  $puja = new Puja;
        $puja->puja_category = $request->category_id;
        $puja->puja_sub_category = $request->sub_category_id; 
        $puja->puja_code = $request->puja_code;
        $puja->puja_id = $request->puja_id; 
        $puja->puja_name = $request->name; 
        $puja->price_inr = $request->price_inr;
        $puja->price_usd = $request->price_usd;
        $puja->no_of_recitals = $request->recitals;
        $puja->no_of_pundits = $request->pundits;
        $puja->with_homam = $request->homam;
        $puja->manner_of_puja = $request->manner;
        $puja->importance_significance = $request->significance;
        $puja->facts_mythology = $request->mythology;
        $puja->puja_mantra = $request->mantra;
        $puja->assurance_guarantee = $request->assurance_guarantee;
        $puja->refundable = $request->refundable;
        $puja->availability = $request->availability;
        $puja->who_when_how = $request->who_when_how;
        $puja->cd = $request->cd;
        $puja->meta_title = $request->meta_title;
        $puja->meta_description = $request->meta_description;

        if (@$request->youtube_link) {
        if (in_array('www.youtube.com', explode('/', @$request->youtube_link))) {
          $explode = explode('=', @$request->youtube_link);
          $code = end($explode);
         }else{
          $explode = explode('/', @$request->youtube_link);
          $code = end($explode);
         }
         $puja->youtube_link_code = $code;
         $puja->youtube_link = @$request->youtube_link;
       }


        if($request->cd=="Y"){
        if (@$request->cd_price_inr==null) {
          $puja->cd_price_inr = 0;
        }else{
          $puja->cd_price_inr = $request->cd_price_inr;
        }

        if (@$request->cd_price_usd==null) {
          $puja->cd_price_usd = 0;
        }else{
          $puja->cd_price_usd = $request->cd_price_usd;
        }

      }





        $puja->live_streaming = $request->live_streaming;
        
    if($request->live_streaming=="Y"){
        if (@$request->liver_streaming_inr==null) {
          $puja->liver_streaming_inr = 0;
        }else{
          $puja->liver_streaming_inr = $request->liver_streaming_inr;
        }

        if (@$request->liver_streaming_usd==null) {
          $puja->liver_streaming_usd = 0;
        }else{
          $puja->liver_streaming_usd = $request->liver_streaming_usd;
        }

      }

        $puja->prasad = $request->prasad;
        


        if($request->prasad=="Y"){
        if (@$request->prasad_inr==null) {
          $puja->prasad_inr = 0;
        }else{
          $puja->prasad_inr = $request->prasad_inr;
        }

        if (@$request->prasad_usd==null) {
          $puja->prasad_usd = 0;
        }else{
          $puja->prasad_usd = $request->prasad_usd;
        }
        $puja->is_prasad_delivery = $request->prasad_delivery;
        if ($request->prasad_delivery=="Y") {
          $puja->delivery_days_india = $request->delivery_days_india;
          $puja->delivery_days_outside_india = $request->delivery_days_outside_india;
        }else{
           $puja->delivery_days_india = null;
           $puja->delivery_days_outside_india = null;
        }
        
        
      }else{
        $puja->is_prasad_delivery = 'N';
        $puja->delivery_days_india = null;
        $puja->delivery_days_outside_india = null;
      }

      
      

        if (@$request->refundable=='Y') {
            $puja->refundable_status = $request->refundable_status;
        }else{
            $puja->refundable_status = null;
        }
        if ($request->discount_inr==null) {
           $puja->discount_inr = 0;
        }else{
            $puja->discount_inr = $request->discount_inr;
        }

        if ($request->discount_usd==null) {
           $puja->discount_usd = 0;
        }else{
            $puja->discount_usd = $request->discount_usd;
        }

        if($request->homam=="Y"){
        if (@$request->homam_price_inr==null) {
          $puja->homam_price_inr = 0;
        }else{
          $puja->homam_price_inr = $request->homam_price_inr;
        }

        if (@$request->homam_price_usd==null) {
          $puja->homam_price_usd = 0;
        }else{
          $puja->homam_price_usd = $request->homam_price_usd;
        }

      }

      //  if ($request->hasFile('image'))
	     // {
	     //  $image = $request->image;
      //   $destinationPath = "storage/app/public/puja_image/";
	     //  $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
      //   $image->move($destinationPath, $filename);
      //   ImageResize::doResize(['file' => $image, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/puja_image_small/", 'dimension' => [257, 242], 'filename' =>$filename]);

      //   // ImageResize::doResize(['file' => $image, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/product_big_image/", 'dimension' => [437, 362], 'filename' =>$filename]);
	     //  // $resize_image = Image::make($image->getRealPath());
      //  //    $resize_image->resize(67, 67, function($constraint){
      //  //          $constraint->aspectRatio();
      //  //    })->save("storage/app/public/puja_image_small" . '/' . $filename);
      //  //    $image->move("storage/app/public/puja_image",$filename);
      //   } 

         if ($request->profile_picture) {
           $destinationPath = "storage/app/public/puja_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $puja->puja_image = $img;
        }

      if ($request->hasFile('video')) {
        $file = $request->file('video');
        $unicname = time().'.'.$file->getClientOriginalExtension();
        $file->move("storage/app/public/puja_video",$unicname);
        $puja->puja_video = $unicname;
      }   


    	$puja->puja_description = $request->description;
    	// $puja->puja_image = $filename;
      
    	$puja->save();
		
		// planets
        if ($request->planets) {
        $planets = @$request->planets;
        foreach ($planets as $value) {

            $insPlanet = [];
            $insPlanet['puja_id'] = $puja->id;
            $insPlanet['planet_id'] = $value;
            PujaToPlanet::create($insPlanet);
        }
       } 

        // rashis
       if ($request->rashis) {
        $rashis = $request->rashis;
        foreach ($rashis as $value) {

            $insRashi = [];
            $insRashi['puja_id'] = $puja->id;
            $insRashi['rashi_id'] = $value;
            PujaToRashi::create($insRashi);
        }
      }

        // nakshatras
       if ($request->nakshatra) {
        $nakshatras = $request->nakshatra;
        foreach ($nakshatras as $value) {

            $insNak = [];
            $insNak['puja_id'] = $puja->id;
            $insNak['nakshatra_id'] = $value;
            PujaToNakshatra::create($insNak);
        }
       } 

       if ($request->deity) {
        $deitys = $request->deity;
        foreach ($deitys as $value) {

            $insDeity = [];
            $insDeity['puja_id'] = $puja->id;
            $insDeity['deity_id'] = $value;
            PujaToDeity::create($insDeity);
        }
     }

     if ($request->purpose) {
        $purpose = $request->purpose;
        foreach ($purpose as $value) {

            $insDeity = [];
            $insDeity['puja_id'] = $puja->id;
            $insDeity['purpose_id'] = $value;
            PujaToPurpose::create($insDeity);
        }
     }

     $update = Puja::where('id',$puja->id)->update([
            'slug'=> str_slug($request->name).'-'.$puja->id
      ]);

     // assign-all-pundit the puja 
     $pundit = User::where('status','!=','D')->where('status','!=','U')->where('user_type','P')->get();
     if (@$pundit!="") {
        foreach ($pundit as $key => $value) {
          PunditToPuja::create([
              'user_id' =>$value->id,
              'puja_id' =>$puja->id,
          ]);
        }
     }



    	return redirect()->back()->with('success','Puja added successfully');
	}


	public function delete($id)
	{
		$check = Puja::where('id',$id)->first();
		if ($check==null) {
			return redirect()->back();
		}
    $check2 = PunditToPuja::where('puja_id',$id)->first();
    if ($check2!="") {
      return redirect()->back()->with('error','Puja can not be deleted as it is associated with pundit');
    }
		$delete = Puja::where('id',$id)->delete();
		return redirect()->back()->with('success','Puja deleted successfully');
	}

	public function editview($id)
	{
    $puja = [];
		$check = Puja::where('id',$id)->first();
		if ($check==null) {
			return redirect()->back()->with('success','Puja deleted successfully');
		}
		$puja['data'] = Puja::where('id',$id)->first();
		//dd($puja['data']->pujaPlanet);
		$puja['category'] = PujaCategory::where('status','A')->orderBy('name','asc')->where('parent_id',0)->get();
    $puja['sub_category'] = PujaCategory::where('status','A')->orderBy('name','asc')->where('parent_id',$puja['data']->puja_category)->get();
		$puja['deity'] = Deity::orderBy('name','asc')->get();
		$puja['purpose'] = Purpose::orderBy('name','asc')->get();
		$puja['planets'] = Planets::orderBy('planet_name','asc')->get();
        $puja['rashi'] = Rashi::orderBy('name','asc')->get();
		$puja['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
    $puja['pujas'] = PujaName::orderBy('name','asc')->get();

    $puja['selected_deity'] = PujaToDeity::where('puja_id',$id)->pluck('deity_id')->toArray();
    $puja['selected_planet'] = PujaToPlanet::where('puja_id',$id)->pluck('planet_id')->toArray();
    $puja['selected_rashi'] = PujaToRashi::where('puja_id',$id)->pluck('rashi_id')->toArray();
    $puja['selected_nakshatra'] = PujaToNakshatra::where('puja_id',$id)->pluck('nakshatra_id')->toArray();
    $puja['selected_purpose'] = PujaToPurpose::where('puja_id',$id)->pluck('purpose_id')->toArray();
    // check-if this puja has order or not 
    $order = OrderMaster::where('puja_id',$id)->first();
    if (@$order!="") {
      $puja['dis'] = 'disable';
    }
		return view('admin.modules.puja.edit_puja',$puja); 
	}

	public function update(Request $request)
	{

		$check = Puja::where('id',$request->id)->first();
		if ($check==null) {
			return redirect()->back()->with('success','Puja deleted successfully');
		}
		// return $request;
        $upd = [];
        if (@$request->puja_code) {
          $upd['puja_code'] = $request->puja_code; 
        }
        $upd['puja_id'] = $request->puja_id;
        $upd['puja_name'] = $request->name;
        $upd['puja_category'] = $request->category_id; 
        $upd['puja_sub_category'] = $request->sub_category_id; 
        $upd['puja_name'] = $request->name; 
        $upd['price_inr'] = $request->price_inr;
        $upd['price_usd'] = $request->price_usd;
        $upd['no_of_recitals'] = $request->recitals;
        $upd['no_of_pundits'] = $request->pundits;
        $upd['with_homam'] = $request->homam;
        $upd['manner_of_puja'] = $request->manner;
        $upd['importance_significance'] = $request->significance;
        $upd['facts_mythology'] = $request->mythology;
        $upd['puja_description'] = $request->description;
        $upd['puja_mantra'] = $request->mantra;
        $upd['assurance_guarantee'] = $request->assurance_guarantee;
         $upd['availability'] = $request->availability;
         $upd['who_when_how'] = $request->who_when_how;
         $upd['meta_title'] = $request->meta_title;
         $upd['meta_description'] = $request->meta_description;
        $upd['slug'] = str_slug($request->name).'-'.$request->id;

        if (@$request->youtube_link) {
        if (in_array('www.youtube.com', explode('/', @$request->youtube_link))) {
          $explode = explode('=', @$request->youtube_link);
          $code = end($explode);
         }else{
          $explode = explode('/', @$request->youtube_link);
          $code = end($explode);
         }
         $upd['youtube_link_code'] = $code;
         $upd['youtube_link'] = @$request->youtube_link;
       }




       $upd['cd'] = $request->cd;


        if($request->cd=="Y"){
        if (@$request->cd_price_inr==null) {
          $upd['cd_price_inr'] = 0;
        }else{
          $upd['cd_price_inr'] = $request->cd_price_inr;
        }

        if (@$request->cd_price_usd==null) {
          $upd['cd_price_usd'] = 0;
        }else{
          $upd['cd_price_usd'] = $request->cd_price_usd;
        }

      }else{
        $upd['cd_price_inr'] = 0;
        $upd['cd_price_usd'] = 0;
      }





   $upd['live_streaming'] = $request->live_streaming;
        
    if($request->live_streaming=="Y"){
        if (@$request->liver_streaming_inr==null) {
          $upd['liver_streaming_inr'] = 0;
        }else{
          $upd['liver_streaming_inr'] = $request->liver_streaming_inr;
        }

        if (@$request->liver_streaming_usd==null) {
          $upd['liver_streaming_usd'] = 0;
        }else{
          $upd['liver_streaming_usd'] = $request->liver_streaming_usd;
        }

      }else{
        $upd['liver_streaming_inr'] = 0;
        $upd['liver_streaming_usd'] = 0;
      }

        $upd['prasad'] = $request->prasad;
        


        if($request->prasad=="Y"){
        if (@$request->prasad_inr==null) {
          $upd['prasad_inr'] = 0;
        }else{
          $upd['prasad_inr'] = $request->prasad_inr;
        }

        if (@$request->prasad_usd==null) {
          $upd['prasad_usd'] = 0;
        }else{
          $upd['prasad_usd'] = $request->prasad_usd;
        }
        $upd['is_prasad_delivery'] = $request->prasad_delivery;
        $upd['delivery_days_india'] = $request->delivery_days_india;
        $upd['delivery_days_outside_india'] = $request->delivery_days_outside_india;
        if ($request->prasad_delivery=='N') {
          $upd['delivery_days_india'] = null;
          $upd['delivery_days_outside_india'] = null;
        }
        

      }else{
         $upd['prasad_inr'] = 0;
         $upd['prasad_usd'] = 0;
         $upd['delivery_days_india'] = null;
         $upd['delivery_days_outside_india'] = null;
         $upd['is_prasad_delivery'] = 'N';
      }


      
      



         if (@$request->refundable=='Y') {
            $upd['refundable_status'] = $request->refundable_status;
        }else{
            $upd['refundable_status'] = null;
        }
        $upd['refundable'] = @$request->refundable;


          if(@$request->homam=="Y") {
          // return 2;
          if ($request->homam_price_inr==null || $request->homam_price_inr==0) {
            $upd['homam_price_inr'] = 0;
          }else{
            $upd['homam_price_inr'] = $request->homam_price_inr;
          }
         

        
          if ($request->homam_price_usd==null) {
            $upd['homam_price_usd'] = 0;
          }else{
            $upd['homam_price_usd'] = $request->homam_price_usd;
          }

        }else{
           $upd['homam_price_inr'] = 0;
           $upd['homam_price_usd'] = 0;
        }

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



        
        // if ($request->hasFile('image')) {
        //        $destinationPath = "storage/app/public/puja_image/";
        //         $image = $request->image;
        //         $filename = time() . '-' . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
        //         $image->move($destinationPath, $filename);
        //         ImageResize::doResize(['file' => $image, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/puja_image_small/", 'dimension' => [257, 242], 'filename' =>$filename]);
        //   //       $resize_image = Image::make($image->getRealPath());
        //   //       $resize_image->resize(67, 67, function($constraint){
        //   //       $constraint->aspectRatio();
		      //   // })->save("storage/app/public/puja_image_small" . '/' . $filename);
		      //   // $image->move("storage/app/public/puja_image",$filename);
                
        //         $upd['puja_image'] = $filename;
        //         @unlink(storage_path('app/public/puja_image/' . $check->puja_image));
        //         @unlink(storage_path('app/public/puja_image_small/' . $check->puja_image));
        // }

        if ($request->profile_picture) {

            @unlink(storage_path('app/public/puja_image/' . $user_details->profile_img));
            @unlink(storage_path('app/public/puja_image_small/' . $user_details->profile_img));
            $destinationPath = "storage/app/public/puja_image/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['puja_image'] = $img;
        }

        // return $request;
       if ($request->hasFile('video')) {
        // return $request->hasFile('video');
        $file = $request->file('video');
        $unicname = time().'.'.$file->getClientOriginalExtension();
        $file->move("storage/app/public/puja_video",$unicname);
        $upd['puja_video'] = $unicname;
        @unlink(storage_path('app/public/puja_video/' . $check->puja_video));
      } 




        $update = Puja::where('id', $request->id)->update($upd);

        // deity
        $deity =  @$request->deity;
        if (@$request->deity) {
         
        foreach ($deity as $item) {
            $indDeity = [];
            $indDeity['puja_id'] = $request->id;
            $indDeity['deity_id'] = $item;
            $checkAvailable = PujaToDeity::where('puja_id', $request->id)->where('deity_id', $item)->first();
            if ($checkAvailable == null) {
                PujaToDeity::create($indDeity);
            }
        }
      }
      if ($deity) {
        PujaToDeity::where('puja_id', $request->id)->whereNotIn('deity_id', $deity)->delete();
      }else{
        PujaToDeity::where('puja_id', $request->id)->delete();
      }
     
	 // nakshtrats
     $nakshatra = @$request->nakshatra;
        if (@$request->nakshatra) {
         
        foreach ($nakshatra as $item) {
            $insnakshatra = [];
            $insnakshatra['puja_id'] = $request->id;
            $insnakshatra['nakshatra_id'] = $item;
            $checkAvailable = PujaToNakshatra::where('puja_id', $request->id)->where('nakshatra_id', $item)->first();
            if ($checkAvailable == null) {
                PujaToNakshatra::create($insnakshatra);
            }
        }
      }
      if ($nakshatra) {
        PujaToNakshatra::where('puja_id', $request->id)->whereNotIn('nakshatra_id', $nakshatra)->delete();
      }else{
        PujaToNakshatra::where('puja_id', $request->id)->delete();
      }
     
	 
	 // planets 
        $planets =  @$request->planets;
        if (@$request->planets) {
         
        foreach ($planets as $item) {
            $insPlanet = [];
            $insPlanet['puja_id'] = $request->id;
            $insPlanet['planet_id'] = $item;
            $checkAvailable = PujaToPlanet::where('puja_id', $request->id)->where('planet_id', $item)->first();
            if ($checkAvailable == null) {
                PujaToPlanet::create($insPlanet);
            }
        }
      }
      if ($planets) {
       PujaToPlanet::where('puja_id', $request->id)->whereNotIn('planet_id', $planets)->delete();
      }else{
        PujaToPlanet::where('puja_id', $request->id)->delete();
      }
     

     // rashi

     $rashis = @$request->rashis;
        if (@$request->rashis) {
         
        foreach ($rashis as $item) {
            $insRashi = [];
            $insRashi['puja_id'] = $request->id;
            $insRashi['rashi_id'] = $item;
            $checkAvailable = PujaToRashi::where('puja_id', $request->id)->where('rashi_id', $item)->first();
            if ($checkAvailable == null) {
                PujaToRashi::create($insRashi);
            }
        }
      }
      if ($rashis) {
       PujaToRashi::where('puja_id', $request->id)->whereNotIn('rashi_id', $rashis)->delete();
      }else{
        PujaToRashi::where('puja_id', $request->id)->delete();
      }
     


     // purpose 
       $purpose = @$request->purpose;
        if (@$request->purpose) {
         
        foreach ($purpose as $item) {
            $indDeity = [];
            $indDeity['puja_id'] = $request->id;
            $indDeity['purpose_id'] = $item;
            $checkAvailable = PujaToPurpose::where('puja_id', $request->id)->where('purpose_id', $item)->first();
            if ($checkAvailable == null) {
                PujaToPurpose::create($indDeity);
            }
        }
      }
      if ($purpose) {
         PujaToPurpose::where('puja_id', $request->id)->whereNotIn('purpose_id', $purpose)->delete();
      }else{
        PujaToPurpose::where('puja_id', $request->id)->delete();
      }
    
    // assign pundit puja if not assigned
    $check2 = PunditToPuja::where('puja_id',$request->id)->first();
    if ($check2=="") {
    
    $pundit = User::where('status','!=','D')->where('status','!=','U')->where('user_type','P')->get();
     if (@$pundit!="") {
        foreach ($pundit as $key => $value) {
          PunditToPuja::create([
              'user_id' =>$value->id,
              'puja_id' =>$request->id,
          ]);
        }
     }
   }





     return redirect()->back()->with('success','Puja updated successfully');

	}



	public function check(Request $request)
	{

  	if (@$request->id) {
              $checkpuja = Puja::where('puja_name',$request->name)->where('puja_category',$request->category_id)->where('id','!=',$request->id)->where('status','!=','D')->first();
              if ($checkpuja!="") {
                  echo "found";
              }else{
                  echo "not found";
              }
          }else{
          $checkpuja = Puja::where('puja_name',$request->name)->where('puja_category',$request->category_id)->where('status','!=','D')->first();
          if ($checkpuja!="") {
              echo "found";
          }else{
              echo "not found";
          }
       }
	}



  public function showAtHome($id)
  {
    $check = Puja::where('id',$id)->where('status','!=','D')->first();
    if (@$check==null) {
      return redirect()->back();
    }
    if (@$check->show_at_home=='Y') {
      $update = Puja::where('id',$id)->update(['show_at_home'=>'N']);
      return redirect()->back()->with('success','Puja is remove from home successfully');
    }else{
      $update = Puja::where('id',$id)->update(['show_at_home'=>'Y']);
      return redirect()->back()->with('success','Puja is show at home successfully');
    }
  }


  public function getSubCat(Request $request)
  {
    $data = PujaCategory::where('parent_id',$request->id)->orderBy('name','asc')->where('status','!=','D')->get();
        $response=array();
        $result="<option value=''>Select Sub Category</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request->sub_id==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->name."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->name."</option>";
                }
                
            }
        }
        $response['sub_cat']=$result;
        return response()->json($response);
  }


  public function deleteImage(Request $request)
  {
      Puja::where('id',$request->id)->update(['puja_image'=>'']);
      echo "success";
  }

  public function deleteVideo(Request $request)
  {
    Puja::where('id',$request->id)->update(['puja_video'=>'']);
    echo "success";
  }
}
