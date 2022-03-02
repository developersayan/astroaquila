@extends('layouts.app')

@section('title')
<title>{{__('profile.customer_profile')}}</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection

@section('body')
<section class="pad-114">
    <div class="dashboard-customer">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="cus-dashboard-right">
                        <h2>{{__('sidebar.dashboard')}}</h2>
                    </div>
                     @include('includes.message')
                    <div class="cus-rightbody">
                        {{-- <div class="dash_info">
                            <h2>Hi, {{auth()->user()->first_name}}</h2>
                            <p>You last logged in on {{date('jS \of F, Y h:i A',strtotime(auth()->user()->last_login))}}</p>
                        </div> --}}
                        <div class="usaer-cart-sec">
                <div class="dash_info">
                            <h2>Hi, {{auth()->user()->first_name}}</h2>
                            <p>You last logged in on {{date('jS \of F, Y h:i A',strtotime(auth()->user()->last_login))}}</p>
                        </div>
                        <div class="text-center">
                        <a href="{{route('product.shopping.cart')}}" class="cart-user"> <img src="http://localhost/astroaquila/public/frontend/images/cuticon.png" alt=""> </a>
                            <p class="cart-it">Cart Items</p>
                            </div>
                        
                    </div>

                        <div class="dasbbox">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm">
                                        <div class="media">
                                            <div class="meadia-img">
                                                <img src="{{ URL::to('public/frontend/images/dash-ic1.png')}}">
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Gem Stone Purchase </h6>
                                                <p>10</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm">
                                        <div class="media">
                                            <div class="meadia-img">
                                                <img src="{{ URL::to('public/frontend/images/dash-ic2.png')}}">
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Astro Product Purchase </h6>
                                                <p>14</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm">
                                        <div class="media">
                                            <div class="meadia-img">
                                                <img src="{{ URL::to('public/frontend/images/dash-ic3.png')}}">
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Given Puja</h6>
                                                <p>18</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-12">
                                    <div class="dashboxitm">
                                        <div class="media">
                                            <div class="meadia-img">
                                                <img src="{{ URL::to('public/frontend/images/dash-ic4.png')}}">
                                            </div>
                                            <div class="meadia-body">
                                                <h6>Talk to Astrologer</h6>
                                                <p>10</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
						@if(@$last_three_orders->isNotEmpty())
						<div class="details-table">
                            <div class="tab-heading">
                                <h2>My Recent Orders</h2>
                            </div>

                            <div class="table-cus">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">Order No </div>
                                    <div class="cell amunt cess">Order Date</div>
                                    <div class="cell amunt cess">Total Amount</div>
                                    <div class="cell amunt cess">Status</div>
                                    <div class="cell amunt cess">Order Type</div>
                                    <div class="cell amunt cess actn">{{__('profile.action')}}</div>

                                </div>
                                @if(@$last_three_orders->isNotEmpty())
                                @foreach (@$last_three_orders as $order)
                                <div class="row small_screen2 scernexr">
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Order No :</span> <a href="@if($order->order_type=='P') {{route('customer.puja.history.view',['id'=>$order->order_id])}} @elseif($order->order_type=='PO') {{route('customer.order.details',['id'=>$order->order_id])}} @elseif($order->order_type=='C') {{route('customer.call.view',['id'=>$order->order_id])}} @elseif(@$order->order_type=="H") {{route('user.manage.horoscope.order.details',['id'=>@$order->order_id])}} @elseif(@$order->order_type=="A" || @$order->order_type=="C" || @$order->order_type=="V") {{route('customer.call.view',['id'=>@$order->order_id])}} @endif" target="_blank"> {{@$order->order_id}} </a></div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Order Date:</span>{{ date('m/d/Y', strtotime(@$order->date)) }}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Total Amount:</span>
                                        {{@$order->currencyDetails->currency_code}} {{round(@$order->total_rate)}}
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Status:</span>
                                        @if(@$order->status=='I')
                                            Incomplete
                                            @elseif(@$order->status=='N')
                                            New
                                            @elseif(@$order->status=="C")
                                            Complete
                                            @elseif(@$order->status=="CA")
                                            Cancel
                                            @elseif(@$order->status=="IP")
                                            In Progress
                                            @elseif(@$order->status=="D")
                                            Delivered
											@elseif(@$order->status=="A")
                                            Accepted
                                            @endif
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Order Type:</span>
                                        @if(@$order->order_type=='P')
                                        Puja
                                        @elseif(@$order->order_type=='PO')
                                        Product
                                        @elseif(@$order->order_type=='H')
                                        Horoscope
                                        @elseif(@$order->order_type=='A')
                                        Audio Call
                                        @elseif(@$order->order_type=='C')
                                        Chat
                                        @elseif(@$order->order_type=='V')
                                        Video Call
                                        @endif
                                    </div>
                                    <div class="cell amunt-detail cess"><span class="hide_big">Action:</span>
                                        <div class="add_ttrr actions-main">
                                            <a class="action-dots" href="@if($order->order_type=='P') {{route('customer.puja.history.view',['id'=>$order->order_id])}} @elseif($order->order_type=='PO') {{route('customer.order.details',['id'=>$order->order_id])}} @elseif($order->order_type=='C') {{route('customer.call.view',['id'=>$order->order_id])}} @elseif(@$order->order_type=="H") {{route('user.manage.horoscope.order.details',['id'=>@$order->order_id])}} @elseif(@$order->order_type=="A" || @$order->order_type=="C" || @$order->order_type=="V") {{route('customer.call.view',['id'=>@$order->order_id])}} @endif" target="_blank">
											<i class="fa fa-eye"></i></a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else

                                <div class="row small_screen2 scernexr" >
                                    No Order Found
                                </div>
                                @endif


                            </div>

                        </div>
						@endif
						@if(@$allOrder->isNotEmpty())
                        <div class="details-table">
                            <div class="tab-heading">
                                <h2>My Recently Product Orders</h2>
                            </div>

                            <div class="table-cus">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">Order No </div>
                                    <div class="cell amunt cess">Order Date</div>
                                    <div class="cell amunt cess">Total Amount</div>
                                    <div class="cell amunt cess">Status</div>
                                    <div class="cell amunt cess">Payment Type</div>
                                    {{-- <div class="cell amunt cess">{{__('profile.call_rate_label')}}</div>
                                    <div class="cell amunt cess">{{__('profile.order_total_label')}}</div>
                                    <div class="cell amunt cess">{{__('profile.call_status')}}</div> --}}
                                    <div class="cell amunt cess actn">{{__('profile.action')}}</div>

                                </div>
                                @if(@$allOrder->isNotEmpty())
                                @foreach (@$allOrder as $order)
                                <div class="row small_screen2 scernexr">
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Order No :</span> <a href="{{route('customer.order.details',['slug'=>@$order->order_id])}}"> {{@$order->order_id}} </a></div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Order Date:</span>{{ date('m/d/Y', strtotime(@$order->date)) }}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Total Amount:</span>
                                        {{@$order->currencyDetails->currency_code}} {{round(@$order->total_rate)}}
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Status:</span>
                                        @if(@$order->status=='I')
                                            Incomplete
                                            @elseif(@$order->status=='N')
                                            New
                                            @elseif(@$order->status=="C")
                                            Complete
                                            @elseif(@$order->status=="CA")
                                            Cancel
                                            @elseif(@$order->status=="IP")
                                            In Progress
                                            @elseif(@$order->status=="D")
                                            Delivered
                                            @endif
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Payment Type:</span>
                                        @if(@$order->payment_type=='W')
                                        {{__('profile.call_status_new')}}
                                        @elseif(@$order->payment_type=='O')
                                        Online
                                        @elseif(@$order->payment_type=='COD')
                                        Cash On Delivery
                                        @endif
                                    </div>
                                    <div class="cell amunt-detail cess"><span class="hide_big">Action:</span>
                                        <div class="add_ttrr actions-main">
                                            <a href="javascript:void(0);" class="action-dots" id="action{{@$order->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                            <div class="show-actions" id="show-{{@$order->id}}" style="display: none;">
                                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                <ul>
                                                    <li><a href="{{route('customer.order.details',['slug'=>@$order->order_id])}}">View</a></li>
                                                    @if(@$order->is_customer_review=='N' && $order->status=='D')
                                                    <li> <a href="{{route('customer.order.review',['slug'=>@$order->order_id])}}">Post Review</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else

                                <div class="row small_screen2 scernexr" >
                                    No Order Found
                                </div>
                                @endif


                            </div>
							

                        </div>
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


@section('script')
@include('includes.script')

<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
<script type="text/javascript">
    @foreach (@$allOrder as $value)

      $("#action{{$value->id}}").click(function(){
          $('.show-actions:not(#show-{{$value->id}})').slideUp();
          $("#show-{{$value->id}}").slideToggle();
      });
   @endforeach
   @foreach (@$last_three_orders as $value)

      $("#action1{{$value->id}}").click(function(){
          $('.show-actions:not(#show1-{{$value->id}})').slideUp();
          $("#show1-{{$value->id}}").slideToggle();
      });
   @endforeach
   </script>

@endsection
