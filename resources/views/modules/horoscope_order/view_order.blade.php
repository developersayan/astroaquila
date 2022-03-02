@extends('layouts.app')

@section('title')
<title>My Order Details</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
    .u_ran ul li span {
        width: auto;
        float: left;
        font-weight: bold;
    }
    .u_ran h2{
        margin-bottom: 10px;
    }
    .addr{
        width: 50%;
    }
    @media only screen and (max-width: 650px) {
        .addr{
            width: 100%;
        }
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection

@section('body')
@if(Auth::user()->user_type=='C')
<section class="pad-114">
    <div class="dashboard-customer puja_or_pg">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="cus-dashboard-right">
                        <h2>Horoscope Order</h2>
                    </div>@include('includes.message')
                    <div class="cus-rightbody">
                        <div class="astro-dash-pro-right" style="width: 100%">
							<div class="post-review-sec">
								<div class="u_ran">
                                <h1>Horoscope Order Details</h1>@include('includes.message')
								   <ul>
								   		<li><span>Order Id </span> <label> : {{@$data->order_id}}</label></li>

                                       <li><span>Horoscope Name </span> <label> : {{@$data->horoscope->name }}</label></li>

                                       <li><span>Horoscope Code </span> <label> : {{@$data->horoscope->code }}</label></li>

								   		<li><span>Name </span> <label>: {{@$data->name}}</label></li>
								   		<li><span>Order Date </span> <label>: {{date('m/d/Y', strtotime(@$data->date))}}</label></li>

									  	<li><span>Email</span> <label> : {{@$data->email}}</label></li>
										<li><span>Mobile No</span> <label> : {{@$data->phone_no}}</label></li>

										<li><span>Gender </span> <label> : @if(@$data->gender=="M")Male @elseif(@$data->gender=="F") Female @else Other @endif</label></li>

										<li><span>Know Date Of Birth ? </span> <label> : @if(@$data->no_dob=="N") Yes @else No @endif</label></li>

										@if(@$data->no_dob=="N")
										<li><span>Date Of Birth </span> <label> : {{date('d/m/Y',strtotime(@$data->dob))}}</label></li>
										@endif

										<li><span>Know Time Of Birth ? </span> <label> : @if(@$data->no_dob_time=="N") Yes @else No @endif</label></li>

                                        @if(@$data->no_dob_time=="N")
										<li><span>Time Of Birth</span> <label> : {{date('H:i a',strtotime(@$data->dob_time))}}</label></li>
                                        @endif

										<li><span>Birth Place</span> <label> : {{@$data->place}}</label></li>

										@if(@$data->country_id!="" && @$data->country_id!=0)
                                        <li><span>Country</span> <label> : {{@$data->country_horoscope->name}}</label></li>
                                        @endif

										@if(@$data->problem_question!="")
										<li><span>Problem / Question</span> <label> : {{@$data->problem_question}}</label></li>
										@endif

										{{-- <li><span>Order Date</span> <label> : {{date('d/m/Y',strtotime(@$data->date))}}</label></li> --}}
                                        @if(@$data->horoscope_delivery=="Y")
                                        <li><span>Tentative Delivery Date</span> <label> : {{date('d/m/Y',strtotime(@$data->horoscope_delivery_date))}}</label></li>
                                        @endif

										<li><span>Total Amount</span> <label> : {{@$data->currencyDetails->currency_code}} {{@$data->total_rate}}</label></li>

                                        <li><span>Refundable</span> <label> :
                                            @if(@$data->horoscope->refundable=="Y" && @$data->horoscope->refundable_status!="")Yes @else No @endif
                                        </label></li>
                                        @if(@$data->horoscope->refundable=="Y" && @$data->horoscope->refundable_status!="")
                                        <li><span>Refundable Status</span> <label> :
                                            @if(@$data->horoscope->refundable_status=="E")Exchange Only @elseif(@$data->horoscope->refundable_status=="'FR") Fully Refundable @elseif(@$data->horoscope->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif
                                        </label></li>
                                        @endif




										<li><span>Status </span> <label>:
                                            @if(@$data->status=='I')
                                            {{__('profile.puja_status_incomplete')}}
                                            @elseif(@$data->status=='N')
                                            {{__('profile.puja_status_new')}}
                                            @elseif(@$data->status=='C')
                                            {{__('profile.puja_status_complete')}}
                                            @elseif(@$data->status=='CA')
                                            {{__('profile.puja_status_cancel')}}
                                            @elseif(@$data->status=='A')
                                            Accepted
                                            @elseif(@$data->status=='IP')
                                            Inprocess
                                            @endif
                                        </label></li>

									  	<li><span>{{__('profile.payment_status')}} </span> <label>:
                                            @if(@$data->payment_status=='I')
                                            {{__('profile.payment_status_initiated')}}
                                            @elseif(@$data->payment_status=='P')
                                            {{__('profile.payment_status_paid')}}
                                            @elseif(@$data->payment_status=='F')
                                            {{__('profile.payment_status_failed')}}
                                            @endif
                                        </label></li>




								   </ul>
								</div>
                                @if(@$data->horoscope_delivery=="Y")
                                <div class="u_ran addr">
                                    <h2>Shipping Details</h2>
                                    <ul>
                                       <li><span>Name </span> <label>: {{@$data->shipping_fname}} {{@$data->shipping_lname}}</label></li>
                                       <li><span>Email </span> <label>: {{@$data->shipping_email}}</label></li>
                                       <li><span>Phone Number </span> <label>: {{@$data->shipping_phone}}</label></li>


                                       <li><span>Land Mark </span> <label>: {{@$data->shipping_landmark}}</label></li>
                                       <li><span>Street </span> <label>: {{@$data->shipping_street}}</label></li>
                                       <li><span>Address </span> <label>: {{@$data->shipping_address}}</label></li>
                                       <li><span>Country </span> <label>: {{@$data->country->name}}</label></li>
                                       <li><span>State </span> <label>: {{@$data->state->name}}</label></li>
                                       <li><span>City </span> <label>: {{@$data->city->name}}</label></li>
                                       <li><span>Zip Code </span><label>:{{@$data->shipping_pin_code}}</label></li>
                                       <li><span>Area </span><label>:{{@$data->area->area}}</label></li>
                                    </ul>
                                </div>
                                @endif
							</div>
						</div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif


@if(Auth::user()->user_type=='P'||Auth::user()->user_type=='A')
<div class="dashboard_sec dashboard_sec_education">
	<div class="container">
		<div class="dashboard_iner">
            @include('includes.profile_sidebar')
            <div class="astro-dash-pro-right">
                <h1>Horoscope Order</h1>@include('includes.message')
                <div class="post-review-sec">
                    <div class="u_ran">
                    <h1>Horoscope Order Details</h1>@include('includes.message')
                       <ul style="margin-top: 16px;">
                        <li><span>Order Id </span> <label>: {{@$data->order_id}}</label></li>

                                       <li><span>Horoscope Name </span> <label>: {{@$data->horoscope->name }}</label></li>

                                       <li><span>Horoscope Code </span> <label>: {{@$data->horoscope->code }}</label></li>

								   		<li><span>Name </span> <label>: {{@$data->name}}</label></li>
								   		{{-- <li><span>Order Date </span> <label>: {{date('m/d/Y', strtotime(@$data->date))}}</label></li> --}}

									  	<li><span>Email</span> <label> : {{@$data->email}}</label></li>
										<li><span>Mobile No</span> <label> : {{@$data->phone_no}}</label></li>

										<li><span>Gender </span> <label> : @if(@$data->gender=="M")Male @elseif(@$data->gender=="F") Female @else Other @endif</label></li>

										<li><span>Know Date Of Birth ? </span> <label> : @if(@$data->no_dob=="N") Yes @else No @endif</label></li>

										@if(@$data->no_dob=="N")
										<li><span>Date Of Birth </span> <label> : {{date('d/m/Y',strtotime(@$data->dob))}}</label></li>
										@endif

										<li><span>Know Time Of Birth ? </span> <label> : @if(@$data->no_dob_time=="N") Yes @else No @endif</label></li>

                                        @if(@$data->no_dob_time=="N")
										<li><span>Time Of Birth</span> <label> : {{date('H:i a',strtotime(@$data->dob_time))}}</label></li>
                                        @endif
										<li><span>Birth Place</span> <label> : {{@$data->place}}</label></li>
                                        @if(@$data->country_id!="" && @$data->country_id!=0)
										<li><span>Country</span> <label> : {{@$data->country_horoscope->name}}</label></li>
                                        @endif

										@if(@$data->problem_question!="")
										<li><span>Problem / Question </span> <label> : {{@$data->problem_question}}</label></li>
										@endif

										{{-- <li><span>Order Date</span> <label> : {{date('d/m/Y',strtotime(@$data->date))}}</label></li> --}}

                                        @if(@$data->horoscope_delivery=="Y")
                                        <li><span>Tentative Delivery Date</span> <label> : {{date('d/m/Y',strtotime(@$data->horoscope_delivery_date))}}</label></li>

                                        <li><span>Delivery Charges</span> <label> : {{@$data->currencyDetails->currency_code}} {{@$data->horoscope_delivery_price}}</label></li>
                                        @endif



										<li><span>Total Amount</span> <label> : {{@$data->currencyDetails->currency_code}} {{@$data->total_rate}}</label></li>

                                         <li><span>Refundable</span> <label> :
                                            @if(@$data->horoscope->refundable=="Y" && @$data->horoscope->refundable_status!="")Yes @else No @endif
                                        </label></li>
                                        @if(@$data->horoscope->refundable=="Y" && @$data->horoscope->refundable_status!="")
                                        <li><span>Refundable Status</span> <label> :
                                            @if(@$data->horoscope->refundable_status=="E")Exchange Only @elseif(@$data->horoscope->refundable_status=="'FR") Fully Refundable @elseif(@$data->horoscope->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif
                                        </label></li>
                                        @endif


										<li><span>Status </span> <label>:
                                            @if(@$data->status=='I')
                                            {{__('profile.puja_status_incomplete')}}
                                            @elseif(@$data->status=='N')
                                            {{__('profile.puja_status_new')}}
                                            @elseif(@$data->status=='C')
                                            {{__('profile.puja_status_complete')}}
                                            @elseif(@$data->status=='CA')
                                            {{__('profile.puja_status_cancel')}}
                                            @elseif(@$data->status=='A')
                                            Accepted
                                            @elseif(@$data->status=='IP')
                                            Inprocess
                                            @endif
                                        </label></li>

									  	<li><span>{{__('profile.payment_status')}} </span> <label>:
                                            @if(@$data->payment_status=='I')
                                            {{__('profile.payment_status_initiated')}}
                                            @elseif(@$data->payment_status=='P')
                                            {{__('profile.payment_status_paid')}}
                                            @elseif(@$data->payment_status=='F')
                                            {{__('profile.payment_status_failed')}}
                                            @endif
                                        </label></li>
                       </ul>
                    </div>
                    @if(@$data->horoscope_delivery=="Y")
                                <div class="u_ran addr">
                                    <h2>Shipping Details</h2>
                                    <ul>
                                       <li><span>Name </span> <label>: {{@$data->shipping_fname}} {{@$data->shipping_lname}}</label></li>
                                       <li><span>Email </span> <label>: {{@$data->shipping_email}}</label></li>
                                       <li><span>Phone Number </span> <label>: {{@$data->shipping_phone}}</label></li>


                                       <li><span>Land Mark </span> <label>: {{@$data->shipping_landmark}}</label></li>
                                       <li><span>Street </span> <label>: {{@$data->shipping_street}}</label></li>
                                       <li><span>Address </span> <label>: {{@$data->shipping_address}}</label></li>
                                       <li><span>Country </span> <label>: {{@$data->country->name}}</label></li>
                                       <li><span>State </span> <label>: {{@$data->state->name}}</label></li>
                                       <li><span>City </span> <label>: {{@$data->city->name}}</label></li>
                                       <li><span>Zip Code </span><label>:{{@$data->shipping_pin_code}}</label></li>
                                       <li><span>Area </span><label>:{{@$data->area->area}}</label></li>
                                    </ul>
                                </div>
                                @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endif

@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script>
$(document).ready(function(){
	$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });
});
</script>
@endsection
