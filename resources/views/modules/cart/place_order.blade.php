@extends('layouts.app')

@section('title')
<title>Place Order</title>
@endsection

@section('style')
@include('includes.style')
<style>
    .error{
        color: #ff0000 !important;
    }
</style>
@endsection


@section('header')
@include('includes.header')
@endsection



@section('body')

<section class="pad-114">
    <div class="product-det">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cart-head">
                        <h2>Shopping Cart</h2>
                    </div>
                    <div class="cart-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">Product Details</div>
                                <div class="cell amunt cess">Quantity</div>
                                <div class="cell amunt cess">Unit Price </div>
                                <div class="cell amunt cess">Total </div>
                                <div class="cell amunt cess">Refundable</div>
                                <div class="cell amunt cess">Tentative date of Delivery</div>
                                <div class="cell amunt cess font0">Action</div>
                            </div>
                            @if($allCartData->count()>0)
                            @foreach ($allCartData as $cart)
                            <div class="row small_screen2 scernexr new-tabc">
                                <div class="cell amunt-detail cess"> <span class="hide_big font0">Product Details</span>
                                    <div class="product">
                                        <figure class="product-media">
                                            @if($cart->cart_type=='GS')
												<a href="{{route('gemstone.details',['slug'=>$cart->product->slug])}}">
													<img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$cart->productdefault->image}}" alt="Product image">
												</a>
											@else
												<a href="{{route('product.search.details',['slug'=>$cart->product->slug])}}">
													<img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$cart->productdefault->image}}" alt="Product image">
												</a>
											@endif
                                        </figure>
                                        <div class="cart-details">
                                            <h3 class="product-title">
                                                @if($cart->cart_type=='GS')
                                                <a href="{{route('gemstone.details',['slug'=>$cart->product->slug])}}">@if(@$cart->product['title']) {{@$cart->product['title']->title}}@if(@$cart->product['subtitle'])/{{@$cart->product['subtitle']->title}} @endif /{{@$cart->product->product_code}} @else {{@$cart->product->product_name}}/{{@$cart->product->product_code}} @endif</a>
											@else
												<a href="{{route('product.search.details',['slug'=>$cart->product->slug])}}">{{@$cart->product->product_name}}/{{@$cart->product->product_code}}</a>
											@endif
                                            </h3>
											@if($cart->cart_type=='GS')
												<p>@if(@$cart->jewellery_type=='OS') Only Stone @elseif(@$cart->jewellery_type=='R') With Ring @elseif(@$cart->jewellery_type=='P') With Pendant @elseif(@$cart->jewellery_type=='B') With Bracelet @endif</p>
											<p><a href="javascript:void(0);" class="more_info" data-id="{{$cart->id}}">More Info</a></p>
											@endif
                                            @if(@$cart->product->color)
                                            <p>Color : <span>{{$cart->product->color}}</span> </p>
                                            @endif
                                            @if(@$cart->product->size)
                                            <p>Size : <span> {{$cart->product->size}} MM</span> </p>
                                            @endif
                                            @if(@session()->get('currency')==1 && $cart->gift_pack_price_inr>0)
                                            <p>Gift pack added : <span> {{session()->get('currencySym').$cart->gift_pack_price_inr}}</span> </p>
                                            @endif
                                            @if(@session()->get('currency')>=2 && $cart->gift_pack_price_usd>0)
                                            <p>Gift pack added : <span> {{session()->get('currencySym').round($cart->gift_pack_price_usd*currencyConversionCustom(),2)}}</span> </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Quantity:</span>
                                    <div class="product-quantity new-quantity">
                                        <div class="product-quantity">
                                            <div class="quantity-selectors">
                                                <input data-min="1" data-max="0" type="text" id="quantity{{$cart->id}}" name="quantity" value="{{@$cart->quantity}}" readonly="true" style="border: none">
												<div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(@session()->get('currency')==1)
                                <div class="cell amunt-detail cess" id="unit_price{{$cart->id}}"> <span class="hide_big">Unit Price: </span> {{session()->get('currencySym').@$cart->price_inr}}</div>
                                <div class="cell amunt-detail cess" id="total_price{{$cart->id}}"> <span class="hide_big">Total:</span>{{session()->get('currencySym').@$cart->total_price_inr}}</div>
                                @elseif(@session()->get('currency')>=2)
                                <div class="cell amunt-detail cess" id="unit_price{{$cart->id}}"> <span class="hide_big">Unit Price: </span> {{session()->get('currencySym').round(@$cart->price_usd*currencyConversionCustom(),2)}}</div>
                                <div class="cell amunt-detail cess" id="total_price{{$cart->id}}"> <span class="hide_big">Total:</span>{{session()->get('currencySym').round(@$cart->total_price_usd*currencyConversionCustom(),2)}}</div>
                                @endif

                                <div class="cell amunt-detail cess"> <span class="hide_big">Refundable: </span>@if($cart->product->refundable=="Y")Yes (@if(@$cart->product->refundable_status=="E")Exchange Only @elseif(@$cart->product->refundable_status=="'FR") Fully Refundable @elseif(@$cart->product->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif) @else No @endif </div>

                                <div class="cell amunt-detail cess"> <span class="hide_big">Tentative date of Delivery: </span>
                                  @if(@session()->get('currency')==1)
                                  @if(@$cart->product->delivery_days_india!="")
									  @if(@$cart->cirtificate)
										  <?php $days = @$cart->product->delivery_days_india+@$cart->cirtificate['certificate_name']->no_of_days+1  ?>
										  @else
											  <?php $days = @$cart->product->delivery_days_india+1  ?>
										@endif
                                  Before {{date('F j, Y', strtotime(date('Y-m-d'). ' + '.$days.' days'))}}
                                  @else
                                  --
                                  @endif
                                  @else
                                  @if(@$cart->product->delivery_days_outside_india!="")
									  @if(@$cart->cirtificate)
										  <?php $days = @$cart->product->delivery_days_outside_india+@$cart->cirtificate['certificate_name']->no_of_days+1  ?>
										  @else
											  <?php $days = @$cart->product->delivery_days_outside_india+1  ?>
										@endif
                                 Before {{date('F j, Y', strtotime(date('Y-m-d'). ' + '.$days.' days'))}}
                                  @else
                                  --
                                  @endif

                                  @endif

                                 </div>

                            </div>
                            @endforeach
                            @else
                            No Item in shopping cart
                            @endif

                        </div>
                    </div>
                    <div class="cart-price-box">
                        <div class="pull-right wid-cart">
                            @if(@session()->get('currency')==1)
                            <h4>Subtotal<span class="pull-right"  id="sub_amount">{{session()->get('currencySym').$allCartData->sum('total_price_inr')}}</span></h4>
                            <h4>SHIPPING CHARGES<span class="pull-right ">{{session()->get('currencySym')}}0</span></h4>
                            <div class="total-pay">
                                <h3 >Total payable amount<span class="pull-right " id="total_amount" >{{session()->get('currencySym').$allCartData->sum('total_price_inr')}}</span></h3>
                            </div>
                            @elseif(@session()->get('currency')>=2)
                            <h4>Subtotal<span class="pull-right " id="sub_amount">{{session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)}}</span></h4>
                            <h4>SHIPPING CHARGES<span class="pull-right ">{{session()->get('currencySym')}}0</span></h4>
                            <div class="total-pay">
                                <h3 >Total payable amount<span class="pull-right " id="total_amount">{{session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)}}</span></h3>
                            </div>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <form method="post" id="order_form" action="{{route('product.shopping.placed.order.success')}}">
                        @csrf
                        <div class="shipping-details">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Shipping Information</h2>
                                            {{-- <ul>
                                                <li id="shiping_address"><i class="fa fa-pencil"></i></li>
                                            </ul> --}}
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="shipping-body">
                                            <h3>{{@$request['fname']}} {{@$request['lname']}}</h3>
                                            <p><img src="{{ URL::to('public/frontend/images/call.png')}}"> {{@$request['phone']}}</p>
                                            <p><img src="{{ URL::to('public/frontend/images/mes.png')}}">  {{@$request['email']}}</p>
                                            <p>
                                                <img src="{{ URL::to('public/frontend/images/map1.png')}}">
                                                Street - {{@$request['st_address']}} ,
                                                Landmark - {{@$request['landmark']}} ,
                                                Address - {{@$request['address']}} ,
                                                @foreach ($state as $s1)
                                                {{ @$request['state']==$s1->id? 'State - '. $s1->name .',':'' }}
                                                @endforeach
                                                @foreach ($AllCountry as $cc)
                                                {{@$request['country']==$cc->id? 'Country - '. @$cc->name : ''  }}
                                                @endforeach
                                                @foreach ($city as $ct)
                                                {{@$request['city']==$ct->id? 'City - '. @$ct->name : ''  }}
                                                @endforeach
                                                Postal Code - {{@$request['zip_code']}} ,
                                                @if(@$request['area_drop']== 'O')
                                                    Area - {{@$request['area']}}
                                                @else
                                                    @foreach ($areas as $ar)
                                                    {{@$request['area_drop']==$ar->id? 'Area - '. @$ar->area : ''  }}
                                                    @endforeach
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Billing Information</h2>
                                            {{-- <ul>
                                                <li id="billing_address"><i class="fa fa-pencil"></i></li>
                                            </ul> --}}
                                            <div class="clearfix"></div>
                                        </div>
                                        @if(@$request['same_billing'])
                                        <div class="shipping-body">
                                            <h3>{{@$request['fname']}} {{@$request['lname']}}</h3>
                                            <p><img src="{{ URL::to('public/frontend/images/call.png')}}"> {{@$request['phone']}} </p>
                                            <p><img src="{{ URL::to('public/frontend/images/mes.png')}}">  {{@$request['email']}}</p>
                                            <p>
                                                <img src="{{ URL::to('public/frontend/images/map1.png')}}">
                                                Street - {{@$request['st_address']}} ,
                                                Landmark - {{@$request['landmark']}} ,
                                                Address - {{@$request['address']}} ,
                                                @foreach ($AllCountry as $cc)
                                                {{@$request['country']==$cc->id? 'Country - '. @$cc->name : ''  }}
                                                @endforeach
                                                @foreach ($state as $s1)
                                                {{ @$request['state']==$s1->id? 'State - '. $s1->name .',':'' }}
                                                @endforeach

                                                @foreach ($city as $ct)
                                                {{@$request['city']==$ct->id? 'City - '. @$ct->name : ''  }}
                                                @endforeach
                                                Postal Code - {{@$request['zip_code']}} ,
                                                @if(@$request['area_drop']== 'O')
                                                    Area - {{@$request['area']}}
                                                @else
                                                    @foreach ($areas as $ar)
                                                    {{@$request['area_drop']==$ar->id? 'Area - '. @$ar->area : ''  }}
                                                    @endforeach
                                                @endif

                                            </p>
                                        </div>
                                        @else
                                        <div class="shipping-body">
                                            <h3>{{@$request['bfname']}} {{@$request['blname']}}</h3>
                                            <p><img src="{{ URL::to('public/frontend/images/call.png')}}">{{@$request['bphone']}}</p>
                                            <p><img src="{{ URL::to('public/frontend/images/mes.png')}}">  {{@$request['bemail']}}</p>
                                            <p>
                                                <img src="{{ URL::to('public/frontend/images/map1.png')}}">
                                                Street - {{@$request['bst_address']}} ,
                                                Landmark - {{@$request['blandmark']}} ,
                                                Address - {{@$request['baddress']}} ,
                                                @foreach ($state as $s2)
                                                {{ @$request['bstate']==$s2->id? 'State - '. $s2->name .',':'' }}
                                                @endforeach
                                                @foreach ($AllCountry as $cc2)
                                                {{@$request['bcountry']==$cc2->id? 'Country - '. @$cc2->name : ''  }}
                                                @endforeach
                                                @foreach ($city as $ct2)
                                                {{@$request['bcity']==$ct2->id? 'City - '. @$ct2->name : ''  }}
                                                @endforeach
                                                Postal Code - {{@$request['bzip_code']}} ,
                                                @if(@$request['area_drop1']== 'O')
                                                    Area - {{@$request['area1']}}
                                                @else
                                                    @foreach ($areas as $ar2)
                                                    {{@$request['area_drop1']==$ar2->id? 'Area - '. @$ar2->area : ''  }}
                                                    @endforeach
                                                @endif
                                            </p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="shipping-details" id="shiping_address_div" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Shipping Information</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <hr class="custom-hr">
                                        <div class="input-section-check">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>First name</label>
                                                        <input type="text" placeholder="Enter your first name  " name="fname" value="{{@$request['fname']}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Last Name</label>
                                                        <input type="text" placeholder="Enter your last name " name="lname" value="{{@$request['lname']}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Phone No.</label>
                                                        <input type="tel" placeholder="Enter your Phone no." name="phone" value="{{@$request['phone']}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Email Address</label>
                                                        <input type="email" placeholder="Enter your email address " name="email" value="{{@$request['email']}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                  <div class="form_box_area">
                                                    <label>Country </label>
                                                    <select id="country" name="country">
                                                        <option value="">Select Country</option>
                                                        @foreach ($AllCountry as $country)
                                                        <option value="{{$country->id}}" {{@$request['country']==$country->id?'selected':''}} >{{@$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                          <label>State </label>
                                                          <select id="state" name="state">
                                                              <option value="">Select State</option>
                                                              @foreach ($state as $state1)
                                                              <option value="{{$state1->id}}" {{@$request['state']==$state1->id?'selected':''}} >{{@$state1->name}}</option>
                                                              @endforeach
                                                          </select>
                                                    </div>
                                                  </div>
                                                {{-- <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>City</label>
                                                        <input type="tel" placeholder="Enter your city" name="city" value="{{@$request['city']}}" > </div>
                                                </div> --}}
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>City</label>
                                                        <select class="login-type log-select " name="city" id="city">
                                                            <option value="">Select City</option>
                                                            @if(@$city)
                                                                @foreach (@$city as $ct)
                                                                    <option value="{{$ct->id}}" {{@$request['city']==$ct->id?'selected':''}} >{{@$ct->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label id="city-error" class="error" for="city"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Post Code</label>
                                                        <input type="text" placeholder="Enter your postal code" id="pincode" name="zip_code" value="{{@$request['zip_code']}}">
                                                        <label id="pincode-error" class="error" for="pincode"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4" id="areaDropDiv" >
                                                    <div class="form_box_area">
                                                        <label>Select Area</label>
                                                        <select class="login-type log-select " name="area_drop" id="areaDrop">
                                                            <option value="">Select Area</option>
                                                            @if(@$areas)
                                                                @foreach (@$areas as $area)
                                                                    <option value="{{$area->id}}" {{@$request['area_drop']==$area->id?'selected':''}} >{{@$area->area}}</option>
                                                                @endforeach
                                                                <option value="O">Other</option>
                                                            @endif
                                                        </select>
                                                        <label id="areaDrop-error" class="error" for="areaDrop"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4" id="areaTextDiv" >
                                                    <div class="form_box_area">
                                                        <label>Area</label>
                                                        <input type="text" class="login-type" placeholder="Area" id="areaText" name="area" value="{{ @$request['area'] }}">
                                                        <label id="areaText-error" class="error" for="areaText"></label>
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Street</label>
                                                        <input type="text" placeholder="Enter your street  " name="st_address" value="{{@$request['st_address']}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                          <label>Nearest Landmark</label>
                                                          <input type="text" placeholder="Enter your nearest landmark" name="landmark" value="{{@$request['landmark']}}" >
                                                        </div>
                                                  </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Address</label>
                                                        <input type="text" placeholder="Enter your address" name="address" value="{{@$request['address']}}">
                                                    </div>
                                                </div>
                                                <div class="bill-add">
                                                    <label class="list_checkBox">Save in address book
                                                        <input type="checkbox" name="save_in_address_book"  id="save_in_address_book" value="1" @if(@$request['save_in_address_book']) checked @endif> <span class="list_checkmark"  for="differentaddress"></span> </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(@$request['same_billing'])
                        <div class="shipping-details" id="billing_address_div" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Billing Information</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        {{-- <div class="bill-add">
                                            <label class="list_checkBox">Billing address is same as shipping address
                                                <input type="checkbox" name="text"  id="differentaddress" > <span class="list_checkmark"  for="differentaddress"></span> </label>
                                        </div> --}}

                                        <div class="different_address" >
                                            <hr class="custom-hr">
                                            <div class="input-section-check">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>First name</label>
                                                            <input type="text" placeholder="Enter your first name  " name="bfname" value="{{@$request['fname']}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Last Name</label>
                                                            <input type="text" placeholder="Enter your last name " name="blname" value="{{@$request['lname']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Phone No.</label>
                                                            <input type="tel" placeholder="Enter your Phone no." name="bphone" value="{{@$request['phone']}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Email Address</label>
                                                            <input type="email" placeholder="Enter your email address " name="bemail" value="{{@$request['email']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                      <div class="form_box_area">
                                                        <label>Country </label>
                                                        <select id="bcountry" name="bcountry">
                                                            <option value="">Select Country</option>
                                                            @foreach ($AllCountry as $country)
                                                            <option value="{{$country->id}}" {{@$request['country']==$country->id?'selected':''}} >{{@$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                              <label>State </label>
                                                              <select id="bstate" name="bstate">
                                                                  <option value="">Select State</option>
                                                                  @foreach ($state as $state1)
                                                                  <option value="{{$state1->id}}" {{@$request['state']==$state1->id?'selected':''}} >{{@$state1->name}}</option>
                                                                  @endforeach
                                                              </select>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>City</label>
                                                            {{-- <input type="tel" placeholder="Enter your city" name="bcity" value="{{@$lastOrder->billing_city}}"> </div> --}}
                                                            <select class="login-type log-select " name="bcity" id="bcity">
                                                                <option value="">Select City</option>
                                                                @if(@$city)
                                                                    @foreach (@$city as $ct)
                                                                        <option value="{{$ct->id}}" {{@$request['city']==$ct->id?'selected':''}} >{{@$ct->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <label id="city-error" class="error" for="bcity"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Post Code</label>
                                                            <input type="text" placeholder="Enter your postal code" id="bzip_code" name="bzip_code" value="{{@$request['zip_code']}}">
                                                            <label id="bzip_code-error" class="error" for="bzip_code"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4" id="areaDropDiv1" >
                                                        <div class="form_box_area">
                                                            <label>Select Area</label>
                                                            <select class="login-type log-select " name="area_drop1" id="areaDrop1">
                                                                <option value="">Select Area</option>
                                                                @if(@$areas)
                                                                    @foreach (@$areas as $area)
                                                                        <option value="{{$area->id}}" {{@$request['area_drop']==$area->id?'selected':''}} >{{@$area->area}}</option>
                                                                    @endforeach
                                                                    <option value="O">Other</option>
                                                                @endif
                                                            </select>
                                                            <label id="areaDrop-error" class="error" for="areaDrop1"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4" id="areaTextDiv1" >
                                                        <label>Area</label>
                                                        <input type="text" class="login-type" placeholder="Area" id="areaText1" name="area1" value="{{ @$request['area'] }}">
                                                        <label id="areaText-error" class="error" for="areaText1"></label>
                                                    </div>
                                                    {{-- <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>City</label>
                                                            <input type="tel" placeholder="Enter your city" name="bcity" value="{{@$request['city']}}" > </div>
                                                    </div> --}}
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Street</label>
                                                            <input type="text" placeholder="Enter your street  " name="bst_address" value="{{@$request['st_address']}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                              <label>Nearest Landmark</label>
                                                              <input type="text" placeholder="Enter your nearest landmark" name="blandmark" value="{{@$request['landmark']}}" >
                                                            </div>
                                                      </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Address</label>
                                                            <input type="text" placeholder="Enter your address" name="baddress" value="{{@$request['address']}}" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="shipping-details" id="billing_address_div" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Billing Information</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        {{-- <div class="bill-add">
                                            <label class="list_checkBox">Billing address is same as shipping address
                                                <input type="checkbox" name="text"  id="differentaddress" > <span class="list_checkmark"  for="differentaddress"></span> </label>
                                        </div> --}}

                                        <div class="different_address" >
                                            <hr class="custom-hr">
                                            <div class="input-section-check">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>First name</label>
                                                            <input type="text" placeholder="Enter your first name  " name="bfname" value="{{@$request['bfname']}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Last Name</label>
                                                            <input type="text" placeholder="Enter your last name " name="blname" value="{{@$request['blname']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Phone No.</label>
                                                            <input type="tel" placeholder="Enter your Phone no." name="bphone" value="{{@$request['bphone']}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Email Address</label>
                                                            <input type="email" placeholder="Enter your email address " name="bemail" value="{{@$request['bemail']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                      <div class="form_box_area">
                                                        <label>Country </label>
                                                        <select id="bcountry" name="bcountry">
                                                            <option value="">Select Country</option>
                                                            @foreach ($AllCountry as $country)
                                                            <option value="{{$country->id}}" {{@$request['bcountry']==$country->id?'selected':''}} >{{@$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                              <label>State </label>
                                                              <select id="bstate" name="bstate">
                                                                  <option value="">Select State</option>
                                                                  @foreach ($bstate as $state2)
                                                                  <option value="{{$state2->id}}" {{@$request['bstate']==$state2->id?'selected':''}} >{{@$state2->name}}</option>
                                                                  @endforeach
                                                              </select>
                                                        </div>
                                                      </div>
                                                      <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>City</label>
                                                            {{-- <input type="tel" placeholder="Enter your city" name="bcity" value="{{@$lastOrder->billing_city}}"> </div> --}}
                                                            <select class="login-type log-select " name="bcity" id="bcity">
                                                                <option value="">Select City</option>
                                                                @if(@$bcity)
                                                                    @foreach (@$bcity as $bct)
                                                                        <option value="{{$bct->id}}" {{@$request['bcity']==$bct->id?'selected':''}} >{{@$bct->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <label id="city-error" class="error" for="bcity"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Post Code</label>
                                                            <input type="text" placeholder="Enter your postal code" id="bzip_code" name="bzip_code" value="{{@$request['bzip_code']}}">
                                                            <label id="bzip_code-error" class="error" for="bzip_code"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4" id="areaDropDiv1" >
                                                        <div class="form_box_area">
                                                            <label>Select Area</label>
                                                            <select class="login-type log-select " name="area_drop1" id="areaDrop1">
                                                                <option value="">Select Area</option>
                                                                @if(@$bareas)
                                                                    @foreach (@$bareas as $barea)
                                                                        <option value="{{$barea->id}}" {{@$request['area_drop1']==$barea->id?'selected':''}} >{{@$barea->area}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <label id="areaDrop-error" class="error" for="areaDrop1"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4" id="areaTextDiv1" >
                                                        <label>Area</label>
                                                        <input type="text" class="login-type" placeholder="Area" id="areaText1" name="area1" value="{{ @$request['area1'] }}">
                                                        <label id="areaText-error" class="error" for="areaText1"></label>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Street</label>
                                                            <input type="text" placeholder="Enter your street  " name="bst_address" value="{{@$request['bst_address']}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                              <label>Nearest Landmark</label>
                                                              <input type="text" placeholder="Enter your nearest landmark" name="blandmark" value="{{@$request['blandmark']}}" >
                                                            </div>
                                                      </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Address</label>
                                                            <input type="text" placeholder="Enter your apt number" name="baddress" value="{{@$request['baddress']}}" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="shipping-details" style="display: none">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Payment Method</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div>
                                            <div>
                                                <div class="checkBox newcheck new-cus">
                                                    <ul>
                                                        <li>
                                                            <input type="radio" id="payment1" name="payment" value="COD" {{$request['payment']=='COD' ? 'checked':''}} >
                                                            <label for="payment1"><img src="{{ URL::to('public/frontend/images/cash.png')}}"> Cash On Delivery</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="payment2" name="payment" value="O" {{$request['payment']=='O' ? 'checked':''}}>
                                                            <label for="payment2"><img src="{{ URL::to('public/frontend/images/card.png')}}"> Online Payment</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="shipping-details">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="shipping-add">
                                        <div class="shipping-head">
                                            <h2>Payment Method</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        @if($request['payment']=='COD')
                                        <div class="shipping-body">
                                            <p class="p-0"><img src="{{ URL::to('public/frontend/images/cash.png')}}">Cash On Delivery</p>
                                        </div>
                                        @elseif($request['payment']=='O')
                                        <div class="shipping-body">
                                            <p class="p-0"><img src="{{ URL::to('public/frontend/images/card.png')}}"> Online Payment</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="shipping-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add">
                                        <div class="shipping-head">

                                            <div class="clearfix"></div>
                                        </div>
                                        <div>
                                            For more information on Return/Exchange/Refund refer to our Return/Exchange/Refund policy.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="shipping-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add">
                                        <div class="shipping-head">

                                            <div class="clearfix"></div>
                                        </div>
                                        <div>
                                            We do not give any kind of Assurance/ Guarantee / Warranty related to the Astrological impact against the item purchased/service booked/taken/paid. The same is based on one's own related devotion and belief system and. For further information, please refer to our Assurance/ Guarantee / Warranty policy.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                           <div class="col-md-6">
                            <div class="availability_check">
                                        <input id="agree_check" type="checkbox"  value="agree" name="agree_check" >
                                        <label for="agree_check">I agree <a href="{{route('terms.condition')}}" target="_blank">terms & condition</a> and <a href="{{route('privacy.policy')}}" target="_blank">Privacy Policy </a></label>
                                        <div id="error_check"></div>
                                    </div>
                                </div>

                        <div class="cart-btn-sec">


                            <button class="cartbtn">Confirm & Pay</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="moreInfoModal" tabindex="-1" role="dialog" aria-labelledby="moreInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="moreInfoModalLabel">More Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="gemstone_info"></div>
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
@include('includes.toaster')
<!---------deatils------->
 <script src="{{ URL::to('public/frontend/js/thumbelina.js')}}"></script>
 <script src="{{ URL::to('public/frontend/js/product-carousel.js')}}"></script>

<!---------input increament---------->
<script type="text/javascript">
@if(@session()->get('currency')==1)
var currencyId= '{{session()->get("currencySym")}}';
@elseif(@session()->get('currency')>=2)
var currencyId= '{{session()->get("currencySym")}}';
@endif
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
$('.shpping').click(function(){
    window.location.href="{{route('product.search')}}";
})
$('.different_address').css('display','block');
</script>
<script>
    // $('.different_address').hide();
    $('#differentaddress:checkbox').on('change', function(){
        if($(this).is(":not(:checked)")) {
            $('.different_address').slideDown();
        } else {
            $('.different_address').slideUp();
        }
    });
    $('#shiping_address').click(function(){
        $('#shiping_address_div').css('display','block')
    })
    $('#billing_address').click(function(){
        $('#billing_address_div').css('display','block')
    })





    $('#country').change(function(){
        const countryId = $(this).val();
        $('#state').html('');
        if (countryId != "") {
            $.ajax({
                url: "{{route('get.state')}}",
                method: 'POST',
                data: {
                    jsonrpc: 2.0,
                    _token: "{{ csrf_token() }}",
                    params: {
                        countryId: countryId,
                    },
                },
                dataType: 'JSON'
            })
            .done(function (response) {
                if (response.result) {
                    const res = response.result;
                    console.log(res);
                    $('#state').append('<option value="" selected>Select state</option>');
                    $.each(res, function (i, v) {
                        $('#state').append('<option value="' + v.id + '"">' + v.name + '</option>');
                    })
                }
            })
            .fail(function (error) {
                $('#state').html('<option value="" selected>Select state</option>');
            });
        } else {
            $('#state').html('<option value="" selected>Select state</option>');
        }
    });
    $('#bcountry').change(function(){
        const bcountryId = $(this).val();
        $('#bstate').html('');
        if (bcountryId != "") {
            $.ajax({
                url: "{{route('get.state')}}",
                method: 'POST',
                data: {
                    jsonrpc: 2.0,
                    _token: "{{ csrf_token() }}",
                    params: {
                        countryId: bcountryId,
                    },
                },
                dataType: 'JSON'
            })
            .done(function (response) {
                if (response.result) {
                    const res = response.result;
                    console.log(res);
                    $('#bstate').append('<option value="" selected>Select state</option>');
                    $.each(res, function (i, v) {
                        $('#bstate').append('<option value="' + v.id + '"">' + v.name + '</option>');
                    })
                }
            })
            .fail(function (error) {
                $('#bstate').html('<option value="" selected>Select state</option>');
            });
        } else {
            $('#bstate').html('<option value="" selected>Select state</option>');
        }
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
		$('.more_info').click(function(){
		var cart_id =$(this).data('id');
		$.ajax({
  			url: '{{ route('gemstone.more.info') }}',
  			type: 'get',
  			dataType: 'json',
  			data: {'cart_id':cart_id},
  		})
		.done(function(response) {
			$('#gemstone_info').html(response.html);
			$('#moreInfoModal').modal('show');
		})
		.fail(function(error) {
			console.log("error", error);
		})
		.always(function() {
			console.log("complete");
		})
	});
        $("#order_form").validate({
            rules: {
                fname:{
                    required:true,
                },
                lname:{
                    required:true,
                },
                phone:{
                    required:true,
                },
                email:{
                    required:true,
                },
                country:{
                    required:true,
                },
                state:{
                    required:true,
                },
                zip_code:{
                    required:true,
                },
                city:{
                    required:true,
                },
                st_address:{
                    required:true,
                },
                landmark:{
                    required:true,
                },

                bfname:{
                    required:true,
                },
                blname:{
                    required:true,
                },
                bphone:{
                    required:true,
                },
                bemail:{
                    required:true,
                },
                bcountry:{
                    required:true,
                },
                bstate:{
                    required:true,
                },
                bzip_code:{
                    required:true,
                },
                bcity:{
                    required:true,
                },
                bst_address:{
                    required:true,
                },
                blandmark:{
                    required:true,
                },


            },
            messages: {
                fname:{
                    required:'First name required',
                },
            },
            submitHandler:function(form){
                $('#error_check').html('');
                if($('#agree_check').prop("checked") == false)
                {
                    $('#error_check').append('<p class="error">Please accept the terms and condition before pay</p>')
                }else{

                    // $('#error_check').html('');
                    form.submit();
                }
            },
        })
    });

</script>


@endsection
