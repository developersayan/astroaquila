@extends('layouts.app')

@section('title')
<title>Horoscope Order</title>
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
                        <h2> Horoscope Order History</h2>
                    </div>@include('includes.message')
                    <div class="cus-rightbody">
                        <form action="{{route('user.manage.horoscope.order')}}" method="POST" id="filter">
                            @csrf
                            <input type="hidden" name="page" value="" id="page">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Order No</label>
                                        <input type="text" placeholder="Order No" name="order_no" value="{{@$request['order_no']}}"> </div>
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
                                
                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <a href="javascript:;" class="res search">{{__('profile.search_label')}}</a>
                                    </div>
                                    <div class="add_btnbx">
                                        <a href="{{route('user.manage.horoscope.order')}}" class="res">{{__('profile.cancel')}}</a>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                        <div class="details-table">
                            <div class="table-cus">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">Order Id</div>
                                    <div class="cell amunt cess">Person Name</div>
                                    <div class="cell amunt cess">Horoscope Name</div>
                                    <div class="cell amunt cess">Order Date</div>
                                    <div class="cell amunt cess">Email </div>
                                    <div class="cell amunt cess">Status</div>
                                    <div class="cell amunt cess actn">{{__('profile.action_label')}}</div>

                                </div>
                                @if(@$data->isNotEmpty())
                                @foreach (@$data as $value)
                                    <div class="row small_screen2 scernexr">
                                        <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_no_label')}} : </span><a href="{{route('user.manage.horoscope.order.details',['id'=>@$value->order_id])}}" > {{@$value->order_id}} </a></div>
                                        <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_name_label')}} : </span>{{@$value->name}}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.pandit_name_label')}} : </span>{{@$value->horoscope->name}}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_date_label')}} : </span>{{ date('m/d/Y', strtotime(@$value->date)) }}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_total_label')}} : </span>{{@$value->email}}</div>
                                          <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.status_label')}} : </span>
                                            @if(@$value->status=='N')
                                            {{__('profile.puja_status_new')}}
                                            @elseif(@$value->status=='C')
                                            {{__('profile.puja_status_complete')}}
                                            @elseif(@$value->status=='CA')
                                            {{__('profile.puja_status_cancel')}}
                                            @elseif(@$value->status=='I')
                                            {{__('profile.puja_status_incomplete')}}
                                            @elseif(@$value->status=='IP')
                                            Inprocess
                                            @elseif(@$value->status=='A')
                                            Accepted
                                            @endif
                                        </div>
                                        <div class="cell amunt-detail cess">
                                        <span class="hide_big">{{__('profile.action')}}:</span>
                                        <div class="add_ttrr actions-main">
                                                       <a href="javascript:void(0);" class="action-dots" id="action{{@$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$value->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                        <ul>
                                                           <li><a href="{{route('user.manage.horoscope.order.details',['id'=>@$value->order_id])}}" >View</a></li>
                                                          </ul>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                @endforeach
                                @else
                                <div class="row small_screen2 scernexr" >
                                    No Order Found
                                </div>
                                @endif
                            </div>
                            <section class="pagination-sec">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-9 offset-lg-3">
                                            <nav aria-label="Page navigation example" class="list-pagination">
                                                <ul class="pagination justify-content-end">
                                                    {{@$data->links()}}
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
                <h1>My Order</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
					<form action="{{route('user.manage.horoscope.order')}}" method="POST" id="filter">
                        @csrf
                        <input type="hidden" name="page" value="" id="page">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="form_box_area">
                                    <label>Order No</label>
                                    <input type="text" placeholder="Enter order no" name="order_no" value="{{@$request['order_no']}}"> </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form_box_area">
                                    <label>Order Date</label>
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
                            {{-- <div class="col-md-4 col-sm-6">
                                <div class="form_box_area">
                                    <label>{{__('profile.status_label')}}</label>
                                    <select name="status">
                                        <option value="">{{__('profile.any_status')}}</option>
                                        <option value="I" @if( @$request['status'] == 'I') selected @endif>{{__('profile.puja_status_new')}}</option>
                                        <option value="C" @if( @$request['status'] == 'C') selected @endif>{{__('profile.puja_status_complete')}}</option>
                                        <option value="CA" @if( @$request['status'] == 'CA') selected @endif>{{__('profile.puja_status_incomplete')}}</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-12 col-sm-12">
                                <div class="add_btnbx">
                                    <a href="javascript:;" class="res search">{{__('profile.search_label')}}</a>
                                </div>
                                <div class="add_btnbx">
                                    <a href="{{route('user.manage.horoscope.order')}}" class="res">{{__('profile.cancel')}}</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                    <div class="details-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">Order Id</div>
                                    <div class="cell amunt cess">Person Name</div>
                                    <div class="cell amunt cess">Horoscope Name</div>
                                    <div class="cell amunt cess">Order Date</div>
                                    <div class="cell amunt cess">Email </div>
                                    <div class="cell amunt cess">Status</div>
                                    <div class="cell amunt cess actn">{{__('profile.action_label')}}</div>

                            </div>
                            @if(@$data->isNotEmpty())
                                @foreach (@$data as $value)
                                    <div class="row small_screen2 scernexr">
                                        <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_no_label')}} : </span> {{@$value->order_id}}</div>
                                        <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_name_label')}} : </span>{{@$value->name}}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.pandit_name_label')}} : </span>{{@$value->horoscope->name}}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.puja_date_label')}} : </span>{{ date('m/d/Y', strtotime(@$value->date)) }}</div>
                                         <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.order_total_label')}} : </span>{{@$value->email}}</div>
                                          <div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.status_label')}} : </span>
                                            @if(@$value->status=='N')
                                            {{__('profile.puja_status_new')}}
                                            @elseif(@$value->status=='C')
                                            {{__('profile.puja_status_complete')}}
                                            @elseif(@$value->status=='CA')
                                            {{__('profile.puja_status_cancel')}}
                                            @elseif(@$value->status=='I')
                                            {{__('profile.puja_status_incomplete')}}
                                            @elseif(@$value->status=='IP')
                                            Inprocess
                                            @elseif(@$value->status=='A')
                                            Accepted
                                            @endif
                                        </div>
                                        <div class="cell amunt-detail cess">
                                        <span class="hide_big">{{__('profile.action')}}:</span>
                                        <div class="add_ttrr actions-main">
                                                       <a href="javascript:void(0);" class="action-dots" id="action{{@$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$value->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                        <ul>
                                                           <li><a href="{{route('user.manage.horoscope.order.details',['id'=>@$value->order_id])}}" >View</a></li>
                                                          </ul>
                                                      </div>
                                                    </div>
                                                </div>
                                            </div>
                                       {{--  <<div class="cell amunt-detail cess"> <span class="hide_big">{{__('profile.action_label')}} : </span>
                                            <p class="table-actions">
                                                <a href="{{route('customer.puja.history.view',['id'=>@$puja->order_id])}}" data-toggle="tooltip" data-placement="top" title="View"><i class="fa fa-eye"></i></a>
                                                <a href="#" data-toggle="tooltip" data-placement="top" title="Cancel"><i class="fa fa-times"></i></a>
                                                @if(@$puja->is_customer_review=='N' && @$puja->user_id!="")
                                                <a href="{{route('customer.review.puja.view',['id'=>@$puja->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review"> <i class="fa fa-commenting-o"></i></a>
                                                @endif
                                            </p>
                                        </div>
                                    </div> --}}
                                @endforeach
                                @else
                                <div class="row small_screen2 scernexr" >
                                    No Order Found
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
                                            {{@$data->links()}}
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
      @foreach (@$data as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>
@endsection