@extends('layouts.app')

@section('title')
<title>Home</title>
@endsection

@section('style')
@include('includes.style')
{{-- <style type="text/css">
	.gem-stone-text p{
		min-height: 40px;
	}
	.gem-stone-text h5{
		min-height: 47px;
	}
</style> --}}
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')
<?php
 $custom = (new \App\Helpers\CustomHelper)->currencyConversion();
?>

@if(@$banner_setting->setting_type=="I" && @$banner_details->isNotEmpty())
<div class="bannersec">
	<div id="carouselExampleControls" class="carousel slide @if(@$banner_setting->transition=="carousel-fade") carousel-fade @endif " data-ride="carousel">
	  <div class="carousel-inner">
	  	@foreach($banner_details as $key=> $value)
	    <div class="carousel-item @if(count($banner_details)==1)  active @else @if($key==1)active @endif @endif ">
	      <div class="banner_box">
	      	<img src="{{ URL::to('storage/app/public/banner_image/'.@$value->image)}}" alt="">
	      		<div class="banner_tx_bx">
	      			<div class="container">
	      				<div class="bbn_tx">
	      					@if(@$value->heading!="")<strong>{{@$value->heading}}</strong>@endif
	      					@if(@$value->sub_heading!="")<p>{{@$value->sub_heading}}</p>@endif
	      					@if(@$value->button_link!="" && @$value->button_caption!="")  <a href="{{@$value->button_link}}" class="pag_btn">{{@$value->button_caption}}</a> @endif
	      				</div>
	      			</div>
	      		</div>
	      		<div class="ban_pick_bx">
	      			<div class="container">
	      				<div class="ban_pick">
	      					<img src="{{ URL::to('public/frontend/images/banerpick1.png')}}" alt="">
	      				</div>
	      			</div>
	      		</div>
	      </div>
	    </div>
	    @endforeach
	    
	    
	  </div>
	  <div class="carousel-control_bx">
	  	<ul>
	  		<li><a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">	  </a></li>
	  		<li><a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">	  </a></li>
	  	</ul>
	  </div>
	</div>
</div>
@elseif(@$banner_setting->setting_type=="V" && @$banner_setting->video!="")
<div class="bannersec">
<div class="banner_box">
	      	<div class="ban_vedio">
	      		 <video autoplay loop muted class="wrapper__video" id="videoPlay">
			      <source src="{{ URL::to('storage/app/public/banner_video/'.@$banner_setting->video)}}">
			   </video> 
			   <button id="unmuteButton" style="position: absolute;bottom: 20px; width: 50px;z-index: 9;
    left: 20px;
    display: block;
    font-size: 30px;
    background: #fff;
    border: none;height:50px;border-radius:100%;"><i class="fa fa-volume-off"></i></button>
	      	</div>
	      		<div class="banner_tx_bx">
	      			<div class="container">
	      				<div class="bbn_tx">
	      					@if(@$banner_setting->heading!="")<strong>{{@$banner_setting->heading}}</strong>@endif
	      					@if(@$banner_setting->sub_heading!="")<p>{{@$banner_setting->sub_heading}}</p>@endif
	      					@if(@$banner_setting->button_link!="" && @$banner_setting->button_caption!="")  <a href="{{@$banner_setting->button_link}}" class="pag_btn">{{@$banner_setting->button_caption}}</a> @endif
	      				</div>
	      			</div>
	      		</div>
	      </div>
</div>	



@else
<div class="bannersec">
	<div id="carouselExampleControls" class="carousel slide @if(@$banner_setting->transition=="carousel-fade") carousel-fade @endif " data-ride="carousel">
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <div class="banner_box">
	      	<img src="{{ URL::to('public/frontend/images/banimg1.jpg')}}" alt="">
	      		<div class="banner_tx_bx">
	      			<div class="container">
	      				<div class="bbn_tx">
	      					<strong>Ultimate Guides</strong>
	      					<ul>
		      					<li>Horoscope</li>
		      					<li>Astolorgers</li>
		      					<li>Remedies</li>
		      					<li>Gemstone</li>
		      				</ul>
	      					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doinim ea commodo consequat. Duis aute irure dolor in reprehenderit in
	      					  dolore eu fugiat nulla pariatur.</p>
	      					  <a href="#url" class="pag_btn">Let???s Begin</a>
	      				</div>
	      			</div>
	      		</div>
	      		<div class="ban_pick_bx">
	      			<div class="container">
	      				<div class="ban_pick">
	      					<img src="{{ URL::to('public/frontend/images/banerpick1.png')}}" alt="">
	      				</div>
	      			</div>
	      		</div>
	      </div>
	    </div>
{{-- 	    <div class="carousel-item">
	      <div class="banner_box">
	      	<img src="{{ URL::to('public/frontend/images/banimg1.jpg')}}" alt="">
	      		<div class="banner_tx_bx">
	      			<div class="container">
	      				<div class="bbn_tx">
	      					<strong>Ultimate Guides</strong>
	      					<ul>
		      					<li>Horoscope</li>
		      					<li>Astolorgers</li>
		      					<li>Remedies</li>
		      					<li>Gemstone</li>
		      				</ul>
	      					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doinim ea commodo consequat. Duis aute irure dolor in reprehenderit in
	      					  dolore eu fugiat nulla pariatur.</p>
	      					  <a href="#url" class="pag_btn">Let???s Begin</a>
	      				</div>
	      			</div>
	      		</div>
	      		<div class="ban_pick_bx">
	      			<div class="container">
	      				<div class="ban_pick">
	      					<img src="{{ URL::to('public/frontend/images/banerpick1.png')}}" alt="">
	      				</div>
	      			</div>
	      		</div>
	      </div>
	    </div>
	    <div class="carousel-item">
	      <div class="banner_box">
	      	<img src="{{ URL::to('public/frontend/images/banimg1.jpg')}}" alt="">
	      		<div class="banner_tx_bx">
	      			<div class="container">
	      				<div class="bbn_tx">
	      					<strong>Ultimate Guides</strong>
	      					<ul>
		      					<li>Horoscope</li>
		      					<li>Astolorgers</li>
		      					<li>Remedies</li>
		      					<li>Gemstone</li>
		      				</ul>
	      					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed doinim ea commodo consequat. Duis aute irure dolor in reprehenderit in
	      					  dolore eu fugiat nulla pariatur.</p>
	      					  <a href="#url" class="pag_btn">Let???s Begin</a>
	      				</div>
	      			</div>
	      		</div>
	      		<div class="ban_pick_bx">
	      			<div class="container">
	      				<div class="ban_pick">
	      					<img src="{{ URL::to('public/frontend/images/banerpick1.png')}}" alt="">
	      				</div>
	      			</div>
	      		</div>
	      </div>
	    </div> --}}
	  </div>
	  <div class="carousel-control_bx">
	  	<ul>
	  		<li><a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">	  </a></li>
	  		<li><a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">	  </a></li>
	  	</ul>
	  </div>
	</div>
</div>
@endif























<section class="horoscope_sec">
	<div class="container">
		<div class="pghed">
			<h1>Free <b>Horoscope</b></h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
		</div>
		<div class="horoscope_iner">
			<div class="row">
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope1.png')}}" alt=""></span>
						<strong><a href="#url">Aries</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope2.png')}}" alt=""></span>
						<strong><a href="#url">Taurus</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope3.png')}}" alt=""></span>
						<strong><a href="#url">Gemini</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope4.png')}}" alt=""></span>
						<strong><a href="#url">Cancer</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope5.png')}}" alt=""></span>
						<strong><a href="#url">Leo</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope6.png')}}" alt=""></span>
						<strong><a href="#url">Virgo</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope7.png')}}" alt=""></span>
						<strong><a href="#url">Libra</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope8.png')}}" alt=""></span>
						<strong><a href="#url">Scoipio</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope9.png')}}" alt=""></span>
						<strong><a href="#url">Saggitarius</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope10.png')}}" alt=""></span>
						<strong><a href="#url">Capricorn</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope11.png')}}" alt=""></span>
						<strong><a href="#url">Aquarius</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
				<div class="col-md-2">
					<div class="horoscope_bx">
						<span><img src="{{ URL::to('public/frontend/images/horoscope12.png')}}" alt=""></span>
						<strong><a href="#url">Pisces</a></strong>
						<em>Mar 21 - Apr 19</em>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="take_astro_sec astro_cc">
	<div class="take_astro_bg"><i><img src="{{ URL::to('public/frontend/images/take_astro_bg.png')}}" alt=""></i></div>
	<div class="container">
		<div class="pghed">
			<h2>Talk with <b>Astrologers</b></h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
		</div>
		<div class="take_astro_iner">
			<div class="owl-carousel">
                {{-- @foreach (@$astrologers as $astrologer)
                <div class="item">
                    <div class="take_astro_item">
                        <span><img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$astrologer->profile_img}}" alt=""></span>
                        <div class="take_astro_text">
                            <a href="javascript:;" class="tack_new" data-slug="{{@$astrologer->slug}}"><i class="fa fa-envelope-o"></i>Talk Now</a>
                            <h4><a href="{{route('astrologer.search.publicProfile',['slug'=>@$astrologer->slug])}}">{{$astrologer->first_name}} {{$astrologer->lastname_name}}</a><b><i class="fa fa-star"></i>{{@$astrologer->avg_review}}</b></h4>
                            <ul class="talk_dat">
                                <li><em><img src="{{ URL::to('public/frontend/images/dollIconbag.png')}}" alt=""></em> {{@$astrologer->experience}} Years</li>
                                <li><em><img src="{{ URL::to('public/frontend/images/dollIcon1.png')}}" alt=""></em> Rs. {{@$astrologer->call_price}}/min</li>
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach --}}
                <div class="item">
                    <div class="take_astro_item">
                        <span><img src="{{ URL::to('public/frontend/images/take_astro1.jpg')}}" alt=""></span>
                        <div class="take_astro_text">
                            <a href="#url" class="tack_new"><i class="fa fa-envelope-o"></i>Talk Now</a>
                            <h4><a href="#url">Micky Holley</a><b><i class="fa fa-star"></i>4.5</b></h4>
                            <ul class="talk_dat">
                                <li><em><img src="{{ URL::to('public/frontend/images/dollIconbag.png')}}" alt=""></em> 6 Years</li>
                                <li><em><img src="{{ URL::to('public/frontend/images/dollIcon1.png')}}" alt=""></em> Rs. 50/min</li>
                            </ul>
                        </div>
                    </div>
                </div>

				<div class="item">
					 <div class="take_astro_item">
					 	<span><img src="{{ URL::to('public/frontend/images/take_astro2.jpg')}}" alt=""></span>
					 	<div class="take_astro_text">
					 		<a href="#url" class="tack_new"><i class="fa fa-envelope-o"></i>Talk Now</a>
					 		<h4><a href="#url">Micky Holley</a><b><i class="fa fa-star"></i>4.5</b></h4>
						 	<ul class="talk_dat">
						 		<li><em><img src="{{ URL::to('public/frontend/images/dollIconbag.png')}}" alt=""></em> 6 Years</li>
						 		<li><em><img src="{{ URL::to('public/frontend/images/dollIcon1.png')}}" alt=""></em> Rs. 50/min</li>
						 	</ul>
					 	</div>
					 </div>
				</div>
				<div class="item">
					 <div class="take_astro_item">
					 	<span><img src="{{ URL::to('public/frontend/images/take_astro3.jpg')}}" alt=""></span>
					 	<div class="take_astro_text">
					 		<a href="#url" class="tack_new"><i class="fa fa-envelope-o"></i>Talk Now</a>
					 		<h4><a href="#url">Micky Holley</a><b><i class="fa fa-star"></i>4.5</b></h4>
						 	<ul class="talk_dat">
						 		<li><em><img src="{{ URL::to('public/frontend/images/dollIconbag.png')}}" alt=""></em> 6 Years</li>
						 		<li><em><img src="{{ URL::to('public/frontend/images/dollIcon1.png')}}" alt=""></em> Rs. 50/min</li>
						 	</ul>
					 	</div>
					 </div>
				</div>
				<div class="item">
					 <div class="take_astro_item">
					 	<span><img src="{{ URL::to('public/frontend/images/take_astro4.jpg')}}" alt=""></span>
					 	<div class="take_astro_text">
					 		<a href="#url" class="tack_new"><i class="fa fa-envelope-o"></i>Talk Now</a>
					 		<h4><a href="#url">Micky Holley</a><b><i class="fa fa-star"></i>4.5</b></h4>
						 	<ul class="talk_dat">
						 		<li><em><img src="{{ URL::to('public/frontend/images/dollIconbag.png')}}" alt=""></em> 6 Years</li>
						 		<li><em><img src="{{ URL::to('public/frontend/images/dollIcon1.png')}}" alt=""></em> Rs. 50/min</li>
						 	</ul>
					 	</div>
					 </div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Buy Gem Stone -->
@if(@$gemstones->isNotEmpty())
<section class="gem-stone-sec">
	<div class="container">
		<div class="pghed">
			<h3>Buy <b>Gem Stone</b></h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
		</div>
		<div class="gem-stone-iner">
			<div class="owl-carousel">
				@foreach(@$gemstones as $product)
				<div class="item">
					<div class="gem-stone-item back_white">
						<a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" target="_blank">
						<span>
							@if(@$product->productdefault->image)
                            <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$product->productdefault->image}}"alt="">
                             @else
                             <img src="{{ URL::to('public/frontend/images/ston1.png')}}" alt="">
                             @endif
						</span>
					   </a>
						<div class="gem-stone-text">
							<h5><a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" target="_blank">
								@if(@$product->title && @$product->subtitle)
											{{@$product->title->title}}/{{@$product->subtitle->title}}/{{@$product->product_code}}
										@else
											{{@$product->product_name}}/{{@$product->product_code}}
										@endif</a>
                             </h5>
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
                                                 $old_price = $product->price_per_carat_inr;
                                                  $discount_value = ($old_price / 100) * @$product->discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{@$product->price_per_carat_inr}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{@$product->price_per_carat_inr}}
                                                @endif

                                                @else

                                                @if(@$product->discount_usd!=null && @$product->discount_usd>0)
                                                @php
                                                 $old_price = @$custom * $product->price_per_carat_usd;
                                                  $discount_value = ($old_price / 100) * @$product->discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{round(@$custom * @$product->price_per_carat_usd,2)}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{round(@$custom * @$product->price_per_carat_usd,2)}}
                                                @endif
                                                


                                                @endif
												<span class="gemstone_carat">per carat</span>
								</li>
								<li> @if(@$product->availability=="Y")<a href="{{route('gemstone.details',['slug'=>@$product->slug])}}"  class="pag_btn" target="_blank" data-product="{{@$product->id}}">Buy Now</a>@else<a href="javascript:;" class="pag_btn">Out Of Stock</a>  @endif</li>
							</ul>
						</div>
					</div>
				</div>
				@endforeach
			</div>
			
			<div class="gem_ston_btn">
				<a href="{{route('gemstone.search')}}" class="pag_btn" >See All Gem Stones</a>
			</div>
			
		</div>
	</div>
</section>
@endif

<!-- Book Your Puja -->
@if(@$pujas->isNotEmpty())
<section class="book_puja">
	<div class="container">
		<div class="pghed">
			<h3>Book <b>Your Puja</b></h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
		</div>
		<div class="boock_puja_iner">
			<div class="owl-carousel">
				@foreach(@$pujas as $puja)
				<div class="item">
					<div class="book_puja_item">
						<div class="book_puja_img">
							<a href="{{route('search.puja.details',['slug'=>@$puja->slug])}}" target="_blank">
							<img src="{{ URL::to('storage/app/public/puja_image')}}/{{@$puja->puja_image}}">
						    </a>
							<em>Price. <b>@if(@session()->get('currency')==1)
                                                    @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                                   @php
                                                    $old_price = $puja->price_inr;
                                                    $discount_value = ($old_price / 100) * @$puja->discount_inr;
                                                    $new_price = $old_price - $discount_value;
                                                    @endphp
                                                    <del>{{@session()->get('currencySym')}} {{@$puja->price_inr}} </del> &nbsp;   {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                    @else
                                                    {{@session()->get('currencySym')}} {{@$puja->price_inr}}
                                                    @endif
                                                    @else
                                                    @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                                    @php
                                                    $old_price = @$custom * $puja->price_usd;
                                                    $discount_value = ($old_price / 100) * @$puja->discount_usd;
                                                    $new_price = $old_price - $discount_value;
                                                    @endphp
                                                    <del>{{@session()->get('currencySym')}} {{round(@$custom * @$puja->price_usd,2)}} </del> &nbsp;  {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                    @else
                                                    {{@session()->get('currencySym')}} {{round(@$custom * @$puja->price_usd,2)}}
                                                    @endif
                                                    





                                                    @endif</b></em>
						</div>
						<div class="book_puja_text">
							<a href="{{route('search.puja.details',['slug'=>@$puja->slug])}}" target="_blank"><h6>@if(strlen(@$puja->puja_name) > 20)
                                        {!! substr(@$puja->puja_name, 0, 20 ) . '...' !!} /  {{@$puja->puja_code}}
                                        @else
                                        {!! @$puja->puja_name !!} /  {{@$puja->puja_code}}
                                        @endif</h6></a>
							<p>{{substr(@$puja->puja_description, 0, 75)}}..</p>
							<span><a href="{{route('search.puja.details',['slug'=>@$puja->slug])}}" class="pag_btn" target="_blank">View More</a></span>
						</div>
					</div>
				</div>
				@endforeach

				{{-- <div class="item">
					<div class="book_puja_item">
						<div class="book_puja_img">
							<img src="{{ URL::to('public/frontend/images/puja2.jpg')}}">
							<em>Starting Form Rs. <b>1147</b></em>
						</div>
						<div class="book_puja_text">
							<h6>Diwali Puja 2021</h6>
							<p>Lorem quis bibendum auctor, nisi elit nibh id elit. Duis sed .</p>
							<span><a href="#url" class="pag_btn">View More</a></span>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="book_puja_item">
						<div class="book_puja_img">
							<img src="{{ URL::to('public/frontend/images/puja3.jpg')}}">
							<em>Starting Form Rs. <b>1147</b></em>
						</div>
						<div class="book_puja_text">
							<h6>Krishna Puja 2021</h6>
							<p>Lorem quis bibendum auctor, nisi elit nibh id elit. Duis sed .</p>
							<span><a href="#url" class="pag_btn">View More</a></span>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="book_puja_item">
						<div class="book_puja_img">
							<img src="{{ URL::to('public/frontend/images/puja4.jpg')}}">
							<em>Starting Form Rs. <b>1147</b></em>
						</div>
						<div class="book_puja_text">
							<h6>Bengali New Year Puja </h6>
							<p>Lorem quis bibendum auctor, nisi elit nibh id elit. Duis sed .</p>
							<span><a href="#url" class="pag_btn">View More</a></span>
						</div>
					</div>
				</div> --}}
			</div>
		</div>
	</div>
</section>
@endif


<!-- Buy Astro Product -->
@if(@$products->isNotEmpty())
<section class="gem-stone-sec">
	<div class="container">
		<div class="pghed">
			<h3>Buy <b>Astro Product</b></h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
		</div>
		<div class="astro-product-iner">
			<div class="owl-carousel">
				@foreach(@$products as $product)
				<div class="item">
					<div class="gem-stone-item back_white">
						<a href="{{route('product.search.details',['slug'=>@$product->slug])}}" target="_blank">
						<span>
							@if(@$product->productdefault->image)
                            <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$product->productdefault->image}}"alt="">
                             @else
                             <img src="{{ URL::to('public/frontend/images/ston1.png')}}" alt="">
                             @endif
						</span>
					   </a>
						<div class="gem-stone-text">
							<h5><a href="{{route('product.search.details',['slug'=>@$product->slug])}}" target="_blank">
								@if(strlen(@$product->product_name) > 45)
                                            {!! substr(@$product->product_name, 0, 45 ) . '..' !!} / {{@$product->product_code}}
                                            @else
                                            {!!@$product->product_name!!} / {{@$product->product_code}}
                                            @endif</a>
                             </h5>
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
                                                 $old_price = @$custom * $product->price_usd;
                                                  $discount_value = ($old_price / 100) * @$product->discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{round(@$custom * @$product->price_usd,2)}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{round(@$custom * @$product->price_usd,2)}}
                                                @endif
                                                @endif
								</li>
								<li> @if(@$product->availability=="Y")<a href="javascript:;" class="pag_btn buynow" data-product="{{@$product->id}}">Buy Now</a>@else<a href="javascript:;" class="pag_btn">Out Of Stock</a>  @endif</li>
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
				</div> --}}
			</div>
			
			<div class="gem_ston_btn">
				<a href="{{route('product.search')}}" class="pag_btn" >See All Products</a>
			</div>
			
		</div>
	</div>
</section>
@endif


<!-- pundit -->
@if(Auth::user()==null)
<section class="punditSec">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<div class="punditBx">
					<h4>Are You a <b>Astrologer</b></h4>
					<a href="{{route('astrologer.register')}}" class="pag_btn"> Sign Up as a Astrologer</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="punditBx">
					<h4> Are You a <b>Pundit</b></h4>
					<a href="{{route('pundit.register')}}" class="pag_btn">  Sign Up as a Pundit</a>
				</div>
			</div>
			<div class="col-md-4">
				<div class="punditBx">
					<h4>Are You a <b>GemStone Supplier</b></h4>
					<a href="{{route('seller.register')}}" class="pag_btn"> Sign Up as a GemStone Supplier </a>
				</div>
			</div>
		</div>
	</div>
</section>
@endif
<!-- Videos & Blogs -->
@if(@$blogs->isNotEmpty())
<section class="videos-blog-sec">
	<div class="container">
		<div class="pghed">
			<h4>Videos <b>& Blogs</b></h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
		</div>
		<div class="videos-blog-iner">
			<div class="row">
				@if(@$featured->isNotEmpty())
				@foreach(@$featured as $blog)
				<div class="col-md-4 pt-4 back_white">
					<div class="videos-blog-item">
						<a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
						<div class="videos-blog-img">
							<img src="{{ URL::to('storage/app/public/SmallBlogImage')}}/{{@$blog->blog_pic}}">
						</div>
					    </a>
						<div class="videos-blog-text">
							<div class="videos-post">
								<strong><i><img src="{{ URL::to('public/frontend/images/posticon1.png')}}" alt=""></i>Posted by : <em>{{@$blog->author_name}}</em></strong>
								<span><i class="fa fa-calendar"></i>{{date('d.m.Y',strtotime(@$blog->created_at))}}</span>
							</div>
							<h5><a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
								@if(strlen(@$blog->blog_title) >50)
								{!! substr(@$blog->blog_title, 0, 50 )!!}...
								@else
								{{@$blog->blog_title}}
								@endif
							</a></h5>
							<p>
								@if(strlen(@$blog->blog_desc) >200)
								{!!strip_tags(substr(@$blog->blog_desc, 0, 200 ))!!}...
								@else
								{!!@$blog->blog_desc!!}

								@endif
							</p>
							<a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" class="red_mor" target="_blank">Read more</a>
						</div>
					</div>
				</div>
				@endforeach
				@else
				@foreach(@$blogs as $blog)
				<div class="col-md-4 pt-4">
					<div class="videos-blog-item">
						<a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
						<div class="videos-blog-img">
							<img src="{{ URL::to('storage/app/public/SmallBlogImage')}}/{{@$blog->blog_pic}}">
						</div>
					    </a>
						<div class="videos-blog-text">
							<div class="videos-post">
								<strong><i><img src="{{ URL::to('public/frontend/images/posticon1.png')}}" alt=""></i>Posted by : <em>{{@$blog->author_name}}</em></strong>
								<span><i class="fa fa-calendar"></i>{{date('d.m.Y',strtotime(@$blog->created_at))}}</span>
							</div>
							<h5><a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
								@if(strlen(@$blog->blog_title) >50)
								{!! substr(@$blog->blog_title, 0, 50 )!!}...
								@else
								{{@$blog->blog_title}}
								@endif
							</a></h5>
							<p>
								@if(strlen(@$blog->blog_desc) >200)
								{!!strip_tags(substr(@$blog->blog_desc, 0, 200 ))!!}...
								@else
								{!!@$blog->blog_desc!!}

								@endif
							</p>
							<a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" class="red_mor" target="_blank">Read more</a>
						</div>
					</div>
				</div>
				@endforeach
				@endif
				
			</div>
			<div class="gem_ston_btn">
				<a href="{{route('blog.show.frontend')}}" class="pag_btn" >See All Blogs</a>
			</div>
		</div>
	</div>
</section>
@endif
<!-- Testimonials  -->
<section class="testimonials_sec">
	<div class="testimonials_bg"><i><img src="{{ URL::to('public/frontend/images/testimoni_bg.png')}}"></i></div>
	<div class="container">
		<div class="pghed">
			<h4>Clients <b>Testimonials </b></h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
		</div>
		<div class="testimonials_inr">
			<div class="owl-carousel">
				<div class="item">
					<div class="testimoni_item">
						<div class="testimoni_img">
							<img src="{{ URL::to('public/frontend/images/testimoni1.png')}}" alt="">
						</div>
						<div class="testimoni_text">
							<p>???Lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem sequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet.</p>
							<strong>Charlyn Stewart, </strong>
							<em>Business Man</em>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="testimoni_item">
						<div class="testimoni_img">
							<img src="{{ URL::to('public/frontend/images/testimoni2.png')}}" alt="">
						</div>
						<div class="testimoni_text">
							<p>???Lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem sequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet.</p>
							<strong>Charlyn Stewart, </strong>
							<em>Business Man</em>
						</div>
					</div>
				</div>
				<div class="item">
					<div class="testimoni_item">
						<div class="testimoni_img">
							<img src="{{ URL::to('public/frontend/images/testimoni3.png')}}" alt="">
						</div>
						<div class="testimoni_text">
							<p>???Lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem sequat ipsum, nec sagittis sem nibh id elit. Duis sed odio sit amet.</p>
							<strong>Charlyn Stewart, </strong>
							<em>Business Man</em>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal" tabindex="-1" role="dialog" id="durarion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Call Booking</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form method="POST" enctype="multipart/form-data" id="duration_from"
                            {{-- action="{{route('astrologer.call.booking',['slug'=>@$userData->slug])}}" --}}>
                            @csrf
                            <div class="main-center-div">@include('includes.message')
                                <div class="login-from-area">
                                    <input type="hidden" name="astrologer_id" id="astrologer_id">
                                    <input type="hidden" id="astrologer_rate">
                                    <input type="hidden" id="u_id" @if(@auth()->user()->id) value="1" @endif>
                                    {{-- <h2>{{__('auth.otp_header')}}</h2> --}}
                                    <div class="marb20">
                                        <select class="login-type log-select" name="call_day" id="call_day">
                                            <option value="">Select Day</option>
                                            {{-- @foreach ($userData->userAvailable as $key=>$available)
                                        <option value="{{$available->day}}" >
                                            @if($available->day =='SUNDAY')
                                            {{__('search.sunday')}}
                                            @elseif($available->day =='MONDAY')
                                            {{__('search.monday')}}
                                            @elseif($available->day =='TUESDAY')
                                            {{__('search.tuesday')}}
                                            @elseif($available->day =='WEDNESDAY')
                                            {{__('search.wednesday')}}
                                            @elseif($available->day =='THURSDAY')
                                            {{__('search.thursday')}}
                                            @elseif($available->day =='FRIDAY')
                                            {{__('search.friday')}}
                                            @elseif($available->day =='SATURDAY')
                                            {{__('search.saturday')}}
                                            @endif
                                            </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div>
                                        <input class="login-type" id="time_duration" name="time_duration" type="number"
                                            placeholder="Duration in Min"
                                            oninput="this.value = this.value.replace(/[^0-9.]/g,'')">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="birth-details" id="amount">
                                        <h3>Total Amount: - 0</h3>
                                        <div>

                                            {{-- <input type="text" class="login-type" placeholder="0" name="amount" id="amount" readonly> --}}
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <button type="submit" class="login-submit">Booking</button>
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
@endsection



@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
{{-- @include('includes.toaster') --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
   <script>
	$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });
	@if(@$banner_setting->setting_type=="V" && @$banner_setting->video!="")
	var promise = document.querySelector('video').play();

if (promise !== undefined) {
  promise.then(_ => {
    console.log('playing');
  }).catch(error => {
    console.log('No playing');
  });
}
unmuteButton.addEventListener('click', function() {
	if( $("video").prop('muted') ) {
          $("video").prop('muted', false);
		  $(this).html('<i class="fa fa-volume-up"></i>');
    } else {
      $("video").prop('muted', true);
	  $(this).html('<i class="fa fa-volume-off"></i>');
    }
    
  });
  @endif

</script>
{{-- <script>
    $(document).ready(function(){
        $("#duration_from").validate({
            rules: {
                call_day:{
                    required: true,
                },
                time_duration:{
                    required: true,
                    number: true ,
                    min:5,
                    max:60,
                },
            },
            messages: {
                call_day:{
                    required: 'Select call booking day',
                },
                time_duration:{
                    required: 'Enter duration for call',
                    number: 'Only Number enter' ,
                    min:'Minumum call duration 5 minutes',
                    max:'Maximum call duration 60 minutes',
                },
            },
        });
        $('.tack_new').click(function(){
            if(!$('#u_id').val()){
            Swal.fire('Please login to Call booking');
            return 0;
            }
            var slug = $(this).data('slug');
            console.log($(this).data('slug'))
            $('#call_day').html('');
            if (slug != "") {
                $.ajax({
                    url: "astrologer-details/"+slug,
                    method: 'GET',
                    dataType: 'JSON'
                })
                .done(function (response) {
                    if (response.result) {
                        const res = response.result.userData.user_available;
                        console.log(res);
                        $('#call_day').append('<option value="" selected>Select Day</option>');
                        $('#astrologer_rate').val(response.result.userData.call_price);
                        $('#astrologer_id').val(response.result.userData.id);
                        var url = '{{ route("astrologer.call.booking", ":slug") }}';
                        url = url.replace(':slug', response.result.userData.slug)
                        $('#duration_from').attr('action', url);
                        $.each(res, function (i, v) {
                            $('#call_day').append('<option value="' + v.day + '"">' + v.day + '</option>');
                        })
                        $("#durarion").modal("show");
                    }else{
                        $('#call_day').html('<option value="" selected>Day Not Available</option>');
                        Swal.fire('Astrologer Day Not Available');
                        return 0;
                    }
                })
                .fail(function (error) {
                    $('#call_day').html('<option value="" selected>Select Day</option>');
                });
            } else {
                $('#call_day').html('<option value="" selected>Select Day</option>');
            }
        })
        $('#time_duration').keyup(function(){
            var duration=$(this).val();
            var rate=$('#astrologer_rate').val();;
            $('#amount h3').html('Total Amount: - '+duration*rate);
            console.log(duration*rate)
        });
        $('#time_duration').blur(function(){
            var duration=$(this).val()
            var rate=$('#astrologer_rate').val();;
            $('#amount h3').html('Total Amount: - '+duration*rate);
            console.log(duration*rate)
        });
    })
</script> --}}
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
@endsection
