<?php

namespace App\Http\Controllers\Admin\Modules\ManageProducts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Products;
use App\Models\ProductToImage;
use App\Models\Purpose;
use App\Models\SellerMaster;
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
use App\Models\OrderDetails;
use App\Models\CertificationName;
class ManageProductController extends Controller
{
    //

    public function index(Request $request)
    {

        $data = [];

        $data['product_categories'] = ProductCategory::where('status','!=','D')->where('label','C')->orderBy('name','asc')->get();
        $data['sellers'] = SellerMaster::orderBy('seller_name','asc')->get();
        $data['products'] = Products::with('productPlanets')->where('status','!=','D')->where('product_type','AP');

        if (@$request->keyword) {
        // dd($request->keyword);
        $keyword = @$request->keyword;
           $data['products'] = $data['products']->where(function($query){
                $query->where('product_name','LIKE','%'.request('keyword').'%');
                    $query->orWhere('color','LIKE','%'.request('keyword').'%');
                    $query->orWhere('size','LIKE','%'.request('keyword').'%');
                    $query->orWhere('significance','LIKE','%'.request('keyword').'%');
                    $query->orWhere('description','LIKE','%'.request('keyword').'%');
                    $query->orWhere('product_code','LIKE','%'.request('keyword').'%');
                    $query->orWhere('how_to_place','LIKE','%'.request('keyword').'%');
          })->orWhereHas('productPlanets.planets',function($query){
                $query->where('planet_name','LIKE','%'.request('keyword').'%');
                })->orWhereHas('productRashi.rashis',function($query){
                    $query->where('name','LIKE','%'.request('keyword').'%');
                })->orWhereHas('productDeity.deities',function($query){
                $query->where('name','LIKE','%'.request('keyword').'%');
                })->orWhereHas('productNakshtra.nakshatras',function($query){
                    $query->where('name','LIKE','%'.request('keyword').'%');
                })->orWhereHas('seller',function($query){
                $query->where('seller_name','LIKE','%'.request('keyword').'%');
              });
            $get =  $data['products']->get();
            $ids = [];
            foreach ($get  as $key => $value) {
                array_push($ids, $value->id);
            }
             $data['products'] = Products::whereIn('id',$ids)->where('status','A')->where('product_type','AP');
       }


        if (@$request->category) {
           $data['products'] = $data['products']->where('category_id',@$request->category);
		   $data['sub_categories']=ProductCategory::where('parent_id',@$request->category)->where('status','!=','D')->where('label','S')->get();

        }
		if (@$request->sub_category) {
           $data['products'] = $data['products']->where('sub_category_id',@$request->sub_category);

        }
		
        // planets
        if (@$request->planets) {
        $planets =  $request->planets;
        $data['products']= $data['products']->whereHas('productPlanets', function ($query) use ( $planets) {
                    $query->whereIn('planet_id',  $planets);
                });
        }

        
        

        // rashi
        if (@$request->rashi) {
        $rashi =  $request->rashi;
        $data['products']= $data['products']->whereHas('productRashi', function ($query) use ( $rashi) {
                    $query->whereIn('rashi_id',  $rashi);
                });
        }

       

       // nakshatra
        if (@$request->nakshatra) {
        $nakshatra =  $request->nakshatra;
        $data['products']= $data['products']->whereHas('productNakshtra', function ($query) use ( $nakshatra) {
                    $query->whereIn('nakshatra_id',  $nakshatra);
                });
      }

       
      // planets
      // if (@$request->planets) {
      //   $planets =  $request->planets);
      //   $data['products']= $data['products']->whereHas('productPlanets', function ($query) use ( $planets) {
      //               $query->whereIn('planet_id',  $planets);
      //           });
      // }
      //   if (@$request->planets) {
      //   $planets =  explode(",", $request->planets);
      //   $data['planetArray'] = $planets;
      // }


      // deity
      if (@$request->deity) {
        $deity =  $request->deity;
       $data['products']= $data['products']->whereHas('productDeity', function ($query) use ($deity) {
                    $query->whereIn('deity_id', $deity);
                });
      }

      


        if (@$request->seller) {
           $data['products'] = $data['products']->where('seller_id',@$request->seller);
        }

        if (@$request->purpose) {
           $data['products'] = $data['products']->where('purpose_id',@$request->purpose);
        }

         if (@$request->avail) {
           $data['products'] = $data['products']->where('availability',@$request->avail);
        }

        if(@$request->amount1!="" && @$request->amount2){
            $data['products'] = $data['products']->whereBetween('price_inr',[$request->amount1,$request->amount2]);
        }

      if(@$request->amount1==null && @$request->amount2){
        $data['products'] = $data['products']->whereBetween('price_inr','<',$request->amount2);
      }

      if (@$request->discount){
             
             $data['products']=$data['products']->whereBetween('discount_inr',[1,@$request->discount]);
        }

      // if(@$request->amount1==null && @$request->amount2){
      //   $data['products'] = $data['products']->whereBetween('price_inr','<',$request->amount2);
      // }


      if (@$request->status) {
           $data['products'] = $data['products']->where('status',@$request->status);
       }


       $data['product_count'] = $data['products']->count();
       $data['products'] = $data['products']->orderBy('id','desc')->paginate(10);
       $data['request'] = $request->all();
	   $data['max_price']=Products::where('product_type','AP')->max('price_inr');
	   $data['planets']=Planets::orderBy('planet_name','asc')->get();
       $data['rashi'] = Rashi::orderBy('name','asc')->get();
       $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
       $data['deity'] = Deity::orderBy('name','asc')->get();
       $data['purpose'] = Purpose::orderBy('name','asc')->get();
       // return  $data['purpose'];
       return view('admin.modules.products.manage_products',$data);
    }



    public function addView(Request $request)
    {
    	$data = [];
    	$data['categories'] = ProductCategory::where('status','A')->where('label','C')->orderBy('name','asc')->get();
        $data['purpose'] = Purpose::orderBy('name','asc')->get();
        $data['seller'] = SellerMaster::orderBy('id','desc')->get();
        $data['planets'] = Planets::orderBy('planet_name','asc')->get();
        $data['rashi'] = Rashi::orderBy('name','asc')->get();
        $data['deity'] = Deity::orderBy('name','asc')->get();
        $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
        $data['country'] = Country::get();
        $data['certificate'] = CertificationName::orderBy('cert_name','asc')->get();
    	return view('admin.modules.products.add_products',$data);
    }
	/**
    * Method: productCodeDuplicate
    * Description: To check the product code is duplicate or not by ajax call
    * Author: Madhuchandra
    * Date: 2021-AUGUST-31
    */
    public function productCodeDuplicate(Request $request)
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
    public function addproduct(Request $request)
    {
    	$request->validate([
    		'product_code'=>'required|unique:products',
    		'product_name'=>'required',
    		'category_id'=>'required',
    		'product_description'=>'required',
    	]);

       // return $request;
        $ins = [];
        $ins['product_code'] = $request->product_code;
        $ins['product_name'] = $request->product_name;
        $ins['category_id'] = $request->category_id;
        $ins['sub_category_id'] = $request->sub_category_id;
        $ins['product_weight'] = $request->product_weight;
        $ins['price_inr'] = $request->price_inr;
        $ins['price_usd'] = $request->price_usd;
        $ins['shipable'] = $request->ship;
        $ins['clarity'] = $request->clarity;
        $ins['significance'] = $request->significance;
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
        $ins['color'] = $request->color;
        $ins['size'] = $request->size;
        $ins['country_of_origin'] = $request->country_id;
        $ins['shape_cut'] = $request->shape;
        $ins['purpose_id'] = $request->purpose;
        $ins['manta_to_chant'] = $request->mantra_to_chant;
        $ins['placement'] = $request->placement;
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

        $ins['seller_id'] = $request->seller_id;
        $ins['shipping_policy'] = $request->shipping_policy;
        $ins['terms_of_refund'] = $request->terms_of_refund;
        $ins['how_to_place'] = $request->how_to_place;
        $ins['is_cod_available'] = @$request->is_cod_available;
        $ins['refundable'] = @$request->refundable;
        $ins['delivery_days_india'] = @$request->delivery_days_india;
        $ins['delivery_days_outside_india'] = @$request->delivery_days_outside_india;
        $ins['specific_prosperty'] = $request->specific_prosperty;
        if (@$request->refundable=='Y') {
            $ins['refundable_status'] = $request->refundable_status;
        }else{
            $ins['refundable_status'] = null;
        }
        $ins['assurance_guarantee'] = @$request->assurance_guarantee;
        // $ins['gift_pack_price'] = $request->gift_price;
        $products = Products::create($ins);
        $productsId = $products->id;
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
				$destinationPath = "storage/app/public/product_video/";
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



         $upd = [];
         $upd['slug'] = Str::slug($products->product_name, '-').'-'.$productsId;
		 $products = Products::where('id',$productsId)->update($upd);
         if(@$request->images)
            {
                $i = 0;
                foreach ($request->images as $key => $value) {

                        $filename = time().'_'.$value->getClientOriginalName();
                        $destinationPath = "storage/app/public/Products/";
                        $value->move($destinationPath, $filename);

                        // call to image resize function 300*300
                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/small_product_image/", 'dimension' => [246, 240], 'filename' =>$filename]);

                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/product_big_image/", 'dimension' => [437, 362], 'filename' =>$filename]);
                        // call to image resize function 150*150
                        // ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => $destinationPath.'thumbs/', 'dimension' => [150, 150], 'filename' =>$filename]);

                        // // call to image resize function 600*600
                        // ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => $destinationPath.'big/', 'dimension' => [600, 600], 'filename' =>$filename]);
                        // step to insert to product_to_images table
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

         return redirect()->back()->with('success','Product added successfully');
    }

    public function checkproduct(Request $request)
    {
        if (@$request->id) {
            // return $request->id;
            $checkproduct = Products::where('product_name',$request->product_name)->where('category_id',$request->category_id)->where('id','!=',$request->id)->where('status','!=','D')->where('product_type','AP')->first();
            if ($checkproduct!="") {
                echo "hey";
            }else{
                echo "not found";
            }
        }else{
        $checkproduct = Products::where('product_name',$request->product_name)->where('category_id',$request->category_id)->where('status','!=','D')->where('product_type','AP')->first();
        if ($checkproduct!="") {
            echo "found";
        }else{
            echo "not found";
        }
    }
    }

    public function status($id)
    {
        $data = Products::where('id',$id)->where('status','!=','D')->first();
        if ($data==null) {
            return redirect()->back();
        }
        if ($data->status=="A") {
            $inactive = Products::where('id',$id)->update(['status'=>'I']);
            return redirect()->back()->with('success','Product Status Deactivated Successfully');
        }

        if ($data->status=="I") {
            $inactive = Products::where('id',$id)->update(['status'=>'A']);
            return redirect()->back()->with('success','Product Status Activated Successfully');
        }
    }

    public function product_delete($id)
    {
        $data = Products::where('id',$id)->where('status','!=','D')->first();
        if ($data==null) {
            return redirect()->back();
        }
        $delete = Products::where('id',$id)->update(['status'=>'D']);
        return redirect()->back()->with('success','Product Deleted Successfully');
    }

    public function editView($id)
    {
        $data = [];
        $check = Products::where('id',$id)->where('status','!=','D')->first();
        if ($check==null) {
            return redirect()->back();
        }
        $data['data'] = Products::where('id',$id)->where('status','!=','D')->first();
        $data['categories'] = ProductCategory::where('status','A')->where('label','C')->orderBy('name','asc')->get();
        $data['subcategories'] = ProductCategory::where('status','A')->where('label','S')->where('parent_id',$data['data']->category_id)->orderBy('name','asc')->get();
        $data['purpose'] = Purpose::orderBy('name','asc')->get();
        $data['seller'] = SellerMaster::orderBy('seller_name','asc')->get();
        $data['planets'] = Planets::orderBy('planet_name','asc')->get();
        $data['rashi'] = Rashi::orderBy('name','asc')->get();
        $data['deity'] = Deity::orderBy('name','asc')->get();
        $data['nakshatras'] = Nakshatras::orderBy('name','asc')->get();
        $data['country'] = Country::get();
        $data['certificate'] = CertificationName::orderBy('cert_name','asc')->get();



        $data['selected_deity'] = ProductToDeity::where('product_id',$id)->pluck('deity_id')->toArray();
        $data['selected_planet'] = ProductToPlanet::where('product_id',$id)->pluck('planet_id')->toArray();
        $data['selected_rashi'] = ProductToRashi::where('product_id',$id)->pluck('rashi_id')->toArray();
        $data['selected_nakshatra'] = ProductToNakshatras::where('product_id',$id)->pluck('nakshatra_id')->toArray();
        // check-if this puja has order or not 
        $order = OrderDetails::where('product_id',$id)->first();
        if (@$order!="") {
          $data['dis'] = 'disable';
        }
        return view('admin.modules.products.edit_products',$data);
    }


    public function updateProduct(Request $request)
    {
		//dd($request->all());
        $request->validate([
            'product_name'=>'required',
            'category_id'=>'required',
            'product_description'=>'required',
        ]);

        $check = Products::where('id',$request->product_id)->first();
        $check2 = ProductToImage::where('product_id',$request->product_id)->where('is_default','Y')->first();

        $upd = [];
        if (@$request->product_code) {
            $upd['product_code'] = $request->product_code;
        }
        $upd['product_name'] = $request->product_name;
        $upd['category_id'] = $request->category_id;
        $upd['sub_category_id'] = $request->sub_category_id;
        $upd['product_weight'] = $request->product_weight;

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
        $upd['price_inr'] = $request->price_inr;
        $upd['price_usd'] = $request->price_usd;
        $upd['description'] = $request->product_description;
        $upd['meta_title'] = $request->meta_title;
        $upd['meta_description'] = $request->meta_description;
        $upd['color'] = $request->color;
        $upd['size'] = $request->size;
        $upd['slug'] = Str::slug($request->product_name, '-').'-'.$request->product_id;
        $upd['country_of_origin'] = $request->country_id;
        $upd['shape_cut'] = $request->shape;
        $upd['purpose_id'] = $request->purpose;
        $upd['manta_to_chant'] = $request->mantra_to_chant;
        $upd['placement'] = $request->placement;
        $upd['lab_certified'] = $request->lab;
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
        $upd['shipable'] = $request->ship;
        $upd['seller_id'] = $request->seller_id;
		$upd['shipping_policy'] = $request->shipping_policy;
        $upd['terms_of_refund'] = $request->terms_of_refund;
        $upd['how_to_place'] = $request->how_to_place;
        $upd['is_cod_available'] = @$request->is_cod_available;
        $upd['refundable'] = @$request->refundable;
        $upd['delivery_days_india'] = @$request->delivery_days_india;
        $upd['delivery_days_outside_india'] = @$request->delivery_days_outside_india;
        $upd['clarity'] = $request->clarity;
        $upd['significance'] = $request->significance;
        $upd['specific_prosperty'] = $request->specific_prosperty;
        if (@$request->refundable=='Y') {
            $upd['refundable_status'] = $request->refundable_status;
        }else{
            $upd['refundable_status'] = null;
        }
        $upd['assurance_guarantee'] = @$request->assurance_guarantee;

        /*if (@$request->youtube_link!="") {
           ProductToImage::where('product_id',$request->product_id)->where('type','V')->delete();
           // dd(explode('/', @$request->youtube_link));
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
           $video->product_id = $request->product_id;
           $video->save();
        }else{
            ProductToImage::where('product_id',$request->product_id)->where('type','V')->delete();
        }*/
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
				$destinationPath = "storage/app/public/product_video/";
				$request->prod_video->move($destinationPath, $videofilename);
				$video = new ProductToImage;
				$video->type = 'V';
				$video->image = $videofilename;
				$video->product_id = $request->product_id;
				$video->save();
			}
		}
        // planets
        $planets = $request->planets;
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
         ProductToNakshatras::where('product_id', $request->product_id)->whereNotIn('nakshatra_id',$nakshatra)->delete();
      }else{
        ProductToNakshatras::where('product_id', $request->product_id)->delete();
      } 
     




    $update = Products::where('id', $request->product_id)->update($upd);
                 if(@$request->images)
            {
                // $remove = explode(',', $request->change_image);
                $i = 0;
                foreach ($request->images as $key => $value) {

                        $filename = time().'_'.$value->getClientOriginalName();
                        $destinationPath = "storage/app/public/Products/";
                        $value->move($destinationPath, $filename);

                        // call to image resize function 300*300
                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/small_product_image/", 'dimension' => [246, 240], 'filename' =>$filename]);

                        ImageResize::doResize(['file' => $value, 'original_path' => $destinationPath, 'resize_path' => "storage/app/public/product_big_image/", 'dimension' => [437, 362], 'filename' =>$filename]);

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
        return redirect()->back()->with('success','Product updated successfully');
    }


public function deleteProductImage($id)
{
    $check = ProductToImage::where('id',$id)->first();
    $check2 = ProductToImage::where('product_id',$check->product_id)->count();
     if($check2 > 1)
     {
                if($check->is_default == 'Y') {
                    // delete image from ProductToImage table
                    // @unlink(storage_path('app/public/Products/' . $check->product_image));
                    // @unlink(storage_path('app/public/small_product_image/' . $check->product_image));
                    // $delete = ProductToImage::where('id',$id)->delete();

                    // // create new default_image
                    // $new_default = ProductToImage::where('product_id', $check->product_id)
                    //                 ->orderBy('id', 'asc')
                    //                 ->first();
                    // ProductToImage::where('id', $new_default->id)->update(['is_default' => 'Y']);

                    return redirect()->back()->with('error','Default Images Can Not Be Deleted');
        }
        elseif($check->is_default == 'N')
        {

                        @unlink('storage/app/public/Products/' . $check->image);
                        @unlink('storage/app/public/small_product_image/' . $check->image);
                         @unlink('storage/app/public/product_big_image/' . $check->image);
                        // delete image from ProductToImage table
                        $delete = ProductToImage::where('id',$id)->delete();

                        return redirect()->back()->with('success','Image deleted successfully');
        }

    }else{
       return redirect()->back()->with('error','Image can not be deleted as it is default image');
    }
}

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

    public function getSubCategory(Request $request)
    {
        $data = ProductCategory::where('parent_id',$request->category)->where('status','!=','D')->orderBy('name','asc')->get();
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


    public function checkSubProduct(Request $request)
    {
        // return $request;
        if (@$request->id) {
            $checkproduct = Products::where('product_name',$request->product_name)->where('category_id',$request->category_id)->where('sub_category_id',$request->sub_category_id)->where('id','!=',$request->id)->where('status','!=','D')->first();
            if ($checkproduct!="") {
                echo "hey";
            }else{
                echo "not found";
            }
        }else{
        $checkproduct = Products::where('product_name',$request->product_name)->where('category_id',$request->category_id)->where('sub_category_id',$request->sub_category_id)->where('status','!=','D')->first();
        if ($checkproduct!="") {
            echo "hey";
        }else{
            echo "not found";
        }
    }
    }


    public function showHome($id)
    {
        $check = Products::where('id',$id)->where('status','!=','D')->first();
        if (@$check==null) {
            return redirect()->back();
        }
        if (@$check->is_show=="Y") {
            $update = Products::where('id',$id)->where('status','!=','D')->update(['is_show'=>'N']);
            return redirect()->back()->with('success','Product Remove From Home Successfully');
        }else{
            $update = Products::where('id',$id)->where('status','!=','D')->update(['is_show'=>'Y']);
            return redirect()->back()->with('success','Product Show At Home Successfully');
        }
    }




}
