<?php

namespace App\Http\Controllers\Modules\Gemstones;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AddToFavorite;
use App\User;
use App\Models\GemstoneCategory;
use App\Models\Products;
use App\Models\Planets;
use App\Models\Rashi;
use App\Models\Review;
use App\Models\Metal;
use App\Models\ProductGemstonePrice;
use App\Models\Cirtificate;
use App\Models\PujaEnergization;
use App\Models\GoldPurity;
use App\Models\RingPendent;
use App\Models\RingSystem;
use App\Models\RingSize;
use App\Models\BraceletDesign;
use App\Models\CurrencyConversion;
use App\Models\Treatment;
use App\Models\ProductToPlanet;
use App\Models\ProductToRashi;
use App\Models\GemstoneColor;
use App\Models\GemstoneShape;
use App\Models\GemstoneCut;
use App\Models\SellerMaster;
use App\Models\ProductToNakshatras;
use App\Models\ProductToDeity;
use App\Models\Nakshatras;
use App\Models\Deity;
use App\Models\RingPendentDesign;
use App\Models\GemstoneTitle;
use App\Models\BraceletSize;
use App\Models\Faq;
use App\Models\SearchPageData;
use App\Models\StoneType;
use App\Models\FaqCategory;
use DB;
class GemstoneController extends Controller
{
    /**
     *   Method      : index
     *   Description : Search gemstones
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-11
     **/

    public function index(Request $request){
        $data = [];
        $products=Products::where('product_type','GS')->where('status','A')->with('productdefault','title','subtitle');
        if($request->all()){

                        if (@$request->keyword){
                $keyword=$request->keyword;
                $products = $products->where(function($query){
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
            $get = $products->get();
            $ids = [];
            foreach ($get  as $key => $value) {
                array_push($ids, $value->id);
            }
            $products = Products::whereIn('id',$ids)->where('status','A')->where('product_type','GS');
            // return $products->get();
            }

            
            if(@$request->gemstoneCategory){                
                $products=$products->where('category_id',$request->gemstoneCategory);  
            }

            if(@$request->color){                
                $products=$products->whereIn('color_id',$request->color);  
            }
            if(@$request->shape){                
                $products=$products->where('shape_id',$request->shape);  
            }
            if(@$request->cut){                
                $products=$products->where('cut_id',$request->cut);  
            }
			if(@$request->stone_type){                
                $products=$products->where('stone_type',$request->stone_type);  
            }
            if(@$request->seller){                
                $products=$products->where('seller_id',$request->seller);  
            }
            if (@$request->title) {
               $products = $products->where('title_id',@$request->title);
            }
			if(@$request->treatment){      
			          
                $products = $products->whereHas('gemstoneTreatment',function ($query) use ($request){
                $query = $query->where('treatment',$request->treatment);
              });  
            }
            // planets
            if (@$request->planets) {
                $products = $products->whereHas('productPlanets',function ($query) use ($request){
                $query = $query->whereIn('planet_id', $request->planets);
              });
            }
            // rashi
            // if (@$request->rashi) {
            //     $products = $products->whereHas('productRashi',function ($query) use ($request){
            //     $query = $query->whereIn('rashi_id', $request->rashi);
            //   });
            // }

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

            if(@$request->avail){
                $products=$products->where('availability',$request->avail);
              
            }




            if(@session()->get('currency')==1){
                if(@$request->amount1!=null && @$request->amount2!=null){
                    $products = $products->whereBetween('price_per_carat_inr',[$request->amount1,$request->amount2]);
                }
                if (@$request->discount){
                    $maxDiscount=max(@$request->discount);
                        $products=$products->whereBetween('discount_inr',[1,$maxDiscount]);
                }
                if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $products=$products->orderBy('price_per_carat_inr','DESC');

                    }
                    if(@$request->sort_by==2){
                        $products=$products->orderBy('price_per_carat_inr','ASC');
                    }
                }
            }else{
                if(@$request->amount1!=null && @$request->amount2 !=null){
                	@$get = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
                    if(@$request->amount1 !=null && @$request->amount2 !=null){
                    $convert = 1/@$get->conversion_factor;
                    $amount1 = round($request->amount1*$convert,2);
                    $amount2 = round($request->amount2*$convert,2);
                    $products = $products->whereBetween('price_per_carat_usd',[$amount1,$amount2]);
                }
                if (@$request->discount){
                    $maxDiscount=max(@$request->discount);
                        $products=$products->whereBetween('discount_usd',[1,$maxDiscount]);
                }
                if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $products=$products->orderBy('price_per_carat_usd','DESC');

                    }
                    if(@$request->sort_by==2){
                        $products=$products->orderBy('price_per_carat_usd','ASC');
                    }
                }
            }
            }
			if(@$request->weight1!=null && @$request->weight2 !=null){
				$products = $products->whereBetween('product_weight',[$request->weight1,$request->weight2]);
			}
			if (@$request->sort_by){
				if(@$request->sort_by==3){
					$products=$products->orderBy('product_weight','DESC');

				}
				if(@$request->sort_by==4){
					$products=$products->orderBy('product_weight','ASC');
				}
			}

        }

        $data['totalProduct'] = $products->count();
		 $result_data_product = $products->pluck('id');
		 $result_data_product_availability = $products->pluck('availability')->toArray();
         if (@$request->show_result){
            $data['products'] = $products->paginate(@$request->show_result);
        }else{
            $data['products'] = $products->paginate(12);
        }
        
        $data['request'] = $request->all();
		if(@session()->get('currency')==1){
			$maxprice=Products::where('product_type','GS')->max('price_per_carat_inr');
		}
		else
		{
			$maxprice=Products::where('product_type','GS')->max('price_per_carat_usd');
		}
		$data['max_price']=@$maxprice;
		$data['max_weight']=Products::where('product_type','GS')->where('status','!=','D')->max('product_weight');
		$searched_product_ids=$result_data_product;
		$data['gemstoneCategories']=GemstoneCategory::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('category_name','asc')->get();
        $data['planets']=Planets::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('planet_name','asc')->get();
        $data['rashis']=Rashi::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['treatments'] = Treatment::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('gemstone_id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['color'] = GemstoneColor::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('color','asc')->get();
       	$data['shape'] = GemstoneShape::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('shapes','asc')->get();
       	$data['cut'] =   GemstoneCut::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('cuts','asc')->get();
       	$data['seller'] = SellerMaster::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('seller_name','asc')->get();
        $data['nakshatras']=Nakshatras::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['deity'] = Deity::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('product_id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['title'] = GemstoneTitle::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->where('parent_id',0)->orderBy('title','asc')->get();
		$data['stone_types'] = StoneType::with('productDetails')->whereHas('productDetails',function($query) use($searched_product_ids){
			$query->whereIn('id', $searched_product_ids);
		})->orderBy('name','asc')->get();
        $data['content'] = SearchPageData::where('type','G')->first();
        $data['all_faq_cat']=FaqCategory::with('parent','gemFaqDetails')->where('parent_id','!=',0)->has('gemFaqDetails')->get();
		$data['prod_availability']=array_unique($result_data_product_availability);
        // return $data;
        return view('modules.gemstones.search_gemstones')->with($data);
    }
	/**
     *   Method      : gemstoneDetails
     *   Description : Search gemstone details
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-11
     **/

    public function gemstoneDetails($slug=null){
        $productDetails=Products::where('slug',$slug)->with(['productimgs','productdefault','title','subtitle','shape','cut','colors'])->first();
        if($productDetails){
            $data['similarProducts'] = Products::where('product_type','GS')->where('id','!=',$productDetails->id)->where('category_id',$productDetails->category_id)->where('status','A')->with(['productimgs','productdefault'])->take(10)->get();
            if($data['similarProducts']->count()<=0){
                $data['similarProducts'] = Products::where('product_type','GS')->where('id','!=',$productDetails->id)->where('status','A')->with(['productimgs','productdefault'])->take(10)->get();
            }
            $data['productDetails']= $productDetails;
            $data['productReview']= Review::with('customer_review')->where('product_id',$productDetails->id)->orderBy('id','desc')->get();
            $data['favorite']= AddToFavorite::where('user_id',@auth()->user()->id)->where('product_id',$productDetails->id)->first();
			$data['metals']=Metal::get();
			$data['gemstone_price_increase']=ProductGemstonePrice::where('product_id',$productDetails->id)->where('price_type','A')->orderBy('price_inr','Asc')->get();
			$data['gemstone_price_decrease']=ProductGemstonePrice::where('product_id',$productDetails->id)->where('price_type','D')->orderBy('price_inr','Desc')->get();
			$data['gemstone_price_base']=ProductGemstonePrice::where('product_id',$productDetails->id)->where('price_type','B')->first();
			if(@session()->get('currency')>=2)
			{
				$data['certification']=Cirtificate::with('certificate_name')->where('bp_usd_from','<=',$productDetails->price_usd)->where('bp_usd_to','>=',$productDetails->price_usd)->get();
			}
			else
			{
				$data['certification']=Cirtificate::with('certificate_name')->where('bp_inr_from','<=',$productDetails->price_inr)->where('bp_inr_to','>=',$productDetails->price_inr)->get();
			}
			if(@session()->get('currency')>=2)
			{
				$data['puja_energization']=PujaEnergization::with('puja_name')->where('bp_usd_from','<=',$productDetails->price_usd)->where('bp_usd_to','>=',$productDetails->price_usd)->get();
			}
			else
			{
				$data['puja_energization']=PujaEnergization::with('puja_name')->where('bp_inr_from','<=',$productDetails->price_inr)->where('bp_inr_to','>=',$productDetails->price_inr)->get();
			}
			$data['ring_systems']=RingSystem::orderBy('ring_size_system','Asc')->get();

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
            $deityAll = Deity::count();
            $productToDeity = ProductToDeity::where('product_id',$productDetails->id)->count();
            if (@$deityAll==@$productToDeity) {
                $data['benificials_deity'] = 'benificials_deity';
            }
			$data['bracelet_size']=BraceletSize::get();
			$data['all_faq_cat']=FaqCategory::with('parent')->Join('faq','faq.subcategory_id','=','faq_category.id')->leftJoin('faq_product','faq.id','=','faq_product.faq_id')->select('faq_category.*')->whereRaw(DB::raw("(faq_product.product_id = ".$productDetails->id." OR faq.product_id = ".$productDetails->id.")"))->where('faq.type','G')->where('parent_id','!=',0)->groupBy('faq_category.id')->get();
			if(@$data['all_faq_cat']->isNotEmpty())
			{
				foreach(@$data['all_faq_cat'] as $key=>$fcat)
				{
					$data['all_faq_cat'][$key]['all_faq']=Faq::leftJoin('faq_product','faq.id','=','faq_product.faq_id')->select('faq.*')->where('subcategory_id',$fcat->id)->whereRaw(DB::raw("(faq_product.product_id = ".$productDetails->id." OR faq.product_id = ".$productDetails->id.")"))->where('faq.type','G')->groupBy('faq.id')->orderBy('faq.display_order','desc')->get();
				}
				
			}
			//dd($data['all_faq_cat']);
            return view('modules.gemstones.gemstone_details')->with($data);
        }
        return redirect()->route('gemstone.search');
    }
	/**
     *   Method      : fetchGemstonePriceData
     *   Description : For fetching the gemstone price
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-20
     **/
	
	public function fetchGemstonePriceData(Request $request)
    {
		//dd(@$request->all());
		$currencySym=session()->get('currencySym');
		$conversionFactor=currencyConversionCustom();
		if(@$request->all())
		{
			$gem_price=0;
			$old_price=0;
			$gold_purity_price=0;
			$other_price=0;
			$bracelet_design_price=0;
			$certificate_price=0;
			$energize_price=0;
			$pendant_with_chain_price='';
			$pendant_without_chain_price='';
			$html='';
			$gold_purity_select='';
			$ring_pendant_weight_select='';
			$ring_size_option='';
			$bracelet_design_option='';
			$rp_design_option='';
			$weight_price_details = ProductGemstonePrice::where('id',$request->gemstone_weight)->first();
			$gem_details = Products::where('id',$request->gem_id)->first();
			$certificate = Cirtificate::where('id',$request->certification)->first();
			$puja_energy = PujaEnergization::where('id',$request->puja_energy)->first();
			if(@$request->metal && @$request->jewellery)
			{
				$metal_details=Metal::where('id',@$request->metal)->first();
				if(@$metal_details->metal_type=='G')
				{
					$gold_purity = GoldPurity::orderBy('id','Desc')->get();
					$gold_purity_select.='<label class="list_checkBox">Gold Purity (22K/18K/14K):</label>
									<select class="" id="gold_purity" name="gold_purity">
								<option value="">Select</option>';
								$selected='';
								foreach(@$gold_purity as $value)
								{
									if(@$request->jewellery=='R')
									{
										if(@session()->get('currency')>=2)
										{
											if(@$request->gold_purity==@$value->id)
											{
												$gold_purity_select.='<option value="'.@$value->id.'" selected>'.@$value->purity.' ('.@$value->ring_weight_carat.' Carat) + '.$currencySym.round(@$value->ring_price_usd*$conversionFactor,2).'</option>';
												$gold_purity_price=@$value->ring_price_usd;
											}
											else
											{
												$gold_purity_select.='<option value="'.@$value->id.'">'.@$value->purity.' ('.@$value->ring_weight_carat.' Carat) + '.$currencySym.round(@$value->ring_price_usd*$conversionFactor,2).'</option>';
											}
											
										}
										else
										{
											if(@$request->gold_purity==@$value->id)
											{
												$gold_purity_select.='<option value="'.@$value->id.'" selected>'.@$value->purity.' ('.@$value->ring_weight_carat.' Carat) + '.$currencySym.@$value->ring_price_inr.'</option>';
												$gold_purity_price=@$value->ring_price_inr;
											}
											else
											{
												$gold_purity_select.='<option value="'.@$value->id.'">'.@$value->purity.' ('.@$value->ring_weight_carat.' Carat) + '.$currencySym.@$value->ring_price_inr.'</option>';
											}
											
										}
										
									}
									elseif(@$request->jewellery=='P')
									{
										if(@session()->get('currency')>=2)
										{
											
												if(@$request->gold_purity==@$value->id)
												{
													$pendant_with_chain_price='$'.@$value->pendent_chain_price_usd;
													$pendant_without_chain_price='$'.@$value->pendent_price_usd;
													$gold_purity_select.='<option value="'.@$value->id.'" selected>'.@$value->purity.' ('.@$value->pendent_weight_carat.' Carat)</option>';
													if(@$request->pendant_chain=='W')
													{
														$gold_purity_price=@$value->pendent_chain_price_usd;
													}
													else
													{
														$gold_purity_price=@$value->pendent_price_usd;
													}
													
												}
												else
												{
													$gold_purity_select.='<option value="'.@$value->id.'">'.@$value->purity.' ('.@$value->pendent_weight_carat.' Carat)</option>';
												}
												
											
										}
										else
										{
											
											
												if(@$request->gold_purity==@$value->id)
												{
													$pendant_with_chain_price='Rs. '.@$value->pendent_chain_price_inr;
													$pendant_without_chain_price='Rs. '.@$value->pendent_price_inr;
													$gold_purity_select.='<option value="'.@$value->id.'" selected>'.@$value->purity.' ('.@$value->pendent_weight_carat.' Carat)</option>';
													if(@$request->pendant_chain=='W')
													{
														$gold_purity_price=@$value->pendent_chain_price_inr;
													}
													else
													{
														$gold_purity_price=@$value->pendent_price_inr;
													}
													
												}
												else
												{
													$gold_purity_select.='<option value="'.@$value->id.'">'.@$value->purity.' ('.@$value->pendent_weight_carat.' Carat)</option>';
												}
												
											
										}
									}
									elseif(@$request->jewellery=='B')
									{
										if(@session()->get('currency')>=2)
										{
											if(@$request->gold_purity==@$value->id)
											{
												$gold_purity_select.='<option value="'.@$value->id.'" selected>'.@$value->purity.' ('.@$value->bracalet_weight_carat.' Carat) + '.$currencySym.round(@$value->bracelet_price_usd*$conversionFactor,2).'</option>';
												$gold_purity_price=@$value->bracelet_price_usd;
											}
											else
											{
												$gold_purity_select.='<option value="'.@$value->id.'">'.@$value->purity.' ('.@$value->bracalet_weight_carat.' Carat) + '.$currencySym.round(@$value->bracelet_price_usd*$conversionFactor,2).'</option>';
											}
											
										}
										else
										{
											if(@$request->gold_purity==@$value->id)
											{
												$gold_purity_select.='<option value="'.@$value->id.'" selected>'.@$value->purity.' ('.@$value->bracalet_weight_carat.' Carat) + '.$currencySym.@$value->bracelet_price_inr.'</option>';
												$gold_purity_price=@$value->bracelet_price_inr;
											}
											else
											{
												$gold_purity_select.='<option value="'.@$value->id.'">'.@$value->purity.' ('.@$value->bracalet_weight_carat.' Carat) + '.$currencySym.@$value->bracelet_price_inr.'</option>';
											}
											
										}
									}
									
								}																	
					
							$gold_purity_select.='</select>';
				}
				elseif((@$metal_details->metal_type=='S' || @$metal_details->metal_type=='P') && (@$request->jewellery=='R' || @$request->jewellery=='P'))
				{
					$other_price_details=RingPendent::where('metal_type',@$metal_details->metal_type)->where('type',@$request->jewellery)->get();
					if(@$request->jewellery=='R')
					{
						$ring_pendant_weight_select.='<label class="list_checkBox">Ring Weight:</label>
									<select class="" id="ring_pendant_weight" name="ring_pendant_weight">
								<option value="">Select</option>';
							if(@$other_price_details->isNotEmpty())
							{
								foreach(@$other_price_details as $rpw)
								{
									if(@$rpw->id==@$request->ring_pendant_weight)
									{
										if(@session()->get('currency')>=2)
										{
											$ring_pendant_weight_select.='<option value="'.$rpw->id.'" selected>'.@$rpw->weight.' Gm +'.$currencySym.round(@$rpw->price_usd*$conversionFactor,2).'</option>';
											$other_price=$rpw->price_usd;
										}
										else
										{
											$ring_pendant_weight_select.='<option value="'.$rpw->id.'" selected>'.@$rpw->weight.' Gm +'.$currencySym.@$rpw->price_inr.'</option>';
											$other_price=$rpw->price_inr;
										}
									}
									else
									{
										if(@session()->get('currency')>=2)
										{
											$ring_pendant_weight_select.='<option value="'.$rpw->id.'">'.@$rpw->weight.' Gm +'.$currencySym.round(@$rpw->price_usd*$conversionFactor,2).'</option>';
										}
										else
										{
											$ring_pendant_weight_select.='<option value="'.$rpw->id.'">'.@$rpw->weight.' Gm +'.$currencySym.@$rpw->price_inr.'</option>';
										}
									}									
									
								}
							}								
							$ring_pendant_weight_select.='</select>';
					}
					if(@$request->jewellery=='P')
					{
						$ring_pendant_weight_select.='<label class="list_checkBox">Pendant Weight:</label>
									<select class="" id="ring_pendant_weight" name="ring_pendant_weight">
								<option value="">Select</option>';
							if(@$other_price_details->isNotEmpty())
							{
								foreach(@$other_price_details as $rpw)
								{
									if(@$rpw->id==@$request->ring_pendant_weight)
									{
										$ring_pendant_weight_select.='<option value="'.$rpw->id.'" selected>'.@$rpw->weight.' Gm</option>';
										if(@session()->get('currency')>=2)
										{
											$pendant_with_chain_price=$currencySym.round(@$rpw->with_chain_price_usd*$conversionFactor,2);
											$pendant_without_chain_price=$currencySym.round(@$rpw->price_usd*$conversionFactor,2);
											if(@$request->pendant_chain=='W')
											{
												$other_price=$rpw->with_chain_price_usd;
											}
											else
											{
												$other_price=$rpw->price_usd;
											}
										}
										else
										{
											$pendant_with_chain_price=$currencySym.@$rpw->with_chain_price_inr;
											$pendant_without_chain_price=$currencySym.@$rpw->price_inr;
											if(@$request->pendant_chain=='W')
											{
												$other_price=$rpw->with_chain_price_inr;
											}
											else
											{
												$other_price=$rpw->price_inr;
											}
										}
											
									}
									else
									{
										$ring_pendant_weight_select.='<option value="'.$rpw->id.'">'.@$rpw->weight.' Gm</option>';
									}									
									
								}
							}								
							$ring_pendant_weight_select.='</select>';						
					}
				}
				if(@$request->jewellery=='B')
				{
					$design_details=BraceletDesign::where('metal_type',@$metal_details->metal_type)->get();
					if(@$design_details->isNotEmpty())
					{
						$bracelet_design_option.='<label class="list_checkBox">Choose Bracelet Design:</label><ul class="image-radio1 rp_design_image">';
						foreach(@$design_details as $dsgn)
						{
							$url=asset('storage/app/public/bracelet_design/'.$dsgn->design_picture);
							if(@session()->get('currency')>=2)
							{
								if(@$request->select_design==$dsgn->id)
								{
									$bracelet_design_option.='<li>
										<input type="radio" name="select_design" id="design'.$dsgn->id.'" value="'.$dsgn->id.'" class="selectDesign" checked/>
										<label for="design'.$dsgn->id.'"><img class="img-responsive" src="'.$url.'"/> <p>+ '.$currencySym.round($dsgn->price_usd*$conversionFactor,2).'</p></label>
										</li>';
										$bracelet_design_price=$dsgn->price_usd;
								}
								else
								{
									$bracelet_design_option.='<li>
										<input type="radio" name="select_design" id="design'.$dsgn->id.'" value="'.$dsgn->id.'" class="selectDesign"/>
										<label for="design'.$dsgn->id.'"><img class="img-responsive" src="'.$url.'"/> <p>+ '.$currencySym.round($dsgn->price_usd*$conversionFactor,2).'</p></label>
										</li>';
								}
								
							}
							else
							{
								if(@$request->select_design==$dsgn->id)
								{
									$bracelet_design_option.='<li>
										<input type="radio" name="select_design" id="design'.$dsgn->id.'" value="'.$dsgn->id.'" class="selectDesign" checked/>
										<label for="design'.$dsgn->id.'"><img class="img-responsive" src="'.$url.'"/><p>+ '.$currencySym.$dsgn->price_inr.'</p></label>
										</li>';
										$bracelet_design_price=$dsgn->price_inr;
								}
								else
								{
									$bracelet_design_option.='<li>
										<input type="radio" name="select_design" id="design'.$dsgn->id.'" value="'.$dsgn->id.'" class="selectDesign"/>
										<label for="design'.$dsgn->id.'"><img class="img-responsive" src="'.$url.'"/><p>+ '.$currencySym.$dsgn->price_inr.'</p></label>
										</li>';
								}
								
							}
							
						}
						$bracelet_design_option.='</ul>';
					}
					else
					{
						$bracelet_design_option.='<label class="list_checkBox"><strong>No bracelet design available</strong></label><ul class="image-radio1"></ul>';
					}			
				}
				
			}
			if(@$request->jewellery=='R' || @$request->jewellery=='P')
				{
					$rp_design_details=RingPendentDesign::where('type',@$request->jewellery)->get();
					if(@$rp_design_details->isNotEmpty())
					{
						if(@$request->jewellery=='R')
						{
							$rp_design_option.='<label class="list_checkBox">Choose Ring Design:</label><ul class="image-radio1 rp_design_image">';
						}
						elseif(@$request->jewellery=='P')
						{
							$rp_design_option.='<label class="list_checkBox">Choose Pendant Design:</label><ul class="image-radio1 rp_design_image">';
						}						
						foreach(@$rp_design_details as $rpdsgn)
						{
							$url=asset('storage/app/public/ring_pendent_design/'.$rpdsgn->design_image);
							
							if(@$request->select_design==$rpdsgn->id)
							{
								$rp_design_option.='<li>
									<input type="radio" name="select_design" id="design'.$rpdsgn->id.'" value="'.$rpdsgn->id.'" class="selectDesign" checked/>
									<label for="design'.$rpdsgn->id.'"><img class="img-responsive" src="'.$url.'"/><p>'.$rpdsgn->design_name.'</p></label>
									</li>';
							}
							else
							{
								$rp_design_option.='<li>
									<input type="radio" name="select_design" id="design'.$rpdsgn->id.'" value="'.$rpdsgn->id.'" class="selectDesign"/>
									<label for="design'.$rpdsgn->id.'"><img class="img-responsive" src="'.$url.'"/><p>'.$rpdsgn->design_name.'</p></label>
									</li>';
							}
						}
						$rp_design_option.='</ul>';
					}
					else
					{
						if(@$request->jewellery=='R')
						{
							$rp_design_option.='<label class="list_checkBox"><strong>No ring design available</strong></label><ul class="image-radio1"></ul>';
						}
						elseif(@$request->jewellery=='P')
						{
							$rp_design_option.='<label class="list_checkBox"><strong>No pendant design available</strong></label><ul class="image-radio1"></ul>';
						}
						
					}
					                                           
									
				}
			if(@session()->get('currency')>=2)
			{
				if(@$gem_details->discount_usd)
				{
					if($weight_price_details->price_type=='A')
					{
						$old_price = $gem_details->price_usd+$weight_price_details->price_usd;
					}
					elseif($weight_price_details->price_type=='D')
					{
						$old_price = $gem_details->price_usd-$weight_price_details->price_usd;
					}
					else
					{
						$old_price = $gem_details->price_usd;
					}					
					$discount_value = ($old_price / 100) * @$gem_details->discount_usd;
					$gem_price = $old_price - $discount_value;
					$gem_price=$gem_price;
					if(@$certificate)
					{
						$certificate_price=$certificate->price_usd;
					}
					if(@$puja_energy)
					{
						$energize_price=$puja_energy->price_usd;
					}
					$html.='<del>'.$currencySym.round($old_price*$conversionFactor,2).'</del>
                                <span class="price"> '.$currencySym.round($gem_price*$conversionFactor
								,2).'</span>';
				}
				else
				{
					if($weight_price_details->price_type=='A')
					{
						$gem_price = $gem_details->price_usd+$weight_price_details->price_usd;
					}
					elseif($weight_price_details->price_type=='D')
					{
						$gem_price = $gem_details->price_usd-$weight_price_details->price_usd;
					}
					else
					{
						$gem_price = $gem_details->price_usd;
					}
					$gem_price=$gem_price;
					if(@$certificate)
					{
						$certificate_price=$certificate->price_usd;
					}
					if(@$puja_energy)
					{
						$energize_price=$puja_energy->price_usd;
					}
					$html.='<span class="price"> '.$currencySym.round($gem_price*$conversionFactor,2).'</span>';
				}
			}
			else
			{
				if(@$gem_details->discount_inr)
				{
					if($weight_price_details->price_type=='A')
					{
						$old_price = $gem_details->price_inr+$weight_price_details->price_inr;
					}
					elseif($weight_price_details->price_type=='D')
					{
						$old_price = $gem_details->price_inr-$weight_price_details->price_inr;
					}
					else
					{
						$old_price = $gem_details->price_inr;
					}					
					$discount_value = ($old_price / 100) * @$gem_details->discount_inr;
					$gem_price = $old_price - $discount_value;
					$gem_price=$gem_price;
					if(@$certificate)
					{
						$certificate_price=$certificate->price_inr;
					}
					if(@$puja_energy)
					{
						$energize_price=$puja_energy->price_inr;
					}
					$html.='<del>'.$currencySym.$old_price.'</del>
                                <span class="price"> '.$currencySym.$gem_price.'</span>';
				}
				else
				{
					if($weight_price_details->price_type=='A')
					{
						$gem_price = $gem_details->price_inr+$weight_price_details->price_inr;
					}
					elseif($weight_price_details->price_type=='D')
					{
						$gem_price = $gem_details->price_inr-$weight_price_details->price_inr;
					}
					else
					{
						$gem_price = $gem_details->price_inr;
					}
					$gem_price=$gem_price;
					if(@$certificate)
					{
						$certificate_price=$certificate->price_inr;
					}
					if(@$puja_energy)
					{
						$energize_price=$puja_energy->price_inr;
					}
					$html.='<span class="price"> '.$currencySym.$gem_price.'</span>';
				}
			}
			if(@$request->ring_system)
			{
				$ring_size_option='<option value="">Select</option>';
                $ring_sizes=RingSize::where('ring_size_system_id',@$request->ring_system)->orderBy('ring_size','Asc')->get();
				if(@$ring_sizes->isNotEmpty())
				{
					foreach(@$ring_sizes as $value)
					{
						if($value->id==$request->ring_size)
						{
							$ring_size_option.='<option value="'.$value->id.'" selected>'.$value->ring_size.'</option>';
						}
						else
						{
							$ring_size_option.='<option value="'.$value->id.'">'.$value->ring_size.'</option>';
						}
						
					}
				}
				
			}
			if(@$request->jewellery=='OS')
			{
				$gold_purity_select='';
				$ring_size_option='';
				$bracelet_design_option='';
				$rp_design_option='';
				$other_price=0;
				$gold_purity_price=0;
				$bracelet_design_price=0;
				$pendant_with_chain_price='';
				$pendant_without_chain_price='';
				$ring_pendant_weight_select='';
			}
			$gift_pack=0;
			if(@$request->gift_pack)
			{
				$gift_pack=@$request->gift_pack;
			}
			$payable_gem_price=$gem_price+$other_price+$gold_purity_price+$bracelet_design_price+$certificate_price+$energize_price;
			$response['success']='success';			
			$response['gem_price']=$gem_price;
			if(@session()->get('currency')>=2)
			{
				$response['payable_gem_price']='You pay - '.$currencySym.(round($payable_gem_price*$conversionFactor,2)+$gift_pack);
			}
			else
			{
				$response['payable_gem_price']='You pay - '.$currencySym.($payable_gem_price+$gift_pack);
			}			
			$response['html']=$html;			
			$response['gold_purity_select']=$gold_purity_select;			
			$response['ring_pendant_weight_select']=$ring_pendant_weight_select;			
			$response['ring_size_option']=$ring_size_option;			
			$response['bracelet_design_option']=$bracelet_design_option;
			$response['rp_design_option']=$rp_design_option;
			$response['pendant_with_chain_price']=$pendant_with_chain_price;
			$response['pendant_without_chain_price']=$pendant_without_chain_price;
		}
		else
		{
			$response['error']='error';
		}
		return response()->json($response);
    }







    public function gemCatView()
    {
        $data = [];
        $data['category'] = GemstoneCategory::get();
        return view('modules.separate_search.category')->with($data);
    }

    public function gemTitleView($id)
    {
        $array = [];
        $gettitle = Products::where('product_type','GS')->where('category_id',$id)->where('title_id','!=','')->where('status','!=','D')->get();
        foreach ($gettitle as $key => $value) {
           array_push($array, $value->title_id);
        }
        $common  = array_unique($array);
        $data = [];
        $data['title'] = GemstoneTitle::whereIn('id',$common)->get();
        $data['category'] = GemstoneCategory::where('id',$id)->first();
        return view('modules.separate_search.title',$data);
    }

    public function gemSubTitleView($id,$cat)
    {
        $array = [];
        $getsub = Products::where('product_type','GS')->where('title_id',$id)->where('subtitle_id','!=','')->where('status','!=','D')->where('category_id',$cat)->get();
        foreach ($getsub as $key => $value) {
           array_push($array, $value->subtitle_id);
        }
        $common  = array_unique($array);
        $data = [];
        $data['subtitle'] = GemstoneTitle::whereIn('id',$common)->get();
        // return $cat;
        $data['category'] = GemstoneCategory::where('id',$cat)->first();
        // return $data['category'];
        $data['title'] = GemstoneTitle::where('id',$id)->first();
        return view('modules.separate_search.subtitle',$data);
    }

    public function gemSubTitleSearch(Request $request,$id,$cat)
    {
        // return $request;
        $data['content'] = SearchPageData::where('type','G')->first();
        $data['all_faq_cat']=FaqCategory::with('parent','gemFaqDetails')->where('parent_id','!=',0)->has('gemFaqDetails')->get();


        $title_type = GemstoneTitle::where('id',$id)->first();
        if (@$title_type->parent_id>0) {
            $products=Products::where('product_type','GS')->where('status','A')->with('productdefault','title','subtitle')->where('subtitle_id',$id)->where('category_id',$cat);
        }else{
        $products=Products::where('product_type','GS')->where('status','A')->with('productdefault','title','subtitle')->where('title_id',$id)->where('category_id',$cat);
       }
        $data['totalProduct'] = $products->count();
        if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $products=$products->orderBy('price_per_carat_usd','DESC');

                    }
                    if(@$request->sort_by==2){
                        $products=$products->orderBy('price_per_carat_usd','ASC');
                    }
        }
         if (@$request->show_result){
            $data['products'] = $products->paginate(@$request->show_result);
            
        }else{
            $data['products'] = $products->paginate(12);
        }
        
        $data['request'] = $request->all();
        $data['subtitle_id'] = $id;
        $data['category'] = $cat;
        return view('modules.separate_search.gem_separate_search',$data);
     }


     public function categorySearch(Request $request,$id)
     {
        $data['content'] = SearchPageData::where('type','G')->first();
        $data['all_faq_cat']=FaqCategory::with('parent','gemFaqDetails')->where('parent_id','!=',0)->has('gemFaqDetails')->get();
        $products=Products::where('product_type','GS')->where('status','A')->with('productdefault','title','subtitle')->where('category_id',$id);
        $data['totalProduct'] = $products->count();
        if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $products=$products->orderBy('price_per_carat_usd','DESC');

                    }
                    if(@$request->sort_by==2){
                        $products=$products->orderBy('price_per_carat_usd','ASC');
                    }
        }
         if (@$request->show_result){
            $data['products'] = $products->paginate(@$request->show_result);
            
        }else{
            $data['products'] = $products->paginate(12);
        }
        
        $data['request'] = $request->all();
        $data['category'] = $id;
        return view('modules.separate_search.gem_separate_search_category',$data);
     }



}
