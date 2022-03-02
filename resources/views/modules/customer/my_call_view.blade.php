@extends('layouts.app')

@section('title')
<title>My Calls</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .u_ran ul li span {
        width: 169px;
    }
    #completed_call_audio{
      margin-right: 5px;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection

@section('body')
@if(Auth::user()->user_type=='C')
<section class="pad-114">
    <div class="dashboard-customer">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="cus-dashboard-right">
                <div class="view-action-div">
                <h1>My Call Details </h1>@include('includes.message')

                

                               <ul class="view_action_icons">


                @if(@$callDetails->order_type=="C" && @$callDetails->callHistory->call_date_time<=date('Y-m-d H:i:s') && $callDetails->status!='I' && @$callDetails->order_type !="F")
                
                <li><a href="{{route('chat.with.astrologer',['id'=>@$callDetails->callHistory->id])}}"><i class="fa fa-commenting-o" aria-hidden="true"></i></a></li>
                @endif
                
                @if(date('Y-m-d') <= date('Y-m-d',strtotime(@$callDetails->callHistory->call_date_time)))  
                {{-- video-call --}}
                @if(@$callDetails->status!="C" && @$callDetails->status!="I"  && @$callDetails->order_type=="V" && @$callDetails->order_type !="F")
                 @if(@$callDetails->status!="CA")
                 <li><a class="videoCallStart" data-token="{{ @$callDetails->id }}" data-id="{{ $callDetails->user_id }}" data-dur="@if($callDetails->callHistory->is_per_minute=="N"){{ @$callDetails->duration*60-@$callDetails->callHistory->completed_call}} @else {{'10000'}} @endif" data-toggle="tooltip" data-name="cus" data-placement="top" title="view" data-permin="@if($callDetails->callHistory->is_per_minute=="Y")Y @else N @endif"><i class="fa fa-phone-square" aria-hidden="true"></i></a></li>
                  @endif
                @endif






                 @php
                                    $permin = '';
                                   if (@$callDetails->callHistory->is_per_minute=="Y") {
                                      $permin='Y';
                                    }else{
                                       $permin='N';
                                    }
                            @endphp

                {{-- audio-call  --}}
                @if(@$callDetails->status!="C" && @$callDetails->status!="I"  && @$callDetails->order_type=="A" && @$val->order_type !="F" && @$callDetails->status!="CA")
                @if(@$callDetails->status!="CA")
                    <li><a class="class_click clickon" data-order="{{@$callDetails->id}}" data-duration="{{(@$callDetails->duration*60)-$callDetails->callHistory->completed_call}}" data-astro="{{@$callDetails->astrologer->first_name}} {{@$callDetails->astrologer->last_name}}" data-image="{{@$callDetails->profile_img}}" data-permin="{{@$permin}}"><i class="fa fa-phone-square" aria-hidden="true"></i></a></li>
                @endif
                @endif

                
                

                @if(@$callDetails->is_customer_review=='N' && @$callDetails->status!="CA")
                     <li> <a href="{{route('customer.review.call.view',['id'=>@$callDetails->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review" ><i class="fa fa-registered" aria-hidden="true"></i></a></li>
                @endif

                @if(@$callDetails->order_type =="F" &&  date('Y-m-d',strtotime(@$callDetails->callHistory->call_date_time))==date('Y-m-d') && @$callDetails->status!="CA" &&  @$callDetails->status!="C")
                       <li> <a href="{{route('customer.call.complete.offline',['id'=>@$callDetails->order_id])}}" data-toggle="tooltip" data-placement="top" onclick="return confirm('Do you want to mark this complete?')"><i class="fa fa-check" aria-hidden="true"></i></a></li>
                  @endif

                  @if(@$callDetails->callHistory->book_type=="S" && @$callDetails->status!="CA" && @$callDetails->status!="C")
                        <li><a href="{{route('customer.call.cancel',['id'=>@$callDetails->id])}}"  onclick="return confirm('Do you want to cancel this ?')"><i class="fa fa-times" aria-hidden="true"></i>
                    </a></li>
                   @endif

                    @endif
                 </ul>


               </div>
                    </div>
                    <div class="cus-rightbody">
                        <div class="astro-dash-form">
							<div class="post-review-sec">
								<div class="u_ran">
								   <ul>
                                       <li><span>{{__('profile.order_no_label')}} </span> <label>: {{@$callDetails->order_id}}</label></li>
                                   <li><span>{{__('profile.customer_name_label')}} </span> <label>: {{@$callDetails->customer->first_name}} {{@$callDetails->customer->last_name}}</label></li>

                                   <li><span>Astrologer Name </span> <label>: {{@$callDetails->astrologer->first_name}} {{@$callDetails->astrologer->last_name}}</label></li>

                                    @if(@$callDetails->order_type=="F")
                                    <li><span>Astrologer Ph Number </span> <label>: {{@$callDetails->astrologer->mobile}}</label></li>
                                    <li><span>Astrologer Address </span> <label>: {{@$callDetails->astrologer->address}}</label></li>
                                   @endif







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


                                   <li><span>Appointment Date </span> <label>: {{date('F j, Y',strtotime(@$callDetails->callHistory->call_date_time))}}</label></li>
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
                                    {{date('H:i a',strtotime(@$callDetails->from_time))}}

                                   </label></li>
                                   @endif



                                   @if(@$callDetails->callHistory->is_per_minute=="N")
                                  @if(@$callDetails->duration!="")
                                   <li><span>{{__('profile.call_duration_label')}} </span> <label>: {{@$callDetails->duration}} minutes</label></li>
                                   @endif
                                   @else
                                   <li><span>{{__('profile.call_duration_label')}} </span> <label>: Per minutes based</label></li>
                                   @endif

                                   @if(@$callDetails->callHistory->completed_call>0 && @$callDetails->callHistory->call_type=="V")
                                   <li><span>Call Occured For </span> <label>  <span id="completed_call_audio"></span></label></li>
                                   @endif

                                   <input type="hidden" id="complete_call_id" value="{{@$callDetails->callHistory->completed_call}}">

                                    @if(@$callDetails->callHistory->completed_call>0 && @$callDetails->callHistory->call_type=="A")
                                   <li><span>Call Occured For </span>  <label>  <span id="completed_call_audio"></span></label></li>
                                   @endif

                                   @if(@$callDetails->callHistory->completed_call>0 && @$callDetails->callHistory->call_type=="C")
                                   @php
                                        $s = @$callDetails->callHistory->completed_call%60;
                                        $m = floor((@$callDetails->callHistory->completed_call%3600)/60);
                                        $h = floor((@$callDetails->callHistory->completed_call%86400)/3600);
                                    @endphp
                                   <li><span>Chat Occured For </span> : <label>
                                        @if($h != 0)
                                            {{$h}} hour
                                        @endif
                                        @if($m != 0)
                                            {{$m}} minute
                                        @endif
                                        @if($s != 0)
                                            {{$s}} seconds
                                        @endif
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
                                        Incomplete
                                        @elseif(@$callDetails->status=='C')
                                        {{__('profile.call_status_complete')}}
                                        @elseif(@$callDetails->status=='CA')
                                        {{__('profile.call_status_cancel')}}
                                        @elseif(@$callDetails->status=='N')
                                        New
                                        @elseif(@$callDetails->status=='IP')
                                        Inprogress
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
							</div>
						</div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if(Auth::user()->user_type=='P'||Auth::user()->user_type=='A')
<div class="dashboard_sec dashboard_sec_education">
	<div class="container">
		<div class="dashboard_iner">
            @include('includes.profile_sidebar')
            <div class="astro-dash-pro-right">
              <div class="view-action-div">
                <h1>My Call Details </h1>@include('includes.message')


                


                <ul class="view_action_icons">


                @if(@$callDetails->order_type=="C" && @$callDetails->callHistory->call_date_time<=date('Y-m-d H:i:s') && $callDetails->status!='I' && @$callDetails->order_type !="F")
                
                <li><a href="{{route('chat.with.astrologer',['id'=>@$callDetails->callHistory->id])}}"><i class="fa fa-commenting-o" aria-hidden="true"></i></a></li>
                @endif
                
                @if(date('Y-m-d') <= date('Y-m-d',strtotime(@$callDetails->callHistory->call_date_time)))  
                {{-- video-call --}}
                @if(@$callDetails->status!="C" && @$callDetails->status!="I"  && @$callDetails->order_type=="V" && @$callDetails->order_type !="F")
                 @if(@$callDetails->status!="CA")
                 <li><a class="videoCallStart" data-token="{{ @$callDetails->id }}" data-id="{{ $callDetails->user_id }}" data-dur="@if($callDetails->callHistory->is_per_minute=="N"){{ @$callDetails->duration*60-@$callDetails->callHistory->completed_call}} @else {{'10000'}} @endif" data-toggle="tooltip" data-name="cus" data-placement="top" title="view" data-permin="@if($callDetails->callHistory->is_per_minute=="Y")Y @else N @endif"><i class="fa fa-phone-square" aria-hidden="true"></i></a></li>
                  @endif
                @endif






                 @php
                                    $permin = '';
                                   if (@$callDetails->callHistory->is_per_minute=="Y") {
                                      $permin='Y';
                                    }else{
                                       $permin='N';
                                    }
                            @endphp

                {{-- audio-call  --}}
                @if(@$callDetails->status!="C" && @$callDetails->status!="I"  && @$callDetails->order_type=="A" && @$val->order_type !="F" && @$callDetails->status!="CA")
                @if(@$callDetails->status!="CA")
                    <li><a class="class_click clickon" data-order="{{@$callDetails->id}}" data-duration="{{(@$callDetails->duration*60)-$callDetails->callHistory->completed_call}}" data-astro="{{@$callDetails->astrologer->first_name}} {{@$callDetails->astrologer->last_name}}" data-image="{{@$callDetails->profile_img}}" data-permin="{{@$permin}}"><i class="fa fa-phone-square" aria-hidden="true"></i></a></li>
                @endif
                @endif

                
                

                @if(@$callDetails->is_customer_review=='N' && @$callDetails->status!="CA")
                     <li> <a href="{{route('customer.review.call.view',['id'=>@$callDetails->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review" ><i class="fa fa-registered" aria-hidden="true"></i></a></li>
                @endif

                @if(@$callDetails->order_type =="F" &&  date('Y-m-d',strtotime(@$callDetails->callHistory->call_date_time))==date('Y-m-d') && @$callDetails->status!="CA" &&  @$callDetails->status!="C")
                       <li> <a href="{{route('customer.call.complete.offline',['id'=>@$callDetails->order_id])}}" data-toggle="tooltip" data-placement="top" onclick="return confirm('Do you want to mark this complete?')"><i class="fa fa-check" aria-hidden="true"></i></a></li>
                  @endif

                  @if(@$callDetails->callHistory->book_type=="S" && @$callDetails->status!="CA" && @$callDetails->status!="C")
                        <li><a href="{{route('customer.call.cancel',['id'=>@$callDetails->id])}}"  onclick="return confirm('Do you want to cancel this ?')"><i class="fa fa-times" aria-hidden="true"></i>
                    </a></li>
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

                                   <li><span>Astrologer Name </span> <label>: {{@$callDetails->astrologer->first_name}} {{@$callDetails->astrologer->last_name}}</label></li>

                                   @if(@$callDetails->order_type=="F")
                                    <li><span>Astrologer Ph Number </span> <label>: {{@$callDetails->astrologer->mobile}}</label></li>
                                    <li><span>Astrologer Address </span> <label>: {{@$callDetails->astrologer->address}} </label></li>
                                    {{-- ,{{@$callDetails->astrologer->countries->name}}, {{@$callDetails->astrologer->states->name}},{{@$callDetails->astrologer->cityName->name}} --}}

                                   @endif

                                   <li><span>Order Type </span> <label>:
                                    @if(@$callDetails->callHistory->call_type=="A")
                                    Audio Call
                                    @elseif(@$callDetails->callHistory->call_type=="V")
                                    Video Call
                                    @else
                                    Chat
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
                                   <li><span>Appointment Date </span> <label>: {{date('F j, Y',strtotime(@$callDetails->callHistory->call_date_time))}}</label></li>

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
                                    {{date('H:i a',strtotime(@$callDetails->from_time))}} - {{date('H:i a',strtotime(@$callDetails->end_time))}}

                                   </label></li>
                                   @endif




                                   @if(@$callDetails->duration!="")
                                   <li><span>{{__('profile.call_duration_label')}} </span> <label>: {{@$callDetails->duration}} minutes</label></li>
                                   @endif



                                   @if(@$callDetails->callHistory->completed_call>0 && @$callDetails->callHistory->call_type=="V")
                                   <li><span>Call Occured For </span> <label>  <span id="completed_call_audio"></span></label></li>
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
                                   <li><span>Chat Occured For </span> : <label>
                                        @if($h != 0)
                                            {{$h}} hour
                                        @endif
                                        @if($m != 0)
                                            {{$m}} minute
                                        @endif
                                        @if($s != 0)
                                            {{$s}} seconds
                                        @endif
                                    </label></li>
                                   @endif
                                   {{-- <li><span>{{__('profile.call_rate_label')}} </span> <label>: {{@$callDetails->currencyDetails->currency_code}}  {{@$callDetails->rate}}/{{__('profile.per_min')}} </label></li> --}}

                                   <li><span>{{__('profile.order_total_label')}} </span> <label>:  {{@$callDetails->currencyDetails->currency_code}} {{@$callDetails->total_rate}}</label></li>

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
                                        Inprogress
                                        @endif
                                    </label></li>


                                    @if(@$callDetails->status=="CA" && @$callDetails->reason!="")
                                    <li><span>Rejectio Reason </span> <label>:
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

                                    @if(@$callDetails->expertise)
                                    <li><span>Expertise </span> <label>:
                                       {{$callDetails->expertise_name->expertise_name}} 
                                    </label></li>
                                    @endif


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
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@section('footer')
@include('includes.footer')
<div class="modal" tabindex="-1" role="dialog" id="call-duration">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Call With <span id="astrologer_name"></span></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="location.reload();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="main-center-div for_ap22">
                        <div class="login-from-area">
                            <input type="hidden" id="audio_order_id">
                            <input type="hidden" id="remaining_duration">
                            <input type="hidden" id="total_duration" value="0">
                            <input type="hidden" name="start" id="start_time">
                            <input type="hidden" name="permin_call" id="permin_call">

                            <div class="popp_picc_area"><img id="astrologer-image" src="{{ asset('storage/app/public/profile_picture/'.@$userData->profile_img) }}" alt=""></div>


                        <div class="popp_areaa_mm">

                            {{-- <p id="remain">Order Duration : <span id="remain-time"></span></p>     --}}


                            <p class="order_duration">Order Duration : <span id="remain-time"></span></p>


                            <span class="timer_areaa calling_rea" id="timer">Calling...</span>
                            <button class="hngp calling_rea_btn" type="button" id="button-hangup" onClick="history.go(0)"><img src="{{ url('public/frontend/images/hngup.png') }}" /></button>
                            <button class="callnw" style="display: none;" type="button" id="button-call"><img src="{{ url('public/images/cll.png') }}" /></button>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="location.reload();">Close</button>
            </div> --}}
        </div>
    </div>
</div>
@endsection


@section('script')
@include('includes.script')

<button type="button" id="get-devices" style="display:none;"></button>
<input type="hidden" id="phone-number">
<script src="{{URL::to('public/frontend/js/twilio.min.js')}}"></script>
<script src="{{URL::to('public/frontend/js/quickstart.js')}}"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.session@1.0.0/jquery.session.min.js"></script>
<script type="text/javascript">


  $(document).ready(function(e){
        var duration = $('#complete_call_id').val();
         var m = Math.floor(duration % 3600 / 60);
         var s = Math.floor(duration % 3600 % 60);
         $('#completed_call_audio').text(': '+m + "Min:" + s +"Sec");
  });
</script>


<script type="text/javascript">
     var callStatus = 'initiated';

     $('.class_click').on('click',function(e){
        $.session.set("customer_error", "Please call the astrologer again to complete the call"); 
         var order_id = $(this).data('order');
         var duration = $(this).data('duration');
         var astrologer_name = $(this).data('astro');
         var imagename = $(this).data('image');
         var permin = $(this).data('permin');
         if (imagename=='') {
            var image = "{{asset('public/frontend/images/take_astro3.jpg')}}"
         }else{
         var image = "{{asset('storage/app/public/profile_picture')}}/"+imagename;
        }
         // alert(image);
         // alert(astrologer_name);
         var m = Math.floor(duration % 3600 / 60);
         var s = Math.floor(duration % 3600 % 60);
         $('#remain-time').text(m + "m :" + s +"s");

         $('#astrologer-image').attr("src", image);
         $('#audio_order_id').val(order_id);

         $('#remaining_duration').val(duration);
         $('#astrologer_name').html(astrologer_name);
         $('#permin_call').val(permin);
         if($('#permin_call').val() =='Y') {
           $('.order_duration').hide();
         }
         $("#call-duration").modal("show");
         $('#phone-number').val('+919830109208');
         $('#button-call').trigger('click');
    });

    // $("#call-duration").on('hidden.bs.modal', function (e) {
    //         $('#button-hangup').trigger('click');
    //         clearInterval(myInterval);
    //         location.href="{{route('customer.call')}}";
    //     });


    // function timer_disconnect()
    // {
    //    var second = $('#remaining_duration').val();
    //    setTimeout(function () {
    //     alert('Reloading Page');
    //     location.reload(true);
    //   }, second);
    // }





        function startTimer(duration, display) {

        var minutes = '0'; var seconds = '01';
        var totMin = '0';
        var timer = duration, minutes, seconds;
        updateCustomerWallet(totMin, minutes, seconds);
        myInterval = setInterval(function () {
            updateCustomerWallet(totMin, minutes, seconds);
            if(callStatus == 'initiated') {
                display.text('Calling...');
                var remaining_duration = $('#remaining_duration').val();
                $('#total_duration').val(1);
            }
            else if(callStatus == 'ringing') {
                display.text('Ringing...');
                var remaining_duration = $('#remaining_duration').val();
                $('#total_duration').val(0);
                timer = 0;
            } else if(callStatus=='start') {

                var dur = $('#remaining_duration').val();
                var permin =  $('#permin_call').val();
                var total_duration  = $('#total_duration').val();
                var tot = +total_duration+1;
                $('#total_duration').val(tot);
                timing = $('#total_duration').val();
                console.log(timing);
                if (timing==dur && permin=="N") {
                    sessionStorage.removeItem('customer_error');
                    dis();
                 }

                minutes = parseInt(timer / 60, 10)
                seconds = parseInt(timer % 60, 10)+2;

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;
                display.text(minutes + ":" + seconds);
                var totMin = Math.ceil(parseInt(minutes) + (parseFloat(seconds) + 2) / 60);
                if (timer++ < 0) {
                    timer = duration;
                }


            }
        }, 1000);
    }


    function insertToOrderMaster(sId) {
        var order_id = $('#audio_order_id').val();
        var reqData = {
            'jsonrpc': '2.0',
            '_token': '{{csrf_token()}}',
            'params': {
                order_id:order_id,
                sid: sId,
             }
        };
        $.ajax({
            url: '{{ route('customer.insert.order') }}',
            type: 'post',
            dataType: 'json',
            data: reqData,
        })
        .done(function(response) {
            // console.log(response);
        })
        .fail(function(error) {
            // console.log("error", error);
        })
        .always(function() {
            // console.log("complete");
        });
    }

    function disconnectCall() {

    }


   function dis(){
    order_id = $('#audio_order_id').val();
    var reqData = {
            'jsonrpc': '2.0',
            '_token': '{{csrf_token()}}',
            'params': {
               order_id:order_id,
            }
        };
        $.ajax({
            url: '{{ route('update.call.status.complete') }}',
            type: 'post',
            dataType: 'json',
            data: reqData,
        })
        .done(function(response) {
          location.reload();
        });
  }

    function updateCustomerWallet(totMin, minutes, seconds) {

        var order_id = $('#audio_order_id').val();
        var reqData = {
            'jsonrpc': '2.0',
            '_token': '{{csrf_token()}}',
            'params': {
               order_id:order_id,
            }
        };
        $.ajax({
            url: '{{ route('customer.order.status') }}',
            type: 'post',
            dataType: 'json',
            data: reqData,
        })
        .done(function(response) {
            if(response.error) {
                toastr.error(response.error);
                //console.log(response.error);
            } else {
                if(response.result){

                    callStatus = response.result.call_status;
                    if (callStatus=='finish') {
                        sessionStorage.removeItem('customer_error');
                        location.reload();
                    }
                    console.log(callStatus);
                }
            }
            // console.log(response);
        })
        .fail(function(error) {
            // console.log("error", error);
        })
        .always(function() {
            // console.log("complete");
        });
    }
</script>


<script>
    $( function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker1" ).datepicker();
        $('.ui-datepicker').addClass('notranslate');
    });
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>

<script type="text/javascript">
    $(document).ready(function(e){
        if ($.session.get("customer_error")) {
            alert($.session.get("customer_error"));
            $.session.remove('customer_error');
            // $.session..remove('customer_error');
            // sessionStorage.clear();
        }
    });
</script>
{{-- @include('includes.toaster') --}}

@endsection
