@extends('layouts.app')

@section('title')
<title>{{__('profile.post_review_label')}}</title>
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
                        <h2>{{__('profile.post_review_label')}} </h2>
                    </div>
                    <div class="cus-rightbody">@include('includes.message')
                    	<form id="review_form" action="{{route('customer.post.review')}}" method="post">
                    		@csrf

						<div class="astro-dash-form">
							<div class="post-review-sec">
								<div class="u_ran">
								   <ul>
								   		{{-- <li><span><img src="{{asset('public/frontend/images/u.png')}}"></span> <label> {{@$data->astrologer->first_name}} {{@$data->astrologer->last_name}} </label></li> --}}
									  	<li><span><img src="{{asset('public/frontend/images/c.png')}}"></span> <label>{{ date('F j, Y', strtotime(@$data->date)) }} </label></li>
									  	<li><span><img src="@if(@$data->order_type=='C'){{asset('public/frontend/images/call1.png')}} @else{{asset('public/frontend/images/puja.png')}} @endif "></span><label>Review for @if(@$data->order_type=='C') Call @elseif(@$data->order_type=='P') {{@$data->pujas->puja_name}} @endif</label></li>
								   </ul>
								</div>
								<div class="rating_post_mainBox">
								 	<label>{{__('profile.rating_lebel')}}</label>
									   <ul>
									      <li><a href="#" onclick="fair(1)"><img id="f1" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="#" onclick="fair(2)"><img id="f2" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="#" onclick="fair(3)"><img id="f3" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="#" onclick="fair(4)"><img id="f4" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <li><a href="#" onclick="fair(5)"><img id="f5" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
										  <input type="hidden" id="fair_value" name="fair_value" required>
									   </ul>

	                                <div class="form_box_area your-rviewBox">
	                                    <label>{{__('profile.your_review')}}</label>
	                                    <textarea placeholder="{{__('profile.type_here_placeholder')}}" name="review"></textarea>
	                                </div>
	                                <input type="hidden" name="order_id" value="{{@$data->id}}">
	                                <input type="hidden" name="from_user_id" value="{{@$data->customer_id}}">
	                                <input type="hidden" name="to_user_id" value="{{@$data->user_id}}">
                                    <input type="hidden" name="puja_id" value="{{@$data->puja_id}}">
                                    <input type="hidden" name="type" value="{{@$data->order_type}}">
								</div>
							</div>
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
                <h1>{{__('profile.post_review_label')}}</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
                    <form id="review_form" action="{{route('customer.post.review')}}" method="post">
                        @csrf

                    <div class="astro-dash-form">
                        <div class="post-review-sec">
                            <div class="u_ran">
                               <ul>
                                       {{-- <li><span><img src="{{asset('public/frontend/images/u.png')}}"></span> <label> {{@$data->astrologer->first_name}} {{@$data->astrologer->last_name}} </label></li> --}}
                                      <li><span><img src="{{asset('public/frontend/images/c.png')}}"></span> <label>{{ date('F j, Y', strtotime(@$data->date)) }} </label></li>
                                      <li><span><img src="@if(@$data->order_type=='A'||@$data->order_type=='V'||@$data->order_type=='C'){{asset('public/frontend/images/call1.png')}} @else{{asset('public/frontend/images/puja.png')}} @endif "></span><label>Review for @if(@$data->order_type=='A') Audio Call @elseif(@$data->order_type=='P') {{@$data->pujas->puja_name}} @elseif(@$data->order_type=='V') Video Call @elseif(@$data->order_type=='C') Chat @endif</label></li>
                               </ul>
                            </div>
                            <div class="rating_post_mainBox">
                                 <label>{{__('profile.rating_lebel')}}</label>
                                   <ul>
                                      <li><a href="#" onclick="fair(1)"><img id="f1" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="#" onclick="fair(2)"><img id="f2" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="#" onclick="fair(3)"><img id="f3" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="#" onclick="fair(4)"><img id="f4" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <li><a href="#" onclick="fair(5)"><img id="f5" src="{{asset('public/frontend/images/rating2.png')}}"></a></li>
                                      <input type="hidden" id="fair_value" name="fair_value" required>
                                   </ul>

                                <div class="form_box_area your-rviewBox">
                                    <label>{{__('profile.your_review')}}</label>
                                    <textarea placeholder="{{__('profile.type_here_placeholder')}}" name="review"></textarea>
                                </div>
                                <input type="hidden" name="order_id" value="{{@$data->id}}">
                                <input type="hidden" name="from_user_id" value="{{@$data->customer_id}}">
                                <input type="hidden" name="to_user_id" value="{{@$data->user_id}}">
                                <input type="hidden" name="puja_id" value="{{@$data->puja_id}}">
                                <input type="hidden" name="type" value="{{@$data->order_type}}">
                            </div>
                        </div>
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
                $('#review_form').validate({
                	ignore: "",
                    rules:{
                        review:{
                            required:true,
                         },

                        fair_value:{
                        	required:true
                        },


                    },
                    messages:{
                         review:{
                            required:"{{__('profile.review_required')}}",
                        },
                         fair_value:{
                            required:"{{__('profile.rating_required')}}",
						},
                    }
                    /////////
				});

            });
        </script>
<script type="text/javascript">
	function fair(id){
console.log(id);
if(id==1){
document.getElementById('f1').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f2').src='{{asset('public/frontend/images/rating2.png')}}';
document.getElementById('f3').src='{{asset('public/frontend/images/rating2.png')}}';
document.getElementById('f4').src='{{asset('public/frontend/images/rating2.png')}}';
document.getElementById('f5').src='{{asset('public/frontend/images/rating2.png')}}';
$('#fair_value').val(id);
}
if(id==2){
document.getElementById('f1').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f2').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f3').src='{{asset('public/frontend/images/rating2.png')}}';
document.getElementById('f4').src='{{asset('public/frontend/images/rating2.png')}}';
document.getElementById('f5').src='{{asset('public/frontend/images/rating2.png')}}';
$('#fair_value').val(id);
}
if(id==3){
document.getElementById('f1').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f2').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f3').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f4').src='{{asset('public/frontend/images/rating2.png')}}';
document.getElementById('f5').src='{{asset('public/frontend/images/rating2.png')}}';
$('#fair_value').val(id);
}
if(id==4){
document.getElementById('f1').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f2').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f3').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f4').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f5').src='{{asset('public/frontend/images/rating2.png')}}';
$('#fair_value').val(id);
}
if(id==5){
document.getElementById('f1').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f2').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f3').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f4').src='{{asset('public/frontend/images/rating1.png')}}';
document.getElementById('f5').src='{{asset('public/frontend/images/rating1.png')}}';
$('#fair_value').val(id);
}

}
</script>

@endsection
