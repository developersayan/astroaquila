@extends('layouts.app')

@section('title')
<title>Astrologer</title>
@endsection

@section('style')
@include('includes.style')
<!---------range slider------------>
<link rel="stylesheet" href="{{ URL::to('public/frontend/css/jquery-ui.css')}}">
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
               <div class="banner-inners details-inner">
                  <div class="container">
          <div class="details-inner-rows">
                     <!--<div class="row row-content">
                        <div class="col-lg-9 col-md-12">
                           <div class="details-captions page_banner_data">
                              <p style="white-space:pre-wrap;">{!!@$content->description!!}</p>
                           </div>
                        </div>
                     </div>-->
           <div class="row" style="align-self: flex-end;">
                        <div class="col-12">
                           <ul class="nav nav-tabs" role="tablist">
						   @if(@$astro_tips->isNotEmpty())
                              <li class="nav-item">
                                 <a class="nav-link show active" data-toggle="tab" href="#menu1" id="who_when_tab">Astro Tips </a>
                              </li>
                              @endif
						   @if(@$content->why_who)
                              <li class="nav-item">
                                 <a class="nav-link @if(@$astro_tips->isEmpty()) show active @endif" data-toggle="tab" href="#menu2" id="who_when_tab">Why & Who </a>
                              </li>
                              @endif
                              @if(@$all_faq_cat->isNotEmpty())   
                              <li class="nav-item">
                                 <a class="nav-link @if(@$astro_tips->isEmpty() && !$content->why_who) show active @endif" data-toggle="tab" href="#menu5">FAQ</a>
                              </li>
                              @endif
                           </ul>
                        </div>
                     </div>
                     </div>
                  </div>
                  <div class="container">
                     
                  </div>
               </div>
              
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
						@if(@$content->why_who)
						<div id="menu2" class="container tab-pane @if(@$astro_tips->isEmpty()) show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Why & Who  </h2>
                              <p style="white-space:pre-wrap;">{!!@$content->why_who!!}</p>
                           </div>
                        </div>
						@endif
                           @if(@$all_faq_cat->isNotEmpty())
                           <div id="menu5" class="container tab-pane @if(@$astro_tips->isEmpty() && !$content->why_who) show active @else fade @endif">
              @foreach(@$all_faq_cat as $faq1)
              <span class="faq-cat-details">{{@$faq1->parent->faq_category}} > {{@$faq1->faq_category}}</span>
                              <div class="accordian-faq">
                                 <div class="accordion" id="faqcat{{@$faq1->id}}">
                                    @php $count= 1@endphp
                                    @foreach(@$faq1->astrologerFaqDetails as $faq)
                                    <div class="card">
                                       <div class="card-header" id="faqhead{{@$faq->id}}">
                                          <a href="#" class="btn btn-header-link acco-chap collapsed" data-toggle="collapse" data-target="#faq{{@$faq->id}}" aria-expanded="true" aria-controls="faq{{@$faq->id}}">
                                             <p class="word_wrapper"><span>Q{{@$count++}}. </span>{{@$faq->question}}</p>
                                          </a>
                                       </div>
                                       <div id="faq{{@$faq->id}}" class="collapse" aria-labelledby="faqhead{{@$faq->id}}" data-parent="#faqcat{{@$faq1->id}}">
                                          <div class="card-body horoscope_faq_answer">
                                             <p style="white-space:pre-wrap;">{!!@$faq->answer!!}</p>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                    
                                 </div>
                              </div>
                @endforeach
                           </div>
               @endif
                        </div>
                   
            </div>
	</section>
<section class="search-bred">
    <div class="container">
        <div class="row">
            
        </div>
    </div>
</section>
<section class="search-list">
    <div class="container">
        <div class="row">
            <form action="@if(@$puja_id) {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>@$puja_id])}} @else {{route('puja.search.puja-search',['slug'=>@$cat_slug])}} @endif" method="POST" id="filter" style="width: 100%">
              @csrf
			  <input type="hidden" name="page" value="" id="page">
            <div class="col-lg-12 product-list">
                <div class="product-list-view">
                    <div class="top-total">
	             
	                 <h5>Showing {{$astrologers->count()}} of {{@$totalAstrologer}} results for Astrologers </h5>

	                <div class="sort-filter">
	                  <p><img src="{{asset('public/frontend/images/sort.png')}}" class="sort-img"> Sort by : </p>
	                  <select class="sort-select" onchange="this.form.submit()" name="sort">
	                    <option value="">Select</option>
	                    <option value="1" @if(@$key['sort']=='1') selected @endif>Rating High To Low</option>
	                    <option value="2" @if(@$key['sort']=='2') selected @endif>Rating Low To High</option>
						<option value="3" @if(@$key['sort']=='3') selected @endif>Experience</option>
						@if(@$is_audio)
	                    <option value="4" @if(@$key['sort']=='4') selected @endif>Audio Call Price Low To High</option>
	                    <option value="5" @if(@$key['sort']=='5') selected @endif>Audio Call Price High To Low</option>
						@endif
						@if(@$is_video_call)
	                    <option value="6" @if(@$key['sort']=='6') selected @endif>Video Call Price Low To High</option>
	                    <option value="7" @if(@$key['sort']=='7') selected @endif>Video Call Price High To Low</option>
						@endif
						@if(@$is_chat)
						<option value="8" @if(@$key['sort']=='8') selected @endif>Chat Price Low To High</option>
	                    <option value="9" @if(@$key['sort']=='9') selected @endif>Chat Price High To Low</option>
						@endif
						@if(@$is_offline)
						<option value="10" @if(@$key['sort']=='10') selected @endif>Offline Price Low To High</option>
	                    <option value="11" @if(@$key['sort']=='11') selected @endif>Offline Price High To Low</option>
						@endif
						<option value="12" @if(@$key['sort']=='12') selected @endif>Alphabetically</option>
	                  </select>
	                  <div class="clearfix"></div>
	                </div>

	                <div class="sort-filter">
                            <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> Show Result : </p>
                            <select class="sort-select" name="show_result" id="show_result" onchange="this.form.submit()">
                                <option value="">Select</option>
                                <option value="12" @if(@$key['show_result']=='12') selected @endif>12</option>
                                <option value="24" @if(@$key['show_result']=='24') selected @endif>24</option>
                                <option value="48" @if(@$key['show_result']=='48') selected @endif>48</option>
                                <option value="96" @if(@$key['show_result']=='96') selected @endif>96</option>
                            </select>
                            <div class="clearfix"></div>
                        </div>

	            



	                <div class="clearfix"></div>
	              </div>
                </form>
                    <div class="clearfix"></div>
                     <div class="all-products astro-custom-price">
	              	<div class="row">
	              		@if(@$astrologers->isNotEmpty())
	              		@foreach(@$astrologers as $astrologer)
	              		<div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
	              			<div class="take_astro_item">
							 <a href="{{route('astrologer.search.publicProfile',['slug'=>@$astrologer->slug])}}" target="_blank"><span><img src="@if(@$astrologer->profile_img!=""){{ URL::to('storage/app/public/profile_picture')}}/{{@$astrologer->profile_img}} @else {{asset('public/frontend/images/take_astro3.jpg')}} @endif" alt=""></span></a>
							 	<div class="take_astro_text">

							 		<a href="{{route('astrologer.search.publicProfile',['slug'=>@$astrologer->slug])}}" class="tack_new clickon" target="_blank" style="display: none" data-value="{{@$astrologer->slug}}" data-id="{{@$astrologer->id}}" data-profile-image="{{ asset('storage/app/public/profile_picture/'.@$astrologer->profile_img) }}"><i class="fa fa-envelope-o"></i>Talk Now</a>
							 		<h4><a href="{{route('astrologer.search.publicProfile',['slug'=>@$astrologer->slug])}}" target="_blank">{{@$astrologer->first_name}} {{@$astrologer->last_name}}</a><b><i class="fa fa-star"></i>{{@$astrologer->avg_review}}</b></h4>
								 	<ul class="talk_dat">
								 		<li><em><img src="{{asset('public/frontend/images/dollIconbag.png')}}" alt=""></em> {{@$astrologer->experience}} Years</li>
								 		

								 		@if(@$astrologer->is_audio_call=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)

								 			 @if(@$astrologer->call_discount_inr!=null && @$astrologer->call_discount_inr>0)

								 			 @php
                                                  $old_price = $astrologer->call_price;
                                                  $discount_value = ($old_price / 100) * @$astrologer->call_discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Audio Call :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->call_price}}/{{__('search.min')}} </del>-->{{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Audio Call : {{@session()->get('currencySym')}}  {{@$astrologer->call_price}}/{{__('search.min')}}
								 			@endif



								 			@else
								 			
								 			@if(@$astrologer->call_discount_usd!=null && @$astrologer->call_discount_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->call_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->call_discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Audio Call :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->call_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Audio Call : {{@session()->get('currencySym')}} {{round(@$astrologer->call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif
								 			
								 			@endif
								 			


								 		</li>
								 		@endif


								 		@if(@$astrologer->is_video_call=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)
								 			
								 			@if(@$astrologer->video_call_discount_inr!=null && @$astrologer->video_call_discount_inr>0)

								 			 @php
                                                  $old_price = $astrologer->video_call_price_inr;
                                                  $discount_value = ($old_price / 100) * @$astrologer->video_call_discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Video Call :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->video_call_discount_inr}}/{{__('search.min')}} </del>-->
                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Video Call : {{@session()->get('currencySym')}}  {{@$astrologer->call_price}}/{{__('search.min')}}
								 			@endif


								 			@else
								 			


								 			@if(@$astrologer->video_call_discount_usd!=null && @$astrologer->video_call_discount_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->video_call_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->video_call_discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Video Call :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->video_call_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Video Call : {{@session()->get('currencySym')}} {{round(@$astrologer->video_call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif

											@endif
								 			


								 		</li>
								 		@endif


								 		@if(@$astrologer->is_chat=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)

								 			@if(@$astrologer->chat_discount_inr!=null && @$astrologer->chat_discount_inr>0)

								 			 @php
                                                  $old_price = $astrologer->chat_price_inr;
                                                  $discount_value = ($old_price / 100) * @$astrologer->chat_discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Chat  :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->chat_price_inr}}/{{__('search.min')}} </del>-->
                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Chat : {{@session()->get('currencySym')}} {{@$astrologer->chat_price_inr}}/{{__('search.min')}}
								 			@endif



								 			@else
								 			



								 			@if(@$astrologer->chat_discount_usd!=null && @$astrologer->chat_discount_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->chat_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->chat_discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Chat :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->chat_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Chat : {{@session()->get('currencySym')}} {{round(@$astrologer->chat_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif



								 			
								 			@endif
								 			


								 		</li>
								 		@endif
										
										@if(@$astrologer->is_astrologer_offer_offline=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)

								 			@if(@$astrologer->offline_discount_price_inr!=null && @$astrologer->offline_discount_price_inr>0)

								 			 @php
                                                  $old_price = $astrologer->astrologer_offline_price_inr;
                                                  $discount_value = ($old_price / 100) * @$astrologer->offline_discount_price_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Offline  :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->astrologer_offline_price_inr}}/{{__('search.min')}} </del>-->
                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Offline : {{@session()->get('currencySym')}} {{@$astrologer->astrologer_offline_price_inr}}/{{__('search.min')}}
								 			@endif



								 			@else
								 			



								 			@if(@$astrologer->offline_discount_price_usd!=null && @$astrologer->offline_discount_price_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->astrologer_offline_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->offline_discount_price_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Offline :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->astrologer_offline_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Offline : {{@session()->get('currencySym')}} {{round(@$astrologer->astrologer_offline_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif



								 			
								 			@endif
								 			


								 		</li>
								 		@endif






								 		<li><em><img src="{{asset('public/frontend/images/icon5.png')}}" alt=""></em> @if(@$astrologer->astrologerExpertise->isNotEmpty())
								 			@foreach(@$astrologer->astrologerExpertise as $key3=>$expertise)
                                             {{-- {{@$expertise->experties->expertise_name}}, --}}
                                             @if($key3+1==@$astrologer->astrologerExpertise->count())
                                             {{@$expertise->experties->expertise_name}}
                                             @else
                                             {{@$expertise->experties->expertise_name}} ,
                                             @endif
                                            @endforeach
                                            @else
                                             No Experties Selected
                                            @endif</li>
								 	</ul>
							 	</div>
							 	<div class="clearfix"></div>
							 </div>
						</div>
					 @endforeach
	              	  @else
	              	  <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">No Data Found</div>
	              	  @endif
	              	  <div class="clearfix"></div>
	              	</div>
	              	<div class="clearfix"></div>
	              </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pagination-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
        <nav aria-label="Page navigation example" class="list-pagination">
          <ul class="pagination justify-content-end rtg">
            {{@$astrologers->links()}}
          </ul>
        </nav>
      </div>
        </div>
    </div>
</section>
@endsection



@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
@include('includes.toaster')
<script>
    $(document).ready(function(){
		$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });
		$(".rtg li a").click(function(){
      
      
      var url = $(this).attr('href');
      
      

      var vars = [], hash;
      var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++)
      {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
      }
      // console.log(hash[1]);
      $('#page').val(hash[1]);
      $("#filter").submit();
      return false;
    });
	$(".mobile-list").click(function() {
		$(".search-filter").slideToggle();
	});
	$(".mobile_filter").click(function() {
		$(".left-rashis").slideToggle();
	});
        $('#sort_by').change(function(){
            $('#filter').submit();
        });
        $('#show_result').change(function(){
            $('#filter').submit();
        });
    });
</script>
@endsection
