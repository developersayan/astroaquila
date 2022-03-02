<?php

namespace App\Http\Controllers\Admin\Modules\ManageGemstones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GemstoneCategory;
use App\Models\Products;
use App\Models\ProductToImage;
use App\Models\Purpose;
use App\Models\seller;
use App\Models\Nakshatras;
use App\Models\Rashi;
use App\Models\Planets;
use App\Models\ProductToPlanet;
use App\Models\ProductToRashi;
use App\Models\ProductToNakshatras;
use App\Models\Deity;
use App\Models\Country;
use App\Models\ProductToDeity;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Providers\Libraries\ImageResize;
use App\Models\GemstoneToTreatment;
use App\Models\ProductGemstonePrice;
use App\Models\OrderDetails;
use App\Models\Treatment;
use App\Models\GemstoneTitle;
use App\Models\GemstoneColor;
use App\Models\GemstoneShape;
use App\Models\GemstoneCut;
use App\Models\CertificationName;
use App\Models\StoneType;
use App\Models\SellerMaster;
class ManageGemstoneController extends Controller
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
     *   Description : manage Gemstone Category
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
    public function index(Request $request)
    {
        $data['category'] = GemstoneCategory::get(); 
        $GemstoneCategory= GemstoneCategory::orderBy('id','desc');
        if(@$request->all()){
            if(@$request->keyword){
                $GemstoneCategory= $GemstoneCategory->where('category_name', 'like','%'.@$request->keyword.'%');
            }
            $data['key']= @$request->all();
        }
        $data['AllGemstoneCategory']=$GemstoneCategory->paginate(10);
        return view('admin.modules.gemstoneCategory.manage_gemstone_category')->with($data);
    }
    /**
     *   Method      : addGemstoneCategory
     *   Description : Gemstone Category Add view page
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
    public function addGemstoneCategory()
    {
        return view('admin.modules.gemstoneCategory.add_gemstone_category');
    }
    /**
     *   Method      : addGemstoneCategorySave
     *   Description : Gemstone Category save
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
    public function addGemstoneCategorySave(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);
        $ins=[];
        $ins['category_name']=$request->category_name;
        if ($request->profile_picture) {
           $destinationPath = "storage/app/public/gemstone_category/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $ins['image'] = $img;
        }        
        $create=GemstoneCategory::create($ins);
        if(@$create){
            session()->flash('success', 'Gemstone category added successfully');
            return redirect()->route('admin.gemstone.category.manage');
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back()->withInput($request->input());
    }
    /**
     *   Method      : editGemstoneCategory
     *   Description : Gemstone Category Edit view page
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
    public function editGemstoneCategory($id=null)
    {
        $GemstoneCategory = GemstoneCategory::where('id',$id)->first();
        if(@$GemstoneCategory){
            $data['GemstoneCategory']= $GemstoneCategory;
           
            return view('admin.modules.gemstoneCategory.edit_gemstone_category')->with($data);
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
    }
    /**
     *   Method      : editGemstoneCategorySave
     *   Description : Gemstone Category edit value update
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
    public function editGemstoneCategorySave(Request $request,$id = null)
    {
       
        $GemstoneCategory = GemstoneCategory::where('id', $id)->first();
        if (@$GemstoneCategory) {
            $upd = [];
            $upd['category_name'] = $request->category_name;
            if ($request->profile_picture) {

            @unlink(storage_path('app/public/gemstone_category/' . $GemstoneCategory->image));
            
            $destinationPath = "storage/app/public/gemstone_category/";
            $img1 = str_replace('data:image/png;base64,', '', @$request->profile_picture);
            $img1 = str_replace(' ', '+', $img1);
            $image_base64 = base64_decode($img1);
            $img = time() . '-' . rand(1000, 9999) . '.png';
            $file = $destinationPath . $img;
            file_put_contents($file, $image_base64);
            chmod($file, 0755);
            $upd['image'] = $img;
            }
            $create = GemstoneCategory::where('id', $GemstoneCategory->id)->update($upd);
            if (@$create) {
                session()->flash('success', 'gemstone category updated successfully');
                return redirect()->route('admin.gemstone.category.edit',['id'=> $GemstoneCategory->id]);
            }
            session()->flash('error', 'Something went wrong');
            return redirect()->back()->withInput($request->input());
        }
        session()->flash('error', 'Something went wrong');
        return redirect()->back();
    }
    /**
     *   Method      : deleteGemstoneCategory
     *   Description : Gemstone Category delete
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
    public function deleteGemstoneCategory($id = null)
    {
        $GemstoneCategory = GemstoneCategory::where('id', $id)->first();

        if ( $GemstoneCategory==null) {
            return redirect()->back();
        }
        
             $check = Products::where('product_type','GS')->where('category_id',$id)->where('status','!=','D')->first();
             if($check!="") {
              return redirect()->back()->with('error','Gemstone Category Can Not Be Deleted As It Is Associated With a Gemstone');
            }
            GemstoneCategory::where('id', $GemstoneCategory->id)->delete();
            session()->flash('success', 'Gemstone Category Deleted Successfully');
            return redirect()->back();

    }

     /**
     *   Method      : checkname
     *   Description : duplicate name checking
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
    public function checkname(Request $request)
    {
    
     if (@$request->id) {
      $check = GemstoneCategory::where('category_name',$request->category_name)->where('id','!=',$request->id)->first();
      if (!empty($check)) {
           echo "false";
      }else{
           echo "true";
      }
          
      }else{
         $check = GemstoneCategory::where('category_name',$request->category_name)->first();
          if (!empty($check)) {
               echo "false";
          }else{
               echo "true";
          }
      }

   }
   /**
     *   Method      : manageGemstone
     *   Description : For showing the gemstone listing
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
   public function manageGemstone(Request $request)
    {

        $data = [];

        $data['gemstone_categories'] = GemstoneCategory::orderBy('category_name','asc')->get();
        $data['gemstones'] = Products::with('productPlanets','productRashi')->where('product_type','GS')->where('status','!=','D');


               if (@$request->keyword) {
        // dd($request->keyword);
           $data['gemstones'] = $data['gemstones']->where(function($query){
                $query->Where('product_name','LIKE','%'.request('keyword').'%')
                      ->orWhere('description','LIKE','%'.request('keyword').'%')
                      ->orWhere('product_code','LIKE','%'.request('keyword').'%')
                      ->orWhere('how_to_place','LIKE','%'.request('keyword').'%')
                      ->orWhere('manta_to_chant','LIKE','%'.request('keyword').'%')
                      ->orWhere('significance','LIKE','%'.request('keyword').'%')
                      ->orWhere('placement','LIKE','%'.request('keyword').'%')
                      ->orWhere('product_weight','LIKE','%'.request('keyword').'%');
          })->orWhereHas('subtitle',function($query){
                $query->where('title','LIKE','%'.request('keyword').'%');
        })->orWhereHas('stone',function($query){
                $query->where('name','LIKE','%'.request('keyword').'%');
         })->orWhereHas('productPlanets.planets',function($query){
                $query->where('planet_name','LIKE','%'.request('keyword').'%');
            })->orWhereHas('productRashi.rashis',function($query){
                $query->where('name','LIKE','%'.request('keyword').'%');
            })->orWhereHas('colors',function($query){
                $query->where('color','LIKE','%'.request('keyword').'%');
            })->orWhereHas('shape',function($query){
                $query->where('shapes','LIKE','%'.request('keyword').'%');
            })->orWhereHas('cut',function($query){
                $query->where('cuts','LIKE','%'.request('keyword').'%');
            })->orWhereHas('seller',function($query){
                $query->where('seller_name','LIKE','%'.request('keyword').'%');
            })->orWhereHas('productDeity.deities',function($query){
                $query->where('name','LIKE','%'.request('keyword').'%');
            })->orWhereHas('productNakshtra.nakshatras',function($query){
                    $query->where('name','LIKE','%'.request('keyword').'%');
            });
            $get = $data['gemstones']->get();
            $ids = [];
            foreach ($get  as $key => $value) {
                array_push($ids, $value->id);
            }
            
            $data['gemstones'] = Products::whereIn('id',$ids)->where('status','!=','D')->where('product_type','=','GS');
            // return $data['gemstones'];
       }


        if (@$request->category) {
           $data['gemstones'] = $data['gemstones']->where('category_id',@$request->category);		   

        }
		        // planets
        if (@$request->planets) {
        $planets =  $request->planets;
        $data['gemstones']= $data['gemstones']->whereHas('productPlanets', function ($query) use ( $planets) {
                    $query->whereIn('planet_id',  $planets);
                });
        }

       
        

        // rashi
        if (@$request->rashi) {
        $rashi =  $request->rashi;
        $data['gemstones']= $data['gemstones']->whereHas('productRashi', function ($query) use ( $rashi) {
                    $query->whereIn('rashi_id',  $rashi);
                });
        }

       

       // nakshatra
        if (@$request->nakshatra) {
        $nakshatra =   $request->nakshatra;
        $data['gemstones']= $data['gemstones']->whereHas('productNakshtra', function ($query) use ( $nakshatra) {
                    $query->whereIn('nakshatra_id',  $nakshatra);
                });
      }

       
      // planets
      if (@$request->planets) {
        $planets =  $request->planets;
        $data['gemstones']= $data['gemstones']->whereHas('productPlanets', function ($query) use ( $planets) {
                    $query->whereIn('planet_id',  $planets);
                });
      }
        


      // deity
      if (@$request->deity) {
        $deity =   $request->deity;
       $data['gemstones']= $data['gemstones']->whereHas('productDeity', function ($query) use ($deity) {
                    $query->whereIn('deity_id', $deity);
                });
      }

      

      

      
		if (@$request->rashi) {
           $data['gemstones'] = $data['gemstones']->whereHas('productRashi',function($e) use ($request){
                            $e->where('rashi_id',@$request->rashi);
                    });

        }


        // color

      if (@$request->color) {
        $color =  $request->color;
       $data['gemstones']= $data['gemstones']->whereIn('color_id',$request->color); 
       // return $data['gemstones']->get(); 
      }
		if (@$request->stone_type) {
           $data['gemstones'] = $data['gemstones']->where('stone_type',@$request->stone_type);		   

        }

         if (@$request->avail) {
           $data['gemstones'] = $data['gemstones']->where('availability',@$request->avail);
        }

        if(@$request->amount1!="" && @$request->amount2){
            $data['gemstones'] = $data['gemstones']->whereBetween('price_inr',[$request->amount1,$request->amount2]);
        }

      if(@$request->amount1==null && @$request->amount2){
        $data['gemstones'] = $data['gemstones']->whereBetween('price_inr','<',$request->amount2);
      }

      if (@$request->status) {
           $data['gemstones'] = $data['gemstones']->where('status',@$request->status);
       }
	   if (@$request->lab) {
           $data['gemstones'] = $data['gemstones']->where('lab_certified',@$request->lab);
        }
        // shape-cut-color-title
         if (@$request->title) {
           $data['gemstones'] = $data['gemstones']->where('title_id',@$request->title);
        }

         if (@$request->cut) {
           $data['gemstones'] = $data['gemstones']->where('cut_id',@$request->cut);
        }
        
        if (@$request->shape) {
           $data['gemstones'] = $data['gemstones']->where('shape_id',@$request->shape);
        }
       

        // if (@$request->color) {
        //    $data['gemstones'] = $data['gemstones']->where('color_id',@$request->color);
        // }

		if (@$request->is_cod_available) {
           $data['gemstones'] = $data['gemstones']->where('is_cod_available',@$request->is_cod_available);
        }
        if (@$request->treatment) {
           $data['gemstones'] = $data['gemstones']->whereHas('productTreatment',function($e) use ($request){
                            $e->where('treatment',@$request->treatment);
                    });
        }
        if (@$request->discount){
             
             $data['gemstones']=$data['gemstones']->whereBetween('discount_inr',[1,@$request->discount]);
        }

        if (@$request->weight==0 || @$request->weight!=0){
             
             $data['gemstones']=$data['gemstones']->where('product_weight','LIKE','%'.request('weight').'%');
        }


       $data['gemstone_count'] = $data['gemstones']->count();
       $data['gemstones'] = $data['gemstones']->orderBy('id','desc')->paginate(10);
       $data['request'] = $request->all();
	   $data['max_price']=Products::where('product_type','GS')->max('price_inr');
	   $data['planets']=Planets::orderBy('planet_name','asc')->get();
	   $data['rashi'] = Rashi::orderBy('name','asc')->get();
       $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
       $data['deity'] = Deity::orderBy('name','asc')->get();
       $data['treatment'] = Treatment::orderBy('name','asc')->get();
       $data['color'] = GemstoneColor::orderBy('color','asc')->get();
       $data['shape'] = GemstoneShape::orderBy('shapes','asc')->get();
       $data['cut'] =   GemstoneCut::orderBy('cuts','asc')->get();
       $data['title'] = GemstoneTitle::where('parent_id',0)->orderBy('title','asc')->get();

       return view('admin.modules.gemstones.manage_gemstone',$data);
    }
	/**
     *   Method      : addView
     *   Description : For showing the gemstone add page
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-10
     **/
	public function addView(Request $request)
    {
    	$data = [];
    	$data['categories'] = GemstoneCategory::orderBy('category_name','asc')->get();
        $data['planets'] = Planets::orderBy('planet_name','asc')->get();
        $data['rashi'] = Rashi::orderBy('name','asc')->get();
        $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
        $data['country'] = Country::get();
        $data['treatment'] = Treatment::orderBy('name','asc')->get();
        $data['title'] = GemstoneTitle::where('parent_id',0)->orderBy('title','asc')->get();
        $data['color'] = GemstoneColor::orderBy('color','asc')->get();
        $data['shape'] = GemstoneShape::orderBy('shapes','asc')->get();
        $data['cut'] =   GemstoneCut::orderBy('cuts','asc')->get();
        $data['certificate'] = CertificationName::orderBy('cert_name','asc')->get();
        $data['stone'] = StoneType::orderBy('name','asc')->get();
        $data['sellers'] = SellerMaster::orderBy('seller_name','asc')->get();
        $data['deity'] = Deity::orderBy('name','asc')->get();
    	return view('admin.modules.gemstones.add_gemstone',$data);
    }
	/**
    * Method: productCodeDuplicate
    * Description: To check the product code is duplicate or not by ajax call
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
    public function gemstoneCodeDuplicate(Request $request)
    {
        if(@$request->id){
        $products = Products::where(['product_code' => trim($request->product_code)])->where('status', '!=', 'D')->where('id','!=',$request->id)->first();
        if(@$products) {
            return response('false');
        } else {
            return response('true');
        } 
      

       }else{
        $products = Products::where(['product_code' => trim($request->product_code)])->where('status', '!=', 'D')->first();
        if(@$products) {
            return response('false');
        } else {
            return response('true');
        }
    }
    }
	/**
    * Method: addGemstone
    * Description: To save the gemstone information
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
    public function addGemstone(Request $request)
    {
    	$request->validate([
    		// 'product_code'=>'required|unique:products',
    		// 'product_name'=>'required',
    		'category_id'=>'required',
    		'product_description'=>'required',
    	]);

       // return $request;
        $ins = [];
        if ($request->single_product=="1") {
            $ins['single_product'] = 'Y';
            $ins['price_per_carat_inr'] = $request->price_per_carat_inr;
        $ins['price_per_carat_usd'] = $request->price_per_carat_usd;
        }else{
            $ins['single_product'] = 'N';
            $ins['price_per_carat_inr'] = $request->price_per_carat_inr;
            $ins['price_per_carat_usd'] = $request->price_per_carat_usd;
        }   
        $ins['product_code'] = $request->product_code;
        // $ins['product_name'] = $request->product_name;
        $ins['title_id'] = $request->title;
        $ins['subtitle_id'] = $request->sub_title;
        $ins['category_id'] = $request->category_id;
        $ins['stone_type'] = $request->stone_type;
        $ins['product_weight'] = round($request->product_weight,2);
        $ins['price_inr'] = $request->price_inr;
        $ins['price_usd'] = $request->price_usd;
        $ins['seller_id'] = $request->seller_id;
        $ins['weight_ratti'] = $request->weight_ratti;
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

        $ins['description'] = $request->product_description;
        $ins['meta_title'] = $request->meta_title;
        $ins['meta_description'] = $request->meta_description;
        $ins['color_id'] = $request->color;
        $ins['size'] = $request->size;
        $ins['country_of_origin'] = $request->country_id;
        $ins['shape_id'] = $request->shape;
        $ins['cut_id'] = $request->cut;
        $ins['lab_certified'] = $request->lab;
		if($request->lab=='Y')
		{
			$ins['laboratory_name'] = $request->laboratory_name;
		}
		else
		{
			$ins['laboratory_name'] = null;
		}
        $ins['availability'] = $request->avail;
        $ins['gift_pack_price_inr'] = $request->gift_price_inr;
        $ins['gift_pack_price_usd'] = $request->gift_price_usd;
        $ins['shipping_policy'] = $request->shipping_policy;
        $ins['terms_of_refund'] = $request->terms_of_refund;
        $ins['how_to_place'] = $request->how_to_place;
        $ins['is_cod_available'] = @$request->is_cod_available;
        $ins['product_type'] = 'GS';
        // return @$request->mantra_to_chant;
        $ins['manta_to_chant'] = @$request->mantra_to_chant;
        $ins['significance'] = @$request->significance;
        $ins['additional_certification'] = @$request->additional_certification;
        $ins['composition'] = @$request->composition;
        $ins['dimention_type'] = @$request->dimention_type;
        $ins['transparency'] = @$request->transparency;
        $ins['heft'] = @$request->heft;
        $ins['gravity'] = @$request->gravity;
        $ins['inclusions'] = @$request->inclusions;
        $ins['refractive_index'] = @$request->refractive_index;
        $ins['clarity'] = @$request->clarity;
        $ins['optical_phenomena'] = @$request->optical_phenomena;
        $ins['specific_prosperty'] = @$request->specific_prosperty;
        $ins['refundable'] = @$request->refundable;
        $ins['delivery_days_india'] = @$request->delivery_days_india;
        $ins['delivery_days_outside_india'] = @$request->delivery_days_outside_india;
        if (@$request->refundable=='Y') {
            $ins['refundable_status'] = $request->refundable_status;
        }else{
            $ins['refundable_status'] = null;
        }
        $ins['assurance_guarantee'] = @$request->assurance_guarantee;


        // $ins['gift_pack_price'] = $request->gift_price;
        $products = Products::create($ins);
        $productsId = $products->id;
		$insprice=array();
		$insprice['product_id']=$productsId;
		$insprice['weight']=$request->product_weight;
		$insprice['price_inr']=$request->price_inr;
		$insprice['price_usd']=$request->price_usd;
		$insprice['price_type']='B';
		ProductGemstonePrice::create($insprice);
        // video
		if(@$request->product_video=='Y')
		{
			if (@$request->youtube_link) {
			  if (in_array('www.youtube.com', explode('/', @$request->youtube_link))) {
					$explode = explode('=', @$request->youtube_link);
					$image_name = end($explode);
			   }else{
				  $explode = explode('/', @$request->youtube_link);
				  $image_name = end($explode);
			   }
			   $video = new ProductToImage;
			   $video->type = 'V';
			   $video->image = $image_name;
			   $video->video_link = @$request->youtube_link;
			   $video->product_id = $productsId;
			   $video->save();
			}
		}
		else
		{
			if (@$request->prod_video) {
				$videofilename = time().'_'.$request->prod_video->getClientOriginalName();
				$destinationPath = "storage/app/public/gemstone_video/";
				$request->prod_video->move($destinationPath, $videofilename);
				$video = new ProductToImage;
				$video->type = 'V';
				$video->image = $videofilename;
				$video->product_id = $productsId;
				$video->save();
			}
		}

        // planets
        if ($request->planets) {
        $planets = $request->planets;
        foreach ($planets as $value) {

            $insPlanet = [];
            $insPlanet['product_id'] = $productsId;
            $insPlanet['planet_id'] = $value;
            ProductToPlanet::create($insPlanet);
        }
       }

        // rashis
       if ($request->rashis) {
        $rashis = $request->rashis;
        foreach ($rashis as $value) {

            $insRashi = [];
            $insRashi['product_id'] = $productsId;
            $insRashi['rashi_id'] = $value;
            ProductToRashi::create($insRashi);
        }
      }

      // nakshatras
       if ($request->nakshatra) {
        $nakshatras = $request->nakshatra;
        foreach ($nakshatras as $value) {

            $insNak = [];
            $insNak['product_id'] = $productsId;
            $insNak['nakshatra_id'] = $value;
            ProductToNakshatras::create($insNak);
        }
       }

        // deity
       if ($request->deity) {
        $deitys = $request->deity;
        foreach ($deitys as $value) {

            $insDeity = [];
            $insDeity['product_id'] = $productsId;
            $insDeity['deity_id'] = $value;
            ProductToDeity::create($insDeity);
        }
     }
	  // planets
        if ($request->treatments) {
        $treatments = $request->treatments;
        foreach ($treatments as $value) {

            $insTreatment = [];
            $insTreatment['gemstone_id'] = $productsId;
            $insTreatment['treatment'] = $value;
            GemstoneToTreatment::create($insTreatment);
        }
       }

         $upd = [];
         $title_slug = GemstoneTitle::where('id',$request->title)->first();
         $sub_title_slug = GemstoneTitle::where('id',$request->sub_title)->first();
         $upd['slug'] = Str::slug($title_slug->title).'-'.$productsId;
         // return $upd['slug'];
		 $products = Products::where('id',$productsId)->update($upd);
         if(@$request->images)
            {
                $i = 0;
                foreach ($request->images as $key => $value) {

                        $filename = time().'_'.$value->getClientOriginalName();
                        $destinationPath = "storage/app/public/gemstone/";
                        $value->move($destinationPath, $filename);

                        // call to image resize function 300*300
                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/small_gemstone_image/", 'dimension' => [246, 240], 'filename' =>$filename]);

                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/gemstone_big_image/", 'dimension' => [437, 362], 'filename' =>$filename]);
                        
                        $reqData4 = array(
                            'product_id' => $productsId,
                            'image' => $filename,
                            'type'=>'I',
                        );
                        if($i == 0)
                        {
                            // this will check if there is any one existing default image associated with the product or not
                            $default_check = ProductToImage::where([
                                                'product_id' => $productsId,
                                                'is_default' => 'Y',
                                            ])->count();

                            ///if no default image associated with product then is_default Y otherwise is_default N
                            if(@$default_check == 0)
                            {
                                $reqData4['is_default'] = 'Y';
                            }
                            else
                            {
                                $reqData4['is_default'] = 'N';
                            }
                        }

                        $insert_imasge = ProductToImage::create($reqData4);
                        $i++;

                }
            }

         return redirect()->back()->with('success','Gemstone added successfully');
    }
	/**
    * Method: checkGemstone
    * Description: To check the gemstone name is duplicate or not for the category chosen by ajax call
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
	public function checkGemstone(Request $request)
    {
        if (@$request->id) {
            // return $request->id;
            $checkproduct = Products::where('product_name',$request->product_name)->where('category_id',$request->category_id)->where('id','!=',$request->id)->where('status','!=','D')->where('product_type','GS')->first();
            if ($checkproduct!="") {
                echo "hey";
            }else{
                echo "not found";
            }
        }else{
        $checkproduct = Products::where('product_name',$request->product_name)->where('category_id',$request->category_id)->where('status','!=','D')->where('product_type','GS')->first();
        if ($checkproduct!="") {
            echo "found";
        }else{
            echo "not found";
        }
    }
    }
	/**
    * Method: editView
    * Description: To show the gemstone edit page
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
	public function editView($id)
    {
        $data = [];
        $check = Products::where('id',$id)->where('status','!=','D')->first();
        if ($check==null) {
            return redirect()->back();
        }
        $data['data'] = Products::where('id',$id)->where('status','!=','D')->first();
        $data['categories'] = GemstoneCategory::orderBy('category_name','asc')->get();
        $data['planets'] = Planets::orderBy('planet_name','asc')->get();
        $data['rashi'] = Rashi::orderBy('name','asc')->get();
        $data['country'] = Country::get();
        $data['treatment'] = Treatment::orderBy('name','asc')->get();
        $data['title'] =GemstoneTitle::where('parent_id',0)->orderBy('title','asc')->get();
        $data['subtitle'] = GemstoneTitle::where('parent_id',$check->title_id)->orderBy('title','asc')->get();
        $data['color'] = GemstoneColor::orderBy('color','asc')->get();
        $data['shape'] = GemstoneShape::orderBy('shapes','asc')->get();
        $data['cut'] =   GemstoneCut::orderBy('cuts','asc')->get();
        $data['certificate'] = CertificationName::orderBy('cert_name','asc')->get();
        $data['stone'] = StoneType::orderBy('name','asc')->get();
        $data['sellers'] = SellerMaster::orderBy('seller_name','asc')->get();
        $data['deity'] = Deity::orderBy('name','asc')->get();
        $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();

        $data['selected_deity'] = ProductToDeity::where('product_id',$id)->pluck('deity_id')->toArray();
        $data['selected_planet'] = ProductToPlanet::where('product_id',$id)->pluck('planet_id')->toArray();
        $data['selected_rashi'] = ProductToRashi::where('product_id',$id)->pluck('rashi_id')->toArray();
        $data['selected_nakshatra'] = ProductToNakshatras::where('product_id',$id)->pluck('nakshatra_id')->toArray();
        $data['selected_treatment'] = GemstoneToTreatment::where('gemstone_id',$id)->pluck('treatment')->toArray();

         // check-if this puja has order or not 
        $order = OrderDetails::where('product_id',$id)->first();
        if (@$order!="") {
              $data['dis'] = 'disable';
        }
        return view('admin.modules.gemstones.edit_gemstone',$data);
    }
	/**
    * Method: updateGemstone
    * Description: To update the gemstone information
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
    public function updateGemstone(Request $request)
    {
		//dd($request->all());
        $request->validate([
            // 'product_name'=>'required',
            'category_id'=>'required',
            'product_description'=>'required',
        ]);

        $check = Products::where('id',$request->product_id)->first();
        $check2 = ProductToImage::where('product_id',$request->product_id)->where('is_default','Y')->first();

        $upd = [];
        if (@$request->product_code) {
            $upd['product_code'] = $request->product_code;
        }
        // $upd['product_name'] = $request->product_name;
        $upd['title_id'] = $request->title;
        $upd['subtitle_id'] = $request->sub_title;
        $upd['category_id'] = $request->category_id;
        $upd['stone_type'] = $request->stone_type;
        $upd['product_weight'] = round($request->product_weight,2);
        $upd['weight_ratti'] = $request->weight_ratti;
        $upd['seller_id'] = $request->seller_id;
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

        if ($request->single_product=="1") {
            $upd['single_product'] = 'Y';
            $upd['price_per_carat_inr'] = $request->price_per_carat_inr;
            $upd['price_per_carat_usd'] = $request->price_per_carat_usd;
        }else{
            $upd['single_product'] = 'N';
            $upd['price_per_carat_inr'] = $request->price_per_carat_inr;
            $upd['price_per_carat_usd'] = $request->price_per_carat_usd;
        }  
		
        $upd['price_inr'] = $request->price_inr;
        $upd['price_usd'] = $request->price_usd;
		// $upd['price_per_carat_inr'] = $request->price_per_carat_inr;
  //       $upd['price_per_carat_usd'] = $request->price_per_carat_usd;
        $upd['description'] = $request->product_description;
        $upd['meta_title'] = $request->meta_title;
        $upd['meta_description'] = $request->meta_description;
        $upd['color_id'] = $request->color;
        $upd['size'] = $request->size;
        $title_slug = GemstoneTitle::where('id',$request->title)->first();
        $sub_title_slug = GemstoneTitle::where('id',$request->sub_title)->first();
        $upd['slug'] = Str::slug($title_slug->title).'-'.$request->product_id;
        $upd['country_of_origin'] = $request->country_id;
        $upd['shape_id'] = $request->shape;
        $upd['cut_id'] = $request->cut;
        $upd['lab_certified'] = $request->lab;
        $upd['manta_to_chant'] = @$request->mantra_to_chant;
        $upd['significance'] = @$request->significance;
        if($request->lab=='Y')
		{
			$upd['laboratory_name'] = $request->laboratory_name;
		}
		else
		{
			$upd['laboratory_name'] = null;
		}
        $upd['availability'] = $request->avail;
        $upd['gift_pack_price_inr'] = $request->gift_price_inr;
        $upd['gift_pack_price_usd'] = $request->gift_price_usd;
		$upd['shipping_policy'] = $request->shipping_policy;
        $upd['terms_of_refund'] = $request->terms_of_refund;
        $upd['how_to_place'] = $request->how_to_place;
        $upd['is_cod_available'] = @$request->is_cod_available;
        $upd['additional_certification'] = @$request->additional_certification;

        $upd['composition'] = @$request->composition;
        $upd['dimention_type'] = @$request->dimention_type;
        $upd['transparency'] = @$request->transparency;
        $upd['heft'] = @$request->heft;
        $upd['gravity'] = @$request->gravity;
        $upd['inclusions'] = @$request->inclusions;
        $upd['refractive_index'] = @$request->refractive_index;
        $upd['clarity'] = @$request->clarity;
        $upd['optical_phenomena'] = @$request->optical_phenomena;
        $upd['specific_prosperty'] = @$request->specific_prosperty;
        $upd['refundable'] = @$request->refundable;
        $upd['delivery_days_india'] = @$request->delivery_days_india;
        $upd['delivery_days_outside_india'] = @$request->delivery_days_outside_india;
        if (@$request->refundable=='Y') {
            $upd['refundable_status'] = $request->refundable_status;
        }else{
            $upd['refundable_status'] = null;
        }
        $upd['assurance_guarantee'] = @$request->assurance_guarantee;
        
		// video
		if(@$request->product_video=='Y')
		{
			ProductToImage::where('product_id',$request->product_id)->where('type','V')->delete();
			if (@$request->youtube_link) {
			  if (in_array('www.youtube.com', explode('/', @$request->youtube_link))) {
					$explode = explode('=', @$request->youtube_link);
					$image_name = end($explode);
			   }else{
				  $explode = explode('/', @$request->youtube_link);
				  $image_name = end($explode);
			   }
			   //dd($image_name);
			   $video = new ProductToImage;
			   $video->type = 'V';
			   $video->image = $image_name;
			   $video->video_link = @$request->youtube_link;
			   $video->product_id = $request->product_id;
			   $video->save();
			}
		}
		elseif(@$request->product_video=='U' && @$request->prod_video)
		{
			ProductToImage::where('product_id',$request->product_id)->where('type','V')->delete();
			if (@$request->prod_video) {
				$videofilename = time().'_'.$request->prod_video->getClientOriginalName();
				$destinationPath = "storage/app/public/gemstone_video/";
				$request->prod_video->move($destinationPath, $videofilename);
				$video = new ProductToImage;
				$video->type = 'V';
				$video->image = $videofilename;
				$video->product_id = $request->product_id;
				$video->save();
			}
		}
        // planets
        $planets =$request->planets;
        if (@$request->planets) {

        foreach ($planets as $item) {
            $insPlanet = [];
            $insPlanet['product_id'] = $request->product_id;
            $insPlanet['planet_id'] = $item;
            $checkAvailable = ProductToPlanet::where('product_id', $request->product_id)->where('planet_id', $item)->first();
            if ($checkAvailable == null) {
                ProductToPlanet::create($insPlanet);
            }
        }
      }
     if ($planets) {
        ProductToPlanet::where('product_id', $request->product_id)->whereNotIn('planet_id', $planets)->delete();
      }else{
        ProductToPlanet::where('product_id', $request->product_id)->delete();
      } 
     

     // rashi

     $rashis = $request->rashis;
        if (@$request->rashis) {

        foreach ($rashis as $item) {
            $insRashi = [];
            $insRashi['product_id'] = $request->product_id;
            $insRashi['rashi_id'] = $item;
            $checkAvailable = ProductToRashi::where('product_id', $request->product_id)->where('rashi_id', $item)->first();
            if ($checkAvailable == null) {
                ProductToRashi::create($insRashi);
            }
        }
      }
      if ($rashis) {
        ProductToRashi::where('product_id', $request->product_id)->whereNotIn('rashi_id', $rashis)->delete();
      }else{
        ProductToRashi::where('product_id', $request->product_id)->delete();
      }
     

          // deity
    $deity = $request->deity;
        if (@$request->deity) {

        foreach ($deity as $item) {
            $indDeity = [];
            $indDeity['product_id'] = $request->product_id;
            $indDeity['deity_id'] = $item;
            $checkAvailable = ProductToDeity::where('product_id', $request->product_id)->where('deity_id', $item)->first();
            if ($checkAvailable == null) {
                ProductToDeity::create($indDeity);
            }
        }
      }
      if ($deity) {
        ProductToDeity::where('product_id', $request->product_id)->whereNotIn('deity_id', $deity)->delete();
      }else{
        ProductToDeity::where('product_id', $request->product_id)->delete();
      }
     

     // nakshtrats
     $nakshatra = $request->nakshatra;
        if (@$request->nakshatra) {

        foreach ($nakshatra as $item) {
            $insnakshatra = [];
            $insnakshatra['product_id'] = $request->product_id;
            $insnakshatra['nakshatra_id'] = $item;
            $checkAvailable = ProductToNakshatras::where('product_id', $request->product_id)->where('nakshatra_id', $item)->first();
            if ($checkAvailable == null) {
                ProductToNakshatras::create($insnakshatra);
            }
        }
      }
     if ($nakshatra) {
        ProductToNakshatras::where('product_id', $request->product_id)->whereNotIn('nakshatra_id', $nakshatra)->delete();
      }else{
        ProductToNakshatras::where('product_id', $request->product_id)->delete();
      } 
     
	 
	 
	 // treatments
        $treatments = $request->treatments;
        if (@$request->treatments) {

        foreach ($treatments as $item) {
            $insTreatment = [];
            $insTreatment['gemstone_id'] = $request->product_id;
            $insTreatment['treatment'] = $item;
            $checkAvailable = GemstoneToTreatment::where('gemstone_id', $request->product_id)->where('treatment', $item)->first();
            if ($checkAvailable == null) {
                GemstoneToTreatment::create($insTreatment);
            }
        }
      }
      if ($treatments) {
        GemstoneToTreatment::where('gemstone_id', $request->product_id)->whereNotIn('treatment', $treatments)->delete();
      }else{
        GemstoneToTreatment::where('gemstone_id', $request->product_id)->delete();
      }
     

     $update = Products::where('id', $request->product_id)->update($upd);
			$insprice=array();
			$insprice['weight']=$request->product_weight;
			$insprice['price_inr']=$request->price_inr;
			$insprice['price_usd']=$request->price_usd;
			ProductGemstonePrice::where('product_id',$request->product_id)->where('price_type','B')->update($insprice);
            if(@$request->images)
            {
                // $remove = explode(',', $request->change_image);
                $i = 0;
                foreach ($request->images as $key => $value) {

                        $filename = time().'_'.$value->getClientOriginalName();
                        $destinationPath = "storage/app/public/gemstone/";
                        $value->move($destinationPath, $filename);

                        // call to image resize function 300*300
                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/small_gemstone_image/", 'dimension' => [246, 240], 'filename' =>$filename]);

                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/gemstone_big_image/", 'dimension' => [437, 362], 'filename' =>$filename]);

                        $reqData4 = array(
                            'product_id' => $request->product_id,
                            'image' => $filename,
                            'type' => 'I',
                        );
                        if (@$check2==null) {
                            if($i == 0)
                        {
                            // this will check if there is any one existing default image associated with the product or not
                            $default_check = ProductToImage::where([
                                                'product_id' => $request->product_id,
                                                'is_default' => 'Y'
                                            ])->count();

                            ///if no default image associated with product then is_default Y otherwise is_default N
                            if(@$default_check == 0)
                            {
                                $reqData4['is_default'] = 'Y';
                            }
                            else
                            {
                                $reqData4['is_default'] = 'N';
                            }
                        }
                        }

                        $insert_imasge = ProductToImage::create($reqData4);
                        $i++;

                }
            }
        return redirect()->back()->with('success','Gemstone updated successfully');
    }
	/**
    * Method: deleteGemstoneImage
    * Description: To delete the gemstone image
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
	public function deleteGemstoneImage($id)
	{
		$check = ProductToImage::where('id',$id)->first();
		$check2 = ProductToImage::where('product_id',$check->product_id)->count();
		 if($check2 > 1)
		 {
					if($check->is_default == 'Y') {
						return redirect()->back()->with('error','Default Images Can Not Be Deleted');
			}
			elseif($check->is_default == 'N')
			{

							@unlink('storage/app/public/gemstone/' . $check->image);
							@unlink('storage/app/public/small_gemstone_image/' . $check->image);
							 @unlink('storage/app/public/gemstone_big_image/' . $check->image);
							// delete image from ProductToImage table
							$delete = ProductToImage::where('id',$id)->delete();

							return redirect()->back()->with('success','Image deleted successfully');
			}

		}else{
		   return redirect()->back()->with('error','Image can not be deleted as it is default image');
		}
	}
	/**
    * Method: changedefault
    * Description: To change the default gemstone image
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
    public function changedefault(Request $request)
    {
        $check = ProductToImage::where('id',$request->is_default)->first();
        $check2 = ProductToImage::where('product_id',$check->product_id)->where('is_default','Y')->first();
        if (@$check2) {
           $update = $check2->update(['is_default' => 'N']);
        }

        // update new_deafult image
        ProductToImage::where(['id' => $request->is_default])->update(['is_default' => 'Y']);
        return redirect()->back()->with('success','Default image changes successfully');
    }
	/**
    * Method: showHome
    * Description: To show gemstone in home page
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
	public function showHome($id)
    {
        $check = Products::where('id',$id)->where('status','!=','D')->first();
        if (@$check==null) {
            return redirect()->back();
        }
        if (@$check->is_show=="Y") {
            $update = Products::where('id',$id)->where('status','!=','D')->update(['is_show'=>'N']);
            return redirect()->back()->with('success','Gemstone Remove From Home Successfully');
        }else{
            $update = Products::where('id',$id)->where('status','!=','D')->update(['is_show'=>'Y']);
            return redirect()->back()->with('success','Gemstone Show At Home Successfully');
        }
    }
	/**
    * Method: status
    * Description: To change the gemstone status
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
	public function status($id)
    {
        $data = Products::where('id',$id)->where('status','!=','D')->first();
        if ($data==null) {
            return redirect()->back();
        }
        if ($data->status=="A") {
            $inactive = Products::where('id',$id)->update(['status'=>'I']);
            return redirect()->back()->with('success','Gemstone Status Deactivated Successfully');
        }

        if ($data->status=="I") {
            $inactive = Products::where('id',$id)->update(['status'=>'A']);
            return redirect()->back()->with('success','Gemstone Status Activated Successfully');
        }
    }
	/**
    * Method: gemstoneDelete
    * Description: To delete the gemstone
    * Author: Madhuchandra
    * Date: 2021-SEPT-10
    */
    public function gemstoneDelete($id)
    {
        $data = Products::where('id',$id)->where('status','!=','D')->first();
        if ($data==null) {
            return redirect()->back();
        }
        $delete = Products::where('id',$id)->update(['status'=>'D']);
        return redirect()->back()->with('success','Gemstone Deleted Successfully');
    }
	/**
     *   Method      : manageGemstonePrice
     *   Description : For showing the gemstone price listing
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-16
     **/
	public function manageGemstonePrice(Request $request)
    {
		$data = [];
		$data['gemstone_price'] = ProductGemstonePrice::with('gemstoneDetails')->whereHas('gemstoneDetails',function($e) use ($request){
                            $e->where('status','!=','D');
                    });;
		if(@$request->all())
		{
			if(@$request->gemstone_id)
			{
				$data['gemstone_price']=$data['gemstone_price']->where('product_id',@$request->gemstone_id);
			}			
		}
		$data['gemstone_price']=$data['gemstone_price']->orderBy('id','Desc')->paginate(20);
		$data['gemstones'] = Products::where('product_type','GS')->where('status','!=','D')->get();
		return view('admin.modules.gemstone_price.manage_gemstone_price',$data);
    }
	/**
     *   Method      : addGemstonePrice
     *   Description : For showing the add gemstone price page
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-16
     **/
	public function addGemstonePrice($id='')
    {
		$data = [];
		$data['gemstones'] = Products::where('product_type','GS')->where('status','!=','D')->get();
		if(@$id)
		{
			$data['gemstone_details']=Products::where('id',$id)->where('product_type','GS')->where('status','!=','D')->first();
			if($data['gemstone_details']==null)
			{
				return redirect()->back()->with('error','Something went wrong');
			}
			$data['gemstone_price_details']=ProductGemstonePrice::where('product_id',$id)->orderBy('price_type','Asc')->orderBy('price_inr','Desc')->get();
		}
		return view('admin.modules.gemstone_price.add_gemstone_price',$data);
    }
	/**
     *   Method      : saveGemstonePrice
     *   Description : For adding the gemstone price
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-20
     **/
	public function saveGemstonePrice(Request $request)
    {
		$response = array(
            'jsonrpc'=> '2.0'
        );
		//dd($request->all());
		if($request->all())
		{
			$gemstone_details=ProductGemstonePrice::where('product_id',$request->gemstone_id)->where('weight',@$request->weight)->count();
			if($gemstone_details>0)
			{
				$response['error']='error';
				$response['message']='The weight is already added';
			}
			else
			{
				$price_id=ProductGemstonePrice::create([
				  'product_id' =>$request->gemstone_id,
				  'weight' => @$request->weight,
				  'price_inr' => @$request->price_inr,
				  'price_usd' =>  @$request->price_usd, 
				  'price_type' =>  @$request->price_type, 
			  ]); 
			  $response['success']='success';
			  $response['price_id']=$price_id->id;
			}			  
		}
		else
		{
			$response['error']='error';
			$response['message']='';
		}
		return response()->json($response);
		
    }
	/**
	*Method: fetchGemstonePrice
	*Description: To fetch gmestone base price from a ajax call
	*Author: Madhuchandra
	*Date: 2021-SEPT-16
	*/
    public function fetchGemstonePrice(Request $request)
	{
		$response = array(
            'jsonrpc'=> '2.0'
        );
		if(@$request->all())
		{
			$gemstone_details=Products::where('id',$request->gemstone_id)->first();
			if(@$gemstone_details)
			{
				$gemstone_price_details=ProductGemstonePrice::where('product_id',$request->gemstone_id)->orderBy('price_type','Asc')->orderBy('price_inr','Desc')->get();
				$html='';
				if(@$gemstone_price_details->isNotEmpty())
				{
					$html.='<div class="table-responsive">
											  <table class="table">
												<thead>
												  <tr>
													<th>Weight (In Carat):</th>
													<th>Price (In INR):</th>
													<th>Price (In USD):</th>
													<th>Price Type:</th>
													<th></th>
												  </tr>
												</thead>
												<tbody class="added_table_data">';
					foreach(@$gemstone_price_details as $prices)
					{
						if($prices->price_type=='A')
						{
							$html.='<tr class="added_data_'.$prices->id.'">
														<td>'.$prices->weight.'</td>
														<td>+ '.$prices->price_inr.'</td>
														<td>+ '.$prices->price_usd.'</td>
														<td>Increasing</td>
														<td><i class="fa fa-times remove_price" data-id="'.$prices->id.'"></i></td>
													</tr>';
							
						}
						elseif($prices->price_type=='D')
						{
							$html.='<tr class="added_data_'.$prices->id.'">
														<td>'.$prices->weight.'</td>
														<td>- '.$prices->price_inr.'</td>
														<td>- '.$prices->price_usd.'</td>
														<td>Decreasing</td>
														<td><i class="fa fa-times remove_price" data-id="'.$prices->id.'"></i></td>
													</tr>';
							
						}
						else
						{
							$html.='<tr class="added_data_'.$prices->id.'">
														<td>'.$prices->weight.'</td>
														<td>'.$prices->price_inr.'</td>
														<td>'.$prices->price_usd.'</td>
														<td>Base</td>
														<td></td>
													</tr>';
						}
						
					}
					$html.='</tbody>
						  </table>
						</div>';
				}
				$response['html']=$html;
				$response['success']='success';
			}
			else
			{
				$response['error']='error';
			}
		}
		else
		{
			$response['error']='error';
		}
		return response()->json($response);
	}
	/**
     *   Method      : deleteGemstonePrice
     *   Description : For deleting the gemstone price
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-20
     **/
	
	public function deleteGemstonePrice(Request $request)
    {
		$response = array(
            'jsonrpc'=> '2.0'
        );
		if(@$request->all())
		{
			$data = ProductGemstonePrice::where('id',$request->id)->first();
			if($data==null) {
				$response['error']='error';
			}
			else
			{
				$delete = ProductGemstonePrice::where('id',$request->id)->delete();
				$response['success']='success';
			}
			
		}
		else
		{
			$response['error']='error';
		}
		return response()->json($response);
    }



    public function getSubtitle(Request $request)
    {
        $data = GemstoneTitle::where('parent_id',$request->title)->orderBy('title','asc')->get();
        $response=array();
        $result="<option value=''>Select Sub Title</option>";
        if(@$data->isNotEmpty())
        {
            foreach($data as $rows)
            {
                if(@$request->id==$rows->id)
                {
                    $result.="<option value='".$rows->id."' selected >".$rows->title."</option>";
                }

                else
                {
                    $result.="<option value='".$rows->id."' >".$rows->title."</option>";
                }
                
            }
        }
        $response['sub_title']=$result;
        return response()->json($response);
    }


    public function deleteCategoryImage(Request $request)
    {
      $data = GemstoneCategory::where('id',$request->id)->first();
      @unlink(storage_path('app/public/gemstone_category/' . $data->image));
      GemstoneCategory::where('id',$request->id)->update(['image'=>'']);
      echo "success";
    }

    public function deleteVideo(Request $request)
    {
      ProductToImage::where('type','V')->where('product_id',$request->id)->update(['image'=>'']);
      echo "success";
    }
}
