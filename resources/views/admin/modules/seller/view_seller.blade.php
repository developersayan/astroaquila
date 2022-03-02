@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Seller Details</title>
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
                        <h4 class="pull-left page-title">Seller Details</h4>
                        <ol class="breadcrumb pull-right">
                          <li class="active"><a href="{{route('admin.manage.seller')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                                    <strong>Name</strong>
                                                    <br>
                                                    <p class="text-muted">{{$data->name}}</p>
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
                                                    <strong>Address</strong>
                                                    <br>
                                                     @if(@$data->address!="")
                                                    <p class="text-muted">{{@$data->address}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Item</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$data->description}}</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>file</strong>
                                                    <br>
                                                    <p class="text-muted" style="margin-top: 5px;">
                                                    	@if(@$data->file!="")
						                            	<a class="btn btn-primary waves-effect waves-light" href="{{route('admin.seller.download.file',@$data->file)}}">Download</a>
						                            	@else
						                            	No File 
						                            	@endif
                                                    </p>
                                                </div>

                                            </div> 
                                        </div>
                                        <!-- Personal-Information -->

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

