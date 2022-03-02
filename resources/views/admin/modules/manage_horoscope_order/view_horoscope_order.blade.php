@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Horoscope Order Details</title>
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
                        <h4 class="pull-left page-title">Horoscope Order Details</h4>
                        <ol class="breadcrumb pull-right">
                          <li class="active"><a href="{{route('admin.manage.horoscope.order')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                        </ol>
                      </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">

                        <div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Horoscope Order Details</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="about-info-p">
                                                    <strong>Order Id</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->order_id}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Person Name For Hororscope</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->name}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Person's Email</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->email}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Person's Phone Number</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->phone_no}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Person's Gender</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->gender=="M")Male @elseif(@$data->gender=="F") Female @else Other @endif</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Know Date Of Birth ? </strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->no_dob=="N") Yes @else No @endif</p>
                                                </div>

                                                @if(@$data->no_dob=="N")
                                                <div class="about-info-p">
                                                    <strong>Date Of Birth</strong>
                                                    <br>
                                                    <p class="text-muted"> {{date('d/m/Y',strtotime(@$data->dob))}} </p>
                                                </div>
                                                @endif

                                                <div class="about-info-p">
                                                    <strong>Know Time Of Birth ? </strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->no_dob_time=="N") Yes @else No @endif</p>
                                                </div>

                                                @if(@$data->no_dob=="N")
                                                <div class="about-info-p">
                                                    <strong>Time Of Birth</strong>
                                                    <br>
                                                    <p class="text-muted"> {{date('H:i a',strtotime(@$data->dob_time))}} </p>
                                                </div>
                                                @endif

                                                <div class="about-info-p">
                                                    <strong>Birth Place </strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->place}}</p>
                                                </div>

                                                {{-- <div class="about-info-p">
                                                    <strong> Place Latitude </strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->place_latitude}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong> Place Longitude </strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->place_longitude}}</p>
                                                </div> --}}

                                                @if(@$data->country_id!="" && @$data->country_id!=0)
                                                <div class="about-info-p">
                                                    <strong>Country</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->country_horoscope->name}}</p>
                                                </div>
                                                @endif



                                                @if(@$data->problem_question!="")
                                                <div class="about-info-p">
                                                    <strong>Problem / Question </strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->problem_question}}</p>
                                                </div>
                                                @endif






                                                <div class="about-info-p">
                                                    <strong>Horoscope Name</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->horoscope->name}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Horoscope Code</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->horoscope->code}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Horoscope Order Date</strong>
                                                    <br>
                                                    <p class="text-muted">{{date('d/m/Y',strtotime(@$data->date))}}</p>
                                                </div>

                                                @if(@$data->horoscope_delivery=="Y")
                                                <div class="about-info-p">
                                                    <strong>Tentative Horoscope Delivery date</strong>
                                                    <br>
                                                    <p class="text-muted">{{date('d/m/Y',strtotime(@$data->horoscope_delivery_date))}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Delivery Charges</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->horoscope_delivery_price}}</p>
                                                </div>
                                                @endif

                                                <div class="about-info-p">
                                                    <strong>Total Amount</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->total_rate}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Refundable</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        @if(@$data->horoscope->refundable=="Y" && @$data->horoscope->refundable_status!="")Yes @else No @endif
                                                    </p>
                                                </div>
                                                @if(@$data->horoscope->refundable=="Y" && @$data->horoscope->refundable_status!="")
                                                 <div class="about-info-p">
                                                    <strong>Refundable Status</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        @if(@$data->horoscope->refundable_status=="E")Exchange Only @elseif(@$data->horoscope->refundable_status=="'FR") Fully Refundable @elseif(@$data->horoscope->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif
                                                    </p>
                                                </div>
                                                @endif




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
                                                        Incompleted
                                                        @elseif(@$data->status=='N')
                                                        New
                                                        @elseif(@$data->status=="C")
                                                        Completed
                                                        @elseif(@$data->status=="CA")
                                                        Cancel
                                                        @elseif(@$data->status=="A")
                                                        Accepted
                                                        @endif
                                                    </p>
                                                </div>



                                            </div>
                                        </div>
                                        <!-- Personal-Information -->

                                    </div>


                                      <div class="col-md-4">
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

                                    </div>

                @if(@$data->horoscope_delivery=="Y")
                <div class="row">
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
                </div>
                @endif





















                                <!-- Personal-Information -->
                        </div>
                    </div>
                    </div>
                </div> <!-- container -->



                </div> <!-- content -->

               @include('admin.includes.footer')
         </div>
@endsection
@section('script')
@include('admin.includes.script')
@include('includes.toaster')
@endsection

