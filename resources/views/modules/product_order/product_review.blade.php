@extends('layouts.app')

@section('title')
<title>Post Review Product Order</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
    .u_ran {
    margin-top: 0px;
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
                        <h2>Post Review Product Order </h2>
                    </div>
                    <div class="cus-rightbody">@include('includes.message')
                    	<form id="review_form" action="{{route('customer.order.post.review')}}" method="post">
                    		@csrf
                            <input type="hidden" name="order_id" value="{{@$data->id}}">
						<div class="astro-dash-form">
							<div class="post-review-sec">
                                @foreach ($data->orderDetails as $key=>$item)
								<div class="u_ran">
								   <ul>
								   		<li>Order No : <label> {{@$data->order_id}} </label></li>
                                       
								   		<li>Product Name :<label> @if(@$item->product->product_type=="AS") {{@$item->product->product_name}} @elseif(@$item->product->product_type=="GS")
                                            @if(@$item->product->title_id!="")  {{@$item->product->title->title}} @if(@$item->product->subtitle_id) / {{@$item->product->subtitle->title}} @endif / {{@$item->product->product_code}}  @else {{@$item->product->product_name}} / {{@$item->product->product_code}}  @endif
                                         @endif </label></li>
								   		<li>Total Price : <label> {{@$item->total_price}} </label></li>
									  	{{-- <li><span><img src="{{asset('public/frontend/images/c.png')}}"></span> <label>{{ date('F j, Y', strtotime(@$data->date)) }} </label></li>
									  	<li><span><img src="{{asset('public/frontend/images/call1.png')}}"></span><label>Review for @if(@$data->order_type=='C') Call @elseif(@$data->order_type=='P')Puja @endif</label></li> --}}
								   </ul>
								</div>


								<div class="rating_post_mainBox">
								 	<label>{{__('profile.rating_lebel')}}</label>
									   <ul>
									      <li><a href="javascript:;" onclick="fair(1,{{$key}})"><img id="f1{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="javascript:;" onclick="fair(2,{{$key}})"><img id="f2{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="javascript:;" onclick="fair(3,{{$key}})"><img id="f3{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="javascript:;" onclick="fair(4,{{$key}})"><img id="f4{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="javascript:;" onclick="fair(5,{{$key}})"><img id="f5{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <input type="hidden" id="multi{{$key}}" name="multi[{{$key}}][rating]" class="rating">
									   </ul>
                                       <input type="hidden" name="multi[{{$key}}][product_id]" value="{{@$item->product_id}}">

	                                <div class="form_box_area your-rviewBox">
	                                    <label>{{__('profile.your_review')}}</label>
	                                    <textarea placeholder="{{__('profile.type_here_placeholder')}}" name="multi[{{$key}}][review]" class="review"></textarea>
	                                </div>
	                                {{-- <input type="hidden" name="order_id" value="{{@$data->id}}">
	                                <input type="hidden" name="from_user_id" value="{{@$data->customer_id}}">
	                                <input type="hidden" name="to_user_id" value="{{@$data->user_id}}"> --}}
								</div>



							</div>
                            @endforeach
							<div class="subbtn-sec">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" value="Post Your Review" class="subBtn"> </div>
                                </div>
                            </div>
						</div>
					</form>
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
                <h1>Post Review Product Order</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
					<form id="review_form" action="{{route('customer.order.post.review')}}" method="post">
                        @csrf
                        <input type="hidden" name="order_id" value="{{@$data->id}}">
                    <div class="astro-dash-form">
                        <div class="post-review-sec">
                            @foreach ($data->orderDetails as $key=>$item)
                            <div class="u_ran">
                               <ul>
                                       <li>Order No : <label> {{@$data->order_id}} </label></li>
                                       
                                        <li>Product Name :<label> @if(@$item->product->product_type=="AS") {{@$item->product->product_name}} @elseif(@$item->product->product_type=="GS")
                                            @if(@$item->product->title_id!="")  {{@$item->product->title->title}} / {{@$item->product->subtitle->title}} / {{@$item->product->product_code}}  @else {{@$item->product->product_name}} / {{@$item->product->product_code}}  @endif
                                         @endif </label></li>
                                       <li>Total Price : <label> {{@$item->total_price}} </label></li>
                                      {{-- <li><span><img src="{{asset('public/frontend/images/c.png')}}"></span> <label>{{ date('F j, Y', strtotime(@$data->date)) }} </label></li>
                                      <li><span><img src="{{asset('public/frontend/images/call1.png')}}"></span><label>Review for @if(@$data->order_type=='C') Call @elseif(@$data->order_type=='P')Puja @endif</label></li> --}}
                               </ul>
                            </div>


                            <div class="rating_post_mainBox">
                                 <label>{{__('profile.rating_lebel')}}</label>
                                   <ul>
                                      <li><a href="javascript:;" onclick="fair(1,{{$key}})"><img id="f1{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="javascript:;" onclick="fair(2,{{$key}})"><img id="f2{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="javascript:;" onclick="fair(3,{{$key}})"><img id="f3{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="javascript:;" onclick="fair(4,{{$key}})"><img id="f4{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="javascript:;" onclick="fair(5,{{$key}})"><img id="f5{{$key}}" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <input type="hidden" id="multi{{$key}}" name="multi[{{$key}}][rating]" class="rating">
                                   </ul>
                                   <input type="hidden" name="multi[{{$key}}][product_id]" value="{{@$item->product_id}}">

                                <div class="form_box_area your-rviewBox">
                                    <label>{{__('profile.your_review')}}</label>
                                    <textarea placeholder="{{__('profile.type_here_placeholder')}}" name="multi[{{$key}}][review]" class="review"></textarea>
                                </div>
                                {{-- <input type="hidden" name="order_id" value="{{@$data->id}}">
                                <input type="hidden" name="from_user_id" value="{{@$data->customer_id}}">
                                <input type="hidden" name="to_user_id" value="{{@$data->user_id}}"> --}}
                            </div>



                        </div>
                        @endforeach
                        <div class="subbtn-sec">
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" value="Post Your Review" class="subBtn"> </div>
                            </div>
                        </div>
                    </div>
                </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
        $.validator.addMethod(
            "review", //name of a virtual validator
            $.validator.methods.required, //use the actual email validator
            "Please enter your review"
        );
        $.validator.addMethod(
            "rating", //name of a virtual validator
            $.validator.methods.required, //use the actual email validator
            "Please select your rating"
        );
        $.validator.addClassRules(
            "review", //your class name
            { review: true }
        );$.validator.addClassRules(
            "rating", //your class name
            { rating: true }
        );
                // $('#review_form').validate({});
        $('#review_form').validate({
            ignore: "",
        });

    });
</script>
<script type="text/javascript">
function fair(id,key){
    console.log(id);
    if(id==1){
        document.getElementById('f1'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f2'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        document.getElementById('f3'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        document.getElementById('f4'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        document.getElementById('f5'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        $('#multi'+key).val(id);
    }
    if(id==2){
        document.getElementById('f1'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f2'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f3'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        document.getElementById('f4'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        document.getElementById('f5'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        $('#multi'+key).val(id);
    }
    if(id==3){
        document.getElementById('f1'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f2'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f3'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f4'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        document.getElementById('f5'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        $('#multi'+key).val(id);
    }
    if(id==4){
        document.getElementById('f1'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f2'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f3'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f4'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f5'+key).src='{{asset('public/frontend/images/rating2.png')}}';
        $('#multi'+key).val(id);
    }
    if(id==5){
        document.getElementById('f1'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f2'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f3'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f4'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        document.getElementById('f5'+key).src='{{asset('public/frontend/images/rating1.png')}}';
        $('#multi'+key).val(id);
    }

}
</script>

@endsection
