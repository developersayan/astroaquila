@extends('layouts.app')

@section('title')
@if(@$productDetails->meta_title)
<meta property="og:title" content="Gemstone Details | {{$productDetails->meta_title}}">
@else
<meta property="og:title" content="Gemstone Details | {{$productDetails->product_name}}">
@endif
@if(@$productDetails->meta_description)
<meta property="og:description" content="{!! @$productDetails->meta_description !!}">
@else
<meta property="og:description" content="{!! substr(@$productDetails->description,0,150) !!}">
@endif
@if(@$productDetails->productdefault->image)
<meta property="og:image" content="{{ URL::to('storage/app/public/gemstone')}}/{{@$productDetails->productdefault->image}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
<meta property="og:url" content="{{route('gemstone.details', ['slug'=>@$productDetails->slug])}}">
<title>Gemstone Details | {{$productDetails->product_name}}</title>
@endsection

@section('style')
@include('includes.style')
<style type="text/css">
  .color-sec{
    margin-right: 25px;
  }
  .review_moretext{
      display: none
  }
</style>

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class="pad-114">
    <div class="product-det">
        <div class="container">
            <div class="row">
                <div class="col-md-6">                    
                    <div id="product-image">
                        <a href="{{ URL::to('storage/app/public/gemstone')}}/{{@$productDetails->productdefault->image}}">
                            <img class="cloudzoom" src="{{ URL::to('storage/app/public/gemstone')}}/{{@$productDetails->productdefault->image}}" alt="" data-cloudzoom="zoomPosition:'inside', zoomOffsetX:0, zoomFlyOut:false, variableMagnification:false, disableZoom:'auto', touchStartDelay:100, propagateGalleryEvent:true ">
                        </a>
                        <div class="wish-btn"><a href="javascript:;" @if(Auth::user()==null)class="login_show" @else id="wish_list"@endif >
                            @if(@$favorite)
                            <i class="fa fa-heart"></i>
                            @else
                            <i class="fa fa-heart-o"></i>
                            @endif
                        </a></div>
                    </div>
					<div id="slider1">
                        <div class="thumbelina-but horiz left"><i class="fa fa-angle-left"></i></div>
                        <ul>
                            @foreach (@$productDetails->productimgs as $images)
                            <li>
                                <a href="{{ URL::to('storage/app/public/gemstone')}}/{{@$images->image}}" title="View">
                                    <img class="cloudzoom-gallery" src="{{ URL::to('storage/app/public/gemstone')}}/{{@$images->image}}" alt="thumbnail" data-cloudzoom="useZoom:'.cloudzoom',image:'{{ URL::to('storage/app/public/gemstone')}}/{{@$images->image}}'">
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="thumbelina-but horiz right"><i class="fa fa-angle-right"></i></div>
                    </div>
                    <div id="zoom-overlay"></div>
                </div>
                <div class="col-md-6">
                    <div class="pro-descriptipn">
                        <div class="pro-heading">
                            <h1>{{$productDetails->product_name}}</h1> <div class="gem_id_price"><h2>Gemstone ID - {{$productDetails->product_code}}</h2> - <p class="off" style="text-transform:none;">@if(@session()->get('currency')==2) ${{@$productDetails->price_per_carat_usd}} @else Rs. {{@$productDetails->price_per_carat_inr}} @endif - Price per carat</p></div></div>
                            @if(@session()->get('currency')==1)
                            <p class="off">@if(@$productDetails->discount_inr == null || @$productDetails->discount_inr == 0) @else Get {{$productDetails->discount_inr}}% off @endif</p>
							<div class="price_of_gemstone">
                            <div class="product_price priceChange">
                                @if(@$productDetails->discount_inr != null && @$productDetails->discount_inr > 0)
                                @php
                                $old_price = $productDetails->price_inr;
                                $discount_value = ($old_price / 100) * @$productDetails->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <del>₹{{@round($productDetails->price_inr)}}</del>
                                <span class="price">₹ {{round(@$new_price)}}</span>
                                @else
                                <span class="price">₹ {{round(@$productDetails->price_inr)}}</span>
                                @endif
                                <div class="clearfix"></div>
                            </div>
							
							</div>
                            @elseif(@session()->get('currency')==2)
                            <p class="off">@if(@$productDetails->discount_usd == null || @$productDetails->discount_usd == 0) @else Get {{$productDetails->discount_usd}}% off @endif</p>
                            <div class="price_of_gemstone">
                            <div class="product_price priceChange">
                                @if(@$productDetails->discount_usd != null && @$productDetails->discount_usd > 0)
                                @php
                                $old_price = $productDetails->price_usd;
                                $discount_value = ($old_price / 100) * @$productDetails->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <del>$ {{round(@$productDetails->price_usd)}}</del>
                                <span class="price"> $ {{round(@$new_price)}}</span>
                                @else
                                <span class="price">$ {{round(@$productDetails->price_usd)}}</span>
                                @endif                                
                                <div class="clearfix"></div>
                            </div>
							
							</div>
                            @endif
							

                            <hr class="pro-hr">
                            <div class="des-info">
                                @if(@$productDetails->color!="")
                                <div class="color-sec ">
                                    <h6>Color : <span>{{@$productDetails->color}}</span></h6>
                                </div>
                                @endif
                                @if(@$productDetails->size!="")
                                <div class="color-sec ">
                                    <h6>Size : <span>{{@$productDetails->size}} cm</span></h6>
                                </div>
                                @endif
                                @if(@$productDetails->product_weight!="")
                                <div class="color-sec ">
                                    <h6>Weight : <span>{{@$productDetails->product_weight}} Carat</span></h6>
                                </div>
                                @endif
                                @if(@$productDetails->shape_cut!="")
                                <div class="color-sec ">
                                    <h6>Shape Cut : <span>{{@$productDetails->shape_cut}} </span></h6>
                                </div>
                                @endif                                
                                <div class="color-sec ">
                                    <h6>Lab Certified : <span>@if(@$productDetails->lab_certified=="Y")Yes @else No @endif </span></h6>
                                </div>
                                <div class="color-sec ">
                                    <h6>COD Available : <span>@if(@$productDetails->is_cod_available=="Y")Yes @else No @endif </span></h6>
                                </div>
                                <div class="clearfix"></div>
                                @if(@session()->get('currency')==1 && $productDetails->gift_pack_price_inr != null && $productDetails->gift_pack_price_inr > 0)
                                <div class="bill-add">
                                    <label class="list_checkBox">Gift Pack Rs {{round($productDetails->gift_pack_price_inr)}}
                                        <input type="checkbox" name="gift_pack"  id="gift_pack" value="{{round($productDetails->gift_pack_price_inr)}}"> <span class="list_checkmark"  for="gift_pack"></span> </label>
                                </div>
                                @elseif(@session()->get('currency')==2 && $productDetails->gift_pack_price_usd!=null && $productDetails->gift_pack_price_usd > 0)
                                <div class="bill-add">
                                    <label class="list_checkBox">Gift Pack $ {{round($productDetails->gift_pack_price_usd)}}
                                        <input type="checkbox" name="gift_pack"  id="gift_pack" value="{{round($productDetails->gift_pack_price_usd)}}"> <span class="list_checkmark"  for="gift_pack"></span> </label>
                                </div>
                                @endif
								<div class="clearfix"></div>
								<div class="pricerabf">
								<form class="fromcaret" action="" method="post" name="priceChangeForm" id="priceChangeForm">
								@csrf
								<input type="hidden" name="gem_id" value="{{@$productDetails->id}}"/>
								<div class="color-sec new-je">
                                    <label class="list_checkBox">Gemstone weight</label>
									<select class="" id="gemstone_weight" name="gemstone_weight">
										@if(@$gemstone_price_decrease->isNotempty())
										@foreach(@$gemstone_price_decrease as $value)
										<option value="{{@$value->id}}">{{@$value->weight}} Carat - @if(@session()->get('currency')==2) ${{@$value->price_usd}} @else Rs. {{@$value->price_inr}} @endif</option>
										@endforeach
										@endif
										<option value="{{@$gemstone_price_base->id}}" selected>{{@$gemstone_price_base->weight}} Carat</option>
										@if(@$gemstone_price_increase->isNotempty())
										@foreach(@$gemstone_price_increase as $value)
										<option value="{{@$value->id}}">{{@$value->weight}} Carat + @if(@session()->get('currency')==2) ${{@$value->price_usd}} @else Rs. {{@$value->price_inr}} @endif</option>
										@endforeach
										@endif
									</select>
                                </div>
								<div class="color-sec new-je checkBox">
                                    <label class="list_checkBox">Purchase this gemstone with:</label>
									<ul>
                                            <li>
									<input type="radio" name="jewellery" id="jewel1" value="R" class="selectJewellery"/>
									<label for="jewel1">Ring</label>
									</li>
									<li>
									<input type="radio" name="jewellery" id="jewel2" value="P" class="selectJewellery"/>
									<label for="jewel2">Pendant</label>
									</li>
									<li>
									<input type="radio" name="jewellery" id="jewel3" value="B" class="selectJewellery"/>
									<label for="jewel3">Bracelet</label>
									</li>
									</ul>
                                </div>
								<div class="color-sec new-je checkBox">
                                    <label class="list_checkBox">Please select metal:</label>
									@if(@$metals->isNotempty())
									<ul>
								@foreach(@$metals as $value)
                                            <li>
									<input type="radio" name="metal" id="metal{{@$value->id}}" value="{{@$value->id}}" class="selectMetal"/>
									<label for="metal{{@$value->id}}">{{@$value->metal_name}}</label>
									</li>
									@endforeach
									</ul>									
									@endif
                                </div>
								<div class="color-sec new-je checkBox pendant_chain" style="display:none;">
                                    <label class="list_checkBox">Want to buy pendant:</label>
										<select class="" id="pendant_chain" name="pendant_chain">
											<option value="">Select</option>
											<option value="W">With Chain</option>
											<option value="O" selected>Without Chain</option>
										</select>	
                                </div>
								<div class="color-sec new-je checkBox goldpurity" style="display:none;">
								</div>								
								<div class="color-sec new-je checkBox ringsystem" style="display:none;">
                                    <label class="list_checkBox">Ring Size System:</label>									
									<select class="" id="ring_system" name="ring_system">
								<option value="">Select</option>
								@foreach(@$ring_systems as $value)
										<option value="{{@$value->id}}">{{@$value->ring_size_system}}</option>
									@endforeach
									</select>
                                </div>
								<div class="color-sec new-je checkBox ringsize" style="display:none;">
									<label class="list_checkBox">Ring Size:</label>									
									<select class="" id="ring_size" name="ring_size">
										<option value="">Select</option>
									</select>
								</div>
								@if(@$certification->isNotempty())
								<div class="color-sec new-je checkBox">
                                    <label class="list_checkBox">Certification:</label>									
									<select class="" id="certification" name="certification">
								<option value="">Select</option>
								@foreach(@$certification as $value)
										<option value="{{@$value->id}}">{{@$value->certificate_name->cert_name}} + @if(@session()->get('currency')==2) ${{@$value->price_usd}} @else Rs. {{@$value->price_inr}} @endif</option>
									@endforeach
									</select>
                                </div>
								@endif
								@if(@$certification->isNotempty())
								<div class="color-sec new-je checkBox">
                                    <label class="list_checkBox">Puja Energization:</label>
									<select class="" id="puja_energy" name="puja_energy">
								<option value="">Select</option>
								@foreach(@$puja_energization as $value)
										<option value="{{@$value->id}}">{{@$value->puja_name->puja}} + @if(@session()->get('currency')==2) ${{@$value->price_usd}} @else Rs. {{@$value->price_inr}} @endif</option>
									@endforeach
									</select>
                                </div>
								@endif
								<div class="color-sec new-je checkBox selectdesign" style="display:none;">
								
                                </div>
								<div class="clearfix"></div>
								</form>
								</div>
								<div class="clearfix"></div>
                            </div>
                            @if(@$productDetails->availability=="Y")
                            <div class="marb-20">
                                <div class="color-sec qty-sec float-left">
                                   <h6>Quantity</h6>
                                   <div class="product-quantity">
                                      <div class="quantity-selectors">
                                         <button type="button" class="decrement-quantity" aria-label="Subtract one" data-direction="-1" disabled="disabled"><span>&#8722;</span></button>
                                         <input data-min="1" data-max="0" type="text" name="quantity" value="1" readonly="true" id="quantity">
                                         <button type="button" class="increment-quantity" aria-label="Add one" data-direction="1"><span>&#43;</span></button>
                                         <div class="clearfix"></div>
                                      </div>
                                   </div>
                                </div>

                                <div class="color-sec btn-3 float-right right-btn-3">
                                   <h6 class="invisible">Quantity</h6>
                                   <button type="button" class="btn addcardbtn" id="addToCart" data-product="{{$productDetails->id}}"><img src="{{ URL::to('public/frontend/images/addbtn.png')}}"> Add to Cart</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @else
                            <div class="marb-20">
                                {{-- <div class="color-sec qty-sec float-left">
                                   <h6>Quantity</h6>
                                   <div class="product-quantity">
                                      <div class="quantity-selectors">
                                         <button type="button" class="decrement-quantity" aria-label="Subtract one" data-direction="-1" disabled="disabled"><span>&#8722;</span></button>
                                         <input data-min="1" data-max="0" type="text" name="quantity" value="1" readonly="true" id="quantity">
                                         <button type="button" class="increment-quantity" aria-label="Add one" data-direction="1"><span>&#43;</span></button>
                                         <div class="clearfix"></div>
                                      </div>
                                   </div>
                                </div> --}}

                                <div class="color-sec btn-3 float-right right-btn-3">
                                   <h6 class="invisible">Quantity</h6>
                                   <button type="button" class="btn addcardbtn" data-product="{{$productDetails->id}}">
                                    {{-- <img src="{{ URL::to('public/frontend/images/addbtn.png')}}"> --}}
                                     Out Of Stock</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @endif
                            <hr class="pro1-hr">
                            <div class="share-section">
                                <button class="float-left report-btn">Send to a friend</button>
                                <div class="share-btn float-right">
                                   <p class="float-left">Share this product :</p>
                                   <ul class="share-list float-left" style="width: 200px">
                                       <div class="sharethis-inline-share-buttons"></div>

                                   </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <hr class="pro1-hr">
                        </div>
                    </div>
                </div>
                @if( @$productDetails->productPlanets->isNotEmpty() || @$productDetails->productNakshtra->isNotEmpty()||@$productDetails->productPlanets->isNotEmpty()||@$productDetails->productRashi->isNotEmpty()||@$productDetails->country_of_origin!=""||@$productDetails->placement!=""||@$productDetails->purpose_id!=""||@$productDetails->manta_to_chant!="")

                <div class="row" style="margin-bottom: 25px">
                    <div class="col-12">
                       <div class="item-description">


                        @if(@$productDetails->country_of_origin!="")
                           <h2>Country Of Origin </h2>
                           <p>{{@$productDetails->country_name->name}} </p>
                           @endif
                        @if(@$productDetails->placement!="")
                        <h2>Placement</h2>
                        <p>{{@$productDetails->placement}} </p>
                        @endif
                        @if(@$productDetails->purpose_id!="")
                        <h2>Purpose </h2>
                        <p>{{@$productDetails->purpose_name->name}} </p>
                        @endif

                        @if(@$productDetails->productDeity->isNotEmpty())
                        <h2>Deity </h2>
                        <p>
                            @foreach (@$productDetails->productDeity as $deity) {{@$deity->deities->name}} @if (!$loop->last),@endif @endforeach
                        </p>
                        @endif
                        @if(@$productDetails->productNakshtra->isNotEmpty())
                        <h2>Nakshatras </h2>
                        <p>
                            @foreach (@$productDetails->productNakshtra as $nakshatra) {{@$nakshatra->nakshatras->name}} @if (!$loop->last),@endif @endforeach
                        </p>
                        @endif

                        @if(@$productDetails->productPlanets->isNotEmpty())
                        <h2>Planets </h2>
                        <p>
                            @foreach (@$productDetails->productPlanets as $planet) {{@$planet->planets->planet_name}} @if (!$loop->last),@endif @endforeach
                        </p>
                        @endif


                       @if(@$productDetails->productRashi->isNotEmpty())
                       <h2>Rashis </h2>
                       <p>
                           @foreach (@$productDetails->productRashi as $rashi) {{@$rashi->rashis->name}} @if (!$loop->last),@endif @endforeach
                       </p>
                       @endif
                       @if(@$productDetails->manta_to_chant!="")
                       <h2>Mantra To Chant </h2>
                       <p>{{@$productDetails->manta_to_chant}}</p>
                       @endif
                       </div>
                    </div>
                 </div>
                @endif

                <div class="row">
                    <div class="col-12">
                       <div class="item-description">
                           <h2>{{__('search.product_description')}}</h2>
                           <div class="article">
                               @if(strlen(@$productDetails->description) > 350)
                               <p class="aboutRemaove">{!! substr(@$productDetails->description, 0, 350 ) . '...' !!}</p>
                               <p class="moretext">{!! @$productDetails->description !!}</p>
                               <a class="moreless-button">{{__('search.read_more')}} +</a>
                               @else
                               <p>{!! @$productDetails->description !!}</p>
                               @endif
                            </div>
                        </div>
                    </div>
                </div>
				@if(@$productDetails->shipping_policy)
				<div class="row">
                    <div class="col-12">
                       <div class="item-description">
                           <h2>{{__('search.shipping_policy')}}</h2>
                           <div class="article">
                               @if(strlen(@$productDetails->shipping_policy) > 350)
                               <p class="aboutRemaove">{!! substr(@$productDetails->shipping_policy, 0, 350 ) . '...' !!}</p>
                               <p class="moretext">{!! @$productDetails->shipping_policy !!}</p>
                               <a class="moreless-button">{{__('search.read_more')}} +</a>
                               @else
                               <p>{!! @$productDetails->shipping_policy !!}</p>
                               @endif
                            </div>
                        </div>
                    </div>
                </div>
				@endif
				@if(@$productDetails->terms_of_refund)
				<div class="row">
                    <div class="col-12">
                       <div class="item-description">
                           <h2>{{__('search.terms_of_refund')}}</h2>
                           <div class="article">
                               @if(strlen(@$productDetails->terms_of_refund) > 350)
                               <p class="aboutRemaove">{!! substr(@$productDetails->terms_of_refund, 0, 350 ) . '...' !!}</p>
                               <p class="moretext">{!! @$productDetails->terms_of_refund !!}</p>
                               <a class="moreless-button">{{__('search.read_more')}} +</a>
                               @else
                               <p>{!! @$productDetails->terms_of_refund !!}</p>
                               @endif
                            </div>
                        </div>
                    </div>
                </div>
				@endif
				@if(@$productDetails->how_to_place)
				<div class="row">
                    <div class="col-12">
                       <div class="item-description">
                           <h2>{{__('search.how_to_place')}}</h2>
                           <div class="article">
                               @if(strlen(@$productDetails->how_to_place) > 350)
                               <p class="aboutRemaove">{!! substr(@$productDetails->how_to_place, 0, 350 ) . '...' !!}</p>
                               <p class="moretext">{!! @$productDetails->how_to_place !!}</p>
                               <a class="moreless-button">{{__('search.read_more')}} +</a>
                               @else
                               <p>{!! @$productDetails->how_to_place !!}</p>
                               @endif
                            </div>
                        </div>
                    </div>
                </div>
				@endif
				@if(@$productDetails->productVideo)
                @if(@$productDetails->productVideo->image && @$productDetails->productVideo->video_link)
                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description video-center">
                          <h2>Product Video </h2>
                          <iframe width="560" height="315" src="https://www.youtube.com/embed/{{@$productDetails->productVideo->image}}" frameborder="0" allowfullscreen></iframe>
                       </div>
                    </div>
                </div>
                @else
					<div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description video-center">
                          <h2>Product Video </h2>
                          <video src="{{asset('storage/app/public/gemstone_video/'.@$productDetails->productVideo->image)}}" loop muted controls ></video>
                       </div>
                    </div>
                </div>
				@endif
				@endif
                {{-- @if(@$productDetails->manta_to_chant!="")
                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                        <div class="item-description">
                            <h2>Mantra To Chant</h2>
                            <div class="article">
                                <p>{{@$productDetails->manta_to_chant}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}
                <div class="customer_review_box">
					<h5>{{__('search.customer_review')}} :</h5>
					<div class="review_box">
						<div class="review_left">
							<b>{{$productDetails->avg_review}}</b>
							<ul>
							@php
							$rating=explode('.',$productDetails->avg_review);
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
							<strong>(Review {{$productDetails->tot_review}})</strong>
						</div>
						<div class="review_right">
							<ul>
								<li>
									<em>5</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($productReview)>0?100*(count($productReview->where('ratting_number',5))/count($productReview)):0}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>( {{count(@$productReview->where('ratting_number', 5)) }} Customers)</b>
								</li>
								<li><em>4</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($productReview)>0?100*(count($productReview->where('ratting_number',4))/count($productReview)):0}}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$productReview->where('ratting_number',4))}} Customers)</b>
								</li>
								<li><em>3</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($productReview)>0?100*(count($productReview->where('ratting_number',3))/count($productReview)):0}}%;%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$productReview->where('ratting_number',3))}} Customers)</b>
								</li>
								<li><em>2</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: {{count($productReview)>0?100*(count($productReview->where('ratting_number',2))/count($productReview)):0}}%;%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>({{count(@$productReview->where('ratting_number',2))}} Customers)</b>
								</li>
							</ul>
						</div>
					</div>
                    @if($productReview->count()>0 )
					<div class="review_person">
                        @foreach ($productReview as $key=>$review)
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
                    @if($productReview->count()>2 )
					<a class="moreless-button5  show_more">Show More Reviews +</a>
                    @endif
                    @endif
				</div>
            </div>
        </div>
    </section>

 <!-- Buy Gem Stone -->

 <section class="gem-stone-sec">
     <div class="container">
      <div id="success"></div>
         <div class="pghed">
             <h3>Related  <b>Gemstones</b></h3>
             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
         </div>
         <div class="gem-stone-iner">
             <div class="owl-carousel" id="owl-carousel-1">
                 @foreach ($similarProducts as $product)
                 <div class="item">
                    <div class="gem-stone-item product_card">
                        <span>
                            <a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" target="_blank">
                            @if(@$product->productdefault->image)
                            <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$product->productdefault->image}}"alt="">
                            @else
                            <img src="{{ URL::to('public/frontend/images/ston1.png')}}" alt="">
                            @endif
                            </a>
                        </span>
                        <div class="gem-stone-text">
                            <h5><a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" target="_blank">
                                @if(strlen(@$product->product_name) > 45)
                                {!! substr(@$product->product_name, 0, 45 ) . '..' !!}
                                @else
                                {!!@$product->product_name!!}
                                @endif
                            </a></h5>
                            @if(strlen(@$product->description) > 60)
                            <p>{!! substr(@$product->description, 0, 60 ) . '...' !!}</p>
                            @else
                            <p>
                                {!! @$product->description !!}
                            </p>
                            @endif
                            <ul>
                                <li>
                                    @if(@session()->get('currency')==1)

                                                @if(@$product->discount_inr!=null && @$product->discount_inr>0)
                                                @php
                                                 $old_price = $product->price_inr;
                                                  $discount_value = ($old_price / 100) * @$product->discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>₹ {{@$product->price_inr}} </del>

                                                ₹ {{round(@$new_price,2)}}
                                                @else
                                                ₹ {{@$product->price_inr}}
                                                @endif

                                                @elseif(@session()->get('currency')==2)

                                                @if(@$product->discount_usd!=null && @$product->discount_usd>0)
                                                @php
                                                 $old_price = $product->price_usd;
                                                  $discount_value = ($old_price / 100) * @$product->discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>$ {{@$product->price_usd}} </del>

                                                $ {{round(@$new_price,2)}}
                                                @else
                                                $ {{@$product->price_usd}}
                                                @endif

                                                @endif
                                    {{-- @if(@session()->get('currency')==1)
                                    @if(@$product->discount_inr!=null&&@$product->discount_inr>0)
                                    @php $discountPrice = 100 - $product->discount_inr
                                    @endphp
                                    <del>₹ {{round(@$product->price_inr * 100/$discountPrice)}}</del>
                                    @endif
                                    ₹ {{round(@$product->price_inr)}}

                                    @elseif(@session()->get('currency')==2)
                                    @if(@$product->discount_usd!=null&&@$product->discount_usd>0)
                                    @php $discountPrice = 100 - $product->discount_usd
                                    @endphp
                                    <del>$ {{round(@$product->price_usd * 100/$discountPrice)}}</del>
                                    @endif
                                    $ {{round(@$product->price_usd)}}
                                    @endif --}}
                                </li>
                                <li>
                                    @if(@$product->availability=="Y")
                                    <a href="javascript:;" class="pag_btn buynow" data-product="{{@$product->id}}">Buy Now</a>
                                    @else
                                    <a href="javascript:;" class="pag_btn">Out Of Stock</a>
                                    @endif
                                </li>

                                {{-- <li><a href="javascript:;" class="pag_btn buynow" data-product="{{@$product->id}}">Buy Now</a></li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                 @endforeach

                 
             </div>

         </div>
     </div>
 </section>
@endsection

@endsection



@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
<script>
    $(document).ready(function() {
		$("#owl-carousel-1").owlCarousel({
	 	 	margin: 20,
			nav: true,
			loop: false,
			responsiveClass:true,
			responsiveBaseElement:".gem-stone-sec",
			responsive: {
			  	0: {
					items: 1
			  	},
			  	480: {
					items:2
			  	},
			  	992: {
					items:2
			  	},
			}
      	});
		$('#slider1').Thumbelina({
                    $bwdBut:$('#slider1 .left'), 
                    $fwdBut:$('#slider1 .right')
                });
        $('.review_more').click(function(){
            var id = $(this).data('id');
            console.log(id);
            $('#review_less'+id).css('display','block');
            $('#review_more'+id).css('display','none');
            $('#review_lesstext'+id).css('display','none');
            $('#review_moretext'+id).css('display','block');
        });
        $('.review_less').click(function(){
            var id = $(this).data('id');
            console.log(id);
            $('#review_less'+id).css('display','none');
            $('#review_more'+id).css('display','block');
            $('#review_lesstext'+id).css('display','block');
            $('#review_moretext'+id).css('display','none');
        });
        $('.moreless-button5').click(function() {
            $('.moretext5').slideToggle();
            if ($('.moreless-button5').text() == "Show More Reviews +") {
                $(this).text("Show Less Reviews -")
            } else {
                $(this).text("Show More Reviews +")
            }
        });
		$('body').on('change','#gemstone_weight,#certification,#puja_energy,#gold_purity,#pendant_chain,#ring_system',function(){
			$.ajax({
			url:'{{route('fetch.gemstone.price.data')}}',
			type:'POST',
			dataType:'JSON',
			data:$('#priceChangeForm').serialize(),
			success:function(data){
			  //console.log(data);
			  if(data.success=='success')
			  {
				  $('.priceChange').html(data.html);
				  if(data.gold_purity_select!='')
				  {
					  $('.goldpurity').html(data.gold_purity_select);
					  $('.goldpurity').show();
				  }
				  else
				  {
					  $('.goldpurity').html('');
					  $('.goldpurity').hide();
				  }
				  if(data.ring_size_option!='')
				  {
					  $('#ring_size').html(data.ring_size_option);
					  $('.ringsize').show();
				  }
				  else
				  {
					  $('#ring_size').html('');
					  $('.ringsize').hide();
				  }
				  if(data.bracelet_design_option!='')
				  {
					  $('.selectdesign').html(data.bracelet_design_option);
					  $('.selectdesign').show();
				  }
				  else
				  {
					  $('.selectdesign').html('');
					  $('.selectdesign').hide();
				  }
				  
			  }
			  
			}
		  })
		});
		$('body').on('click','.selectMetal',function(){
			$.ajax({
			url:'{{route('fetch.gemstone.price.data')}}',
			type:'POST',
			dataType:'JSON',
			data:$('#priceChangeForm').serialize(),
			success:function(data){
			  //console.log(data);
			  if(data.success=='success')
			  {
				  $('.priceChange').html(data.html);
				  if(data.gold_purity_select!='')
				  {
					  $('.goldpurity').html(data.gold_purity_select);
					  $('.goldpurity').show();
				  }
				  else
				  {
					  $('.goldpurity').html('');
					  $('.goldpurity').hide();
				  }
				  if(data.ring_size_option!='')
				  {
					  $('#ring_size').html(data.ring_size_option);
					  $('.ringsize').show();
				  }
				  else
				  {
					  $('#ring_size').html('');
					  $('.ringsize').hide();
				  }
				  if(data.bracelet_design_option!='')
				  {
					  $('.selectdesign').html(data.bracelet_design_option);
					  $('.selectdesign').show();
				  }
				  else
				  {
					  $('.selectdesign').html('');
					  $('.selectdesign').hide();
				  }
				  
			  }
			  
			}
		  })
		});
		$('body').on('click','.selectJewellery',function(){
			var obj=$(this);
			if(obj.is(':checked') && obj.val()=='P')
			{
				$('.pendant_chain').show();
			}
			else
			{
				$('.pendant_chain').hide();
			}
			if(obj.is(':checked') && obj.val()=='R')
			{
				$('.ringsystem').show();
			}
			else
			{
				$('.ringsystem').hide();
			}
			$.ajax({
			url:'{{route('fetch.gemstone.price.data')}}',
			type:'POST',
			dataType:'JSON',
			data:$('#priceChangeForm').serialize(),
			async:false,
			success:function(data){
			  //console.log(data);
			  if(data.success=='success')
			  {
				  $('.priceChange').html(data.html);
				  if(data.gold_purity_select!='')
				  {
					  $('.goldpurity').html(data.gold_purity_select);
					  $('.goldpurity').show();
				  }
				  else
				  {
					  $('.goldpurity').html('');
					  $('.goldpurity').hide();
				  }
				  if(data.ring_size_option!='')
				  {
					  $('#ring_size').html(data.ring_size_option);
					  $('.ringsize').show();
				  }
				  else
				  {
					  $('#ring_size').html('');
					  $('.ringsize').hide();
				  }
				  if(data.bracelet_design_option!='')
				  {
					  $('.selectdesign').html(data.bracelet_design_option);
					  $('.selectdesign').show();
				  }
				  else
				  {
					  $('.selectdesign').html('');
					  $('.selectdesign').hide();
				  }
				  
			  }
			  
			}
		  })
		});
		$('body').on('click','.selectDesign',function(){
			$.ajax({
			url:'{{route('fetch.gemstone.price.data')}}',
			type:'POST',
			dataType:'JSON',
			data:$('#priceChangeForm').serialize(),
			success:function(data){
			  //console.log(data);
			  if(data.success=='success')
			  {
				  $('.priceChange').html(data.html);
				  if(data.gold_purity_select!='')
				  {
					  $('.goldpurity').html(data.gold_purity_select);
					  $('.goldpurity').show();
				  }
				  else
				  {
					  $('.goldpurity').html('');
					  $('.goldpurity').hide();
				  }
				  if(data.ring_size_option!='')
				  {
					  $('#ring_size').html(data.ring_size_option);
					  $('.ringsize').show();
				  }
				  else
				  {
					  $('#ring_size').html('');
					  $('.ringsize').hide();
				  }
				  if(data.bracelet_design_option!='')
				  {
					  $('.selectdesign').html(data.bracelet_design_option);
					  $('.selectdesign').show();
				  }
				  else
				  {
					  $('.selectdesign').html('');
					  $('.selectdesign').hide();
				  }
				  
			  }
			  
			}
		  })
		});
    });
</script>
@include('includes.toaster')
<!---------deatils------->
<script>
    $('.product-thumbs-track > .pt').on('click', function() {
     $('.product-thumbs-track .pt').removeClass('active');
     $(this).addClass('active');
     var imgurl = $(this).data('imgbigurl');
     var bigImg = $('.product-big-img').attr('src');
     if(imgurl != bigImg) {
       $('.product-big-img').attr({
         src: imgurl
       });
       $('.zoomImg').attr({
         src: imgurl
       });
     }
   });
//    $('.product-pic-zoom').zoom();
</script>
 <script src="{{ URL::to('public/frontend/js/thumbelina.js')}}"></script>
 <script src="{{ URL::to('public/frontend/js/product-carousel.js')}}"></script>

<!---------input increament---------->
<script type="text/javascript">
  $(".increment-quantity,.decrement-quantity").on("click", function(ev) {
     var currentQty = $('input[name="quantity"]').val();
     var qtyDirection = $(this).data("direction");
     var newQty = 0;
     if(qtyDirection == "1") {
        newQty = parseInt(currentQty) + 1;
     } else if(qtyDirection == "-1") {
        newQty = parseInt(currentQty) - 1;
     }
     // make decrement disabled at 1
     if(newQty == 1) {
        $(".decrement-quantity").attr("disabled", "disabled");
     }
     if(newQty == 10) {
        $(".increment-quantity").attr("disabled", "disabled");
     }
     // remove disabled attribute on subtract
     if(newQty > 1) {
        $(".decrement-quantity").removeAttr("disabled");
     }
     if(newQty < 10 ) {
        $(".increment-quantity").removeAttr("disabled");
     }
     if(newQty > 0) {
        newQty = newQty.toString();
        $('input[name="quantity"]').val(newQty);
     } else {
        $('input[name="quantity"]').val("1");
     }
  });
  </script>
  <script type="text/javascript">

$('.moreless-button').click(function() {
var obj = $(this);
if (obj.text() == "{{__('search.read_more')}} +") {
    obj.prev().prev().hide();
    obj.prev().show();
    obj.text("{{__('search.read_less')}} -")
} else {
    obj.prev().prev().show();
    obj.prev().hide();
    obj.text("{{__('search.read_more')}} +")
}
// $('.moretext').slideToggle();

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
 if(!$target.closest('.shopcutBx').length && !$target.closest('.shopcut').length && $('.shopcutBx').is(":visible")) {
     $('.shopcutBx').slideUp();
    }
})
</script>
<script>
$(document).ready(function(){
    $('#addToCart').click(function(){
        var productId = $(this).data('product');
        var quantity = $('#quantity').val();
        var gift_pack = 0 ;
        if($('#gift_pack').is(":checked")) {
            gift_pack=1;
        } else {
            gift_pack=0;
        }
        console.log(gift_pack);
        console.log(productId)
        var reqData = {
			'jsonrpc': '2.0',
			'_token': '{{csrf_token()}}',
			'params': {
				productId: productId,
				quantity: quantity,
                gift_pack:gift_pack
			}
		};
        $.ajax({
  			url: '{{ route('product.add.to.cart') }}',
  			type: 'post',
  			dataType: 'json',
  			data: reqData,
  		})
		.done(function(response) {
			console.log(response);
            console.log(response.result.cart.length)
            if (response.result.insert=="insert") {
                toastr.success('Product added to cart successfully')
            //   alert('Product added to cart successfully');
            }
            if (response.result.updated=="updated") {
                toastr.success('Product quantity updated successfully')
            //   alert('Product quantity updated successfully');
            }

            $('#cartLi .noti').text(response.result.cart.length);
            $('#cartLi .shopcutBx').html();
            $('#cartLi .shopcutBx').html(response.result.html);
		})
		.fail(function(error) {
			console.log("error", error);
		})
		.always(function() {
			console.log("complete");
		})
    })
    $('.buynow').click(function(){
            var productId = $(this).data('product');
            var quantity = 1;
            console.log(productId)
            var reqData = {
                'jsonrpc': '2.0',
                '_token': '{{csrf_token()}}',
                'params': {
                    productId: productId,
                    quantity: quantity
                }
            };
            $.ajax({
                  url: '{{ route('product.add.to.cart') }}',
                  type: 'post',
                  dataType: 'json',
                  data: reqData,
              })
            .done(function(response) {
                console.log(response);
                console.log(response.result.cart.length)
                if (response.result.insert=="insert") {
                //   alert('Product added to cart successfully');
                }
                if (response.result.updated=="updated") {
                //   alert('Product quantity updated successfully');
                }

                $('#cartLi .noti').text(response.result.cart.length);
                $('#cartLi .shopcutBx').html();
                $('#cartLi .shopcutBx').html(response.result.html);
                window.location.href="{{route('product.shopping.cart')}}";
            })
            .fail(function(error) {
                console.log("error", error);
            })
            .always(function() {
                console.log("complete");
            })
        });
		$('#gemstone_weight').change(function(){
			
		});
})
</script>

<script type="text/javascript">
  function delpost(event)
  {
    if( confirm('Are you sure you want to delete this product from cart?')){
    var reqData = {
      'jsonrpc': '2.0',
      '_token': '{{csrf_token()}}',
      'params': {
        productId: event,
      }
    };
    $.ajax({
        url: '{{ route('product.add.to.cart.delete-ajax') }}',
        type: 'post',
        dataType: 'json',
        data: reqData,
      })
    .done(function(response) {
      if (response.result.success=="success") {
          location.reload();
       }
    })
    .fail(function(error) {
      console.log("error", error);
    })
    }
  }
</script>
<script>
    $('#wish_list').click(function(){
        window.location='{{route('add.to.favorite',['id'=>@$productDetails->id])}}';
    })
</script>
@endsection
