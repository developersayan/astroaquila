@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | </title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  .edit_action li {
    display: inline-block;
    margin: 0 4px;
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
      <div class="container">

        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <h4 class="pull-left page-title">@if(@$exp)Edit @else Add @endif Experience</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.astrologer')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                    <div class="col-lg-12">
                        <div class="astro_bac_list">
                          <ul>
                            <li><a href="{{route('admin.astrologer.edit-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            Basic Info</a></li>
                            <li ><a href="{{route('admin.astrologer.edit-education-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon2.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon22.png')}}" class="bacicon2" alt="">
                            Education</a></li>
                            <li ><a href="{{route('admin.astrologer.edit-exp-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon3.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon33.png')}}" class="bacicon2" alt="">
                            Experience</a></li>
                            <li><a href="{{route('admin.astrologer.edit-avail-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Availability</a></li>
							<li class="actv"><a href="{{route('admin.astrologer.date.exclusion',['id'=>@$data->id])}}">
                                <img src="{{ URL::to('public/frontend/images/declined-white.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/declined-color.png')}}" class="bacicon2" alt="">
                                Date Exclusion List</a></li>
                          </ul>
                        </div>
                        @include('admin.includes.message')
                        <div>

                              <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"> Add Zipcode</h3>
                                    </div>
                                    <div class="panel-body rm02 rm04">
                                        <form role="form" id="exclusion_from" method="post" enctype="multipart/form-data" action="{{route('admin.astrologer.date.exclusion.insert')}}">
                                          @csrf
                                          <input type="hidden" name="user_id" value="{{@$data->id}}">

                                          <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Exclusion From Date</label>
                                                <input type="text" class="required" placeholder="Choose From Date" name="exclusion_from_date" id="exclusion_from_date" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6">
                                            <div class="form_box_area">
                                                <label>Exclusion To Date</label>
                                                <input type="text"  placeholder="Choose To Date" name="exclusion_to_date" id="exclusion_to_date" readonly>
                                            </div>
                                        </div>

                                      <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit"> Save  </button></div>
                                        </form>

                                    </div>
                                </div>
                                <!-- Personal-Information -->
                                  <div class="panel panel-default panel-fill">

                                    <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Exclusion Date</th>
                                          <th class="rm07"> Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @if(@$datelist->isNotEmpty())
                                        @foreach(@$datelist as $list)
                                        <tr>
                                          <td>{{date('m/d/Y',strtotime($list->date))}}</td>
                                          <td class="rm07">
                                              <ul class="edit_action">


                                                <li><a href="{{route('admin.astrologer.date.exclusion.delete',['id'=>$list->id])}}" onclick="return confirm('Do you want to delete this date ?')"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>

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
        <!-- End row -->

      </div>
      <!-- container -->

    </div>
    <!-- content -->

     @include('admin.includes.footer')
  </div>
  <!-- ============================================================== -->
  <!-- End Right content here -->
@endsection
@section('script')
@include('admin.includes.script')
<link rel='stylesheet' href='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css'>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
    $( "#exclusion_from_date , #exclusion_to_date" ).datepicker({
        minDate:new Date(),
        changeYear:true,
        changeMonth:true,
    });
  } );
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
        jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {
                if(value){
                    if (!/Invalid|NaN/.test(new Date(value))) {
                        return (new Date(value) >= new Date($(params).val()))
                    }


                    return isNaN(value) && isNaN($(params).val())
                    || (Number(value) >= Number($(params).val()))
                }else{
                    return true
                }


            },'Must be less than exclusion to date.');
        $("#exclusion_from").validate({
            rules:{
                exclusion_from_date:{
                    required: true
                },
                exclusion_to_date:{
                    greaterThan: "#exclusion_from_date"
                }
            }
        });
  });
</script>




@endsection
