<header class="header_sec">
    <div class="header_top">
        <div class="container">
            <div class="header_top_inr">
                <ul>

                   {{--  <li>
                        <select class="hedSelect" id="currency_change">
                            <option value="1" @if(@session()->get('currency')==1) selected @endif>INR</option>
                            <option value="2" @if(@session()->get('currency')==2) selected @endif>USD</option>
                        </select>
                    </li> --}}
                    {{-- new-code --}}
                    
                    @if(@session()->get('currency')>1)
                    <li>
                        <select class="hedSelect" id="currency_change">
                            <option value="2" @if(@session()->get('currency')==2) selected @endif>USD</option>
                            <option value="3" @if(@session()->get('currency')==3) selected @endif>AUD</option>
                            <option value="4" @if(@session()->get('currency')==4) selected @endif>GBP</option>
                            <option value="5" @if(@session()->get('currency')==5) selected @endif>EURO</option>
                        </select>
                    </li>
                    @endif

                    <li>
                       {{--  <select class="hedSelect" id="lang_change">
                            <option value="1" @if(@session()->get('lang')==1) selected @endif>English</option>
                            <option value="2" @if(@session()->get('lang')==2) selected @endif>Hindi</option>
                        </select> --}}
                        <div id="google_translate_element"></div>
                    </li>

                    <?php
                    $carts=(new \App\Helpers\CustomHelper)->getAllCart();
                    ?>
                    <li id="cartLi">
                        <a href="javascript:;" class="shopcut"> <img src="{{ URL::to('public/frontend/images/cuticon.png')}}" alt=""> <span class="noti notranslate">{{@$carts->count()}} </span>
                        </a><span id="cart_text_icon" class="shopcut">Cart</span>
                        <div class="shopcutBx">

                            @foreach (@$carts as $cart)
                            <div class="shopcutBx_media">
                                <div class="media">
								@if($cart->cart_type=='GS')								
									<em> <a href="javascript:;"> <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$cart->productdefault->image}}" alt="product"> </a></em>								
								@else								
									<em> <a href="javascript:;"> <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$cart->productdefault->image}}" alt="product"> </a></em>
								@endif
                                    
                                    <div class="media-body">
									@if($cart->cart_type=='GS' && @$cart->product['title'])
                                        <p><a href="javascript:;">{{@$cart->product['title']->title}}@if(@$cart->product['subtitle'])/{{@$cart->product['subtitle']->title}} @endif/{{@$cart->product->product_code}}</a></p>									
									@else
										<p><a href="javascript:;">{{@$cart->product->product_name}}/{{@$cart->product->product_code}}</a></p>
									@endif
									<p><b>Quantity</b> - {{@$cart->quantity}}</p>
                                        @if(@session()->get('currency')==1)
                                        <b>{{session()->get('currencySym')}} {{@$cart->total_price_inr}}</b>
                                        @elseif(@session()->get('currency')>=2)
                                        <b>{{session()->get('currencySym')}} {{round($cart->total_price_usd*currencyConversionCustom(),2)}}</b>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{route('product.add.to.cart.delete',['id'=>$cart->id])}}" onclick="return confirm('Do you want to delete this product from cart?')" class="closecut"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </div>
                            @endforeach

                            
                            @if(@$cart)
                            <div class="total_cut">
                                <em>Total</em>
                                @if(@session()->get('currency')==1)
                                <b>{{session()->get('currencySym')}} {{$carts->sum('total_price_inr')}}</b>
                                @elseif(@session()->get('currency')>=2)
                                <b>{{session()->get('currencySym')}}{{round($carts->sum('total_price_usd')*currencyConversionCustom(),2)}}</b>
                                @endif
                            </div>
                            <div class="cutview_btn">
                                <ul>
                                    <li><a href="{{route('product.shopping.cart')}}" class="sign_btn">View Cart</a></li>

                                    {{-- @if(Auth::user()==null)
                                    <li><a href="javascript:;" class="sign_btn login_show">Checkout</a></li>
                                    @else --}}
                                    @if(@Auth::user())
                                    <li><a href="{{route('product.shopping.check.out')}}" class="sign_btn">Checkout</a></li>
                                    @endif
                                </ul>
                            </div>
                            @else
                            <p>No Products</p>
                            @endif
                        </div>
                    </li>
                    @if(Auth::user()==null)
                    <li class="hedTopBtn">
                        <a href="{{route('register')}}" class="sign_btn">Sign Up</a>
                        <a href="{{route('login')}}" class="sign_btn log_btn">Login</a>
                    </li>
                    @endif
                    @if(Auth::user())
                    <li class="hedTopBtn new-t">
                        <div class="after_login">
                            <a href="javascript:;" class="user_llk"> <span>
                               @if(auth()->user()->profile_img!="")
                                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{auth()->user()->profile_img}}" alt="">
                                @else
                                <img src="{{asset('public/frontend/images/user-log.png')}}">
                                @endif
                            </span> <b><span>Hi, @if(strlen(Auth::user()->first_name)>5) {{substr(Auth::user()->first_name,0,5).'...'}} @else {{Auth::user()->first_name}} @endif</span><i class="fa fa-caret-down" aria-hidden="true"></i></b></a>
                            <div class="show01" style="display: none;">
                                <ul>
                                    @if(Auth::user()->user_type=='C')
                                    <li><a href="{{route('customer.dashboard')}}" @if(Request::segment(1)=="dashboard") class="active" @endif>{{__('sidebar.dashboard')}}</a></li>
                                    <li><a href="javascript:;">{{__('sidebar.wallet')}}</a></li>
                                    <li><a href="{{route('customer.profile')}}" @if(Request::segment(1)=="profile") class="active" @endif>{{__('sidebar.edit_profile')}}</a></li>
                                    <li><a href="{{route('customer.call')}}" @if(Request::segment(1)=="my-calls") class="active" @endif >My Calls</a></li>
                                    <li><a href="{{route('customer.order')}}" @if(Request::segment(1)=="my-order") class="active" @endif>{{__('sidebar.product_orders')}} </a></li>
                                    <li><a href="{{route('wishlist')}}" @if(Request::segment(1)=="wishlist") class="active" @endif> {{__('sidebar.wishlist')}}</a></li>
                                    <li><a href="{{route('customer.puja.history')}}" @if(Request::segment(1)=="puja-history") class="active" @endif>{{__('sidebar.puja_orders')}}</a></li>
                                    
                                    <li><a href="#" @if(Request::segment(1)=="my-horoscope-order") class="active" @endif>Horoscope Order</a></li>

                                    <li><a href="{{route('customer.change.password')}}" @if(Request::segment(1)=="change-password") class="active" @endif> {{__('sidebar.change_password')}}</a></li>
                                    <li><a href="{{route('logout')}}">{{__('sidebar.logout')}}</a></li>
                                    @endif
                                    @if(Auth::user()->user_type=='P')
                                    <li><a href="{{route('pundit.dashboard')}}" @if(Request::segment(2)=="dashboard") class="active" @endif>{{__('sidebar.dashboard')}}</a></li>
                                    <li><a href="javascript:;">{{__('sidebar.wallet')}}</a></li>
                                    <li><a href="{{route('pundit.profile')}}" @if(Request::segment(2)=="profile") class="active" @endif>{{__('sidebar.edit_profile')}}</a></li>
                                    <li><a href="{{route('customer.call')}}" @if(Request::segment(1)=="my-calls") class="active" @endif >My Calls</a></li>
                                    <li><a href="{{route('customer.order')}}" @if(Request::segment(1)=="my-order") class="active" @endif>{{__('sidebar.product_orders')}} </a></li>
                                    <li><a href="{{route('wishlist')}}" @if(Request::segment(1)=="wishlist") class="active" @endif> {{__('sidebar.wishlist')}}</a></li>
                                    <li><a href="{{route('customer.puja.history')}}" @if(Request::segment(1)=="puja-history") class="active" @endif>{{__('sidebar.puja_orders')}}</a></li>

                                    <li><a href="{{route('user.manage.horoscope.order')}}" @if(Request::segment(1)=="my-horoscope-order") class="active" @endif>Horoscope Order</a></li>

                                    <li><a href="{{route('pundit.change.password')}}" @if(Request::segment(2)=="change-password") class="active" @endif> {{__('sidebar.change_password')}}</a></li>
                                    <li><a href="{{route('logout')}}">{{__('sidebar.logout')}}</a></li>
                                    @endif
                                    @if(Auth::user()->user_type=='A')
                                    <li><a href="{{route('astrologer.dashboard')}}" @if(Request::segment(2)=="dashboard") class="active" @endif>{{__('sidebar.dashboard')}}</a></li>
                                    <li><a href="javascript:;">{{__('sidebar.wallet')}}</a></li>
                                    <li><a href="{{route('astrologer.profile')}}" @if(Request::segment(2)=="profile") class="active" @endif>{{__('sidebar.edit_profile')}}</a></li>
                                    <li><a href="{{route('customer.call')}}" @if(Request::segment(1)=="my-calls") class="active" @endif >My Calls</a></li>
                                    <li><a href="{{route('customer.order')}}" @if(Request::segment(1)=="my-order") class="active" @endif>{{__('sidebar.product_orders')}} </a></li>
                                    <li><a href="{{route('wishlist')}}" @if(Request::segment(1)=="wishlist") class="active" @endif> {{__('sidebar.wishlist')}}</a></li>
                                    <li><a href="{{route('customer.puja.history')}}" @if(Request::segment(1)=="puja-history") class="active" @endif>{{__('sidebar.puja_orders')}}</a></li>
                                    
                                    <li><a href="{{route('user.manage.horoscope.order')}}" @if(Request::segment(1)=="my-horoscope-order") class="active" @endif>Horoscope Order</a></li>

                                    <li><a href="{{route('astrologer.change.password')}}" @if(Request::segment(2)=="change-password") class="active" @endif> {{__('sidebar.change_password')}}</a></li>
                                    <li><a href="{{route('logout')}}">{{__('sidebar.logout')}}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="header_botom">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light nav_top">
                <a class="navbar-brand" href="{{route('home')}}"><img src="{{ URL::to('public/frontend/images/logo.png')}}" alt="logo" /></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span
                        class="icon-bar" id="navbarSupportedButton"></span> </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <!-- <ul class="mr-auto">
				  	</ul> -->
                    <ul class="navbar-nav menu_sec">
                        <li>
                            <a href="{{route('home')}}" class="home-c"><img src="{{ URL::to('public/frontend/images/home.png')}}"></a>
                        </li>
                        <li><a href="javascript:;">About us</a></li>
                       
                        <li @if(Route::is('horoscope.search') || Route::is('horoscope.details') || Route::is('horoscope.order.now')) class="actv" @endif><a href="{{route('horoscope.search')}}">Horoscope</a></li>
                        <li class="dropdown @if(Request::segment(1)=="astrologer-search") actv @endif"> <a href="{{route('astrologer.search.view')}}">Astro Talk</a>{{-- <span class="dropdown-toggle drop-arw"
                                data-toggle="dropdown"></span> --}}
                            {{-- <ul class="dropdown-menu">
                                <li><a href="javascript:;">Free vedic Remedies</a></li>
                            </ul> --}}
                        </li>
                        <li class="dropdown @if(Request::segment(1)=='gems-jwels') actv @endif" > <a href="{{route('gemstone.search')}}" >Gems & Jewels</a>{{-- <span class="dropdown-toggle drop-arw"
                                data-toggle="dropdown"></span> --}}
                            {{-- <ul class="dropdown-menu">
                                <li><a href="javascript:;">Buying guide</a></li>
                            </ul> --}}
                        </li>
                        <li @if(Request::segment(1)=="puja-search") class="actv" @endif><a href="{{route('search.pandit')}}" >Book My Puja </a></li>

                        <li  @if(Request::segment(1)=="product-search") class="actv" @endif><a href="{{route('product.search')}}" >Astro product</a></li>

                         <li><a href="{{route('aquila.wiki')}}">Aquila Wiki</a></li>
                        
                        @if(Auth::user()==null)
                        <li class="mo_view"><a href="{{route('register')}}">Sign Up</a></li>
                        <li class="mo_view"><a href="{{route('login')}}">Login</a></li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>


