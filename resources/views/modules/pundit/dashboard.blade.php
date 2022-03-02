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
{{-- @include('includes.heder_profile') --}}
@include('includes.header')
@endsection

@section('body')
<div class="dashboard_sec dashboard_sec_education">
	<div class="container">
		<div class="dashboard_iner">
			@include('includes.profile_sidebar')
			<div class="astro-dash-pro-right">
				<h1>{{__('sidebar.dashboard')}}</h1>
				@include('includes.message')
				<div class="astro-dash-right_iner">
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
							<div class="col-sm-4 col-12">
								<div class="dashboxitm">
									<div class="media">
										<div class="meadia-img">
											<img src="{{ URL::to('public/frontend/images/astro-dash1.png')}}">
										</div>
										<div class="meadia-body">
											<h6>Gross Earning</h6>
											<p>5000.00</p>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-4 col-12">
								<div class="dashboxitm">
									<div class="media">
										<div class="meadia-img">
											<img src="{{ URL::to('public/frontend/images/astro-dash2.png')}}">
										</div>
										<div class="meadia-body">
											<h6>Commission</h6>
											<p>500.00</p>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-4 col-12">
								<div class="dashboxitm">
									<div class="media">
										<div class="meadia-img">
											<img src="{{ URL::to('public/frontend/images/astro-dash3.png')}}">
										</div>
										<div class="meadia-body">
											<h6>Net Earning</h6>
											<p>4500.00</p>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-4 col-12">
								<div class="dashboxitm">
									<div class="media">
										<div class="meadia-img">
											<img src="{{ URL::to('public/frontend/images/astro-dash4.png')}}">
										</div>
										<div class="meadia-body">
											<h6>Paid</h6>
											<p>3000.00</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-12">
								<div class="dashboxitm">
									<div class="media">
										<div class="meadia-img">
											<img src="{{ URL::to('public/frontend/images/astro-dash5.png')}}">
										</div>
										<div class="meadia-body">
											<h6>Wallet Balance</h6>
											<p>2000</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-4 col-12">
								<div class="dashboxitm">
									<div class="media">
										<div class="meadia-img">
											<img src="{{ URL::to('public/frontend/images/dash-ic3.png')}}">
										</div>
										<div class="meadia-body">
											<h6>Total Puja Order</h6>
											<p>10</p>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="save_coniBx">
					</div>
					@if(@$last_three_orders->isNotEmpty())
					<div class="details-table">
                            <div class="tab-heading">
                                <h2>My Recent Orders</h2>
                            </div>
					<table class="table custom_table">
						  <thead class="thead-dark">
						    <tr>
						      <th scope="col">Order No</th>
						      <th scope="col">Order Date</th>
						      <th scope="col">Total Amount</th>
						      <th scope="col">Status</th>
						      <th scope="col">Order Type</th>
						      <th scope="col">Action</th>
						    </tr>
						  </thead>
						  <tbody>
						    @if(@$last_three_orders->isNotEmpty())
						  	@foreach (@$last_three_orders as $order)
						    <tr>
						      <td><a href="@if($order->order_type=='P') {{route('customer.puja.history.view',['id'=>$order->order_id])}} @elseif($order->order_type=='PO') {{route('customer.order.details',['id'=>$order->order_id])}} @elseif($order->order_type=='C') {{route('customer.call.view',['id'=>$order->order_id])}} @elseif(@$order->order_type=="H") {{route('user.manage.horoscope.order.details',['id'=>@$order->order_id])}} @endif" target="_blank"> {{@$order->order_id}} </a></td>
						      <td>{{ date('m/d/Y', strtotime(@$order->date)) }}</td>
						      <td>{{@$order->currencyDetails->currency_code}} {{round(@$order->total_rate)}}</td>
						      <td>
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
							  </td>
						      <td>
							  @if(@$order->order_type=='P')
                                        Puja
                                        @elseif(@$order->order_type=='PO')
                                        Product
                                        @elseif(@$order->order_type=='C')
                                        Call
                                        @elseif(@$order->order_type=='H')
                                        Hororscope
                                        @endif
							  </td>
						      <td>
							       <div class="add_ttrr actions-main">
									   <a class="action-dots" href="@if($order->order_type=='P') {{route('customer.puja.history.view',['id'=>$order->order_id])}} @elseif($order->order_type=='PO') {{route('customer.order.details',['id'=>$order->order_id])}} @elseif($order->order_type=='C') {{route('customer.call.view',['id'=>$order->order_id])}} @elseif(@$order->order_type=="H") {{route('user.manage.horoscope.order.details',['id'=>@$order->order_id])}} @endif" target="_blank">
										<i class="fa fa-eye"></i></a>
                                  </div>
								</td>
						    </tr>
						    @endforeach
						    @else
						    <tr><td>No Data</td></tr>
						    @endif
						  </tbody>
						</table>
						</div>
						@endif
						@if(@$pujas->isNotEmpty())
					<div class="details-table">
                            <div class="tab-heading">
                                <h2>Puja Orders Received</h2>
                            </div>
					<table class="table custom_table">
						  <thead class="thead-dark">
						    <tr>
						      <th scope="col">{{__('profile.order_no_label')}}</th>
						      <th scope="col">{{__('profile.puja_name_label')}}</th>
						      <th scope="col">{{__('profile.customer_name_label')}}</th>
						      <th scope="col">{{__('profile.puja_date_label')}}</th>
						      <th scope="col">{{__('profile.puja_type_label')}}</th>
						      <th scope="col">{{__('profile.order_total_label')}}</th>
						      <th scope="col">{{__('profile.status_label')}}</th>
						      <th scope="col">{{__('profile.action_label')}}</th>
						    </tr>
						  </thead>
						  <tbody>
						    @if(@$pujas->isNotEmpty())
						  	@foreach(@$pujas as $puja)
						    <tr>
						      <td><a href="{{route('pundit.puja.history.view',['id'=>@$puja->order_id])}}" target="_blank"> {{@$puja->order_id}} </a></td>
						      <td>{{@$puja->pujas->puja_name}}</td>
						      <td>{{@$puja->customer->first_name}} {{@$puja->customer->last_name}}</td>
						      <td>{{date('m/d/Y', strtotime(@$puja->date))}}</td>
						      <td>{{@$puja->puja_type}}</td>
						      <td>@if(@$puja->currency_id==1)RS @else USD @endif {{@$puja->total_rate}}</td>
						      <td>
						      	@if(@$puja->status=='I')
						      	Incomplete
						      	@elseif(@$puja->status=='N')
						      	New
						      	@elseif(@$puja->status=='C')
						      	Completed
						      	@elseif(@$puja->status=='CA')
						      	Cancel
						      	@elseif(@$puja->status=='A')
						      	Accepted
						      	@elseif(@$puja->status=='IP')
						      	Inprocess
						      	@endif
							 </td>
						      <td>
							       <div class="add_ttrr actions-main">
                                                       <a href="javascript:void(0);" class="action-dots" id="action{{@$puja->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$puja->id}}" style="display: none;">
                                <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                        <ul>
                                                           <li><a href="{{route('pundit.puja.history.view',['id'=>@$puja->order_id])}}" target="_blank">View</a></li>
                                                          @if(date('m/d/Y', strtotime(@$puja->date))>=date('m/d/Y'))	
                                                          @if(@$puja->status=="N")
                                                          <li><a href="{{route('pundit.puja.accept',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to accept this puja ?')">Accept</a></li>
                                                          <li><a href="{{route('pundit.puja.reject',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to reject this puja ?')">Reject</a></li>
                                                          @endif

                                                            @if(@$puja->status=="A")
                                                          <li><a href="{{route('pundit.puja.inprocess',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to mark this puja  in process ?')">Mark as In Process</a></li>
                                                          @endif

                                                          @if(@$puja->status=="IP")
                                                          <li><a href="{{route('pundit.puja.complete',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to mark this puja as complete ?')">Mark as Complete</a></li>
                                                          @endif
                                                          @endif
                                                         </ul>
                                                      </div>
                                                    </div>
								</td>
						    </tr>
						    @endforeach
						    @else
						    <tr><td>No Data</td></tr>
						    @endif
						  </tbody>
						</table>
						</div>
						@endif

				</div>
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

<script type="text/javascript">
      @foreach (@$pujas as $puja)

    $("#action{{$puja->id}}").click(function(){
        $('.show-actions:not(#show-{{$puja->id}})').slideUp();
        $("#show-{{$puja->id}}").slideToggle();
    });
 @endforeach
</script>
{{-- @include('includes.toaster') --}}

@endsection
