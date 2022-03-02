<?php

namespace App\Http\Controllers\Modules\AstrologerSearch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Expertise;
use App\Models\LanguageSpeak;
use App\Models\UserToAvailable;
use App\Models\OrderMaster;
use App\User;
use Auth;
use App\Models\CurrencyConversion;
use App\Models\CallHistory;
use DB;
use App\Models\Review;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\FaqCategory;
use App\Models\Faq;
use App\Models\SearchPageData;
use App\Models\AstroTip;
use App\Models\AstrologerExclusionDateList;
use App\Models\UserWallet;

class AstrologerSearchController extends Controller
{
	public function __construct()
    {
        // $this->middleware('customer.access');
    }
    /**
     *   Method      : index
     *   Description : Astrologer profile search
     *   Author      : Soumojit
     *   Date        : 2021-MAY-8
     **/

    public function index(Request $request)
    {

    	$data = [];
      if (Auth::check()) {
        $data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('users.id','!=',auth()->user()->id);
      }else{
    	$data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y');
      }
	  if(@$request->keyword){
			$data['astrologers']=$data['astrologers']->where(function($query) use($request){
				$query->where(DB::raw("CONCAT(users.first_name,' ',users.last_name)"),'LIKE','%'.$request->keyword.'%')->orWhere('language_speakes.language_name','LIKE','%'.$request->keyword.'%')->orWhere('expertise.expertise_name','LIKE','%'.$request->keyword.'%');
			});
		}
	  if (@$request->country_id) {
			$data['astrologers'] = $data['astrologers']->where('country_id',@$request->country_id);
        }
		if (@$request->state_id) {
			$data['astrologers'] = $data['astrologers']->where('state',@$request->state_id);
        }
		if (@$request->city_id) {
			$data['astrologers'] = $data['astrologers']->where('city',@$request->city_id);
        }
        // expertise-search
        if (@$request->expertise) {
        $data['astrologers'] = $data['astrologers']->whereHas('astrologerExpertise',function ($query) use ($request)
            {
                $query = $query->whereIn('expertise_id', $request->expertise);
            });
        }



        // language-search
        if(@$request->language){
            $data['astrologers'] = $data['astrologers']->whereHas('astrologerLanguage',function ($query) use ($request)
            {
                $query = $query->whereIn('language_id', $request->language);
            });
        }


        // offer_type
        if (@$request->offer_type ) {



         if (in_array(2, $request->offer_type)) {

            if (in_array(3, $request->offer_type) && in_array(2, $request->offer_type) && in_array(4, $request->offer_type)) {
              $ids =  $data['astrologers']->pluck('id')->toArray();
              $data['astrologers'] = User::whereIn('id',$ids)->where('is_chat','Y')->orWhere('is_video_call','Y')->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');


            }elseif (in_array(3, $request->offer_type) && in_array(4, $request->offer_type)) {
              $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_chat','Y')
                      ->orWhere('is_video_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(1, $request->offer_type) && in_array(4, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_video_call','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(1, $request->offer_type) && in_array(3, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_video_call','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_chat','Y');
              });
            }else{
              $data['astrologers'] = $data['astrologers']->where('is_video_call','Y');
            }
          }

          elseif (in_array(3, $request->offer_type)) {
            if (in_array(3, $request->offer_type) && in_array(2, $request->offer_type) && in_array(4, $request->offer_type)) {
              $ids =  $data['astrologers']->pluck('id')->toArray();
              $data['astrologers'] = User::whereIn('id',$ids)->where('is_chat','Y')->orWhere('is_video_call','Y')->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');


            }elseif (in_array(2, $request->offer_type) && in_array(4, $request->offer_type)) {
              $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_chat','Y')
                      ->orWhere('is_video_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(1, $request->offer_type) && in_array(4, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_chat','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(1, $request->offer_type) && in_array(2, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_video_call','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_chat','Y');
              });
            }else{
              $data['astrologers'] = $data['astrologers']->where('is_chat','Y');
            }
          }

          elseif (in_array(1, $request->offer_type)) {

            if (in_array(3, $request->offer_type) && in_array(2, $request->offer_type) && in_array(4, $request->offer_type)) {
              $ids =  $data['astrologers']->pluck('id')->toArray();
              $data['astrologers'] = User::whereIn('id',$ids)->where('is_chat','Y')->orWhere('is_video_call','Y')->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');


            }elseif (in_array(3, $request->offer_type) && in_array(4, $request->offer_type)) {
              $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_chat','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(2, $request->offer_type) && in_array(4, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_video_call','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(3, $request->offer_type) && in_array(2, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_chat','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_video_call','Y');
              });
            }else{
              $data['astrologers'] = $data['astrologers']->where('is_audio_call','Y');
            }
          }
		  elseif (in_array(4, $request->offer_type)) {

            if (in_array(3, $request->offer_type) && in_array(2, $request->offer_type) && in_array(1, $request->offer_type)) {
              $ids =  $data['astrologers']->pluck('id')->toArray();
              $data['astrologers'] = User::whereIn('id',$ids)->where('is_chat','Y')->orWhere('is_video_call','Y')->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');


            }elseif (in_array(3, $request->offer_type) && in_array(2, $request->offer_type)) {
              $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_chat','Y')
                      ->orWhere('is_video_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(2, $request->offer_type) && in_array(1, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_video_call','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }elseif (in_array(3, $request->offer_type) && in_array(1, $request->offer_type)) {
             $data['astrologers'] = $data['astrologers']->where(function($query){
                $query->where('is_chat','Y')
                      ->orWhere('is_audio_call','Y')->orWhere('is_astrologer_offer_offline','Y');
              });
            }else{
              $data['astrologers'] = $data['astrologers']->where('is_astrologer_offer_offline','Y');
            }
          }


        }



                // offer_type
        if (@$request->avail_now ) {
          if (in_array(3, $request->avail_now)) {

            if (in_array(2, $request->avail_now) && in_array(1, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                 $query->where('avail_now_chat','Y')->orWhere('avail_now_video_call','Y')->orWhere('avail_now_audio_call','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');
          }elseif (in_array(2, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                $query->where('avail_now_video_call','Y')->orWhere('avail_now_chat','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');
            }elseif (in_array(1, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                $query->where('avail_now_audio_call','Y')->orWhere('avail_now_chat','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');
            }else{
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where('avail_now_chat','Y')->whereDoesntHave('astrologerExclusionDateDetails');
            }
          }

          elseif (in_array(2, $request->avail_now)) {

            if (in_array(1, $request->avail_now) && in_array(3, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                 $query->where('avail_now_chat','Y')->orWhere('avail_now_video_call','Y')->orWhere('avail_now_audio_call','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');

            }elseif (in_array(3, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                $query->where('avail_now_chat','Y')->orWhere('avail_now_video_call','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');
            }elseif (in_array(1, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                $query->where('avail_now_audio_call','Y')->orWhere('avail_now_video_call','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');
            }else{
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where('avail_now_video_call','Y')->whereDoesntHave('astrologerExclusionDateDetails');
            }
          }

          elseif (in_array(1, $request->avail_now)) {

            if (in_array(3, $request->avail_now) && in_array(2, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                 $query->where('avail_now_chat','Y')->orWhere('avail_now_video_call','Y')->orWhere('avail_now_audio_call','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');

            }elseif (in_array(3, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                $query->where('avail_now_chat','Y')->orWhere('avail_now_audio_call','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');
            }elseif (in_array(2, $request->avail_now)) {
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where(function($query){
                $query->where('avail_now_video_call','Y')->orWhere('avail_now_audio_call','Y');
              })->whereDoesntHave('astrologerExclusionDateDetails');
            }else{
              $data['astrologers'] = $data['astrologers']->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->where('avail_now_audio_call','Y')->whereDoesntHave('astrologerExclusionDateDetails');
            }
          }


        }

        // experience-search

        if(@$request->experience ){
        $exp = [];
       if(in_array(3, $request->experience))
        {

          if(in_array(2, $request->experience)){
                $data['astrologers']= $data['astrologers']->where('approve_by_admin','Y')->where(function($query){
                  $query->where('experience','<','20')->orWhere('experience','>','20');
                });
            } elseif(in_array(1, $request->experience)){
                $data['astrologers'] = $data['astrologers']->where('approve_by_admin','Y')->where(function($query){
                  $query->where('experience','<','10')->orWhere('experience','>','20');
                });
            } else {
                $data['astrologers'] = $data['astrologers']->where('experience','>','20');
            }

        } else {
            if(in_array(1, $request->experience)){
                $max = 10;
            }
            if(in_array(2, $request->experience)){
                $max = 20;
            }
            $data['astrologers'] = $data['astrologers']->where('experience','<', $max);
        }


    }


    // call-charge

    @$get = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
    $convert = 1/@$get->conversion_factor;
    if(@session()->get('currency')==1){
      if (@$request->call ){
        if(in_array(1, $request->call)){
          $data['astrologers'] = $data['astrologers']->where('call_price','!=','')->where('is_audio_call','Y');
        }elseif (in_array(101, $request->call)) {
          $hightest= array_diff($request->call,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('call_price',[$amount1,@$hightest_factor])->where('is_audio_call','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('call_price','>',$amount1)->where('is_audio_call','Y');
          }
        }else{
          $hightest_number = max($request->call);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('call_price','<=',$hightest_factor)->where('is_audio_call','Y');

        }
      }
    }else{
      if (@$request->call ){
        if(in_array(1, $request->call)){
          $data['astrologers'] = $data['astrologers']->where('call_price_usd','!=','')->where('is_audio_call','Y');
        }elseif (in_array(101, $request->call)) {
          $hightest= array_diff($request->call,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('call_price_usd',[$amount1,@$hightest_factor])->where('is_audio_call','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('call_price_usd','>',$amount1)->where('is_audio_call','Y');
          }
        }else{
          $hightest_number = max($request->call);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('call_price_usd','<=',$hightest_factor)->where('is_audio_call','Y');

        }
      }

    }



    // video-call

    if(@session()->get('currency')==1){
      if (@$request->video_call ){
        if(in_array(1, $request->video_call)){
          $data['astrologers'] = $data['astrologers']->where('video_call_price_inr','!=','')->where('is_video_call','Y');
        }elseif (in_array(101, $request->video_call)) {
          $hightest= array_diff($request->video_call,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('video_call_price_inr',[$amount1,@$hightest_factor])->where('is_video_call','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('video_call_price_inr','>',$amount1)->where('is_video_call','Y');
          }
        }else{
          $hightest_number = max($request->video_call);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('video_call_price_inr','<=',$hightest_factor)->where('is_video_call','Y');

        }
      }
    }else{
      if (@$request->video_call ){
        if(in_array(1, $request->video_call)){
          $data['astrologers'] = $data['astrologers']->where('video_call_price_usd','!=','')->where('is_video_call','Y');
        }elseif (in_array(101, $request->video_call)) {
          $hightest= array_diff($request->video_call,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('video_call_price_usd',[$amount1,@$hightest_factor])->where('is_video_call','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('video_call_price_usd','>',$amount1)->where('is_video_call','Y');
          }
        }else{
          $hightest_number = max($request->video_call);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('video_call_price_usd','<=',$hightest_factor)->where('is_video_call','Y');

        }
      }

    }




    // chat
    if(@session()->get('currency')==1){
      if (@$request->chat_price ){
        if(in_array(1, $request->chat_price)){
          $data['astrologers'] = $data['astrologers']->where('chat_price_inr','!=','')->where('is_chat','Y');
        }elseif (in_array(101, $request->chat_price)) {
          $hightest= array_diff($request->chat_price,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('chat_price_inr',[$amount1,@$hightest_factor])->where('is_chat','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('chat_price_inr','>',$amount1)->where('is_chat','Y');
          }
        }else{
          $hightest_number = max($request->chat_price);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('chat_price_inr','<=',$hightest_factor)->where('is_chat','Y');

        }
      }
    }else{
      if (@$request->chat_price ){
        if(in_array(1, $request->chat_price)){
          $data['astrologers'] = $data['astrologers']->where('chat_price_usd','!=','')->where('is_chat','Y');
        }elseif (in_array(101, $request->chat_price)) {
          $hightest= array_diff($request->chat_price,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('chat_price_usd',[$amount1,@$hightest_factor])->where('is_chat','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('chat_price_usd','>',$amount1)->where('is_chat','Y');
          }
        }else{
          $hightest_number = max($request->chat_price);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('chat_price_usd','<=',$hightest_factor)->where('is_chat','Y');

        }
      }

    }

	//Offline price
	if(@session()->get('currency')==1){
      if (@$request->offline_price ){
        if(in_array(1, $request->offline_price)){
          $data['astrologers'] = $data['astrologers']->where('astrologer_offline_price_inr','!=','')->where('is_astrologer_offer_offline','Y');
        }elseif (in_array(101, $request->offline_price)) {
          $hightest= array_diff($request->offline_price,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('astrologer_offline_price_inr',[$amount1,@$hightest_factor])->where('is_astrologer_offer_offline','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('astrologer_offline_price_inr','>',$amount1)->where('is_astrologer_offer_offline','Y');
          }
        }else{
          $hightest_number = max($request->offline_price);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('astrologer_offline_price_inr','<=',$hightest_factor)->where('is_astrologer_offer_offline','Y');

        }
      }
    }else{
      if (@$request->offline_price){
        if(in_array(1, $request->offline_price)){
          $data['astrologers'] = $data['astrologers']->where('astrologer_offline_price_usd','!=','')->where('is_astrologer_offer_offline','Y');
        }elseif (in_array(101, $request->offline_price)) {
          $hightest= array_diff($request->offline_price,array('101'));
          if (count(@$hightest)>0) {
            $hightest_number = max($hightest);
            @$hightest_factor = round($hightest_number*$convert,2);
            $amount1 = round(101*$convert,2);
            $data['astrologers'] = $data['astrologers']->whereNotBetween('astrologer_offline_price_usd',[$amount1,@$hightest_factor])->where('is_astrologer_offer_offline','Y');
          }else{
           $amount1 = round(101*$convert,2);
           $data['astrologers'] = $data['astrologers']->where('astrologer_offline_price_usd','>',$amount1)->where('is_astrologer_offer_offline','Y');
          }
        }else{
          $hightest_number = max($request->offline_price);
          @$hightest_factor = round($hightest_number*$convert,2);
          $data['astrologers'] = $data['astrologers']->where('astrologer_offline_price_usd','<=',$hightest_factor)->where('is_astrologer_offer_offline','Y');

        }
      }

    }





    // rating-search
    if (@$request->rating )
    {
       $rating = [];
       if(in_array(1, $request->rating))
       {
          $data['astrologers'] = $data['astrologers']->where('avg_review','!=','');
       }else{
       if(in_array(2, $request->rating)){
         $data['astrologers'] = $data['astrologers']->where('avg_review','>=',3);
       }
       if(in_array(3, $request->rating))
       {
         if(in_array(2, $request->rating)){
            $data['astrologers'] = $data['astrologers']->where(function($query){
              $query->where('avg_review','>=',3)->orWhere('avg_review','>=',4);
            });
          }else{
            $data['astrologers'] = $data['astrologers']->where('avg_review','>=',4);
        }
      }

    }

   }





      /*if (Auth::check()) {
        $ids= $data['astrologers']->where('status', 'A')->where('approve_by_admin','Y')->pluck('users.id')->toArray();
        $data['astrologers'] = User::whereIn('id',$ids)->where('id','!=',auth()->user()->id)->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y');

      }else{
        $data['astrologers']= $data['astrologers']->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y');
      }  */

      // sorting
    if(@$request->sort)
    {
       if(@$request->sort==1)
	   {
		   $data['astrologers'] = $data['astrologers']->orderBy('avg_review','desc');
	   }
		if(@$request->sort==2)
	   {
		   $data['astrologers'] = $data['astrologers']->orderBy('avg_review','asc');
	   }
	   if(@$request->sort==3)
	   {
		   $data['astrologers'] = $data['astrologers']->orderBy('experience','desc');
	   }
	   if(@$request->sort==4)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price_usd','asc');
		   }
	   }
	  if(@$request->sort==5)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price_usd','desc');
		   }

	   }
	   if(@$request->sort==6)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_inr','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_usd','asc');
		   }

	   }
	   if(@$request->sort==7)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_inr','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_usd','desc');
		   }
	   }
	   if(@$request->sort==8)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_inr','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_usd','asc');
		   }
	   }
	   if(@$request->sort==9)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_inr','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_usd','desc');
		   }
	   }
	   if(@$request->sort==10)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_inr','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_usd','asc');
		   }
	   }
	   if(@$request->sort==11)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_inr','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_usd','desc');
		   }
	   }
	   if(@$request->sort==12)
	   {
			$data['astrologers'] = $data['astrologers']->orderBy(DB::raw('CONCAT(first_name," ",last_name)'),'asc');
	   }

    }
	else
	{
		$data['astrologers'] = $data['astrologers']->orderBy('astrologer_type','asc');
	}
	  $result_data_users= $data['astrologers']->groupBy('users.id')->pluck('users.id')->toArray();
	  $data['totalAstrologer'] = count($result_data_users);

	  //dd($result_data_users);
        if (@$request->show_result){

             $data['astrologers']= $data['astrologers']->groupBy('users.id')->paginate(@$request->show_result);
        }else{
            $data['astrologers'] = $data['astrologers']->groupBy('users.id')->paginate(12);
          }
       
        //dd($data['astrologers']);
      $data['key'] = $request->all();
		$data['expertise'] = Expertise::with('userDetails')->whereHas('userDetails',function($query) use($result_data_users){
			$query->whereIn('user_id', $result_data_users);
		})->orderBy('expertise_name','asc')->get();

   $data['languages'] = LanguageSpeak::with('userDetails')->whereHas('userDetails',function($query) use($result_data_users){
			$query->whereIn('user_id', $result_data_users);
		})->orderBy('language_name','asc')->get();
	$data['countries'] = Country::with('userDetails')->whereHas('userDetails',function($query) use($result_data_users){
			$query->whereIn('id', $result_data_users);
		})->orderBy('name','asc')->get();
		if(@$request->country_id)
		{
			$data['states'] = State::with('userDetails')->whereHas('userDetails',function($query) use($result_data_users){
					$query->whereIn('id', $result_data_users);
				})->orderBy('name','asc')->get();
				if(@$request->state_id)
				{
					$data['cities'] = City::with('userDetails')->whereHas('userDetails',function($query) use($result_data_users){
						$query->whereIn('id', $result_data_users);
					})->orderBy('name','asc')->get();
				}

		}



   $audio = User::whereIn('id',$result_data_users)->where('is_audio_call','Y')->first();
   if (@$audio!="") {
     $data['is_audio'] = 'Y';
   }

   $video = User::whereIn('id',$result_data_users)->where('is_video_call','Y')->first();
   if (@$video!="") {
     $data['is_video_call'] = 'Y';
   }

   $chat = User::whereIn('id',$result_data_users)->where('is_chat','Y')->first();
   if (@$chat!="") {
     $data['is_chat'] = 'Y';
   }
   $offline = User::whereIn('id',$result_data_users)->where('is_astrologer_offer_offline','Y')->first();
   if (@$offline!="") {
     $data['is_offline'] = 'Y';
   }

   $avail_now_audio = User::whereIn('id',$result_data_users)->where('is_audio_call','Y')->where('avail_now_audio_call','Y')->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->count();
   if (@$avail_now_audio) {
      $data['avail_now_audio'] = 'Y';

   }

   $avail_now_video = User::whereIn('id',$result_data_users)->where('is_video_call','Y')->where('avail_now_video_call','Y')->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->count();
   if (@$avail_now_video) {
      $data['avail_now_video'] = 'Y';

   }

   $avail_now_chat = User::whereIn('id',$result_data_users)->where('is_chat','Y')->where('avail_now_chat','Y')->where('instant_booking_expiry','>=',date('Y-m-d H:i:s'))->count();
   if (@$avail_now_chat) {
      $data['avail_now_chat'] = 'Y';

   }

   $data['content'] = SearchPageData::where('type','A')->first();
   $data['astro_tips'] = AstroTip::where('astrologer_id',0)->get();
   $data['all_faq_cat']=FaqCategory::with('parent','astrologerFaqDetails')->where('parent_id','!=',0)->has('astrologerFaqDetails')->get();

    	return view('modules.astrologer_search.astrologer_search',$data);
    }

    /**
     *   Method      : astrologerPublicProfile
     *   Description : Astrologer profile search
     *   Author      : Madhuchandra
     *   Date        : 2021-MAY-8
     **/

    public function astrologerPublicProfile($slug)
    {
        $data = [];
        $day= ['MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'];
        $day=implode(',', $day);
        $data['userData']=User::where('slug',$slug)->with(['userAvailable' , 'astrologerExperience', 'astrologerEducation', 'astrologerLanguage', 'astrologerExpertise.experties', 'countries','states'])
        ->where('status', 'A')->where('approve_by_admin', 'Y')
        ->first();
        // return $data;
        if($data['userData']==null){
            return redirect()->route('astrologer.search.view');
        }
        $data['monday'] = UserToAvailable::where('user_id',$data['userData']->id)->where('day','MONDAY')->get();
        $data['tuesday'] = UserToAvailable::where('user_id',$data['userData']->id)->where('day','TUESDAY')->get();
        $data['wednesday'] = UserToAvailable::where('user_id',$data['userData']->id)->where('day','WEDNESDAY')->get();
        $data['thursday'] = UserToAvailable::where('user_id',$data['userData']->id)->where('day','THURSDAY')->get();
        $data['friday'] = UserToAvailable::where('user_id',$data['userData']->id)->where('day','FRIDAY')->get();
        $data['saturday'] = UserToAvailable::where('user_id',$data['userData']->id)->where('day','SATURDAY')->get();
        $data['sunday'] = UserToAvailable::where('user_id',$data['userData']->id)->where('day','SUNDAY')->get();
         // get the day-id array
         $b=array();
         $getdayid  = UserToAvailable::where('user_id',$data['userData']->id)->get();
         if ($getdayid!="") {

         foreach ($getdayid as $key => $value) {
            if(in_array($value->day_id,$b))
            {
              continue;
            }
            else{
             array_push($b,$value->day_id);
            }
            }
        $data['days'] = $b;
        }
		$check = CallHistory::with('orderDetails')->where('astrologer_id',$data['userData']->id)->where(DB::raw('DATE(call_date_time)'),date('Y-m-d'))->whereHas('orderDetails',function($query) {
			 $query->where('from_time','<=',date('H:i:s'))->where('end_time','>',date('H:i:s'))->where(function($query2){
				 $query2->where('status','N')->orWhere('status','IP');
			 });
		 })->count();
		 $data['call_details']=$check;
		 $data['astrologerReview']= Review::with('customer_review')->where('to_user_id',$data['userData']->id)->orderBy('id','desc')->get();
		 $data['all_faq_cat']=FaqCategory::with('parent')->Join('faq','faq.subcategory_id','=','faq_category.id')->leftJoin('faq_astro','faq.id','=','faq_astro.faq_id')->select('faq_category.*')->whereRaw(DB::raw("(faq_astro.astro_id = ".$data['userData']->id." OR faq.astrologer_id = ".$data['userData']->id.")"))->where('faq.type','A')->where('parent_id','!=',0)->groupBy('faq_category.id')->get();
		if(@$data['all_faq_cat']->isNotEmpty())
		{
			foreach(@$data['all_faq_cat'] as $key=>$fcat)
			{
				$data['all_faq_cat'][$key]['all_faq']=Faq::leftJoin('faq_astro','faq.id','=','faq_astro.faq_id')->select('faq.*')->where('subcategory_id',$fcat->id)->whereRaw(DB::raw("(faq_astro.astro_id = ".$data['userData']->id." OR faq.astrologer_id = ".$data['userData']->id.")"))->where('faq.type','A')->groupBy('faq.id')->orderBy('faq.display_order','desc')->get();
			}

		}
		$data['astro_tips'] = AstroTip::where('astrologer_id',$data['userData']->id)->get();
		$data['exclusion_dates'] = AstrologerExclusionDateList::where('astrologer_id',$data['userData']->id)->where('date',date('Y-m-d'))->count();
		$data['exclusion_dates_array'] = AstrologerExclusionDateList::where('astrologer_id',$data['userData']->id)->pluck('date')->toArray();
		if(Auth::check())
		{
			if(session()->get('currency')>=2)
			{
				$data['wallet_balance']=UserWallet::where('user_id',auth()->user()->id)->where('currency_id',2)->first();
			}
			else
			{
				$data['wallet_balance']=UserWallet::where('user_id',auth()->user()->id)->where('currency_id',1)->first();
			}
		}
        return view('modules.astrologer_search.astrologer_public_profile')->with($data);
    }
    public function slotFetch(Request $request)
    {
      $day = date('l', strtotime($request->date));
      if ($day=="Monday") {
         $day_id = '1';
      }
      if ($day=="Tuesday") {
         $day_id = '2';
      }
      if ($day=="Wednesday") {
         $day_id = '3';
      }
      if ($day=="Thursday") {
         $day_id = '4';
      }
      if ($day=="Friday") {
         $day_id = '5';
      }
      if ($day=="Saturday") {
         $day_id = '6';
      }
      if ($day=="Sunday") {
         $day_id = '0';
      }
      $getSlot = UserToAvailable::where('day_id',$day_id)->where('user_id',$request->astrologer_id)->get();
      $uniq = array();
      foreach ($getSlot as $key => $value) {
         $check = CallHistory::with('orderDetails')->where('astrologer_id',$request->astrologer_id)->where(DB::raw('DATE(call_date_time)'),date('Y-m-d',strtotime($request->date)))->whereHas('orderDetails',function($query) use($value){
			 $query->where('from_time','<=',$value->from_time)->where('end_time','>=',$value->from_time);
		 })->first();

         if ($check!="") {

         }else{
          array_push($uniq,$value->from_time);
         }
      }
      $data['uniq'] =  $uniq;
      $data['date'] = $request->date;
      $data['user'] = User::where('id',$request->astrologer_id)->first();
      // return $data['uniq'];
      if ($data['date']==date('m/d/Y')) {
         $expired = [];
         foreach ($data['uniq'] as $key => $value) {
           if(date('H:i:s')>=date('H:i:s',strtotime(@$value))){

           }else{
            array_push($expired, $value);
           }
         }
         $data['uniq'] = $expired;
         return view('modules.astrologer_search.astrologer_slot',$data);
      }else{
     return view('modules.astrologer_search.astrologer_slot_two',$data);
     }
   }


   public function slotDuration(Request $request)
   {
      $array = $request->slots;
      $min =  min($array);
      $max =  max($array);
      $addhours = date('H:i:s',strtotime('+1hour',strtotime($min)));
      if ($min<=$max && $max<=$addhours) {
        echo "fine";
      }else{
        echo "excess";
      }
      // return $addhours;
   }
   /**
     *   Method      : schedulePaymentAmount
     *   Description : Amount calculation for schedule booking
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-03
     **/
   public function schedulePaymentAmount(Request $request)
   {
		$astrologerData=User::where('slug', $request->slug)->first();
		$array = $request->slots;
		$min =  min($array);
		$max =  max($array);
		//$addhours = date('H:i:s',strtotime('+1hour',strtotime($min)));
		$addhours = count($array)*15;
		$amount=0;
		$conversionFactor=currencyConversionCustom();
		$duration=0;
		$day = date('w', strtotime($request->booking_date));
		if($min<=$max && $addhours>1){
			if(count($array)>0)
			{
				foreach($array as $time)
				{
					if($time<$max)
					{
						$nextslot=$this->getAvailableTimeslot($time,$astrologerData->id,$day);
						if($nextslot<=max($array) && !in_array($nextslot,$array))
						{
							$response['status']='error';
							$response['message']='Please choose consecutive time slots';
							return response()->json($response);
						}
					}
				}
			}

		  $duration=count($array)*15;
		  /*if(count($array)==1)
		  {
			$duration=15;
		  }
		  else
		  {
			$dateTimeObject1 = date_create(date('Y-m-d').' '.date('H:i:s',strtotime($min)));
			$dateTimeObject2 = date_create(date('Y-m-d').' '.date('H:i:s',strtotime($max)));
			$interval = date_diff($dateTimeObject1, $dateTimeObject2);
			$min = ($interval->h*60)+$interval->i;
			$duration=$min;
		  }*/
		$call_price=0;
		$video_call_price=0;
		$chat_price=0;
		$offline_price=0;
		if(session()->get('currency')==1)
		{
			if(@$astrologerData->call_discount_inr)
			{
				$call_price=(@$astrologerData->call_price-((@$astrologerData->call_price*@$astrologerData->call_discount_inr)/100));
			}
			else
			{
				$call_price=@$astrologerData->call_price;
			}

			if(@$astrologerData->video_call_discount_inr)
			{
				$video_call_price=(@$astrologerData->video_call_price_inr-((@$astrologerData->video_call_price_inr*@$astrologerData->video_call_discount_inr)/100));
			}
			else
			{
				$video_call_price=@$astrologerData->video_call_price_inr;
			}

			if(@$astrologerData->chat_discount_inr)
			{
				$chat_price=(@$astrologerData->chat_price_inr-((@$astrologerData->chat_price_inr*@$astrologerData->chat_discount_inr)/100));
			}
			else
			{
				$chat_price=@$astrologerData->chat_price_inr;
			}
			if(@$astrologerData->offline_discount_price_inr)
			{
				$offline_price=(@$astrologerData->astrologer_offline_price_inr-((@$astrologerData->astrologer_offline_price_inr*@$astrologerData->offline_discount_price_inr)/100));
			}
			else
			{
				$offline_price=@$astrologerData->astrologer_offline_price_inr;
			}
		}
		else
		{
			if(@$astrologerData->call_discount_usd)
			{
				$call_price=((@$astrologerData->call_price_usd-((@$astrologerData->call_price_usd*@$astrologerData->call_discount_usd)/100))*currencyConversionCustom());
			}
			else
			{
				$call_price=@$astrologerData->call_price_usd*currencyConversionCustom();
			}

			if(@$astrologerData->video_call_discount_usd)
			{
				$video_call_price=((@$astrologerData->video_call_price_usd-((@$astrologerData->video_call_price_usd*@$astrologerData->video_call_discount_usd)/100))*currencyConversionCustom());
			}
			else
			{
				$video_call_price=@$astrologerData->video_call_price_usd*currencyConversionCustom();
			}

			if(@$astrologerData->chat_discount_usd)
			{
				$chat_price=((@$astrologerData->chat_price_usd-((@$astrologerData->chat_price_usd*@$astrologerData->chat_discount_usd)/100))*currencyConversionCustom());
			}
			else
			{
				$chat_price=@$astrologerData->chat_price_usd*currencyConversionCustom();
			}
			if(@$astrologerData->offline_discount_price_usd)
			{
				$offline_price=((@$astrologerData->astrologer_offline_price_usd-((@$astrologerData->astrologer_offline_price_usd*@$astrologerData->offline_discount_price_usd)/100))*currencyConversionCustom());
			}
			else
			{
				$offline_price=@$astrologerData->astrologer_offline_price_usd*currencyConversionCustom();
			}
		}
		if(@$request->booking_type=='A')
		{
			$amount=$duration*@$call_price;
		}
		elseif(@$request->booking_type=='V')
		{
			$amount=$duration*@$video_call_price;
		}
		elseif(@$request->booking_type=='C')
		{
			$amount=$duration*@$chat_price;
		}
		elseif(@$request->booking_type=='F')
		{
			$amount=$duration*@$offline_price;
		}
        $response['status']='success';
        $response['amount']=$amount;
      }else{
		$response['message']='Please select one hour range from your start time';
        $response['status']='error';
      }
	  return response()->json($response);
   }
   /**
     *   Method      : getAvailableTimeslot
     *   Description : To check the next slot is available or not
     *   Author      : Madhuchandra
     *   Date        : 2021-DEC-03
     **/
   protected function getAvailableTimeslot($time,$astrologerId,$day)
   {
	   $nextslot=date('H:i:s',strtotime('+15minutes '.$time));
	   $getSlot = UserToAvailable::where('day_id',$day)->where('user_id',$astrologerId)->where('from_time',$nextslot)->count();
		if($getSlot<=0)
		{
			return $this->getAvailableTimeslot($nextslot,$astrologerId,$day);
		}
		else
		{
			return $nextslot;
		}
   }
   /**
	*Method:allCountries
	*Description:Showing count related countries
	*Author:Madhuchandra
	*Date:2021-DEC-24
	*/
	public function allCountries()
    {
        $data = [];
        $data['countries'] = Country::withCount([
		'userDetails'=>function($query1){
			$query1->select(DB::raw('count(distinct(id))'))->where('users.user_type','A')->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y');
		}, 
    'userDetails as state_count' => function ($query) {
        $query->select(DB::raw('count(distinct(state))'))->whereRaw(DB::raw('state IS NOT NULL'))->where('state','>',0)->where('users.user_type','A')->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y');
    }])->paginate(50);
	//dd($data['countries'] );
        return view('modules.separate_search.all_countries')->with($data);
    }
	/**
	*Method:allStates
	*Description:Showing count related states
	*Author:Madhuchandra
	*Date:2021-DEC-24
	*/
	public function allStates($id)
    {
        $data = [];
		$data['country']=$country=Country::where('id',$id)->first();
        $data['states'] = State::withCount([
    'userDetails'=>function($query1){
			$query1->select(DB::raw('count(distinct(id))'))->where('state','>',0)->where('users.user_type','A')->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y');
		}])->where('country_id',$id)->paginate(50);
	//dd($data['states']);
        return view('modules.separate_search.all_states')->with($data);
    }
	/**
	*Method:allExpertise
	*Description:Showing count related expertise
	*Author:Madhuchandra
	*Date:2021-DEC-30
	*/
	public function allExpertise($id,$id1=null)
    {
		if(@$id1)
		{
			$country_id=$id1;
			$state_id=$id;
		}
		else
		{
			$country_id=$id;
			$state_id='';
		}
        $data = [];
		$data['country']=Country::where('id',$country_id)->first();
		if(@$state_id)
		{
			$data['state']=State::where('id',$state_id)->first();
			$data['expertise'] = Expertise::join('astrologer_expertise','expertise.id','=','astrologer_expertise.expertise_id')->join('users','users.id','=','astrologer_expertise.user_id')->select('expertise.*')->where('state',@$state_id)->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('users.user_type','A')->groupBy('expertise_id')->paginate(50);
		}
		else
		{
			$data['expertise'] = Expertise::join('astrologer_expertise','expertise.id','=','astrologer_expertise.expertise_id')->join('users','users.id','=','astrologer_expertise.user_id')->select('expertise.*')->where('country_id',@$country_id)->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('users.user_type','A')->groupBy('expertise_id')->paginate(50);
		}
		
	//dd($data['expertise']);
        return view('modules.separate_search.all_expertise')->with($data);
    }
	
	/**
	*Method:astrologerAllSearch
	*Description:Showing astrologers
	*Author:Madhuchandra
	*Date:2021-DEC-24
	*/
	public function astrologerAllSearch(Request $request,$id,$id1=null,$id2=null)
    {
		if(@$id2)
		{
			if(@$id2!='es' && @$id2!='ec' && @$id2!='sc')
			{
				return redirect()->back();
			}
		}
        $data = [];
		if (Auth::check()) {
			if(@$id1 && @$id2)
			{
				if(@$id2=='es')
				{
					$data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('users.id','!=',auth()->user()->id)->where('state',$id1)->where('astrologer_expertise.expertise_id',$id);
				}
				elseif(@$id2=='ec')
				{
					$data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('users.id','!=',auth()->user()->id)->where('country_id',$id1)->where('astrologer_expertise.expertise_id',$id);
				}
				elseif(@$id2!='sc')
				{
					$data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('users.id','!=',auth()->user()->id)->where('country_id',$id1)->where('state',$id);
				}
				else
				{
					$data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('users.id','!=',auth()->user()->id)->where('country_id',$id);
				}
				
			}
        
		  }else{
			  if(@$id1 && @$id2)
			  {
				  if(@$id2=='es')
				  {
					  $data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('state',$id1)->where('astrologer_expertise.expertise_id',$id);
				  }
				  elseif(@$id2=='ec')
				  {
					  $data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('country_id',$id1)->where('astrologer_expertise.expertise_id',$id);
				  }
				  elseif(@$id2=='sc')
				  {
					  $data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('country_id',$id1)->where('state',$id);
				  }
				  else
				  {
					  $data['astrologers'] = User::with('astrologerExclusionDateDetails')->select('users.*')->leftJoin('astrologer_expertise','users.id','=','astrologer_expertise.user_id')->leftJoin('expertise','astrologer_expertise.expertise_id','=','expertise.id')->leftJoin('astrologer_to_languages','users.id','=','astrologer_to_languages.user_id')->leftJoin('language_speakes','astrologer_to_languages.language_id','=','language_speakes.id')->where('user_type','A')->where('status', 'A')->where('approve_by_admin','Y')->where('user_availability','Y')->where('country_id',$id);
				  }
				  
			  }
			
		  }
		$data['totalAstrologer']= $data['astrologers']->groupBy('users.id')->pluck('users.id')->toArray();
		$data['totalAstrologer']=count($data['totalAstrologer']);
		//dd($data['totalAstrologer']);
        if(@$request->all()){
            if(@$request->sort)
    {
       if(@$request->sort==1)
	   {
		   $data['astrologers'] = $data['astrologers']->orderBy('avg_review','desc');
	   }
		if(@$request->sort==2)
	   {
		   $data['astrologers'] = $data['astrologers']->orderBy('avg_review','asc');
	   }
	   if(@$request->sort==3)
	   {
		   $data['astrologers'] = $data['astrologers']->orderBy('experience','desc');
	   }
	   if(@$request->sort==4)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price_usd','asc');
		   }
	   }
	  if(@$request->sort==5)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('call_price_usd','desc');
		   }

	   }
	   if(@$request->sort==6)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_inr','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_usd','asc');
		   }

	   }
	   if(@$request->sort==7)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_inr','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('video_call_price_usd','desc');
		   }
	   }
	   if(@$request->sort==8)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_inr','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_usd','asc');
		   }
	   }
	   if(@$request->sort==9)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_inr','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('chat_price_usd','desc');
		   }
	   }
	   if(@$request->sort==10)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_inr','asc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_usd','asc');
		   }
	   }
	   if(@$request->sort==11)
	   {
		   if(session()->get('currency')==1)
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_inr','desc');
		   }
		   else
		   {
			   $data['astrologers'] = $data['astrologers']->orderBy('astrologer_offline_price_usd','desc');
		   }
	   }
	   if(@$request->sort==12)
	   {
			$data['astrologers'] = $data['astrologers']->orderBy(DB::raw('CONCAT(first_name," ",last_name)'),'asc');
	   }

    }
	else
	{
		$data['astrologers'] = $data['astrologers']->orderBy('astrologer_type','asc');
	}           

        }
		$result_data_users= $data['astrologers']->groupBy('users.id')->pluck('users.id');
        if (@$request->show_result){
            $data['astrologers']= $data['astrologers']->groupBy('users.id')->paginate(@$request->show_result);
        }else{
            $data['astrologers']= $data['astrologers']->groupBy('users.id')->paginate(12);
        }
        
        $data['key'] = $request->all();
        $data['content'] = SearchPageData::where('type','A')->first();
	   $data['astro_tips'] = AstroTip::where('astrologer_id',0)->get();
	   $data['all_faq_cat']=FaqCategory::with('parent','astrologerFaqDetails')->where('parent_id','!=',0)->has('astrologerFaqDetails')->get();
	   $audio = User::whereIn('id',$result_data_users)->where('is_audio_call','Y')->first();
   if (@$audio!="") {
     $data['is_audio'] = 'Y';
   }

   $video = User::whereIn('id',$result_data_users)->where('is_video_call','Y')->first();
   if (@$video!="") {
     $data['is_video_call'] = 'Y';
   }

   $chat = User::whereIn('id',$result_data_users)->where('is_chat','Y')->first();
   if (@$chat!="") {
     $data['is_chat'] = 'Y';
   }
   $offline = User::whereIn('id',$result_data_users)->where('is_astrologer_offer_offline','Y')->first();
   if (@$offline!="") {
     $data['is_offline'] = 'Y';
   }
        return view('modules.separate_search.astrologer_separate_search')->with($data);
    }
}
