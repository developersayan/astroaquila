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
    <div class="dashboard-customer">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="cus-dashboard-right">
					<div class="view-action-div">
                <h2> My Order Details</h2>

                <ul class="view_action_icons">
				@if((@$data->status=='N' || @$data->status=='IP') && (date('Y-m-d H:i:s') < date('Y-m-d H:i:s',strtotime($data->date."+48 hours"))))
				<li><a href="{{route('customer.order.cancel',['slug'=>@$data->order_id])}}" onclick="return confirm('Do you want to Cancel this Order?')"><i class="fa fa-times" aria-hidden="true"></i></a></li>
				@endif
				@if(@$data->is_customer_review=='N' && $data->status=='D')
				<li> <a href="{{route('customer.order.review',['slug'=>@$data->order_id])}}" ><i class="fa fa-registered" aria-hidden="true"></i></a></li>
				@endif
                 </ul>
               </div>

                    </div> @include('includes.message')
                    <div class="cus-rightbody">
                        <div class="astro-dash-form">
							<div class="post-review-sec">
								<div class="u_ran">
                                    <ul>
                                       <li><span>Order No </span> <label>: {{ $data->order_id }}</label></li>
                                       <li><span>Order Date </span> <label>: {{date('d/m/Y',strtotime(@$data->date))}}</label></li>
                                       <li><span>Total Amount </span> <label>: {{@$data->currencyDetails->currency_code}} {{@$data->total_rate}}</label></li>
                                       <li><span>Payment Status </span>
                                        <label>:
                                            @if(@$data->payment_status=='I')
                                            Initiated
                                            @elseif(@$data->payment_status=='P')
                                            Paid
                                            @elseif(@$data->payment_status=="F")
                                            Failed
                                            @endif
                                        </label>
                                        </li>
                                       <li><span>Order Status </span>
                                        <label>:
                                            @if(@$data->status=='I')
                                            Incomplete
                                            @elseif(@$data->status=='N')
                                            New
                                            @elseif(@$data->status=="C")
                                            Complete
                                            @elseif(@$data->status=="CA")
                                            Cancel
                                            @elseif(@$data->status=="IP")
                                            In Progress
                                            @elseif(@$data->status=="OD")
                                            Out of Delivery
                                            @elseif(@$data->status=="D")
                                            Delivered
                                            @endif
                                        </label>
                                        </li>
                                    </ul>
                                </div>
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
								<div class="u_ran addr">
                                    <h2>Billing Details</h2>
                                    <ul>
                                       <li><span>Name </span> <label>: {{@$data->billing_fname}} {{@$data->billing_lname}}</label></li>
                                       <li><span>Email </span> <label>: {{@$data->billing_email}}</label></li>
                                       <li><span>Phone Number </span> <label>: {{@$data->billing_phone}}</label></li>
                                       <li><span>Zip Code </span><label>:{{@$data->billing_pin_code}}</label></li>
                                       <li><span>Land Mark </span> <label>: {{@$data->billing_landmark}}</label></li>
                                       <li><span>Street </span> <label>: {{@$data->billing_street}}</label></li>
                                       <li><span>Address </span> <label>: {{@$data->billing_address}}</label></li>
                                       <li><span>Country </span> <label>: {{@$data->billingCountry->name}}</label></li>
                                       <li><span>State </span> <label>: {{@$data->billingState->name}}</label></li>
                                       <li><span>City </span> <label>: {{@$data->billingCity->name}}</label></li>
                                       <li><span>Area </span><label>:{{@$data->billingArea->area}}</label></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="details-table">
                            <div class="table-cus">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">Product Image</div>
                                    <div class="cell amunt cess">Product Name</div>
                                    <div class="cell amunt cess">Product Code</div>
                                    <div class="cell amunt cess">Price</div>
                                    <div class="cell amunt cess">Quantity</div>
                                    <div class="cell amunt cess">Gift Pack</div>
                                    <div class="cell amunt cess ">Total Price</div>
                                    <div class="cell amunt cess ">Refundable</div>
                                    <div class="cell amunt cess ">Tentative date of Delivery</div>
                                </div>
                                @if(@$data->orderDetails->isNotEmpty())
                                @foreach(@$data->orderDetails as $value)
                                <div class="row small_screen2 scernexr">
								@if($value->product_type=='GS')
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Product Image :</span>
                                        <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$value->product->productdefault->image}}" style="width:65px;height: 68px">
                                    </div>
								@else
									<div class="cell amunt-detail cess"> <span class="hide_big">Product Image :</span>
                                        <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$value->product->productdefault->image}}" style="width:65px;height: 68px">
                                    </div>
								@endif
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Product Name :</span>
                                    @if($value->product_type=='GS') @if(@$value->product->title_id!="")  {{@$value->product->title->title}} @if(@$value->product->subtitle_id!="") / {{@$value->product->subtitle->title}} @endif / {{@$value->product->product_code}}  @else {{@$value->product->product_name}} / {{@$value->product->product_code}}  @endif @else {{@$value->product->product_name}} / {{@$value->product->product_code}}  @endif
                                        @if($value->product_type=='GS')
											<p><b>@if(@$value->jewellery_type=='OS') Only Stone @elseif(@$value->jewellery_type=='R') With Ring @elseif(@$value->jewellery_type=='P') With Pendant @elseif(@$value->jewellery_type=='B') With Bracelet @endif</b></p>
											<p><a href="javascript:void(0);" class="more_info" data-id="{{$value->id}}">More Info</a></p>
										@endif
                                    </div>
									<div class="cell amunt-detail cess"> <span class="hide_big">Product Code :</span>{{@$value->product->product_code}}
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Price :</span> {{@$data->currencyDetails->currency_code}} {{@$value->price}}</div>
                                    <div class="cell amunt-detail cess notranslate"> <span class="hide_big">Quentity :</span> {{@$value->quantity}}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Gift Pack :</span>
                                       {{--  @if(@$data->currency_id==1 && @$value->gift_pack_price>0)
                                        Rs {{@$value->gift_pack_price}}
                                        @elseif(@$data->currency_id==2 && @$value->gift_pack_price>0)
                                        USD {{@$value->gift_pack_price}}
                                        @else
                                        Not added
                                        @endif --}}
                                        @if( @$value->gift_pack_price>0)
                                        {{@$data->currencyDetails->currency_code}} {{@$value->gift_pack_price}}
                                        @else
                                        Not added
                                        @endif


                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Total Price :</span>{{@$data->currencyDetails->currency_code}} {{@$value->total_price}}</div>

                                    <div class="cell amunt-detail cess"> <span class="hide_big">Total Price :</span>
                                  @if(@$value->product->refundable=="Y")Yes (@if(@$value->product->refundable_status=="E")Exchange Only @elseif(@$value->product->refundable_status=="'FR") Fully Refundable @elseif(@$value->product->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif) @else No @endif
                                </div>

                                <div class="cell amunt-detail cess"> <span class="hide_big">Total Price :</span>
                                  @if(@$value->delivery_date!="")
                                   Before {{date('F j, Y', strtotime(@$value->delivery_date))}}
                                  @else
                                  --
                                  @endif
                                </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row small_screen2 scernexr" >
                                    No Product
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
                <h1>My Order Details</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
					<div class="astro-dash-form">
                        <div class="post-review-sec">
                            <div class="u_ran">
                                <ul>
                                   <li><span>Order No </span> <label>: {{ $data->order_id }}</label></li>
                                   <li><span>Order Date </span> <label>: {{date('d/m/Y',strtotime(@$data->date))}}</label></li>
                                   <li><span>Total Amount </span> <label>: {{@$data->currencyDetails->currency_code}} {{@$data->total_rate}}</label></li>
                                   <li><span>Payment Status </span>
                                    <label>:
                                        @if(@$data->payment_status=='I')
                                        Initiated
                                        @elseif(@$data->payment_status=='P')
                                        Paid
                                        @elseif(@$data->payment_status=="F")
                                        Failed
                                        @endif
                                    </label>
                                    </li>
                                   <li><span>Order Status </span>
                                    <label>:
                                        @if(@$data->status=='I')
                                        Incomplete
                                        @elseif(@$data->status=='N')
                                        New
                                        @elseif(@$data->status=="C")
                                        Complete
                                        @elseif(@$data->status=="CA")
                                        Cancel
                                        @elseif(@$data->status=="IP")
                                        In Progress
                                        @elseif(@$data->status=="OD")
                                        Out of Delivery
                                        @elseif(@$data->status=="D")
                                        Delivered
                                        @endif
                                    </label>
                                    </li>
                                </ul>
                            </div>
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
                <div class="u_ran addr">
                                    <h2>Billing Details</h2>
                                    <ul>
                                       <li><span>Name </span> <label>: {{@$data->billing_fname}} {{@$data->billing_lname}}</label></li>
                                       <li><span>Email </span> <label>: {{@$data->billing_email}}</label></li>
                                       <li><span>Phone Number </span> <label>: {{@$data->billing_phone}}</label></li>
                                       <li><span>Zip Code </span><label>:{{@$data->billing_pin_code}}</label></li>
                                       <li><span>Land Mark </span> <label>: {{@$data->billing_landmark}}</label></li>
                                       <li><span>Street </span> <label>: {{@$data->billing_street}}</label></li>
                                       <li><span>Address </span> <label>: {{@$data->billing_address}}</label></li>
                                       <li><span>Country </span> <label>: {{@$data->billingCountry->name}}</label></li>
                                       <li><span>State </span> <label>: {{@$data->billingState->name}}</label></li>
                                       <li><span>City </span> <label>: {{@$data->billingCity->name}}</label></li>
                                       <li><span>Area </span><label>:{{@$data->billingArea->area}}</label></li>
                                    </ul>
                                </div>
                        </div>
                    </div>
                    <div class="details-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">Product Image</div>
                                <div class="cell amunt cess">Product Name</div>
                                <div class="cell amunt cess">Product Code</div>
                                <div class="cell amunt cess">Price</div>
                                <div class="cell amunt cess">Quantity</div>
                                <div class="cell amunt cess">Gift Pack</div>
                                <div class="cell amunt cess ">Total Price</div>
                                <div class="cell amunt cess ">Refundable</div>
                                <div class="cell amunt cess ">Tentative date of Delivery</div>
                            </div>
                            @if(@$data->orderDetails->isNotEmpty())
                            @foreach(@$data->orderDetails as $value)
                            <div class="row small_screen2 scernexr">
                                @if($value->product_type=='GS')
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Product Image :</span>
                                        <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$value->product->productdefault->image}}" style="width:65px;height: 68px">
                                    </div>
                                    @else
                                      <div class="cell amunt-detail cess"> <span class="hide_big">Product Image :</span>
                                                            <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$value->product->productdefault->image}}" style="width:65px;height: 68px">
                                                        </div>
                                    @endif
                                <div class="cell amunt-detail cess"> <span class="hide_big">Product Name :</span>
                                  @if($value->product_type=='GS') @if(@$value->product->title_id!="")  {{@$value->product->title->title}} @if(@$value->product->subtitle_id) / {{@$value->product->subtitle->title}} @endif / {{@$value->product->product_code}}  @else {{@$value->product->product_name}} / {{@$value->product->product_code}}  @endif @else {{@$value->product->product_name}} / {{@$value->product->product_code}}  @endif
                                  <br>
                                                           @if($value->product_type=='GS')
											<p><b>@if(@$value->jewellery_type=='OS') Only Stone @elseif(@$value->jewellery_type=='R') With Ring @elseif(@$value->jewellery_type=='P') With Pendant @elseif(@$value->jewellery_type=='B') With Bracelet @endif</b></p>
											<p><a href="javascript:void(0);" class="more_info" data-id="{{$value->id}}">More Info</a></p>
										@endif
                                    {{-- @if(@$data->currency_id==1 && @$value->gift_pack_price>0)
                                    <p>Gift pack price Rs {{@$value->gift_pack_price}}</p>
                                    @elseif(@$data->currency_id==2 && @$value->gift_pack_price>0)
                                    Gift pack price USD {{@$value->gift_pack_price}}
                                    @endif --}}
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Product Code :</span>{{@$value->product->product_code}}
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Price :</span>{{@$data->currencyDetails->currency_code}} {{@$value->price}}</div>
                                <div class="cell amunt-detail cess notranslate"> <span class="hide_big">Quentity :</span> {{@$value->quantity}}</div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Gift Pack :</span>
                                   {{--  @if(@$data->currency_id==1 && @$value->gift_pack_price>0)
                                    Rs {{@$value->gift_pack_price}}
                                    @elseif(@$data->currency_id==2 && @$value->gift_pack_price>0)
                                    USD {{@$value->gift_pack_price}}
                                    @else
                                    Not added
                                    @endif --}}
                                    @if(@$value->gift_pack_price>0)
                                    {{@$data->currencyDetails->currency_code}} {{@$value->gift_pack_price}}
                                    @else
                                    Not added
                                    @endif
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Total Price :</span> {{@$data->currencyDetails->currency_code}} {{@$value->total_price}}</div>

                                <div class="cell amunt-detail cess"> <span class="hide_big">Total Price :</span>
                                  @if(@$value->product->refundable=="Y")Yes (@if(@$value->product->refundable_status=="E")Exchange Only @elseif(@$value->product->refundable_status=="'FR") Fully Refundable @elseif(@$value->product->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif) @else No @endif
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Total Price :</span>
                                  @if(@$value->delivery_date!="")
                                  Before {{date('F j, Y', strtotime(@$value->delivery_date))}}
                                  @else
                                  --
                                  @endif
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="row small_screen2 scernexr" >
                                No Product
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
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

<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $( function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker1" ).datepicker();
    });
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
<script>
    $(document).ready(function(){
		$('.more_info').click(function(){
		var order_details_id =$(this).data('id');
		$.ajax({
  			url: '{{ route('gemstone.order.more.info') }}',
  			type: 'get',
  			dataType: 'json',
  			data: {'order_details_id':order_details_id},
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
        $(".list-pagination ul li a").click(function(){
            var url = $(this).attr('href');
            var vars = [], hash;
            var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            // console.log(hash[1]);
            $('#page').val(hash[1]);
            $("#filter").submit();
            return false;
        });
        $(".search").click(function(){
            $('#page').val('');
            $("#filter").submit();
        });
    });
</script>

@endsection
