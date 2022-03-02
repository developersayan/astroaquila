@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Product Order Details</title>
@endsection

@section('style')
@include('admin.includes.style')
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
<!-- Left Sidebar End -->
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="wraper container-fluid">
            <div class="row">
                <div class="col-sm-12">
                  <h4 class="pull-left page-title">Product Order Details</h4>
                  <ol class="breadcrumb pull-right">
                    <li class="active"><a href="{{route('admin.manage.product.order')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                  </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div>
                        <div class="row">
                            <div class="col-md-4">

                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Order Details</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="about-info-p">
                                            <strong>Order Id</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->order_id}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Order Date</strong>
                                            <br>
                                            <p class="text-muted">{{date('d/m/Y',strtotime(@$data->date))}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Total Amount</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->total_rate}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Payment Status</strong>
                                            <br>
                                            <p class="text-muted">
                                                @if(@$data->payment_status=='I')
                                                Initiated
                                                @elseif(@$data->payment_status=='P')
                                                Paid
                                                @elseif(@$data->payment_status=="F")
                                                Failed
                                                @endif
                                            </p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Order Status</strong>
                                            <br>
                                            <p class="text-muted">
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
                                            </p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Order Account Customer Name</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->customer->first_name}} {{@$data->customer->last_name}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Order Account Customer Email</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->customer->email}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Shipping Details</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="about-info-p">
                                            <strong>Name</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->shipping_fname}} {{@$data->shipping_lname}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Email</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->shipping_email}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Phone Number</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->shipping_phone}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Land Mark</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->shipping_landmark}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Street</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->shipping_street}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Country</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->country->name}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>State</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->state->name}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>City</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->city->name}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Zip Code</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->shipping_pin_code}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Area</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->area->area}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Address</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->shipping_address}}</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Billing Details</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="about-info-p">
                                            <strong>Name</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billing_fname}} {{@$data->billing_lname}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Email</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billing_email}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Phone Number</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billing_phone}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Land Mark</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billing_landmark}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Street</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billing_street}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Country</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billingCountry->name}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>State</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billingState->name}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>City</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billingCity->name}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Zip Code</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billing_pin_code}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Area</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billingArea->area}}</p>
                                        </div>
                                        <div class="about-info-p">
                                            <strong>Address</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->billing_address}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal-Information -->

                            </div>
                            {{-- <div class="col-md-4">
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Customer Details</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="about-info-p">
                                            <strong>Customer Name</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->customer->first_name}} {{@$data->customer->last_name}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Customer Email</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->customer->email}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Phone Number</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->customer->mobile}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Address</strong>
                                            <br>
                                            @if(@$data->customer->address!="")
                                            {{@$data->customer->address}}
                                            @else
                                            --
                                            @endif
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Profile Image</strong>
                                            <br>
                                            @if(@$data->customer->profile_img!="")
                                            <p class="text-muted">
                                                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$data->customer->profile_img}}" style="width: 200px;height: 200px;margin-top: 3px">
                                            </p>
                                            @else
                                            <p class="text-muted"> No Image </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Personal-Information -->

                            </div> --}}



                            {{-- <div class="col-md-4">
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Assigned Pundit Details</h3>
                                    </div>
                                    @if(@$data->user_id!="")
                                    <div class="panel-body">
                                        <div class="about-info-p">
                                            <strong>Pundit Name</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->pundit->first_name}} {{@$data->pundit->last_name}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Customer Email</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->pundit->email}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Phone Number</strong>
                                            <br>
                                            <p class="text-muted">{{@$data->pundit->mobile}}</p>
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Address</strong>
                                            <br>
                                            @if(@$data->customer->pundit!="")
                                            {{@$data->customer->pundit}}
                                            @else
                                            --
                                            @endif
                                        </div>

                                        <div class="about-info-p">
                                            <strong>Profile Image</strong>
                                            <br>
                                            @if(@$data->pundit->profile_img!="")
                                            <p class="text-muted">
                                                <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$data->pundit->profile_img}}" style="width: 200px;height: 200px;margin-top: 3px">
                                            </p>
                                            @else
                                            <p class="text-muted"> No Image </p>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                    <div class="about-info-p">
                                            <p class="text-muted" style="margin-left: 15px;">No Pundit Assigned</p>
                                    </div>
                                    @endif
                                </div>
                                <!-- Personal-Information -->

                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Order Product Details</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Image</th>
                                                        <th>Product Title</th>
                                                        <th>Product Code</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Gift Pack</th>
                                                        <th>Total Price</th>
                                                        <th>Refundable</th>
                                                        <th>Tentative date of Delivery</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(@$data->orderDetails->isNotEmpty())
                                                    @foreach(@$data->orderDetails as $value)
                                                    <tr>
                                                        <td>
														@if(@$value->product_type=='GS')
                                                            <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$value->product->productdefault->image}}" style="width:65px;height: 68px">
														@else
															<img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$value->product->productdefault->image}}" style="width:65px;height: 68px">
														@endif
                                                        </td>
                                                        <td>
                                                         @if($value->product_type=='GS') @if(@$value->product->title_id!="")  {{@$value->product->title->title}} @if(@$value->product->subtitle_id)/ {{@$value->product->subtitle->title}} @endif / {{@$value->product->product_code}}  @else {{@$value->product->product_name}} / {{@$value->product->product_code}}  @endif @else {{@$value->product->product_name}} / {{@$value->product->product_code}}  @endif

                                                         @if(@$value->product_type=='GS')
															 <br>
														 @if(@$value->jewellery_type=='OS') Only Stone @elseif(@$value->jewellery_type=='R') With Ring @elseif(@$value->jewellery_type=='P') With Pendant @elseif(@$value->jewellery_type=='B') With Bracelet @endif
														 <br>
														 <a href="javascript:void(0);" class="more_info" data-id="{{$value->id}}">More Info</a> @endif</td>
                                                        <td>{{@$value->product->product_code}}</td>
                                                        <td>{{@$data->currencyDetails->currency_code}} {{@$value->price}}</td>
                                                        <td>{{@$value->quantity}}</td>
                                                        <td>
                                                            {{-- @if(@$data->currency_id==1 && @$value->gift_pack_price>0)
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
                                                        </td>
                                                        <td>{{@$data->currencyDetails->currency_code}} {{@$value->total_price}}</td>
                                                        <td>
                                                            @if(@$value->product->refundable=="Y")
                                                            Yes (@if(@$value->product->refundable_status=="E")Exchange Only @elseif(@$value->product->refundable_status=="'FR") Fully Refundable @elseif(@$value->product->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif)
                                                            @else
                                                            No
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(@$value->delivery_date!="")
                                                            Before {{date('F j, Y', strtotime(@$value->delivery_date))}}
                                                            @else
                                                            --
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr><td>No Data</td></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- container -->

    </div>
    <!-- content -->
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
   @include('admin.includes.footer')
</div>
@endsection
@section('script')
@include('admin.includes.script')
@include('includes.toaster')
<script>
    $(document).ready(function(){
		$('.more_info').click(function(){
		var order_details_id =$(this).data('id');
		$.ajax({
  			url: '{{ route('gemstone.admin.more.info') }}',
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
	});
	</script>
@endsection

