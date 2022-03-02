@extends('layouts.app')

@section('title')
<title>My Call History</title>
@endsection


@section('style')
@include('includes.style')
<style type="text/css">
    .error {
        color: red !important;
    }
    .edit_action {
    list-style: none;
    display: inline-flex;
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
                <h1>My Call History</h1>@include('includes.message')
                <div class="astro-dash-right_iner">
                    <form method="post" action="{{route('astrologer.call.history.search')}}" class="search_filter">
                        @csrf
                        <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>{{__('profile.keyword_label')}}</label>
                                            <input type="text" name="keyword" placeholder="{{__('profile.keyword_placeholder')}}" value="{{request('keyword')}}"> </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>{{__('profile.date_label')}}</label>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="from_date" id="datepicker" value="{{request('from_date')}}"  placeholder="{{__('profile.from_placeholder')}}" class="position-relative from_date">

                                                </div>

                                                <div class="col-md-6 col-sm-6">
                                                        <input type="text" name="to_date" id="datepicker1" value="{{request('to_date')}}"  placeholder="{{__('profile.to_placeholder')}}" class="position-relative to_date">
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-sm-6">
                                        <div class="form_box_area">
                                            <label>{{__('profile.status_label')}}</label>
                                            <select name="status">
                                                <option value="">Any Status</option>
                                                <option value="N" @if(request('status')=='N') selected @endif>New</option>
                                                <option value="I" @if(request('status')=='I') selected @endif>Incomplete</option>
                                                <option value="IP" @if(request('status')=='IP') selected @endif>Inprogress</option>
                                                <option value="C" @if(request('status')=='C') selected @endif>Completed</option>
                                                <option value="CA" @if(request('status')=='CA') selected @endif>Cancel</option>

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
                                            <button class="res">{{__('profile.search_label')}}</button>
                                        </div>
                                        <div class="add_btnbx">
                                            <a href="{{route('astrologer.call.history')}}" class="res">{{__('profile.cancel')}}</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                        </div>
                    </form>
                    <div class="save_coniBx">

                    </div>
                    <div class="table_sec">
                        <table class="table">
                          <thead class="thead-dark">
                            <tr>
                              <th scope="col">{{__('profile.order_no_label')}}</th>
                              <th scope="col">{{__('profile.name_label')}}</th>
                              <th scope="col">Appointment Date</th>

                              <th scope="col">{{__('profile.duration_label')}}</th>

                              <th scope="col">Order Type</th>
                               <th scope="col">Booking Type</th>
                              <th scope="col">{{__('profile.amount_label')}}</th>
                              <th scope="col">Order Status</th>
                              <th scope="col">{{__('profile.action_label')}}</th>
                            </tr>
                          </thead>
                          <tbody>
                            @if(@$call_hisory->isNotEmpty())
                            @foreach(@$call_hisory as $val)
                           <tr>
                            <td><a href="{{route('astrologer.call.view',['id'=>@$val->order_id])}}" >{{@$val->order_id}}</a></td>
                            <td>{{@$val->customer->first_name}} {{@$val->customer->last_name}}</td>
                            <td>{{date('F j, Y', strtotime(@$val->callHistory->call_date_time))}}</td>
                            <td>  
                                @if(@$val->callHistory->is_per_minute=="N")
                                @if(@$val->duration!=""){{@$val->duration}} minutes @else -- @endif
                                @else
                                Per minutes Based
                                @endif

                            </td>

                             <td>
                                @if(@$val->callHistory->call_type=="A")
                                Audio Call
                                @elseif(@$val->callHistory->call_type=="V")
                                Video Call
                                 @elseif(@$val->callHistory->call_type=="C")
                                Chat
                                @else
                                Offline Booking
                                @endif
                            </td>

                            <td>
                                @if(@$val->callHistory->book_type=="I")
                                Instant
                                @else
                                Schedule
                                @endif
                            </td>



                            <td>{{@$val->currencyDetails->currency_code}} {{@$val->total_rate}}</td>
                            <td>
                              @if(@$val->status=='N')
                              New
                              @elseif(@$val->status=='C')
                              Complete
                              @elseif(@$val->status=='CA')
                              Cancel
                              @elseif(@$val->status=='I')
                               Incomplete
                               @elseif(@$val->status=='IP')
                               Inprogress
                              @endif
                            </td>
                            <td>
                                <ul class="edit_action">
                                <li><a href="{{route('astrologer.call.view',['id'=>@$val->order_id])}}" data-toggle="tooltip" data-placement="top" title="view" ><i class="fa fa-eye"></i></a></li>

                                @if(@$val->order_type=="C" && @$val->callHistory->call_date_time<=date('Y-m-d H:i:s') && $val->status!='I' && @$val->order_type !="F")
                                
                                <li><a href="{{route('chat.with.astrologer',['id'=>@$val->callHistory->id])}}"><i class="fa fa-commenting-o" aria-hidden="true"></i></a></li>
                                
                                @endif

                                {{-- date validation --}}
                                 @if(date('Y-m-d') <= date('Y-m-d',strtotime(@$val->callHistory->call_date_time)))

                                @if(@$val->status!="C" && @$val->status!="I" && @$val->order_type=="V" && @$val->order_type !="F")
                                @if(@$val->status!="CA")
                                <li><a class="videoCallStart" data-token="{{ @$val->id }}" data-id="{{$val->customer_id}}" data-dur="@if($val->callHistory->is_per_minute=="N"){{ @$val->duration*60-@$val->callHistory->completed_call}} @else {{'10000'}} @endif" data-permin="@if($val->callHistory->is_per_minute=="Y")Y @else N @endif" data-name="" data-toggle="tooltip" data-placement="top" title="view" ><i class="fa fa-phone-square" aria-hidden="true"></i></a></li>
                                @endif
                                @endif

                                

                                @if(@$val->callHistory->book_type=="S" && @$val->status!="CA" && @$val->status!="C") 
                                <li><a data-id="{{@$val->id}}" class="cancel_call"><i class="fa fa-times" aria-hidden="true"></i></a></li>
                                 @endif

                                 {{-- @if(@$val->status=="C") --}}
                                 @if(@$val->order_type =="V" ||@$val->order_type =="A")
                                 @if(@$val->astro_suggestion=='' && @$val->astro_suggestion_attachment=='')
                                 @if(@$val->status!="CA")
                                 <li><a href="{{route('astro.suggestion',['id'=>@$val->order_id])}}"><i class="fa fa-envelope" aria-hidden="true" title="suggestion/feedback"></i></a></li>
                                 @endif
                                 @endif
                                 @endif


                                 @endif
                                 {{-- @endif --}}
                                {{-- <li><a href="{{route('astrologer.call.history.del',['id'=>@$val->id])}}" data-toggle="tooltip" data-placement="top" title="Cancel" onclick="return confirm('{{__('profile.confrontation_msg_delete_call_history')}}');"><i class="fa fa-times"></i></a></li> --}}
                              </ul>
                            </td>

                          </tr>
                           @endforeach
                           @else
                           <tr><td>No Data</td></tr>
                           @endif

                          </tbody>
                        </table>
                        <section class="pagination-sec">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-9 offset-lg-3">
                                                <nav aria-label="Page navigation example" class="list-pagination">
                                                    <ul class="pagination justify-content-end">
                                                        {{@$call_hisory->links()}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $( function() {
        $( "#datepicker" ).datepicker();
        $( "#datepicker1" ).datepicker();
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
</script>
<script type="text/javascript">

$(document).ready(function(){
        $(".search_filter").validate({
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
