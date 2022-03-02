@extends('layouts.app')

@section('title')
<title>Dashboard</title>
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
											<img src="{{ URL::to('public/frontend/images/astro-dash6.png')}}">
										</div>
										<div class="meadia-body">
											<h6>Total Calling Order</h6>
											<p>10</p>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="save_coniBx">
					</div>
					<div class="dasbbox">
						<div class="row">
						<div class="col-md-12 col-sm-12">
						<form method="post" action="{{route('astrologer.dashboard')}}" name="instant_avail_form" id="instant_avail_form">
						@csrf
							<div class="col-md-6 col-sm-6" id="avail_now_audio_call_div" @if(@$userData->is_audio_call=="N") style="display: none;" @endif>
								<p class="terms-para"> 
									<div class="availability_check1">
										<input id="avail_now_audio_call" type="checkbox"  value="Y" name="avail_now_audio_call" @if(@$userData->avail_now_audio_call=="Y" && strtotime(@$userData->instant_booking_expiry)>=time()) checked @endif>
										<label for="avail_now_audio_call">I am currently available for audio call</label>
									</div>
								</p>
							</div>
							<div class="col-md-6 col-sm-6" id="avail_now_video_call_div" @if(@$userData->is_video_call=="N") style="display: none;" @endif>
							<p class="terms-para"> 
								<div class="availability_check1">
									<input id="avail_now_video_call" type="checkbox"  value="Y" name="avail_now_video_call" @if(@$userData->avail_now_video_call=="Y" && strtotime(@$userData->instant_booking_expiry)>=time()) checked @endif>
									<label for="avail_now_video_call">I am currently available for video call</label>
								</div>
							</p>
							</div>
							<div class="col-md-6 col-sm-6" id="avail_now_chat_div" @if(@$userData->is_chat=="N") style="display: none;" @endif>
							<p class="terms-para"> 
								<div class="availability_check1">
									<input id="avail_now_chat" type="checkbox"  value="Y" name="avail_now_chat" @if(@$userData->avail_now_chat=="Y" && strtotime(@$userData->instant_booking_expiry)>=time()) checked @endif>
									<label for="avail_now_chat">I am currently available for chat</label>
								</div>
							</p>
							</div>
							<div class="col-md-6 col-sm-6" id="avail_now_expiry_div" @if(@$userData->is_audio_call=="Y" || @$userData->is_video_call=="Y" || @$userData->is_chat=="Y") @else style="display: none;" @endif>
								<div class="form_box_area">
									<label>Duration </label>
									<select name="instant_booking_expiry" id="instant_booking_expiry">
										<option value="">Select</option>
										@for($i=1;$i<33;$i++)

										<option value="{{$i*15}}" @if(@$userData->instant_booking_duration==$i*15) selected @endif>@if(intdiv(($i*15), 60)>0){{intdiv(($i*15), 60)}} hrs @endif @if((($i*15) % 60)>0) {{(($i*15) % 60)}} mins @endif</option>
										@endfor
									</select>
								</div>
							</div>
							@if(@$userData->instant_booking_expiry)
							<div class="col-md-12 col-sm-12" @if(@$userData->is_audio_call=="Y" || @$userData->is_video_call=="Y" || @$userData->is_chat=="Y") @else style="display: none;" @endif>
								<div class="form_box_area">
									<label style="color:#c43c13;font-weight:bold;">@if(strtotime(@$userData->instant_booking_expiry) >= time()) The instant booking availability will expire on {{date('jS F, Y h:i A',strtotime(@$userData->instant_booking_expiry))}} @endif  @if(strtotime(@$userData->instant_booking_expiry) < time()) The instant booking availability expired on {{date('jS F, Y h:i A',strtotime(@$userData->instant_booking_expiry))}} @endif </label>
								</div>
							</div>
							@endif
							<div class="col-md-12 col-sm-12" @if(@$userData->is_audio_call=="Y" || @$userData->is_video_call=="Y" || @$userData->is_chat=="Y") @else style="display: none;" @endif>
								<span class="error error_duration"></span>
							</div>
							<div class="col-md-6 col-sm-6" id="avail_now_submit" @if(@$userData->is_audio_call=="Y" || @$userData->is_video_call=="Y" || @$userData->is_chat=="Y") @else style="display: none;" @endif>
								<div class="add_btnbx">
									<input type="submit" value="Save" class="res">
								</div>
							</div>
							</form>
							</div>
						</div>
					</div>
					<div class="save_coniBx">
					</div>
					@if(@$last_three_orders->isNotEmpty())
					<div class="table_sec">
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
                                            <a href="@if($order->order_type=='P') {{route('customer.puja.history.view',['id'=>$order->order_id])}} @elseif($order->order_type=='PO') {{route('customer.order.details',['id'=>$order->order_id])}} @elseif($order->order_type=='C') {{route('customer.call.view',['id'=>$order->order_id])}} @elseif(@$order->order_type=='H') {{route('user.manage.horoscope.order.details',['id'=>@$order->order_id])}} @elseif(@$order->order_type=='A' || @$order->order_type=='C' || @$order->order_type=='V') {{route('customer.call.view',['id'=>@$order->order_id])}} @endif" target="_blank" class="action-dots"><i class="fa fa-eye"></i></a>
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
@endsection
@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
<!-- Time picek jas -->
<link rel='stylesheet' href='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css'>
<script src='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js'></script>

<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $( function() {
	$('#instant_avail_form').validate({
		submitHandler:function(form){
			if(!$('#avail_now_audio_call').is(':checked') && !$('#avail_now_video_call').is(':checked') && !$('#avail_now_chat').is(':checked'))
			{
				$('.error_duration').html('Please check at least one option.');
				return false;
			}
			if($('#instant_booking_expiry').val()!='')
			{
				if(!$('#avail_now_audio_call').is(':checked') && !$('#avail_now_video_call').is(':checked') && !$('#avail_now_chat').is(':checked'))
				{
					$('.error_duration').html('Please check at least one option.');
					return false;
				}
			}
			else
			{
				$('.error_duration').html('Please select duration.');
				return false;
			}
			form.submit();
		}
	});
	$('#avail_now_audio_call,#avail_now_video_call,#avail_now_chat').click(function(){
		if($(this).is(':checked'))
		{
			$('.error_duration').html('');
		}
	});
  });
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}

@endsection
