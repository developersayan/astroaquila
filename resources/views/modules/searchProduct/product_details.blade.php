@extends('layouts.app')

@section('title')
<meta name="title" content="{{@$productDetails->meta_title}}">
<meta name="description" content="{{strip_tags(@$productDetails->meta_description)}}">
@if(@$productDetails->meta_title)
<meta property="og:title" content="Product Details | {{$productDetails->meta_title}}">
@else
<meta property="og:title" content="Product Details | {{$productDetails->product_name}}">
@endif
@if(@$productDetails->meta_description)
<meta property="og:description" content="{{ strip_tags(@$productDetails->meta_description) }}">
@else
<meta property="og:description" content="{{ substr(strip_tags(@$productDetails->description),0,150) }}">
@endif
@if(@$productDetails->productdefault->image)
<meta property="og:image" content="{{ URL::to('storage/app/public/Products')}}/{{@$productDetails->productdefault->image}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
<meta property="og:url" content="{{route('product.search.details', ['slug'=>@$productDetails->slug])}}">
<title>Product Details | {{$productDetails->product_name}}</title>
@endsection

@section('style')
@include('includes.style')
<link href="https://www.starplugins.com/sites/starplugins/js/thumbelina/thumbelina.css" rel="stylesheet"> 
<style type="text/css">
  .color-sec{
    margin-right: 25px;
  }
  .review_moretext{
      display: none
  }
  /* div that surrounds Cloud Zoom image and content slider. */
            #surround {
                width:100%;
            }
            
            /* Image expands to width of surround */
            img.cloudzoom {
                width:100%;
            }
            .main-section{
               background: #f9f9f9;
            }
            .details-desc{
               border: 1px solid #e2e2e2 ;
               padding: 20px;
            }
            /* CSS for slider - will expand to width of surround */
</style>

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
                                 <li><a href="{{route('product.all.categories')}}"> {{@$productDetails->productscat->name}} </a> <span>    @if(@$productDetails->sub_category_id!="")         &nbsp; /  &nbsp; <a href="{{route('product.sub.categories',['id'=>@@$productDetails->productscat->id])}}">{{@$productDetails->products_subcat->name}}</a></span> @endif</li>
                                 <li><a href="#"> &nbsp; /  &nbsp; {{@$productDetails->product_name}} </a><span>             &nbsp; /  &nbsp;</span></li>
                                 <li><span>{{@$productDetails->product_code}}</span></li>
                                 <div class="clearfix"></div>
                              </ul>
                           </div>
                           <div class="details-captions page_banner_data">
                              <h1>{{@$productDetails->product_name}}</h1>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->description!!}</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="container">
                     <div class="row">
                        <div class="col-12">
                           <ul class="nav nav-tabs" role="tablist">
                              @if(@$productDetails->significance!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$productDetails->significance!="") show active @endif" data-toggle="tab" href="#home">Significance and Benefits</a>
                              </li>
                              @endif
                              @if(@$productDetails->how_to_place!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$productDetails->significance=="" && @$productDetails->how_to_place!="") show active @endif" data-toggle="tab" href="#menu1" id="who_when_tab">Who, How & When </a>
                              </li>
                              @endif

                              @if(@$productDetails->manta_to_chant!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant!="") show active @endif" data-toggle="tab" href="#menu2" id="mantra_tab">Related Mantra</a>
                              </li>
                              @endif
                              @if(@$productDetails->clarity!="")
                              <li class="nav-item">
                                 <a class="nav-link @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant=="" && @$productDetails->clarity!="") show active @endif" data-toggle="tab" href="#menu3" id="usage_tab">Usage </a>
                              </li>
                              @endif
                              
                              @if(@$all_faq_cat->isNotEmpty())
                              <li class="nav-item">
                                 <a class="nav-link @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant=="" && @$productDetails->clarity=="") show active @endif" data-toggle="tab" href="#menu5" id="faq_tab">FAQ</a>
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
                        <div id="home" class="container tab-pane @if(@$productDetails->significance!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Significance and Benefits</h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->significance!!}</p>                              
                        </div>
                        
                        </div>

                        <div id="menu1" class="container tab-pane fade @if(@$productDetails->significance=="" && @$productDetails->how_to_place!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Who, How & When  </h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->how_to_place!!}</p>
                              </div>
                           </div>

                        <div id="menu2" class="container tab-pane fade @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Related Mantra</h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->manta_to_chant!!}</p>                             
                           </div>
                        </div>
                        <div id="menu3" class="container tab-pane fade @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant=="" && @$productDetails->clarity!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Usage</h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->clarity!!}</p>
                           </div>
                        </div>
                        @if(@$all_faq_cat->isNotEmpty())
                        <div id="menu5" class="container tab-pane fade @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant=="" && @$productDetails->clarity=="" && !@$faq_status) show active @endif">
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
    
    <div class="product-det astro-product-slider" >
        <div class="container">
            <div class="row">
                <div class="col-md-6">
				<div id="surround">
					    <div class="new-imgs astro-imgs">
                    <em>
					<img class="cloudzoom" alt ="Cloud Zoom small image" id ="zoom1" src="{{ URL::to('storage/app/public/Products')}}/{{@$productDetails->productdefault->image}}"
					   data-cloudzoom='
					   zoomPosition:"inside",
						   zoomSizeMode:"image",
						   autoInside: 550
					   '>
					   
					   <div class="wish-btn"><a href="javascript:;" @if(Auth::user()==null)class="login_show" @else id="wish_list"@endif >
                            @if(@$favorite)
                            <i class="fa fa-heart"></i>
                            @else
                            <i class="fa fa-heart-o"></i>
                            @endif
                        </a></div>
						</em>
						</div>
				 
				 
					<div id="slider1">
						<div class="thumbelina-but horiz left">&#706;</div>
						<ul>
						@foreach (@$productDetails->productimgs as $images)
							<li><img class='cloudzoom-gallery' src="{{ URL::to('storage/app/public/Products')}}/{{@$images->image}}" 
									 data-cloudzoom ="useZoom:'.cloudzoom', image:'{{ URL::to('storage/app/public/Products')}}/{{@$images->image}}' "></li>
									 @endforeach
						</ul>
						<div class="thumbelina-but horiz right">&#707;</div>
						
					</div>
					
				</div>
                    
                </div>
                <div class="col-md-6">
                    <div class="pro-descriptipn">
                        {{-- <div class="pro-heading">
                            <h1>{{$productDetails->product_name}}</h1> <h2>Product ID - {{$productDetails->product_code}}</h2></div> --}}
                            @if(@session()->get('currency')==1)
                            <p class="off">@if(@$productDetails->discount_inr == null || @$productDetails->discount_inr == 0) @else Get {{$productDetails->discount_inr}}% off @endif</p>
                            <div class="product_price">
                                @if(@$productDetails->discount_inr != null && @$productDetails->discount_inr > 0)
                                @php
                                $old_price = $productDetails->price_inr;
                                $discount_value = ($old_price / 100) * @$productDetails->discount_inr;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <del>{{@session()->get('currencySym')}} {{$productDetails->price_inr}}</del>
                                <span class="price">{{@session()->get('currencySym')}}  {{round(@$new_price,2)}}</span>

                                <input type="hidden" name="product_price_div" id="product_price_div" value="{{round(@$new_price,2)}}">
                                
                                @else
                                <span class="price">{{@session()->get('currencySym')}}  {{@$productDetails->price_inr}}</span>
                                <input type="hidden" name="product_price_div" id="product_price_div" value="{{@$productDetails->price_inr}}">
                                @endif
                                {{-- @if(@$productDetails->discount_inr != null && @$productDetails->discount_inr > 0)
                                @php
                                $discount_value = 100 - @$productDetails->discount_inr;
                                @endphp
                                <del>$ {{round($productDetails->price_inr * 100/$discount_value)}}</del>
                                <span class="price">₹ {{round(@$productDetails->price_inr)}}</span>
                                @else
                                <span class="price">₹ {{round(@$productDetails->price_inr)}}</span>
                                @endif --}}
                                <div class="clearfix"></div>
                            </div>
                            @else
                            <p class="off">@if(@$productDetails->discount_usd == null || @$productDetails->discount_usd == 0) @else Get {{$productDetails->discount_usd}}% off @endif</p>
                            <div class="product_price">
                                @if(@$productDetails->discount_usd != null && @$productDetails->discount_usd > 0)
                                @php
                                $old_price = @$custom * $productDetails->price_usd;
                                $discount_value = ($old_price / 100) * @$productDetails->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <del>{{@session()->get('currencySym')}} {{round( @$productDetails->price_usd *currencyConversionCustom(),2)}}</del>
                                <span class="price"> {{@session()->get('currencySym')}} {{round(@$new_price,2)}}</span>
                                <input type="hidden" name="product_price_div" id="product_price_div" value="{{round(@$new_price,2)}}">
                                @else
                                <span class="price">{{@session()->get('currencySym')}} {{round( @$productDetails->price_usd *currencyConversionCustom(),2)}}</span>
                                 <input type="hidden" name="product_price_div" id="product_price_div" value="{{round( @$productDetails->price_usd *currencyConversionCustom(),2)}}">
                                @endif

                                {{-- @if(@$productDetails->discount_usd != null && @$productDetails->discount_usd > 0)
                                @php
                                $discount_value = 100 - @$productDetails->discount_usd;
                                @endphp
                                <del>$ {{round($productDetails->price_usd * 100/$discount_value)}}</del>
                                <span class="price"> $ {{round(@$productDetails->price_usd)}}</span>
                                @else
                                <span class="price">$ {{round(@$productDetails->price_usd)}}</span>
                                @endif --}}
                                <div class="clearfix"></div>
                            </div>
                            @endif

                            <hr class="pro-hr">
                            <div class="des-info">
                                {{-- @if(@$productDetails->color!="")
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
                                    <h6>Weight : <span>{{@$productDetails->product_weight}} gm</span></h6>
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


                                 @if(@$productDetails->seller_id!="")
                                <div class="color-sec ">
                                    <h6>Seller Name  : <span>{{@$productDetails->seller->seller_name}} </span></h6>
                                </div>
                                @endif

                                <div class="color-sec ">
                                    <h6>Refundable : <span>@if(@$productDetails->refundable=="Y")Yes @else No @endif  </span></h6>
                                </div>
                                @if(@$productDetails->refundable=="Y")
                                <div class="color-sec ">
                                    <h6>Refundable Status : <span> @if(@$productDetails->refundable_status=="E")Exchange Only @elseif(@$productDetails->refundable_status=="'FR") Fully Refundable @elseif(@$productDetails->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif  </span></h6>
                                </div>
                                @endif
                                @if(@session()->get('currency')==1)
                                @if(@$productDetails->delivery_days_india!="")
                                <div class="color-sec ">
                                    <h6>Delivery In : <span> {{@$productDetails->delivery_days_india}} days  </span></h6>
                                </div>
                                @endif
                                @else
                                @if(@$productDetails->delivery_days_outside_india!="")
                                <div class="color-sec ">
                                    <h6>Delivery In : <span> {{@$productDetails->delivery_days_outside_india}} days  </span></h6>
                                </div>
                                @endif
                                @endif --}}
                                {{-- <div class="color-sec ">
                                    <h6>Availabilty : <span>@if(@$productDetails->availability=="Y")Yes @else No @endif </span></h6>
                                </div> --}}
                                {{-- <div class="color-sec ">
                                    <h6>Shippable Product: <span>@if(@$productDetails->shipable=="Y")Yes @else No @endif </span></h6>
                                </div> --}}
                                <div class="clearfix"></div>
                                @if(@session()->get('currency')==1 && $productDetails->gift_pack_price_inr != null && $productDetails->gift_pack_price_inr > 0)
                                <div class="bill-add">
                                    <label class="list_checkBox dis-checkbox">Gift Pack Rs {{$productDetails->gift_pack_price_inr}}
                                        <input type="checkbox" name="gift_pack"  id="gift_pack" value="{{$productDetails->gift_pack_price_inr}}"> <span class="list_checkmark"  for="gift_pack"></span> </label>
                                </div>
                                @elseif(@session()->get('currency')>=2 && $productDetails->gift_pack_price_usd!=null && $productDetails->gift_pack_price_usd > 0)
                                <div class="bill-add">
                                    <label class="list_checkBox dis-checkbox">Gift Pack {{session()->get('currencySym').round($productDetails->gift_pack_price_usd*currencyConversionCustom(),2)}}
                                        <input type="checkbox" name="gift_pack"  id="gift_pack" value="{{round($productDetails->gift_pack_price_usd)}}"> <span class="list_checkmark"  for="gift_pack"></span> </label>
                                </div>

                                @endif
                            </div>

                            <input type="hidden" name="gift_pack_price" id="gift_pack_price" value="@if(@session()->get('currency')==1 && $productDetails->gift_pack_price_inr != null && $productDetails->gift_pack_price_inr > 0) {{$productDetails->gift_pack_price_inr}} @elseif(@session()->get('currency')>=2 && $productDetails->gift_pack_price_usd!=null && $productDetails->gift_pack_price_usd > 0) {{round($productDetails->gift_pack_price_usd*currencyConversionCustom(),2)}} @endif ">

                            <div class="payable_price" style="margin-bottom: 10px; display: none;"> You Pay : @if(@session()->get('currency')==1){{@session()->get('currencySym')}} @else {{@session()->get('currencySym')}} @endif <span id="you_pay_price"></span> </div>
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
								   <button type="button" class="btn addcardbtn" id="buyNow" data-product="{{$productDetails->id}}"><img src="{{ URL::to('public/frontend/images/addbtn.png')}}"> Buy Now</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            @else
                            <div class="marb-20">
                                

                                <div class="color-sec btn-3 float-right right-btn-3">
                                   <h6 class="invisible">Quantity</h6>
                                   <button type="button" class="btn addcardbtn" data-product="{{$productDetails->id}}">
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

                <div class="row">
                     <div class="col-12">
                        <div class="details-desc back_white" >
                           <h4>PRODUCT DETAILS</h4>
                           {{-- <p> Original Natural Yellow Sapphire (Heated) weighing 0.54 carat In Cushion shape. </p> --}}
                           <div class="wrap-details-list">
                              <ul>
                                 @if(@$productDetails->product_weight!="")
                                 <li>
                                    <h3>Product Weight</h3>
                                    <span>{{@$productDetails->product_weight}} gm </span>
                                 </li>
                                 @endif
                                 @if(@$productDetails->color!="")
                                 <li>
                                    <h3>Color</h3>
                                    <span>{{@$productDetails->color}} </span>     
                                 </li>
                                 @endif

                                 @if(@$productDetails->size!="")
                                 <li>
                                    <h3>Size </h3>
                                    <span>{{@$productDetails->size}} MM</span>
                                 </li>
                                 @endif
                                 @if(@$productDetails->shape_cut!="")
                                 <li>
                                    <h3>Shape & Cut</h3>
                                    <span>{{@$productDetails->shape_cut}}</span>
                                 </li>
                                 @endif
                                 
                                 @if(@$productDetails->country_of_origin!="")
                                 <li>
                                    <h3>Country Of Origin</h3>
                                    <span>{{@$productDetails->country_name->name}}</span>
                                 </li>
                                 @endif
                                 @if(@$productDetails->placement!="")
                                 <li>
                                    <h3>Placement</h3>
                                    <span>{{@$productDetails->placement}}</span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->lab_certified!="")
                                 <li>
                                    <h3>Lab Certified</h3>
                                    <span>@if(@$productDetails->lab_certified=='Y') Yes @else No @endif  </span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->lab_certified=="Y" && @$productDetails->laboratory_name!="")
                                 <li>
                                    <h3>Laboratory Name</h3>
                                    <span>{{@$productDetails->labname->cert_name}}</span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->seller_id!="")
                                 <li>
                                    <h3>Seller Name</h3>
                                    <span>{{@$productDetails->seller->seller_name}}</span>
                                 </li>
                                 @endif

                                  @if(@$productDetails->availability!="")
                                 <li>
                                    <h3>Product Available</h3>
                                    <span>@if(@$productDetails->availability=="Y")Yes @else No @endif </span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->shipable!="")
                                 <li>
                                    <h3>Product Shippable</h3>
                                    <span>@if(@$productDetails->shipable=="Y")Yes @else No @endif </span>
                                 </li>
                                 @endif

                                

                                 @if(@$productDetails->is_cod_available!="")
                                 <li>
                                    <h3>Cod Available</h3>
                                    <span>@if(@$productDetails->is_cod_available=="Y")Yes @else No @endif </span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->refundable!="")
                                  <li>
                                    <h3>Product Refundable</h3>
                                    <span>@if(@$productDetails->refundable=="Y")Yes @else No @endif</span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->refundable_status!="")
                                  <li>
                                    <h3>Product Refundable Status</h3>
                                    <span>@if(@$productDetails->refundable_status=="E")Exchange Only @elseif(@$productDetails->refundable_status=="'FR") Fully Refundable @elseif(@$productDetails->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif</span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->refundable_status!="")
                                 <li>
                                    <h3>Product Tentative Delivery Days</h3>
                                    <span>@if(@session()->get('currency')==1)
                                @if(@$productDetails->delivery_days_india!="")
                                
                                    {{@$productDetails->delivery_days_india}} days
                                
                                @endif
                                @else
                                 {{@$productDetails->delivery_days_outside_india}} days
                                @endif
                                 </li>
                                 @endif


                                 



                                 
                                 <div class="clearfix"></div>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>



                @if( @$productDetails->productPlanets->isNotEmpty() || @$productDetails->productNakshtra->isNotEmpty()||@$productDetails->productPlanets->isNotEmpty()||@$productDetails->productRashi->isNotEmpty() || @$productDetails->productDeity->isNotEmpty())

                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">


                       
                        {{-- @if(@$productDetails->purpose_id!="")
                        <h2>Purpose </h2>
                        <p>{{@$productDetails->purpose_name->name}} </p>
                        @endif --}}

                        @if(@$productDetails->productDeity->isNotEmpty())
                        <h2>Deity </h2>
                        <p>
                            @foreach (@$productDetails->productDeity as $deity) {{@$deity->deities->name}} @if (!$loop->last),@endif @endforeach
                             {{-- <br> @if(@$benificials_deity) <b><h4 style="color: #e8a173">(Beneficial for all deity)</b></h4> @endif --}}
                        </p>
                        @endif
                        @if(@$productDetails->productNakshtra->isNotEmpty())
                        <h2>Nakshatras </h2>
                        <p>
                           @if(!@$benificials_nakshatra)
                            @foreach (@$productDetails->productNakshtra as $nakshatra) {{@$nakshatra->nakshatras->name}} @if (!$loop->last),@endif @endforeach
                            @else
                            Beneficial for all nakshatra
                              {{-- <b><h4 style="color: #e8a173"></b></h4>  --}}
                           @endif
                        </p>
                        @endif

                        @if(@$productDetails->productPlanets->isNotEmpty())
                        <h2>Planets </h2>
                        <p>
                           @if(!@$benificials_planet)
                            @foreach (@$productDetails->productPlanets as $planet) {{@$planet->planets->planet_name}} @if (!$loop->last),@endif @endforeach
                            @else
                            Beneficial for all planet
                             {{-- <br>  <b><h4 style="color: #e8a173">(Beneficial for all planet)</b></h4> @endif --}}
                             @endif
                        </p>
                        @endif


                       @if(@$productDetails->productRashi->isNotEmpty())
                       <h2>Rashis </h2>
                       <p>
                        @if(!@$benificials_rashi)
                           @foreach (@$productDetails->productRashi as $rashi) {{@$rashi->rashis->name}} @if (!$loop->last),@endif @endforeach
                        @else
                        Beneficial for all rashi
                        @endif   
                           {{-- <br>  <b><h4 style="color: #e8a173">(Beneficial for all rashi)</b></h4> @endif --}}
                       </p>
                       @endif
                       
                       </div>
                    </div>
                 </div>
                @endif


          
          @if( @$productDetails->specific_prosperty!="" ||@$productDetails->purpose_id!="")
                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">

                        @if(@$productDetails->purpose_id!="")
                        <h2>Purpose </h2>
                        <p>
                          {{@$productDetails->purpose_name->name}}
                        </p>
                        @endif


                        @if(@$productDetails->specific_prosperty!="")
                        <h2>Specific Property </h2>
                        <p>
                          {{@$productDetails->specific_prosperty}}
                        </p>
                        @endif

                       </div>
                     </div>
                   </div>
                  @endif      


           @if(@$productDetails->shipping_policy)
            <div class="row">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">
                           <h2>{{__('search.shipping_policy')}}</h2>
                           <div class="article">
                               <p style="white-space:pre-wrap;">{!! @$productDetails->shipping_policy !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @if(@$productDetails->terms_of_refund)
            <div class="row">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">
                           <h2>{{__('search.terms_of_refund')}}</h2>
                           <div class="article">
                               <p style="white-space:pre-wrap;">{!! @$productDetails->terms_of_refund !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

                

                 @if(@$productDetails->assurance_guarantee)
                <div class="row">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">
                           <h2>Assurance/ Guarantee / Warranty</h2>
                           <div class="article">
                               <p style="white-space:pre-wrap;">{!! @$productDetails->assurance_guarantee !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

				
				
				
				@if(@$productDetails->productVideo)
                @if(@$productDetails->productVideo->image && @$productDetails->productVideo->video_link)
                <div class="row" style="margin-top: 25px" >
                    <div class="col-12">
                       <div class="item-description video-center back_white" >
                          <h2>Product Video </h2>
                          <iframe width="560" height="315" src="https://www.youtube.com/embed/{{@$productDetails->productVideo->image}}" frameborder="0" allowfullscreen></iframe>
                       </div>
                    </div>
                </div>
                @else
					<div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description video-center back_white">
                          <h2>Product Video </h2>
                          <video src="{{asset('storage/app/public/product_video/'.@$productDetails->productVideo->image)}}" loop muted controls ></video>
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
                                <p style="white-space:pre-wrap;">{{@$productDetails->manta_to_chant}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif --}}
                <div class="customer_review_box back_white">
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
             <h3>Related  <b>Product</b></h3>
             <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
         </div>
         <div class="gem-stone-iner">
             <div class="owl-carousel" id="owl-carousel-1">
                 @foreach ($similarProducts as $product)
                 <div class="item back_white">
                    <div class="gem-stone-item product_card">
                        <span>
                            <a href="{{route('product.search.details',['slug'=>@$product->slug])}}" target="_blank">
                            @if(@$product->productdefault->image)
                            <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$product->productdefault->image}}"alt="">
                            @else
                            <img src="{{ URL::to('public/frontend/images/ston1.png')}}" alt="">
                            @endif
                            </a>
                        </span>
                        <div class="gem-stone-text">
                            <h5><a href="{{route('product.search.details',['slug'=>@$product->slug])}}" target="_blank">
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
                                                <del>{{@session()->get('currencySym')}} {{@$product->price_inr}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{@$product->price_inr}}
                                                @endif

                                                @else

                                                @if(@$product->discount_usd!=null && @$product->discount_usd>0)
                                                @php
                                                 $old_price = $custom * $product->price_usd;
                                                  $discount_value = ($old_price / 100) * @$product->discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{round($custom *@$product->price_usd)}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{round($custom *@$product->price_usd)}}
                                                @endif

                                                @endif
                                    
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

                 {{-- <div class="item">
                     <div class="gem-stone-item">
                         <span><img src="{{ URL::to('public/frontend/images/ston2.png')}}" alt=""></span>
                         <em class="new_ston">New</em>
                         <div class="gem-stone-text">
                             <h5><a href="#url">Natural Pearl 10X8 MM</a></h5>
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
                         <span><img src="{{ URL::to('public/frontend/images/ston3.png')}}" alt=""></span>
                         <div class="gem-stone-text">
                             <h5><a href="#url">Iolite 10X8 MM - 3.21 carats</a></h5>
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
                         <span><img src="{{ URL::to('public/frontend/images/ston4.png')}}" alt=""></span>
                         <div class="gem-stone-text">
                             <h5><a href="#url">Blue Sapphire - 3.21 carats</a></h5>
                             <p>Lorem quis bibendum auctor, nisi elit nib id elit. Duis sed .</p>
                             <ul>
                                 <li><del>$35.00</del>$28.00</li>
                                 <li><a href="#url" class="pag_btn">Buy Now</a></li>
                             </ul>
                         </div>
                     </div>
                 </div> --}}
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
<script type="text/javascript" src="https://www.starplugins.com/sites/starplugins/js/thumbelina/thumbelina.js"></script>

    <script type="text/javascript" src="https://www.starplugins.com/sites/starplugins/js/cloudzoom/cloudzoom.js"></script>
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
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
// $('.moreless-button').click(function() {
//  $('.moretext').slideToggle();
//  if ($('.moreless-button').text() == "Read More +") {
//    $(this).text("Read Less -")
//  } else {
//    $(this).text("Read More +")
//  }
// });
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
    $('#buyNow').click(function(){
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
				window.location.href="{{route('product.shopping.cart')}}";
            //   alert('Product added to cart successfully');
            }
            if (response.result.updated=="updated") {
                toastr.success('Product quantity updated successfully')
                window.location.href="{{route('product.shopping.cart')}}";
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


<script>
    $(document).ready(function(){
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
        })
    })
    </script>


{{-- <script type="text/javascript">
$(document).on('click', '.nav-link.active', function() {
  var href = $(this).attr('href').substring(1);
  //alert(href);
  $(this).removeClass('active');
  $('.tab-pane[id="' + href + '"]').removeClass('active');

});
</script>
 --}}

{{-- gift-pack-price-calculation   --}}
<script type="text/javascript">
   $('#gift_pack').on('click',function(e){
      if($('#gift_pack').prop("checked") == true){
      var gift_pack_price = $('#gift_pack_price').val();
      var product_price_div = $('#product_price_div').val();
      var sum = +gift_pack_price + +product_price_div;
      $('#you_pay_price').html(sum);
      $('.payable_price').show();
    }else{
      var gift_pack_price = $('#gift_pack_price').val();
      var product_price_div = $('#product_price_div').val();
      var sum = +gift_pack_price + +product_price_div;
      var minus = sum-gift_pack_price;
      $('#you_pay_price').html(minus);
      $('.payable_price').show();
   }
   })
    
</script>
@endsection
