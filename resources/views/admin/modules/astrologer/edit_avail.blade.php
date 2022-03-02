@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Astrologer Availability</title>
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
                            <li><a href="{{route('admin.astrologer.edit-exp-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon3.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon33.png')}}" class="bacicon2" alt="">
                            Experience</a></li>
                            <li class="actv"><a href="{{route('admin.astrologer.edit-avail-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Availability</a></li>
							<li><a href="{{route('admin.astrologer.date.exclusion',['id'=>@$data->id])}}">
                                <img src="{{ URL::to('public/frontend/images/declined-white.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/declined-color.png')}}" class="bacicon2" alt="">
                                Date Exclusion List</a></li>
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
                                        <form role="form" id="availability_form" method="post" enctype="multipart/form-data" action="{{route('admin.astrologer.update-avail')}}">
                                        	@csrf
                              <input type="hidden" name="user_id" value="{{@$data->id}}">
                                                      <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day1" type="checkbox" value="MONDAY" name="day1" @if(count(@$monday)>0) checked @endif>
                                        <label for="day1">Monday</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_monday_{{$slot}}" type="checkbox" class="checkMon"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" @if(count(@$monday)>0) {{ $monday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_monday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_monday_{{$slot}}" type="checkbox" class="checkMon" value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" @if(count(@$monday)>0) {{ $monday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_monday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                             @if(count(@$slots)>24)
                                                <a class="see-all moreless-button mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>
                            </div>




                            <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day2" type="checkbox" value="TUESDAY" name="day2" @if(count(@$tuesday)>0) checked @endif>
                                        <label for="day2">Tuesday</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_tuesday_{{$slot}}" type="checkbox" class="checkTue" value="{{date('H:i:s',strtotime(@$slot))}}" name="tuesday_slot[]" @if(count(@$tuesday)>0) {{ $tuesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_tuesday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-tuesday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_tuesday_{{$slot}}" type="checkbox" class="checkTue" value="{{date('H:i:s',strtotime(@$slot))}}" name="tuesday_slot[]" @if(count(@$tuesday)>0) {{ $tuesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_tuesday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-tuesday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>



                             <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day3" type="checkbox" value="WEDNESDAY" name="day3" @if(count(@$wednesday)>0) checked @endif>
                                        <label for="day3">{{__('profile.wednesday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_wednesday{{$slot}}" type="checkbox" class="checkWed" value="{{date('H:i:s',strtotime(@$slot))}}" name="wednesday_slot[]" @if(count(@$wednesday)>0) {{ $wednesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_wednesday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-wednesday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_wednesday{{$slot}}" type="checkbox" class="checkWed" value="{{date('H:i:s',strtotime(@$slot))}}" name="wednesday_slot[]"  @if(count(@$wednesday)>0) {{ $wednesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_wednesday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-wednesday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>



                             <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day4" type="checkbox" value="THURSDAY" name="day4" @if(count(@$thursday)>0) checked @endif>
                                        <label for="day4">{{__('profile.thursday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_thursday{{$slot}}" type="checkbox" class="checkThu" value="{{date('H:i:s',strtotime(@$slot))}}" name="thursday_slot[]"  @if(count(@$thursday)>0) {{ $thursday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_thursday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-thursday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_thursday{{$slot}}" type="checkbox" class="checkThu" value="{{date('H:i:s',strtotime(@$slot))}}" name="thursday_slot[]" @if(count(@$thursday)>0) {{ $thursday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_thursday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-thursday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>


                        <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day5" type="checkbox" value="FRIDAY" name="day5" @if(count(@$friday)>0) checked @endif>
                                        <label for="day5">{{__('profile.friday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_friday{{$slot}}" type="checkbox" class="checkFry" value="{{date('H:i:s',strtotime(@$slot))}}" name="friday_slot[]" @if(count(@$friday)>0) {{ $friday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_friday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-firday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_friday{{$slot}}" type="checkbox" class="checkFry" value="{{date('H:i:s',strtotime(@$slot))}}" name="friday_slot[]" @if(count(@$friday)>0) {{ $friday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_friday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-firday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>







                            <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day6" type="checkbox" value="SATURDAY" name="day6" @if(count(@$saturday)>0) checked @endif>
                                        <label for="day6">{{__('profile.saturday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_saturday{{$slot}}" type="checkbox" class="checkSat" value="{{date('H:i:s',strtotime(@$slot))}}" name="saturday_slot[]" @if(count(@$saturday)>0) {{ $saturday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_saturday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-saturday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_saturday{{$slot}}" type="checkbox" class="checkSat" value="{{date('H:i:s',strtotime(@$slot))}}" name="saturday_slot[]" @if(count(@$saturday)>0) {{ $saturday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_saturday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-saturday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>




                                                        <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day7" type="checkbox" value="SUNDAY" name="day7" @if(count(@$sunday)>0) checked @endif>
                                        <label for="day7">{{__('profile.sunday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_sunday{{$slot}}" type="checkbox" class="checkSun" value="{{date('H:i:s',strtotime(@$slot))}}" name="sunday_slot[]" @if(count(@$sunday)>0) {{ $sunday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_sunday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-sunday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_sunday{{$slot}}" type="checkbox" class="checkSun" value="{{date('H:i:s',strtotime(@$slot))}}" name="sunday_slot[]" @if(count(@$sunday)>0) {{ $sunday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_sunday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-sunday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" style="margin-top: 25px;"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                   </div>



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



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

    <script type="text/javascript">
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
$('.moreless-button').click(function() {
  $('.moretext').slideToggle();
  if ($('.moreless-button').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});

$('.moreless-button-tuesday').click(function() {
  $('.moretext-tuesday').slideToggle();
  if ($('.moreless-button-tuesday').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});

$('.moreless-button-wednesday').click(function() {
  $('.moretext-wednesday').slideToggle();
  if ($('.moreless-button-wednesday').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});

$('.moreless-button-thursday').click(function() {
  $('.moretext-thursday').slideToggle();
  if ($('.moreless-button-thursday').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});


$('.moreless-button-firday').click(function() {
  $('.moretext-firday').slideToggle();
  if ($('.moreless-button-firday').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});



$('.moreless-button-saturday').click(function() {
  $('.moretext-saturday').slideToggle();
  if ($('.moreless-button-saturday').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});

$('.moreless-button-sunday').click(function() {
  $('.moretext-sunday').slideToggle();
  if ($('.moreless-button-sunday').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>
<script>
    $(document).ready(function(){
        $('body').on('click','.checkMon',function(){
            if($("#day1").prop("checked") == false){
                alert('Please check the checkbox for monday first');
                return false;
            }

        })
        $('body').on('click','.checkTue',function(){
            if($("#day2").prop("checked") == false){
                alert('Please check the checkbox for tuesday first');
                return false;
            }

        })
        $('body').on('click','.checkWed',function(){
            if($("#day3").prop("checked") == false){
                alert('Please check the checkbox for wednesday first');
                return false;
            }

        })
        $('body').on('click','.checkThu',function(){
            if($("#day4").prop("checked") == false){
                alert('Please check the checkbox for thursday first');
                return false;
            }

        })
        $('body').on('click','.checkFry',function(){
            if($("#day5").prop("checked") == false){
                alert('Please check the checkbox for friday first');
                return false;
            }

        })
        $('body').on('click','.checkSat',function(){
            if($("#day6").prop("checked") == false){
                alert('Please check the checkbox for saturday first');
                return false;
            }

        })
        $('body').on('click','.checkSun',function(){
            if($("#day7").prop("checked") == false){
                alert('Please check the checkbox for sunday first');
                return false;
            }

        })
    })
</script>
<script type="text/javascript">
          $("#availability_form").validate({


          submitHandler: function(form){

           // if($("#day1 input[type=checkbox]").prop(":checked")){
           //      alert('hey');
           //      return false;
           //  }

            if($("#day1").prop("checked") == true) {
                var allRadios = $('[name="monday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from monday');
                    return false;
                }
            }
            if($("#day2").prop("checked") == true){
                var allRadios = $('[name="tuesday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from tuesday');
                    return false;
                }
            }

            if($("#day3").prop("checked") == true){
                var allRadios = $('[name="wednesday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from wednesday');
                    return false;
                }
            }

            if($("#day4").prop("checked") == true){
                var allRadios = $('[name="thursday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from thursday');
                    return false;
                }
            }

            if($("#day5").prop("checked") == true){
                var allRadios = $('[name="friday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from friday');
                    return false;
                }
            }

             if($("#day6").prop("checked") == true){
                var allRadios = $('[name="saturday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from saturday');
                    return false;
                }
            }

            if($("#day7").prop("checked") == true){
                var allRadios = $('[name="sunday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from sunday');
                    return false;
                }
            }


            form.submit();

          },

});


</script>

@endsection
