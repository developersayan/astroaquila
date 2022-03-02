  @extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Pandit</title>
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
  <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    
                

                <div class="wraper container-fluid">
                    
                    <div class="row">
                      <div class="col-sm-12">
                        <h4 class="pull-left page-title">Pundit Details</h4>
                        <ol class="breadcrumb pull-right">
                          <li class="active"><a href="{{route('admin.manage.pandit')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                                    <strong>User Availability</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$user->user_availability=="Y")Yes @else No @endif</p>
                                                </div>

                                                   <div class="about-info-p">
                                                    <strong>Full Name</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$user->first_name}} {{@$user->last_name}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Pundit Code</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        @if(@$user->user_unique_code)
                                                        {{@$user->user_unique_code}}
                                                        @else
                                                        --
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Mobile</strong>
                                                    <br>
                                                    <p class="text-muted">+91 {{@$user->mobile}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Email</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$user->email}}</p>
                                                </div>
                                                 <div class="about-info-p">
                                                    <strong>Gender</strong>
                                                    <br>
                                                   @if(@$user->gender!="")
                                                    <p class="text-muted">
                                                    	@if(@$user->gender=="M")
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
                                                    <strong>Puja</strong>
                                                    <br>
                                                    @if(@$user->puja_type!="")
                                                    <p class="text-muted">
                                                    @if(@$user->puja_type=="BOTH")
                                                    Online,Offline
                                                    @elseif(@$user->puja_type=="ONLINE")
                                                    Online
                                                    @elseif(@$user->puja_type=="OFFLINE")
                                                    Offline
                                                    @endif

                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                               

                                                <div class="about-info-p">
                                                    <strong>Experience</strong>
                                                    <br>
                                                    @if(@$user->experience!="")
                                                    <p class="text-muted">
                                                    {{@$user->experience}} Years
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Country</strong>
                                                    <br>
                                                    @if(@$user->country_id!="")
                                                    <p class="text-muted">
                                                    {{@$user->countries->name}}
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>

                                                 <div class="about-info-p">
                                                    <strong>State</strong>
                                                    <br>
                                                     @if(@$user->state!="")
                                                    <p class="text-muted">{{@$user->states->name}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>City</strong>
                                                    <br>
                                                    @if(@$user->city!="")
                                                    <p class="text-muted">{{@$user->city}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>

                                            <div class="about-info-p">
                                                    <strong>Address</strong>
                                                    <br>
                                                     @if(@$user->address!="")
                                                    <p class="text-muted">{{@$user->address}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>


                                                    <div class="about-info-p">
                                                    <strong>Pincode</strong>
                                                    <br>
                                                     @if(@$user->pincode!="")
                                                    <p class="text-muted">{{@$user->pincode}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                 <div class="about-info-p">
                                                    <strong>Gst No</strong>
                                                    <br>
                                                     @if(@$user->gst_no!="")
                                                    <p class="text-muted">{{@$user->gst_no}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Profile Picture</strong>
                                                    <br>
                                                    @if(@$user->profile_img!="")
                                                    <p class="text-muted">
                                                    	<img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$user->profile_img}}" style="width: 200px;height: 200px;margin-top: 3px">
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> No Image </p>
                                                    @endif
                                                </div>

                                                  <div class="about-info-p">
                                                    <strong>Mobile Verified</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    	@if(@$user->is_mobile_verify=="Y")
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
                                                    	@if(@$user->is_email_verify=="Y")
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
                                                    	@if(@$user->status=="A")
                                                    	Active
                                                    	@elseif(@$user->status=="I")
                                                    	Inactive
                                                    	@elseif(@$user->status=="U")
                                                    	Unverified
                                                    	@endif
                                                    </p>
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- Personal-Information -->

                                        <!-- Languages -->
                                       {{--  <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Puja Name</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <ul>
                                                	@if(@$user->punditPujas->isNotEmpty())
                                                	@foreach(@$user->punditPujas as $puja)
                                                    <li>{{@$puja->pujas->puja_name}}  ₹{{@$puja->price}}</li>
                                                    @endforeach
                                                    @else
                                                    <li>No Puja Found</li>
                                                    @endif
                                                </ul>
                                            </div> 

                                        </div> --}}

                                         
                                        <!-- Languages -->

                                    </div>


                                    <div class="col-md-8">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">About Pundit </h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <p>
                                                	@if(@$user->about!="")
                                                	{{@$user->about}}
                                                	@else
                                                	No About Description Found
                                                	@endif
                                                </p>

                                                
                                            </div> 
                                        </div>
                                        <!-- Personal-Information -->

                                         <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Availability</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                @if(@$user->userAvailable->isNotEmpty())
                                                 @foreach(@$user->userAvailable as $avail)
                                                    <li>{{@$avail->day}} : {{date('H:i', strtotime($avail->from_time))}} -  {{date('H:i', strtotime(@$avail->to_time))}}</li>
                                                  @endforeach
                                                  @else
                                                 <p class="text-muted">No Data</p>
                                                 @endif
                                            </div> 
                                        </div>

                                         <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Bank Details</h3> 
                                            </div> 
                                           <div class="panel-body"> 
                                                
                                                 <p class="text-muted"></p>
                                                <li> <strong>Bank Name</strong> : &nbsp; 
                                                    @if(@$user->userAccount->bank_name!="")
                                                    {{@$user->userAccount->bank_name}}
                                                    @else
                                                    --
                                                    @endif
                                                </li>
                                                <li> <strong>A/C No</strong> :  &nbsp; 
                                                     @if(@$user->userAccount->ac_no!="")
                                                     {{@$user->userAccount->ac_no}}
                                                     @else
                                                     --
                                                     @endif
                                                </li>
                                                <li> <strong>IFSC Code</strong> :  &nbsp; 
                                                    @if(@$user->userAccount->ifsc_code!="")
                                                    {{@$user->userAccount->ifsc_code}}</li>
                                                    @else
                                                    --
                                                    @endif
                                                <li> <strong>Name of account holder</strong> :  &nbsp; 
                                                    @if(@$user->userAccount->account_holder!="")
                                                    {{@$user->userAccount->account_holder}}
                                                    @else
                                                    --
                                                    @endif
                                                </li>

                                                <li> <strong>Account Type</strong> :  &nbsp; 
                                                    @if(@$user->Ac_Type!="")
                                                    @if(@$user->Ac_Type=='S')
                                                    Savings
                                                    @else
                                                    Current
                                                    @endif
                                                    @else
                                                    --
                                                    @endif
                                                </li>
                                                
                                                 
                                            </div> 
                                        </div>
                                        

                                    </div>

                                </div>
                            


                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Puja History</h3> 
                                    </div> 
                                    <div class="panel-body"> 
                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Customer Name</th>
                                                                        <th> Puja Name</th>
                                                                        <th> Puja Code</th>
                                                                        <th> Puja Type</th>
                                                                        <th>Date</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                  @if(@$user->orderbookings->isNotEmpty())  
                                                                  @foreach(@$user->orderbookings as $orders)  
                                                                    <tr>
                                                                        <td>{{@$orders->customer->first_name}} {{@$orders->customer->last_name}}</td>
                                                                        <td>{{@$orders->pujas->puja_name}}</td>
                                                                        <td>{{@$orders->pujas->puja_code}}</td>
                                                                        <td>{{@$orders->puja_type}}</td>
                                                                        <td>{{date('Y-m-d', strtotime(@$orders->date))}}</td>
                                                                        <td>@if(@$orders->currency_id=="1")RS @else USD @endif{{@$orders->total_rate}}</td>
                                                                    </tr>
                                                                  @endforeach
                                                                  @else
                                                                  <tr><td>No Bookings</td></tr>
                                                                  @endif
                                                                </tbody>
                                                            </table>
                                                        </div>

                                    </div> 
                                </div>
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
