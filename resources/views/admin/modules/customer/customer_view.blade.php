@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Customer View</title>
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
                        <h4 class="pull-left page-title">Customer Details</h4>
                        <ol class="breadcrumb pull-right">
                          <li class="active"><a href="{{route('admin.manage.customer')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                                <h3 class="panel-title">Personal Information</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <div class="about-info-p">
                                                    <strong>Full Name</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->first_name}} {{@$data->last_name}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Customer Code</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        @if(@$data->user_unique_code!="")
                                                        {{@$data->user_unique_code}}
                                                        @else
                                                        --
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Mobile</strong>
                                                    <br>
                                                    <p class="text-muted">+91 {{@$data->mobile}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Email</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->email}}</p>
                                                </div>

                                                
                                                 <div class="about-info-p">
                                                    <strong>Gender</strong>
                                                    <br>
                                                    @if(@$data->gender!="")
                                                    <p class="text-muted">
                                                    	@if(@$data->gender=="M")
                                                    	Male
                                                    	@else
                                                    	Female
                                                    	@endif
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                

                                                
                                                <div class="about-info-p">
                                                    <strong>Gotra</strong>
                                                    <br>
                                                    @if(@$data->gotra_id!="")
                                                    <p class="text-muted">{{@$data->gotra_id}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                

                                                 
                                                <div class="about-info-p">
                                                    <strong>Dob</strong>
                                                    <br>
                                                    @if(@$data->dob!="")
                                                    <p class="text-muted">{{@$data->dob}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                

                                                
                                                <div class="about-info-p">
                                                    <strong>Time Of Birth</strong>
                                                    <br>
                                                    @if(@$data->time_of_birth!="")
                                                    <p class="text-muted"> {{date('H:i ', strtotime(@$data->time_of_birth))}}</p>
                                                    @else
                                                     <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                

                                                
                                                <div class="about-info-p">
                                                    <strong>Place Of Birth</strong>
                                                    <br>
                                                    @if(@$data->place_of_birth!="")
                                                    <p class="text-muted">{{@$data->place_of_birth}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                

                                                
                                                <div class="about-info-p">
                                                    <strong>Country Name</strong>
                                                    <br>
                                                    @if(@$data->country_id!="")
                                                    <p class="text-muted">{{@$data->countries->name}}</p>
                                                    @else
                                                     <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                

                                               
                                                <div class="about-info-p">
                                                    <strong>State</strong>
                                                    <br>
                                                     @if(@$data->state!="")
                                                    <p class="text-muted">{{@$data->states->name}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                               
                                               

                                                
                                                <div class="about-info-p">
                                                    <strong>City</strong>
                                                    <br>
                                                    @if(@$data->city!="")
                                                    <p class="text-muted">{{@$data->city}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>

                                                 <div class="about-info-p">
                                                    <strong>Address</strong>
                                                    <br>
                                                     @if(@$data->address!="")
                                                    <p class="text-muted">{{@$data->address}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                  <div class="about-info-p">
                                                    <strong>Pincode</strong>
                                                    <br>
                                                     @if(@$data->pincode!="")
                                                    <p class="text-muted">{{@$data->pincode}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Gst No</strong>
                                                    <br>
                                                     @if(@$data->gst_no!="")
                                                    <p class="text-muted">{{@$data->gst_no}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Profile Picture</strong>
                                                    <br>
                                                    @if(@$data->profile_img!="")
                                                    <p class="text-muted">
                                                    	<img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$data->profile_img}}" style="width: 200px;height: 200px;margin-top: 3px">
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> No Image </p>
                                                    @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Mobile Verified</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    	@if(@$data->is_mobile_verify=="Y")
                                                    	Verified
                                                    	@else
                                                    	Not Verified
                                                    	@endif
                                                    </p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Email Verified</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    	@if(@$data->is_email_verify=="Y")
                                                    	Verified
                                                    	@else
                                                    	Not Verified
                                                    	@endif
                                                    </p>
                                                </div>

                                                 <div class="about-info-p">
                                                    <strong>Status</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    	@if(@$data->status=="A")
                                                    	Active
                                                    	@elseif(@$data->status=="I")
                                                    	Inactive
                                                    	@elseif(@$data->status=="U")
                                                    	Unverified
                                                    	@endif
                                                    </p>
                                                </div>


                                                

                                               {{--  <div class="about-info-p m-b-0">
                                                    <strong>Location</strong>
                                                    <br>
                                                    <p class="text-muted">Bagnan , Howrah , West Bengal , India</p>
                                                </div> --}}
                                            </div> 
                                        </div>
                                        <!-- Personal-Information -->

                                    </div>
                                </div>
                            

                                <!-- Personal-Information -->
                                
                                <!-- Personal-Information -->

                  


                                <!-- Personal-Information -->
                           {{--      <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Call History</h3> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Astrologer Name</th>
                                                                        <th> Date</th>
                                                                        <th>Duration</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sayanti Das</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                    </div> 
                                </div> --}}


                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Puja History</h3> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Pundit Name</th>
                                                                        <th> Puja Name </th>
                                                                        <th>Puja Type   </th>
                                                                        <th>Date</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if(@$data->customerbooking_puja->isNotEmpty())
                                                                    @foreach(@$data->customerbooking_puja as $order)
                                                                    <tr>
                                                                        <td>{{@$order->pundit->first_name}} {{@$order->pundit->last_name}}</td>
                                                                        <td>{{@$order->pujas->puja_name}}</td>
                                                                        <td>{{@$order->puja_type}}</td>
                                                                        <td>{{date('Y-m-d', strtotime(@$order->date))}}</td>
                                                                        <td>@if(@$order->currency_id=="1")RS @else USD @endif {{@$order->total_rate}}</td>
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


                                                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Call History</h3> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Astrologer Name</th>
                                                                        <th> Date </th>
                                                                        <th>Duration</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if(@$data->customerbooking_call->isNotEmpty())
                                                                    @foreach(@$data->customerbooking_call as $order)
                                                                    <tr>
                                                                        <td>{{@$order->astrologer->first_name}} {{@$order->astrologer->last_name}}</td>
                                                                        <td>{{date('Y-m-d', strtotime(@$order->date))}}</td>
                                                                        <td>{{-- {{number_format((float)round( @$order->duration / 60,4), 2, '.', '')}} --}} {{@$order->duration}}minutes</td>
                                                                       
                                                                        <td>₹{{@$order->total_rate}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                    @else
                                                                    <tr><td>No data</td></tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>

                                    </div> 
                                </div>


{{--                                 <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Product Order History</h3> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Order No.</th>
                                                                        <th>Product Name</th>
                                                                        <th> Image</th>
                                                                        <th>Quantity</th>
                                                                        <th>Order Date</th>
                                                                        <th>Delivery Date</th>
                                                                        <th>Price</th>
                                                                        <th>Status</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>ORDASW00009544</td>
                                                                        <td>Ruby stone 10X8 MM - 3.21 carats    </td>
                                                                        <td><img src="assets/images/icon2.jpg"></td>
                                                                        <td>1</td>
                                                                        <td>12/03/2021</td>
                                                                        <td>18/03/2021</td>
                                                                        <td>₹ 160.00</td>
                                                                        <td class="waitc">Out For  Deliver</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>ORDASW00009544</td>
                                                                        <td>Ruby stone 10X8 MM - 3.21 carats    </td>
                                                                        <td><img src="assets/images/icon1.jpg"></td>
                                                                        <td>1</td>
                                                                        <td>12/03/2021</td>
                                                                        <td>18/03/2021</td>
                                                                        <td>₹ 160.00</td>
                                                                        <td class="waitc">Shipped</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>ORDASW00009544</td>
                                                                        <td>Ruby stone 10X8 MM - 3.21 carats    </td>
                                                                        <td><img src="assets/images/icon2.jpg"></td>
                                                                        <td>1</td>
                                                                        <td>12/03/2021</td>
                                                                        <td>18/03/2021</td>
                                                                        <td>₹ 160.00</td>
                                                                        <td class="green">Deliverd</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>ORDASW00009544</td>
                                                                        <td>Ruby stone 10X8 MM - 3.21 carats    </td>
                                                                        <td><img src="assets/images/icon2.jpg"></td>
                                                                        <td>1</td>
                                                                        <td>12/03/2021</td>
                                                                        <td>18/03/2021</td>
                                                                        <td>₹ 160.00</td>
                                                                        <td class="green">Deliverd</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>ORDASW00009544</td>
                                                                        <td>Ruby stone 10X8 MM - 3.21 carats    </td>
                                                                        <td><img src="assets/images/icon1.jpg"></td>
                                                                        <td>1</td>
                                                                        <td>12/03/2021</td>
                                                                        <td>18/03/2021</td>
                                                                        <td>₹ 160.00</td>
                                                                        <td class="cancel">Cancelled</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>ORDASW00009544</td>
                                                                        <td>Ruby stone 10X8 MM - 3.21 carats    </td>
                                                                        <td><img src="assets/images/icon2.jpg"></td>
                                                                        <td>1</td>
                                                                        <td>12/03/2021</td>
                                                                        <td>18/03/2021</td>
                                                                        <td>₹ 160.00</td>
                                                                        <td class="green">Deliverd</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                    </div> 
                                </div> --}}
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

