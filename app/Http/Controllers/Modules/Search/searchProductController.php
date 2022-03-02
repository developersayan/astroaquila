<?php

namespace App\Http\Controllers\Modules\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AddToFavorite;
use App\User;
use App\Models\ProductCategory;
use App\Models\Products;
use App\Models\Nakshatras;
use App\Models\Planets;
use App\Models\Purpose;
use App\Models\Rashi;
use App\Models\Review;
use App\Models\CurrencyConversion;
use App\Models\ProductToPlanet;
use App\Models\ProductToRashi;
use App\Models\ProductToNakshatras;
use App\Models\ProductToDeity;
use App\Models\Deity;
use App\Models\SellerMaster;
use App\Models\Faq;
use App\Models\SearchPageData;
use App\Models\FaqCategory;
use DB;
class searchProductController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : index
     *   Description : Search Product
     *   Author      : Soumojit
     *   Date        : 14-JUN-2021
     **/

    public function index(Request $request){
        $data = [];
        $products=Products::where('product_type','AP')->where('status','A')->with('productdefault');
        if($request->all()){

            if (@$request->keyword){
                $keyword=$request->keyword;
                $products=$products->where(function($query) use ($keyword){
                    $query->where('product_name','LIKE','%'.$keyword.'%');
                    $query->orWhere('color','LIKE','%'.$keyword.'%');
                    $query->orWhere('size','LIKE','%'.$keyword.'%');
                    $query->orWhere('description','LIKE','%'.$keyword.'%');
                    $query->orWhere('product_code','LIKE','%'.$keyword.'%');
                    $query->orWhere('significance','LIKE','%'.request('keyword').'%');
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
            $get = $products->get();
            $ids = [];
            foreach ($get  as $key => $value) {
                array_push($ids, $value->id);
            }
            $products = Products::whereIn('id',$ids)->where('status','A')->where('product_type','AP');
            }

            
            if(@$request->productCategory){
                if (@$request->subcat) {
                   $products=$products->where('sub_category_id',$request->subcat);
                }else{
                $products=$products->where('category_id',$request->productCategory);
                // return $products->get();
               }
                
                // return $data['subcategories'];
            }
            // planets
            if (@$request->planets) {
                $products = $products->whereHas('productPlanets',function ($query) use ($request){
                $query = $query->whereIn('planet_id', $request->planets);
              });
            }
            // rashi
            if (@$request->rashi) {
                $products = $products->whereHas('productRashi',function ($query) use ($request){
                $query = $query->whereIn('rashi_id', $request->rashi);
              });
            }

            // nakshatras
            if (@$request->nakshatra) {
                $products = $products->whereHas('productNakshtra',function ($query) use ($request){
                $query = $query->whereIn('nakshatra_id', $request->nakshatra);
              });
            }

            // deity 
            if (@$request->deity) {
                // return @$request->deity;
                $products = $products->whereHas('productDeity',function ($query) use ($request){
                $query = $query->whereIn('deity_id', $request->deity);
              });
            }

            // purpose
            if(@$request->purpose){
                $products=$products->where('purpose_id',$request->purpose);
                // return $products->get();
            }

            if(@$request->avail){
                $products=$products->where('availability',$request->avail);
              
            }

            if(@$request->seller){                
                $products=$products->where('seller_id',$request->seller);  
            }


            // if (@$request->price){
            //     $maxPrice=max(@$request->price);
            //     if(in_array(0, $request->price)){
            //         $products=$products->where('price','!=','');
            //     }else{
            //         $products=$products->whereBetween('price',[0,$maxPrice]);
            //     }
            // }




            if (@$request->shippable){
                $products=$products->whereIn('shipable',@$request->shippable);
            }
            

            if(@session()->get('currency')==1){
                if(@$request->amount1!=null && @$request->amount2!=null){
                    $products = $products->whereBetween('price_inr',[$request->amount1,$request->amount2]);
                }
                // if(@$request->amount1==null && @$request->amount2){
                //     $products = $products->whereBetween('price_inr','<',$request->amount2);
                // }
                // return $request->all();
                if (@$request->discount){
                    $maxDiscount=max(@$request->discount);
                        $products=$products->whereBetween('discount_inr',[1,$maxDiscount]);
                }
                if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $products=$products->orderBy('price_inr','DESC');

                    }
                    if(@$request->sort_by==2){
                        $products=$products->orderBy('price_inr','ASC');
                    }
                }

            }
            else{
                @$get = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
                if(@$request->amount1!=null && @$request->amount2 !=null){
                    $convert = 1/@$get->conversion_factor;
                    $amount1 = round($request->amount1*$convert,2);
                    $amount2 = round($request->amount2*$convert,2);
                    $products= $products->whereBetween('price_usd', [$amount1,$amount2]);
                }
                // if(@$request->amount1==null && @$request->amount2){
                //     $products = $products->whereBetween('price_usd','<',$request->amount2);
                // }
                if (@$request->discount){
                    $maxDiscount=max(@$request->discount);
                        $products=$products->whereBetween('discount_usd',[1,$maxDiscount]);
                }
                if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $products=$products->orderBy('price_usd','DESC');

                    }
                    if(@$request->sort_by==2){
                        $products=$products->orderBy('price_usd','ASC');
                    }
                }
            }

        }

        $data['totalProduct'] = $products->count();
		$result_data_product = $products->pluck('id');
		$result_data_product_availability = $products->pluck('availability')->toArray();
		$result_data_product_shippable = $products->pluck('shipable')->toArray();
        if (@$request->show_result){
            $data['products'] = $products->paginate(@$request->show_result);
        }else{
            $data['products'] = $products->paginate(12);
        }
        
        $data['request'] = $request->all();
		if(@session()->get('currency')==1){
			$maxprice=Products::where('product_type','AP')->max('price_inr');
		}
		else
		{
			$maxprice=Products::where('product_type','AP')->max('price_usd');
		}
		$data['max_price']=@$maxprice;
		$searched_product_ids=$result_data_product;
		$data['productCategorys']=ProductCategory::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->where('status','A')->where('label','C')->orderBy('name','asc')->get();
        $data['planets']=Planets::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('planet_name','asc')->get();
        $data['purposes']=Purpose::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['rashis']=Rashi::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['nakshatras']=Nakshatras::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['deity'] = Deity::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('name','asc')->get();
		$data['seller'] = SellerMaster::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('seller_name','asc')->get();
		if(@$request->productCategory){
		$data['subcategories'] = ProductCategory::with('productDetailsSubCategory')->whereHas('productDetailsSubCategory',function($query) use($searched_product_ids){
					$query->whereIn('id', $searched_product_ids);
				})->where('status','A')->where('label','S')->where('parent_id',@$request->productCategory)->orderBy('name','asc')->get();
		}
		$data['prod_availability']=array_unique($result_data_product_availability);
		$data['prod_shippable']=array_unique($result_data_product_shippable);
		$data['content'] = SearchPageData::where('type','P')->first();
        $data['all_faq_cat']=FaqCategory::with('parent','astroFaqDetails')->where('parent_id','!=',0)->has('astroFaqDetails')->get();
        // return $data;
        return view('modules.searchProduct.search_product')->with($data);
    }


    /**
     *   Method      : productDetails
     *   Description : Search Product details
     *   Author      : Soumojit
     *   Date        : 14-JUN-2021
     **/

    public function productDetails($slug=null){
        $productDetails=Products::where('slug',$slug)->with(['productimgs','productdefault'])->first();
        if($productDetails){
            $data['similarProducts'] = Products::where('product_type','AP')->where('id','!=',$productDetails->id)->where('category_id',$productDetails->category_id)->where('status','A')->with(['productimgs','productdefault'])->take(10)->get();
            if($data['similarProducts']->count()<=0){
                $data['similarProducts'] = Products::where('product_type','AP')->where('id','!=',$productDetails->id)->where('status','A')->with(['productimgs','productdefault'])->take(10)->get();
            }
            $data['productDetails']= $productDetails;
            $data['productReview']= Review::with('customer_review')->where('product_id',$productDetails->id)->orderBy('id','desc')->get();
            $data['favorite']= AddToFavorite::where('user_id',@auth()->user()->id)->where('product_id',$productDetails->id)->first();
            // benificials to all  planet
            $planetAll = Planets::count();
            $productToPlanet = ProductToPlanet::where('product_id',$productDetails->id)->count();
            if (@$planetAll==@$productToPlanet) {
                $data['benificials_planet'] = 'benificials_planet';
            }
            // benificials to all  rashi
            $rashiAll = Rashi::count();
            $productToRashi = ProductToRashi::where('product_id',$productDetails->id)->count();
            if (@$rashiAll==@$productToRashi) {
                $data['benificials_rashi'] = 'benificials_rashi';
            }
            // benificials to all  nakshatra
            $nakshatraAll = Nakshatras::count();
            $productToNakshatras = ProductToNakshatras::where('product_id',$productDetails->id)->count();
            if (@$nakshatraAll==@$productToNakshatras) {
                $data['benificials_nakshatra'] = 'benificials_nakshatra';
            }
            // benificials to all  deity
            // $deityAll = Deity::count();
            // $productToDeity = ProductToDeity::where('product_id',$productDetails->id)->count();
            // if (@$deityAll==@$productToDeity) {
            //     $data['benificials_deity'] = 'benificials_deity';
            // }
            // new-changes
            $data['faqs'] = Faq::where('product_id',$productDetails->id)->get();
            $data['all_faq_cat']=FaqCategory::with('parent')->Join('faq','faq.subcategory_id','=','faq_category.id')->leftJoin('faq_product','faq.id','=','faq_product.faq_id')->select('faq_category.*')->whereRaw(DB::raw("(faq_product.product_id = ".$productDetails->id." OR faq.product_id = ".$productDetails->id.")"))->where('faq.type','P')->where('parent_id','!=',0)->groupBy('faq_category.id')->get();
			if(@$data['all_faq_cat']->isNotEmpty())
			{
				foreach(@$data['all_faq_cat'] as $key=>$fcat)
				{
					$data['all_faq_cat'][$key]['all_faq']=Faq::leftJoin('faq_product','faq.id','=','faq_product.faq_id')->select('faq.*')->where('subcategory_id',$fcat->id)->whereRaw(DB::raw("(faq_product.product_id = ".$productDetails->id." OR faq.product_id = ".$productDetails->id.")"))->where('faq.type','P')->groupBy('faq.id')->orderBy('faq.display_order','desc')->get();
				}
				
			}
            if (@$data['all_faq_cat']->isEmpty()) {
                $data['faq_status'] = 'N';
            }
            
            return view('modules.searchProduct.product_details')->with($data);
        }
        return redirect()->route('product.search');
    }
	/**
	*Method:productAllCategory
	*Description:Showing count related categories
	*Author:Sayan
	*Date:2021-NOV-23
	*/
	public function productAllCategory()
    {
       $data = [];
       $data['category'] = ProductCategory::where('parent_id',0)->where('status','A')->get();
       return view('modules.separate_search.product_all_category',$data);
    }

    public function productSubcategory($id)
    {
       $data = [];
       $data['category'] = ProductCategory::where('id',$id)->first();
       $data['sub_category'] = ProductCategory::where('parent_id',$id)->where('status','A')->get();
       return view('modules.separate_search.product_all_sub_category',$data);
    }

    public function productSeparateSearch(Request $request,$id)
    {

        $data = [];
        $data['content'] = SearchPageData::where('type','P')->first();
        $data['all_faq_cat']=FaqCategory::with('parent','astroFaqDetails')->where('parent_id','!=',0)->has('astroFaqDetails')->get();
        
        $check = ProductCategory::where('id',$id)->first();
        if (@$check->label=="C") {
            $data['products'] = Products::where('category_id',$id)->where('status','A')->where('product_type','AP');
        }else{
            $data['products'] = Products::where('sub_category_id',$id)->where('status','A')->where('product_type','AP');
        }
        
         
        
        $data['totalProduct'] = $data['products']->count();
        if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $data['products']=$data['products']->orderBy('price_inr','DESC');

                    }
                    if(@$request->sort_by==2){
                        $data['products']=$data['products']->orderBy('price_usd','ASC');
                    }
        }
         if (@$request->show_result){
            $data['products'] = $data['products']->paginate(@$request->show_result);
            
        }else{
            $data['products'] = $data['products']->paginate(12);
        }
        $data['request'] = $request->all();
        $data['cat'] = $id;
        return view('modules.separate_search.product_separate_search',$data);
    }


}
