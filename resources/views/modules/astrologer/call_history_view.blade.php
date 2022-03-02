@extends('layouts.app')

@section('title')
<title>My Call History Details</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .u_ran ul li span {
        width: 169px;
    }
</style>
@endsection

@section('header')
{{-- @include('includes.heder_profile') --}}
@include('includes.header')
@endsection

@section('body')
<div class="dashboard_sec dashboard_sec_education">
    <div class="container">
        <div class="dashboard_iner">
             @include('includes.profile_sidebar')
                        <div class="astro-dash-pro-right">
                                <div class="view-action-div">
                <h1>My Call History Details </h1>@include('includes.message')

                

                <ul class="view_action_icons">
                  @if(@$callDetails->order_type=="C" && @$callDetails->callHistory->call_date_time<=date('Y-m-d H:i:s') && $callDetails->status!='I' && @$callDetails->order_type !="F" && @$order->status!="CA")
                <li><a href="{{route('chat.with.astrologer',['id'=>@$callDetails->callHistory->id])}}"><i class="fa fa-commenting-o" aria-hidden="true"></i></a></li>
                @endif
                 

                 @if(date('Y-m-d') <= date('Y-m-d',strtotime(@$callDetails->callHistory->call_date_time))) 
                 

                 @if(@$callDetails->status!="C" && @$callDetails->status!="I"  && @$callDetails->order_type=="V" && @$callDetails->order_type !="F" && @$order->status!="CA")
                @if(@$callDetails->status!="C" && @$callDetails->status!="I"  && @$callDetails->order_type=="V" && @$callDetails->order_type !="F")
                 @if(@$callDetails->status!="CA")
                 <li><a class="videoCallStart" data-token="{{ @$callDetails->id }}" data-id="{{ $callDetails->user_id }}" data-dur="@if($callDetails->callHistory->is_per_minute=="N"){{ @$callDetails->duration*60-@$callDetails->callHistory->completed_call}} @else {{'10000'}} @endif" data-name="cus" data-toggle="tooltip" data-placement="top" data-permin="@if($callDetails->callHistory->is_per_minute=="Y")Y @else N @endif" title="view" ><i class="fa fa-phone-square" aria-hidden="true"></i></a></li>
                  @endif
                @endif

                @endif






                





                  @if(@$callDetails->callHistory->book_type=="S" && @$callDetails->status!="CA" && @$callDetails->status!="C")
                         <li><a  data-id="{{@$callDetails->id}}" class="cancel_call"><i class="fa fa-times" aria-hidden="true"></i></a></li>
                    </a></li>
                   @endif

                   @if(@$callDetails->order_type =="V" ||@$callDetails->order_type =="A")
                                 @if(@$callDetails->astro_suggestion=='' && @$callDetails->astro_suggestion_attachment=='')
                                 @if(@$callDetails->status!="CA")
                                 <li><a href="{{route('astro.suggestion',['id'=>@$callDetails->order_id])}}"><i class="fa fa-envelope" aria-hidden="true" title="suggestion/feedback"></i></a></li>
                                 @endif
                                 @endif
                                 @endif

                  @endif               


                 </ul>

                 
               </div>
                <div class="astro-dash-right_iner">
                    <div class="astro-dash-form">
                        <div class="post-review-sec">
                            <div class="u_ran">
                               <ul>
                                   <li><span>{{__('profile.order_no_label')}} </span> <label>: {{@$callDetails->order_id}}</label></li>
                                   <li><span>{{__('profile.customer_name_label')}} </span> <label>: {{@$callDetails->customer->first_name}} {{@$callDetails->customer->last_name}}</label></li>

                                   



                                   <li><span>Order Type </span> <label>:
                                    @if(@$callDetails->callHistory->call_type=="A")
                                    Audio Call
                                    @elseif(@$callDetails->callHistory->call_type=="V")
                                    Video Call
                                    @elseif(@$callDetails->callHistory->call_type=="C")
                                    Chat
                                    @else
                                    Offline Booking
                                    @endif
                                   </label></li>


                                   <li><span>Booking Type </span> <label>:
                                     @if(@$callDetails->callHistory->book_type=="I")
                                      Instant
                                      @else
                                      Schedule
                                      @endif
                                   </label></li>

                                   <li><span>Booking Date </span> <label>: {{date('F j, Y',strtotime(@$callDetails->date))}}</label></li>

                                   <li><span>Schedule Date </span> <label>: {{date('F j, Y',strtotime(@$callDetails->callHistory->call_date_time))}}</label></li>
                                    @if(@$callDetails->consultany_type!="")
                                   <li><span>Consultany type </span> <label>: {{@$callDetails->consultany_type}}</label></li>
                                   @endif

                                   @if(@$callDetails->measurement!="")
                                   <li><span>Measurment </span> <label>: {{@$callDetails->measurement}}</label></li>
                                   @endif

                                   @if(@$callDetails->astro_attachment!="")
                                   <li><span>Astro attachment </span> <label>: {{@$callDetails->astro_attachment}} <a href="{{url('storage/app/public/astro_attachment/'.@$callDetails->astro_attachment)}}" download> <i class="fa fa-download"></i> </a></label></li>
                                   @endif
                                   @if(@$callDetails->from_time!="" && @$callDetails->end_time!="")
                                   <li><span>Booking Start Timing </span> <label>:
                                    {{date('H:i a',strtotime(@$callDetails->from_time))}}</label></li>
                                   @endif


                                   @if(@$callDetails->callHistory->is_per_minute=="N")
                                  @if(@$callDetails->duration!="")
                                   <li><span>{{__('profile.call_duration_label')}} </span> <label>: {{@$callDetails->duration}} minutes</label></li>
                                   @endif
                                   @else
                                   <li><span>{{__('profile.call_duration_label')}} </span> <label>: Per minutes based</label></li>
                                   @endif

                                   @if(@$callDetails->callHistory->completed_call>0 && @$callDetails->callHistory->call_type=="V")
                                   <li><span>Call Occured For </span> <label> <span id="completed_call_audio"></span></label></li>
                                   @endif

                                   <input type="hidden" id="complete_call_id" value="{{@$callDetails->callHistory->completed_call}}">

                                   @if(@$callDetails->callHistory->completed_call>0 && @$callDetails->callHistory->call_type=="A")
                                   <li><span>Call Occured For </span> : <label>  <span id="completed_call_audio"></span></label></li>
                                   @endif

                                    @if(@$callDetails->callHistory->completed_call>0 && @$callDetails->callHistory->call_type=="C")
                                    @php
                                        $s = @$callDetails->callHistory->completed_call%60;
                                        $m = floor((@$callDetails->callHistory->completed_call%3600)/60);
                                        $h = floor((@$callDetails->callHistory->completed_call%86400)/3600);
                                    @endphp
                                   <li><span>Chat Occured For </span> :
                                        @if($h != 0)
                                            {{$h}} hour
                                        @endif
                                        @if($m != 0)
                                            {{$m}} minute
                                        @endif
                                        @if($s != 0)
                                            {{$s}} seconds
                                        @endif
                                    <label>
                                    </label></li>
                                   @endif

                                   {{-- <li><span>{{__('profile.call_rate_label')}} </span> <label>: {{@$callDetails->currencyDetails->currency_code}}  {{@$callDetails->rate}}/{{__('profile.per_min')}} </label></li> --}}

                                   <li><span>{{__('profile.order_total_label')}} </span> <label>:  {{@$callDetails->currencyDetails->currency_code}} {{@$callDetails->total_rate}}</label></li>

                                    @if(@$callDetails->expertise)
                                    <li><span>Expertise </span> <label>:
                                       {{@$callDetails->expertise_name->expertise_name}} 
                                    </label></li>
                                    @endif

                                   <li><span>Order Status </span> <label>:
                                        @if(@$callDetails->status=='I')
                                        {{-- {{__('profile.call_status_incomplete')}}
                                        @elseif(@$callDetails->status=='N') --}}
                                        Incomplete
                                        @elseif(@$callDetails->status=='C')
                                        {{__('profile.call_status_complete')}}
                                        @elseif(@$callDetails->status=='CA')
                                        {{__('profile.call_status_cancel')}}
                                        @elseif(@$callDetails->status=='N')
                                        New
                                        @elseif(@$callDetails->status=='IP')
                                        In Progress
                                        @endif
                                    </label></li>


                                    @if(@$callDetails->status=="CA" && @$callDetails->reason!="")
                                    <li><span>Rejection Reason </span> <label>:
                                       {{@$callDetails->reason}}
                                    </label></li>
                                    @endif

                                   <li><span>{{__('profile.payment_status')}} </span> <label>:
                                        @if(@$callDetails->payment_status=='I')
                                        {{__('profile.payment_status_not_paid')}}
                                        @elseif(@$callDetails->payment_status=='P')
                                        {{__('profile.payment_status_paid')}}
                                        @elseif(@$callDetails->payment_status=='F')
                                        {{__('profile.payment_status_failed')}}
                                        @endif
                                    </label></li>



                                    @if(@$callDetails->callHistory->call_start_time)
                                    <li><span>  @if(@$callDetails->callHistory->call_type=="A") Audio Call @elseif(@$callDetails->callHistory->call_type=="V") Video Call @else Chat @endif Start Time</span> <label>:
                                        {{date('F j, Y h:i a',strtotime(@$callDetails->callHistory->call_start_time))}}
                                    </label></li>
                                    @endif

                                    @if(@$callDetails->order_description)
                                    <li> <span>Description</span> <label>
                                     <p style="word-break: break-all;"> {{@$callDetails->order_description}}</p>
                                    </label></li>
                                    @endif

                                    @if(@$callDetails->astro_suggestion)
                                   <li> <span><u>Suggestion/Feedback</u> </span> <label>
                                      {{@$callDetails->astro_suggestion}}
                                    </label></li>
                                    @endif

                                    @if(@$callDetails->astro_suggestion_attachment!="")
                                   <li><span><u>Suggestion/Feedback Attachment</u> </span> <label>:<a href="{{url('storage/app/public/astro_suggestion_attachment/'.@$callDetails->astro_suggestion_attachment)}}" download> Download <i class="fa fa-download"></i> </a></label></li>
                                   @endif

                                    {{-- @if(@$callDetails->callHistory->call_end_time)
                                    <li><span>  @if(@$callDetails->callHistory->call_type=="A") Audio Call @elseif(@$callDetails->callHistory->call_type=="V") Video Call @else Chat @endif End Time</span> <label>:
                                        {{date('F j, Y h:i a',strtotime(@$callDetails->callHistory->call_end_time))}}
                                    </label></li>
                                    @endif --}}
                                     @if(@$callDetails->review->ratting_number!="" && @$callDetails->review->review_message!="")
                                        <li><span> {{__('profile.rating_lebel')}}</span> :<label >

                                             @for($i=0;$i<=($callDetails->review->ratting_number-1);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/rating1.png')}}"></a>

                                              @endfor
                                            @for($i=0;$i<(5-$callDetails->review->ratting_number);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/rating2.png')}}"></a>
                                            @endfor
                                          </label>
                                          </li>


                                          <li><span> {{__('profile.review_lebel')}}</span> :

                                            {{@$callDetails->review->review_message}}


                                        </li>
                                        @endif
                               </ul>
                            </div>
                            <div class="astro-dash-form">
                                <div class="post-review-sec">
                                    <div class="u_ran">
                                        <h1>Person Name For Consult</h1>
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
                                                            <th>Relation</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(@$callDetails->orderPujaNames)
                                                        <tr>
                                                            <td>{{@$callDetails->orderPujaNames->name}}</td>

                                                            <td>
                                                                @if(@$callDetails->orderPujaNames->gotra!="")
                                                                {{@$callDetails->orderPujaNames->gotra}}
                                                                @else
                                                                --
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if(@$callDetails->orderPujaNames->janam_rashi_lagna!="")
                                                                {{@$callDetails->orderPujaNames->rashis->name}}
                                                                @else
                                                                --
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if(@$callDetails->orderPujaNames->janama_nkshatra!="")
                                                                {{@$callDetails->orderPujaNames->nakshatras->name}}
                                                                @else
                                                                --
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if(@$callDetails->orderPujaNames->dob!="")
                                                                {{@$callDetails->orderPujaNames->dob}}
                                                                @else
                                                                --
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if(@$callDetails->orderPujaNames->place_of_residence !="")
                                                                {{@$callDetails->orderPujaNames->place_of_residence}}
                                                                @else
                                                                --
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(@$callDetails->orderPujaNames->relation !="")
                                                                {{@$callDetails->orderPujaNames->relation}}
                                                                @else
                                                                --
                                                                @endif
                                                            </td>

                                                        </tr>
                                                        @else
                                                        <tr><td>No Data</td></tr>
                                                        @endif

                                                    </tbody>
                                                </table>
                                            </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="u_ran addr">

                                    <h2>Customer Details</h2>
                                    <ul style="margin-top: 25px;">
                                       <li><span>Customer Name </span> <label>: {{@$callDetails->customer->first_name}} {{@$callDetails->customer->last_name}}</label></li>
                                        <li><span>Customer Email </span> <label>: {{@$callDetails->customer->email}}</label></li>

                                       <li><span>Customer Mobile </span> <label>: {{@$callDetails->customer->mobile}}</label></li>

                                       <li><span>Customer Address </span> <label>: {{@$callDetails->customer->address}}</label></li>
                                    </ul>
                                </div> --}}
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('footer')
@include('includes.footer')
<div class="modal" tabindex="-1" role="dialog" id="exampleModalLong">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Select Rejection Reason</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <form  method="POST" enctype="multipart/form-data" id="reason_form" action="{{route('astrologer.cancel.call.otp')}}">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form_box_area">
                                     <label>Select Rejection Reason</label>
                                            <select name="type" id="reason_select">
                                                <option value="">Select</option>
                                                @foreach(@$rejection as $value)
                                                <option value="{{@$value->title}}">{{@$value->title}}</option>
                                                @endforeach
                                                <option value="other_reason_select" >Other</option>

                                      </select>
                                     </div>
                                </div>

                            <div class="col-md-12 col-sm-12" id="other_reason" style="display: none;">
                                <div class="form_box_area">
                                    <label>Enter Your Reason</label>
                                     <input type="text" name="reason" placeholder="Enter your reason">
                                 </div>
                            </div>

                            </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="submit" value="Confirm" class="save-change">
                                        </div>
                                    </div>

                        </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@include('includes.script')
<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  $(document).ready(function(e){
        var duration = $('#complete_call_id').val();
         var m = Math.floor(duration % 3600 / 60);
         var s = Math.floor(duration % 3600 % 60);
         $('#completed_call_audio').text(': '+m + "Min:" + s +"Sec");
  });
</script>

<script type="text/javascript">
    $('#reason_select').on('change',function(e){
        if ($('#reason_select').val()=='other_reason_select') {
            $('#other_reason').css('display','block');
        }else{
            $('#other_reason').css('display','none');
        }
    })
</script>

<script type="text/javascript">
    $('.cancel_call').on('click',function(e){
        var id  = $(this).data('id');
        $('#order_id').val(id);
        $('#exampleModalLong').show();
    })
</script>


<script>
    $(document).ready(function(){
       $("#reason_form").validate({
            rules: {
                type: {
                   required:true,
                 },
                 reason:{
                    required:true,
                 },

          },

        messages: {
                type: {
                    required:'Please select the reason',
                },
                reason:{
                    required:'Please enter the reason',
                },

        },

        });
    })
</script>
@endsection
