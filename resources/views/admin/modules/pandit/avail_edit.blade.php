@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Pundit Availability</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
 .error {
        color: red !important;
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
            <h4 class="pull-left page-title">Edit Availability</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.pandit')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                        <div class="col-lg-12"> 
                          <div class="astro_bac_list">
                          <ul>
                            <li><a href="{{route('admin.pundit.edit-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            Basic Info</a></li>

                          <li ><a href="{{route('admin.pundit.edit-puja-view',['id'=>@$data->id])}}">
                                 <img src="{{ URL::to('public/frontend/images/bacicon5.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon55.png')}}" class="bacicon2" alt="">
                                Puja</a></li>

                           <li>
                            <a href="{{route('admin.pundit.edit-zipcode-view',['id'=>@$data->id])}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Service Area</a>
                          </li>     
                            
                            <li class="actv"><a href="{{route('admin.astrologer.edit-avail-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Availability</a></li>
                          </ul>
                        </div>
                        @include('admin.includes.message')  
                        <div> 
                           
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Edit Availability</h3> 
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                        <form role="form" id="availability_form" method="post" enctype="multipart/form-data" action="{{route('admin.pundit.update-avail')}}">
                                        	@csrf
                              <input type="hidden" name="user_id" value="{{@$data->id}}">              
                              <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day1" type="checkbox" value="MONDAY" name="day1" @if(@$monday) checked @endif>
                                        
                                        <label for="day1">Monday</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="from_time_day1"
                                                        value="{{@$monday?date('H:i',strtotime(@$monday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="to_time_day1"
                                                        value="{{ @$monday? date('H:i',strtotime(@$monday->to_time)): '' }}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day2" type="checkbox" value="TUESDAY" name="day2" @if(@$tuesday) checked @endif>
                                        <label for="day2">{{__('profile.tuesday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="from_time_day2"
                                                        value="{{@$tuesday?date('H:i',strtotime(@$tuesday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="to_time_day2"
                                                        value="{{@$tuesday?date('H:i',strtotime(@$tuesday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day3" type="checkbox" value="WEDNESDAY" name="day3" @if(@$wednesday) checked @endif>
                                        <label for="day3">{{__('profile.wednesday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="from_time_day3"
                                                        value="{{@$wednesday?date('H:i',strtotime(@$wednesday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="to_time_day3"
                                                        value="{{@$wednesday?date('H:i',strtotime(@$wednesday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day4" type="checkbox" value="THURSDAY" name="day4" @if(@$thursday) checked @endif>
                                        <label for="day4">{{__('profile.thursday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="from_time_day4"
                                                        value="{{@$thursday?date('H:i',strtotime(@$thursday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="to_time_day4"
                                                        value="{{@$thursday?date('H:i',strtotime(@$thursday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day5" type="checkbox" value="FRIDAY" name="day5" @if(@$friday) checked @endif>
                                        <label for="day5">{{__('profile.friday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="from_time_day5"
                                                        value="{{@$friday?date('H:i',strtotime(@$friday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="to_time_day5"
                                                        value="{{@$friday?date('H:i',strtotime(@$friday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day6" type="checkbox" value="SATURDAY" name="day6" @if(@$saturday) checked @endif>
                                        <label for="day6">{{__('profile.saturday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="from_time_day6"
                                                        value="{{@$saturday?date('H:i',strtotime(@$saturday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="to_time_day6"
                                                        value="{{@$saturday?date('H:i',strtotime(@$saturday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day7" type="checkbox" value="SUNDAY" name="day7" @if(@$sunday) checked @endif>
                                        <label for="day7">{{__('profile.sunday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>From Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="from_time_day7"
                                                        value="{{@$sunday?date('H:i',strtotime(@$sunday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>To Time</label>
                                                    <input type="text" placeholder="Time"
                                                        class="position-relative" name="to_time_day7"
                                                        value="{{@$sunday?date('H:i',strtotime(@$sunday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                                             

                                            
                                           
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                                        </form>

                                    </div> 
                                </div>
                                <!-- Personal-Information -->
                           
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
<!-- Time picek jas -->
<link rel='stylesheet' href='{{ URL::to('public/frontend/css/jquery-clockpicker.min.css')}}'>

<script>
    $("input[name=to_time_day1],input[name=to_time_day2],input[name=to_time_day3],input[name=to_time_day4],input[name=to_time_day5],input[name=to_time_day6],input[name=to_time_day7]").clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    default: 'now',
    donetext: "Select",
    init: function() {
      console.log("colorpicker initiated");
    },
    beforeShow: function() {
      console.log("before show");
    },
    afterShow: function() {
      console.log("after show");
    },
    beforeHide: function() {
      console.log("before hide");
    },
    afterHide: function() {
      console.log("after hide");
    },
    beforeHourSelect: function() {
      console.log("before hour selected");
    },
    afterHourSelect: function() {
      console.log("after hour selected");
    },
    beforeDone: function() {
      console.log("before done");
    },
    afterDone: function() {
      console.log("after done");
    }
  });
    $("input[name=from_time_day1],input[name=from_time_day2],input[name=from_time_day3],input[name=from_time_day4],input[name=from_time_day5],input[name=from_time_day6],input[name=from_time_day7]").clockpicker({
    placement: 'bottom',
    align: 'left',
    autoclose: true,
    default: 'now',
    donetext: "Select",
    init: function() {
      console.log("colorpicker initiated");
    },
    beforeShow: function() {
      console.log("before show");
    },
    afterShow: function() {
      console.log("after show");
    },
    beforeHide: function() {
      console.log("before hide");
    },
    afterHide: function() {
      console.log("after hide");
    },
    beforeHourSelect: function() {
      console.log("before hour selected");
    },
    afterHourSelect: function() {
      console.log("after hour selected");
    },
    beforeDone: function() {
      console.log("before done");
    },
    afterDone: function() {
      console.log("after done");
    }
  });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){
        $.validator.addMethod("timemin", function(value, element, min) {
            // var valuestart = $("select[name='timestart']").val();
            // var valuestop = $("select[name='timestop']").val();

            //create date format
            var timeStart = new Date("01/01/2007 " + min);
            var timeEnd = new Date("01/01/2007 " + value);

            var difference = timeEnd - timeStart;

            difference = difference / 60 / 60 / 1000;
            if(value>min){
                return true;
            }
            else if(value==''){
                return true;
            }
        }, "{{__('To time should not be greater than from time')}}");
        $("#availability_form").validate({
            rules: {
                from_time_day1:{
                    required: function(){
                        if($('#day1').prop("checked") == false){
                            return false;
                        }else{
                            
                            return true;
                         }
                    },
                },
                to_time_day1:{
                    required: function(){
                        if($('#day1').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                       
                        return $("input[name=from_time_day1]").val();
                    }
                },
                from_time_day2:{
                    required: function(){
                        if($('#day2').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day2:{
                    required: function(){
                        if($('#day2').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day2]").val();
                    }
                },
                from_time_day3:{
                    required: function(){
                        if($('#day3').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day3:{
                    required: function(){
                        if($('#day3').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day3]").val();
                    }
                },
                from_time_day4:{
                    required: function(){
                        if($('#day4').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day4:{
                    required: function(){
                        if($('#day4').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day4]").val();
                    }
                },
                from_time_day5:{
                    required: function(){
                        if($('#day5').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day5:{
                    required: function(){
                        if($('#day5').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day5]").val();
                    }
                },
                from_time_day6:{
                    required: function(){
                        if($('#day6').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day6:{
                    required: function(){
                        if($('#day6').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day6]").val();
                    }
                },
                from_time_day7:{
                    required: function(){
                        if($('#day7').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day7:{
                    required: function(){
                        if($('#day7').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day7]").val();
                    }
                },

            },
        messages: {
                from_time_day1:{
                    required: 'From time',
                },
                to_time_day1:{
                    required: 'To time',
                },
                from_time_day2:{
                    required: 'From time',
                },
                to_time_day2:{
                    required: 'To time',
                },
                from_time_day3:{
                    required: 'From time'
                },
                to_time_day3:{
                    required:'To time',
                },
                from_time_day4:{
                    required: 'From time',
                },
                to_time_day4:{
                    required: 'To time',
                },
                from_time_day5:{
                    required: 'From time',
                },
                to_time_day5:{
                    required: 'To time',
                },
                from_time_day6:{
                    required: 'From time',
                },
                to_time_day6:{
                    required: 'To time',
                },
                from_time_day7:{
                    required: 'From time',
                },
                to_time_day7:{
                    required:'To time',
                },
            },
        });
    })
</script>

@endsection