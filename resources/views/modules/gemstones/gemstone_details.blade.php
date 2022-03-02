@extends('layouts.app')

@section('title')
<meta name="title" content="{{@$productDetails->meta_title}}">
<meta name="description" content="{{strip_tags(@$productDetails->meta_description)}}">
@if(@$productDetails->title && @$productDetails->subtitle)
<meta property="og:title" content="Gemstone Details | {{@$productDetails->title->title}} - {{@$productDetails->subtitle->title}} - {{@$productDetails->product_code}}">
@elseif(@$productDetails->product_name)
<meta property="og:title" content="Gemstone Details | {{@$productDetails->product_name}}- {{@$productDetails->product_code}}">
@endif
<meta property="og:description" content="{{ substr(strip_tags(@$productDetails->description),0,150) }}">
@if(@$productDetails->productdefault->image)
<meta property="og:image" content="{{ URL::to('storage/app/public/gemstone')}}/{{@$productDetails->productdefault->image}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
<meta property="og:url" content="{{route('gemstone.details', ['slug'=>@$productDetails->slug])}}">
<title>Gemstone Details |  @if(@$productDetails->meta_title) {{@$productDetails->meta_title}} @else @if(@$productDetails->title && @$productDetails->subtitle) {{@$productDetails->title->title}} / {{@$productDetails->subtitle->title}} / {{@$productDetails->product_code}} @else {{@$productDetails->product_name}} / {{@$productDetails->product_code}} @endif @endif</title>
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
            
            /* CSS for slider - will expand to width of surround */
			.details-desc{
               border: 1px solid #e2e2e2 ;
               padding: 20px;
            }
			
</style>

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class="pad-114">
<div class="details-banners">
               <div class="banner-inners">
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-9 col-md-12">
                           <div class="mb-breadcrumbs">
                              <ul>
                                 <li><a href="{{route('gemstone.search.category')}}"> {{@$productDetails->gemcategory->category_name}} </a> <span>             </span></li>
								 @if(@$productDetails->title)
									 <li>&nbsp; /  &nbsp;<a href="{{route('gemstone.search.title',['id'=>@$productDetails->category_id])}}"> {{@$productDetails->title->title}} </a></li>
                 @if(@$productDetails->subtitle)  
								 <li><span> &nbsp; /  &nbsp;</span><a href="{{route('gemstone.search.sub-title',['id'=>@$productDetails->title_id,'cat'=>@$productDetails->category_id])}}"> {{@$productDetails->subtitle->title}} </a><span></span></li>
                @endif 
								@else
                                 <li><span>             &nbsp; /  &nbsp;</span> <a href="#"> {{@$productDetails->product_name}} </a></li>
								@endif
                                 <li><span>&nbsp; /  &nbsp;</span><span>{{@$productDetails->product_code}}</span></li>
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
                                 <a class="nav-link @if($productDetails->significance=='' && $productDetails->how_to_place=='' && $productDetails->manta_to_chant=='' && $productDetails->clarity=='') show active @endif" data-toggle="tab" href="#menu4">FAQ</a>
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
                        <div id="home" class="container tab-pane  @if(@$productDetails->significance!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Significance and Benefits</h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->significance!!}</p>
                        </div>
                        </div>

                        <div id="menu1" class="container tab-pane @if(@$productDetails->significance=="" && @$productDetails->how_to_place!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Who, How & When  </h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->how_to_place!!}</p>
                           </div>
                        </div>

                        <div id="menu2" class="container tab-pane @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Related Mantra</h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->manta_to_chant!!}</p>
                           </div>
                        </div>
                        <div id="menu3" class="container tab-pane @if(@$productDetails->significance=="" && @$productDetails->how_to_place=="" && @$productDetails->manta_to_chant=="" && @$productDetails->clarity!="") show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Usage</h2>
                              <p style="white-space:pre-wrap;">{!!@$productDetails->clarity!!}</p>
                           </div>
                        </div>
                         
                        @if(@$all_faq_cat->isNotEmpty())
                        <div id="menu4" class="container tab-pane @if($productDetails->significance=='' && $productDetails->how_to_place=='' && $productDetails->manta_to_chant=='' && $productDetails->clarity=='') active @else fade @endif">
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
			</div>
    <div class="product-det">
        <div class="container">
            <div class="row">
                <div class="col-md-6">                    
                    <div id="surround">
    
					
					    <div class="new-imgs">
                    <em>
					<img class="cloudzoom" alt ="Cloud Zoom small image" id ="zoom1" src="{{ URL::to('storage/app/public/gemstone')}}/{{@$productDetails->productdefault->image}}"
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
							<li><img class='cloudzoom-gallery' src="{{ URL::to('storage/app/public/gemstone')}}/{{@$images->image}}" 
									 data-cloudzoom ="useZoom:'.cloudzoom', image:'{{ URL::to('storage/app/public/gemstone')}}/{{@$images->image}}' "></li>
									 @endforeach
						</ul>
						<div class="thumbelina-but horiz right">&#707;</div>
						
					</div>
					
				</div>
                </div>
                <div class="col-md-6">
                    <div class="pro-descriptipn">
                        <div class="pro-heading">
                            <!--<h1>@if($productDetails->product_name!=""){{$productDetails->product_name}} @else {{@$productDetails->title->title}}  @endif</h1> <div class="gem_id_price"><h2>Gemstone ID - {{$productDetails->product_code}}</h2> - --> <p class="off" style="text-transform:none;">@if(@session()->get('currency')>=2) {{session()->get('currencySym').round(@$productDetails->price_per_carat_usd*currencyConversionCustom(),2)}} @else {{session()->get('currencySym').@$productDetails->price_per_carat_inr}} @endif @if(@$productDetails->single_product=='N') - Price per carat @endif</p></div></div>
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
                                <del>{{session()->get('currencySym').$productDetails->price_inr}}</del>
                                <span class="price">{{session()->get('currencySym').round(@$new_price)}}</span>
                                @else
                                <span class="price">{{session()->get('currencySym').@$productDetails->price_inr}}</span>
                                @endif
                                <div class="clearfix"></div>
                            </div>
							<div class="clearfix"></div>
							<div class="payable_price" style="display:none;"></div>
							
							</div>
                            @elseif(@session()->get('currency')>=2)
                            <p class="off">@if(@$productDetails->discount_usd == null || @$productDetails->discount_usd == 0) @else Get {{$productDetails->discount_usd}}% off @endif</p>
                            <div class="price_of_gemstone">
                            <div class="product_price priceChange">
                                @if(@$productDetails->discount_usd != null && @$productDetails->discount_usd > 0)
                                @php
                                $old_price = $productDetails->price_usd;
                                $discount_value = ($old_price / 100) * @$productDetails->discount_usd;
                                $new_price = $old_price - $discount_value;
                                @endphp
                                <del>{{session()->get('currencySym').round(@$productDetails->price_usd*currencyConversionCustom(),2)}}</del>
                                <span class="price"> {{session()->get('currencySym').round(@$new_price*currencyConversionCustom(),2)}}</span>
                                @else
                                <span class="price">{{session()->get('currencySym').round(@$productDetails->price_usd*currencyConversionCustom(),2)}}</span>
                                @endif                                
                                <div class="clearfix"></div>
                            </div>
							<div class="clearfix"></div>
							<div class="payable_price" style="display:none;"></div>
							
							</div>
                            @endif
							

                            <hr class="pro-hr">
							<form class="fromcaret" action="" method="post" name="priceChangeForm" id="priceChangeForm">
								@csrf
                            <div class="des-info">                               
                                <div class="clearfix"></div>
                                @if(@session()->get('currency')==1 && $productDetails->gift_pack_price_inr != null && $productDetails->gift_pack_price_inr > 0)
                                <div class="bill-add">
                                    <label class="list_checkBox dis-checkbox">Gift Pack Rs {{$productDetails->gift_pack_price_inr}}
                                        <input type="checkbox" name="gift_pack"  id="gift_pack" value="{{round($productDetails->gift_pack_price_inr)}}"> <span class="list_checkmark"  for="gift_pack"></span> </label>
                                </div>
                                @elseif(@session()->get('currency')>=2 && $productDetails->gift_pack_price_usd!=null && $productDetails->gift_pack_price_usd > 0)
                                <div class="bill-add">
                                    <label class="list_checkBox dis-checkbox">Gift Pack {{session()->get('currencySym').round($productDetails->gift_pack_price_usd*currencyConversionCustom(),2)}}
                                        <input type="checkbox" name="gift_pack"  id="gift_pack" value="{{round($productDetails->gift_pack_price_usd*currencyConversionCustom(),2)}}"> <span class="list_checkmark"  for="gift_pack"></span> </label>
                                </div>
                                @endif
								<div class="clearfix"></div>
								<div class="pricerabf">
								<input type="hidden" name="gem_id" value="{{@$productDetails->id}}"/>
								<div class="color-sec new-je">
                                    <label class="list_checkBox">Gemstone weight</label>
									<select class="" id="gemstone_weight" name="gemstone_weight">
										@if(@$gemstone_price_decrease->isNotempty())
										@foreach(@$gemstone_price_decrease as $value)
										<option value="{{@$value->id}}">{{@$value->weight}} Carat ({{(round(@$value->weight/env('RATTI_TO_CARAT'),2)) }} Ratti) - @if(@session()->get('currency')>=2) {{session()->get('currencySym').round(@$value->price_usd*currencyConversionCustom(),2)}} @else {{session()->get('currencySym').@$value->price_inr}} @endif</option>
										@endforeach
										@endif
										<option value="{{@$gemstone_price_base->id}}" selected>{{@$gemstone_price_base->weight}} Carat ({{(round(@$gemstone_price_base->weight/env('RATTI_TO_CARAT'),2)) }} Ratti)</option>
										@if(@$gemstone_price_increase->isNotempty())
										@foreach(@$gemstone_price_increase as $value)
										<option value="{{@$value->id}}">{{@$value->weight}} Carat ({{(round(@$value->weight/env('RATTI_TO_CARAT'),2)) }} Ratti) + @if(@session()->get('currency')>=2) {{session()->get('currencySym').round(@$value->price_usd*currencyConversionCustom(),2)}} @else {{session()->get('currencySym').@$value->price_inr}} @endif</option>
										@endforeach
										@endif
									</select>
                                </div>
								@if(@$productDetails->single_product=='N')
								<div class="color-sec new-je checkBox">
                                    <label class="list_checkBox">Purchase this gemstone with:</label>
									<ul>
									<li>
									<input type="radio" name="jewellery" id="jewel1" value="OS" class="selectJewellery" checked/>
									<label for="jewel1">Only Stone</label>
									</li>
                                            <li>
									<input type="radio" name="jewellery" id="jewel2" value="R" class="selectJewellery"/>
									<label for="jewel2">Ring</label>
									</li>
									<li>
									<input type="radio" name="jewellery" id="jewel3" value="P" class="selectJewellery"/>
									<label for="jewel3">Pendant</label>
									</li>
									<li>
									<input type="radio" name="jewellery" id="jewel4" value="B" class="selectJewellery"/>
									<label for="jewel4">Bracelet</label>
									</li>
									</ul>
                                </div>
								<div class="color-sec new-je checkBox metal_radio" style="display:none;">
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
								<div class="color-sec new-je checkBox goldpurity" style="display:none;">
								</div>
								<div class="color-sec new-je checkBox ringpendantweight" style="display:none;">
								</div>
								<div class="color-sec new-je checkBox pendant_chain" style="display:none;">
                                    <label class="list_checkBox">Want to buy pendant:</label>
										<select class="" id="pendant_chain" name="pendant_chain">
											<option value="W">With Chain</option>
											<option value="O" selected>Without Chain</option>
										</select>	
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
								@endif
								@if(@$bracelet_size->isnotEmpty())
								<div class="color-sec new-je checkBox braceletsize" style="display:none;">
                                    <label class="list_checkBox">Bracelet Size:</label>									
									<select class="" id="bracelet_size" name="bracelet_size">
								<option value="">Select</option>
								@foreach(@$bracelet_size as $value)
										<option value="{{@$value->id}}">{{@$value->size}}</option>
									@endforeach
									</select>
                                </div>
								@endif
								@if(@$productDetails->additional_certification=='Y')
								@if(@$certification->isNotempty())
								<div class="color-sec new-je checkBox">
                                    <label class="list_checkBox">Certification:</label>									
									<select class="" id="certification" name="certification">
								<option value="">Select</option>
								@foreach(@$certification as $value)
										<option value="{{@$value->id}}">{{@$value->certificate_name->cert_name}} + @if(@session()->get('currency')>=2) {{session()->get('currencySym').round(@$value->price_usd*currencyConversionCustom(),2)}} @else {{session()->get('currencySym').@$value->price_inr}} @endif @if(@$value->certificate_name->no_of_days!="")- additional {{@$value->certificate_name->no_of_days}} days. @endif </option>
									@endforeach
									</select>
                                </div>
								@endif
								@endif
								@if(@$puja_energization->isNotempty())
								<div class="color-sec new-je checkBox">
                                    <label class="list_checkBox">Puja Energization:</label>
									<select class="" id="puja_energy" name="puja_energy">
								<option value="">Select</option>
								@foreach(@$puja_energization as $value)
										<option value="{{@$value->id}}">{{@$value->puja_name->puja}} + @if(@session()->get('currency')>=2) {{session()->get('currencySym').round(@$value->price_usd*currencyConversionCustom(),2)}} @else {{session()->get('currencySym').@$value->price_inr}} @endif</option>
									@endforeach
									</select>
                                </div>
								@endif
								<div class="color-sec new-je checkBox selectdesign" style="display:none;">
								
                                </div>
								<div class="color-sec new-je checkBox errorShow" style="display:none;">
								
                                </div>
								<div class="clearfix"></div>
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
							</form>
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
                
				 <div class="row" style="margin-top: 25px">
                     <div class="col-12">
                        <div class="details-desc back_white">
                           <h4>GEMSTONE DETAILS</h4>
                           <div class="wrap-details-list">
                              <ul>
                                 @if(@$productDetails->product_weight!="")
                                 <li>
                                    <h3>Gemstone Weight</h3>
                                    <span>{{@$productDetails->product_weight}} Carat @if(@$productDetails->weight_ratti) ({{@$productDetails->weight_ratti}} Ratti) @endif</span>
                                 </li>
                                 @endif
                                 @if(@$productDetails->colors!="")
                                 <li>
                                    <h3>Color</h3>
                                    <span>{{@$productDetails->colors->color}} </span>     
                                 </li>
                                 @endif

                                 @if(@$productDetails->size!="")
                                 <li>
                                    <h3>Size </h3>
                                    <span>{{@$productDetails->size}} MM</span>
                                 </li>
                                 @endif
								 @if(@$productDetails->composition!="")
                                 <li>
                                    <h3>Composition</h3>
                                    <span>@if(@$productDetails->composition=="N")
									Natural
									@elseif(@$productDetails->composition=="S")
									Synthetic
									@elseif(@$productDetails->composition=="A")
									Artificial
									@else
									Imitation
									@endif	</span>
                                 </li>
                                 @endif
								 @if(@$productDetails->dimention_type!="")
                                 <li>
                                    <h3>Dimension Type</h3>
                                    <span>@if(@$productDetails->dimention_type=="C")
									Calibrated
									@else
									Non-Calibrated
									@endif	</span>
                                 </li>
                                 @endif
								 @if(@$productDetails->transparency!="")
                                 <li>
                                    <h3>Transparency</h3>
                                    <span>@if(@$productDetails->transparency=="T")
										Transparent
										@elseif(@$productDetails->transparency=="TRA")
										Translucent
										@else
										Opaque
										@endif</span>
                                 </li>
                                 @endif
								 @if(@$productDetails->heft!="")
                                 <li>
                                    <h3>Heft</h3>
                                    <span>@if(@$productDetails->heft=="H")
										Heavy
										@elseif(@$productDetails->heft=="M")
										Medium
										@else
										Light
										@endif</span>
                                 </li>
                                 @endif
								 
                                 @if(@$productDetails->shape)
                                 <li>
                                    <h3>Shape</h3>
                                    <span>{{@$productDetails->shape->shapes}}</span>
                                 </li>
                                 @endif
								 @if(@$productDetails->cut)
                                 <li>
                                    <h3>Cut</h3>
                                    <span>{{@$productDetails->cut->cuts}}</span>
                                 </li>
                                 @endif
                                 
                                 @if(@$productDetails->country_of_origin!="")
                                 <li>
                                    <h3>Country Of Origin</h3>
                                    <span>{{@$productDetails->country_name->name}}</span>
                                 </li>
                                 @endif
                                 

                                 @if(@$productDetails->lab_certified!="")
                                 <li>
                                    <h3>Lab Certified</h3>
                                    <span>@if(@$productDetails->lab_certified!='Y') Yes @else No @endif  </span>
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
                                    <h3>Available</h3>
                                    <span>@if(@$productDetails->availability=="Y")Yes @else No @endif </span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->shipable!="")
                                 <li>
                                    <h3>Shippable</h3>
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
                                    <h3>Refundable</h3>
                                    <span>@if(@$productDetails->refundable_status=="E")Exchange Only @elseif(@$productDetails->refundable_status=="'FR") Fully Refundable @elseif(@$productDetails->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif</span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->delivery_days_india!="" && @session()->get('currency')==1)
                                 <li>
                                    <h3>Tentative Delivery Days</h3>
                                    <span>{{@$productDetails->delivery_days_india}} days</span>
                                 </li>
                                 @endif
								 @if(@$productDetails->delivery_days_outside_india!="" && @session()->get('currency')>1)
								 <li>
									<h3>Tentative Delivery Days</h3>
									<span>{{@$productDetails->delivery_days_outside_india}} days</span>
								 </li>
								 @endif



                              @if(@$productDetails->gravity!="")
                                 <li>
                                    <h3>Gravity</h3>
                                    <span>{{@$productDetails->gravity}} </span>
                                 </li>
                                 @endif

                                @if(@$productDetails->inclusions!="")
                                 <li>
                                    <h3>Inclusions</h3>
                                    <span>{{@$productDetails->inclusions}} </span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->refractive_index!="")
                                 <li>
                                    <h3>Refractive Index</h3>
                                    <span>{{@$productDetails->refractive_index}} </span>
                                 </li>
                                 @endif
                                
                                @if(@$productDetails->optical_phenomena!="")
                                 <li>
                                    <h3>Optical phenomena</h3>
                                    <span>{{@$productDetails->optical_phenomena}} </span>
                                 </li>
                                 @endif

                                 @if(@$productDetails->productTreatment->isNotEmpty())
                                 <li>
                                 <h3>Treatment </h3>
                                <span>
                                     @foreach (@$productDetails->productTreatment as $treatment) {{@$treatment->treatname->name}} @if (!$loop->last),@endif @endforeach
                                 </span>
                               </li>
                                 @endif



                                 <div class="clearfix"></div>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                @if( @$productDetails->productPlanets->isNotEmpty() || @$productDetails->productNakshtra->isNotEmpty()||@$productDetails->productPlanets->isNotEmpty()||@$productDetails->productRashi->isNotEmpty() ||@$productDetails->productDeity->isNotEmpty())

                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">

                        {{-- @if(@$productDetails->gravity!="")
                        <h2>Gravity </h2>
                        <p>
                        	{{@$productDetails->gravity}}
                        </p>
                        @endif

                         @if(@$productDetails->inclusions!="")
                        <h2>Inclusions </h2>
                        <p>
                        	{{@$productDetails->inclusions}}
                        </p>
                        @endif

                        @if(@$productDetails->refractive_index!="")
                        <h2>Refractive Index </h2>
                        <p>
                        	{{@$productDetails->refractive_index}}
                        </p>
                        @endif

                         

                         @if(@$productDetails->optical_phenomena!="")
                        <h2>Optical phenomena </h2>
                        <p>
                        	{{@$productDetails->optical_phenomena}}
                        </p>
                        @endif --}}

                        {{-- @if(@$productDetails->specific_prosperty!="")
                        <h2>Specific Property </h2>
                        <p>
                        	{{@$productDetails->specific_prosperty}}
                        </p>
                        @endif --}}

                        



                        
                        @if(@$productDetails->productNakshtra->isNotEmpty())
                        <h2>Nakshatras </h2>
                        <p>
                            
							@if(@$benificials_nakshatra)
                              Beneficial for all nakshatra 
						 @else
							 @foreach (@$productDetails->productNakshtra as $nakshatra) {{@$nakshatra->nakshatras->name}} @if (!$loop->last),@endif @endforeach
						@endif
                        </p>
                        @endif

                        @if(@$productDetails->productPlanets->isNotEmpty())
                        <h2>Planets </h2>
                        <p>
                            
							@if(@$benificials_planet)
                            Beneficial for all planet 
							@else
							@foreach (@$productDetails->productPlanets as $planet) {{@$planet->planets->planet_name}} @if (!$loop->last),@endif @endforeach
							@endif
                        </p>
                        @endif


                       @if(@$productDetails->productRashi->isNotEmpty())
                       <h2>Rashis </h2>
                       <p>
                           
						   @if(@$benificials_rashi)
                         Beneficial for all rashi
							@else
								@foreach (@$productDetails->productRashi as $rashi) {{@$rashi->rashis->name}} @if (!$loop->last),@endif @endforeach
						 @endif
                       </p>
                       @endif




                       @if(@$productDetails->productDeity->isNotEmpty())
                        <h2>Deity </h2>
                        <p>
                            
							@if(@$benificials_deity)
                             Beneficial for all deity
							@else
							 @foreach (@$productDetails->productDeity as $deity) {{@$deity->deities->name}} @if (!$loop->last),@endif @endforeach
							 @endif
                        </p>
                        @endif


                       {{-- @if(@$productDetails->productTreatment->isNotEmpty())
                       <h2>Treatment </h2>
                       <p>
                           @foreach (@$productDetails->productTreatment as $treatment) {{@$treatment->treatname->name}} @if (!$loop->last),@endif @endforeach
                       </p>
                       @endif --}}
                      
                       </div>
                    </div>
                 </div>
                @endif



                @if( @$productDetails->specific_prosperty!="")
                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">
                        @if(@$productDetails->specific_prosperty!="")
                        <h2>Specific Property </h2>
                        <p style="white-space:pre-wrap;">{!!@$productDetails->specific_prosperty!!}</p>
                        @endif

                       </div>
                     </div>
                   </div>
                  @endif 

                @if(@$productDetails->assurance_guarantee)
				<div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description back_white product_gemstone_anchor">
                           <h2>Assurance/ Guarantee / Warranty</h2>
                           <div class="article">
                               <!--<p class="aboutRemaove" style="white-space:pre-wrap;">{!! substr(@$productDetails->assurance_guarantee, 0, 350 ) . '...' !!}</p>
                               <p class="moretext" style="white-space:pre-wrap;">{!! @$productDetails->assurance_guarantee !!}</p>
                               <a class="moreless-button">{{__('search.read_more')}} +</a>-->
							   <p style="white-space:pre-wrap;">{!! @$productDetails->assurance_guarantee !!}</p>                               
                            </div>
                        </div>
                    </div>
                </div>
				@endif

				@if(@$productDetails->shipping_policy)
				<div class="row" style="margin-top: 25px">
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
				<div class="row" style="margin-top: 25px">
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
				


				@if(@$productDetails->productVideo)
                @if(@$productDetails->productVideo->image && @$productDetails->productVideo->video_link)
                <div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description video-center back_white">
                          <h2>Gemstone Video </h2>
                          <iframe width="560" height="315" src="https://www.youtube.com/embed/{{@$productDetails->productVideo->image}}" frameborder="0" allowfullscreen></iframe>
                       </div>
                    </div>
                </div>
                @else
					<div class="row" style="margin-top: 25px">
                    <div class="col-12">
                       <div class="item-description video-center back_white">
                          <h2>Gemstone Video </h2>
                          <video src="{{asset('storage/app/public/gemstone_video/'.@$productDetails->productVideo->image)}}" loop muted controls ></video>
                       </div>
                    </div>
                </div>
				@endif
				@endif
                
				
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
                 <div class="item back_white">
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
                              @if(@$product->title)
								{{@$product->title->title}}@if(@$product->subtitle)/{{@$product->subtitle->title}} @endif/{{@$product->product_code}}
							@else
								{{@$product->product_name}}/{{@$product->product_code}}
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
                                                <del> {{session()->get('currencySym').@$product->price_inr}} </del>

                                                {{session()->get('currencySym').round(@$new_price,2)}}
                                                @else
                                                {{session()->get('currencySym').@$product->price_inr}}
                                                @endif

                                                @elseif(@session()->get('currency')>=2)

                                                @if(@$product->discount_usd!=null && @$product->discount_usd>0)
                                                @php
                                                 $old_price = $product->price_usd;
                                                  $discount_value = ($old_price / 100) * @$product->discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{session()->get('currencySym').round(@$product->price_usd*currencyConversionCustom(),2)}} </del>

                                                {{session()->get('currencySym').round(@$new_price*currencyConversionCustom(),2)}}
                                                @else
                                                {{session()->get('currencySym').round(@$product->price_usd*currencyConversionCustom(),2)}}
                                                @endif

                                                @endif
                                    
                                </li>
                                <li>
                                    @if(@$product->availability=="Y")
                                    <a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" class="pag_btn" target="_blank" data-product="{{@$product->id}}">Buy Now</a>
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
		$('body').on('change','#gemstone_weight,#certification,#puja_energy,#gold_purity,#pendant_chain,#ring_system,#ring_pendant_weight,#gift_pack',function(){
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
				  $('.payable_price').html(data.payable_gem_price);
				  $('.payable_price').show();
				  if(data.pendant_with_chain_price!='')
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain + '+data.pendant_with_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain');
				  }
				  if(data.pendant_without_chain_price!='')
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain + '+data.pendant_without_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain');
				  }
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
				  if(data.ring_pendant_weight_select!='')
				  {
					  $('.ringpendantweight').html(data.ring_pendant_weight_select);
					  $('.ringpendantweight').show();
				  }
				  else
				  {
					  $('.ringpendantweight').html('');
					  $('.ringpendantweight').hide();
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
				  if(data.bracelet_design_option!='' || data.rp_design_option!='')
				  {
					  if(data.bracelet_design_option!='')
					  {
						$('.selectdesign').html(data.bracelet_design_option);
						$('.selectdesign').show();
					  }
					  else if(data.rp_design_option!='')
					  {
						$('.selectdesign').html(data.rp_design_option);
						$('.selectdesign').show();
					  }
					  else
					  {
						$('.selectdesign').html('');
						$('.selectdesign').hide();
					  }
					  
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
				  $('.payable_price').html(data.payable_gem_price);
				  $('.payable_price').show();
				  if(data.pendant_with_chain_price!='')
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain + '+data.pendant_with_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain');
				  }
				  if(data.pendant_without_chain_price!='')
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain + '+data.pendant_without_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain');
				  }
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
				  if(data.ring_pendant_weight_select!='')
				  {
					  $('.ringpendantweight').html(data.ring_pendant_weight_select);
					  $('.ringpendantweight').show();
				  }
				  else
				  {
					  $('.ringpendantweight').html('');
					  $('.ringpendantweight').hide();
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
				  if(data.bracelet_design_option!='' || data.rp_design_option!='')
				  {
					  if(data.bracelet_design_option!='')
					  {
						$('.selectdesign').html(data.bracelet_design_option);
						$('.selectdesign').show();
					  }
					  else if(data.rp_design_option!='')
					  {
						$('.selectdesign').html(data.rp_design_option);
						$('.selectdesign').show();
					  }
					  else
					  {
						$('.selectdesign').html('');
						$('.selectdesign').hide();
					  }
					  
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
				$('#ring_system').val('');
			}
			if(obj.is(':checked') && obj.val()=='B')
			{
				$('.braceletsize').show();
			}
			else
			{
				$('.braceletsize').hide();
			}
			if(obj.is(':checked') && obj.val()=='OS')
			{
				$('.metal_radio').hide();
			}
			else
			{
				$('.metal_radio').show();
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
				  $('.payable_price').html(data.payable_gem_price);
				  $('.payable_price').show();
				  if(data.pendant_with_chain_price!='')
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain + '+data.pendant_with_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain');
				  }
				  if(data.pendant_without_chain_price!='')
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain + '+data.pendant_without_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain');
				  }
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
				  if(data.ring_pendant_weight_select!='')
				  {
					  $('.ringpendantweight').html(data.ring_pendant_weight_select);
					  $('.ringpendantweight').show();
				  }
				  else
				  {
					  $('.ringpendantweight').html('');
					  $('.ringpendantweight').hide();
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
				  if(data.bracelet_design_option!='' || data.rp_design_option!='')
				  {
					  if(data.bracelet_design_option!='')
					  {
						$('.selectdesign').html(data.bracelet_design_option);
						$('.selectdesign').show();
					  }
					  else if(data.rp_design_option!='')
					  {
						$('.selectdesign').html(data.rp_design_option);
						$('.selectdesign').show();
					  }
					  else
					  {
						$('.selectdesign').html('');
						$('.selectdesign').hide();
					  }
					  
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
				  $('.payable_price').html(data.payable_gem_price);
				  $('.payable_price').show();
				  if(data.pendant_with_chain_price!='')
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain + '+data.pendant_with_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="W"]').text('With Chain');
				  }
				  if(data.pendant_without_chain_price!='')
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain + '+data.pendant_without_chain_price);
				  }
				  else
				  {
					  $('#pendant_chain option[value="O"]').text('Without Chain');
				  }
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
				  if(data.ring_pendant_weight_select!='')
				  {
					  $('.ringpendantweight').html(data.ring_pendant_weight_select);
					  $('.ringpendantweight').show();
				  }
				  else
				  {
					  $('.ringpendantweight').html('');
					  $('.ringpendantweight').hide();
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
				  if(data.bracelet_design_option!='' || data.rp_design_option!='')
				  {
					  if(data.bracelet_design_option!='')
					  {
						$('.selectdesign').html(data.bracelet_design_option);
						$('.selectdesign').show();
					  }
					  else if(data.rp_design_option!='')
					  {
						$('.selectdesign').html(data.rp_design_option);
						$('.selectdesign').show();
					  }
					  else
					  {
						$('.selectdesign').html('');
						$('.selectdesign').hide();
					  }
					  
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
        /*var productId = $(this).data('product');
        var quantity = $('#quantity').val();
        var gift_pack = 0 ;*/
		var jewellery = $('.selectJewellery:checked').val();
		var flag=false;
		var errormessage='';
		if($('.selectJewellery').is(':checked'))
		{
			
			if(jewellery!='OS')
			{
				if($('.selectMetal').is(':checked'))
				{
					var metal=$('.selectMetal:checked').val();
					if(metal==1)
					{
						var gold_purity=$('#gold_purity').val();
						if(gold_purity=='')
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select gold purity</label>';
						}
					}
					if(metal==2 || metal==3)
					{
						var ring_pendant_weight=$('#ring_pendant_weight').val();
						if(ring_pendant_weight=='')
						{
							flag=true;
							if(jewellery=='R')
							{
								errormessage='<label class="list_checkBox error">Please select ring weight</label>';
							}
							else if(jewellery=='P')
							{
								errormessage='<label class="list_checkBox error">Please select pendant weight</label>';
							}
							
						}
					}
					if(jewellery=='R')
					{
						var ring_system=$('#ring_system').val();
						if(ring_system!='')
						{
							var ring_size=$('#ring_size').val();
							if(ring_size=='')
							{
								flag=true;
								errormessage='<label class="list_checkBox error">Please select ring size</label>';
							}
						}
						else
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select ring size system</label>';
						}
					}
					if(jewellery=='B')
					{
						if(!$('.selectDesign').is(':checked'))
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select bracelet design</label>';
						}
						if($('#bracelet_size').val()=='')
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select bracelet size</label>';
						}
					}
					if(jewellery=='R')
					{
						if(!$('.selectDesign').is(':checked'))
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select ring design</label>';
						}
					}
					if(jewellery=='P')
					{
						if(!$('.selectDesign').is(':checked'))
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select pendant design</label>';
						}
					}
					
				}
				else
				{
					flag=true;
					errormessage='<label class="list_checkBox error">Please select metal option</label>';
				}
				
			}
			
		}
		if(flag)
		{
			$('.errorShow').html(errormessage);
			$('.errorShow').show();
			return false;
		}
        $.ajax({
  			url: '{{ route('gemstone.add.to.cart') }}',
  			type: 'post',
  			dataType: 'json',
  			data: $('#priceChangeForm').serialize(),
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
        /*var productId = $(this).data('product');
        var quantity = $('#quantity').val();
        var gift_pack = 0 ;*/
		var jewellery = $('.selectJewellery:checked').val();
		var flag=false;
		var errormessage='';
		if($('.selectJewellery').is(':checked'))
		{
			
			if(jewellery!='OS')
			{
				if($('.selectMetal').is(':checked'))
				{
					var metal=$('.selectMetal:checked').val();
					if(metal==1)
					{
						var gold_purity=$('#gold_purity').val();
						if(gold_purity=='')
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select gold purity</label>';
						}
					}
					if(jewellery=='R')
					{
						var ring_system=$('#ring_system').val();
						if(ring_system!='')
						{
							var ring_size=$('#ring_size').val();
							if(ring_size=='')
							{
								flag=true;
								errormessage='<label class="list_checkBox error">Please select ring size</label>';
							}
						}
						else
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select ring size system</label>';
						}
					}
					if(jewellery=='B')
					{
						if(!$('.selectDesign').is(':checked'))
						{
							flag=true;
							errormessage='<label class="list_checkBox error">Please select bracelet design</label>';
						}
					}
					
				}
				else
				{
					flag=true;
					errormessage='<label class="list_checkBox error">Please select metal option</label>';
				}
				
			}
			
		}
		if(flag)
		{
			$('.errorShow').html(errormessage);
			$('.errorShow').show();
			return false;
		}
        $.ajax({
  			url: '{{ route('gemstone.add.to.cart') }}',
  			type: 'post',
  			dataType: 'json',
  			data: $('#priceChangeForm').serialize(),
  		})
		.done(function(response) {
			console.log(response);
            console.log(response.result.cart.length)
            if (response.result.insert=="insert") {
                toastr.success('Product added to cart successfully');
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
@endsection
