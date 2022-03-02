@extends('layouts.app')

@section('title')
<meta name="title" content="{{@$horoscope_details->meta_title?@$horoscope_details->meta_title:@$horoscope_details->name}}">
<meta name="description" content="{{@$horoscope_details->meta_description?strip_tags(@$horoscope_details->meta_description):strip_tags(@$horoscope_details->about_report)}}">
<meta property="og:title" content="Puja | {{@$horoscope_details->name }}">
<meta property="og:description" content="{{ substr(strip_tags(@$horoscope_details->about_report),0,150) }}">
@if(@$horoscope_details->image)
<meta property="og:image" content="{{ URL::to('storage/app/public/horoscope_image')}}/{{$horoscope_details->image}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/videos2.jpg')}}" alt="">
@endif
<meta property="og:url" content="{{route('horoscope.details', ['slug'=>$horoscope_details->slug])}}">
<title>Horoscope | {{@$horoscope_details->meta_title?@$horoscope_details->meta_title:@$horoscope_details->name }}</title>
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
                                 <li><a href="{{route('hororscope.all.category')}}"> {{@$horoscope_details->category->name}} </a> <span>               </span></li>
								 @if(@$horoscope_details->subcategory)
                                 <li><a href="{{route('hororscope.sub.category',['id'=>$horoscope_details->category->id])}}">&nbsp; /  &nbsp; {{@$horoscope_details->subcategory->name}} </a><span>             </span></li>
								@endif
								@if(@$horoscope_details->title)
                                 <li><a href=" @if(@$horoscope_details->subcategory) {{route('horoscope.title.get',['cat'=>@$horoscope_details->subcategory->id])}} @else {{route('horoscope.category.title.get',['id'=>@$horoscope_details->category->id])}} @endif">&nbsp; /  &nbsp; {{@$horoscope_details->title->title}} </a><span>             </span></li>
								@else
									<li><a href="javascript:void(0);">&nbsp; /  &nbsp; {{@$horoscope_details->name}} </a><span>             </span></li>
								@endif
                                 <li><span>&nbsp; /  &nbsp; {{@$horoscope_details->code}}</span></li>
                                 <div class="clearfix"></div>
                              </ul>
                           </div>
                           <div class="details-captions page_banner_data">
                              <h1>{{@$horoscope_details->name}}</h1>
                              <p style="white-space:pre-wrap;">{!!@$horoscope_details->about_report!!}</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <ul class="nav nav-tabs" role="tablist">   
						   @if(@$horoscope_details->significance!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$horoscope_details->significance!="") show active @endif" data-toggle="tab" href="#home">Significance and Benefits</a>
                              </li>
                              @endif
                              @if(@$horoscope_details->who_how_when!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$horoscope_details->significance=="" && @$horoscope_details->who_how_when!="") show active @endif" data-toggle="tab" href="#menu1" id="who_when_tab">Who, How & When </a>
                              </li>
                              @endif

                              {{-- @if(@$horoscope_details->related_mantra!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$horoscope_details->significance=="" && @$horoscope_details->who_how_when=="" && @$horoscope_details->related_mantra!="") show active @endif" data-toggle="tab" href="#menu2" id="mantra_tab">Related Mantra</a>
                              </li>
                              @endif
                              @if(@$horoscope_details->usages!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$horoscope_details->significance=="" && @$horoscope_details->who_how_when=="" && @$horoscope_details->related_mantra=="" && @$horoscope_details->usages!="") show active @endif" data-toggle="tab" href="#menu3" id="usage_tab">Usage </a>
                              </li>
                              @endif   --}}                         
                              @if(@$all_faq_cat->isNotEmpty())
                              <li class="nav-item">
                                 <a class="nav-link @if($horoscope_details->significance=='' && $horoscope_details->who_how_when=='' && $horoscope_details->related_mantra=='' && $horoscope_details->usages=='') show active @endif" data-toggle="tab" href="#menu5" id="faq_tab">FAQ</a>
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
					 <div id="home" class="container tab-pane  @if(@$horoscope_details->significance!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Significance and Benefits</h2>
                              <p style="white-space:pre-wrap;">{!!@$horoscope_details->significance!!}</p>
                        </div>
                        </div>

                        <div id="menu1" class="container tab-pane @if(@$horoscope_details->significance=="" && @$horoscope_details->who_how_when!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Who, How & When  </h2>
                              <p style="white-space:pre-wrap;">{!!@$horoscope_details->who_how_when!!}</p>
                           </div>
                        </div>

                        <div id="menu2" class="container tab-pane @if(@$horoscope_details->significance=="" && @$horoscope_details->who_how_when=="" && @$horoscope_details->related_mantra!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Related Mantra</h2>
                              <p style="white-space:pre-wrap;">{!!@$horoscope_details->related_mantra!!}</p>
                           </div>
                        </div>
                        <div id="menu3" class="container tab-pane @if(@$horoscope_details->significance=="" && @$horoscope_details->who_how_when=="" && @$horoscope_details->related_mantra=="" && @$horoscope_details->usages!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Usage</h2>
                              <p style="white-space:pre-wrap;">{!!@$horoscope_details->usages!!}</p>
                           </div>
                        </div>
                        @if(@$all_faq_cat->isNotEmpty())
                        <div id="menu5" class="container tab-pane @if($horoscope_details->significance=='' && $horoscope_details->who_how_when=='' && $horoscope_details->related_mantra=='' && $horoscope_details->usages=='') show active @else fade @endif">
                           @foreach(@$all_faq_cat as $key=>$faq)
							<span class="faq-cat-details">{{@$faq->parent->faq_category}} > {{@$faq->faq_category}}</span>
							   <div class="accordian-faq">
								  <div class="accordion" id="faq">
								  @if(@$faq->all_faq->isNotEmpty())
									 @php $count= 1 @endphp
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
                            <em>@if(@$horoscope_details->image) <img src="{{ URL::to('storage/app/public/horoscope_image')}}/{{$horoscope_details->image}}" alt=""> @else <img src="{{ URL::to('public/frontend/images/videos2.jpg')}}" alt=""> @endif</em>
                            <div class="media-body">
                                <h4>{{@$horoscope_details->name}}</h4>
                                @if(@session()->get('currency')==1)
                                @if(@$horoscope_details->discount_inr!=null && @$horoscope_details->discount_inr>0)
                                @php
                                $old_price = $horoscope_details->price_inr;
                                $discount_value = ($old_price / 100) * @$horoscope_details->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <p >Price - <del>{{@session()->get('currencySym')}}  {{@$horoscope_details->price_inr}} </del> &nbsp;  <span class="price">{{@session()->get('currencySym')}} {{round(@$new_price,2)}} </span> ({{@$horoscope_details->discount_inr}}% OFF)</p>
                                @else
                                <p>Price - {{@session()->get('currencySym')}}  {{@$horoscope_details->price_inr}}</p>
                                @endif
                                @else
                                @if(@$horoscope_details->discount_usd!=null && @$horoscope_details->discount_usd>0)
                                @php
                                $old_price = @$custom * $horoscope_details->price_usd;
                                $discount_value = ($old_price / 100) * @$horoscope_details->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <p >Price - <del>{{@session()->get('currencySym')}}  {{round(@$custom * @$horoscope_details->price_usd,2)}} </del> &nbsp;  <span class="price">{{@session()->get('currencySym')}}  {{round(@$new_price,2)}} </span> ({{@$horoscope_details->discount_usd}}% OFF)</p>
                                @else
                                <p>Price - {{@session()->get('currencySym')}}  {{round(@$custom * @$horoscope_details->price_usd,2)}}</b></p>
                                @endif
                                
                                @endif

                                
                     
                     
                     @if(@session()->get('currency')==1)
                    @if(@$horoscope_details->discount_inr!=null && @$horoscope_details->discount_inr>0)
                                @php
                                $old_price = $horoscope_details->price_inr;
                                $discount_value = ($old_price / 100) * @$horoscope_details->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{@$horoscope_details->price_inr}}">
                               
                     @endif
                     @else
                     @if(@$horoscope_details->discount_usd!=null && @$horoscope_details->discount_usd>0)
                                 @php
                                $old_price = @$custom * $horoscope_details->price_usd;
                                $discount_value = ($old_price / 100) * @$horoscope_details->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{round(@$new_price,2)}}">
                                @else
                                <input type="hidden" name="puja_actual_price" id="puja_actual_price" value="{{round(@$custom * @$horoscope_details->price_usd,2)}}">
                               
                     @endif
                    
                     @endif    

                             <p> Email Delivery Report will be delivered in 48 Hours.</p> 
                                 @if(@$horoscope_details->is_deliverable=="Y")
                                 <p>Physical Delivey Avaialable : Yes</p>
                                 
                                 @if(@session()->get('currency')==1)
                                 @if(@$horoscope_details->delivery_days_india!='')
                                 <p>Tentative Delivery Date: 
                                    {{@$horoscope_details->delivery_days_india}} days
                                 </p>
                                 @endif
                                 @else
                                 @if(@$horoscope_details->delivery_days_outside_india!='')
                                 <p>Tentative Delivery Date: 
                                    {{@$horoscope_details->delivery_days_outside_india}} days
                                 </p>
                                 @endif
                                @endif
                                @else
                                <p>Physical Delivery Avaialable : No</p>
                                @endif
                              <p>Refundable : @if(@$horoscope_details->refundable=="Y" && @$horoscope_details->refundable_status!="")Yes @else No @endif</p>
                              @if(@$horoscope_details->refundable=="Y" && @$horoscope_details->refundable_status!="")
                              <p>Refundable Status : @if(@$horoscope_details->refundable_status=="E")Exchange Only @elseif(@$horoscope_details->refundable_status=="'FR") Fully Refundable @elseif(@$horoscope_details->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif</p>  
                              @endif

                              <p>Expertise : @foreach (@$horoscope_details->horoscopeExpertise as $val) {{@$val->name->expertise_name}} @if (!$loop->last),@endif @endforeach</p>
								<p><a href="@if(@auth()->user()->id) {{route('horoscope.order.now',['slug'=>$horoscope_details->slug])}} @else javscript:void(0); @endif" class="pag_btn" @if(!Auth::check()) data-toggle="modal" data-target="#loginBeforeOrder @endif">Order Now</a></p>

                            </div>
                        </div>
                    </div>
                    <div class="shareBx" >
                        <span><i class="fa fa-share-square-o" aria-hidden="true"></i>{{__('search.share')}}:</span>

                        <ul style="min-width: 160px">
                            <div class="sharethis-inline-share-buttons"></div>
                        </ul>


                    </div>
                    </div>
                    
                </div>
                <div class="about_astro back_white horoscope_report_main">
                    @if(@$horoscope_details->heading_one && @$horoscope_details->description_one)
                    <div class="edu_quli horoscope_report">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_one}}</strong>
                            <span>{!!@$horoscope_details->description_one!!}</span>
                        </div>
                    </div>
                    @endif
					@if(@$horoscope_details->heading_two && @$horoscope_details->description_two)
                    <div class="edu_quli horoscope_report">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_two}}</strong>
                            <span>{!!@$horoscope_details->description_two!!}</span>
                        </div>
                    </div>
                    @endif
					@if(@$horoscope_details->heading_three && @$horoscope_details->description_three)
                    <div class="edu_quli horoscope_report">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_three}}</strong>
                            <span>{!!@$horoscope_details->description_three!!}</span>
                        </div>
                    </div>
                    @endif
					@if(@$horoscope_details->heading_four && @$horoscope_details->description_four)
                    <div class="edu_quli horoscope_report">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_four}}</strong>
                            <span>{!!@$horoscope_details->description_four!!}</span>
                        </div>
                    </div>
                    @endif
                </div>
				@if(@$horoscope_details->heading_five && @$horoscope_details->description_five)
				<div class="about_astro back_white">                    
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_five}}</strong>
                            <span>{!!@$horoscope_details->description_five!!}</span>
                        </div>
                    </div>                    
                </div>
				@endif
				@if(@$horoscope_details->heading_six && @$horoscope_details->description_six)
				<div class="about_astro back_white">                    
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_six}}</strong>
                            <span>{!!@$horoscope_details->description_six!!}</span>
                        </div>
                    </div>                    
                </div>
				@endif
				@if(@$horoscope_details->heading_seven && @$horoscope_details->description_seven)
				<div class="about_astro back_white">                   
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_seven}}</strong>
                            <span>{!!@$horoscope_details->description_seven!!}</span>
                        </div>
                    </div>                    
                </div>
				@endif
				@if(@$horoscope_details->heading_eight && @$horoscope_details->description_eight)
				<div class="about_astro back_white">                   
                    <div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{@$horoscope_details->heading_eight}}</strong>
                            <span>{!!@$horoscope_details->description_eight!!}</span>
                        </div>
                    </div>                    
                </div>
				@endif
                
            </div>

            <div class="ast_det_right bac">
                <div class="ast_det_right_inr">
                    <h6><img src="{{ URL::to('public/frontend/images/check.png')}}" alt="">Similar Horoscopes</h6>
                        @if(@$similar_horoscopes->isNotEmpty())
                        <div class="astro-dash-form new-astropuja">
                            <div class="row similer-puja">
                                <div  style="display: block; width:100%;">
                                    @foreach ($similar_horoscopes as $smhscope)
                                    <div class="item">
                                        <div class="gem-stone-item back_white">
                                            <a href="{{route('horoscope.details',['slug'=>@$smhscope->slug])}}" target="_blank"><span>@if(@$smhscope->image) <img src="{{ URL::to('storage/app/public/horoscope_image')}}/{{$smhscope->image}}" > @else <img src="{{ URL::to('public/frontend/images/videos2.jpg')}}" alt=""> @endif</span></a>
                                            <div class="gem-stone-text">
                                                <h5><a href="{{route('horoscope.details',['slug'=>@$smhscope->slug])}}" target="_blank">@if(strlen(@$smhscope->name) > 20)
                                        {!! substr(@$smhscope->name, 0, 20 ) . '...' !!}
                                        @else
                                        {!! @$smhscope->name !!}
                                        @endif</a></h5>
                                                <p>
                                                    @if(strlen(@$smhscope->about_report) > 60)
                                                    {!! substr(@$smhscope->about_report, 0, 60 ) . '...' !!}
                                                    @else
                                                    {!! @$smhscope->about_report !!}
                                                    @endif
                                                </p>
                                                <ul>
                                                    <li>
                                                    @if(@session()->get('currency')==1)
                                                    @if(@$smhscope->discount_inr!=null && @$smhscope->discount_inr>0)
                                                   @php
                                                    $old_price = $smhscope->price_inr;
                                                    $discount_value = ($old_price / 100) * @$smhscope->discount_inr;
                                                    $new_price = $old_price - $discount_value;
                                                    @endphp
                                                    <del>{{@session()->get('currencySym')}} {{@$smhscope->price_inr}} </del> &nbsp;   {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                    @else
                                                    {{@session()->get('currencySym')}} {{@$smhscope->price_inr}}
                                                    @endif
                                                    @else
                                                    @if(@$smhscope->discount_usd!=null && @$smhscope->discount_usd>0)
                                                    @php
                                                    $old_price = @$custom * $smhscope->price_usd;
                                                    $discount_value = ($old_price / 100) * @$smhscope->discount_usd;
                                                    $new_price = $old_price - $discount_value;
                                                    @endphp
                                                    <del>{{@session()->get('currencySym')}} {{round(@$custom * @$smhscope->price_usd,2)}} </del> &nbsp;  {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                    @else
                                                    {{@session()->get('currencySym')}} {{round(@$custom * @$smhscope->price_usd,2)}}
                                                    @endif
                                                    


                                                    @endif
                                                    </li>
                                                    <li><a href="{{route('horoscope.details',['slug'=>@$smhscope->slug])}}" class="pag_btn" target="_blank">Order Now</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                
                            </div>
                            
                            
                            </div>
                            @endif
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
<div class="modal" tabindex="-1" role="dialog" id="loginBeforeOrder">
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
              <a href="{{route('register')."?ref=".route('horoscope.order.now',['slug'=>$horoscope_details->slug])}}" class="new-register" style="width: 100%;margin-top: 9px" ><img src="{{ URL::to('public/frontend/images/log-user.png')}}"> <p>New User? Click to</p> Sign Up</a>
             </div>
           </div>

            <div class="col-sm-6">

            <div>
              <a href="{{route('login')."?ref=".route('horoscope.order.now',['slug'=>$horoscope_details->slug])}}" class="new-register" style="width: 100%;margin-top: 9px"  ><img src="{{ URL::to('public/frontend/images/add-user.png')}}"> <p>Have an account ?</p> Click to Login</a>
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
@endsection

