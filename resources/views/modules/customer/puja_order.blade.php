@extends('layouts.app')

@section('title')
<title>{{__('profile.puja_order_history_title')}}</title>
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
                        <h2>{{__('profile.puja_order_history')}}</h2>
                    </div>@include('includes.message')
                    <div class="cus-rightbody">
                        <form action="{{route('customer.puja.history.filter')}}" method="POST" id="filter">
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
                                            <option value="N" @if( @$request['status'] == 'N') selected @endif>{{__('profile.puja_status_new')}}</option>
                                            <option value="C" @if( @$request['status'] == 'C') selected @endif>{{__('profile.puja_status_complete')}}</option>
                                            <option value="IP" @if( @$request['status'] == 'IP') selected @endif>In Process</option>
                                            <option value="A" @if( @$request['status'] == 'A') selected @endif>Accepted</option>


                                            {{-- <option value="CA" @if( @$request['status'] == 'CA') selected @endif> {{__('profile.puja_status_incomplete')}}</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <a href="javascript:;" class="res search">{{__('profile.search_label')}}</a>
                                    </div>
                                    <div class="add_btnbx">
                                        <a href="{{route('customer.puja.history')}}" class="res">{{__('profile.cancel')}}</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                        <div class="details-table">
                            <div class="table-cus">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">{{__('profile.order_no_label')}}</div>
                                    <div class="cell amunt cess">Puja Title</div>
                                    <div class="cell amunt cess">{{__('profile.pandit_name_label')}}</div>
                                    <div class="cell amunt cess">{{__('profile.puja_date_label')}}</div>
                                    <div class="cell amunt cess">{{__('profile.order_total_label')}} </div>
                                    <div class="cell amunt cess">{{__('profile.status_label')}} </div>
                                    <div class="cell amunt cess actn">{{__('profile.action_label')}}</div>

                                </div>
                                @if(@$pujaDetails->isNotEmpty())
                                @foreach (@$pujaDetails as $puja)
                                    <div class="row small_screen2 scernexr">
                                        <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_no_label')}} : </span><a href="{{route('customer.puja.history.view',['id'=>@$puja->order_id])}}" > {{@$puja->order_id}} </a></div>
                                        <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_name_label')}} : </span>{{@$puja->pujas->puja_name}}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.pandit_name_label')}} : </span>@if(@$puja->pundit_accepted=="Y") {{@$puja->pundit->first_name}} {{@$puja->pundit->last_name}} @else -- @endif</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_date_label')}} : </span>{{ date('m/d/Y', strtotime(@$puja->date)) }}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_total_label')}} : </span>{{@$puja->currencyDetails->currency_code}} {{@$puja->total_rate}}</div>
                                          <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.status_label')}} : </span>
                                            @if(@$puja->status=='N')
                                            {{__('profile.puja_status_new')}}
                                            @elseif(@$puja->status=='C')
                                            {{__('profile.puja_status_complete')}}
                                            @elseif(@$puja->status=='CA')
                                            {{__('profile.puja_status_cancel')}}
                                            @elseif(@$puja->status=='I')
                                            {{__('profile.puja_status_incomplete')}}
                                            @elseif(@$puja->status=='IP')
                                            Inprocess
                                            @elseif(@$puja->status=='A')
                                            Accepted
                                            @endif
                                        </div>
                                        <div class="cell amunt-detail cess">
                                        <span class="hide_big">{{__('profile.action')}}:</span>
                                        <div class="add_ttrr actions-main">
                                                       <a href="javascript:void(0);" class="action-dots" id="action{{@$puja->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$puja->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                        <ul>
                                                           <li><a href="{{route('customer.puja.history.view',['id'=>@$puja->order_id])}}" >View</a></li>
                                                           @if(@$puja->is_customer_review=='N' && @$puja->user_id!="")
                                                           <li> <a href="{{route('customer.review.puja.view',['id'=>@$puja->order_id])}}" >Post Review</a></li>
                                                            @endif
                                                        </ul>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                @endforeach
                                @else
                                <div class="row small_screen2 scernexr" >
                                    {{__('profile.not_found_puja_order_history')}}
                                </div>
                                @endif
                            </div>
                            <section class="pagination-sec">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <nav aria-label="Page navigation example" class="list-pagination">
                                                <ul class="pagination justify-content-end">
                                                    {{@$pujaDetails->links()}}
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
</section>
@endif
@if(Auth::user()->user_type=='P'||Auth::user()->user_type=='A')
<div class="dashboard_sec dashboard_sec_education">
	<div class="container">
		<div class="dashboard_iner">
            @include('includes.profile_sidebar')
            <div class="astro-dash-pro-right">
                <h1>{{__('profile.puja_order_history')}}</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
					<form action="{{route('customer.puja.history.filter')}}" method="POST" id="filter">
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
                                        <option value="N" @if( @$request['status'] == 'N') selected @endif>{{__('profile.puja_status_new')}}</option>
                                        <option value="C" @if( @$request['status'] == 'C') selected @endif>{{__('profile.puja_status_complete')}}</option>
                                        <option value="IP" @if( @$request['status'] == 'IP') selected @endif>In Process</option>
                                        <option value="A" @if( @$request['status'] == 'A') selected @endif>Accepted</option>


                                        {{-- <option value="CA" @if( @$request['status'] == 'CA') selected @endif> {{__('profile.puja_status_incomplete')}}</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12">
                                <div class="add_btnbx">
                                    <a href="javascript:;" class="res search">{{__('profile.search_label')}}</a>
                                </div>
                                <div class="add_btnbx">
                                    <a href="{{route('customer.puja.history')}}" class="res">{{__('profile.cancel')}}</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                    <div class="details-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">{{__('profile.order_no_label')}}</div>
                                <div class="cell amunt cess">Puja Title</div>
                                <div class="cell amunt cess">{{__('profile.pandit_name_label')}}</div>
                                <div class="cell amunt cess">{{__('profile.puja_date_label')}}</div>
                                <div class="cell amunt cess">{{__('profile.order_total_label')}} </div>
                                <div class="cell amunt cess">{{__('profile.status_label')}} </div>
                                <div class="cell amunt cess actn">{{__('profile.action_label')}}</div>

                            </div>
                            @if(@$pujaDetails->isNotEmpty())
                            @foreach (@$pujaDetails as $puja)
                                <div class="row small_screen2 scernexr">
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_no_label')}} : </span> {{@$puja->order_id}}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_name_label')}} : </span>{{@$puja->pujas->puja_name}}</div>
                                     <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.pandit_name_label')}} : </span>@if(@$puja->pundit_accepted=="Y") {{@$puja->pundit->first_name}} {{@$puja->pundit->last_name}} @else -- @endif</div>
                                     <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_date_label')}} : </span>{{ date('m/d/Y', strtotime(@$puja->date)) }}</div>
                                     <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_total_label')}} : </span>{{@$puja->currencyDetails->currency_code}} {{@$puja->total_rate}}</div>
                                      <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.status_label')}} : </span>
                                        @if(@$puja->status=='N')
                                        {{__('profile.puja_status_new')}}
                                        @elseif(@$puja->status=='C')
                                        {{__('profile.puja_status_complete')}}
                                        @elseif(@$puja->status=='CA')
                                        {{__('profile.puja_status_cancel')}}
                                        @elseif(@$puja->status=='I')
                                        {{__('profile.puja_status_incomplete')}}
                                        @elseif(@$puja->status=='IP')
                                        Inprocess
                                        @elseif(@$puja->status=='A')
                                        Accepted
                                        @endif
                                    </div>
                                    <div class="cell amunt-detail cess">
                                        <span class="hide_big">{{__('profile.action')}}:</span>
                                        <div class="add_ttrr actions-main">
                                            <a href="javascript:void(0);" class="action-dots" id="action{{@$puja->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                            <div class="show-actions" id="show-{{@$puja->id}}" style="display: none;">
                                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                <ul>
                                                    <li><a href="{{route('customer.puja.history.view',['id'=>@$puja->order_id])}}" >View</a></li>
                                                    @if(@$puja->is_customer_review=='N' && @$puja->user_id!="")
                                                    <li> <a href="{{route('customer.review.puja.view',['id'=>@$puja->order_id])}}" >Post Review</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @else
                            <div class="row small_screen2 scernexr" >
                                {{__('profile.not_found_puja_order_history')}}
                            </div>
                            @endif
                        </div>
                        <section class="pagination-sec">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-9 offset-lg-3">
                                        <nav aria-label="Page navigation example" class="list-pagination">
                                            <ul class="pagination justify-content-end">
                                                {{@$pujaDetails->links()}}
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
@endif
@endsection
@section('footer')
@include('includes.footer')
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
  } );
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
    $('.ui-datepicker').addClass('notranslate');
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
    $('.ui-datepicker').addClass('notranslate');
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
      @foreach (@$pujaDetails as $puja)

    $("#action{{$puja->id}}").click(function(){
        $('.show-actions:not(#show-{{$puja->id}})').slideUp();
        $("#show-{{$puja->id}}").slideToggle();
    });
 @endforeach
</script>
@endsection
