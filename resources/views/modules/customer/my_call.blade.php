@extends('layouts.app')

@section('title')
<title>My Calls</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
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
                        <h2> My Calls </h2>
                    </div> @include('includes.message')
                    <div class="cus-rightbody">
                        <form action="{{route('customer.call.filter')}}" method="POST" id="filter">
                            @csrf
                            <input type="hidden" name="page" value="" id="page">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.keyword_label')}}</label>
                                        <input type="text" placeholder="{{__('profile.keyword_placeholder')}}" name="keyword" value="{{@$request['keyword']}}"> </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.date_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                    <input type="text" id="datepicker" placeholder="{{__('profile.from_placeholder')}}" class="position-relative" name="from_date" value="{{@$request['from_date']}}">
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                    <input type="text" id="datepicker1" placeholder="{{__('profile.to_placeholder')}}" class="position-relative" name="to_date" value="{{@$request['to_date']}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.status_label')}}</label>
                                        <select name="status">
                                            <option value="">{{__('profile.any_status')}}</option>
                                            <option value="N" @if( @$request['status'] == 'N') selected @endif>New</option>
                                            <option value="I" @if( @$request['status'] == 'I') selected @endif>Incomplete</option>
                                            <option value="C" @if( @$request['status'] == 'C') selected @endif>Completed</option>
                                            <option value="IP" @if( @$request['status'] == 'IP') selected @endif>Inprogress</option>
                                            <option value="CA" @if( @$request['status'] == 'CA') selected @endif>Cancel</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Booking Type</label>
                                            <select name="type">
                                                <option value="">Select</option>
                                                <option value="I" @if(request('type')=='I') selected @endif>Instant</option>
                                                <option value="S" @if(request('type')=='S') selected @endif>Schedule</option>
                                            </select>
                                        </div>
                                </div>

                                <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Order Type</label>
                                            <select name="order_type">
                                                <option value="">Select</option>
                                                <option value="A" @if(request('order_type')=='A') selected @endif>Audio Call</option>
                                                <option value="V" @if(request('order_type')=='V') selected @endif>Video Call</option>
                                                <option value="C" @if(request('order_type')=='C') selected @endif>Chat</option>
                                                <option value="F" @if(request('order_type')=='F') selected @endif>Offline</option>
                                            </select>
                                        </div>
                                </div>


                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <a href="javascript:;" class="res search">{{__('profile.search_label')}}</a>
                                    </div>
                                    <div class="add_btnbx">
                                        <a href="{{route('customer.call')}}" class="res">{{__('profile.cancel')}}</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                        <div class="details-table">
                            <div class="table-cus" id="table_details">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">{{__('profile.order_no_label')}} </div>
                                    <div class="cell amunt cess">{{__('profile.astrologer_name_label')}}</div>
                                    <div class="cell amunt cess">Appointment Date</div>
                                    <div class="cell amunt cess">{{__('profile.call_duration_label')}}</div>
                                    <div class="cell amunt cess">Order Type</div>
                                    <div class="cell amunt cess">Booking Type</div>
                                    {{-- <div class="cell amunt cess">{{__('profile.call_rate_label')}}</div> --}}
                                    <div class="cell amunt cess">{{__('profile.order_total_label')}}</div>
                                    <div class="cell amunt cess">Order Status</div>
                                    <div class="cell amunt cess actn">{{__('profile.action')}}</div>

                                </div>
                                @if(@$orderDetails->isNotEmpty())
                                @foreach (@$orderDetails as $order)
                                @php
                                    $permin = '';
                                   if (@$order->callHistory->is_per_minute=="Y") {
                                      $permin='Y';
                                    }else{
                                       $permin='N';
                                    }
                            @endphp
                                <div class="row small_screen2 scernexr">
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_no_label')}} :</span><a href="{{route('customer.call.view',['id'=>@$order->order_id])}}"> {{@$order->order_id}}</a></div>
                                     <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.astrologer_name_label')}}:</span> {{@$order->astrologer->first_name}} {{@$order->astrologer->last_name}}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_date_label')}}:</span>{{ date('F j, Y', strtotime(@$order->callHistory->call_date_time)) }}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_duration_label')}}:</span>
                                       @if(@$order->callHistory->is_per_minute=="N")
                                        @if(@$order->duration !=  null)  {{@$order->duration}} minutes @else --  @endif 
                                        @else
                                        Per minutes Based
                                        @endif

                                    </div>


                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_duration_label')}}:</span>
                                        @if(@$order->callHistory->call_type=="A")
                                        Audio Call
                                        @elseif(@$order->callHistory->call_type=="V")
                                        Video Call
                                        @elseif(@$order->callHistory->call_type=="C")
                                        Chat
                                        @elseif(@$order->callHistory->call_type=="F")
                                        Offline Booking
                                        @endif
                                    </div>


                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_duration_label')}}:</span>
                                         @if(@$order->callHistory->book_type=="I")
                                        Instant
                                        @else
                                        Schedule
                                        @endif
                                    </div>


                                    {{-- <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_rate_labe')}}:</span>₹{{@$order->rate}}</div> --}}
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_total_label')}}:</span> {{@$order->currencyDetails->currency_code}} {{@$order->total_rate}}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_status')}}:</span>
                                        @if(@$order->status=='I')
                                        Incomplete
                                        @elseif(@$order->status=='C')
                                        {{__('profile.call_status_complete')}}
                                        @elseif(@$order->status=='CA')
                                        {{__('profile.call_status_cancel')}}
                                         @elseif(@$order->status=='N')
                                         New
                                         @elseif(@$order->status=='IP')
                                         Inprogress
                                         @endif
                                    </div>
                                    {{-- <div class="cell amunt-detail cess"> <span class="hide_big">Action:</span>
                                        <p class="table-actions">
                                        <a href="{{route('customer.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="view"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="Cancel"><i class="fa fa-times"></i></a>
                                        @if(@$order->is_customer_review=='N')
                                        <a href="{{route('customer.review.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review"> <i class="fa fa-commenting-o"></i></a>
                                        @endif
                                        </p>
                                    </div> --}}
                                    <div class="cell amunt-detail cess">
                                        <span class="hide_big">{{__('profile.action')}}:</span>
                                        <div class="add_ttrr actions-main">
                                            <a href="javascript:void(0);" class="action-dots" id="action{{@$order->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                            <div class="show-actions" id="show-{{@$order->id}}" style="display: none;">
                                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                <ul>

                                                    <li><a href="{{route('customer.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="view" >View</a></li>

                                                    @if(@$order->order_type=="C" && @$order->callHistory->call_date_time<=date('Y-m-d H:i:s') && $order->status!='I' && @$order->order_type !="F")
                                                    <li><a href="{{route('chat.with.astrologer',['id'=>@$order->callHistory->id])}}">Chat</a></li>
                                                    @endif

                                                   
                                                    {{-- date validation --}}
                                                    @if(date('Y-m-d') <= date('Y-m-d',strtotime(@$order->callHistory->call_date_time)))

                                                    @if(@$order->status!="C"  && @$order->status!="I"  && @$order->order_type=="A" && @$order->order_type !="F")
                                                    @if(@$order->status!="CA")

                                                    <li><a class="class_click clickon" data-order="{{@$order->id}}" data-duration="@if($order->callHistory->is_per_minute=="N"){{ @$order->duration-@$order->callHistory->completed_call}} @else {{'10000'}} @endif" data-astro="{{@$order->astrologer->first_name}} {{@$order->astrologer->last_name}}"  data-image="{{@$order->profile_img}}" data-permin="{{@$permin}}">Audio Call</a></li>
                                                    @endif
                                                    @endif



                                                    @if(@$order->status!="C" && @$order->status!="I"  && @$order->order_type=="V" && @$order->order_type !="F")
                                                    @if(@$order->status!="CA")
                                                    <li><a class="videoCallStart" data-token="{{ @$order->id }}" data-id="{{ $order->user_id }}" data-dur="@if($order->callHistory->is_per_minute=="N"){{ @$order->duration*60-@$order->callHistory->completed_call}} @else {{'10000'}} @endif" data-name="cus" data-toggle="tooltip" data-placement="top" data-permin="@if($order->callHistory->is_per_minute=="Y")Y @else N @endif" title="view" >Start Video Call</a></li>
                                                    @endif
                                                    @endif

                                                    


                                                    @if(@$order->is_customer_review=='N' && @$order->status!="CA")
                                                    <li> <a href="{{route('customer.review.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review" > Post Review</a></li>
                                                    @endif


                                                    

                                                     @if(@$order->callHistory->book_type=="S" && @$order->status!="CA" &&  @$order->status!="C") 
                                                    <li><a href="{{route('customer.call.cancel',['id'=>@$order->id])}}"  onclick="return confirm('Do you want to cancel this ?')">Cancel</a></li>
                                                    @endif

                                                    @endif


                                                    @if(@$order->order_type =="F" &&  date('Y-m-d',strtotime(@$order->callHistory->call_date_time))==date('Y-m-d') && @$order->status!="CA" &&  @$order->status!="C")
                                                    <li> <a href="{{route('customer.call.complete.offline',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" onclick="return confirm('Do you want to mark this complete?')"> Complete Call</a></li>
                                                    @endif

                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else

                                <div class="row small_screen2 scernexr" >
                                    No Call Found
                                </div>
                                @endif


                            </div>
                        </div>
                        <section class="pagination-sec">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-9 offset-lg-3">
                                        <nav aria-label="Page navigation example" class="list-pagination">
                                            <ul class="pagination justify-content-end">
                                                {{@$orderDetails->links()}}
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </section>
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
                <h1>My Calls</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
                    <form action="{{route('customer.call.filter')}}" method="POST" id="filter">
                        @csrf
                        <input type="hidden" name="page" value="" id="page">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="form_box_area">
                                    <label>{{__('profile.keyword_label')}}</label>
                                    <input type="text" placeholder="{{__('profile.keyword_placeholder')}}" name="keyword" value="{{@$request['keyword']}}"> </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form_box_area">
                                    <label>{{__('profile.date_label')}}</label>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                                <input type="text" id="datepicker" placeholder="{{__('profile.from_placeholder')}}" class="position-relative" name="from_date" value="{{@$request['from_date']}}">
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                                <input type="text" id="datepicker1" placeholder="{{__('profile.to_placeholder')}}" class="position-relative" name="to_date" value="{{@$request['to_date']}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form_box_area">
                                    <label>{{__('profile.status_label')}}</label>
                                    <select name="status">
                                        <option value="">{{__('profile.any_status')}}</option>
                                            <option value="N" @if( @$request['status'] == 'N') selected @endif>New</option>
                                            <option value="I" @if( @$request['status'] == 'I') selected @endif>Incomplete</option>
                                            <option value="IP" @if( @$request['status'] == 'IP') selected @endif>Inprogress</option>
                                            <option value="C" @if( @$request['status'] == 'C') selected @endif>Completed</option>
                                            <option value="CA" @if( @$request['status'] == 'CA') selected @endif>Cancel</option>

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Booking Type</label>
                                            <select name="type">
                                                <option value="">Select</option>
                                                <option value="I" @if(request('type')=='I') selected @endif>Instant</option>
                                                <option value="S" @if(request('type')=='S') selected @endif>Schedule</option>
                                            </select>
                                        </div>
                             </div>

                             <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>Order Type</label>
                                            <select name="order_type">
                                                <option value="">Select</option>
                                                <option value="A" @if(request('order_type')=='A') selected @endif>Audio Call</option>
                                                <option value="V" @if(request('order_type')=='V') selected @endif>Video Call</option>
                                                <option value="C" @if(request('order_type')=='C') selected @endif>Chat</option>
                                                <option value="F" @if(request('order_type')=='F') selected @endif>Offline</option>
                                            </select>
                                        </div>
                                </div>


                            <div class="col-md-12 col-sm-12">
                                <div class="add_btnbx">
                                    <a href="javascript:;" class="res search">{{__('profile.search_label')}}</a>
                                </div>
                                <div class="add_btnbx">
                                    <a href="{{route('customer.call')}}" class="res">{{__('profile.cancel')}}</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                    <div class="details-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">{{__('profile.order_no_label')}} </div>
                                    <div class="cell amunt cess">{{__('profile.astrologer_name_label')}}</div>
                                    <div class="cell amunt cess">Appointment Date</div>
                                    <div class="cell amunt cess">{{__('profile.call_duration_label')}}</div>
                                    <div class="cell amunt cess">Order Type</div>
                                    <div class="cell amunt cess">Booking Type</div>
                                    {{-- <div class="cell amunt cess">{{__('profile.call_rate_label')}}</div> --}}
                                    <div class="cell amunt cess">{{__('profile.order_total_label')}}</div>
                                    <div class="cell amunt cess">Order Status</div>
                                    <div class="cell amunt cess actn">{{__('profile.action')}}</div>

                            </div>
                            @if(@$orderDetails->isNotEmpty())
                            @foreach (@$orderDetails as $order)
                             @php
                                    $permin = '';
                                   if (@$order->callHistory->is_per_minute=="Y") {
                                      $permin='Y';
                                    }else{
                                       $permin='N';
                                    }
                            @endphp
                             <div class="row small_screen2 scernexr">
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_no_label')}} :</span> <a href="{{route('customer.call.view',['id'=>@$order->order_id])}}"> {{@$order->order_id}}</a></div>
                                     <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.astrologer_name_label')}}:</span> {{@$order->astrologer->first_name}} {{@$order->astrologer->last_name}}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_date_label')}}:</span>{{ date('F j, Y', strtotime(@$order->callHistory->call_date_time)) }}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_duration_label')}}:</span>
                                         @if(@$order->callHistory->is_per_minute=="N")
                                        @if(@$order->duration !=  null)  {{@$order->duration}} minutes @else --  @endif 
                                        @else
                                        Per minutes Based
                                        @endif
                                     </div>


                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_duration_label')}}:</span>
                                         @if(@$order->callHistory->call_type=="A")
                                        Audio Call
                                        @elseif(@$order->callHistory->call_type=="V")
                                        Video Call
                                        @elseif(@$order->callHistory->call_type=="C")
                                        Chat
                                        @elseif(@$order->callHistory->call_type=="F")
                                        Offline Booking
                                        @endif
                                    </div>


                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_duration_label')}}:</span>
                                         @if(@$order->callHistory->book_type=="I")
                                        Instant
                                        @else
                                        Schedule
                                        @endif
                                    </div>


                                    {{-- <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_rate_labe')}}:</span>₹{{@$order->rate}}</div> --}}
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_total_label')}}:</span> {{@$order->currencyDetails->currency_code}} {{@$order->total_rate}}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.call_status')}}:</span>
                                        @if(@$order->status=='I')
                                        Incomplete
                                        @elseif(@$order->status=='C')
                                        {{__('profile.call_status_complete')}}
                                        @elseif(@$order->status=='CA')
                                        {{__('profile.call_status_cancel')}}
                                        @elseif(@$order->status=='N')
                                        New
                                        @elseif(@$order->status=='IP')
                                         Inprogress
                                        @endif
                                    </div>
                                {{-- <div class="cell amunt-detail cess"> <span class="hide_big">Action:</span>
                                    <p class="table-actions">
                                    <a href="{{route('customer.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="view"><i class="fa fa-eye"></i></a>
                                    <a href="#" data-toggle="tooltip" data-placement="top" title="Cancel"><i class="fa fa-times"></i></a>
                                    @if(@$order->is_customer_review=='N')
                                    <a href="{{route('customer.review.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review"> <i class="fa fa-commenting-o"></i></a>
                                    @endif
                                    </p>
                                </div> --}}
                                <div class="cell amunt-detail cess">
                                    <span class="hide_big">{{__('profile.action')}}:</span>
                                    <div class="add_ttrr actions-main">
                                        <a href="javascript:void(0);" class="action-dots" id="action{{@$order->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                        <div class="show-actions" id="show-{{@$order->id}}" style="display: none;">
                                            <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                            <ul>
                                                <li><a href="{{route('customer.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="view" >View</a></li>

                                                {{-- date validation --}}
                                                @if(date('Y-m-d') <= date('Y-m-d',strtotime(@$order->callHistory->call_date_time)))
                                                
                                                @if(@$order->status!="C" && @$order->status!="I" && @$order->order_type=="V" && @$val->order_type !="F")
                                                @if(@$order->status!="CA")
                                                <li><a class="videoCallStart" data-token="{{ @$order->id }}" data-id="{{ $order->user_id }}" data-dur="@if($order->callHistory->is_per_minute=="N"){{ @$order->duration*60-@$order->callHistory->completed_call}} @else {{'10000'}} @endif" data-toggle="tooltip" data-name="cus" data-placement="top" title="view" data-permin="@if($order->callHistory->is_per_minute=="Y")Y @else N @endif">Start Video Call</a></li>
                                                @endif
                                                @endif

                                                @if(@$order->status!="C" && @$order->status!="I"  && @$order->order_type=="A" && @$val->order_type !="F")
                                                @if(@$order->status!="CA") 
                                                    <li><a class="class_click clickon" data-order="{{@$order->id}}" data-duration="{{(@$order->duration*60)-$order->callHistory->completed_call}}" data-astro="{{@$order->astrologer->first_name}} {{@$order->astrologer->last_name}}" data-image="{{@$order->profile_img}}" data-permin="{{@$permin}}">Audio Call</a></li>
                                                    @endif
                                                    @endif

                                                @if(@$order->order_type=="C" && @$order->callHistory->call_date_time<=date('Y-m-d H:i:s') && $order->status!='I' && @$order->order_type !="F")
                                                    <li><a href="{{route('chat.with.astrologer',['id'=>@$order->callHistory->id])}}">Chat</a></li>
                                                @endif
                                                @if(@$order->is_customer_review=='N' && @$order->status!="CA")
                                                <li> <a href="{{route('customer.review.call.view',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review" > Post Review</a></li>
                                                @endif

                                                 

                                                    @if(@$order->callHistory->book_type=="S" && @$order->status!="CA" &&  @$order->status!="C") 
                                                    <li><a href="{{route('customer.call.cancel',['id'=>@$order->id])}}"  onclick="return confirm('Do you want to cancel this ?')">Cancel</a></li>
                                                    @endif


                                                    @if(@$order->order_type =="F" &&  date('Y-m-d',strtotime(@$order->callHistory->call_date_time))==date('Y-m-d') && @$order->status!="CA" &&  @$order->status!="C" )
                                                    <li> <a href="{{route('customer.call.complete.offline',['id'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" onclick="return confirm('Do you want to mark this complete?')"> Complete Call</a></li>
                                                    @endif

                                                    @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else

                            <div class="row small_screen2 scernexr" >
                                No Call Found
                            </div>
                            @endif


                        </div>
                    </div>
                    <section class="pagination-sec">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-9 offset-lg-3">
                                    <nav aria-label="Page navigation example" class="list-pagination">
                                        <ul class="pagination justify-content-end">
                                            {{@$orderDetails->links()}}
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </section>
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

<!--date picker-->
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
     var callStatus = 'initiated';

     $('.class_click').on('click',function(e){
        $.session.set("customer_error", "Please call the astrologer again to complete the call");  
        // $.session.set("customer_error", "Please call the astrologer again to complete the call");
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
         // 
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
{{-- @include('includes.toaster') --}}
<script>
    $(document).ready(function(){
        $(".list-pagination ul li a").click(function(){
            var url = $(this).attr('href');
            var vars = [], hash;
            var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            // console.log(hash[1]);
            $('#page').val(hash[1]);
            $("#filter").submit();
            return false;
        });
        $(".search").click(function(){
            $('#page').val('');
            $("#filter").submit();
        });
    });



    $("#datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        onClose: function (selectedDate, inst) {
            console.log(selectedDate, Date.parse(selectedDate));
            let minDate = new Date(selectedDate);
            minDate.setDate(minDate.getDate());
            var selectedDate = $('#datepicker').datepicker('getDate');
            selectedDate.setDate(selectedDate.getDate()+1);
            $("#datepicker1").datepicker("option", "minDate", selectedDate);
            $('#datepicker1').datepicker('show');
        }
    });
    $("#datepicker1").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'mm/dd/yy',
        onClose: function (selectedDate, inst) {
            var selectedDate = $('#datepicker1').datepicker('getDate');
            if(selectedDate==''|| selectedDate==null || selectedDate==undefined){
            }else{
                selectedDate.setDate(selectedDate.getDate()-1);
                $("#datepicker").datepicker("option", "maxDate", selectedDate);
            }
        }
    });
    $(document).ready(function(){
        $("#filter").validate({
            rules: {
                to_date:{
                    required: function(){
                        var from_date = $('#datepicker').val();
                        if(from_date !=''){
                            return true
                        }else{
                            return false
                        }
                    },
                },
                from_date:{
                    required:function(){
                        var to_date = $('#datepicker1').val();
                        if(to_date !=''){
                            return true
                        }else{
                            return false
                        }
                    },
                },
            },
            messages: {
                to_date:{
                    required: 'To Date Enter',
                },
                from_date:{
                    required: 'From Date Enter',
                },
            },
        });
    });
</script>
<script type="text/javascript">
    @foreach (@$orderDetails as $order)
    $("#action{{$order->id}}").click(function(){
        $('.show-actions:not(#show-{{$order->id}})').slideUp();
        $("#show-{{$order->id}}").slideToggle();
    });
    @endforeach
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
@endsection
