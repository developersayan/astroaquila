@extends('layouts.app')

@section('title')
<meta property="og:title" content="{{__('search.astrologer_public_profile_title')}} | {{@$userData->first_name}} {{@$userData->last_name}}">
<meta property="og:description" content="{!! substr(@$userData->about,0,150) !!}">
@if(@$userData->profile_img)
<meta property="og:image" content="{{ asset('storage/app/public/profile_picture/'.@$userData->profile_img) }}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
{{-- <meta property="og:url" content="{{route('business.search.view', $business->slug)}}"> --}}
<meta property="og:url" content="{{route('astrologer.search.publicProfile', ['slug'=>@$userData->slug])}}">
<title>{{__('search.astrologer_public_profile_title')}} | {{@$userData->first_name}} {{@$userData->last_name}}</title>
@endsection

@section('style')
@include('includes.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" rel="stylesheet">
<style>
    /* .clickon{pointer-events:none} */
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
							  @if(@$userData->countries)
                                 <li><a href="{{route('astrologer.search.country')}}">{{@$userData->countries->name}}</a></li>
							 @endif
								 @if(@$userData->states)
									 <li><span>&nbsp;/&nbsp;</span><a href="{{route('astrologer.search.state',['id'=>@$userData->country_id])}}">{{@$userData->states->name}}</a></li>
								 @endif
								 @if(@$userData->astrologerExpertise->isNotEmpty())
									 @foreach(@$userData->astrologerExpertise as $astroexpert)
								 <li><span>&nbsp;/&nbsp;</span><a href="@if(@$userData->states) {{route('astrologer.search.expertise',['id'=>@$userData->states->id,'id1'=>@$userData->country_id])}} @else {{route('astrologer.search.expertise',['id'=>@$userData->country_id])}} @endif">{{@$astroexpert['experties']->expertise_name}}</a></li>
									@endforeach
									 @endif
                                 <div class="clearfix"></div>
                              </ul>
                           </div>
                           <div class="details-captions page_banner_data">
                              <h1>{{@$userData->first_name." ".@$userData->last_name}}</h1>
                              <p style="white-space:pre-wrap;">{!!@$userData->about!!}</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
						<ul class="nav nav-tabs" role="tablist">
						 @if(@$astro_tips->isNotEmpty())
                              <li class="nav-item">
                                 <a class="nav-link show active" data-toggle="tab" href="#menu1" id="who_when_tab">Astro Tips </a>
                              </li>
                              @endif
						   @if(@$userData->why_who)
                              <li class="nav-item">
                                 <a class="nav-link @if(@$astro_tips->isEmpty()) show active @endif" data-toggle="tab" href="#menu2" id="who_when_tab">Why & Who </a>
                              </li>
                              @endif
							  @if(@$all_faq_cat->isNotEmpty())
                              <li class="nav-item">
                                 <a class="nav-link @if(@$astro_tips->isEmpty() && !$userData->why_who) show active @endif" data-toggle="tab" href="#menu4">FAQ</a>
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
					 @if(@$astro_tips->isNotEmpty())
                           <div id="menu1" class="container tab-pane show active">
										  <div class="accordian-tips">
											 <div class="accordion" id="astrotips">
												@php $count= 1@endphp
												@foreach(@$astro_tips as $tips)
												<div class="card">
												   <div class="card-header" id="tipshead{{@$tips->id}}">
													  <a href="#" class="btn btn-header-link acco-chap collapsed" data-toggle="collapse" data-target="#tips{{@$tips->id}}" aria-expanded="true" aria-controls="tips{{@$tips->id}}">
														 <p class="word_wrapper"><span>{{@$count++}}. </span>{{@$tips->heading}}</p>
													  </a>
												   </div>
												   <div id="tips{{@$tips->id}}" class="collapse" aria-labelledby="tipshead{{@$tips->id}}" data-parent="#astrotips">
													  <div class="card-body horoscope_faq_answer">
														 <p style="white-space:pre-wrap;">{!!@$tips->description!!}</p>
													  </div>
												   </div>
												</div>
												@endforeach

											 </div>
										  </div>
									   </div>
						   @endif
						@if(@$userData->why_who)
						<div id="menu2" class="container tab-pane @if(@$astro_tips->isEmpty()) show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Why & Who  </h2>
                              <p style="white-space:pre-wrap;">{!!@$userData->why_who!!}</p>
                           </div>
                        </div>
						@endif
                        @if(@$all_faq_cat->isNotEmpty())
                        <div id="menu4" class="container tab-pane @if(@$astro_tips->isEmpty() && !$userData->why_who) show active @else fade @endif">
						@foreach(@$all_faq_cat as $key=>$faq)
						<span class="faq-cat-details">{{@$faq->parent->faq_category}} > {{@$faq->faq_category}}</span>
                           <div class="accordian-faq">
                              <div class="accordion" id="faqcat{{@$faq->id}}">
							  @if(@$faq->all_faq->isNotEmpty())
                                 @php $count= 1@endphp
								 @foreach(@$faq->all_faq as $faq1)
                                 <div class="card">
                                    <div class="card-header" id="faqhead{{@$faq1->id}}">
                                       <a href="#" class="btn btn-header-link acco-chap collapsed" data-toggle="collapse" data-target="#faq{{@$faq1->id}}" aria-expanded="true" aria-controls="faq{{@$faq1->id}}">
                                          <p class="word_wrapper"><span>Q{{@$count++}}. </span>{{@$faq1->question}}</p>
                                       </a>
                                    </div>
                                    <div id="faq{{@$faq1->id}}" class="collapse" aria-labelledby="faqhead{{@$faq1->id}}" data-parent="#faqcat{{@$faq->id}}">
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

<div class="details_sec">
	<div class="container">
		<div class="details_iner">
			<div class="details_left">
				<div class="astro_details astro_public_profile">
					<div class="ast_det_left">
						<div class="media">
							{{-- <em><img src="{{ URL::to('public/frontend/images/astro-det1.jpg')}}" alt=""></em> --}}
							<em><img src="@if(@$userData->profile_img!=""){{ asset('storage/app/public/profile_picture/'.@$userData->profile_img) }} @else {{asset('public/frontend/images/take_astro3.jpg')}} @endif" alt=""></em>
                            <div class="media-body">
                                <h4>{{@$userData->first_name}} {{@$userData->last_name}}<b><i class="fa fa-star"></i>{{@$userData->avg_review}}</b></h4>
								<!--<p>@foreach ($userData->astrologerExpertise as $key=> $expertie)
                                    @if($key+1==$userData->astrologerExpertise->count())
                                    {{$expertie->experties->expertise_name}}
                                    @else
                                    {{@$expertie->experties->expertise_name}} ,
                                    @endif
                                    @endforeach
                                </p>-->
								<p>{{@$userData->experience}} + {{__('search.years_of_experience')}}</p>
								<p>
                                    @foreach (@$userData->astrologerLanguage as $key=> $language)
                                    @if($key+1==$userData->astrologerLanguage->count())
                                    {{$language->languages->language_name}}
                                    @else
                                    {{$language->languages->language_name}} ,
                                    @endif
                                    @endforeach

                                 </p>

                                 @if(@$userData->is_audio_call=="Y")
                                <p class="booking_charge"> @if(@$userData->avail_now_audio_call=="Y" && @$userData->instant_booking_expiry>=date('Y-m-d H:i:s') && @$userData->user_availability=="Y" && $exclusion_dates<=0) <i class="fa fa-check"></i> @else <i class="fa fa-times"></i>  @endif Available now for instant audio call @if(@$userData->avail_now_audio_call=="Y" && @$userData->user_availability=="Y" && @$userData->instant_booking_expiry>=date('Y-m-d H:i:s') && $call_details<=0 && $exclusion_dates<=0) : <a href="javascript:void(0);" class="pag_btn astro_book_now" data-id="A"> Talk Now</a> @endif</p>
                                 @endif

                                 @if(@$userData->is_video_call=="Y")
                                <p class="booking_charge">@if(@$userData->avail_now_video_call=="Y" && @$userData->instant_booking_expiry>=date('Y-m-d H:i:s') && @$userData->user_availability=="Y" && $exclusion_dates<=0) <i class="fa fa-check"></i> @else <i class="fa fa-times"></i>  @endif Available now for instant video call @if(@$userData->avail_now_video_call=="Y" && @$userData->user_availability=="Y" && @$userData->instant_booking_expiry>=date('Y-m-d H:i:s') && $call_details<=0 && $exclusion_dates<=0) : <a href="javascript:void(0);" class="pag_btn astro_book_now" data-id="V"> Call Now</a> @endif</p>
                                 @endif

                                  @if(@$userData->is_chat=="Y")
                                <p class="booking_charge">@if(@$userData->is_chat=="Y" && strtotime(@$userData->instant_booking_expiry)>=time() && @$userData->user_availability=="Y" && $exclusion_dates<=0) <i class="fa fa-check"></i> @else <i class="fa fa-times"></i>  @endif Available now for instant chat @if(@$userData->is_chat=="Y" && @$userData->instant_booking_expiry>=date('Y-m-d H:i:s') && @$userData->user_availability=="Y" && $call_details<=0 && $exclusion_dates<=0) : <a href="javascript:void(0);" class="pag_btn astro_book_now" data-id="C"> Chat Now</a> @endif</p>
                                 @endif

								 @if(@$userData->is_astrologer_offer_offline=="Y")
									 <p class="booking_charge">Offline consultation is available : <a href="javascript:void(0);" class="pag_btn astro_book_now" data-id="F"> Book Now</a> </p>
								@endif


							</div>
						</div>
					</div>
					<div class="shareBx">
						<span><i class="fa fa-share-square-o" aria-hidden="true"></i>{{__('search.share')}}:</span>

						<ul>
                            <div class="sharethis-inline-share-buttons"></div>
						</ul>



					</div>


					<div class="pricing_content">
					@if(@$userData->is_audio_call=="Y")
						@if(@session()->get('currency')==1)

						 @if(@$userData->call_discount_inr!=null && @$userData->call_discount_inr>0)


						 @php
                              $old_price = $userData->call_price;
                              $discount_value = ($old_price / 100) * @$userData->call_discount_inr;
                              $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Audio Call Charges : <del>{{@session()->get('currencySym')}} {{@$userData->call_price}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else

						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Audio Call Charges : {{@session()->get('currencySym')}} {{@$userData->call_price}}/{{__('search.min')}}</strong>

						@endif




						@else

						@if(@$userData->call_discount_usd!=null && @$userData->call_discount_usd>0)
						 @php
                                 $old_price = @$custom * $userData->call_price_usd;
                                 $discount_value = ($old_price / 100) * @$userData->call_discount_usd;
                                $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Audio Call Charges : <del>{{@session()->get('currencySym')}} {{round(@$userData->call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else
						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Audio Call Charges : {{@session()->get('currencySym')}} {{round(@$userData->call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</strong>

						@endif



						@endif
						@endif






						@if(@$userData->is_video_call=="Y")
						@if(@session()->get('currency')==1)

						 @if(@$userData->video_call_discount_inr!=null && @$userData->video_call_discount_inr>0)


						 @php
                              $old_price = $userData->video_call_price_inr;
                              $discount_value = ($old_price / 100) * @$userData->video_call_discount_inr;
                              $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Video Call Charges : <del>{{@session()->get('currencySym')}} {{@$userData->video_call_price_inr}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else

						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Video Call Charges : {{@session()->get('currencySym')}} {{@$userData->video_call_price_inr}}/{{__('search.min')}}</strong>

						@endif




						@else

						@if(@$userData->video_call_discount_usd!=null && @$userData->video_call_discount_usd>0)
						 @php
                                 $old_price = @$custom * $userData->video_call_price_usd;
                                 $discount_value = ($old_price / 100) * @$userData->video_call_discount_usd;
                                $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Video Call Charges : <del>{{@session()->get('currencySym')}} {{round(@$userData->video_call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else
						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Video Call Charges : {{@session()->get('currencySym')}} {{round(@$userData->video_call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</strong>

						@endif








						@endif
						@endif











						@if(@$userData->is_chat=="Y")

						@if(@session()->get('currency')==1)

						 @if(@$userData->chat_discount_inr!=null && @$userData->chat_discount_inr>0)


						 @php
                              $old_price = $userData->chat_price_inr;
                              $discount_value = ($old_price / 100) * @$userData->chat_discount_inr;
                              $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Chat  Charges : <del>{{@session()->get('currencySym')}} {{@$userData->chat_price_inr}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else

						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Chat  Charges : {{@session()->get('currencySym')}} {{@$userData->chat_price_inr}}/{{__('search.min')}}</strong>

						@endif




						@else

						@if(@$userData->chat_discount_usd!=null && @$userData->chat_discount_usd>0)
						 @php
                                 $old_price = @$custom * $userData->chat_price_usd;
                                 $discount_value = ($old_price / 100) * @$userData->chat_discount_usd;
                                $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Chat Charges : <del>{{@session()->get('currencySym')}} {{round(@$userData->chat_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else
						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Chat Charges : {{@session()->get('currencySym')}} {{round(@$userData->chat_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</strong>

						@endif




						@endif
						@endif

						@if(@$userData->is_astrologer_offer_offline=="Y")

						@if(@session()->get('currency')==1)

						 @if(@$userData->offline_discount_price_inr!=null && @$userData->offline_discount_price_inr>0)


						 @php
                              $old_price = $userData->astrologer_offline_price_inr;
                              $discount_value = ($old_price / 100) * @$userData->offline_discount_price_inr;
                              $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Offline  Charges : <del>{{@session()->get('currencySym')}} {{@$userData->astrologer_offline_price_inr}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else

						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Offline  Charges : {{@session()->get('currencySym')}} {{@$userData->astrologer_offline_price_inr}}/{{__('search.min')}}</strong>

						@endif




						@else

						@if(@$userData->offline_discount_price_usd!=null && @$userData->offline_discount_price_usd>0)
						 @php
                                 $old_price = @$custom * $userData->astrologer_offline_price_usd;
                                 $discount_value = ($old_price / 100) * @$userData->offline_discount_price_usd;
                                $new_price = $old_price - $discount_value;
                         @endphp


						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Offline Charges : <del>{{@session()->get('currencySym')}} {{round(@$userData->astrologer_offline_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</del> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}</strong>

						@else
						<strong class="call_cha"><img src="{{ URL::to('public/frontend/images/res.png')}}" alt="">Offline Charges : {{@session()->get('currencySym')}} {{round(@$userData->astrologer_offline_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}</strong>

						@endif




						@endif
						@endif
					</div>




				</div>


				<div class="about_astro back_white">
					<div class="edu_quli">
                        <div class="edu_quliitem">
                            <strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{__('search.educational_qualification')}}</strong>
                            @if(!@$userData->astrologerEducation->isEmpty())
                            @foreach ( @$userData->astrologerEducation as  $education)
                            <span>{{$education->education_title}} - {{$education->institute}} <br>{{$education->year_of_passing}}</span>
							@if(@$education->image)
							<a href="{{URL::to('storage/app/public/education_image/'.@$education->image)}}" data-toggle="lightbox" data-title="{{$education->education_title}} - {{$education->institute}} - {{$education->year_of_passing}}"><img src="{{URL::to('storage/app/public/education_image/'.@$education->image)}}" width="100"/></a>
							@endif
                            @endforeach
                            @else
                            <span>{{__('search.no_educational_qualification_added')}}</span>
                            @endif
						</div>
						<div class="edu_quliitem">
							<strong><em><img src="{{ URL::to('public/frontend/images/edu_quli2.png')}}" alt=""></em>{{__('search.experience')}}</strong>
                            @if(!@$userData->astrologerExperience->isEmpty())
                            @foreach ( @$userData->astrologerExperience as $experience)
                            <span>{{$experience->experience_title}} - {{$experience->year_of_experience}} {{__('search.year')}} <br>{{$experience->description}}</span>
							@if(@$experience->image)
							<a href="{{URL::to('storage/app/public/experience_image/'.@$experience->image)}}" data-toggle="lightbox" data-title="{{$experience->experience_title}} - {{$experience->year_of_experience}} {{__('search.year')}}"><img src="{{URL::to('storage/app/public/experience_image/'.@$experience->image)}}" width="100"/></a>
							@endif
                            @endforeach
                            @else
                            <span>{{__('search.no_experience_added')}}</span>
                            @endif
						</div>
						@if(@$userData->heading_one && @$userData->description_one)
						<div class="edu_quliitem">
							<strong><em><img src="{{ URL::to('public/frontend/images/edu_quli2.png')}}" alt=""></em>{{@$userData->heading_one}}</strong>
                            <span>{{@$userData->description_one}}</span>
						</div>
						@endif
						@if(@$userData->heading_two && @$userData->description_two)
						<div class="edu_quliitem">
							<strong><em><img src="{{ URL::to('public/frontend/images/edu_quli2.png')}}" alt=""></em>{{@$userData->heading_two}}</strong>
                            <span>{{@$userData->description_two}}</span>
						</div>
						@endif
						@if(@$userData->heading_three && @$userData->description_three)
						<div class="edu_quliitem">
							<strong><em><img src="{{ URL::to('public/frontend/images/edu_quli2.png')}}" alt=""></em>{{@$userData->heading_three}}</strong>
                            <span>{{@$userData->description_three}}</span>
						</div>
						@endif
					</div>
				</div>
				<div class="customer_review_box back_white">
					<h5>{{__('search.customer_review')}} :</h5>
					<div class="review_box">
						<div class="review_left">
							<b>{{$userData->avg_review}}</b>
							<ul>
							@php
							$rating=explode('.',$userData->avg_review);
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
							<strong>(Review {{$userData->tot_review}})</strong>
						</div>
						<div class="review_right">
							<ul>
								<li>
									<em>5</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($astrologerReview)>0?100*(count($astrologerReview->where('ratting_number',5))/count($astrologerReview)):0}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>( {{count(@$astrologerReview->where('ratting_number', 5)) }} Customers)</b>
								</li>
								<li><em>4</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($astrologerReview)>0?100*(count($astrologerReview->where('ratting_number',4))/count($astrologerReview)):0}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$astrologerReview->where('ratting_number',4))}} Customers)</b>
								</li>
								<li><em>3</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($astrologerReview)>0?100*(count($astrologerReview->where('ratting_number',3))/count($astrologerReview)):0}}%;%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$astrologerReview->where('ratting_number',3))}} Customers)</b>
								</li>
								<li><em>2</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($astrologerReview)>0?100*(count($astrologerReview->where('ratting_number',2))/count($astrologerReview)):0}}%;%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$astrologerReview->where('ratting_number',2))}} Customers)</b>
								</li>
							</ul>
						</div>
					</div>
                    @if($astrologerReview->count()>0 )
					<div class="review_person">
                        @foreach ($astrologerReview as $key=>$review)
                        @if($key<2)
                        <div class="review_per_item">
							<div class="media">
								<em>@if(@$review->customer_review->profile_img!="")<img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$review->customer_review->profile_img}}" alt=""> @else  <img src="{{ URL::to('public/frontend/images/user-img.jpg')}}" alt=""> @endif</em>
								<div class="media-body">
									<h2>{{$review->customer_review->first_name}} {{$review->customer_review->last_name}}</h2>
									<ul>
										<li>
                                            @if(@$review->ratting_number==5)
                                            <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                            @elseif(@$review->ratting_number==4)
                                            <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                            @elseif(@$review->ratting_number==3)
                                            <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                            @elseif(@$review->ratting_number==2)
                                            <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                            @elseif(@$review->ratting_number==1)
                                            <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                            @endif


										</li>
										<li>
											<i class="fa fa-calendar"></i>
											<strong>{{ date('jS M,  Y', strtotime(@$review->created_at))}}</strong>
											@if(@$review->review_type=='C')
											<a class="audio_call">Audio Call</a>
											@elseif(@$review->review_type=='V')
											<a class="audio_call">Video Call</a>
											@elseif(@$review->review_type=='CA')
											a class="audio_call">Chat</a>
											@endif
										</li>
									</ul>
								</div>
							</div>
                            @if(strlen(@$review->review_message) > 200)
                               <p class="review_aboutRemaove" id="review_lesstext{{$key}}">{!! substr(@@$review->review_message, 0, 200 ) . '...' !!}</p>
                               <p class="review_moretext" id="review_moretext{{$key}}">{!! @$review->review_message !!}</p>
                               <a class="allread review_more" data-id="{{$key}}" id="review_more{{$key}}">Read More +</a>
                               <a class="allread review_less" data-id="{{$key}}" id="review_less{{$key}}" style="display: none">Read less -</a>
                               @else
                               <p>{!! @$review->review_message !!}</p>
                               @endif
						</div>
                        @else
                        <div class="moretext5">
                            <div class="review_per_item">
                                <div class="media">
                                    <em>@if(@$review->customer_review->profile_img!="")<img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$review->customer_review->profile_img}}" alt=""> @else  <img src="{{ URL::to('public/frontend/images/user-img.jpg')}}" alt=""> @endif</em>
                                    <div class="media-body">
                                        <h2>{{$review->customer_review->first_name}} {{$review->customer_review->last_name}}</h2>
                                        <ul>
                                            <li>
                                                @if(@$review->ratting_number==5)
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                @elseif(@$review->ratting_number==4)
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                @elseif(@$review->ratting_number==3)
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                @elseif(@$review->ratting_number==2)
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                @elseif(@$review->ratting_number==1)
                                                <span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                <span><img src="{{ URL::to('public/frontend/images/star4.png')}}" alt=""></span>
                                                @endif


                                            </li>
                                            <li>
                                                <i class="fa fa-calendar"></i>
                                                <strong>{{ date('jS M,  Y', strtotime(@$review->created_at))}}</strong>
												@if(@$review->review_type=='C')
												<a class="audio_call">Audio Call</a>
												@elseif(@$review->review_type=='V')
												<a class="audio_call">Video Call</a>
												@elseif(@$review->review_type=='CA')
												a class="audio_call">Chat</a>
												@endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @if(strlen(@$review->review_message) > 200)
                                   <p class="review_aboutRemaove" id="review_lesstext{{$key}}">{!! substr(@@$review->review_message, 0, 200 ) . '...' !!}</p>
                                   <p class="review_moretext" id="review_moretext{{$key}}">{!! @$review->review_message !!}</p>
                                   <a class="allread review_more" data-id="{{$key}}" id="review_more{{$key}}">Read More +</a>
                                   <a class="allread review_less" data-id="{{$key}}" id="review_less{{$key}}" style="display: none">Read less -</a>
                                   @else
                                   <p>{!! @$review->review_message !!}</p>
                                   @endif
                            </div>
						</div>
                        @endif
                        @endforeach
                    </div>
                    @if($astrologerReview->count()>2 )
					<a class="moreless-button5  show_more">Show More Reviews +</a>
                    @endif
                    @endif
				</div>
			</div>



			<div class="ast_det_right">
				<div class="ast_det_right_inr">
					<h6><img src="{{ URL::to('public/frontend/images/check.png')}}" alt="">{{__('search.availability')}}</h6>
					@if(@$userData->user_availability=='Y' && (@$userData->is_audio_call=="Y" || @$userData->is_video_call=="Y" || @$userData->is_chat=="Y"))
                    @if(!@$userData->userAvailable->isEmpty())
                   @if(count(@$monday)>0)
                    <div class="ast_time">
						<strong>Monday <!-- - <span>At {{$userData->city}}</span>--></strong>
						<ul>
							@foreach(@$monday as $count => $slot)
							@if($count<3)
							<li><a>{{@$slot->from_time}}</a></li>
							@endif
                            @endforeach
						</ul>
					</div>
					@endif



					@if(count(@$tuesday)>0)
                    <div class="ast_time">
						<strong>Tuesday <!-- - <span>At {{$userData->city}}</span>--></strong>
						<ul>
							@foreach(@$tuesday as $key => $slot)
							@if($key<3)
							<li><a>{{@$slot->from_time}}</a></li>
							@endif
                            @endforeach
						</ul>
					</div>
					@endif

					@if(count(@$wednesday)>0)
                    <div class="ast_time">
						<strong>Wednesday <!-- - <span>At {{$userData->city}}</span>--></strong>
						<ul>
							@foreach(@$wednesday as $key => $slot)
							@if($key<3)
							<li><a>{{@$slot->from_time}}</a></li>
							@endif
                            @endforeach
						</ul>
					</div>
					@endif

					@if(count(@$thursday)>0)
                    <div class="ast_time">
						<strong>Thursday <!-- - <span>At {{$userData->city}}</span>--></strong>
						<ul>
							@foreach(@$thursday as $key => $slot)
							@if($key<3)
							<li><a>{{@$slot->from_time}}</a></li>
							@endif
                            @endforeach
						</ul>
					</div>
					@endif

					@if(count(@$friday)>0)
                    <div class="ast_time">
						<strong>Friday <!-- - <span>At {{$userData->city}}</span>--></strong>
						<ul>
							@foreach(@$friday as $key => $slot)
							@if($key<3)
							<li><a>{{@$slot->from_time}}</a></li>
							@endif
                            @endforeach
						</ul>
					</div>
					@endif

				 @if(count(@$saturday)>0)
                    <div class="ast_time">
						<strong>Saturday <!-- - <span>At {{$userData->city}}</span>--></strong>
						<ul>
							@foreach(@$saturday as $key => $slot)
							@if($key<3)
							<li><a>{{@$slot->from_time}}</a></li>
							@endif
                            @endforeach
						</ul>
					</div>
					@endif


					 @if(count(@$sunday)>0)
                    <div class="ast_time">
						<strong>Sunday - <!--<span>At {{$userData->city}}</span>--></strong>
						<ul>
							@foreach(@$sunday as $key => $slot)
							@if($key<3)
							<li><a>{{@$slot->from_time}}</a></li>
							@endif
                            @endforeach
						</ul>
					</div>
					@endif


					<div class="talk_now_fll">
						<a href="javascript:;" class="pag_btn clickon" id="talk_now"><i class="fa fa-envelope-o"></i>Book Now</a>
					</div>
                    @else
                    <span>{{__('search.astrologer_not_available')}}</span>
                    @endif
					@else
                    <span>{{__('search.astrologer_not_available')}}</span>
                    @endif
				</div>
			</div>
</div>
</div>
</div>
</section>


@endsection

@section('footer')
@include('includes.footer')
@endsection
<!--For instant booking-->
<div class="modal custom_modal_sg" tabindex="-1" role="dialog" id="instantBookingModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title booking_title">Call Booking</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form  method="POST" enctype="multipart/form-data" id="instant_form" action="{{route('astrologer.call.booking',['slug'=>@$userData->slug])}}">
                        @csrf
                        <div class="main-center-div">
                        <div class="login-from-area">
                            <input type="hidden" name="astrologer_id" value="{{@$userData->id}}">
                            <input type="hidden" id="u_id1" @if(@auth()->user()->id) value="1" @endif/>
                            <input type="hidden" id="booking_type" name="booking_type" value=""/>
                            <h3>Book an appointment with astrologer</h3>
							<p class="show_wallet_balance"></p>
                            <div class="marb20">
                            	<div class="col-md-12 p-0">
                                <select class="form-control required" name="instant_duration" id="instant_duration">
									<option value="">Select Duration</option>
									<option value="15">15 Mins</option>
									<option value="30">30 Mins</option>
									<option value="45">45 Mins</option>
									<option value="60">60 Mins</option>
									<option value="1">Per Min</option>
								</select>
                                </div>
                                <div class="clearfix"></div>
								<p class="payable_amount"></p>
                            </div>
                            <button type="submit" class="login-submit">Book Now</button>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--For instant booking-->
<div class="modal custom_modal_sg" tabindex="-1" role="dialog" id="durarion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Appointment Booking</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form  method="POST" enctype="multipart/form-data" id="duration_from" action="{{route('astrologer.call.booking',['slug'=>@$userData->slug])}}">
                        @csrf
                        <div class="main-center-div">@include('includes.message')
                        <div class="login-from-area">
                            <input type="hidden" name="astrologer_id" value="{{@$userData->id}}">
                            <input type="hidden" id="u_id" @if(@auth()->user()->id) value="1" @endif)>
                            <h3>Book an appointment with astrologer</h3>
							<div>
                                    <div class="checkBox d-flex sign-astro new-cus booking_type_radio">
                                        <!--<span>{{__('auth.gender_placeholder')}}</span>-->
                                        <ul>
										@if(@$userData->is_audio_call=="Y")
                                            <li>
                                                <input type="radio" class="bookingType" id="radio1" name="booking_type" value="A" @if(@$userData->is_audio_call=="Y") checked @endif>
                                                <label for="radio1">Audio Call</label>
                                            </li>
										@endif
										@if(@$userData->is_video_call=="Y")
                                            <li>
                                                <input type="radio" class="bookingType" id="radio2" name="booking_type" value="V" @if(@$userData->is_audio_call=="N" && @$userData->is_video_call=="Y") checked @endif>
                                                <label for="radio2">Video Call</label>
                                            </li>
										@endif
										@if(@$userData->is_chat=="Y")
											<li>
                                                <input type="radio" class="bookingType" id="radio3" name="booking_type" value="C" @if(@$userData->is_audio_call=="N" && @$userData->is_video_call=="N" && @$userData->is_chat=="Y") checked @endif>
                                                <label for="radio3">Chat</label>
                                            </li>
										@endif
										@if(@$userData->is_astrologer_offer_offline=="Y")
											<li>
                                                <input type="radio" class="bookingType" id="radio4" name="booking_type" value="F" @if(@$userData->is_audio_call=="N" && @$userData->is_video_call=="N" && @$userData->is_chat=="N" && @$userData->is_astrologer_offer_offline=="Y") checked @endif>
                                                <label for="radio4">Offline</label>
                                            </li>
										@endif
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            <div class="marb20">
                            	<div class="col-md-12 p-0">
                                <input type="text" id="datepicker" placeholder="Select Date" class="position-relative" name="date" value="" style="width: 100%;height: 32px;" autocomplete="off">
                                </div>
                                <div class="clearfix"></div>
								<div class="col-lg-12 p-0" >
								<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								  <div class="color_area">
								   <div class="color_box1"></div>
								   <P>Unavailable</P>
								  </div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								  <div class="color_area">
								   <div class="color_box2"></div>
								   <P>Busy</P>
								  </div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
								  <div class="color_area">
								   <div class="color_box3"></div>
								   <P>Available</P>
								  </div>
								</div>
								</div>
								</div>
                                <div class="slot_class slot_class_second" >
                                	<div class="slot_check">
											<ul id="slot_fetch">

										    </ul>
										</div>
                                </div>
                               <p class="payable_amount1"></p>
                            </div>
                            <button type="submit" class="pag_btn login-submit">Booking</button>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="call-duration">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Call Astrologer</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="main-center-div">
                        <div class="login-from-area">
                            <em><img src="{{ asset('storage/app/public/profile_picture/'.@$userData->profile_img) }}" alt="" style="max-height: 100%; max-width: 100%;" ></em>
                            <p>{{ @$userData->first_name }}  {{ @$userData->last_name }}</p>
                            <span id="timer">Calling...</span>
                            <button class="hngp" type="button" id="button-hangup"><img src="{{ url('public/frontend/images/hngup.png') }}" /></button>
                            <button class="callnw" style="display: none;" type="button" id="button-call"><img src="{{ url('public/frontend/images/call.png') }}" /></button>
                        </div>
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

@section('script')
@include('includes.script')

@php

$call_price=0;
$video_call_price=0;
$chat_price=0;
$offline_price=0;
if(session()->get('currency')==1)
{
	if(@$userData->call_discount_inr)
	{
		$call_price=(@$userData->call_price-((@$userData->call_price*@$userData->call_discount_inr)/100));
	}
	else
	{
		$call_price=@$userData->call_price;
	}

	if(@$userData->video_call_discount_inr)
	{
		$video_call_price=(@$userData->video_call_price_inr-((@$userData->video_call_price_inr*@$userData->video_call_discount_inr)/100));
	}
	else
	{
		$video_call_price=@$userData->video_call_price_inr;
	}

	if(@$userData->chat_discount_inr)
	{
		$chat_price=(@$userData->chat_price_inr-((@$userData->chat_price_inr*@$userData->chat_discount_inr)/100));
	}
	else
	{
		$chat_price=@$userData->chat_price_inr;
	}
	if(@$userData->offline_discount_price_inr)
	{
		$offline_price=(@$userData->astrologer_offline_price_inr-((@$userData->astrologer_offline_price_inr*@$userData->offline_discount_price_inr)/100));
	}
	else
	{
		$offline_price=@$userData->astrologer_offline_price_inr;
	}
}
else
{
	if(@$userData->call_discount_usd)
	{
		$call_price=((@$userData->call_price_usd-((@$userData->call_price_usd*@$userData->call_discount_usd)/100))*currencyConversionCustom());
	}
	else
	{
		$call_price=@$userData->call_price_usd*currencyConversionCustom();
	}

	if(@$userData->video_call_discount_usd)
	{
		$video_call_price=((@$userData->video_call_price_usd-((@$userData->video_call_price_usd*@$userData->video_call_discount_usd)/100))*currencyConversionCustom());
	}
	else
	{
		$video_call_price=@$userData->video_call_price_usd*currencyConversionCustom();
	}

	if(@$userData->chat_discount_usd)
	{
		$chat_price=((@$userData->chat_price_usd-((@$userData->chat_price_usd*@$userData->chat_discount_usd)/100))*currencyConversionCustom());
	}
	else
	{
		$chat_price=@$userData->chat_price_usd*currencyConversionCustom();
	}
	if(@$userData->offline_discount_price_usd)
	{
		$offline_price=((@$userData->astrologer_offline_price_usd-((@$userData->astrologer_offline_price_usd*@$userData->offline_discount_price_usd)/100))*currencyConversionCustom());
	}
	else
	{
		$offline_price=@$userData->astrologer_offline_price_usd*currencyConversionCustom();
	}
}
$user_wallet_balance=0;
$audio_15=0;
$video_15=0;
$chat_15=0;
if(@$wallet_balance)
{
	if(session()->get('currency')==1)
	{
		$user_wallet_balance=$wallet_balance->wallet_balance;
	}
	else
	{
		$user_wallet_balance=$wallet_balance->wallet_balance*currencyConversionCustom();
	}

}
$audio_15=$call_price*15;
$video_15=$video_call_price*15;
$chat_15=$chat_price*15;

@endphp
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script>
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
	event.preventDefault();
	$(this).ekkoLightbox();
});
</script>
<script type="text/javascript">
	$('.audio_call').on('click',function(e){
		$("#call-duration").modal("show");
        $('#phone-number').val('+917980768406');
        $('#button-call').trigger('click');
	});
</script>
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}

{{-- // The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on. --}}
{{-- <script>
$('.moreless-button').click(function() {
$('.moretext').slideToggle();
if ($('.moreless-button').text() == "Read More +") {
$(this).text("Read Less -")
} else {
$(this).text("Read More +")
}
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
    $(this).text("{{__('search.read_more')}} +")
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
		$('.astro_book_now').click(function(){
			if(!$('#u_id1').val()){
            	$('#login-modal').modal('show');
                return false;
            }
			var id = $(this).data('id');
			if(id=='F')
			{
				$('#radio4').prop('checked',true);
				$('#durarion').modal('show');
			}
			else
			{
				if(id=='A')
				{
					$('.booking_title').html('Audio Call Booking');
				}
				else if(id=='V')
				{
					$('.booking_title').html('Video Call Booking');
				}
				else if(id=='C')
				{
					$('.booking_title').html('Chat Booking');
				}
				$('#booking_type').val(id);
				$('#instantBookingModal').modal('show');
			}

		});
		$('#instant_duration').change(function(){
			var duration = $(this).val();
			var booking_type = $('#booking_type').val();
			var amount=0;
			$('.payable_amount').hide();
			$('.show_wallet_balance').html('');
			if(duration!='')
			{
				if(duration==1)
				{
					if(booking_type=='A')
					{
						@if($user_wallet_balance<$audio_15)
							alert('You must have atleast {{session()->get("currencySym").$audio_15}} (15 minutes worth of amount) in you wallet in order to proceed.');
						$('#instant_duration').val('');
						@endif
					}
					else if(booking_type=='V')
					{
						@if($user_wallet_balance<$video_15)
							alert('You must have atleast {{session()->get("currencySym").$video_15}} (15 minutes worth of amount) in you wallet in order to proceed.');
						$('#instant_duration').val('');
						@endif
					}
					else if(booking_type=='C')
					{
						@if($user_wallet_balance<$chat_15)
							alert('You must have atleast {{session()->get("currencySym").$chat_15}} (15 minutes worth of amount) in you wallet in order to proceed.');
						$('#instant_duration').val('');
						@endif
					}
					$('.show_wallet_balance').html('Current Wallet Balance: {{session()->get("currencySym").$user_wallet_balance}}');
				}
				else
				{
					if(booking_type=='A')
					{
						var call_price={{@$call_price}};
						amount=parseFloat(duration)*parseFloat(call_price);
					}
					else if(booking_type=='V')
					{
						var video_call_price={{@$video_call_price}};
						amount=parseFloat(duration)*parseFloat(video_call_price);
					}
					else if(booking_type=='C')
					{
						var chat_price={{@$chat_price}};
						amount=parseFloat(duration)*parseFloat(chat_price);
					}
					$('.payable_amount').html('<strong>Payable amount</strong> - {{session()->get('currencySym')}}'+amount.toFixed(2));
					$('.payable_amount').show();
				}

			}

		});
        // click Call Now button
        $('#talk_now').click(function(){
            if(!$('#u_id').val()){
            	$('#login-modal').show();
                // Swal.fire('Please login to Call booking');
                return 0;
            }
            var reqData = {
                'jsonrpc': '2.0',
                '_token': '{{csrf_token()}}',
                'params': {
                    astrologerId: '{{ @$userData->id }}',
                }
            };
            $.ajax({
                url: '{{ route('customer.check.astrologer.available') }}',
                type: 'post',
                dataType: 'json',
                data: reqData,
            })
            .done(function(response) {
                if(response.error) {
                    // toastr.error(response.error);
                    console.log(response.error);
                } else {
                    if(response.result){
                        if(response.result.available=='N'){
                            $(".log-select option:contains(Select Day)").attr('selected', 'selected');
                            $("#durarion").modal("show");
                        }else{
                            $("#call-duration").modal("show");
                            $('#phone-number').val('+917980768406');
                            $('#button-call').trigger('click');
                        }
                    }
                }
            })
            .fail(function(error) {

            })
            .always(function() {

            });
        });


        $("#call-duration").on('hidden.bs.modal', function (e) {
            $('#button-hangup').trigger('click');
            clearInterval(myInterval);
        });
        $('.day_select').click(function(){
            if(!$('#u_id').val()){
            Swal.fire('Please login to Call booking');
            return 0;
            }
            console.log($(this).data('day'));
            var day = $(this).data('day');
            if(day =='SUNDAY'){
               var select_option ='{{__('search.sunday')}}';
            }
            else if(day =='MONDAY'){
                var select_option ='{{__('search.monday')}}';
            }
            else if(day =='TUESDAY'){
                var select_option ='{{__('search.tuesday')}}';
            }
            else if(day =='WEDNESDAY'){
                var select_option ='{{__('search.wednesday')}}';
            }
            else if(day =='THURSDAY'){
                var select_option ='{{__('search.thursday')}}';
            }
            else if(day =='FRIDAY'){
                var select_option ='{{__('search.friday')}}';
            }
            else if(day =='SATURDAY'){
                var select_option ='{{__('search.saturday')}}';
            }
            else{
                var select_option ='Select Day';
            }
            $(".log-select option:contains(" +select_option+")").attr('selected', 'selected');
            // $("#time_duration").val(0);
            $("#durarion").modal("show");
        });
    });
</script>
{{-- <script type="text/javascript" src="https://media.twiliocdn.com/sdk/js/client/v1.4/twilio.min.js"></script> --}}
<button type="button" id="get-devices" style="display:none;"></button>
<input type="hidden" id="phone-number">
<script src="{{URL::to('public/frontend/js/twilio.min.js')}}"></script>
<script src="{{URL::to('public/frontend/js/quickstart.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    var callStatus = 'initiated';
    var day= '{{date("l")}}';
    $(document).ready(function(){
       $('#instant_form').validate();
	   $('body').on('click', '.schedule_class', function(){
		   $('.payable_amount1').hide();
		   var allRadios = $('.schedule_class:checked').length;
		   if (allRadios==0) {
				alert('Please select atleast one slot.');
				return false;
			}
			if (allRadios>4) {
				alert('Maximum 4 slots bookings are allowed.');
				return false;
			}
			if (allRadios>=1) {
				var slots = new Array();
				  $('.schedule_class:checked').each(function(){
					 slots.push($(this).val());
				  });
				  // var dataString = 'slots='+ slots;
				  $.ajax({
					url:"{{route('astrologer.booking.payable.amount')}}",
					method:"GET",
					data: {'slots':slots,'booking_type':$('.bookingType:checked').val(),'slug':'{{@$userData->slug}}','booking_date':$('#datepicker').val()},
					cache: false,
					success: function(res) {
						console.log(res);
					 if (res.status=="error") {
						alert(res.message);
						$('.payable_amount1').html('');
						$('.payable_amount1').hide();
						return false;
					 }else{
						$('.payable_amount1').html('<strong>Payable amount</strong> - {{session()->get("currencySym")}}'+res.amount);
						$('.payable_amount1').show();
					 }
				 }
			  });
			}
	   });
	   $('body').on('click', '.bookingType', function(){
		   $('.payable_amount1').hide();
		   var allRadios = $('.schedule_class:checked').length;
			if (allRadios>4) {
				alert('Maximum 4 slots bookings are allowed.');
				return false;
			}
			if (allRadios>=1) {
				var slots = new Array();
				  $('.schedule_class:checked').each(function(){
					 slots.push($(this).val());
				  });
				  // var dataString = 'slots='+ slots;
				  $.ajax({
					url:"{{route('astrologer.booking.payable.amount')}}",
					method:"GET",
					data: {'slots':slots,'booking_type':$('.bookingType:checked').val(),'slug':'{{@$userData->slug}}','booking_date':$('#datepicker').val()},
					cache: false,
					success: function(res) {
						console.log(res);
					 if (res.status=="error") {
						alert(res.message);
						$('.payable_amount1').html('');
						$('.payable_amount1').hide();
						return false;
					 }else{
						$('.payable_amount1').html('<strong>Payable amount</strong> - {{session()->get("currencySym")}}'+res.amount);
						$('.payable_amount1').show();
					 }
				 }
			  });
			}
	   });

        $("#duration_from").validate({
            rules: {
                date:{
                    required: true,
                },
                // time_duration:{
                //     required: true,
                //     number: true ,
                //     min:5,
                //     max:60,
                // },
            },

            messages: {
                date:{
                    required: 'Please select a date',
                },
                // time_duration:{
                //     required: 'Enter duration for call',
                //     number: 'Only Number enter' ,
                //     min:'Minumum call duration 5 minutes',
                //     max:'Maximum call duration 60 minutes',
                // },
            },
            submitHandler: function(form){
            	 var allRadios = $('[name="slot_name[]"]:checked').length;
            	 if (allRadios==0) {
                    alert('Please select atleast one slot.');
                    return false;
                }
                if (allRadios>4) {
                    alert('Maximum 4 slots bookings are allowed.');
                    return false;
                }
                if (allRadios>1) {
                	var slots = new Array();
				      $('[name="slot_name[]"]:checked').each(function(){
				         slots.push($(this).val());
				      });
				      // var dataString = 'slots='+ slots;
				      $.ajax({
						url:"{{route('astrologer.slot.duration.check')}}",
		                method:"GET",
		                data: {'slots':slots},
            			cache: false,
		                success: function(res) {
		                 if (res=="excess") {
		                 	alert('Please select one hour range from your start time');
		                 	return false;
		                 }else{
		                 	form.submit();
		                 }
		             }
				  });
                }
                else{
					form.submit();
                }
              }
        });
        $('#time_duration').keyup(function(){
            var duration=$(this).val()
            var rate='{{@$userData->call_price}}';
            $('#amount h3').html('Total Amount: - '+duration*rate);
            console.log(duration*rate)
        });
        $('#time_duration').blur(function(){
            var duration=$(this).val()
            var rate='{{@$userData->call_price}}';
            $('#amount h3').html('Total Amount: - '+duration*rate);
            console.log(duration*rate)
        });
    })
    function startTimer(duration, display) {
        var minutes = '0'; var seconds = '01';
        var totMin = '0';
        var timer = duration, minutes, seconds;
        updateCustomerWallet(totMin, minutes, seconds);
        myInterval = setInterval(function () {
            updateCustomerWallet(totMin, minutes, seconds);
	    	if(callStatus == 'initiated') {
	    		display.text('Calling...');
			} else if(callStatus == 'ringing') {
	    		display.text('Ringing...');
			} else {
				minutes = parseInt(timer / 60, 10)
		        seconds = parseInt(timer % 60, 10)+2;
		        minutes = minutes < 10 ? "0" + minutes : minutes;
		        seconds = seconds < 10 ? "0" + seconds : seconds;
		        display.text(minutes + ":" + seconds);
		        var totMin = Math.ceil(parseInt(minutes) + (parseFloat(seconds) + 2) / 60);
		        if (timer++ < 0) {
		            timer = duration;
		        }
			}
        }, 1000);
    }
    function insertToOrderMaster(sId) {
		// console.log(sId);

        if(day=='Sunday'){
            var call_day ='SUNDAY';
        }
        if(day=='Monday'){
            var call_day ='MONDAY';
        }
        if(day=='Tuesday'){
            var call_day ='TUESDAY';
        }
        if(day=='Wednesday'){
            var call_day ='WEDNESDAY';
        }
        if(day=='Thursday'){
            var call_day ='THURSDAY';
        }
        if(day=='Friday'){
            var call_day ='FRIDAY';
        }
        if(day=='Saturday'){
            var call_day ='SATURDAY';
        }
		var reqData = {
			'jsonrpc': '2.0',
			'_token': '{{csrf_token()}}',
			'params': {
				astrologer_id: '{{ @$userData->id }}',
				sid: sId,
                call_day:call_day
			}
		};
		$.ajax({
			url: '{{ route('customer.insert.order') }}',
			type: 'post',
			dataType: 'json',
			data: reqData,
		})
		.done(function(response) {
			// console.log(response);
		})
		.fail(function(error) {
			// console.log("error", error);
		})
		.always(function() {
			// console.log("complete");
		});
	}

    function disconnectCall() {
        // location.reload();
	}
    function updateCustomerWallet(totMin, minutes, seconds) {
		// console.log(totMin, minutes, seconds);
		var reqData = {
			'jsonrpc': '2.0',
			'_token': '{{csrf_token()}}',
			'params': {

			}
		};
		$.ajax({
			url: '{{ route('customer.order.status') }}',
			type: 'post',
			dataType: 'json',
			data: reqData,
		})
		.done(function(response) {
			if(response.error) {
				toastr.error(response.error);
				//console.log(response.error);
			} else {
                if(response.result){

                    callStatus = response.result.call_status;
                }
			}
			// console.log(response);
		})
		.fail(function(error) {
			// console.log("error", error);
		})
		.always(function() {
			// console.log("complete");
		});
	}
</script>

<script>
	// show-only those days available by astrologer
    $( function() {
        $( "#datepicker" ).datepicker();
    });
    var availablDays = [];
    var availablDates = [];
    @if (count(@$days)>0)
	@foreach(@$days as $value)
		availablDays.push('{{$value}}');
	@endforeach
    @endif
	@if (count(@$exclusion_dates_array)>0)
	@foreach(@$exclusion_dates_array as $value1)
		availablDates.push('{{$value1}}');
	@endforeach
    @endif
      function available(date) {
      	d = date.getDay();
	    dmy = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear();
		if(date.getDate()<10)
		{
			if((date.getMonth()+1)<10)
			{
				dmy1 =  date.getFullYear()+'-0'+(date.getMonth()+1)+'-0'+date.getDate();
			}
			else
			{
				dmy1 =  date.getFullYear()+'-'+(date.getMonth()+1)+'-0'+date.getDate();
			}

		}
		else
		{
			if((date.getMonth()+1)<10)
			{
				dmy1 =  date.getFullYear()+'-0'+(date.getMonth()+1)+'-'+date.getDate();
			}
			else
			{
				dmy1 =  date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
			}
		}
		if($.inArray(dmy1, availablDates)>=0)
		{

			return [false,"busy_dates","unAvailable"];
		}
		else
		{
			if ($.inArray(d.toString(), availablDays)>=0) {
				return [true, "available_dates","Available"];
			  } else {
				return [false,"","unAvailable"];
			  }
		}

	}

$('#datepicker').datepicker({ beforeShowDay: available,minDate:0,});



</script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#datepicker').on('change',function(e){
			var date = $('#datepicker').val();
			var astrologer_id= '{{ @$userData->id }}';
			$.ajax({
				url:"{{route('astrologer.slot.check.fetch')}}",
                method:"GET",
                data:{'date':date,'astrologer_id':astrologer_id},
                success: function(res) {
                 //console.log(res);
                 $('#slot_fetch').html(res);

              }

	});
});
});



</script>



<script type="text/javascript">
	$(document).ready(function(){
		$('.custom_modal_sg').on('hidden.bs.modal', function () {
		  location.reload();
		})
	})
</script>

@endsection

