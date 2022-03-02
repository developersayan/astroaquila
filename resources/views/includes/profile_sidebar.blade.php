@if(Auth::user()->user_type=='C')
<div class="col-lg-3 col-md-12 col-sm-12">
    <div class="cusdashb-left">
        <div class="mobile_filter"> <i class="fa fa-bars"></i> {{__('sidebar.show_menus')}} </div>
        <div class="left-profle for_fixed_menu">
            <div class="profilbox">
                <em>
                @if(auth()->user()->profile_img!="")
                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{auth()->user()->profile_img}}" alt="">
                @else
                <img src="{{asset('public/frontend/images/user-img.jpg')}}">
                @endif
               </em>
                <strong>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</strong>
                <a href="mailto:{{auth()->user()->email}}">{{auth()->user()->email}}</a>
            </div>
            <div class="cusdasbordlink">
                <div class="cus-topmenu">
                    <ul>
                        <li>
                            <a href="{{route('customer.dashboard')}}" @if(Request::segment(1)=="dashboard") class="active" @endif> <span>
                                    <img src="{{ URL::to('public/frontend/images/dash1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/dash1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.dashboard')}} </a>
                        </li>
                        <li>
                            <a href="javascript:;"> <span>
                                    <img src="{{ URL::to('public/frontend/images/wallet1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/wallet1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.wallet')}} </a>
                        </li>
                        <li>
                            <a href="{{route('customer.profile')}}" @if(Request::segment(1)=="profile") class="active" @endif>
                                <span>
                                    <img src="{{ URL::to('public/frontend/images/edit1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/edit1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.edit_profile')}} </a>
                        </li>
                        <li>
                            <a href="{{route('customer.call')}}" @if(Request::segment(1)=="my-calls") class="active" @endif @if(Request::segment(1)=="review" && Request::segment(2)=="call") class="active" @endif> <span>
                                    <img src="{{ URL::to('public/frontend/images/call1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/call1-h.png')}}" alt="" class="dashico2">
                                </span> My Calls </a>
                        </li>
                        <li>
                            <a href="{{route('customer.order')}}" @if(Request::segment(1)=="my-order") class="active" @endif> <span>
                                    <img src="{{ URL::to('public/frontend/images/pro1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/pro1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.product_orders')}} </a>
                        </li>
                        <li>
                            <a href="{{route('wishlist')}}"  @if(Request::segment(1)=="wishlist") class="active" @endif> <span>
                                    <img src="{{ URL::to('public/frontend/images/wish1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/wish1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.wishlist')}} </a>
                        </li>
                        <li>
                            <a href="{{route('customer.puja.history')}}" @if(Request::segment(1)=="puja-history") class="active" @endif @if(Request::segment(1)=="review" && Request::segment(2)=="puja") class="active" @endif> <span>
                                    <img src="{{ URL::to('public/frontend/images/avi1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/avi1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.puja_orders')}} </a>
                        </li>

                        <li>
                            <a href="{{route('user.manage.horoscope.order')}}" @if(Request::segment(1)=="my-horoscope-order") class="active" @endif > <span>
                                    <img src="{{ URL::to('public/frontend/images/avi1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/avi1-h.png')}}" alt="" class="dashico2">
                                </span> Horoscope Order </a>
                        </li>

                        <li>
                            <a href="{{route('customer.change.password')}}" @if(Request::segment(1)=="change-password") class="active" @endif> <span>
                                    <img src="{{ URL::to('public/frontend/images/pass1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/pass1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.change_password')}} </a>
                        </li>
                    </ul>
                </div>
                <div class="cus-bottommenu">
                    <ul>
                        <li>
                            <a href="{{route('logout')}}"> <span>
                                    <img src="{{ URL::to('public/frontend/images/log1.png')}}" alt="" class="dashico1">
                                    <img src="{{ URL::to('public/frontend/images/log1-h.png')}}" alt="" class="dashico2">
                                </span> {{__('sidebar.logout')}} </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endif

@if(Auth::user()->user_type=='P')
<div class="dashboard_left">
    <div class="mobile_filter_as"> <i class="fa fa-bars" aria-hidden="true"></i>
        <p>{{__('sidebar.show_menus')}}</p>
    </div>
    <div class="dashboard_left_inr">
        <div class="dash-pro-sec">
            <em>@if(auth()->user()->profile_img!="")
                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{auth()->user()->profile_img}}" alt="">
                @else
                <img src="{{asset('public/frontend/images/user-img.jpg')}}">
                @endif</em>
            <span>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
            <ul>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star4.png')}}" alt=""></li>
                <li><strong>({{Auth::user()->tot_review}})</strong></li>
            </ul>
        </div>
        <div class="dash-pro-list">
            <ul>
                <li @if(Request::segment(2)=="dashboard") class="activ" @endif>
                    <a href="{{route('pundit.dashboard')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon1.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon11.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.dashboard')}}</em>
                    </a>
                </li>
                <li @if((Request::segment(2)=="profile" || Request::segment(2)=="availability" || Request::segment(2)=="puja" || Request::segment(2)=="puja-edit" || Request::segment(2)=="offline-service") && Request::segment(1)!="review") class="activ" @endif >
                    <a href="{{route('pundit.profile')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon2.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon22.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.edit_profile')}}</em>
                    </a>
                </li>
                {{-- <li @if(Request::segment(1)=="my-calls") class="activ" @endif @if(Request::segment(1)=="review" && Request::segment(2)=="call") class="activ" @endif>
                    <a href="{{route('customer.call')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/call1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/call1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>My Calls</em>
                    </a>
                </li>
                <li  @if(Request::segment(1)=="my-order") class="activ" @endif>
                    <a href="{{route('customer.order')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/pro1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/pro1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.product_orders')}}</em>
                    </a>
                </li>
                <li @if(Request::segment(1)=="wishlist") class="activ" @endif>
                    <a href="{{route('wishlist')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/wish1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/wish1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.wishlist')}}</em>
                    </a>
                </li> --}}
                <li @if(Request::segment(2)=="puja-history") class="activ" @endif>
                    <a href="{{route('pundit.puja.history')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon7.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon77.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.puja_history')}}</em>
                    </a>
                </li>
                {{-- <li @if(Request::segment(1)=="puja-history") class="activ" @endif @if(Request::segment(1)=="review" && Request::segment(2)=="puja") class="activ" @endif>
                    <a href="{{route('customer.puja.history')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/avi1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/avi1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.puja_orders')}} </em>
                    </a>
                </li> --}}
                <li>
                    <a href="javascript:;">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon4.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon44.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.finance')}}</em>
                    </a>
                </li>
                <li @if(Request::segment(2)=="change-password" ) class="activ" @endif>
                    <a href="{{route('pundit.change.password')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon5.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon55.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.change_password')}}</em>
                    </a>
                </li>
            </ul>
            <div class="log-astro">
                <ul>
                    <li>
                        <a href="{{route('logout')}}">
                            <span>
                                <img src="{{URL::to('public/frontend/images/dasicon6.png')}}" alt="" class="dashico1">
                                <img src="{{URL::to('public/frontend/images/dasicon66.png')}}" alt="" class="dashico2">
                            </span>
                            <em>{{__('sidebar.logout')}}</em>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endif
@if(Auth::user()->user_type=='A')
<div class="dashboard_left">
    <div class="mobile_filter_as"> <i class="fa fa-bars" aria-hidden="true"></i>
        <p>{{__('sidebar.show_menus')}}</p>
    </div>
    <div class="dashboard_left_inr">
        <div class="dash-pro-sec">
            <em>@if(auth()->user()->profile_img!="")
                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{auth()->user()->profile_img}}" alt="">
                @else
                <img src="{{asset('public/frontend/images/user-img.jpg')}}">
                @endif</em>
            <span>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</span>
            <ul>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star5.png')}}" alt=""></li>
                <li><img src="{{URL::to('public/frontend/images/star4.png')}}" alt=""></li>
                <li><strong>({{Auth::user()->tot_review}})</strong></li>
            </ul>
        </div>
        <div class="dash-pro-list">
            <ul>
                <li @if(Request::segment(2)=="dashboard" ) class="activ" @endif>
                    <a href="{{route('astrologer.dashboard')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon1.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon11.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.dashboard')}}</em>
                    </a>
                </li>
                <li @if(Request::segment(2)=="profile" || Request::segment(2)=="availability" || Request::segment(2)=="experience" || Request::segment(2)=="experience-edit"|| Request::segment(2)=="education"|| Request::segment(2)=="education-edit") class="activ" @endif>
                    <a href="{{route('astrologer.profile')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon2.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon22.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.edit_profile')}}</em>
                    </a>
                </li>
                {{-- <li @if(Request::segment(1)=="my-calls") class="activ" @endif @if(Request::segment(1)=="review" && Request::segment(2)=="call") class="activ" @endif>
                    <a href="{{route('customer.call')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/call1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/call1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>My Calls</em>
                    </a>
                </li> --}}
                <li @if(Request::segment(2)=="call-history")  class="activ" @endif>
                    <a href="{{route('astrologer.call.history')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon3.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon33.png')}}" alt="" class="dashico2">
                        </span>
                        <em>My Call History</em>
                    </a>
                </li>
                {{-- <li  @if(Request::segment(1)=="my-order") class="activ" @endif>
                    <a href="{{route('customer.order')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/pro1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/pro1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.product_orders')}}</em>
                    </a>
                </li>
                <li @if(Request::segment(1)=="wishlist") class="activ" @endif>
                    <a href="{{route('wishlist')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/wish1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/wish1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.wishlist')}}</em>
                    </a>
                </li>
                <li @if(Request::segment(1)=="puja-history") class="activ" @endif @if(Request::segment(1)=="review" && Request::segment(2)=="puja") class="activ" @endif>
                    <a href="{{route('customer.puja.history')}}">
                        <span>
                            <img src="{{ URL::to('public/frontend/images/avi1.png')}}" alt="" class="dashico1">
                            <img src="{{ URL::to('public/frontend/images/avi1-h.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.puja_orders')}} </em>
                    </a>
                </li> --}}
                <li>
                    <a @if(Request::segment(2)=="call-history")  class="activ" @endif>
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon4.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon44.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.finance')}}</em>
                    </a>
                </li>
                <li @if(Request::segment(2)=="manage-astro-tips")  class="activ" @endif>
                    <a href="{{route('manage.astro.tips')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/infos.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/bacicon1.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.astro_tips')}}</em>
                    </a>
                </li>
                <li @if(Request::segment(2)=="change-password" ) class="activ" @endif>
                    <a href="{{route('astrologer.change.password')}}">
                        <span>
                            <img src="{{URL::to('public/frontend/images/dasicon5.png')}}" alt="" class="dashico1">
                            <img src="{{URL::to('public/frontend/images/dasicon55.png')}}" alt="" class="dashico2">
                        </span>
                        <em>{{__('sidebar.change_password')}}</em>
                    </a>
                </li>
            </ul>
            <div class="log-astro">
                <ul>
                    <li>
                        <a href="{{route('logout')}}">
                            <span>
                                <img src="{{URL::to('public/frontend/images/dasicon6.png')}}" alt="" class="dashico1">
                                <img src="{{URL::to('public/frontend/images/dasicon66.png')}}" alt="" class="dashico2">
                            </span>
                            <em>{{__('sidebar.logout')}}</em>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endif
