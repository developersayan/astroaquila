@extends('layouts.app')

@section('title')
<title>Check Out</title>
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
                                                <a href="{{route('gemstone.details',['slug'=>$cart->product->slug])}}">@if(@$cart->product['title']) {{@$cart->product['title']->title}} @if( @$cart->product['subtitle']) /{{@$cart->product['subtitle']->title}} @endif /{{@$cart->product->product_code}} @else {{@$cart->product->product_name}}/{{@$cart->product->product_code}} @endif</a>
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
                                            <p>Gift pack added : <span> {{session()->get('currencySym').($cart->gift_pack_price_usd*currencyConversionCustom())}}</span> </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Quantity:</span>
                                    <div class="product-quantity new-quantity">
                                        <div class="product-quantity">
                                            <div class="quantity-selectors">
                                                <button type="button" class="decrement-quantity" id="decrement-quantity{{$cart->id}}" aria-label="Subtract one"
                                                    data-direction="-1" data-id="{{$cart->id}}" data-product="{{$cart->product_id}}" @if(@$cart->quantity<=1) disabled="disabled" @endif data-type="{{$cart->cart_type}}"><span>&#8722;</span></button>

                                                <input data-min="1" data-max="0" type="text" id="quantity{{$cart->id}}" name="quantity" value="{{@$cart->quantity}}" readonly="true">

                                                <button type="button" class="increment-quantity" id="increment-quantity{{$cart->id}}" aria-label="Add one"
                                                    data-direction="1" data-id="{{$cart->id}}" data-product="{{$cart->product_id}}" @if(@$cart->quantity>=10) disabled="disabled" @endif data-type="{{$cart->cart_type}}"><span>&#43;</span></button>
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
                                <div class="cell amunt-detail cess"> <span class="hide_big">Action:</span>
                                    <p class="table-actions float-right">
                                        <a href="{{route('product.add.to.cart.delete',['id'=>$cart->id])}}" onclick="return confirm('Do you want to delete this product from cart?')" class="del-btn"><img src="{{ URL::to('public/frontend/images/del.png')}}"></a>
                                    </p>
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
                            <h4>SHIPPING CHARGES<span class="pull-right ">{{session()->get('currencySym')}} 0</span></h4>
                            <div class="total-pay">
                                <h3 >Total payable amount<span class="pull-right " id="total_amount" >{{session()->get('currencySym').$allCartData->sum('total_price_inr')}}</span></h3>
                            </div>
                            @elseif(@session()->get('currency')>=2)
                            <h4>Subtotal<span class="pull-right " id="sub_amount"> {{session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)}}</span></h4>
                            <h4>SHIPPING CHARGES<span class="pull-right ">{{session()->get('currencySym')}} 0</span></h4>
                            <div class="total-pay">
                                <h3 >Total payable amount<span class="pull-right " id="total_amount">{{session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)}}</span></h3>
                            </div>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    @if($allCartData->count()>0)
                    <form method="post" id="order_form" action="{{route('product.shopping.placed.order')}}">
                        @csrf
                        <div class="shipping-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Shipping Information</h2>
                                            @if($addressBook->count()>0)
                                            <a href="javascript:;"  id="address_book_view_open" class="pag_adress">Select address from address book <img src="{{ URL::to('public/frontend/images/address-book.png')}}"></a>
                                            <a href="javascript:;" style="display: none" id="add_new_address" class="pag_adress" > Add a new address <img src="{{ URL::to('public/frontend/images/forms-30.png')}}"></a>
                                            @endif
                                            <div class="clearfix"></div>
                                        </div>
                                        <hr class="custom-hr">
                                        @if($addressBook->count()>0)
                                        <div id="address_book_view">
                                            <div>
                                                <div class="checkBox newcheck new-cus">
                                                    <ul>
                                                        @foreach ($addressBook as $key=>$item)
                                                        <li style=" width: 100%; margin: 10px;">
                                                            <input type="radio" id="address_book_label{{$key}}" name="address_book" value="{{$item->id}}" @if($item->is_default=='Y')checked=""@endif class="address_book" disabled >
                                                            <label for="address_book_label{{$key}}">Address {{$key+1}}</label>
                                                            <p class="address_p">
                                                                <b>Name</b>  - {{@$item->fname}} {{@$item->lname}} ,
                                                                <b>Email</b>  - {{@$item->email}} ,
                                                                <b>Phone </b> - {{@$item->phone}} ,
                                                                <b>Address</b>  - {{@$item->address}} ,
                                                                <b>Country </b>  - {{@$item->countryDetails->name}} ,
                                                                <b>State </b>  - {{@$item->stateDetails->name}},
                                                                <b>City </b>  - {{@$item->cityDetails->name}} ,
                                                                <b>Street </b>  - {{@$item->street}} ,
                                                                <b>Landmark </b>  - {{@$item->landmark}} ,
                                                                <b>Post Code </b> - {{@$item->postcode}}
                                                                @if(@$item->areaDetails)
                                                                ,<b>Area</b> - {{@$item->areaDetails->area}}
                                                                @endif
                                                            </p>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="input-section-check" id="normal_address">
                                            <div class="row">
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>First name</label>
                                                        <input type="text" placeholder="Enter your first name  " name="fname" value="{{@$lastOrder->shipping_fname}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Last Name</label>
                                                        <input type="text" placeholder="Enter your last name " name="lname" value="{{@$lastOrder->shipping_lname}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Phone No.</label>
                                                        <input type="tel" placeholder="Enter your Phone no." name="phone" value="{{@$lastOrder->shipping_phone}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Email Address</label>
                                                        <input type="email" placeholder="Enter your email address " name="email" value="{{@$lastOrder->shipping_email}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                  <div class="form_box_area">
                                                    <label>Country </label>
                                                    <select id="country" name="country">
                                                        <option value="">Select Country</option>
                                                        @foreach ($AllCountry as $country)
                                                        <option value="{{$country->id}}" {{ @$lastOrder->shipping_country == $country->id ? 'selected':''}}>{{@$country->name}}</option>
                                                        @endforeach
                                                    </select>
                                                  </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                          <label>State </label>
                                                          <select id="state" name="state">
                                                              <option value="">Select State</option>
                                                              @if(@$state)
                                                                @foreach (@$state as $state1)
                                                                    <option value="{{$state1->id}}" {{@$lastOrder->shipping_state==$state1->id?'selected':''}} >{{@$state1->name}}</option>
                                                                @endforeach
                                                              @endif
                                                          </select>
                                                    </div>
                                                  </div>

                                                {{-- <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>City</label>
                                                        <input type="tel" placeholder="Enter your city" name="city" value="{{@$lastOrder->shipping_city}}"> </div>
                                                </div> --}}
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>City</label>
                                                        <select class="login-type log-select " name="city" id="city">
                                                            <option value="">Select City</option>
                                                            @if(@$city)
                                                                @foreach (@$city as $ct)
                                                                    <option value="{{$ct->id}}" {{@$lastOrder->shipping_city==$ct->id?'selected':''}} >{{@$ct->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label id="city-error" class="error" for="city"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Post Code</label>
                                                        <input type="text" placeholder="Enter your postal code" id="pincode" name="zip_code" value="{{@$lastOrder->shipping_pin_code}}">
                                                        <label id="pincode-error" class="error" for="pincode"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4" id="areaDropDiv" @if(!@$lastOrder->shipping_area)  style="display: none" @endif>
                                                    <div class="form_box_area">
                                                        <label>Select Area</label>
                                                        <select class="login-type log-select " name="area_drop" id="areaDrop">
                                                            <option value="">Select Area</option>
                                                            @if(@$areas)
                                                                @foreach (@$areas as $ar)
                                                                    <option value="{{$ar->id}}" {{@$lastOrder->shipping_area==$ar->id?'selected':''}} >{{@$ar->area}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        <label id="areaDrop-error" class="error" for="areaDrop"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4" id="areaTextDiv" style="display: none">
                                                    <div class="form_box_area">
                                                        <label>Area</label>
                                                        <input type="text" class="login-type" placeholder="Area" id="areaText" name="area" value="{{ old('area') }}">
                                                        <label id="areaText-error" class="error" for="areaText"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Street</label>
                                                        <input type="text" placeholder="Enter your street  " name="st_address" value="{{@$lastOrder->shipping_street}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Nearest Landmark</label>
                                                        <input type="text" placeholder="Enter your nearest landmark" name="landmark" value="{{@$lastOrder->shipping_landmark}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="form_box_area">
                                                        <label>Address</label>
                                                        <input type="text" placeholder="Enter your address" name="address" value="{{@$lastOrder->shipping_address}}">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="bill-add">
                                                        <label class="list_checkBox">Save in address book
                                                            <input type="checkbox" name="save_in_address_book"  id="save_in_address_book" value="1" checked > <span class="list_checkmark"  for="differentaddress"></span> </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="shipping-details">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="shipping-add back_white">
                                        <div class="shipping-head">
                                            <h2>Billing Information</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="bill-add">
                                            <label class="list_checkBox">Billing address is same as shipping address
                                                <input type="checkbox" name="same_billing"  id="differentaddress" value="1" checked> <span class="list_checkmark"  for="differentaddress"></span> </label>
                                        </div>

                                        <div class="different_address">
                                            <hr class="custom-hr">
                                            <div class="input-section-check">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>First name</label>
                                                            <input type="text" placeholder="Enter your first name  " name="bfname" value="{{@$lastOrder->billing_fname}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Last Name</label>
                                                            <input type="text" placeholder="Enter your last name " name="blname" value="{{@$lastOrder->billing_lname}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Phone No.</label>
                                                            <input type="tel" placeholder="Enter your Phone no." name="bphone" value="{{@$lastOrder->billing_phone}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Email Address</label>
                                                            <input type="email" placeholder="Enter your email address " name="bemail" value="{{@$lastOrder->billing_email}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                      <div class="form_box_area">
                                                        <label>Country </label>
                                                        <select id="bcountry" name="bcountry">
                                                            <option value="">Select Country</option>
                                                            @foreach ($AllCountry as $country)
                                                            <option value="{{$country->id}}" {{ @$lastOrder->billing_country == $country->id ? 'selected':''}}>{{@$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                              <label>State </label>
                                                              <select id="bstate" name="bstate">
                                                                  <option value="">Select State</option>
                                                                  @if(@$bstate)
                                                                  @foreach (@$bstate as $state2)
                                                                  <option value="{{$state2->id}}" {{@$lastOrder->billing_state==$state2->id?'selected':''}} >{{@$state2->name}}</option>
                                                                  @endforeach
                                                                  @endif
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
                                                                        <option value="{{$bct->id}}" {{@$lastOrder->billing_city==$bct->id?'selected':''}} >{{@$bct->name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <label id="city-error" class="error" for="bcity"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Post Code</label>
                                                            <input type="text" placeholder="Enter your postal code" id="bzip_code" name="bzip_code" value="{{@$lastOrder->billing_pin_code}}">
                                                            <label id="bzip_code-error" class="error" for="bzip_code"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4" id="areaDropDiv1" @if(!@$lastOrder->billing_area)  style="display: none" @endif>
                                                        <div class="form_box_area">
                                                            <label>Select Area</label>
                                                            <select class="login-type log-select " name="area_drop1" id="areaDrop1">
                                                                <option value="">Select Area</option>
                                                                @if(@$areas1)
                                                                    @foreach (@$areas1 as $ar1)
                                                                        <option value="{{$ar1->id}}" {{@$lastOrder->billing_area==$ar1->id?'selected':''}} >{{@$ar1->area}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <label id="areaDrop-error" class="error" for="areaDrop"></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4" id="areaTextDiv1" style="display: none">
                                                        <label>Area</label>
                                                        <input type="text" class="login-type" placeholder="Area" id="areaText1" name="area1" value="{{ old('area1') }}">
                                                        <label id="areaText-error" class="error" for="areaText1"></label>
                                                    </div>

                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Street</label>
                                                            <input type="text" placeholder="Enter your street  " name="bst_address" value="{{@$lastOrder->billing_street}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                              <label>Nearest Landmark</label>
                                                              <input type="text" placeholder="Enter your nearest landmark" name="blandmark" value="{{@$lastOrder->billing_landmark}}">
                                                            </div>
                                                      </div>
                                                    <div class="col-md-6 col-lg-4">
                                                        <div class="form_box_area">
                                                            <label>Address</label>
                                                            <input type="text" placeholder="Enter your address" name="baddress" value="{{@$lastOrder->billing_address}}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="shipping-details">
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
                                                        @if($is_cod_available=='Y')
                                                        <li>
                                                            <input type="radio" id="payment1" name="payment" value="COD" checked="">
                                                            <label for="payment1"><img src="{{ URL::to('public/frontend/images/cash.png')}}"> Cash On Delivery</label>
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <input type="radio" id="payment2" name="payment" value="O" @if($is_cod_available!='Y') checked="" @endif>
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
                                <div class="col-md-12">
                                    <div class="shipping-add back_white">
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
                                    <div class="shipping-add back_white">
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
                        <div class="cart-btn-sec">
                            <button class="cartbtn">Continue </button>
                        </div>
                    </form>
                    @else
                    <div class="cart-btn-sec">
                        <button class="cartbtn shpping">Continue Shopping</button>
                        {{-- <button class="cartbtn checkout">Secure Checkout</button> --}}
                    </div>
                    @endif
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
    $(".increment-quantity,.decrement-quantity").on("click", function(ev) {
        var id= $(this).data('id');
        var currentQty = $('#quantity'+id).val();
        // var currentQty = $('input[name="quantity"]').val();
        var qtyDirection = $(this).data("direction");
        var newQty = 0;
        if(qtyDirection == "1") {
            newQty = parseInt(currentQty) + 1;
        } else if(qtyDirection == "-1") {
            newQty = parseInt(currentQty) - 1;
        }
       // make decrement disabled at 1
       if(newQty == 1) {
          $("#decrement-quantity"+id).attr("disabled", "disabled");
       }
       if(newQty == 10) {
          $("#increment-quantity"+id).attr("disabled", "disabled");
       }
       // remove disabled attribute on subtract
       if(newQty > 1) {
          $("#decrement-quantity"+id).removeAttr("disabled");
       }
       if(newQty < 10) {
          $("#increment-quantity"+id).removeAttr("disabled");
       }
        if(newQty > 0) {
           newQty = newQty.toString();
           var productId = $(this).data('product');
           var cartId = $(this).data('id');
           var cartType = $(this).data('type');
           var quantity = newQty;
		   var reqData = {
               'jsonrpc': '2.0',
               '_token': '{{csrf_token()}}',
               'params': {
                   productId: productId,
                   quantity: quantity,
				   cart_id: cartId,
				   from_cart:1,
                }
            };
		   if(cartType=='GS')
		   {
			   $.ajax({
					url: '{{ route('gemstone.update.cart') }}',
					type: 'post',
					dataType: 'json',
					data: reqData,
				})
				.done(function(response){
					if (response.result.updated=="updated") {
						$('#unit_price'+id).html('<span class="hide_big">Unit Price: </span>'+response.result.unit_price);
						$('#total_price'+id).html('<span class="hide_big">Total:</span>'+response.result.total_price);
						$('#sub_amount').html(response.result.subtotal);
						$('#total_amount').html(response.result.total);
					}
					$('#quantity'+id).val(newQty);
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
		   }
		   else
		   {
			   $.ajax({
					url: '{{ route('product.add.to.cart') }}',
					type: 'post',
					dataType: 'json',
					data: reqData,
				})
				.done(function(response) {

					if (response.result.updated=="updated") {
						$('#unit_price'+id).html('<span class="hide_big">Unit Price: </span>'+response.result.unit_price);
						$('#total_price'+id).html('<span class="hide_big">Total:</span>'+response.result.total_price);
						$('#sub_amount').html(response.result.subtotal);
						$('#total_amount').html(response.result.total);


						// alert('Product quantity updated successfully');
					}

					$('#quantity'+id).val(newQty);
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
		   }



       } else {
        $('#quantity'+id).val("1");
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
 if(!$target.closest('.shopcutBx').length && !$target.closest('.shopcut').length && $('.shopcutBx').is(":visible")) {
     $('.shopcutBx').slideUp();
    }
})
$('.shpping').click(function(){
    window.location.href="{{route('product.search')}}";
})
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
        if($('#differentaddress').is(":checked")){
            $('.different_address').css('display','none');
        }else if($('#differentaddress').is(":not(:checked)")){
            $('.different_address').css('display','block');
        }
        $('#address_book_view').hide();
        $('#address_book_view_open').click(function(){
            $('#address_book_view').show();
            $('#normal_address').hide();
            $('.address_book').prop("disabled", false);
            $('#add_new_address').css('display','block');
            $('#address_book_view_open').css('display','none');
        });
        $('#add_new_address').click(function(){
            $('#address_book_view').hide();
            $('#normal_address').show();
            $('.address_book').prop("disabled", true);
            $('#add_new_address').css('display','none');
            $('#address_book_view_open').css('display','block');
        });
        jQuery.validator.addMethod("validate_email", function(value, element) {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }, "Please enter valid email");
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
                    number: true ,
                    minlength: 10,
                    maxlength: 10,
                },
                email:{
                    required:true,
                    email: true,
                    validate_email:true,
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
                address:{
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
                    number: true ,
                    minlength: 10,
                    maxlength: 10,
                },
                bemail:{
                    required:true,
                    email: true,
                    validate_email:true,
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
                baddress:{
                    required:true,
                },

            },
            messages: {
                fname:{
                    required:'First name required',
                },
            }
        })
    });

    $('.shpping').click(function(){
        window.location.href="{{route('product.search')}}";
    })
    $('#state').change(function(){
            const state = $(this).val();
            $('#city').html('');
            if (state != "") {
                  $.ajax({
                          url: "{{route('get.city')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  state_id: state,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.result) {
                              const res = response.result;
                              $('#city').append('<option value="" selected>Select city</option>');
                              $.each(res, function (i, v) {
                                  $('#city').append('<option value="' + v.id + '"">' + v.name + '</option>');
                              })
                          }
                      })
                      .fail(function (error) {
                          $('#city').html('<option value="" selected>Select city</option>');
                      });
              } else {
                  $('#city').html('<option value="" selected>Select state</option>');
              }
        });
        $('#pincode').change(function(){
            var pincode = $(this).val();
            var country = $('#country').val();
            var state = $('#state').val();
            var city = $('#city').val();
            $.ajax({
                url: "{{route('get.area')}}",
                method: 'POST',
                data: {
                    jsonrpc: 2.0,
                    _token: "{{ csrf_token() }}",
                    params: {
                        pincode: pincode,
                        country: country,
                        state: state,
                        city: city,
                    },
                },
                dataType: 'JSON'
            })
            .done(function (response) {
                 if (response.postcode == 1) {

                    $('#pincode-error').html('')
                    $('#pincode-error').hide();
                    //$('#areaTextDiv').hide()
                    const res = response.result;
                    var select = '';
                    select += '<option value="">Select Area</option>';
                    if(response.result.length >0){
                        $.each(res, function (i, v) {
                            select += '<option value="' + v.id + '"">' + v.area + '</option>';
                        })
                    }

                    select += '<option value="O">Other</option>';
                   $('#areaDrop').html(select);
                   $('#areaDropDiv').show()
                }else{
                    $('#pincode-error').html('This postcode not available , please try other postcode')
                    $('#pincode-error').show();
                    //$('#areaTextDiv').show()
                    $('#areaDropDiv').hide()
                    $('#pincode').val('')
                }
            })
        });
        $('#areaDrop').on('change',function(){
            var area = $(this).val();
            if(area == 'O'){
                $('#areaTextDiv').show()
            }else{
                $('#areaTextDiv').hide()
            }
        })

        $('#bstate').change(function(){
            const state = $(this).val();
            $('#bcity').html('');
            if (state != "") {
                  $.ajax({
                          url: "{{route('get.city')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  state_id: state,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.result) {
                              const res = response.result;
                              $('#bcity').append('<option value="" selected>Select city</option>');
                              $.each(res, function (i, v) {
                                  $('#bcity').append('<option value="' + v.id + '"">' + v.name + '</option>');
                              })
                          }
                      })
                      .fail(function (error) {
                          $('#bcity').html('<option value="" selected>Select city</option>');
                      });
              } else {
                  $('#bcity').html('<option value="" selected>Select state</option>');
              }
        });
        $('#bzip_code').change(function(){
            var pincode = $(this).val();
            var country = $('#bcountry').val();
            var state = $('#bstate').val();
            var city = $('#bcity').val();
            $.ajax({
                url: "{{route('get.area')}}",
                method: 'POST',
                data: {
                    jsonrpc: 2.0,
                    _token: "{{ csrf_token() }}",
                    params: {
                        pincode: pincode,
                        country: country,
                        state: state,
                        city: city,
                    },
                },
                dataType: 'JSON'
            })
            .done(function (response) {
                if (response.postcode == 1) {
                    $('#pincode-error1').html('')
                    $('#pincode-error1').hide();
                    //$('#areaTextDiv').hide()
                    const res = response.result;
                    var select = '';
                    select += '<option value="">Select Area</option>';
                    if(response.result.length >0){
                        $.each(res, function (i, v) {
                            select += '<option value="' + v.id + '"">' + v.area + '</option>';
                            //$('#areaDrop').append('<option value="' + v.id + '"">' + v.area + '</option>');
                        })
                    }
                    select += '<option value="O">Other</option>';
                   // $('#areaDrop').append('<option value="O">Other</option>');
                   $('#areaDrop1').html(select);
                   $('#areaDropDiv1').show()
                }else{
                    $('#bzip_code-error').html('This postcode not available , please try other postcode')
                    $('#bzip_code-error').show();
                    //$('#areaTextDiv').show()
                    $('#areaDropDiv1').hide()
                    $('#bzip_code').val('')
                }
            })
        });
        $('#areaDrop1').on('change',function(){
            var area = $(this).val();
            if(area == 'O'){
                $('#areaTextDiv1').show()
            }else{
                $('#areaTextDiv1').hide()
            }
        })
</script>


@endsection
