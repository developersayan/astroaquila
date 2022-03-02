@extends('layouts.app')

@section('title')
<title>My Wishlist</title>
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
                        <h2> My Wishlist </h2>
                    </div> @include('includes.message')
                    <div class="cus-rightbody">
                        {{-- <form action="{{route('customer.order')}}" method="POST" id="filter">
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
                        </form> --}}
                        <div class="details-table">
                            <div class="table-cus">
                                <div class="row amnt-tble">
                                    <div class="cell amunt cess">Product Image</div>
                                    <div class="cell amunt cess">Product Name</div>
                                    <div class="cell amunt cess">Price</div>
                                    <div class="cell amunt cess actn">{{__('profile.action')}}</div>


                                </div>
                                @if(@$allFavorite->isNotEmpty())
                                @foreach (@$allFavorite as $favorite)
                                <div class="row small_screen2 scernexr">
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Product Name :</span> @if(@$favorite->product->product_type=="AP") {{@$favorite->product->product_name}} / {{@$favorite->product->product_code}}  @else @if(@$favorite->product->title_id) {{@$favorite->product->title->title}} @if(@$favorite->product->subtitle_id) / {{@$favorite->product->subtitle->title}} @endif / {{@$favorite->product->product_code}}  @else {{@$favorite->product->product_name}} / {{@$favorite->product->product_code}}@endif @endif
                                    </div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Product Name :</span> {{@$favorite->product->product_name}}</div>
                                    <div class="cell amunt-detail cess"> <span class="hide_big">Product Price :</span>
                                        @if(@session()->get('currency')==1)
                                        @if(@$favorite->product->discount_inr!=null && @$favorite->product->discount_inr>0)
                                        @php
                                        $old_price = $favorite->product->price_inr;
                                        $discount_value = ($old_price / 100) * @$favorite->product->discount_inr;
                                        $new_price = $old_price - $discount_value;
                                        @endphp
                                        <del>{{session()->get('currencySym').round(@$favorite->product->price_inr)}} </del>&nbsp;
                                        {{session()->get('currencySym').round(@$new_price,2)}}
                                        @else
                                        {{session()->get('currencySym').round(@$favorite->product->price_inr)}}
                                        @endif
                                        @elseif(@session()->get('currency')>=2)
                                        @if(@$favorite->product->discount_usd!=null && @$favorite->product->discount_usd>0)
                                        @php
                                        $old_price = $favorite->product->price_usd;
                                        $discount_value = ($old_price / 100) * @$favorite->product->discount_usd;
                                        $new_price = $old_price - $discount_value;
                                        @endphp
                                        <del>{{session()->get('currencySym').round(@$favorite->product->price_usd*currencyConversionCustom(),2)}} </del>&nbsp;
                                        {{session()->get('currencySym').round(@$new_price*currencyConversionCustom(),2)}}
                                        @else
                                        {{session()->get('currencySym').round(@$favorite->product->price_usd*currencyConversionCustom(),2)}}
                                        @endif
                                        @endif

                                    </div>
                                    <div class="cell amunt-detail cess"><span class="hide_big">Action :</span>
                                        <div class="add_ttrr actions-main">
                                            <a href="javascript:void(0);" class="action-dots" id="action{{@$favorite->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                            <div class="show-actions" id="show-{{@$favorite->id}}" style="display: none;">
                                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                <ul>
                                                    @if(@$favorite->product->product_type=="AP")
                                                    <li><a href="{{route('product.search.details',['slug'=>@$favorite->product->slug])}}" target="_blank">View</a></li>
                                                    @else
                                                    <li><a href="{{route('gemstone.details',['slug'=>@$favorite->product->slug])}}" target="_blank">View</a></li>
                                                    @endif
                                                    <li><a href="{{route('add.to.favorite',['id'=>@$favorite->product->id])}}">Remove wishlist</a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                                @else

                                <div class="row small_screen2 scernexr" >
                                    No item in wishlist
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
                                                {{@$allFavorite->links()}}
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
                <h1>My Wishlist</h1>
                @include('includes.message')
				<div class="astro-dash-right_iner">
                    <div class="details-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">Product Image</div>
                                <div class="cell amunt cess">Product Name</div>
                                <div class="cell amunt cess">Price</div>
                                <div class="cell amunt cess actn">{{__('profile.action')}}</div>
                            </div>
                            @if(@$allFavorite->isNotEmpty())
                            @foreach (@$allFavorite as $favorite)
                            <div class="row small_screen2 scernexr">
                                <div class="cell amunt-detail cess"> <span class="hide_big">Product Image :</span>
                                        <img src="@if(@$favorite->product->product_type=="AP"){{ URL::to('storage/app/public/small_product_image')}}/{{@$favorite->product->productdefault->image}} @else {{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$favorite->product->productdefault->image}}   @endif" style="width:65px;height: 68px">
                                    </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Product Name :</span> @if(@$favorite->product->product_type=="AP") {{@$favorite->product->product_name}} / {{@$favorite->product->product_code}}  @else @if(@$favorite->product->title_id) {{@$favorite->product->title->title}} @if(@$favorite->product->subtitle_id) / {{@$favorite->product->subtitle->title}} @endif / {{@$favorite->product->product_code}}  @else {{@$favorite->product->product_name}} / {{@$favorite->product->product_code}}@endif @endif</div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Product Price :</span>
                                    @if(@session()->get('currency')==1)
                                    @if(@$favorite->product->discount_inr!=null && @$favorite->product->discount_inr>0)
                                    @php
                                    $old_price = $favorite->product->price_inr;
                                    $discount_value = ($old_price / 100) * @$favorite->product->discount_inr;
                                    $new_price = $old_price - $discount_value;
                                    @endphp
                                    <del>{{session()->get('currencySym').round(@$favorite->product->price_inr)}} </del>&nbsp;
                                    {{session()->get('currencySym').round(@$new_price,2)}}
                                    @else
                                    {{session()->get('currencySym').round(@$favorite->product->price_inr)}}
                                    @endif
                                    @elseif(@session()->get('currency')>=2)
                                    @if(@$favorite->product->discount_usd!=null && @$favorite->product->discount_usd>0)
                                    @php
                                    $old_price = $favorite->product->price_usd;
                                    $discount_value = ($old_price / 100) * @$favorite->product->discount_usd;
                                    $new_price = $old_price - $discount_value;
                                    @endphp
                                    <del>{{session()->get('currencySym').round(@$favorite->product->price_usd*currencyConversionCustom(),2)}} </del>&nbsp;
                                    {{session()->get('currencySym').round(@$new_price*currencyConversionCustom(),2)}}
                                    @else
									{{session()->get('currencySym').round(@$favorite->product->price_usd*currencyConversionCustom(),2)}}
                                    @endif
                                    @endif

                                </div>
                                <div class="cell amunt-detail cess"><span class="hide_big">Action :</span>
                                    <div class="add_ttrr actions-main">
                                        <a href="javascript:void(0);" class="action-dots" id="action{{@$favorite->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                        <div class="show-actions" id="show-{{@$favorite->id}}" style="display: none;">
                                            <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                            <ul>
                                                @if(@$favorite->product->product_type=="AP")
                                                    <li><a href="{{route('product.search.details',['slug'=>@$favorite->product->slug])}}" target="_blank">View</a></li>
                                                    @else
                                                    <li><a href="{{route('gemstone.details',['slug'=>@$favorite->product->slug])}}" target="_blank">View</a></li>
                                                    @endif
                                                <li><a href="{{route('add.to.favorite',['id'=>@$favorite->product->id])}}">Remove wishlist</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="row small_screen2 scernexr" >
                                No item in wishlist
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
                                            {{@$allFavorite->links()}}
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
    @foreach (@$allFavorite as $value)

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
