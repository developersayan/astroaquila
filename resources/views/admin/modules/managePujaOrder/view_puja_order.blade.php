@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Puja Order Details</title>
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
                        <h4 class="pull-left page-title">Puja Order Details</h4>
                        <ol class="breadcrumb pull-right">
                          <li class="active"><a href="{{route('admin.manage.puja.order')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                                <h3 class="panel-title">Puja Order Details</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <div class="about-info-p">
                                                    <strong>Order Id</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->order_id}}</p>
                                                </div>

                                                @if(@$data->pujas->puja_id!="")
                                                <div class="about-info-p">
                                                    <strong>Puja Name</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->pujas->pujaName->name}}</p>
                                                </div>
                                                @endif

                                                <div class="about-info-p">
                                                    <strong>Puja Title</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->pujas->puja_name}}</p>
                                                </div>
												
												<div class="about-info-p">
                                                    <strong>Puja Code</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->pujas->puja_code}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Puja Date</strong>
                                                    <br>
                                                    <p class="text-muted">{{date('d/m/Y',strtotime(@$data->date))}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Total Amount</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->total_rate}}</p>
                                                </div>
												
												<div class="about-info-p">
                                                    <strong>With Homam</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->is_homam=='Y') Yes @else No @endif</p>
                                                </div>
												@if(@$data->is_homam=='Y')
												<div class="about-info-p">
                                                    <strong>Homam Amount</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->homam_price}}</p>
                                                </div>
												@endif


                                                <div class="about-info-p">
                                                    <strong>With CD Recording Of Puja</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->is_cd=='Y') Yes @else No @endif</p>
                                                </div>
                                                @if(@$data->is_cd=='Y')
                                                <div class="about-info-p">
                                                    <strong>CD Recording Amount</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->cd_price}}</p>
                                                </div>
                                                @endif


                                                <div class="about-info-p">
                                                    <strong>With Live Streaming Of Puja</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->is_live_streaming=='Y') Yes @else No @endif</p>
                                                </div>
                                                
                                                @if(@$data->is_live_streaming=='Y')
                                                <div class="about-info-p">
                                                    <strong>Live Streaming Amount</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->live_streaming_price}}</p>
                                                </div>
                                                @endif

                                                 <div class="about-info-p">
                                                    <strong>With Prasad Of Puja</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->is_prasad=='Y') Yes @else No @endif</p>
                                                </div>
                                                



                                                @if(@$data->is_prasad=='Y')
                                                <div class="about-info-p">
                                                    <strong>Prasad Amount</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->prasad_price}}</p>
                                                </div>
                                                
                                                @endif

                                                @if(@$data->delivery_prasad!="" && @$data->is_prasad=='Y' && @$data->delivery_of_prasad=='Y')
                                                <div class="about-info-p">
                                                    <strong>Tentative Prasad Delivery Date </strong>
                                                    <br>
                                                    <p class="text-muted">Before {{date('F j, Y', strtotime(@$data->delivery_prasad))}}</p>
                                                </div>
                                                @endif

                                                @if( @$data->is_prasad=='Y' && @$data->delivery_of_prasad=='N')
                                                <div class="about-info-p">
                                                    <strong>Delivery Of Prasad Available </strong>
                                                    <br>
                                                    <p class="text-muted">Not Available</p>
                                                </div>
                                                @endif

                                                 @if(@$data->dakshina!=0)
                                                 <div class="about-info-p">
                                                    <strong>Dakshina Amount</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->currencyDetails->currency_code}} {{@$data->dakshina}}</p>
                                                </div>
                                                @endif


                                                 



                                                <div class="about-info-p">
                                                    <strong>Puja Type</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->puja_type}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Refundable</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->pujas->refundable=="Y")Yes @else No @endif </p>
                                                </div>

                                                 @if(@$data->pujas->refundable=="Y")
                                                 <div class="about-info-p">
                                                    <strong>Refundable Status</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$data->pujas->refundable_status=="E")Exchange Only @elseif(@$data->pujas->refundable_status=="'FR") Fully Refundable @elseif(@$data->pujas->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif </p>
                                                </div>

                                                 @endif

                                                @if(@$data->puja_type=='OFFLINE')
                                                <div class="about-info-p">
                                                    <strong>Address</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        {{@$data->p_google_address}}
                                                    </p>
                                                </div>
                                                

                                                <div class="about-info-p">
                                                    <strong>Zipcode</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        {{@$data->puja_zip}}
                                                    </p>
                                                </div>    

                                                @if(@$data->puja_landmark!="")
                                                <div class="about-info-p">
                                                    <strong>Landmark</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        {{@$data->puja_landmark}}
                                                    </p>
                                                </div>
                                                @endif

                                                @if(@$data->puja_house_no!="")
                                                <div class="about-info-p">
                                                    <strong>House/Flat No</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        {{@$data->puja_house_no}}
                                                    </p>
                                                </div>
                                                @endif

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
                                                    <strong>Puja Status</strong>
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



                                    <div class="col-md-4">
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
                                                    <strong>Pandit Email</strong>
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

                                    </div>
                                </div>

                                 @if(@$data->final_puja_link!="" && @$data->final_puja_notes!="" )
                                 <div class="col-md-12">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Puja Links And Notes</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                 @if(@$data->final_puja_link!="")
                                                <div class="about-info-p">
                                                    <strong>Final Puja Link</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                      <a href="{{@$data->final_puja_link}}"> {{@$data->final_puja_link}}</a>
                                                    </p>
                                                </div>
                                                @endif

                                                @if(@$data->final_puja_notes!="")
                                                <div class="about-info-p">
                                                    <strong>Final Puja Notes</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                       {{@$data->final_puja_notes}}
                                                    </p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif




                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Persons Name For Puja</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Name</th>
                                                                        <th>Gotra</th>
                                                                        <th>Janam Rashi</th>
                                                                        <th>Janam Nakshatra</th>
                                                                        <th>Date Of Birth</th>
                                                                        <th>Residence</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if(@$pujaNames->isNotEmpty())
                                                                    @foreach(@$pujaNames as $value)
                                                                    <tr>
                                                                        <td>{{@$value->name}}</td>

                                                                        <td>
                                                                            @if(@$value->gotra!="")
                                                                            {{@$value->gotra}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->janam_rashi_lagna!="")
                                                                            {{@$value->rashis->name}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->janama_nkshatra!="")
                                                                            {{@$value->nakshatras->name}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->dob!="")
                                                                            {{@$value->dob}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->place_of_residence !="")
                                                                            {{@$value->place_of_residence}}
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
								
								<div class="row">
                                    <div class="col-md-12">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Additinal Mantra Details</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Mantra</th>
                                                                        <th>No Of Recitals</th>
                                                                        <th>Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if(@$data->mantraDetails->isNotEmpty())
                                                                    @foreach(@$data->mantraDetails as $mantra)
                                                                    <tr>
                                                                        <td>{{@$mantra->mantra->mantra}}</td>

                                                                        <td>
																		{{@$mantra->no_of_recital}}
                                                                        </td>

                                                                        <td>
                                                                            {{@$data->currencyDetails->currency_code}} {{@$mantra->price}}
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

