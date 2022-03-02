  @extends('admin.layouts.app')


@section('title')
<title>Astroaquila | View Details Of Puja</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
    .custom_li_page{
        list-style: initial !important;
        margin-left: 25px !important;
        margin-bottom: 25px !important;
    }
</style>
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
                                                                        <div class="col-md-6">
                                        <!-- Personal-Information -->

                                        <!-- Personal-Information -->

                                        <!-- Languages -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Puja Offered By Pundit</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <ul>
                                                    @if(@$user->punditPujas->isNotEmpty())
                                                    @foreach(@$user->punditPujas as $puja)
                                                    <li class="custom_li_page">{{@$puja->pujas->puja_name}}</li>
                                                    @endforeach
                                                    @else
                                                    No Puja Found
                                                    @endif
                                                </ul>
                                            </div> 

                                        </div>

                                         
                                        <!-- Languages -->

                                    </div>



                                 <div class="col-md-6">
                                        <!-- Personal-Information -->

                                        <!-- Personal-Information -->

                                        <!-- Languages -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading"> 
                                                <h3 class="panel-title">Offline Service Area Of Pundit</h3> 
                                            </div> 
                                            <div class="panel-body"> 
                                                <ul class="custom_ul_custom">
                                                    @if($user->punditZip->isNotEmpty())
                                                     <table class="table">
                                                        <th>Country</th>
                                                        <th>Zipcode</th>
                                                         @foreach($user->punditZip as $zip)
                                                         <tr>
                                                             <td>{{@$zip->zip->countrylist->name}}</td>
                                                             <td>{{@$zip->zip->zipcode}}</td>
                                                         </tr>
                                                         @endforeach
                                                    </table>
                                                    @else
                                                     No Service Area Found
                                                     @endif
                                                   {{--  @foreach($user->punditZip as $zip)
                                                    <li class="custom_li_page">{{@$zip->zip->zipcode}}</li>
                                                    @endforeach
                                                    @else
                                                    No Service Area Found
                                                    @endif --}}
                                                </ul>
                                            </div> 

                                        </div>

                                </div>
                            





                           
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
