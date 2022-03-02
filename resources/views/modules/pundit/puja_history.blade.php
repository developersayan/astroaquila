@extends('layouts.app')

@section('title')
<title>{{__('profile.puja_history_title')}}</title>
@endsection


@section('style')
@include('includes.style')
<style type="text/css">
    .error {
        color: red !important;
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
				<h1>{{__('profile.puja_history_title')}}</h1>@include('includes.message')
				<div class="astro-dash-right_iner">
					<form method="post" action="{{route('pundit.puja.history.search')}}" class="search_filter">
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
														<input type="text" name="from_date" value="{{request('from_date')}}" id="datepicker" placeholder="{{__('profile.from_placeholder')}}" class="position-relative from_date">

												</div>
												<div class="col-md-6 col-sm-6">
														<input type="text" name="to_date" value="{{request('to_date')}}" id="datepicker1" placeholder="{{__('profile.to_placeholder')}}" class="position-relative to_date">

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
												<option value="C" @if(request('status')=='C') selected @endif>Completed</option>
												<option value="IP" @if(request('status')=='IP') selected @endif>In Process</option>
												<option value="A" @if(request('status')=='A') selected @endif>Accepted</option>
												
										</select>
										</div>
									</div>

									<div class="col-md-12 col-sm-12">
										<div class="add_btnbx">
											<button class="res">{{__('profile.search_label')}}</button>
										</div>
										<div class="add_btnbx">
											<a href="{{route('pundit.puja.history')}}" class="res">{{__('profile.cancel')}}</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
						</div>
					</form>
					<div class="save_coniBx">

					</div>
					<div class="table_sec">
						<table class="table custom_table">
						  <thead class="thead-dark">
						    <tr>
						      <th scope="col">{{__('profile.order_no_label')}}</th>
						      {{-- <th scope="col">{{__('profile.date_label')}}</th> --}}
						      <th scope="col">Puja Title</th>
						      <th scope="col">{{__('profile.customer_name_label')}}</th>
						      <th scope="col">{{__('profile.puja_date_label')}}</th>
						      <th scope="col">{{__('profile.puja_type_label')}}</th>
						      <th scope="col">{{__('profile.order_total_label')}}</th>
						      <th scope="col">{{__('profile.status_label')}}</th>
						      <th scope="col">{{__('profile.action_label')}}</th>
						    </tr>
						  </thead>
						  <tbody>
						  	@if(@$pujas->isNotEmpty())
						  	@foreach(@$pujas as $puja)
						    <tr>
						      <td><a href="{{route('pundit.puja.history.view',['id'=>@$puja->order_id])}}" target="_blank"> {{@$puja->order_id}} </a></td>
						      <td>{{@$puja->pujas->puja_name}}</td>
						      <td>{{@$puja->customer->first_name}} {{@$puja->customer->last_name}}</td>
						      <td>{{date('m/d/Y', strtotime(@$puja->date))}}</td>
						      <td>{{@$puja->puja_type}}</td>
						      <td>{{@$puja->currencyDetails->currency_code}} {{@$puja->total_rate}}</td>
						      <td>
						      	@if(@$puja->status=='I')
						      	Incomplete
						      	@elseif(@$puja->status=='N')
						      	New
						      	@elseif(@$puja->status=='C')
						      	Completed
						      	@elseif(@$puja->status=='A')
						      	Accepted
						      	@elseif(@$puja->status=='CA')
						      	Cancel
						      	@elseif(@$puja->status=='IP')
						      	Inprocess
						      	@endif
							 </td>
						      <td>

						      	  <div class="add_ttrr actions-main">
                                                       <a href="javascript:void(0);" class="action-dots" id="action{{@$puja->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$puja->id}}" style="display: none;">
                                <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                        <ul>
                                                           <li><a href="{{route('pundit.puja.history.view',['id'=>@$puja->order_id])}}" target="_blank">View</a></li>
                                                          @if(date('m/d/Y', strtotime(@$puja->date))>=date('m/d/Y'))	
                                                          @if(@$puja->status=="N")
                                                          <li><a href="{{route('pundit.puja.accept',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to accept this puja ?')">Accept</a></li>
                                                          <li><a href="{{route('pundit.puja.reject',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to reject this puja ?')">Reject</a></li>
                                                          @endif

                                                          @if(@$puja->status=="A")
                                                          <li><a href="{{route('pundit.puja.inprocess',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to mark this puja  in process ?')">Mark as In Process</a></li>
                                                          @endif

                                                          @if(@$puja->status=="IP")
                                                          <li><a href="{{route('pundit.puja.complete',['id'=>@$puja->id])}}" onclick="return confirm('Do you want to mark this puja as complete ?')">Mark as Complete</a></li>
                                                          @endif
                                                          @endif
                                                         </ul>
                                                      </div>
                                                    </div>

							      	
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
                                                        {{@$pujas->links()}}
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
@endsection
@section('script')
@include('includes.script')
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
      @foreach (@$pujas as $puja)

    $("#action{{$puja->id}}").click(function(){
        $('.show-actions:not(#show-{{$puja->id}})').slideUp();
        $("#show-{{$puja->id}}").slideToggle();
    });
 @endforeach
</script>
@endsection
