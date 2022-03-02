@extends('layouts.app')

@section('title')
<title>My Order</title>
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
                        <h2> My Order </h2>
                    </div> @include('includes.message')
                    <div class="cus-rightbody">
                        <form action="{{route('customer.order')}}" method="POST" id="filter">
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
                                    {{-- <div class="add_btnbx">
                                        <a href="{{route('customer.call')}}" class="res">{{__('profile.cancel')}}</a>
                                    </div> --}}
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                        <div class="details-table">
                            <div class="table-cus">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">Order No </div>
                                    <div class="cell amunt cess">Order Date</div>
                                    <div class="cell amunt cess">Total Amount</div>
                                    <div class="cell amunt cess">Status</div>
                                    <div class="cell amunt cess">Payment Type</div>
                                    {{-- <div class="cell amunt cess">{{__('profile.call_rate_label')}}</div>
                                    <div class="cell amunt cess">{{__('profile.order_total_label')}}</div>
                                    <div class="cell amunt cess">{{__('profile.call_status')}}</div> --}}
                                    <div class="cell amunt cess actn">{{__('profile.action')}}</div>

                                </div>
                                @if(@$allOrder->isNotEmpty())
                                @foreach (@$allOrder as $order)
                                <div class="row small_screen2 scernexr">
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Order No :</span> <a href="{{route('customer.order.details',['slug'=>@$order->order_id])}}" > {{@$order->order_id}} </a></div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Order Date:</span>{{ date('m/d/Y', strtotime(@$order->date)) }}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Total Amount:</span>
                                        {{@$order->currencyDetails->currency_code}} {{@$order->total_rate}}
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Status:</span>
                                        @if(@$order->status=='I')
                                            Incomplete
                                            @elseif(@$order->status=='N')
                                            New
                                            @elseif(@$order->status=="C")
                                            Complete
                                            @elseif(@$order->status=="CA")
                                            Cancel
                                            @elseif(@$order->status=="IP")
                                            In Progress
                                            @elseif(@$order->status=="D")
                                            Delivered
                                            @elseif(@$order->status=="OD")
                                            Out of Delivery
                                            @endif
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Payment Type:</span>
                                        @if(@$order->payment_type=='W')
                                        {{__('profile.call_status_new')}}
                                        @elseif(@$order->payment_type=='O')
                                        Online
                                        @elseif(@$order->payment_type=='COD')
                                        Cash On Delivery
                                        @endif
                                    </div>
                                    <div class="cell amunt-detail cess"><span class="hide_big">{{__('profile.action')}}:</span>
                                        <div class="add_ttrr actions-main">
                                            <a href="javascript:void(0);" class="action-dots" id="action{{@$order->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                            <div class="show-actions" id="show-{{@$order->id}}" style="display: none;">
                                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                <ul>
                                                    <li><a href="{{route('customer.order.details',['slug'=>@$order->order_id])}}" >View</a></li>
                                                    @if((@$order->status=='N' || @$order->status=='IP') && (date('Y-m-d H:i:s') < date('Y-m-d H:i:s',strtotime($order->date."+48 hours"))))
                                                    <li><a href="{{route('customer.order.cancel',['slug'=>@$order->order_id])}}" onclick="return confirm('Do you want to Cancel this Order?')">Cancel Order</a></li>
                                                    @endif
                                                    @if(@$order->is_customer_review=='N' && $order->status=='D')
                                                    <li> <a href="{{route('customer.order.review',['slug'=>@$order->order_id])}}" >Post Review</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="cell amunt-detail cess"> <span class="hide_big">Action:</span>
                                        <p class="table-actions">
                                        <a href="{{route('customer.order.details',['slug'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="view"><i class="fa fa-eye"></i></a>

                                        @if(@$order->is_customer_review=='N' && $order->status=='D')
                                        <a href="{{route('customer.order.review',['slug'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review"> <i class="fa fa-commenting-o"></i></a>
                                        @endif
                                        </p>
                                    </div> --}}
                                </div>
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
                                                {{@$allOrder->links()}}
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
                <h1>My Order</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
					<form action="{{route('customer.order')}}" method="POST" id="filter">
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
                                    <a href="{{route('customer.call')}}" class="res">{{__('profile.cancel')}}</a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                    <div class="details-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">Order No </div>
                                <div class="cell amunt cess">Order Date</div>
                                <div class="cell amunt cess">Total Amount</div>
                                <div class="cell amunt cess">Status</div>
                                <div class="cell amunt cess">Payment Type</div>
                                {{-- <div class="cell amunt cess">{{__('profile.call_rate_label')}}</div>
                                <div class="cell amunt cess">{{__('profile.order_total_label')}}</div>
                                <div class="cell amunt cess">{{__('profile.call_status')}}</div> --}}
                                <div class="cell amunt cess actn">{{__('profile.action')}}</div>

                            </div>
                            @if(@$allOrder->isNotEmpty())
                            @foreach (@$allOrder as $order)
                            <div class="row small_screen2 scernexr">
                                <div class="cell amunt-detail cess"> <span class="hide_big">Order No :</span> {{@$order->order_id}}</div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Order Date:</span>{{ date('m/d/Y', strtotime(@$order->date)) }}</div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Total Amount:</span>
                                    {{@$order->currencyDetails->currency_code}} {{@$order->total_rate}}
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Status:</span>
                                    @if(@$order->status=='I')
                                        Incomplete
                                        @elseif(@$order->status=='N')
                                        New
                                        @elseif(@$order->status=="C")
                                        Complete
                                        @elseif(@$order->status=="CA")
                                        Cancel
                                        @elseif(@$order->status=="IP")
                                        In Progress
                                        @elseif(@$order->status=="D")
                                        Delivered
                                        @elseif(@$order->status=="OD")
                                        Out of Delivery
                                        @endif
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Payment Type:</span>
                                    @if(@$order->payment_type=='W')
                                    {{__('profile.call_status_new')}}
                                    @elseif(@$order->payment_type=='O')
                                    Online
                                    @elseif(@$order->payment_type=='COD')
                                    Cash On Delivery
                                    @endif
                                </div>
                                <div class="cell amunt-detail cess"><span class="hide_big">{{__('profile.action')}}:</span>
                                    <div class="add_ttrr actions-main">
                                        <a href="javascript:void(0);" class="action-dots" id="action{{@$order->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                        <div class="show-actions" id="show-{{@$order->id}}" style="display: none;">
                                            <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                            <ul>
                                                <li><a href="{{route('customer.order.details',['slug'=>@$order->order_id])}}" >View</a></li>
                                                @if((@$order->status=='N' || @$order->status=='IP') && (date('Y-m-d H:i:s') < date('Y-m-d H:i:s',strtotime($order->date."+48 hours"))))
                                                <li><a href="{{route('customer.order.cancel',['slug'=>@$order->order_id])}}" onclick="return confirm('Do you want to Cancel this Order?')">Cancel Order</a></li>
                                                @endif
                                                @if(@$order->is_customer_review=='N' && $order->status=='D')
                                                <li> <a href="{{route('customer.order.review',['slug'=>@$order->order_id])}}" >Post Review</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="cell amunt-detail cess"> <span class="hide_big">Action:</span>
                                    <p class="table-actions">
                                    <a href="{{route('customer.order.details',['slug'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="view"><i class="fa fa-eye"></i></a>

                                    @if(@$order->is_customer_review=='N' && $order->status=='D')
                                    <a href="{{route('customer.order.review',['slug'=>@$order->order_id])}}" data-toggle="tooltip" data-placement="top" title="Post Review"> <i class="fa fa-commenting-o"></i></a>
                                    @endif
                                    </p>
                                </div> --}}
                            </div>
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
                                            {{@$allOrder->links()}}
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
<script type="text/javascript">
    @foreach (@$allOrder as $value)

      $("#action{{$value->id}}").click(function(){
          $('.show-actions:not(#show-{{$value->id}})').slideUp();
          $("#show-{{$value->id}}").slideToggle();
      });
   @endforeach
   </script>
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

@endsection
