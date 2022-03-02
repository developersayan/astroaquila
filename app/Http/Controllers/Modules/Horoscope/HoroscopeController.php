<?php

namespace App\Http\Controllers\Modules\Horoscope;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Horoscope;
use App\Models\HoroscopeCategory;
use App\Models\CurrencyConversion;
use App\Models\FaqCategory;
use App\Models\Faq;
use App\Models\Country;
use App\Models\OrderMaster;
use DB;
use App\Mail\ProductOrderEmail;
use Mail;
use App\Models\SearchPageData;
use App\Models\HoroscopeTitle;
use App\Models\Expertise;
use App\Models\HoroscopeToExpertise;
use App\Models\CustomerAddressBook;
use App\Models\State;
use App\Models\City;
use App\Models\ZipMaster;
use App\Models\Area;
use App\Models\Databank;
use App\Models\Profession;
use App\Models\Famous;
use App\Models\CustomerPujaNames;
class HoroscopeController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth')->except('horoscopeSearch','horoscopeDetails','databank');

    }
	/**
	*Method:horoscopeSearch
	*Description:To show the list of horoscope and filter them
	*Author:Madhuchandra
	*Date:2021-NOV-24
	*/
    public function horoscopeSearch(Request $request)
	{
		$data=array();
		$horoscope=Horoscope::where('status','A')->select('horoscope.*')->join('horoscope_category','horoscope.category_id','=','horoscope_category.id');
		if(@$request->all())
		{
			if(@$request->keyword){
                $horoscope=$horoscope->where(function($query) use($request){
					$query->where('horoscope.name','LIKE','%'.$request->keyword.'%')->orWhere('horoscope_category.name','LIKE','%'.$request->keyword.'%')->orWhere('horoscope.about_report','LIKE','%'.$request->keyword.'%');
				});
            }

            if (@$request->expertise) {
                $horoscope = $horoscope->whereHas('horoscopeExpertise',function ($query) use ($request){
                $query = $query->whereIn('expertise_id', $request->expertise);
              });
            }


			if(@$request->category){

				if (@$request->subcat) {
                   $horoscope=$horoscope->where('sub_category_id',$request->subcat);
                }else{
                $horoscope=$horoscope->where('category_id',$request->category);
                // return $products->get();
               }
            }
			if(@$request->title_id){
                $horoscope=$horoscope->where('title_id',$request->title_id);
            }
			if(@session()->get('currency')==1){
                if(@$request->amount1!=null && @$request->amount2!=null){
                    $horoscope = $horoscope->whereBetween('price_inr',[$request->amount1,$request->amount2]);
                }
                if (@$request->discount){
                    $maxDiscount=max(@$request->discount);
                        $horoscope=$horoscope->whereBetween('discount_inr',[1,$maxDiscount]);
                }
                if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $horoscope=$horoscope->orderBy('price_inr','DESC');

                    }
                    if(@$request->sort_by==2){
                        $horoscope=$horoscope->orderBy('price_inr','ASC');
                    }
                }
            }else{
                if(@$request->amount1!=null && @$request->amount2 !=null){
                	@$get = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
                    if(@$request->amount1 !=null && @$request->amount2 !=null){
                    $convert = 1/@$get->conversion_factor;
                    $amount1 = round($request->amount1*$convert,2);
                    $amount2 = round($request->amount2*$convert,2);
                    $horoscope = $horoscope->whereBetween('price_usd',[$amount1,$amount2]);
                }
                if (@$request->discount){
                    $maxDiscount=max(@$request->discount);
                        $horoscope=$horoscope->whereBetween('discount_usd',[1,$maxDiscount]);
                }
                if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $horoscope=$horoscope->orderBy('price_usd','DESC');

                    }
                    if(@$request->sort_by==2){
                        $horoscope=$horoscope->orderBy('price_usd','ASC');
                    }
                }
				else
				{
					$horoscope=$horoscope->orderBy('id','DESC');
				}
            }
            }
		}
		else
		{
			$horoscope=$horoscope->orderBy('id','DESC');
		}
		$data['totalhoroscope'] = $horoscope->count();
		$result_data_horoscope = $horoscope->pluck('id');
		if (@$request->show_result){
			$data['horoscopes']=$horoscope->paginate(@$request->show_result);
        }else{
            $data['horoscopes']=$horoscope->paginate(12);
        }
		$data['request'] = $request->all();
		if(@session()->get('currency')==1){
			$maxprice=Horoscope::where('status','A')->max('price_inr');
		}
		else
		{
			$maxprice=Horoscope::where('status','A')->max('price_usd');
		}
		$data['max_price']=@$maxprice;
		$data['categories']=HoroscopeCategory::with('horoscopeDetails')->whereHas('horoscopeDetails',function($query) use($result_data_horoscope){
			$query->whereIn('id', $result_data_horoscope);
		})->orderBy('name')->get();
		if(@$request->category){
		$data['subcategories'] = HoroscopeCategory::with('horoscopeDetailsSubCategory')->whereHas('horoscopeDetailsSubCategory',function($query) use($result_data_horoscope){
					$query->whereIn('id', $result_data_horoscope);
				})->where('parent_id',@$request->category)->orderBy('name','asc')->get();
		}
		$data['hscopetitles'] = HoroscopeTitle::with('horoscopeDetails')->whereHas('horoscopeDetails',function($query) use($result_data_horoscope){
			$query->whereIn('id', $result_data_horoscope);
		})->orderBy('title','asc')->get();

		$data['expertise']=Expertise::with('horoscopeDetails')->whereHas('horoscopeDetails',function($query) use($result_data_horoscope){
			$query->whereIn('horoscope_id', $result_data_horoscope);
		})->orderBy('expertise_name','asc')->get();

		$data['content'] = SearchPageData::where('type','H')->first();
        $data['all_faq_cat']=FaqCategory::with('parent','horoscopeFaqDetails')->where('parent_id','!=',0)->has('horoscopeFaqDetails')->get();
		return view('modules.horoscope.horoscope_search',$data);
	}
	/**
	*Method:horoscopeSearch
	*Description:To show the details of a horoscope
	*Author:Madhuchandra
	*Date:2021-NOV-24
	*/
	public function horoscopeDetails($slug)
	{
		$data=array();
		$data['horoscope_details']=$horoscope_details=Horoscope::where('status','A')->where('slug',$slug)->first();
		if(!$horoscope_details)
		{
			return redirect()->route('horoscope.search')->with('error','Something went wrong');
		}
		$data['all_faq_cat']=FaqCategory::with('parent')->Join('faq','faq.subcategory_id','=','faq_category.id')->leftJoin('faq_horoscope','faq.id','=','faq_horoscope.faq_id')->select('faq_category.*')->whereRaw(DB::raw("(faq_horoscope.horoscope_id = ".$horoscope_details->id." OR faq.horoscope_id = ".$horoscope_details->id.")"))->where('faq.type','H')->where('parent_id','!=',0)->groupBy('faq_category.id')->get();
		if(@$data['all_faq_cat']->isNotEmpty())
		{
			foreach(@$data['all_faq_cat'] as $key=>$fcat)
			{
				$data['all_faq_cat'][$key]['all_faq']=Faq::leftJoin('faq_horoscope','faq.id','=','faq_horoscope.faq_id')->select('faq.*')->where('subcategory_id',$fcat->id)->whereRaw(DB::raw("(faq_horoscope.horoscope_id = ".$horoscope_details->id." OR faq.horoscope_id = ".$horoscope_details->id.")"))->where('faq.type','H')->groupBy('faq.id')->orderBy('faq.display_order','desc')->get();
			}
		}
		$data['similar_horoscopes']=Horoscope::where('category_id',$horoscope_details->category_id)->where('status','A')->where('id','!=',$horoscope_details->id)->paginate(5);

		return view('modules.horoscope.horoscope_details',$data);
	}
	/**
	*Method:orderNow
	*Description:To show the list of horoscope and filter them
	*Author:Madhuchandra
	*Date:2021-NOV-25
	*/
	public function orderNow(Request $request,$slug)
	{
		$data=array();
		$data['horoscope_details']=$horoscope_details=Horoscope::where('status','A')->where('slug',$slug)->first();
		if(!$horoscope_details)
		{
			return redirect()->route('horoscope.search')->with('error','Something went wrong');
		}
		if(@$request->all())
		{
			// return $request;
			//dd(@$request->all());
			$order=array();
			$order['customer_id']=auth()->user()->id;
			$order['horoscope_id']=$horoscope_details->id;
			$order['status']='N';
			$order['payment_type']='O';
			$order['payment_status']='P';
			$order['order_type']='H';
			$order['currency_id']=@session()->get('currency');

			$order['email']=@$request->email;
			$order['gender']=@$request->gender;
			$order['phone_no']=@$request->mobile;


			if(@$request->customer_book)
			{
				$person = CustomerPujaNames::where('id',@$request->customer_book)->first();
				$order['name'] = $person->name;
				$order['place'] = $person->place_of_residence;
				$order['dob'] = date('Y-m-d',strtotime(@$person->dob));
				if (@$person->dob=='') {
					$order['no_dob']='N';
				}else{
					$order['no_dob']='Y';
				}
				$order['dob_time'] = date('H:i:s',strtotime(@$person->dob_time));
				if (@$person->dob_time=='') {
					$order['no_dob_time']='Y';
				}else{
					$order['no_dob_time']='N';
				}

			}else{



			$order['name']=@$request->full_name;
			if(@$request->date_of_birth)
			{
				$order['dob']=date('Y-m-d',strtotime(@$request->date_of_birth));
			}
			if(@$request->time_of_birth)
			{
				$order['dob_time']=date('H:i:s',strtotime(@$request->time_of_birth));
			}
			if(@$request->birth_date)
			{
				$order['no_dob']='Y';
			}
			else
			{
				$order['no_dob']='N';
			}
			if(@$request->birth_time)
			{
				$order['no_dob_time']='Y';
			}
			else
			{
				$order['no_dob']='N';
			}
			$order['place']=@$request->place;
			$order['place_latitude']=@$request->lat;
			$order['place_longitude']=@$request->lng;

		  	$check = CustomerPujaNames::where('name',$request->full_name)->where('dob',date('Y-m-d',strtotime(@$request->date_of_birth)))->where('dob_time',date('H:i:s',strtotime(@$request->time_of_birth)))->where('place_of_residence',@$request->place)->first();
		  	if (@$check=='') {
		  		$ins['name'] = $request->full_name;
		  		$ins['dob'] = date('Y-m-d',strtotime(@$request->date_of_birth));
		  		$ins['dob_time'] = date('H:i:s',strtotime(@$request->time_of_birth));
		  		$ins['place_of_residence'] =@$request->place;
		  		$ins['user_id'] = auth()->user()->id;
		  		CustomerPujaNames::create($ins);
		  	}


		  }
			$order['problem_question']=@$request->problem_question;
			if(@session()->get('currency')==1 && @$horoscope_details->delivery_days_india)
			{
				$total_delivery_days=@$horoscope_details->delivery_days_india+1;
				$order['horoscope_delivery_date']=date('Y-m-d',strtotime('+ '.$total_delivery_days.' days'));
			}
			elseif(@$horoscope_details->delivery_days_outside_india)
			{
				$total_delivery_days=@$horoscope_details->delivery_days_outside_india+1;
				$order['horoscope_delivery_date']=date('Y-m-d',strtotime('+ '.$total_delivery_days.' days'));
			}
			$order['country_id']=@$request->country;
			$order['date']=date('Y-m-d');
			$old_price=0;
			$discount_value=0;
			$new_price=0;
			if(@session()->get('currency')==1)
			{
				$new_price = $request->price;
				// if(@$horoscope_details->discount_inr!=null && @$horoscope_details->discount_inr>0)
				// {
				// 	$old_price = $horoscope_details->price_inr;
				// 	$discount_value = ($old_price / 100) * @$horoscope_details->discount_inr;
				// 	$new_price = $old_price - $discount_value;
				// }
				// else
				// {
				// 	$old_price=$horoscope_details->price_inr;
				// 	$new_price=$horoscope_details->price_inr;
				// }

			}
			else
			{
				$new_price = $request->price;
				// if(@$horoscope_details->discount_usd!=null && @$horoscope_details->discount_usd>0)
				// {
				// 	$old_price = currencyConversionCustom() * $horoscope_details->price_usd;
				// 	$discount_value = ($old_price / 100) * @$horoscope_details->discount_usd;
				// 	$new_price = $old_price - $discount_value;
				// }
				// else
				// {
				// 	$old_price=currencyConversionCustom() * $horoscope_details->price_usd;
				// 	$new_price=currencyConversionCustom() * $horoscope_details->price_usd;
				// }
			}
			$order['subtotal']=$old_price;
			$order['discount']=$discount_value;

			if (@$request->physical_del) {
				$order['horoscope_delivery']='Y';
				$order['horoscope_delivery_price'] = @$request->physical_del;
				$total_price = $new_price+@$request->physical_del;

				if(@$request->address_book){
					$address = CustomerAddressBook::where('user_id',auth()->user()->id)->with('countryDetails','stateDetails')->where('id',$request->address_book)->first();
					// return $address;
					if(@$address){
						$order['shipping_fname']=@$address->fname;
				        $order['shipping_lname']=@$address->lname;
				        $order['shipping_phone']=@$address->phone;
				        $order['shipping_email']=@$address->email;
				        $order['shipping_country']=@$address->country;
				        $order['shipping_state']=@$address->state;
				        $order['shipping_landmark']=@$address->landmark;
				        $order['shipping_pin_code']=@$address->postcode;
				        $order['shipping_city']=@$address->city;
				        $order['shipping_address']=@$address->address;
				        $order['shipping_street']=@$address->street;
				        $order['shipping_area']=@$address->area;


					}
				    }else{

						$order['shipping_fname']=@$request->fname;
				        $order['shipping_lname']=@$request->lname;
				        $order['shipping_phone']=@$request->phone;
				        $order['shipping_email']=@$request->email_one;
				        $order['shipping_country']=@$request->country_one;
				        $order['shipping_state']=@$request->state;
				        $order['shipping_landmark']=@$request->landmark;
				        $order['shipping_pin_code']=@$request->zip_code;
				        $order['shipping_city']=@$request->city;
				        $order['shipping_address']=@$request->address;
				        $order['shipping_street']=@$request->st_address;

                        $post_id = ZipMaster::where([
                            'country_id' => @$request->country_one,
                            'state_id' => $request->state,
                            'city_id' => $request->city,
                            'zipcode'=>$request->zip_code,
                        ])->first();
                        $insArea['country_id'] = @$request->country_one;
                        $insArea['state_id'] = $request->state;
                        $insArea['city_id'] = $request->city;
                        $insArea['postcode_id'] = @$post_id->id;
                        $insArea['area'] = $request->area;
                        if($request->area_drop){
                            if($request->area_drop == 'O'){
                                $area = trim(strtolower($request->area));
                                $check = Area::where('state_id',$request->state)
                                     ->where('city_id',$request->city)
                                     ->where('postcode_id',@$post_id->id)
                                     ->where(DB::raw('trim(lower(area))'),$area)
                                     ->first();
                                if($check){
                                    $order['shipping_area'] = @$check->id;
                                }else{
                                    $area_ins = Area::create($insArea);
                                    $order['shipping_area'] = @$area_ins->id;
                                }
                            }else{
                                $order['shipping_area'] = @$request->area_drop;
                            }
                        }
				        $checkAddress = CustomerAddressBook::where('user_id',auth()->user()->id)
				        ->where('fname',@$request->fname)->where('lname',@$request->lname)->where('phone',@$request->phone)->where('email',@$request->email_one)
				        ->where('country',@$request->country_one)->where('state',@$request->state)->where('city',@$request->city)->where('street',@$request->st_address)
				        ->where('postcode',@$request->zip_code)->where('landmark',@$request->landmark)->where('address',@$request->address)->first();


				            if(@$checkAddress==null && @$request->save_in_address_book){

                                $post_id1 = ZipMaster::where([
                                    'country_id' => @$request->country_one,
                                    'state_id' => $request->state,
                                    'city_id' => $request->city,
                                    'zipcode'=>$request->zip_code,
                                ])->first();
                                $insArea['country_id'] = @$request->country_one;
                                $insArea['state_id'] = $request->state;
                                $insArea['city_id'] = $request->city;
                                $insArea['postcode_id'] = @$post_id1->id;
                                $insArea['area'] = $request->area;
                                if($request->area_drop){
                                    if($request->area_drop == 'O'){
                                        $area = trim(strtolower($request->area));
                                        $check = Area::where('state_id',$request->state)
                                             ->where('city_id',$request->city)
                                             ->where('postcode_id',@$post_id->id)
                                             ->where(DB::raw('trim(lower(area))'),$area)
                                             ->first();
                                        if($check){
                                            $order['shipping_area'] = @$check->id;
                                        }else{
                                            $area_ins = Area::create($insArea);
                                            $order['shipping_area'] = @$area_ins->id;
                                        }
                                    }else{
                                        $order['shipping_area'] = @$request->area_drop;
                                    }
                                }

					            CustomerAddressBook::where('user_id',auth()->user()->id)->update(['is_default'=>'N']);
					            $ins1=[];
					            $ins1['user_id']=auth()->user()->id;
					            $ins1['fname']=@$request->fname;
					            $ins1['lname']=@$request->lname;
					            $ins1['phone']=@$request->phone;
					            $ins1['email']=@$request->email_one;
					            $ins1['country']=@$request->country_one;
					            $ins1['state']=@$request->state;
					            $ins1['landmark']=@$request->landmark;
					            $ins1['postcode']=@$request->zip_code;
					            $ins1['city']=@$request->city;
					            $ins1['street']=@$request->st_address;
					            $ins1['address']=@$request->address;
					            $ins1['is_default']='Y';
					            CustomerAddressBook::create($ins1);
					        }elseif(@$checkAddress){
					            CustomerAddressBook::where('user_id',auth()->user()->id)->update(['is_default'=>'N']);
					            CustomerAddressBook::where('user_id',auth()->user()->id)->where('id',$checkAddress->id)->update(['is_default'=>'Y']);
					        }
				}
		    }else{
		    	$order['horoscope_delivery']='N';
		    	$order['horoscope_delivery_price'] = 0;
		    	$total_price = $new_price;
		    }

		    $order['total_rate']=$total_price;

			$createBooking=OrderMaster::create($order);
			$code='';
			$idlength=strlen($createBooking->id);
			if($idlength>4)
			{
				$code=$createBooking->id;
			}
			else
			{
				for($i=0;$i<(4-$idlength);$i++)
				{
					$code.='0';
				}
				$code=$code.$createBooking->id;
			}
			$upd=[];
			$upd['order_id']='H'.date('y').date('m').date('d').$code;
			OrderMaster::where('id', $createBooking->id)->update($upd);
			$mail_details['order']=OrderMaster::where('id', $createBooking->id)->first();
			@$order = OrderMaster::where('id', $createBooking->id)->first();
			$mail_details['type']='H';
			$mail_details['email']=$mail_details['order']->customer->email;
			Mail::send(new ProductOrderEmail($mail_details));
			$mail_details['email']=$mail_details['order']->email;
			if($mail_details['order']->customer->email!=$mail_details['order']->email)
			{
				Mail::send(new ProductOrderEmail($mail_details));
			}


			return redirect()->route('user.manage.horoscope.order')->with('success','Order placed successfully');
		}
		$data['countries']=Country::orderBy('name')->get();
		$data['lastOrder']= OrderMaster::where('order_type','H')->where('customer_id',auth()->user()->id)->orderby('id','DESC')->first();
		if($data['lastOrder']!=null){
            $data['state']=State::where('country_id',$data['lastOrder']->shipping_country)->get();
            $postcode_shipping = ZipMaster::where([
                'country_id' => $data['lastOrder']->shipping_country,
                'state_id' => $data['lastOrder']->shipping_state,
                'city_id' => $data['lastOrder']->shipping_city,
                'zipcode'=>$data['lastOrder']->shipping_pin_code,
            ])->first();
            $data['city']=City::where('state_id',$data['lastOrder']->shipping_state)->get();
            $data['areas']=Area::where([
                                    'country_id' => $data['lastOrder']->shipping_country,
                                    'state_id' => $data['lastOrder']->shipping_state,
                                    'city_id' => $data['lastOrder']->shipping_city,
                                    'postcode_id'=>@$postcode_shipping->id,
                                ])
                                ->get();
                                

        }
		$data['addressBook']=CustomerAddressBook::where('user_id',auth()->user()->id)->with('countryDetails','stateDetails','cityDetails','areaDetails')->get();
		$data['customers'] = CustomerPujaNames::where('user_id',auth()->user()->id)->get();
		return view('modules.horoscope.order_now',$data);
	}


	public function databank(Request $request)
	{
		$data = [];
		$data['data'] = Databank::orderBy('id','desc');
		if (@$request->famous) {
			$data['data'] = $data['data']->where('famous_id',@$request->famous);
		}
		if (@$request->profession) {
			$data['data'] = $data['data']->where('profession_id',@$request->profession);
		}
		if (@$request->keyword) {
			$data['data'] = $data['data']->where('name','LIKE','%'.request('keyword').'%');
		}
		if (@$request->country) {
			$data['data'] = $data['data']->where('country_id',@$request->country);
		}
		// return @$request->sort;

		if(@$request->sort_by)
	    {

	    	 if(@$request->sort_by==1)
			   {
				   $data['data'] = $data['data']->orderBy('name','asc');
			   }
	    }
		if (@$request->show_result){

             $data['data']= $data['data']->paginate(@$request->show_result);
        }else{
            $data['data'] = $data['data']->paginate(12);
        }

		$profession = $data['data']->pluck('profession_id')->toArray();
		$famous = $data['data']->pluck('famous_id')->toArray();
		$country = $data['data']->pluck('country_id')->toArray();
		$data['famous'] = Famous::whereIn('id',$famous)->get();
		$data['profession'] = Profession::whereIn('id',$profession)->get();
		$data['country'] = Country::whereIn('id',$country)->get();
		$data['totaldata'] = $data['data']->count();
		$data['all_faq_cat']=FaqCategory::with('parent','dataDetails')->where('parent_id','!=',0)->has('dataDetails')->get();
		return view('modules.dataBank.search',$data);
	}



	public function databankDetails($id)
	{
		$data = [];
		$data['data'] = Databank::where('slug',$id)->first();
		$data['similar'] = Databank::where('slug','!=',$id)->limit('5')->inRandomOrder()->get();
		return view('modules.dataBank.details',$data);
	}

	public function downlaod($file)
	{
		$file_path = @storage_path() . "/app/public/data_bank_attachment/".$file;
        return response()->download( $file_path);
	}


	public function allCategory()
	{
		$data =[];
		$data['category'] = HoroscopeCategory::where('parent_id',0)->get();
		return view('modules.separate_search.horoscope_all_category',$data);
	}

	public function subCategory($id)
	{
		$data = [];
		$data['subcategories'] = HoroscopeCategory::where('parent_id',$id)->get();
		$data['category'] = HoroscopeCategory::where('id',$id)->first();
		return view('modules.separate_search.horoscope_sub_category',$data);

	}

	public function horoscopeTitle($id)
	{
      $data = [];
      $data['subCategory'] = HoroscopeCategory::where('id',$id)->first();
      $data['category'] = HoroscopeCategory::where('id',$data['subCategory']->parent_id)->first();
      $title = Horoscope::where('sub_category_id',$id)->where('status','A')->pluck('title_id')->toArray();
      $uniq = array_unique($title);
      $data['title'] = HoroscopeTitle::whereIn('id',$uniq)->get();
      return view('modules.separate_search.horoscope_title',$data);
    }


    public function separateSearch($id,$cat,Request $request)
    {
    	$data = [];
    	$data['content'] = SearchPageData::where('type','H')->first();
        $data['all_faq_cat']=FaqCategory::with('parent','horoscopeFaqDetails')->where('parent_id','!=',0)->has('horoscopeFaqDetails')->get();

        $check = HoroscopeCategory::where('id',$cat)->first();
        if (@$check->parent_id==0) {
        	$data['horoscopes'] = Horoscope::where('category_id',$cat)->where('title_id',$id)->where('status','A');
        }else{
        	$data['horoscopes'] = Horoscope::where('sub_category_id',$cat)->where('title_id',$id)->where('status','A');
        }
        $data['totalhoroscope'] = $data['horoscopes']->count();
        if (@$request->sort_by){
                    if(@$request->sort_by==1){
                        $data['horoscopes']=$data['horoscopes']->orderBy('price_usd','DESC');

                    }
                    if(@$request->sort_by==2){
                        $data['horoscopes']=$data['horoscopes']->orderBy('price_usd','ASC');
                    }
         }
         if (@$request->show_result){
            $data['horoscopes'] = $data['horoscopes']->paginate(@$request->show_result);

        }else{
            $data['horoscopes'] = $data['horoscopes']->paginate(12);
        }

        $data['request'] = $request->all();
        $data['cat'] = $cat;
        $data['id'] = $id;

        return view('modules.separate_search.horoscope_separate_search',$data);

    }


    public function horoscopeTitleCategory($id)
    {
    	// return $id;
      $data = [];
      $data['category'] = HoroscopeCategory::where('id',$id)->first();
      $title = Horoscope::where('category_id',$id)->where('status','A')->pluck('title_id')->toArray();
      $uniq = array_unique($title);
      $data['title'] = HoroscopeTitle::whereIn('id',$uniq)->get();
      return view('modules.separate_search.horoscope_category_title',$data);
    }
}
