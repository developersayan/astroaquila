@extends('layouts.app')

@section('title')
<meta name="title" content="{{@$puja->meta_title}}">
<meta name="description" content="{{strip_tags(@$puja->meta_description)}}">
<meta property="og:title" content="Puja | {{@$puja->puja_name }}">
<meta property="og:description" content="{{ substr(strip_tags(@$puja->puja_description),0,150) }}">
@if(@$puja->puja_image)
<meta property="og:image" content="{{ URL::to('storage/app/public/puja_image')}}/{{$puja->puja_image}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
<meta property="og:url" content="{{route('search.puja.details', ['slug'=>$puja->slug])}}">
<title>Puja | {{@$puja->puja_name }}</title>
@endsection

@section('style')
@include('includes.style')
<style>
    /* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
    .error {
        color: red;
        text-align: left !important;
    }
    .pac-container {
        z-index: 1060 !important;
    }
    .form_box_area {
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .form_box_area input[type] {
        height: 38px;
    }
    .form_box_area select {
        height: 38px;
    }
    .form_box_area label {
        font: 400 14px/20px 'Roboto', sans-serif;
        margin-bottom: 4px;
    }
    .owl-nav{
        display: block !important;
    }
    .owl-prev {
        position: absolute;
        top: 154px;
        width: 13px;
        height: 29px;
        background-size: 100%;
        font-size: 0 !important;
        left: -15px;
        background: url(../public/frontend/images/stonleft.png)no-repeat;
    }
    .owl-next {
        position: absolute;
        top: 154px;
        width: 13px;
        height: 29px;
        background-size: 100%;
        font-size: 0 !important;
        right: -15px;
        background: url(../public/frontend/images/stonright.png)no-repeat;
    }
    .error{
        color: red !important;
    }

</style>
@endsection

@section('header')
@include('includes.header')
@endsection


@section('body')
<?php
 $custom = (new \App\Helpers\CustomHelper)->currencyConversion();
?>

<section class="pad-114">
        <div class="details-banners">
               <div class="banner-inners">
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-9 col-md-12">
                           <div class="mb-breadcrumbs">
                              <ul>
                                 <li><a href="{{route('puja.search.category')}}"> {{@$puja->category->name}} </a> <span>               </span></li>
								 @if(@$puja->puja_sub_category!="")
								 <li><a href="{{route('puja.search.sub.category',['slug'=>@$puja->category->slug])}}">&nbsp; /  &nbsp; {{@$puja->subcategory->name}} </a><span>             </span></li>
								@endif
                                 @if(@$puja->puja_id!="")
                                 <li><a href="@if(@$puja->puja_sub_category!="") {{route('puja.search.puja-name',['slug'=>@$puja->subcategory->slug])}} @else {{route('puja.search.puja-name',['slug'=>@$puja->category->slug])}} @endif">&nbsp; /  &nbsp; {{@$puja->pujaName->name}} </a><span>             </span></li>
                                 @endif
                                 <li><span>&nbsp; /  &nbsp; {{@$puja->puja_code}}</span></li>
                                 <div class="clearfix"></div>
                              </ul>
                           </div>
                           <div class="details-captions page_banner_data">
                              <h1>{{@$puja->puja_name}}</h1>
                              <p style="white-space:pre-wrap;">{!!@$puja->puja_description!!}</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <ul class="nav nav-tabs" role="tablist">
                              @if(@$puja->importance_significance!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$puja->importance_significance!="") show active @endif" data-toggle="tab" href="#home" id="significance_tab">Significance and Benefits</a>
                              </li>
                              @endif
                              @if(@$puja->who_when_how!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$puja->importance_significance=="" && @$puja->who_when_how!="") show active @endif" data-toggle="tab" href="#menu1">Who, How & When </a>
                              </li>
                              @endif

                              @if(@$puja->puja_mantra!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$puja->importance_significance=="" && @$puja->who_when_how=="" && @$puja->puja_mantra!="") show active @endif" data-toggle="tab" href="#menu2">Related Mantra</a>
                              </li>
                              @endif
                              @if(@$puja->facts_mythology!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$puja->importance_significance=="" && @$puja->who_when_how=="" && @$puja->puja_mantra=="" && @$puja->facts_mythology!="") show active @endif" data-toggle="tab" href="#menu3">Facts & Mythology </a>
                              </li>
                              @endif
                              
                              @if(@$all_faq_cat->isNotEmpty())
                              <li class="nav-item">
                                 <a class="nav-link @if(@$puja->importance_significance=="" && @$puja->who_when_how=="" && @$puja->puja_mantra=="" && @$puja->facts_mythology=="") show active @endif" data-toggle="tab" href="#menu5" id="faq_tab">FAQ</a>
                              </li>
                              @endif
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="container">
                  <div class="row">
                    <div class="col-12">
                     <div class="tab-content">
                        <div id="home" class="container tab-pane @if(@$puja->importance_significance!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Significance and Benefits</h2>
                              <p style="white-space:pre-wrap;">{!!@$puja->importance_significance!!}</p>                              
                        </div>
                        
                        </div>

                        <div id="menu1" class="container tab-pane fade @if(@$puja->importance_significance=="" && @$puja->who_when_how!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Who, How & When  </h2>
                              <p style="white-space:pre-wrap;">{!!@$puja->who_when_how!!}</p>
                              </div>
                           </div>

                        <div id="menu2" class="container tab-pane fade @if(@$puja->importance_significance=="" && @$puja->who_when_how=="" && @$puja->puja_mantra!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Related Mantra</h2>
                              <p style="white-space:pre-wrap;">{!!@$puja->puja_mantra!!}</p>
                           </div>
                        </div>
                        <div id="menu3" class="container tab-pane fade @if(@$puja->importance_significance=="" && @$puja->who_when_how=="" && @$puja->puja_mantra=="" && @$puja->facts_mythology!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Facts & Mythology</h2>
                              <p style="white-space:pre-wrap;">{!!@$puja->facts_mythology!!}</p>
                           </div>
                        </div>
                        @if(@$all_faq_cat->isNotEmpty())
                        <div id="menu5" class="container tab-pane fade @if(@$puja->importance_significance=="" && @$puja->who_when_how=="" && @$puja->puja_mantra=="" && @$puja->facts_mythology=="") show active @endif">
                           @foreach(@$all_faq_cat as $key=>$faq)
							<span class="faq-cat-details">{{@$faq->parent->faq_category}} > {{@$faq->faq_category}}</span>
							   <div class="accordian-faq">
								  <div class="accordion" id="faq">
								  @if(@$faq->all_faq->isNotEmpty())
									 @php $count= 1@endphp
									 @foreach(@$faq->all_faq as $faq1)
									 <div class="card">
										<div class="card-header" id="faqhead{{@$faq1->id}}">
										   <a href="#" class="btn btn-header-link acco-chap collapsed" data-toggle="collapse" data-target="#faq{{@$faq1->id}}" aria-expanded="true" aria-controls="faq{{@$faq1->id}}">
											  <p class="word_wrapper"><span>Q{{@$count++}}. </span>{{@$faq1->question}}</p>
										   </a>
										</div>
										<div id="faq{{@$faq1->id}}" class="collapse" aria-labelledby="faqhead{{@$faq1->id}}" data-parent="#faq">
										   <div class="card-body horoscope_faq_answer">
											  <p style="white-space:pre-wrap;">{!!@$faq1->answer!!}</p>
										   </div>
										</div>
									 </div>
									 @endforeach
									 @endif
								  </div>
							   </div>
							   @endforeach
                        </div>
                        @endif
                     </div>
                     </div>
                  </div>
               </div>
            </div>
</section>

<div class="details_sec puja_det_pg new-all-details">
    <div class="container">
        <div class="details_iner">
            <div class="details_left">
                <div class="astro_details noflex back_white">
                    <div class="astroflex">
                    <div class="ast_det_left">
                        <div class="media">
                            {{-- <em><img src="{{ URL::to('public/frontend/images/astro-det1.jpg')}}" alt=""></em> --}}
                            <em><img src="{{ URL::to('storage/app/public/puja_image')}}/{{$puja->puja_image}}" alt=""></em>
                            <div class="media-body">
                                <h4>{{@$puja->puja_name}}<b><i class="fa fa-star"></i>{{@$puja->avg_review}}</b></h4>
                                {{-- <h4>Puja ID - {{@$puja->puja_code}}</h4> --}}
                                @if(@session()->get('currency')==1)
                                @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                @php
                                $old_price = $puja->price_inr;
                                $discount_value = ($old_price / 100) * @$puja->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <p >Price - <del>{{@session()->get('currencySym')}}  {{@$puja->price_inr}} </del> &nbsp;  <span class="price">{{@session()->get('currencySym')}} {{round(@$new_price,2)}} </span> ({{@$puja->discount_inr}}% OFF)</p>
                                @else
                                <p>Price - {{@session()->get('currencySym')}}  {{@$puja->price_inr}}</p>
                                @endif
                                @else
                                @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                @php
                                $old_price = @$custom * $puja->price_usd;
                                $discount_value = ($old_price / 100) * @$puja->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <p >Price - <del>{{@session()->get('currencySym')}}  {{round(@$custom * @$puja->price_usd,2)}} </del> &nbsp;  <span class="price">{{@session()->get('currencySym')}}  {{round(@$new_price,2)}} </span> ({{@$puja->discount_usd}}% OFF)</p>
                                @else
                                <p>Price - {{@session()->get('currencySym')}}  {{round(@$custom * @$puja->price_usd,2)}}</b>
                                @endif
                                
                                @endif

                                <p class="pric_ypu" id="pric_ypu" style="display: none;"><b class="youpay">You Pay: @if(@session()->get('currency')==1){{@session()->get('currencySym')}} @else {{@session()->get('currencySym')}} @endif <span id="price_price">2500</b></p>
                     
                     {{-- puja-actual-price --}}
                     @if(@session()->get('currency')==1)
                    @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                @php
                                $old_price = $puja->price_inr;
                                $discount_value = ($old_price / 100) * @$puja->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{@$puja->price_inr}}">
                               
                     @endif
                     @else
                     @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                 @php
                                $old_price = @$custom * $puja->price_usd;
                                $discount_value = ($old_price / 100) * @$puja->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{round(@$custom * @$puja->price_usd,2)}}">
                               
                     @endif
                    
                     @endif      




                               {{--  @if(@session()->get('currency')==1)
                                @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                @php
                                $discount_value = 100- @$puja->discount_inr;
                                @endphp
                                <p>Price - <del>₹ {{round(@$puja->price_inr*100/$discount_value)}} </del> &nbsp;   <span class="price">₹ {{round(@$puja->price_inr)}}</span> ({{@$puja->discount_inr}}% OFF)</p>
                                @else
                                <p>Price - ₹ {{round(@$puja->price_inr)}}</p>
                                @endif
                                @elseif(@session()->get('currency')==2)
                                @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                @php
                                $discount_value = 100- @$puja->discount_usd;
                                @endphp
                                <p >Price - <del>$ {{round(@$puja->price_usd * 100/$discount_value)}} </del> &nbsp;  <span class="price">$ {{round(@$puja->price_usd)}} </span> ({{@$puja->discount_usd}}% OFF)</p>
                                @else
                                <p>Price - $ {{round(@$puja->price_usd)}}</b>
                                @endif
                                @endif --}}


                                {{-- @if(@session()->get('currency')==1)
                                <p>Price  ₹ - {{@$puja->price_inr}}</p>
                                @elseif(@session()->get('currency')==2)
                                <p>Price  $ - {{@$puja->price_usd}}</p>
                                @endif --}}
                                <p>Puja Manner -
                                    @if(@$userData->manner_of_puja=='BOTH')
                                    {{__('search.both')}}
                                    @elseif(@$userData->manner_of_puja=='ONLINE')
                                    {{__('search.online')}}
                                    @elseif(@$userData->manner_of_puja=='OFFLINE')
                                    {{__('profile.offline')}}
                                    @endif
                                </p>
                                {{-- <p>Puja Category - {{@$puja->category->name}}</p> --}}
                                <p>Puja with {{-- homam --}} Hawan/Yagya - {{@$puja->with_homam=='Y'?'Yes':'No'}}  , No. of Recitals - {{@$puja->no_of_recitals}} , No. of Pundits - {{@$puja->no_of_pundits}}</p>
                                @if(@$puja->puja_video)
                                <p><a href="javascript:;" id="introduction_video"><i class="fa fa-film"></i> Puja Video </a></p>
                                @endif

                                 @if(@$puja->refundable=="Y")
                                <p>Refundable - Yes</p>
                                @else
                                <p>Refundable - No</p>
                                @endif

                                @if(@$puja->refundable=="Y")
                                <p>Refundable Status : @if(@$puja->refundable_status=="E")Exchange Only @elseif(@$puja->refundable_status=="'FR") Fully Refundable @elseif(@$puja->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif</p>
                                @endif

                                 @if(@$puja->prasad=="Y" && @$puja->is_prasad_delivery=="Y")
                                 @if(@session()->get('currency')==1)
                                 @if(@$puja->delivery_days_india!='')
                                 <p>Tentative Prasad Delivery Date: 
                                    {{@$puja->delivery_days_india}} days
                                 </p>
                                 @endif
                                 @else
                                 @if(@$puja->delivery_days_outside_india!='')
                                 <p>Tentative Prasad Delivery Date: 
                                    {{@$puja->delivery_days_outside_india}} days
                                 </p>
                                 @endif
                                @endif
                                 @endif

                                   @if(@$puja->prasad=="Y" && @$puja->is_prasad_delivery=="N")
                                   <p>Delivery Of Prasad Available : No</p>
                                   @endif


                                {{-- <p>{{@$userData->city? $userData->city.',':''}}  {{@$userData->states->name? @$userData->states->name.',':''}}  {{@$userData->countries->name?@$userData->countries->name:''}}</p> --}}
                                
                                @if(@$puja->with_homam=="Y")
                                <div class="form_box_area homam_cc">
                                    <div class="checkBox">
                                        <span>Do You Want to add Homam (@if(@session()->get('currency')==1){{@session()->get('currencyCode')}} {{@$puja->homam_price_inr}} @else {{@session()->get('currencySym')}} {{round(@$custom * @$puja->homam_price_usd,2)}} @endif )</span>
                                        <ul>
                                            <li>
                                                <input type="radio" id="radio3" name="homam_radio" class="gender_select" value="Y" >
                                                <label for="radio3">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio4" name="homam_radio" class="gender_select" value="N" checked="">
                                                <label for="radio4">No</label>
                                            </li>
                                        </ul>
                                         <div><label id="gender-error" class="error" for="gender"></label></div>
                                    </div>
                                </div>
                                @endif
                                
                                <input type="hidden" name="homam_price" id="homam_price" value="@if(@session()->get('currency')==1){{@$puja->homam_price_inr}} @else {{round(@$custom * @$puja->homam_price_usd,2)}} @endif">


                                @if(@$puja->cd=="Y")
                                <div class="form_box_area homam_cc">
                                    <div class="checkBox">
                                        <span>Do you require CD of recording of Puja ? (@if(@session()->get('currency')==1){{@session()->get('currencyCode')}} {{@$puja->cd_price_inr}} @else {{@session()->get('currencySym')}} {{round(@$custom * @$puja->cd_price_usd,2)}} @endif )</span>
                                        <ul>
                                            <li>
                                                <input type="radio" id="radio10" name="cd_radio" class="cd_radio" value="Y" >
                                                <label for="radio10">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio11" name="cd_radio" class="cd_radio" value="N" checked="">
                                                <label for="radio11">No</label>
                                            </li>
                                        </ul>
                                         <div><label id="cd_radio-error" class="error" for="cd_radio"></label></div>
                                    </div>
                                </div>
                                @endif

                                <input type="hidden" name="cd_price" id="cd_price" value="@if(@session()->get('currency')==1){{@$puja->cd_price_inr}} @else {{round(@$custom * @$puja->cd_price_usd,2)}} @endif">


                                @if(@$puja->live_streaming=="Y")
                                <div class="form_box_area homam_cc">
                                    <div class="checkBox">
                                        <span> Do you require option of Live streaming of Puja ? (@if(@session()->get('currency')==1){{@session()->get('currencyCode')}} {{@$puja->liver_streaming_inr}} @else {{@session()->get('currencySym')}} {{round(@$custom * @$puja->liver_streaming_usd,2)}} @endif )</span>
                                        <ul>
                                            <li>
                                                <input type="radio" id="radio12" name="live_streaming_radio" class="live_streaming_radio" value="Y" >
                                                <label for="radio12">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio13" name="live_streaming_radio" class="live_streaming_radio" value="N" checked="">
                                                <label for="radio13">No</label>
                                            </li>
                                        </ul>
                                         <div><label id="live_streaming_radio-error" class="error" for="live_streaming_radio"></label></div>
                                    </div>
                                </div>
                                @endif


                                <input type="hidden" name="live_streaming_price" id="live_streaming_price" value="@if(@session()->get('currency')==1){{@$puja->liver_streaming_inr}} @else {{round(@$custom * @$puja->liver_streaming_usd,2)}} @endif">

                                @if(@$puja->prasad=="Y")
                                <div class="form_box_area homam_cc">
                                    <div class="checkBox">
                                        <span>Do you require delivery of Prasad of Puja ? (@if(@session()->get('currency')==1){{@session()->get('currencyCode')}} {{@$puja->prasad_inr}} @else {{@session()->get('currencySym')}} {{round(@$custom * @$puja->prasad_usd,2)}} @endif )</span>
                                        <ul>
                                            <li>
                                                <input type="radio" id="radio14" name="prasad_radio" class="prasad_radio" value="Y" >
                                                <label for="radio14">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio15" name="prasad_radio" class="prasad_radio" value="N" checked="">
                                                <label for="radio15">No</label>
                                            </li>
                                        </ul>
                                         <div><label id="prasad_radio-error" class="error" for="prasad_radio"></label></div>
                                    </div>
                                </div>
                                @endif

                                <input type="hidden" name="prasad_price" id="prasad_price" value="@if(@session()->get('currency')==1){{@$puja->prasad_inr}} @else {{round(@$custom * @$puja->prasad_usd,2)}} @endif">
                                <div class="form_box_area">
                                <label>Do you want to offer any extra Dakshina / Offering for Priest</label>
                                <input type="number" name="dakshina" class="form_box_area" id="dakshina" placeholder="Please enter amount" min="0">
                               </div>
                               <input type="hidden" name="dakshina_prev" id="dakshina_prev">
                                
                            



                            </div>
                        </div>
                        <div class="puja-zip">
                            <div class="row no-gutters">
                               <div class="col-xl-5 col-lg-8 col-md-5 col-sm-7" @if(@$userData->manner_of_puja=='BOTH') style="display:block;" @else style="display: none;" @endif>
                                <div class="form_box_area">
                                    <div class="checkBox">
                                        <span>Type Of Puja</span>
                                        <ul>
                                            <li>
                                                <input type="radio" id="radio1" name="type_puja" class="gender_select" value="ONLINE" checked="">
                                                <label for="radio1">Online</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio2" name="type_puja" class="gender_select" value="OFFLINE" >
                                                <label for="radio2">Offline</label>
                                            </li>
                                        </ul>
                                         <div><label id="gender-error" class="error" for="gender"></label></div>
                                    </div>
                                </div>
                             </div>
                             <div class="col-xl-7 col-lg-12 col-md-7 col-sm-12">
                             <div @if(@$userData->manner_of_puja=='OFFLINE') style="display: block;"  @else style="display: none;" @endif id="zip_check_id">
                                <div class="row no-gutters">
                                <div class="col-lg-7 col-md-8 col-sm-6 col-7">
                                    <div class="form_box_area">

                                        <input type="text" placeholder="zip code" name="zipCode" id="zipCode">
                                        {{-- <label>Zip code
                                            <a href="javascript:;" id="ch_zip" style="color: blue"> Check</a>
                                            <a href="javascript:;" id="edit_zip" style="color: red;"> change</a>
                                        </label> --}}
                                        
                                    </div>
                                </div>


                            {{-- @csrf --}}
                                <div class="col-lg-5 col-md-4 col-sm-3 col-5">
                                    <div class="form_box_area">
                                        <label>
                                            <a href="javascript:;" id="ch_zip"  class="check-zip"> Check zipcode</a>
                                            {{-- <a href="javascript:;" id="edit_zip" style="color: red;"> Edit Zipcode</a> --}}
                                        </label>

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <label id="offline_puja_location-error" class="error" for="offline_puja_location" style="display: none; margin-top: 2px;"></label>
                                        <label id="offline_puja_location-success"  style="display: none; margin-top: 2px;"></label>
                                </div>
                                </div>
                            </div>
                        </div>

                         </div>
                    </div>
                    


                    {{-- additional-mantra-add --}}
                    @if(@$puja->availability=="Y")
                    @if(Auth::check())
                    <form id="mantra_form" @if(@$userData->manner_of_puja=='OFFLINE') style="display: none;" @else style="display: block;" @endif >
                        <h4 class="custom_heading_h4">You may add additional Mantars for the receital at the given prices for the enhancement of impact of Puja.</h4>
                    <div class="addit_man">
                         
                        <div class="form_box_area">
                            <label>Additional Mantra</label>
                            <select name="mantra"  id="mantra">
                                <option value="">Select Mantra</option>
                                @foreach(@$mantra as $value)
                                <option value="{{@$value->id}}">{{@$value->mantra}}</option>
                                @endforeach    
                            </select>
                            <div id="duplicate_error" style="display: none;color: red;">This already added</div>
                            {{-- <div class="clearfix"></div> --}}
                        </div>
                        <div class="form_box_area">
                            <label>No Of Recitals</label>
                            <select name="mantra_recitals"  id="mantra_recitals">
                                <option value="">Select No Of Recitals</option>
                                
                            </select>
                        </div>
                        {{-- <div class="clearfix"></div> --}}
                        <div class="add_more">
                            <button type="submit" class="pag_btn" style="border:none;"> <i class="fa fa-plus" aria-hidden="true"></i> Add</button>
                         </div>
                     
                    </div>
                    </form>
                    @endif
                    @endif

                    {{-- end-mantra-add --}}

                    </div>
                    <div class="shareBx" >
                        <span><i class="fa fa-share-square-o" aria-hidden="true"></i>{{__('search.share')}}:</span>

                        <ul style="min-width: 160px">
                            <div class="sharethis-inline-share-buttons"></div>
                            {{-- <li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon1.png')}}" alt=""></a></li>
                            <li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon2.png')}}" alt=""></a></li>
                            <li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon3.png')}}" alt=""></a></li>
                            <li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon4.png')}}" alt=""></a></li> --}}
                        </ul>


                    </div>
                    </div>
                    
                </div>
                @if(@$puja->availability=="Y")
                @if(Auth::check())
                <div class="addit_man_list bac back_white" id="addit_man_list" @if(@$userData->manner_of_puja=='OFFLINE') style="display: none;" @else style="display: block;" @endif>
                   <div class="custom_list">
                    <ul>
                        <li><b>No Mantra Added</b></li>
                        
                    </ul>
                    {{-- <a href="#url" class="pag_btn sll_btn"><i class="fa fa-times"></i> Delete</a> --}}
                   </div>
                   
                                       
                </div>
                @endif
                @endif

                @if(@$puja->availability=="Y")
                <div class="gan_puja_sec back_white"  @if(@$userData->manner_of_puja=='OFFLINE') style="display: none;" @else style="display: block;" @endif >
                    @if(Auth::check())
                    


                   {{-- <form action="{{route('user.puja.booking')}}" id="add_customer_form" method="post"> --}}
                    
                   



                   <div class="row">
                     <div class="col-md-6 col-sm-6">
                            
                            <div class="form_box_area" id="offline_date_div" @if(@$userData->manner_of_puja=='OFFLINE') style="display: block;" @else  style="display: none;" @endif>
                                <label>Select Puja Date </label>
                                <input type="text"  placeholder="Select Puja Date" name="puja_date" class="puja_date_picker " id="puja_date_picker_offline" readonly>
                            </div>

                            <div class="form_box_area" @if(@$userData->manner_of_puja=='ONLINE' || @$userData->manner_of_puja=='BOTH') style="display: block;" @else  style="display: none;" @endif id="online_date_div">
                                <label>Select Puja Date </label>
                                <input type="text"  placeholder="Select Puja Date" name="puja_date" class="puja_date_picker " id="puja_date_picker_online" readonly>
                            </div>
                            
							<h4 class="custom_heading_h4">Please book online puja at least 24 hours before and offline puja at 48 hours before.</h4>
                     </div>
                       
                      

                     

                       
                   
                   </div> 





                   



                   <div class="row" id="offline_location" @if(@$userData->manner_of_puja=='ONLINE' || @$userData->manner_of_puja=='BOTH') style="display: none;" @endif>
                     <div class="col-md-12 col-sm-6">
                            <div class="form_box_area">
                                <label>Select Location</label>
                                <input type="text" id="offline_puja_location" type="text" placeholder="{{__('profile.offline_puja_area_placeholder')}}" name="offline_puja_location">
                            </div>
                     </div>
                   </div> 

                   <div class="row"  @if(@$userData->manner_of_puja=='ONLINE' || @$userData->manner_of_puja=='BOTH') style="display: none;" @endif id="landmark_show">
                     <div class="col-md-6 col-sm-6">
                            <div class="form_box_area">
                                <label>Landmark</label>
                                <input type="text" id="landmark" type="text" placeholder="Landmark" name="landmark">
                            </div>
                     </div>

                     <div class="col-md-6 col-sm-6">
                            <div class="form_box_area">
                                <label>House/Flat No</label>
                                <input type="text" id="house_no" type="text" placeholder="House/Flat No" name="house_no">
                            </div>
                     </div>
                   </div>

                   {{-- <div class="row"  @if(@$userData->manner_of_puja=='ONLINE' || @$userData->manner_of_puja=='BOTH') style="display: none;" @endif id="flat_show">
                     
                   </div> --}}

                                           
                      



                   


                   <div class="row hed_puja_det_taital">
                    <div class="col-sm-6">
                       <h2>Add Person Name For Puja  :</h2>
                      </div>  
                      <div class="col-sm-6">
                       @if(@$customers && @count($customers)>0)                           
                        <a href="javascript:;" class="add-cus" id="add_previous"> <i class="fa fa-user" ></i> Select Person from My List </a>
                        <a href="javascript:;" class="add-cus" id="hide_previous" style="display: none;"> <i class="fa fa-user" ></i> Hide Person from My List </a>
                       @endif              
                   </div>
                       
                      
                 </div>


                                    <div class="row" id="previous_customer" style="display: none;">
                    <div class="col-sm-12"> 
                        <div class="add-cus-sec">
                            <h2>Previously Added Name For Puja :</h2>


                        <ul class="add_div">
                           
                            @foreach(@$customers as $customer)
                            <li>   
                                <label class="list_checkBox">
                                <div>
                                    <span>{{@$customer->name}}</span>
                                </div> 
                                @if(@$customer->dob!="")
                                <div>
                                    ,&nbsp;<b>Dob:</b> <span>{{@$customer->dob}}</span>
                                </div>
                                @endif
                                
                                <div>
                                     <span>, {{@$customer->place_of_residence}}</span>
                                </div>

                                @if(@$customer->janama_nkshatra!="")
                                <div>
                                   <span>,{{@$customer->nakshatras->name}}</span>
                                </div>  
                                @endif
                                @if(@$customer->janam_rashi_lagna   !="")
                                <div>
                                    <span>, {{@$customer->rashis->name}}</span>
                                </div> 
                                @endif
                                @if(@$customer->gotra!="")
                                <div>
                                    , {{@$customer->gotra}}</span>
                                </div>
                                @endif
                                   

                                <input type="checkbox" name="previous[]" id="check_box_{{@$customer->id}}" value="{{@$customer->id}}" class="prv_check"> <span class="list_checkmark"></span> 
                            </label>
                                
                            </li>
                            @endforeach
                            
                        </ul>
                        </div>
                    </div>
                   </div>




                 <form id="add_more_form">
                    @csrf
                   <div class="row" id="dynamicform">
                    
                    <div class="col-md-6 col-sm-12">
                        <div class="custom_div_class">
                            <div class="row">

                         <input type="hidden" name="puja_name_id" id="puja_name_id" value="{{@$puja->id}}">
                         <input type="hidden" name="user_id_puja" id="user_id_puja" value="{{auth()->user()->id}}">       
                        <div class="col-md-12 col-sm-6">
                            <div class="form_box_area">
                                
                                <input type="text" placeholder="Name" name="name" class="customer_name" id="customer_name">
                            </div>
                            </div>
                            
                            <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                    
                                    <input type="text" placeholder="Date of Birth" class="position-relative datepicker_puja" name="dob" class="date_of_birth" id="datepicker" readonly> 
                                    </div>
                                </div>
                            
                            <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                 <select name="nakshatra" class="customer_nakshatra" id="nakshatra">
                                      <option value="">Select Janam Nakshatra</option>
                                      @foreach(@$nakshatra as $value)
                                      <option value="{{@$value->id}}">{{@$value->name}}</option>
                                      @endforeach
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                  <select name="rashi" class="customer_rashi" id="rashi">
                                      <option value="">Select Rashi</option>
                                      @foreach(@$rashi as $value)
                                      <option value="{{@$value->id}}">{{@$value->name}}</option>
                                      @endforeach
                                  </select>
                                    
                                </div>
                            </div>

                            <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                    <input type="text"  name="gotra" placeholder="Enter Gotra" class="customer_gotra" id="gotra">
                                 {{--  <select name="gotra" class="customer_gotra" id="gotra">
                                      <option value="">Select Gotra</option>
                                      @foreach(@$gotra as $value)
                                      <option value="{{@$value->id}}">{{@$value->gotra_name_en}}</option>
                                      @endforeach
                                  </select> --}}
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                  <input type="text"  name="residence" placeholder="Place of residence" class="customer_residence" id="residence">
                                </div>
                            </div> 
                           
                            <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                    <div class="check-box">
                                    <input type="checkbox" id="save" name="save" value="1" >
                                    <label for="save" class="checklabeel">add this name to my saved list</label>
                                </div>
                                {{-- <input type="checkbox" name="save" value="1" id="save">add this name to my saved list --}}
                            </div>
                          </div>
                            <input type="hidden" name="cus_check" id="check_val">
                            <div class="col-sm-12">
                                <div class="add_more">
                                    <button type ="submit" class="pag_btn" style="border:none;"> <i class="fa fa-plus" aria-hidden="true"></i> Add Person</button>
                                 </div>
                            </div>
                          </div>   
                        </div> 
                        </div>

                        {{-- dynamic-form --}}
                   </div>
               </form>
               
              


               {{-- display puja customer names --}}


             <div class="row">
                    <div class="col-sm-12"> 
                        <div class="add-cus-sec">
                            <h2>Lisitng Of Added Name For Puja :</h2>
                        <ul class="add_div" id="live_added_names">
                            <li>  
                           <div>
                                 <span>No Data</span>
                                </div>
                            </li>
                           
                            
                        </ul>
                        </div>
                    </div>
                   </div>

















                <form action="{{route('user.puja.booking')}}" id="mail_puja_form" method="post">  
                @csrf 
                 <input type="hidden" name="landmark_name" id="landmark_id">
                 <input type="hidden" name="house_name" id="house_id">
                 <input type="hidden" name="puja_date" id="puja_date_id">   
                 <input type="hidden" name="offline_puja_location" id="puja_location_id">   
                 <input type="hidden" name="puja_id" value="{{@$userData->id}}">    
                 <input type="hidden" name="zipcode" id="zipcode_inner_id" >
                 <input type="hidden" name="homam_status" value="N" id="homam_status">
                 <input type="hidden" name="cd_status" value="N" id="cd_status">
                 <input type="hidden" name="live_streaming_status" value="N" id="live_streaming_status">
                 <input type="hidden" name="prasad_status" value="N" id="prasad_status">
                 <input type="hidden" name="priest_dakshina"  id="priest_dakshina" value="0">
                 <input type="hidden" name="delivery_of_prasad" id="delivery_of_prasad" @if(@$puja->is_prasad_delivery=="Y") value="Y" @else value="N" @endif>
                                      @if(@session()->get('currency')==1)
                    @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                @php
                                $old_price = $puja->price_inr;
                                $discount_value = ($old_price / 100) * @$puja->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_sub_total" id="puja_sub_total" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_sub_total" id="puja_sub_total" value="{{@$puja->price_inr}}">
                               
                     @endif
                     @else
                     @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                 @php
                                $old_price = @$custom * $puja->price_usd;
                                $discount_value = ($old_price / 100) * @$puja->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_sub_total" id="puja_sub_total" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_sub_total" id="puja_sub_total" value="{{round(@$custom * @$puja->price_usd,2)}}">
                               
                     @endif
                    
                     @endif 
                 <input type="hidden" name="manner_of_puja" id="manner_of_puja" @if(@$userData->manner_of_puja=="BOTH"|| @$userData->manner_of_puja=="ONLINE") value="ONLINE" @else value="OFFLINE" @endif>
                    <input type="hidden" name="puja_price" id="puja_price"> 
                     {{-- @if(@session()->get('currency')==1)
                    @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                @php
                                $old_price = $puja->price_inr;
                                $discount_value = ($old_price / 100) * @$puja->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_price" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_price" value="{{round(@$puja->price_inr,2)}}">
                               
                     @endif
                     @else
                     @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                 @php
                                $old_price = $puja->price_usd;
                                $discount_value = ($old_price / 100) * @$puja->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_price" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_price" value="{{round(@$puja->price_usd,2)}}">
                               
                     @endif
                    
                     @endif   --}}  
                <div class="row">
                <div class="col-sm-12">
                                <div class="button_submit">
                                   
                                    <button type ="submit" class="pag_btn" style="border:none;"><i class="fa fa-sign-in" aria-hidden="true"></i> Book Your Puja</button>
                                    
                                 </div>
                            </div>
                  </div>
                </form>          
            
            @else
                 <a class="pag_btn login_click" style="border:none;color: white"><i class="fa fa-sign-in" aria-hidden="true"></i> Book Your Puja</a>
             @endif
            </div>
            @else
            <div class="gan_puja_sec back_white">
                <a class="pag_btn" style="border:none;color: white"><i class="fa fa-sign-in" aria-hidden="true"></i> Puja Currently No Available</a>
            </div>

            @endif


@if(@$puja->pujaDeity->isNotEmpty() || @$puja->pujaPlanet->isNotEmpty() || @$puja->pujaRashi->isNotEmpty() || @$puja->pujaNakshatra->isNotEmpty())
<div class="about_astro back_white">
            @if(!@$puja->pujaDeity->isEmpty())
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Diety</strong>
                            @if(!@$puja->pujaDeity->isEmpty())
                            
                            <p>
                             @foreach (@$puja->pujaDeity as $deity) {{@$deity->deity->name}} @if (!$loop->last),@endif @endforeach
                             
                           </p>
                            @else
                            <span>Diety not available</span>
                            @endif
                        </div>
                    </div>
                    @endif

          @if(@$puja->pujaPlanet->isNotEmpty())
          <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Planets</strong>
                            
                            <p>
                            @if(!@$benificials_planet)
                             @foreach (@$puja->pujaPlanet as $planets) {{@$planets->planets->planet_name}} @if (!$loop->last),@endif @endforeach
                             @else
                             Beneficial for all planet
                             @endif
                             
                         </p>
                        </div>
                    </div>
          @endif
          @if(@$puja->pujaRashi->isNotEmpty())
          <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Rashis</strong>
                           
                            <p>
                            @if(!@$benificials_rashi)
                             @foreach (@$puja->pujaRashi as $rashis) {{@$rashis->rashis->name}} @if (!$loop->last),@endif @endforeach
                             @else
                             Beneficial for all rashi
                             @endif
                             
                         </p>

                        </div>
                    </div>
          @endif
          @if(@$puja->pujaNakshatra->isNotEmpty())
          <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Nakshatras</strong>
                          
                            <p>
                             @if(!@$benificials_nakshatra)
                             @foreach (@$puja->pujaNakshatra as $nakshatras) {{@$nakshatras->nakshatras->name}} @if (!$loop->last),@endif @endforeach
                             @else
                             Beneficial for all nakshatra
                             @endif
                             
                         </p>
                        </div>
                    </div>
          @endif
        </div>
        @endif



                <div class="about_astro back_white">
                    <h2>About Puja :</h2>
                    {{-- <div class="article">
                        @if(strlen(@$puja->puja_description) > 150)
                        <p class="aboutRemaove">{!! substr(@$puja->puja_description, 0, 150 ) . '...' !!}</p>
                        <p class="moretext">
                            {!! @$puja->puja_description !!}
                        </p>
                        <a class="moreless-button">{{__('search.read_more')}} +</a>
                        @else
                        <p>{!! @$puja->puja_description !!}</p>
                        @endif
                    </div>
                    @if(@$puja->importance_significance!="")
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Puja Significance</strong>
                            <span>{{@$puja->importance_significance}}</span>
                        </div>
                    </div>
                    @endif
                    @if(@$puja->facts_mythology!="")
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Facts Of Mythology</strong>
                            <span>{{@$puja->facts_mythology}}</span>
                        </div>
                    </div>
                    @endif --}}
                    @if(!@$puja->pujaPurpose->isEmpty())
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Purpose of Puja</strong>
                            @if(!@$puja->pujaPurpose->isEmpty())
                            <p>
                            @foreach ( @$puja->pujaPurpose as  $purpose)
                            {{$purpose->purpose->name}} @if (!$loop->last),@endif
                            @endforeach
                            </p>
                            @else
                            <span>Purpose not available</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    

                     @if(@$puja->assurance_guarantee)
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Assurance/ Guarantee / Warranty</strong>
                            <span style="white-space:pre-wrap;">{!!@$puja->assurance_guarantee!!}</span>
                        </div>
                    </div>
                    @endif
                </div>
                


                @if(@$puja->youtube_link_code!='')
            <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description video-center back_white">
                          <iframe width="560" height="315" src="https://www.youtube.com/embed/{{@$puja->youtube_link_code}}" frameborder="0" allowfullscreen></iframe>
                       </div>
                    </div>
                </div>
                @endif

               
                <div class="customer_review_box back_white">
                    <h5>{{__('search.customer_review')}} :</h5>
                    <div class="review_box">
                        <div class="review_left">
                            <b>{{@$puja->avg_review}}</b>
                            <ul>
                                @php
							$rating=explode('.',$puja->avg_review);
							for($i=1;$i<=$rating[0];$i++)
							{
							@endphp
                            	<li><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></li>
								@php
							}
							if($rating[1]>0 and $rating[1]<4)
							{
								@endphp
								<li><img src="{{ URL::to('public/frontend/images/star20.png')}}" alt=""></li>
								@php
							}
							if($rating[1]>=4 and $rating[1]<5)
							{
								@endphp
								<li><img src="{{ URL::to('public/frontend/images/star40.png')}}" alt=""></li>
								@php
							}
							if($rating[1]>=5 and $rating[1]<6)
							{
								@endphp
								<li><img src="{{ URL::to('public/frontend/images/star50.png')}}" alt=""></li>
							@php
							}
							if($rating[1]>=6 and $rating[1]<8)
							{
								@endphp
								<li><img src="{{ URL::to('public/frontend/images/star60.png')}}" alt=""></li>
							@php
							}
							if($rating[1]>=8)
							{
								@endphp
								<li><img src="{{ URL::to('public/frontend/images/star80.png')}}" alt=""></li>
							@php
							}
							if($rating[1]>0)
							{
							for($j=1;$j<=(4-$rating[0]);$j++)
							{
							@endphp
							<li><img src="{{ URL::to('public/frontend/images/star3.png')}}" alt=""></li>
							@php
							}}
							else
							{
								for($j=1;$j<=(5-$rating[0]);$j++)
								{
							@endphp
							<li><img src="{{ URL::to('public/frontend/images/star3.png')}}" alt=""></li>
							@php
								}}
							@endphp
                            </ul>
                            <strong>(Review {{@$puja->tot_review}})</strong>
                        </div>
                        <div class="review_right">
                            <ul>
								<li>
									<em>5</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($reviews)>0?100*(count($reviews->where('ratting_number',5))/count($reviews)):0}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>( {{count(@$reviews->where('ratting_number', 5)) }} Customers)</b>
								</li>
								<li><em>4</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($reviews)>0?100*(count($reviews->where('ratting_number',4))/count($reviews)):0}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$reviews->where('ratting_number',4))}} Customers)</b>
								</li>
								<li><em>3</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($reviews)>0?100*(count($reviews->where('ratting_number',3))/count($reviews)):0}}%;%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$reviews->where('ratting_number',3))}} Customers)</b>
								</li>
								<li><em>2</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($reviews)>0?100*(count($reviews->where('ratting_number',2))/count($reviews)):0}}%;%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$reviews->where('ratting_number',2))}} Customers)</b>
								</li>
							</ul>
                        </div>
                    </div>
                    <div class="review_person">
					@if(@$reviews->isNotEmpty())
                        @foreach(@$reviews as $key=> $review)
                        @if($key<2)
                        <div class="review_per_item">
                            <div class="media">
                                <em>@if(@$review->customer_review->profile_img!="")<img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$review->customer_review->profile_img}}" alt=""> @else  <img src="{{ URL::to('public/frontend/images/user-img.jpg')}}" alt=""> @endif</em>
                                <div class="media-body">
                                    <h2>{{@$review->customer_review->first_name}} {{@$review->customer_review->last_name}}</h2>
                                    <ul>
                                        <li>
                                                 @for($i=0;$i<=(@$review->ratting_number-1);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/star1.png')}}"></a>
                                               @endfor
                                            
                                             @for($i=0;$i<(5-@$review->ratting_number);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/star3.png')}}"></a>
                                             @endfor
                                            </li>
                                        <li>
                                            <i class="fa fa-calendar"></i>
                                            <strong>{{date('F j, Y',strtotime(@$review->created_at))}}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if(strlen(@$review->review_message) >212)
                             <p class="aboutRemaove-review-{{@$review->id}}">{!! substr(@$review->review_message, 0, 212 ) . '...' !!}</p>
                                    <p class="moretext-review-{{@$review->id}}" style="display: none;">
                                        {!! @$review->review_message !!}
                                    </p>

                                    <span class="moreless-button-review-{{@$review->id}}" style="color: #e8a173;cursor: pointer;">Read More +</span>
                                    @else

                                    <p>{!! @$review->review_message !!}</p>
                                    @endif
                        </div>
                        @endif
                        @endforeach
                        @endif

                        <div class="more-review" style="display: none;">
						@if(@$reviews->isNotEmpty())
                            @foreach(@$reviews as $key=> $review)
                            @if($key>=2)
                             <div class="review_per_item">
                            <div class="media">
                                <em>@if(@$review->customer_review->profile_img!="")<img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$review->customer_review->profile_img}}" alt=""> @else  <img src="{{ URL::to('public/frontend/images/user-img.jpg')}}" alt=""> @endif</em>
                                <div class="media-body">
                                    <h2>{{@$review->customer_review->first_name}} {{@$review->customer_review->last_name}}</h2>
                                    <ul>
                                        <li>
                                                 @for($i=0;$i<=(@$review->ratting_number-1);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/star1.png')}}"></a>
                                               @endfor
                                            
                                             @for($i=0;$i<(5-@$review->ratting_number);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/star3.png')}}"></a>
                                             @endfor
                                            </li>
                                        <li>
                                            <i class="fa fa-calendar"></i>
                                            <strong>{{date('F j, Y',strtotime(@$review->created_at))}}</strong>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @if(strlen(@$review->review_message) >212)
                             <p class="aboutRemaove-review-{{@$review->id}}">{!! substr(@$review->review_message, 0, 212 ) . '...' !!}</p>
                                    <p class="moretext-review-{{@$review->id}}" style="display: none;">
                                        {!! @$review->review_message !!}
                                    </p>

                                    <span class="moreless-button-review-{{@$review->id}}" style="color: #e8a173;cursor: pointer;">Read More +</span>
                                    @else

                                    <p>{!! @$review->review_message !!}</p>
                                    @endif
                        </div>
                        @endif
                        @endforeach
						@endif
                        </div>
                    </div>
					@if(@$reviews->isNotEmpty())
                    @if(count(@$reviews)>2)
                    <a class="moreless-button5  show_more show-more-review">Show More Reviews +</a>
                    @endif
                    @endif
                </div>
            </div>



            







            <div class="ast_det_right bac">
                <div class="ast_det_right_inr">
                    <h6><img src="{{ URL::to('public/frontend/images/check.png')}}" alt="">Similar Puja</h6>
                    {{-- <form> --}}
                        @if(@$similarPuja->count()>0)
                        <div class="astro-dash-form new-astropuja">
                            <div class="row similer-puja">
                                <div  style="display: block">
                                    @foreach ($similarPuja as $puja1)
                                    <div class="item">
                                        <div class="gem-stone-item back_white">
                                            <a href="{{route('search.puja.details',['slug'=>@$puja1->slug])}}" target="_blank"><span><img src="{{ URL::to('storage/app/public/puja_image')}}/{{$puja1->puja_image}}" ></span></a>
                                            <div class="gem-stone-text">
                                                <h5><a href="{{route('search.puja.details',['slug'=>@$puja1->slug])}}" target="_blank">@if(strlen(@$puja1->puja_name) > 20)
                                        {!! substr(@$puja1->puja_name, 0, 20 ) . '...' !!}
                                        @else
                                        {!! @$puja1->puja_name !!}
                                        @endif</a></h5>
                                                <p>
                                                    @if(strlen(@$puja1->puja_description) > 60)
                                                    {!! substr(@$puja1->puja_description, 0, 60 ) . '...' !!}
                                                    @else
                                                    {!! @$puja1->puja_description !!}
                                                    @endif
                                                </p>
                                                <ul>
                                                    <li>
                                                    @if(@session()->get('currency')==1)
                                                    @if(@$puja1->discount_inr!=null && @$puja1->discount_inr>0)
                                                   @php
                                                    $old_price = $puja1->price_inr;
                                                    $discount_value = ($old_price / 100) * @$puja1->discount_inr;
                                                    $new_price = $old_price - $discount_value;
                                                    @endphp
                                                    <del>{{@session()->get('currencySym')}} {{@$puja1->price_inr}} </del> &nbsp;   {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                    @else
                                                    {{@session()->get('currencySym')}} {{@$puja1->price_inr}}
                                                    @endif
                                                    @else
                                                    @if(@$puja1->discount_usd!=null && @$puja1->discount_usd>0)
                                                    @php
                                                    $old_price = @$custom * $puja1->price_usd;
                                                    $discount_value = ($old_price / 100) * @$puja1->discount_usd;
                                                    $new_price = $old_price - $discount_value;
                                                    @endphp
                                                    <del>{{@session()->get('currencySym')}} {{round(@$custom * @$puja1->price_usd,2)}} </del> &nbsp;  {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                    @else
                                                    {{@session()->get('currencySym')}} {{round(@$custom * @$puja1->price_usd,2)}}
                                                    @endif
                                                    


                                                    @endif
                                                    </li>
                                                    {{-- <li><del>$35.00</del>$28.00</li> --}}
                                                    <li><a href="{{route('search.puja.details',['slug'=>@$puja1->slug])}}" class="pag_btn" target="_blank">View More</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    {{-- <div class="item">
                                        <div class="gem-stone-item">
                                            <span><img src="{{ URL::to('public/frontend/images/product2.png')}}" alt=""></span>
                                            <em class="new_ston">New</em>
                                            <div class="gem-stone-text">
                                                <h5><a href="#url">Sphatik</a></h5>
                                                <p>Lorem quis bibendum auctor, nisi elit nib id elit. Duis sed .</p>
                                                <ul>
                                                    <li><del>$35.00</del>$28.00</li>
                                                    <li><a href="#url" class="pag_btn">Buy Now</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="gem-stone-item">
                                            <span><img src="{{ URL::to('public/frontend/images/product3.png')}}" alt=""></span>
                                            <div class="gem-stone-text">
                                                <h5><a href="#url">Yantra </a></h5>
                                                <p>Lorem quis bibendum auctor, nisi elit nib id elit. Duis sed .</p>
                                                <ul>
                                                    <li><del>$35.00</del>$28.00</li>
                                                    <li><a href="#url" class="pag_btn">Buy Now</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="gem-stone-item">
                                            <span><img src="{{ URL::to('public/frontend/images/product4.png')}}" alt=""></span>
                                            <div class="gem-stone-text">
                                                <h5><a href="#url">Crystal</a></h5>
                                                <p>Lorem quis bibendum auctor, nisi elit nib id elit. Duis sed .</p>
                                                <ul>
                                                    <li><del>$35.00</del>$28.00</li>
                                                    <li><a href="#url" class="pag_btn">Buy Now</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="gem-stone-item">
                                            <span><img src="{{ URL::to('public/frontend/images/product4.png')}}" alt=""></span>
                                            <div class="gem-stone-text">
                                                <h5><a href="#url">Crystal</a></h5>
                                                <p>Lorem quis bibendum auctor, nisi elit nib id elit. Duis sed .</p>
                                                <ul>
                                                    <li><del>$35.00</del>$28.00</li>
                                                    <li><a href="#url" class="pag_btn">Buy Now</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="gem-stone-item">
                                            <span><img src="{{ URL::to('public/frontend/images/product4.png')}}" alt=""></span>
                                            <div class="gem-stone-text">
                                                <h5><a href="#url">Crystal</a></h5>
                                                <p>Lorem quis bibendum auctor, nisi elit nib id elit. Duis sed .</p>
                                                <ul>
                                                    <li><del>$35.00</del>$28.00</li>
                                                    <li><a href="#url" class="pag_btn">Buy Now</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                {{-- <div class="col-12">
                                    <div class="form_box_area">
                                        <label>Puja Date</label>
                                        <input type="text" placeholder="Puja Date" class="datepicker2">
                                    </div>
                                </div> --}}
                                {{-- <div class="col-12">
                                    <div class="form_box_area">
                                        <label>Puja Manner</label>
                                        <select class="login-type log-select" name="puja_manner" id="puja_manner">
                                            @if(@$userData->manner_of_puja=='BOTH')
                                            <option value="">Select Puja Type</option>
                                            <option value="ONLINE">{{__('search.online')}}</option>
                                            <option value="OFFLINE">{{__('profile.offline')}}</option>

                                            @elseif(@$userData->manner_of_puja=='ONLINE')
                                            <option value="ONLINE">{{__('search.online')}}</option>

                                            @elseif(@$userData->manner_of_puja=='OFFLINE')
                                            <option value="OFFLINE">{{__('profile.offline')}}</option>
                                            @endif

                                        </select>
                                    </div>
                                </div> --}}
                                {{-- @if(@$userData->manner_of_puja=='OFFLINE' || @$userData->manner_of_puja=='BOTH') --}}
                                {{-- <div class="col-12">
                                    <div class="form_box_area">
                                        <label>Zip code
                                            <a href="javascript:;" id="ch_zip" style="color: blue"> Check</a>
                                            <a href="javascript:;" id="edit_zip" style="color: red;"> change</a>
                                        </label>
                                        <input type="text" placeholder="zip code" name="zipCode" id="zipCode">
                                        <label id="offline_puja_location-error" class="error" for="offline_puja_location" style="display: none; margin-top: 2px;"></label>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-12">
                                    <div class="form_box_area">
                                        <label>Address</label>
                                        <input type="text" placeholder="Enter address" >
                                    </div>
                                </div> --}}
                                {{-- @endif --}}
                            </div>
                            {{-- <div class="row">
                                <div class="col-12">
                                    <div class="form_box_area">
                                        <label>Name</label>
                                        <input type="text" placeholder="name " >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form_box_area">
                                        <label>DOB</label>
                                        <input type="text" placeholder="Date Of Birth" class="datepicker1">
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <button type="submit" class="login-submit">Booking</button> --}}
                            </div>
                            @endif
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@if(@$puja->puja_video)
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" style="padding: 1rem;" id="yt-player">

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@endif


<div class="modal" tabindex="-1" role="dialog" id="login-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">You are not logged in</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="row">
            <div class="col-sm-6">
            
            <div>
              <a href="{{route('register')."?ref=".\Request::fullUrl()}}" class="new-register" style="width: 100%;margin-top: 9px" ><img src="{{ URL::to('public/frontend/images/log-user.png')}}"> <p>New User? Click to</p> Sign Up</a>
             </div>
           </div>
           
            <div class="col-sm-6">
            
            <div>
              <a href="{{route('login')."?ref=".\Request::fullUrl()}}" class="new-register" style="width: 100%;margin-top: 9px"  ><img src="{{ URL::to('public/frontend/images/add-user.png')}}"> <p>Have an account ?</p> Click to Login</a>
             </div>
           </div>
           </div>

           </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

   <script>
    @foreach(@$reviews as $review)
    $('.moreless-button-review-{{@$review->id}}').click(function() {

        if ($('.moreless-button-review-{{@$review->id}}').text() == "Read More +") {
            $('.aboutRemaove-review-{{@$review->id}}').hide();
            $('.moretext-review-{{@$review->id}}').show();
            $(this).text("Read Less -")
        } else {
            $('.aboutRemaove-review-{{@$review->id}}').show();
            $('.moretext-review-{{@$review->id}}').hide();
            $(this).text("Read More +")
        }
        // $('.moretext').slideToggle();

    });
    @endforeach
</script>

<script type="text/javascript">
// $('body').on('focus', '.datepicker_puja', function(){

//      var currentDate = new Date();
//      // $(this).datepicker
//     // $(this).datepicker();
//         $(this).datepicker({
//          changeMonth: true,
//          changeYear:true,
//         });

// });
//$(".datepicker_puja").prop('readonly', false);

</script>
  <script src='datepicker-hi.js' type='text/javascript'></script>
<script type="text/javascript">
$('body').on('focus', '.puja_date_picker', function(){

     var currentDate = new Date();
     // $(this).datepicker
    // $(this).datepicker();
        $(this).datepicker({
         changeMonth: true,
         changeYear:true,
          minDate: 1 ,
         yearRange: "2021:2023",
         

        });
        $('.ui-datepicker').addClass('notranslate');

});
</script>

<script type="text/javascript">
      $( function() {
    $( "#puja_date_picker_online" ).datepicker({
         changeMonth: true,
         changeYear:true,
         minDate: 1 ,
         yearRange: "2021:2023",

    });
     $('.ui-datepicker').addClass('notranslate');

  } );  
</script>

<script type="text/javascript">
      $( function() {
    $( "#puja_date_picker_offline" ).datepicker({
         changeMonth: true,
         changeYear:true,
         minDate: 2 ,
         yearRange: "2021:2023",

    });
     $('.ui-datepicker').addClass('notranslate');

  } );  
</script>


<script>
    $( function() {
    $( "#datepicker" ).datepicker({
         maxDate : 0,
        changeYear: true,
        changeMonth: true,
        yearRange: "1930:2021",

    });
     $('.ui-datepicker').addClass('notranslate');

  } );
</script>
{{-- <script type="text/javascript">
        $('.datepicker_puja').live('click', function () {
        $(this).datepicker({ maxDate : 0,
        changeYear: true, }).focus();
    });
</script> --}}
{{-- <script type="text/javascript">


$(".datepicker_puja").each(function(){
    $(this).datepicker({
        maxDate : 0,
        changeYear: true,
    });
});
</script> --}}
<script>
    $('.moreless-button').click(function() {

        if ($('.moreless-button').text() == "{{__('search.read_more')}} +") {
            $('.aboutRemaove').hide();
            $('.moretext').show();
            $(this).text("{{__('search.read_less')}} -")
        } else {
            $('.aboutRemaove').show();
            $('.moretext').hide();
            $(this).text("{{__('search.read_more')}} +")
        }
        // $('.moretext').slideToggle();

    });
</script>
<script type="text/javascript">
    $('.moreless-button1').click(function() {
  $('.moretext1').slideToggle();
  if ($('.moreless-button1').text() == "{{__('search.view_all')}} +") {
    $(this).text("{{__('search.view_less')}} -")
  } else {
    $(this).text("{{__('search.view_all')}} +")
  }
});
</script>
<script type="text/javascript">
    $('.moreless-button2').click(function() {
  $('.moretext2').slideToggle();
  if ($('.moreless-button2').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}} +")
  }
});
</script>

<script type="text/javascript">
    $('.moreless-button3').click(function() {
  $('.moretext3').slideToggle();
  if ($('.moreless-button3').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}}e +")
  }
});
</script>


<script type="text/javascript">
    $('.moreless-button4').click(function() {
  $('.moretext4').slideToggle();
  if ($('.moreless-button4').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}} +")
  }
});
</script>


<script type="text/javascript">
    $('.moreless-button5').click(function() {
  $('.moretext5').slideToggle();
  if ($('.moreless-button5').text() == "Show More Reviews +") {
    $(this).text("Show Less Reviews -")
  } else {
    $(this).text("Show More Reviews +")
  }
});
</script>
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
<script>
    $(document).on('click', function () {
        var $target = $(event.target);
        if (!$target.closest('.shopcutBx').length && !$target.closest('.shopcut').length && $('.shopcutBx').is(":visible")) {
            $('.shopcutBx').slideUp();
        }
    });
    $(document).ready(function(){
        $('#full_content').hide();
    });
function showhidepara(){
        if($('#full_content').css('display') == 'none'){
            $('#desc_more').html("{{__('search.read_less')}} -");
            $('#full_content').show();
            $('#short_content').hide();
        } else {
            $('#desc_more').html("{{__('search.read_more')}} +");
            $('#full_content').hide();
            $('#short_content').show();
        }
    }
</script>
<script>
    $(document).ready(function(){

        $('#talk_now').click(function(){
            if(!$('#u_id').val()){
                Swal.fire('Please login to Puja booking');
                return 0;
            }
            $(".log-select option:contains(Select Day)").attr('selected', 'selected');
            $("#durarion").modal("show");
        });

    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
        $("#puja_from").validate({
            rules: {
                puja_day:{
                    required: true,
                },
                puja_type:{
                    required: true,
                },
                puja_name:{
                    required: true,
                },
                offline_puja_location:{
                    required:function(){
                        var puja_type = $('#puja_type').val();
                        if(puja_type=='OFFLINE'){
                            return true
                        }else{
                            return false
                        }
                    },
                },

            },
            messages: {
                puja_day:{
                    required: 'Select puja booking day',
                },
                puja_type:{
                    required: 'Select puja type',
                },
                puja_name:{
                    required: 'Select puja ',
                },
                offline_puja_location:{
                    required:'Enter Puja Location'
                },
            },
        });
        $('#puja_name').change(function(){
            var rate=event.target.options[event.target.selectedIndex].dataset.price;
            console.log(rate);
            if(rate!=null){
                $('#amount h3').html('Total Amount: - '+ rate);
            }else{
                $('#amount h3').html('Total Amount: - '+ 0);
            }
        });
    })
</script>
<script>
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('offline_puja_location');

        var options = {
          types: ['establishment']
        };

        var input = document.getElementById('offline_puja_location');
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place)
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#lat').val(place.geometry.location.lat());
            $('#lng').val(place.geometry.location.lng());
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
            $('.exct_btn').show();
            console.log(place.address_components);
            initMap();
        });
        initMap();
    }
</script>

<script>

    function initMap() {
        geocoder = new google.maps.Geocoder();
        var lat = $('#lat').val();
        var lng = $('#lng').val();
        var myLatLng = new google.maps.LatLng(lat, lng);
        // console.log(myLatLng);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Choose hotel location',
          draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(evt,status){
        $('#lat').val(evt.latLng.lat());
        $('#lng').val(evt.latLng.lng());
        var lat_1 = evt.latLng.lat();
        var lng_1 = evt.latLng.lng();
        var latlng = new google.maps.LatLng(lat_1, lng_1);
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#offline_puja_location').val(results[0].formatted_address);
                }
            });


        });
    }
    </script>
    {{-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1A0Zjdpb5eWY6MCTp_8ZOVAlDkUB4MTY&callback=initMap">
    </script> --}}
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1A0Zjdpb5eWY6MCTp_8ZOVAlDkUB4MTY&libraries=places&callback=initAutocomplete" async defer></script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRZMuXnvy3FntdZUehn0IHLpjQm55Tz1E&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    $(document).ready(function(){
        $('#introduction_video').click(function(){
            $('#myModal .modal-body').html(`<video width="100%" height="315" controls> <source src="{{ URL::to('storage/app/public/puja_video/').'/'.@$puja->puja_video }}" type="video/mp4">
                     Your browser does not support the video tag.</video>`);
            $('#myModal').modal('show');
        });
        $("#myModal").on('hidden.bs.modal', function (e) {
            $('#myModal .modal-body').empty();
        });
        $("#edit_zip").hide();

        $('#ch_zip').click(function(e){
            var zipCode = $('#zipCode').val();
            if(zipCode!=''){
               

                $.ajax({
                    url: '{{ route("search.puja.details.check.zip") }}',
                    dataType: 'json',
                    type:'post',
                    data: {
                        pujaId: '{{@$puja->id}}',
                        _token: '{{ csrf_token() }}',
                        zipCode : zipCode
                    },
                    success: function( response ) {
                        
                        console.log(response['result']);
                        if(response['result']['success']!=null){
                            $('#offline_puja_location-success').html(response.result.success);
                            $('#offline_puja_location-success').css('display','block');
                            // $('#edit_zip').show();
                            $('#ch_zip').show();
                            // $("#zipCode").prop("readonly", true);
                            $('#offline_puja_location-success').css('color','green');
                             $('.gan_puja_sec').css('display','block');
                             $('#zipcode_inner_id').val(zipCode);
                             $('#manner_of_puja').val('OFFLINE');
                             $('#offline_location').css('display','block');
                             $('#offline_puja_location-error').css('display','none');
                             $('#mantra_form').show();
                             $('#addit_man_list').show();
                             $('#landmark_show').show();
                             $('#flat_show').css('display','block');
                             $('#offline_date_div').show();
                             $('#online_date_div').hide();

                        }
                        else{
                            $('#offline_puja_location-error').html(response.result.error);
                            $('#offline_puja_location-error').css('display','block');
                            $('#offline_puja_location-error').css('color','red');
                            $('.gan_puja_sec').css('display','none');
                            $('#offline_puja_location-success').css('display','none');
                            $('#mantra_form').hide();
                            $('#addit_man_list').hide();
                            $('#online_date_div').show();
                        }
                    }
                });
            
            }else{
                $('#offline_puja_location-error').html('Enter Zip Code');
                $('#offline_puja_location-error').css('display','block');
                $('#offline_puja_location-error').css('color','red');
                $('.gan_puja_sec').css('display','none');
                $('#offline_puja_location-success').css('display','none');
                $('#mantra_form').hide();
                $('#addit_man_list').hide();
                $('#online_date_div').show();
            }
        });
        // $('#zipCode').click(function(){
        //     if ( $('#zipCode').is('[readonly]') ) {

        //     }else{
        //         $('#offline_puja_location-error').css('display','none');
        //     }
        // })
        // $('#edit_zip').click(function(){
        //     $('#ch_zip').show();
        //     $('#edit_zip').hide();
        //     $('#offline_puja_location-error').css('display','none');
        //     $("#zipCode").prop("readonly", false);
        //     $('.gan_puja_sec').css('display','none');
        //     $('#manner_of_puja').val('ONLINE');
        // })
    });
</script>
<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( ".datepicker1" ).datepicker({
            maxDate:'-1D',
            changeYear: true,
            yearRange: "1930:2021"
        });
         $('.ui-datepicker').addClass('notranslate');
    });
    $( function() {
        $( ".datepicker2" ).datepicker({
            minDate:'+1D',
            changeYear: true,
            yearRange: "2021:2024"
        });
         $('.ui-datepicker').addClass('notranslate');
    });
    $( document ).ready(function() {
    //     $(".owl-carousel").owlCarousel({
    //     //  items: 1,
    //      loop: true,
    //      mouseDrag: false,
    //      touchDrag: false,
    //      pullDrag: false,
    //      rewind: true,
    //      autoplay: true,
    //      margin: 2,
    //      responsive:{
    //     0:{
    //         items:1,
    //     },
    //     500:{
    //         items:2,
    //     },
    //     767:{
    //         items:3,
    //     },
    //     993:{
    //         items:1,
    //     }
    // }
    //  });
    });
</script>




{{-- <script type="text/javascript">
   
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;
    
        $("#dynamicform").append(`<div class="col-md-6 col-sm-6" id="removeform`+i+`"> <div class="custom_div_class"><div class="row"><div class="col-md-12 col-sm-6"><div class="form_box_area"><input type="text" placeholder="Name" name= "addmore[`+i+`][name]" class="customer_name"></div></div><div class="col-md-12 col-sm-6"><div class="form_box_area">
            <input type="text" placeholder="Date of Birth" class="position-relative datepicker_puja" name="addmore[`+i+`][dob]" id="datepicker`+i+`" readonly>
            </div></div>
            <div class="col-md-12 col-sm-6">
            <div class="form_box_area">
            <select name="addmore[`+i+`][nakshatra]" class="customer_nakshatra">
             <option value="">Select Janam Nakshatra</option>
             @foreach(@$nakshatra as $value)
             <option value="{{@$value->id}}">{{@$value->name}}</option>
             @endforeach
             </select>
            </div>
            </div>

            <div class="col-md-12 col-sm-6"><div class="form_box_area">
            <select class="customer_rashi" name="addmore[`+i+`][rashi]">
            <option value="">Select Rashi</option>
            @foreach(@$rashi as $value)
             <option value="{{@$value->id}}">{{@$value->name}}</option>
            @endforeach
            </select>
            </div>
            </div>

            <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                  <select name="addmore[`+i+`][gotra]" class="customer_gotra">
                                      <option value="">Select Gotra</option>
                                      @foreach(@$gotra as $value)
                                      <option value="{{@$value->id}}">{{@$value->gotra_name_en}}</option>
                                      @endforeach
                                  </select>
                                </div>
                            </div>

              <div class="col-md-12 col-sm-6">
                                <div class="form_box_area">
                                  <input type="text" name="addmore[`+i+`][residence]" placeholder="Place of residence" class="customer_residence">
                                </div>
                            </div>              

            <div class="col-sm-12"><div><a name="remove" id="`+i+`" class="pag_btn btn_remove" style="color:white"><i class="fa fa-minus-circle" aria-hidden="true"></i> Remove</a></div></div></div></div></div>`);
        
    });


   
    $(document).on('click', '.btn_remove', function(){  
         var id = $(this).attr("id");  
        $('#removeform'+id+'').remove();  
    });  
   
</script> --}}


<script type="text/javascript">
$(document).ready(function() {

$.validator.addMethod(
     "customerName", //name of a virtual validator
     $.validator.methods.required, //use the actual email validator
     "Please enter your name"
);

$.validator.addMethod(
     "dateOfBirth", //name of a virtual validator
     $.validator.methods.required, //use the actual email validator
     "Please select your date of birth"
);


$.validator.addMethod(
     "nakshatra", //name of a virtual validator
     $.validator.methods.required, //use the actual email validator
     "Please select your janam nakshatra"
);

$.validator.addMethod(
     "rashi", //name of a virtual validator
     $.validator.methods.required, //use the actual email validator
     "Please select your rashi"
);

$.validator.addMethod(
     "gotra", //name of a virtual validator
     $.validator.methods.required, //use the actual email validator
     "Please select your gotra"
);

$.validator.addMethod(
     "pujaDate", //name of a virtual validator
     $.validator.methods.required, //use the actual email validator
     "Please select puja date"
);

$.validator.addMethod(
     "residence", //name of a virtual validator
     $.validator.methods.required, //use the actual email validator
     "Please enter your residence"
);



// new-rules//////////////////////////////////////////
// $.validator.addClassRules('datepicker_puja', {
//         dateOfBirth: function(element) {
//         return ($(".prv_check").length<1 );
//     }
//   });




// // end-new-rules/////////////////////////////////////////////////













// // Now you can use the addClassRules and give a custom error message as well.

// $.validator.addClassRules(
//    "customer_name", //your class name
//    { customerName: true }
//  );



// $.validator.addClassRules(
// "datepicker_puja", //your class name
//   { dateOfBirth: true }
//  );


// $.validator.addClassRules(
//    "customer_nakshatra", //your class name
//    { nakshatra: true }
//  );

// $.validator.addClassRules(
//    "customer_rashi", //your class name
//    { rashi: true }
//  );

// $.validator.addClassRules(
//    "customer_gotra", //your class name
//    { gotra: true }
//  );

// $.validator.addClassRules(
//    "puja_date_picker", //your class name
//    { pujaDate: true }
//  );
 
//  $.validator.addClassRules(
//    "customer_residence", //your class name
//    { residence: true }
//  );





// old-rules////////////////////////////////////////////////////////////////////////////////////

//     $.validator.addClassRules('customer_nakshatra', {
//     required: true,
//   });



// $.validator.addClassRules('customer_rashi', {
//     required: true,
//   });        
// $.validator.addClassRules('customer_residence', {
//     required: true,
//   });
// $.validator.addClassRules('customer_gotra', {

//     required: true,
//   });
//  $.validator.addClassRules('datepicker_puja', {
//     required: true,
//   });
//   $.validator.addClassRules('puja_date_picker', {
//     required: true,
//   });
  //validate the form
  $('#add_more_form').validate({
    rules:{
        name:{
            required:true,
        },
        // dob:{
        //     required:true,
        // },
        // nakshatra:{
        //     required:true,
        // },
        // rashi:{
        //     required:true,
        // },
        // gotra:{
        //     required:true,
        // },
        residence:{
            required:true,
        },
    },
    submitHandler:function(form){
      var name = $('#customer_name').val();
      var dob  = $('#datepicker').val();
      var nakshatra = $('#nakshatra').val();
      var rashi = $('#rashi').val();
      var gotra = $('#gotra').val();
      var residence = $('#residence').val(); 
      var user_id_puja = $('#user_id_puja').val();
      var puja_name_id = $('#puja_name_id').val();
      if ($('#save').prop("checked")) {
        $('#check_val').val(1)
      }else{
        $('#check_val').val(0)
      }
      var check = $('#check_val').val();
     
      $.ajax({
        url:"{{route('user.puja.add.temp-names')}}",
        type:"POST",
        data:{
        "_token": "{{ csrf_token() }}",
        user_id_puja:user_id_puja,
        puja_name_id:puja_name_id,
        name:name,
        dob:dob,
        rashi:rashi,
        nakshatra:nakshatra,
        gotra:gotra,
        residence:residence,
        check:check,
      },
       success:function(data)
        {
        console.log(data);
        // return false;
          fetch();
          $('#succss').html(data);
           $('#add_more_form').trigger('reset');
       }
     })
    }    
  });

});
</script>


<script>
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('offline_puja_location');

        var options = {
          types: ['establishment']
        };

        var input = document.getElementById('offline_puja_location');
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place)
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#lat').val(place.geometry.location.lat());
            $('#lng').val(place.geometry.location.lng());
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
            $('.exct_btn').show();
            console.log(place.address_components);
            initMap();
        });
        initMap();
    }
</script>

<script>

    function initMap() {
        geocoder = new google.maps.Geocoder();
        var lat = $('#lat').val();
        var lng = $('#lng').val();
        var myLatLng = new google.maps.LatLng(lat, lng);
        // console.log(myLatLng);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Choose hotel location',
          draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(evt,status){
        $('#lat').val(evt.latLng.lat());
        $('#lng').val(evt.latLng.lng());
        var lat_1 = evt.latLng.lat();
        var lng_1 = evt.latLng.lng();
        var latlng = new google.maps.LatLng(lat_1, lng_1);
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#offline_puja_location').val(results[0].formatted_address);
                }
            });


        });
    }
    </script>




<script type="text/javascript">
    $(document).ready(function(){
        $('.login_click').click(function(){
            $("#login-modal").modal("show");
        });
       });     
</script>

<script type="text/javascript">
    $('input[type=radio][name=type_puja]').change(function() {

    if (this.value == 'ONLINE') {
        $('.gan_puja_sec').css('display','block');
        $('#zip_check_id').css('display','none');
        $('#manner_of_puja').val(this.value);
        $('#offline_location').css('display','none');
        $('#landmark_show').hide();
        $('#flat_show').hide();
        $('#offline_puja_location-success').css('display','none');
         $('#offline_puja_location-error').css('display','none');
         $('#mantra_form').show();
         $('#offline_date_div').hide();
         $('#online_date_div').show();
        // location.reload(); 

    }else if (this.value == 'OFFLINE') {
       var zipCode=  $('#zipCode').val();
                    if(zipCode!=''){
                $.ajax({
                    url: '{{ route("search.puja.details.check.zip") }}',
                    dataType: 'json',
                    type:'post',
                    data: {
                        pujaId: '{{@$puja->id}}',
                        _token: '{{ csrf_token() }}',
                        zipCode : zipCode
                    },
                    success: function( response ) {
                        console.log(response['result']);
                        if(response['result']['success']!=null){
                            $('#offline_puja_location-success').html(response.result.success);
                            // $('#offline_puja_location-success').css('display','block');
                            // $('#edit_zip').show();
                            $('#ch_zip').show();
                            // $("#zipCode").prop("readonly", true);
                            // $('#offline_puja_location-success').css('color','green');
                             $('.gan_puja_sec').css('display','block');
                             $('#addit_man_list').show();
                             $('#mantra_form').show();
                             $('#zipcode_inner_id').val(zipCode);
                             $('#manner_of_puja').val('OFFLINE');
                             $('#offline_location').css('display','block');
                             $('#landmark_show').show();
                             $('#flat_show').css('display','block');
                             $('#offline_date_div').show();
                             $('#online_date_div').hide();
                             // $('#offline_puja_location-error').css('display','none');

                        }
                        else{
                            $('#offline_puja_location-error').html(response.result.error);
                            $('#offline_puja_location-error').css('display','block');
                            $('#offline_puja_location-error').css('color','red');
                            $('.gan_puja_sec').css('display','none');
                            $('#addit_man_list').hide();
                             $('#mantra_form').hide();
                            $('#offline_puja_location-success').css('display','none');
                           
                        }
                    }
                });
            }
        $('#zip_check_id').css('display','block');
        $('.gan_puja_sec').css('display','none');
        $('#addit_man_list').hide();
        $('#mantra_form').hide();
    }

});
</script>
<script type="text/javascript">
    $('.show-more-review').click(function() {
  $('.more-review').slideToggle();
  if ($('.show-more-review').text() == "Show More Reviews +") {
    $(this).text("Show More Reviews +")
  } else {
    $(this).text("Show Less Reviews -")
  }
});
</script>

<script type="text/javascript">
    $('#add_previous').on('click',function(e){
        $('#previous_customer').css('display','block');
        $('#add_previous').css('display','none');
        $('#hide_previous').css('display','block');
    })

    $('#hide_previous').on('click',function(e){
        $('#previous_customer').css('display','none');
        $('#add_previous').css('display','block');
        $('#hide_previous').css('display','none');
    })
</script>



{{-- <script type="text/javascript">
  $(document).ready(function(){
    $('#add_more_form').on('submit',function(e){
      e.preventDefault();
      var name = $('#customer_name').val();
      var dob  = $('#datepicker').val();
      var nakshatra = $('#nakshatra').val();
      var rashi = $('#rashi').val();
      var gotra = $('#gotra').val();
      var residence = $('#residence').val(); 
      var user_id_puja = $('#user_id_puja').val();
      var puja_name_id = $('#puja_name_id').val();
      $.ajax({
        url:"{{route('user.puja.add.temp-names')}}",
        type:"POST",
        data:{
        "_token": "{{ csrf_token() }}",
        user_id_puja:user_id_puja,
        puja_name_id:puja_name_id,
        name:name,
        dob:dob,
        rashi:rashi,
        nakshatra:nakshatra,
        gotra:gotra,
        residence:residence,
      },
       success:function(data)
        {
            console.log(data);
          // fetch();
          $('#succss').html(data);
           $('#add_more_form').trigger('reset');
       }
     })
    });
});
</script> --}}
@if(Auth::check())
<script type="text/javascript">

function fetch(){
 $.get(
                  "{{route('user.puja.show.tempnames')}}",
                  {user_id:{{auth()->user()->id}},puja_id:{{@$puja->id}} },
                  function(data) {
                    console.log(data.length);

            $('#live_added_names').html('');
            if (data.length>0) {
            $.each(data,function(key,value){
                var html=`<li id="remove_temp_customer_`+value.id+`">   
                                <label class="list_checkBox newdes">
                                <div class="alldata">
                                <div>
                                    <span>`+value.name+`</span>
                                </div>` 
                                if(value.dob != null){
                                html=html+`<div>
                                    <b>, Dob:</b> <span>`+value.dob+`</span>
                                </div>`;
                                 }
                               html=html+`<div>
                                    <span>, `+value.place_of_residence+`</span>
                                </div>`;
                                console.log(value.janam_nakshatra );
                                if(value.janam_nakshatra != null){
                                    html=html+`<div>
                                   <span>, `+value.nakshatras.name+`</span>
                                </div>`;
                                }
                                if(value.janam_rashi != null){
                                html=html+`<div>
                                   <span>, `+value.rashis.name+`</span>
                                </div>`; 
                                }
                                if(value.gotra != null){
                                html=html+`<div>
                                   <span>, `+value.gotra+`</span>
                                </div>`;
                                 }
                                html=html+`</div>
                               

                                <div class="new-cross"><div><a name="remove" id="`+value.id+`" class="pag_btn btn_remove" style="color:white"><i class="fa fa-times" aria-hidden="true"></i></a></div></div>   

                                
                            </label>
                                
                            </li>


                ` ;

              $('#live_added_names').append(html);
            })
          }else{
            $('#live_added_names').append(
                `
                    <li>   
                                <label class="list_checkBox">
                                <div>
                                    <span>No person name added</span>
                                </div> `
                );
          }
                  }
               );


}

function remove(){
     $.get(
         "{{route('user.delete.data.temp-table')}}",
          {user_id:{{auth()->user()->id}},puja_id:{{@$puja->id}} },
          function(data) {
            $('#live_added_names').html('');
            $('#live_added_names').append(
                `
                    <li>   
                                <label class="list_checkBox">
                                <div>
                                    <span>No person name added</span>
                                </div> `
                );


          }
       );
}

remove();
</script>


<script type="text/javascript">
        $(document).on('click', '.btn_remove', function(){  
         var id = $(this).attr("id");  
             $.ajax({
            url:"{{route('user.puja.delete.tempnames')}}",
            type:"GET",
            data:{id:id},
            success:function(data)
            {
                console.log(data);
             if (data==0) {   
             $('#remove_temp_customer_'+id+'').remove(); 
             fetch();
             }else{
              $('#remove_temp_customer_'+id+'').remove(); 
               $('#check_box_'+data+'').attr("checked", false);
               fetch();
             } 
            }
        });
        
    });  
</script>



<script type="text/javascript">
    $(document).on('click','.prv_check',function(){
        var id = $(this).attr("value");
        if($(this).prop("checked") == true){
        $.ajax({
        url:"{{route('user.puja.insert.checkbox')}}",
        type:"POST",
        data:{
        "_token": "{{ csrf_token() }}",
        id:id,
        user_id:{{auth()->user()->id}},puja_id:{{@$puja->id}}
       },
       success:function(data)
        {
            console.log(data);
            fetch();
          // $('#succss').html(data);
          //  $('#add_more_form').trigger('reset');
       }
     })
    }else{

        $.ajax({
        url:"{{route('user.puja.delete.checkbox')}}",
        type:"POST",
        data:{
        "_token": "{{ csrf_token() }}",
        id:id,
       },
       success:function(data)
        {
            console.log(data);
            fetch();
        }
     })
    }

    })
</script>


<script type="text/javascript">
    $('#mail_puja_form').validate({
    submitHandler:function(form){
     var puja_date_picker_offline = $('#puja_date_picker_offline').val();
     var puja_date_picker_online = $('#puja_date_picker_online').val();
     var offline_puja_location = $('#offline_puja_location').val();
     var landmark = $('#landmark').val();
     var house_no = $('#house_no').val();
     var manner_of_puja = $('#manner_of_puja').val();
     var puja_actual_price = $('#puja_actual_price').val();
     var dakshina = $('#dakshina').val();
     
     if (dakshina<0 && $.isNumeric(dakshina) && dakshina!="") {
      alert('Please enter dakshina properly');
      return false;
    }
     
     else if (manner_of_puja=="OFFLINE" && puja_date_picker_offline=='') {
        alert('Please select puja date');
        return false;
     }
     else if (manner_of_puja=="ONLINE" && puja_date_picker_online=='') {
        alert('Please select puja date');
        return false;
     }
     else if (manner_of_puja=="OFFLINE" && offline_puja_location=='') {
        alert('Please enter puja location');
        return false;
     }
     else{
        if (manner_of_puja=="OFFLINE"){ 
        $('#puja_date_id').val(puja_date_picker_offline);
        }else{
           $('#puja_date_id').val(puja_date_picker_online); 
        }
        $('#puja_location_id').val(offline_puja_location);
        $('#puja_price').val(puja_actual_price);

        $('#landmark_id').val(landmark);
        $('#house_id').val(house_no);

        $.ajax({
            url:'{{route('user.puja.check.temp.customer')}}',
            method:'GET',
            data:{id:'{{auth()->user()->id}}'},
            success:function(data)
            {
              console.log(data);
              // return false;
               if (data=="false") {
                alert('Please add customer name for puja booking');
                return false;
               }else{
                form.submit();
               }
            }

        });

        // form.submit();
     }

    }    
  });

</script>

{{-- ajax-mantra --}} 
<script type="text/javascript">
  $(document).ready(function(){
    $('#mantra').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();
      $.ajax({
        url:'{{route('user.puja.get-mantra-recitals')}}',
        type:'GET',
        data:{mantra:id},
        success:function(data){
          console.log(data);
          $('#mantra_recitals').html(data.recitals);
        }
      })
    })
  })
</script>

<script type="text/javascript">
    $(document).ready(function(){


     $('#mantra_form').validate({
    rules:{
        mantra:{
            required:true,
        },
        mantra_recitals:{
            required:true,
        },
    },
    messages:{
        mantra:{
            required:'Please select mantra',
        },
        mantra_recitals:{
            required:'Please select mantra recitals',
        },
    },
        submitHandler:function(form){
      var mantra = $('#mantra').val();
      var recitals  = $('#mantra_recitals').val();
      var puja = '{{@$puja->id}}';
      $.ajax({
        url:"{{route('user.puja.add.additional-mantra')}}",
        type:"POST",
        data:{
        "_token": "{{ csrf_token() }}",
        mantra:mantra,
        recitals:recitals,
        puja:puja,
       },
       success:function(data)
        {
        if (data.message=="duplicate") {
            $('#duplicate_error').css('display','block');
            // alert('This already added');
        }else{    

         var pujaPrice = $('#puja_actual_price').val();
         var price = data.price;
         var sum = +pujaPrice + +price;
         // console.log(sum);
         $('#price_price').html(sum.toFixed(2));
         $('#puja_actual_price').val(sum.toFixed(2));
         $('#pric_ypu').show();
         $('#duplicate_error').hide();
         mantra_fetch();
         $('#mantra_form').trigger('reset');
       }
        }
     })
    }    



 });
})
</script>

@if(Auth::check())
<script type="text/javascript">

function mantra_fetch(){
 $.get(
                  "{{route('user.puja.added-mantra-list')}}",
                  {user_id:{{auth()->user()->id}},puja_id:{{@$puja->id}} },
                  function(response) {
                    console.log(response);

            $('#addit_man_list').html('');
            if (response.length>0) {
            $.each(response,function(key,value){

              $('#addit_man_list').append(
                `<div class="custom_list" id="remove_mantra`+value.id+`">
                   <ul>
                        <li><b>Additional Mantra:</b> `+value.mantra.mantra+`</li>
                        <li><b>No of Recitals:</b> `+value.no_of_recital+`( @if(@session()->get('currency')==1)Rs @else {{@session()->get('currencyCode')}} @endif`+value.price+`)</li>
                    
                   
                   </ul>
                    <a href="javascript:;" class="pag_btn sll_btn remove_matra" id="`+value.id+`"><i class="fa fa-times"></i></a>
                    </div>

                `    
            );
            })
          }else{
            $('#addit_man_list').append(
                `<div class="custom_list">
                   <ul>
                        <li><b>No Mantra Added</b></li>
                        
                    </ul>
                    </div>`
                );
              }
            }
          );


}

</script>

<script type="text/javascript">
        $(document).on('click', '.remove_matra', function(){  
         var id = $(this).attr("id");  
             $.ajax({
            url:"{{route('user.puja.delete.mantra.list')}}",
            type:"GET",
            data:{id:id},
            success:function(data)
            {
            console.log(data);
              var pujaPrice = $('#puja_actual_price').val();
              var price = data;
              var minus = pujaPrice-price;
              $('#price_price').html(minus.toFixed(2));
              $('#puja_actual_price').val(minus.toFixed(2));
             $('#remove_mantra'+id+'').remove(); 
               mantra_fetch();
             }
        });
        
    });  
</script>


@endif

@endif

<script type="text/javascript">
$(document).ready(function() {
 $('input[type=radio][name=homam_radio]').change(function() {
    var pujaPrice = $('#puja_actual_price').val();
    var homam_price = $('#homam_price').val();
    // alert(pujaPrice);
   if (this.value == 'Y') {
    var sum = +pujaPrice + +homam_price;
    $('#price_price').html(sum.toFixed(2));
    $('#puja_actual_price').val(sum.toFixed(2));
    $('#homam_status').val('Y');
    $('#pric_ypu').show();
   }else{
     var minus = pujaPrice-homam_price;
     $('#price_price').html(minus.toFixed(2));
     $('#puja_actual_price').val(minus.toFixed(2));
     $('#homam_status').val('N');
   }
 });
  
 });
 </script>

 {{-- cd-radio --}}

 <script type="text/javascript">
$(document).ready(function() {
 $('input[type=radio][name=cd_radio]').change(function() {
    var pujaPrice = $('#puja_actual_price').val();
    var cd_price = $('#cd_price').val();
    // alert(pujaPrice);
   if (this.value == 'Y') {
    var sum = +pujaPrice + +cd_price;
    $('#price_price').html(sum.toFixed(2));
    $('#puja_actual_price').val(sum.toFixed(2));
    $('#cd_status').val('Y');
    $('#pric_ypu').show();
   }else{
     var minus = pujaPrice-cd_price;
     $('#price_price').html(minus.toFixed(2));
     $('#puja_actual_price').val(minus.toFixed(2));
     $('#cd_status').val('N');
   }
 });
  
 });
 </script>

 {{-- live-streaming --}}
  <script type="text/javascript">
$(document).ready(function() {
 $('input[type=radio][name=live_streaming_radio]').change(function() {
    var pujaPrice = $('#puja_actual_price').val();
    var live_streaming_price = $('#live_streaming_price').val();
    // alert(pujaPrice);
   if (this.value == 'Y') {
    var sum = +pujaPrice + +live_streaming_price;
    $('#price_price').html(sum.toFixed(2));
    $('#puja_actual_price').val(sum.toFixed(2));
    $('#live_streaming_status').val('Y');
    $('#pric_ypu').show();
   }else{
     var minus = pujaPrice-live_streaming_price;
     $('#price_price').html(minus.toFixed(2));
     $('#puja_actual_price').val(minus.toFixed(2));
     $('#live_streaming_status').val('N');
   }
 });
  
 });
 </script>

 {{-- prasad --}}
 <script type="text/javascript">
 $(document).ready(function() {
 $('input[type=radio][name=prasad_radio]').change(function() {
    var pujaPrice = $('#puja_actual_price').val();
    var prasad_price = $('#prasad_price').val();
    // alert(pujaPrice);
   if (this.value == 'Y') {
    var sum = +pujaPrice + +prasad_price;
    $('#price_price').html(sum.toFixed(2));
    $('#puja_actual_price').val(sum.toFixed(2));
    $('#prasad_status').val('Y');
    $('#pric_ypu').show();
   }else{
     var minus = pujaPrice-prasad_price;
     $('#price_price').html(minus.toFixed(2));
     $('#puja_actual_price').val(minus.toFixed(2));
     $('#prasad_status').val('N');
   }
 });
  
 });
 </script>

 <script type="text/javascript">
  $('#dakshina').on('keyup',function(e){
   var pujaPrice = $('#puja_actual_price').val();
   var dakshina = $('#dakshina').val();
   if (dakshina!="") {
    if (dakshina<0) {
      alert('Please enter dakshina properly');
      return false;
    }
    var sum = +pujaPrice + +dakshina-$('#dakshina_prev').val();
    $('#price_price').html(sum.toFixed(2));
    $('#puja_actual_price').val(sum.toFixed(2));
    $('#pric_ypu').show();
    $('#priest_dakshina').val(dakshina);
    $('#dakshina_prev').val(dakshina);
   }else{
    var dakshina_prev = $('#dakshina_prev').val();
    var pujaPrice = $('#puja_actual_price').val();
    var minus = pujaPrice-dakshina_prev;
     $('#price_price').html(minus.toFixed(2));
     $('#puja_actual_price').val(minus.toFixed(2));
     $('#pric_ypu').show();
     $('#dakshina_prev').val(0);
     $('#priest_dakshina').val(0);

   }
   });
</script> 

{{-- <script type="text/javascript">
$(document).on('click', '.nav-link.active', function() {
  var href = $(this).attr('href').substring(1);
  //alert(href);
  $(this).removeClass('active');
  $('.tab-pane[id="' + href + '"]').removeClass('active');

});
</script> --}}
@endsection

