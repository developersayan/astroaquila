<?php

namespace App\Http\Controllers\Modules\Search;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Puja;
use App\Models\PunditToPuja;
use App\Models\Purpose;
use App\Models\Deity;
use App\Models\PujaCategory;
use App\Models\ZipMaster;
use App\Models\PunditToZipcode;
use App\Models\Planets;
use App\Models\Rashi;
use App\Models\Nakshatras;
use App\Models\Gotra;
use App\Models\OrderMaster;
use App\Models\Review;
use App\Models\CustomerPujaNames;
use App\Models\TempPujaPerson;
use App\Models\Mantra;
use App\Models\MantraPrice;
use Auth;
use App\Models\CurrencyConversion;
use App\Models\PujaToDeity;
use App\Models\PujaToNakshatra;
use App\Models\PujaToPlanet;
use App\Models\PujaToRashi;
use App\Models\PujaName;
use App\Models\Faq;
use App\Models\SearchPageData;
use App\Models\FaqCategory;
use DB;
class SearchController extends Controller
{
    //
    public function __construct()
    {
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : searchPundit
     *   Description : Search Pandit
     *   Author      : Soumojit
     *   Date        : 2021-May-2021
     **/
    public function searchPundit(Request $request)
    {
        
        // $pandit = User::where('user_type','P')->with(['punditPujas'])->where('status','A')->where('approve_by_admin','Y');
		$data['allPuja'] =Puja::orderBy('puja_name','asc')->get();
        $puja = Puja::where('status','A')->with(['pujaDeity','pujaPurpose','pujaPlanet','pujaRashi','pujaNakshatra']);
        if(@$request->all()){
            if(@$request->puja_name){
                $puja= $puja->where(function($query){
                    $query->where('puja_name','LIKE','%'.request('puja_name').'%')
                          ->orWhere('puja_description','LIKE','%'.request('puja_name').'%')
                          ->orWhere('puja_code','LIKE','%'.request('puja_name').'%')
                          ->orWhere('importance_significance','LIKE','%'.request('puja_name').'%')
                          ->orWhere('facts_mythology','LIKE','%'.request('puja_name').'%')
                          ->orWhere('who_when_how','LIKE','%'.request('puja_name').'%')
                          ->orWhere('puja_mantra','LIKE','%'.request('puja_name').'%');
                 })->orWhereHas('pujaRashi.rashis',function($query){
                $query->where('name','LIKE','%'.request('puja_name').'%');
            })->orWhereHas('pujaPlanet.planets',function($query){
                $query->where('planet_name','LIKE','%'.request('puja_name').'%');
            })->orWhereHas('pujaNakshatra.nakshatras',function($query){
                $query->where('name','LIKE','%'.request('puja_name').'%');
            })->orWhereHas('pujaDeity.deity',function($query){
                $query->where('name','LIKE','%'.request('puja_name').'%');
            })->orWhereHas('pujaPurpose.purpose',function($query){
                $query->where('name','LIKE','%'.request('puja_name').'%');
            });
            }
            if(@$request->category){
                if (@$request->subcategory) {
                    $puja= $puja->where('puja_sub_category',$request->subcategory);
                }else{
                $puja= $puja->where('puja_category',$request->category);
               }
            }
             if(@$request->avail){
                $puja= $puja->where('availability',$request->avail);
            }
            if(@$request->puja_name_search){
                $puja= $puja->where('puja_id',$request->puja_name_search);
            }
			// planets
            if (@$request->planets) {
                $puja = $puja->whereHas('pujaPlanet',function ($query) use ($request){
                $query = $query->whereIn('planet_id', $request->planets);
              });
            }
            // rashi
            if (@$request->rashi) {
                $puja = $puja->whereHas('pujaRashi',function ($query) use ($request){
                $query = $query->whereIn('rashi_id', $request->rashi);
              });
            }

            // nakshatras
            if (@$request->nakshatra) {
                $puja = $puja->whereHas('pujaNakshatra',function ($query) use ($request){
                $query = $query->whereIn('nakshatra_id', $request->nakshatra);
              });
            }
            if(@$request->deity){
                $puja= $puja->whereHas('pujaDeity', function ($query) use ($request) {
                    $query->whereIn('deity_id', $request->deity);
                });
            }
            if(@$request->purpose){
                $puja= $puja->whereHas('pujaPurpose', function ($query) use ($request) {
                    $query->where('purpose_id', $request->purpose);
                });
            }
            // if(@$request->amount1 !=null && @$request->amount2 !=null){
            //     return $request;
            //     $puja= $puja->whereBetween('price_inr', [$request->amount1, $request->amount2]);
            // }
            if(@session()->get('currency')==1){
                if(@$request->amount1 !=null && @$request->amount2 !=null){
                    $puja= $puja->whereBetween('price_inr', [$request->amount1, $request->amount2]);
                }
                if(@$request->sort_by){
                    // if(@$request->sort_by==1){
                    //     $pandit = $pandit->orderby('avg_review', 'desc');
                    // }
                    if(@$request->sort_by==2){
                        $puja= $puja->orderby('price_inr', 'desc');
                    }

                    if(@$request->sort_by==3){
                        $puja= $puja->orderby('price_inr', 'asc');
                    }

                }
            }else{
                @$get = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
                if(@$request->amount1 !=null && @$request->amount2 !=null){
                    $convert = 1/@$get->conversion_factor;
                    $amount1 = round($request->amount1*$convert,2);
                    $amount2 = round($request->amount2*$convert,2);
                    // return $amount2;
                    $puja= $puja->whereBetween('price_usd', [$amount1,$amount2]);
                }



                if(@$request->sort_by){
                    // if(@$request->sort_by==1){
                    //     $pandit = $pandit->orderby('avg_review', 'desc');
                    // }
                    if(@$request->sort_by==2){
                        $puja= $puja->orderby('price_usd', 'desc');
                    }

                    if(@$request->sort_by==3){
                        $puja= $puja->orderby('price_usd', 'asc');
                    }

                }
            }


            if(@$request->puja_type){
                if (@in_array('ONLINE', $request->puja_type) && @in_array('OFFLINE', $request->puja_type)) {
                    $da=['OFFLINE', 'ONLINE', 'BOTH'];
                    $puja= $puja->whereIn('manner_of_puja', $da);
                }else if(@in_array('ONLINE', $request->puja_type)){
                    $da = ['ONLINE', 'BOTH'];
                    $puja= $puja->whereIn('manner_of_puja', $da);
                }else if(@in_array('OFFLINE', $request->puja_type)){
                    $da = ['OFFLINE', 'BOTH'];
                    $puja= $puja->whereIn('manner_of_puja', $da);
                }else{
                    $puja= $puja->whereIn('manner_of_puja', @$request->puja_type);
                }
            }

        }
		$result_data_puja = $puja->pluck('id');
		$result_data_puja_availability = $puja->pluck('availability')->toArray();
		$result_data_puja_manners = $puja->pluck('manner_of_puja')->toArray();
        if (@$request->show_result){
            $data['pujas']= $puja->paginate(@$request->show_result);
        }else{
            $data['pujas']= $puja->paginate(12);
        }
        
        $data['request'] = $request->all();
        // $data['allPandit']= $pandit->count();
        // $data['pandits']= $pandit->paginate(10);
        $data['allPuja']= $puja->count();
        

        // return $data;
		//dump($data['pujas']);
		if(@session()->get('currency')==1)
		{
			$data['max_price']=Puja::max('price_inr');
		}
		else
		{
			$data['max_price']=Puja::max('price_usd');
		}
		$searched_puja_ids=$result_data_puja;
        $data['allPuja_name'] =PujaName::with('pujaDetails')->whereHas('pujaDetails',function($query) use($searched_puja_ids){
			$query->whereIn('id', $searched_puja_ids);
		})->orderBy('name','asc')->get();
        $data['allPurpose'] =Purpose::with('pujaDetails')->whereHas('pujaDetails',function($query) use($searched_puja_ids){
			$query->whereIn('puja_id', $searched_puja_ids);
		})->orderBy('name','ASC')->get();
        $data['allDeity'] =Deity::with('pujaDetails')->whereHas('pujaDetails',function($query) use($searched_puja_ids){
			$query->whereIn('puja_id', $searched_puja_ids);
		})->orderBy('name','ASC')->get();
        $data['allCategory'] =PujaCategory::with('pujaDetails')->whereHas('pujaDetails',function($query) use($searched_puja_ids){
			$query->whereIn('id', $searched_puja_ids);
		})->where('status','A')->orderBy('name','asc')->where('parent_id',0)->get();
		if(@$request->category){
			 $data['subcategory'] = PujaCategory::with('pujaDetailsSubCategory')->whereHas('pujaDetailsSubCategory',function($query) use($searched_puja_ids){
			$query->whereIn('id', $searched_puja_ids);
		})->where('status','A')->orderBy('name','asc')->where('parent_id',@$request->category)->get();
		}
		$data['planets']=Planets::with('pujaDetails')->whereHas('pujaDetails',function($query) use($searched_puja_ids){
			$query->whereIn('puja_id', $searched_puja_ids);
		})->orderBy('planet_name','asc')->get();
		$data['rashis']=Rashi::with('pujaDetails')->whereHas('pujaDetails',function($query) use($searched_puja_ids){
			$query->whereIn('puja_id', $searched_puja_ids);
		})->orderBy('name','asc')->get();
        $data['nakshatras']=Nakshatras::with('pujaDetails')->whereHas('pujaDetails',function($query) use($searched_puja_ids){
			$query->whereIn('puja_id', $searched_puja_ids);
		})->orderBy('name','asc')->get();
		$data['puja_availability']=array_unique($result_data_puja_availability);
		$data['puja_manners']=array_unique($result_data_puja_manners);
		$data['content'] = SearchPageData::where('type','PU')->first();
         $data['all_faq_cat']=FaqCategory::with('parent','pujaFaqDetails')->where('parent_id','!=',0)->has('pujaFaqDetails')->get();
        return view('modules.searchPundit.puja_search')->with($data);
    }
    /**
     *   Method      : searchPunditPuja
     *   Description : search Puja
     *   Author      : Soumojit
     *   Date        : 2021-May-2021
     **/
    public function searchPunditPuja(Request $request)
    {
        $data['allPuja'] = Puja::get();
        $pandit = User::where('user_type', 'P')->with(['punditPujas'])->where('status', 'A')->where('approve_by_admin', 'Y');
        // if (@$request->all()) {
        //     if (@$request->puja) {
        //         $puja = $request->puja;
        //         $pandit = $pandit->with(['punditPujas' => function ($query) use ($puja) {
        //             $query->whereIn('puja_id', $puja);
        //         }]);
        //         $pandit = $pandit->whereHas('punditPujas', function ($query) use ($puja) {
        //             $query->whereIn('puja_id', $puja);
        //         });
        //     }
        //     if (@$request->puja_type) {
        //         $pandit = $pandit->whereIn('puja_type', $request->puja_type);
        //     }
        //     if (@$request->amount1 && $request->amount2 && @$request->puja) {
        //         $pandit = $pandit->with(['punditPujas' => function ($query) use ($request) {
        //             $query->whereBetween('price', [$request->amount1, $request->amount2])->whereIn('puja_id', @$request->puja);
        //         }]);
        //         $pandit = $pandit->whereHas('punditPujas', function ($query) use ($request) {
        //             $query->whereBetween('price', [$request->amount1, $request->amount2])->whereIn('puja_id', @$request->puja);
        //         });
        //     }
        //     if (@$request->amount1 && @$request->amount2 && $request->puja == null) {
        //         $pandit = $pandit->with(['punditPujas' => function ($query) use ($request) {
        //             $query->whereBetween('price', [$request->amount1, $request->amount2]);
        //         }]);
        //         $pandit = $pandit->whereHas('punditPujas', function ($query) use ($request) {
        //             $query->whereBetween('price', [$request->amount1, $request->amount2]);
        //         });
        //     }
        //     if (@$request->sort_by) {
        //         $pandit = $pandit->orderby('avg_review', 'desc');
        //     }
        //     $data['request'] = $request->all();
        // }
        // $data['allPandit'] = $pandit->count();
        // $data['pandits'] = $pandit->paginate(20);

        $pujaList= PunditToPuja::with(['users','pujas']);
        if($request->all()){
            if (@$request->puja) {
                $pujaList = $pujaList->whereIn('puja_id', @$request->puja);
            }
            if (@$request->puja) {
                $pujaList = $pujaList->whereBetween('price', [$request->amount1, $request->amount2]);
            }
            if (@$request->puja_type) {
                // $pujaList = $pujaList->with(['users' => function ($query) use ($request) {
                //     $query->whereBetween('price', [$request->amount1, $request->amount2])->whereIn('puja_id', @$request->puja);
                // }]);
                $pujaList = $pujaList->whereHas('users', function ($query) use ($request) {
                    $query->whereIn('puja_type', $request->puja_type);
                });
            }
            if (@$request->sort_by) {
                $userIdList = $pujaList->get('user_id');
                $userIdArray = array();
                foreach ($userIdList as $key => $value) {
                    array_push($userIdArray, $value->user_id);
                }
                $userIdArray = array_unique($userIdArray);
                // $userIdArray = implode(',', $userIdArray);
                $allUser = User::whereIn('id', $userIdArray)->orderby('avg_review', 'desc')->get('id');
                $sortIdArray = array();
                foreach ($allUser as $key => $value1) {
                    array_push($sortIdArray, $value1->id);
                }
                $sortIdArray = implode(',', $sortIdArray);
                $pujaList = $pujaList->orderByRaw("FIELD(user_id, $sortIdArray )");
            }

            $data['request'] = $request->all();
        }
        $data['allPandit'] = $pujaList->count();
        $data['pujaList']= $pujaList->orderBy('puja_id')->paginate(20);
        return view('modules.searchPundit.puja_search')->with($data);
    }
    public function panditPublicProfile($slug){
        $day = ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
        $day = implode(',', $day);
        $data['userData'] = User::where('slug', $slug)->with(['userAvailable', 'countries', 'states', 'punditPujas'])
        ->where('status', 'A')->where('approve_by_admin', 'Y')
        ->first();
        // return $data;
        if ($data['userData'] == null) {
            return redirect()->route('search.pandit');
        }
        return view('modules.searchPundit.pundit_public_profile')->with($data);
    }
    /**
     *   Method      : pujaDetails
     *   Description : puja Details
     *   Author      : Soumojit
     *   Date        : 09-AUG-2021
     **/
    public function pujaDetails($slug){
        $order = [];
        $data['puja'] = Puja::where('slug',$slug)->where('status','A')->with(['pujaDeity','pujaPurpose','category'])->first();
        $data['rashi'] = Rashi::get();
        $data['nakshatra'] = Nakshatras::get();
        $data['gotra'] = Gotra::get();
        $data['zips'] = ZipMaster::get();
        $data['userData'] = Puja::where('slug',$slug)->where('status','A')->with(['pujaDeity','pujaPurpose'])->first();
        // mantra-related-work
        $data['mantra'] = Mantra::get();
        // review_related_work_goes_here
        $ordermaster = OrderMaster::where('puja_id',$data['puja']->id)->where('payment_status','P')->get();
        foreach ($ordermaster as $key => $value) {
            array_push($order, $value->id);
        }
        $data['five_star'] = Review::whereIn('ordermaster_id',$order)->where('ratting_number',5)->count();
        $data['four_star'] = Review::whereIn('ordermaster_id',$order)->where('ratting_number',4)->count();
        $data['three_star'] = Review::whereIn('ordermaster_id',$order)->where('ratting_number',3)->count();
        $data['two_star'] = Review::whereIn('ordermaster_id',$order)->where('ratting_number',2)->count();
        $data['one_star'] = Review::whereIn('ordermaster_id',$order)->where('ratting_number',1)->count();
         if (Auth::check()){
          $data['customers'] = CustomerPujaNames::where('user_id',auth()->user()->id)->get();
          $data['temps'] = TempPujaPerson::where('user_id',auth()->user()->id)->where('puja_id',$data['puja']->id)->get();
        }
        $data['reviews'] = Review::whereIn('ordermaster_id',$order)->get();





        if($data['puja']==null){
            return redirect()->route('search.pandit');
        }
        $data['similarPuja'] = Puja::where('id','!=',$data['puja']->id)->where('status','A')->where('puja_category',$data['puja']->puja_category)->with(['pujaDeity','pujaPurpose','category'])->where('status','A')->take(5)->get();
        if($data['similarPuja']->count()==0){
            $data['similarPuja'] = Puja::where('id','!=',$data['puja']->id)->where('status','A')->with(['pujaDeity','pujaPurpose','category'])->where('status','A')->take(5)->get();

        }

           // benificials to all  planet
            $planetAll = Planets::count();
            $pujaToPlanet = PujaToPlanet::where('puja_id',$data['puja']->id)->count();
            if (@$planetAll==@$pujaToPlanet) {
                $data['benificials_planet'] = 'benificials_planet';
            }
            // benificials to all  rashi
            $rashiAll = Rashi::count();
            $pujaToRashi = PujaToRashi::where('puja_id',$data['puja']->id)->count();
            if (@$rashiAll==@$pujaToRashi) {
                $data['benificials_rashi'] = 'benificials_rashi';
            }
            // benificials to all  nakshatra
            $nakshatraAll = Nakshatras::count();
            $pujaToNakshatra = PujaToNakshatra::where('puja_id',$data['puja']->id)->count();
            if (@$nakshatraAll==@$pujaToNakshatra) {
                $data['benificials_nakshatra'] = 'benificials_nakshatra';
            }
            // benificials to all  deity
            $deityAll = Deity::count();
            $pujaToDeity = PujaToDeity::where('puja_id',$data['puja']->id)->count();
            if (@$deityAll==@$pujaToDeity) {
                $data['benificials_deity'] = 'benificials_deity';
            }

            // new-changes
            $data['faqs'] = Faq::where('puja_id',$data['puja']->id)->get();
            $data['all_faq_cat']=FaqCategory::with('parent')->Join('faq','faq.subcategory_id','=','faq_category.id')->leftJoin('faq_product','faq.id','=','faq_product.faq_id')->select('faq_category.*')->whereRaw(DB::raw("(faq_product.product_id = ".$data['puja']->id." OR faq.product_id = ".$data['puja']->id.")"))->where('faq.type','PU')->where('parent_id','!=',0)->groupBy('faq_category.id')->get();
			if(@$data['all_faq_cat']->isNotEmpty())
			{
				foreach(@$data['all_faq_cat'] as $key=>$fcat)
				{
					$data['all_faq_cat'][$key]['all_faq']=Faq::leftJoin('faq_product','faq.id','=','faq_product.faq_id')->select('faq.*')->where('subcategory_id',$fcat->id)->whereRaw(DB::raw("(faq_product.product_id = ".$data['puja']->id." OR faq.product_id = ".$data['puja']->id.")"))->where('faq.type','PU')->groupBy('faq.id')->orderBy('faq.display_order','desc')->get();
				}
				
			}
            if (@$data['all_faq_cat']->isEmpty()) {
                $data['faq_status'] = 'N';
            }
        return view('modules.searchPundit.puja_details')->with($data);
    }

    public function checkZip(Request $request){


        $checkZipCodeInMaster=ZipMaster::where('zipcode', $request->zipCode)->first();
        if ($checkZipCodeInMaster) {
            if (Auth::check()) {
                $pujaget = PunditToPuja::where('puja_id',$request->pujaId)->pluck('user_id')->toArray();
                $zipget = ZipMaster::where('zipcode', $request->zipCode)->pluck('id')->toArray();
                $pundit_zipcode = PunditToZipcode::whereIn('zipcode_id',$zipget)->pluck('pundit_id')->toArray();
                $uniq_pundit_zipcode = array_unique($pundit_zipcode);
                $found_pundit = array_intersect($pujaget, $uniq_pundit_zipcode);
                $pundit_data = User::where('status','A')->where('user_availability','Y')->where('user_type','P')->whereIn('id',$found_pundit)->where('id','!=',auth()->user()->id)->get();
                
                if(count(@$pundit_data)>0){
                $response['result']['success']= 'Puja available this area';
                $response['result']['data']= @$puja;
                return response()->json($response);
               }else{
                $response['result']['success']=null;
                $response['result']['error']= 'Puja not available this area';
                return response()->json($response);
               }
                



            }else{
                $pujaget = PunditToPuja::where('puja_id',$request->pujaId)->pluck('user_id')->toArray();
                $zipget = ZipMaster::where('zipcode', $request->zipCode)->pluck('id')->toArray();
                $pundit_zipcode = PunditToZipcode::whereIn('zipcode_id',$zipget)->pluck('pundit_id')->toArray();
                $uniq_pundit_zipcode = array_unique($pundit_zipcode);
                $found_pundit = array_intersect($pujaget, $uniq_pundit_zipcode);
                $pundit_data = User::where('status','A')->where('user_availability','Y')->where('user_type','P')->whereIn('id',$found_pundit)->get();
                if(count(@$pundit_data)>0){
                $response['result']['success']= 'Puja available this area';
                $response['result']['data']= @$puja;
                return response()->json($response);
               }else{
                $response['result']['success']=null;
                $response['result']['error']= 'Puja not available this area';
                return response()->json($response);
               }

            }   
        
        }
        
       
        // if($checkZipCodeInMaster){
        //     if (Auth::check()) {
        //         $users = User::where('user_type','P')->where('status','A')->where('id','!=',auth()->user()->id)->pluck('id')->toArray();
        //     $puja= Puja::where('id',$request->pujaId)->where('status','A')->with(['pujaPandit.zipcode'])
        //     ->whereHas('pujaPandit.zipcode', function ($query) use ($checkZipCodeInMaster,$users) {
        //         $query->where('zipcode_id', $checkZipCodeInMaster->id)->whereIn('pundit_id',$users);
        //     })->get();
        //    }else{
        //     $users = User::where('user_type','P')->where('status','A')->pluck('id')->toArray();
        //     $puja= Puja::where('id',$request->pujaId)->where('status','A')->with(['pujaPandit.zipcode'])
        //     ->whereHas('pujaPandit.zipcode', function ($query) use ($checkZipCodeInMaster,$users) {
        //         $query->where('zipcode_id', $checkZipCodeInMaster->id)->whereIn('pundit_id',$users);
        //     })->get();
        //     // $puja1= Puja::where('id',$request->pujaId)->where('status','A')->first();
        //     // if ($puja1!="") {
        //     //     $checkZipCodeInMaster=ZipMaster::where('zipcode', $request->zipCode)->first();
        //     //     $puja = PunditToZipcode::whereIn('pundit_id',$ids)->where('zipcode_id',$checkZipCodeInMaster->id)->get();
        //     // }
        //    }
           
        //     if(count(@$puja)>0){
        //         $response['result']['success']= 'Puja available this area';
        //         $response['result']['data']= @$puja;
        //         return response()->json($response);
        //     }
        //     $response['result']['success']=null;
        //     $response['result']['error']= 'Puja not available this area';
        //     return response()->json($response);
        // }
        $response['result']['success']=null;
        $response['result']['error']= 'Puja not available this area';
        return response()->json($response);
    }
	/**
	*Method:pujaAllCategory
	*Description:Showing count related categories
	*Author:Madhuchandra
	*Date:2021-NOV-22
	*/
	public function pujaAllCategory()
    {
        $data = [];
        $data['categories'] = PujaCategory::withCount([
		'pujaDetails', 
    'pujaDetails as subcat_count' => function ($query) {
        $query->select(DB::raw('count(distinct(puja_id))'))->whereRaw(DB::raw('puja_sub_category IS NOT NULL'));
    },'pujaDetails as puja_name_count' => function ($query) {
        $query->select(DB::raw('count(distinct(puja_id))'))->whereRaw(DB::raw('puja_id IS NOT NULL'));
    }])->where('status','A')->where('parent_id',0)->get();
	//dd($data['categories']);
        return view('modules.separate_search.puja_all_category')->with($data);
    }
	
	/**
	*Method:pujaAllSubCategory
	*Description:Showing count related sub categories
	*Author:Madhuchandra
	*Date:2021-NOV-22
	*/
	public function pujaAllSubCategory($slug)
    {
        $data = [];
		$data['parent_category']=$parent=PujaCategory::where('slug',$slug)->first();
        $data['subcategories'] = PujaCategory::withCount([
    'pujaDetailsSubCategory', 
    'pujaDetailsSubCategory as puja_name_count' => function ($query) {
        $query->select(DB::raw('count(distinct(puja_id))'))->whereRaw(DB::raw('puja_id IS NOT NULL'));
    }])->where('status','A')->where('parent_id',$parent->id)->get();
	//dd($data['subcategories']);
        return view('modules.separate_search.puja_sub_category')->with($data);
    }
	/**
	*Method:pujaAllNames
	*Description:Showing count related to puja names
	*Author:Madhuchandra
	*Date:2021-NOV-22
	*/
	public function pujaAllNames($slug)
    {
        $data = [];
		$data['category']=$category=PujaCategory::with('parent')->where('slug',$slug)->first();
        $data['puja_names'] = PujaName::withCount([
    'pujaDetails as puja_count' => function ($query) use($category) {
        $query->where('puja_category',$category->id)->orWhere('puja_sub_category',$category->id);
    }])->get();
	$data['cat_slug']=$slug;
	//dd($data['puja_names']);
        return view('modules.separate_search.puja_all_names')->with($data);
    }
	
	/**
	*Method:pujaAllSearch
	*Description:Showing pujas
	*Author:Madhuchandra
	*Date:2021-NOV-22
	*/
	public function pujaAllSearch(Request $request,$slug,$id=null)
    {
        $data = [];
		$data['category']=$category=PujaCategory::with('parent')->where('slug',$slug)->first();
		if(@$id)
		{
			$puja = Puja::where('status','A')->where(function($query) use ($category){ 
			$query->where('puja_category',$category->id)->orWhere('puja_sub_category',$category->id); 
			})->where('puja_id',$id);
		}
		else
		{
			$puja = Puja::where('status','A')->where(function($query) use ($category){ 
			$query->where('puja_category',$category->id)->orWhere('puja_sub_category',$category->id); 
			});
		}
		$data['allPuja']= $puja->count();
        if(@$request->all()){
            if(@session()->get('currency')==1){
                
                if(@$request->sort_by){
                    if(@$request->sort_by==1){
                        $puja= $puja->orderby('price_inr', 'desc');
                    }

                    if(@$request->sort_by==2){
                        $puja= $puja->orderby('price_inr', 'asc');
                    }

                }
            }else{
                if(@$request->sort_by){
                    if(@$request->sort_by==1){
                        $puja= $puja->orderby('price_usd', 'desc');
                    }

                    if(@$request->sort_by==2){
                        $puja= $puja->orderby('price_usd', 'asc');
                    }

                }
            }


            

        }
		
        if (@$request->show_result){
            $data['pujas']= $puja->paginate(@$request->show_result);
        }else{
            $data['pujas']= $puja->paginate(12);
        }
        
        $data['request'] = $request->all();
        $data['content'] = SearchPageData::where('type','PU')->first();
         $data['all_faq_cat']=FaqCategory::with('parent','pujaFaqDetails')->where('parent_id','!=',0)->has('pujaFaqDetails')->get();
		 $data['cat_slug']=@$slug;
		 $data['puja_id']=@$id;
        return view('modules.separate_search.puja_separate_search')->with($data);
    }
}
