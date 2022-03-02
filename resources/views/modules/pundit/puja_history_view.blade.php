@extends('layouts.app')

@section('title')
<title>{{__('profile.puja_details_title')}}</title>
@endsection
@section('style')
@include('includes.style')
<style>
    .u_ran ul li span {
        width: 169px;
    }
</style>
@endsection

@section('header')
{{-- @include('includes.heder_profile') --}}
@include('includes.header')
@endsection

@section('body')
<div class="dashboard_sec dashboard_sec_education puja_or_pg">
	<div class="container">
		<div class="dashboard_iner">
            @include('includes.profile_sidebar')
            <div class="astro-dash-pro-right">
                <div class="astro-dash-right_iner">
                    <div class="astro-dash-form">
                            <div class="post-review-sec">
                                <div class="u_ran">
								<div class="view-action-div">
									<h1>{{__('profile.puja_details')}}</h1>
									<ul class="view_action_icons">
									@if(date('m/d/Y', strtotime(@$pujaDetails->date))>=date('m/d/Y'))	
									  @if(@$pujaDetails->status=="N")
									  <li><a href="{{route('pundit.puja.accept',['id'=>@$pujaDetails->id])}}" onclick="return confirm('Do you want to accept this puja ?')"><i class="fa fa-check" aria-hidden="true"></i></a></li>
									  <li><a href="{{route('pundit.puja.reject',['id'=>@$pujaDetails->id])}}" onclick="return confirm('Do you want to reject this puja ?')"><i class="fa fa-times" aria-hidden="true"></i></a></li>
									  @endif

									  @if(@$pujaDetails->status=="A")
									  <li><a href="{{route('pundit.puja.inprocess',['id'=>@$pujaDetails->id])}}" onclick="return confirm('Do you want to mark this puja  in process ?')"><i class="fa fa-tasks" aria-hidden="true"></i></a></li>
									  @endif

									  @if(@$pujaDetails->status=="IP")
									  <li><a href="{{route('pundit.puja.complete',['id'=>@$pujaDetails->id])}}" onclick="return confirm('Do you want to mark this puja as complete ?')"><i class="fa fa-check-circle" aria-hidden="true"></i></a></li>
									  @endif
									  @endif
									 </ul>
								   </div>
                                    @include('includes.message')
                                   <ul>
                                        <li><span>{{__('profile.order_no_label')}} </span> <label>: {{@$pujaDetails->order_id}}</label></li>
                                        {{-- <li><span>{{__('profile.customer_name_label')}} </span> <label>: {{@$pujaDetails->customer->first_name}} {{@$pujaDetails->customer->last_name}}</label></li> --}}
                                        @if(@$pujaDetails->pujas->puja_id!="")
                                        <li><span>Puja Name </span> <label>: {{@$pujaDetails->pujas->pujaName->name }}</label></li>
                                        @endif
                                        <li><span>Puja Title </span> <label>: {{@$pujaDetails->pujas->puja_name }}</label></li>
                                        <li><span>Puja Code </span> <label>: {{@$pujaDetails->pujas->puja_code }}</label></li>
                                        <li><span>{{__('profile.puja_date_label')}} </span> <label>: {{date('m/d/Y', strtotime(@$pujaDetails->date))}}</label></li>
                                        <li><span>{{__('profile.order_total_label')}} </span> <label>: {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->total_rate}}</label></li>
										<li><span>With Homam </span> <label> : @if(@$pujaDetails->is_homam=='Y') Yes @else No @endif </label></li>
										@if(@$pujaDetails->is_homam=='Y')
										<li><span>Homam Amount </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}}  {{@$pujaDetails->homam_price}}</label></li>
										@endif
                                        <li><span>{{__('profile.puja_type_label')}} </span> <label>: {{@$pujaDetails->puja_type}}</label></li>





                                        <li><span>{{__('profile.status_label')}} </span> <label>:
                                            @if(@$pujaDetails->status=='I')
                                            {{__('profile.puja_status_incomplete')}}
                                            @elseif(@$pujaDetails->status=='N')
                                            {{__('profile.puja_status_new')}}
                                            @elseif(@$pujaDetails->status=='C')
                                            {{__('profile.puja_status_complete')}}
                                            @elseif(@$pujaDetails->status=='CA')
                                            {{__('profile.puja_status_cancel')}}
                                            @elseif(@$pujaDetails->status=='IP')
                                            Inprocess
                                            @elseif(@$pujaDetails->status=='A')
                                            Accepted
                                            @endif
                                        </label></li>





                                        <li><span>{{__('profile.payment_status')}} </span> <label>:
                                            @if(@$pujaDetails->payment_status=='I')
                                            {{__('profile.payment_status_initiated')}}
                                            @elseif(@$pujaDetails->payment_status=='P')
                                            {{__('profile.payment_status_paid')}}
                                            @elseif(@$pujaDetails->payment_status=='F')
                                            {{__('profile.payment_status_failed')}}
                                            @endif
                                        </label></li>


                                         @if(@$pujaDetails->puja_zip!="")
                                            <li><span>Zipcode</span> <label>: {{@$pujaDetails->puja_zip}}</label></li>

                                         @endif

                                         @if(@$pujaDetails->p_google_address!="")
                                            <li><span>Puja Address </span> <label> {{@$pujaDetails->p_google_address}}</label></li>

                                         @endif

                                        @if(@$pujaDetails->puja_landmark!="")
                                        <li><span>Puja Landmark </span> <label>:
                                        {{@$pujaDetails->puja_landmark}}
                                        </label></li>
                                        @endif
                                       
                                        @if(@$pujaDetails->puja_house_no!="")
                                        <li><span>House No / Flat No </span> <label>:
                                        {{@$pujaDetails->puja_house_no}}
                                        </label></li>
                                        @endif

                                        <li><span>With CD Recording Of Puja </span> <label> : @if(@$pujaDetails->is_cd=='Y') Yes @else No @endif </label></li>
                                        @if(@$pujaDetails->is_cd=='Y')
                                        <li><span>CD Recording Amount </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->cd_price}}</label></li>
                                        @endif

                                        <li><span>With Live Streaming Of Puja </span> <label> : @if(@$pujaDetails->is_live_streaming=='Y') Yes @else No @endif </label></li>
                                        @if(@$pujaDetails->is_live_streaming=='Y')
                                        <li><span> Live Streaming Amount </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->live_streaming_price}}</label></li>
                                        @endif

                                        <li><span>With Prasad Of Puja </span> <label> : @if(@$pujaDetails->is_prasad=='Y') Yes @else No @endif </label></li>
                                        @if(@$pujaDetails->is_prasad=='Y')
                                        <li><span> Prasad Amount </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->prasad_price}}</label></li>
                                        
                                        @endif

                                         @if(@$pujaDetails->delivery_prasad!="" && @$pujaDetails->is_prasad=='Y' && @$pujaDetails->delivery_of_prasad=="Y")
                                        <li><span>Tentative Prasad Delivery Date </span> <label> : Before {{date('F j, Y',strtotime(@$pujaDetails->delivery_prasad))}}</label></li>
                                        @endif

                                        @if(@$pujaDetails->is_prasad=='Y' && @$pujaDetails->delivery_of_prasad=="N")
                                        <li><span>Delivery Of Prasad Available</span> <label> : Not Available</label></li>
                                        @endif

                                        @if(@$pujaDetails->dakshina!=0)
                                        <li><span>Dakshina </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->dakshina}}</label></li>
                                        @endif

                                         


                                         @if(@$pujaDetails->final_puja_link!="" && @$pujaDetails->final_puja_notes!="")
                                        <li style="margin-top: 25px;"><span>Puja Link</span>
                                           <p><a href="{{@$pujaDetails->final_puja_link}}" class="color_an">{{@$pujaDetails->final_puja_link}}</a></p>
                                        </li>

                                        <li style="margin-top: 15px;"><span>Puja Notes</span>
                                           <p>{{@$pujaDetails->final_puja_notes}}</p>
                                        </li>

                                        @endif


                                        @if(@$pujaDetails->review->ratting_number!="" && @$pujaDetails->review->review_message!="")
                                        <li><span> {{__('profile.rating_lebel')}} </span> :<label>

                                             @for($i=0;$i<=($pujaDetails->review->ratting_number-1);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/rating1.png')}}"></a>

                                              @endfor
                                            @for($i=0;$i<(5-$pujaDetails->review->ratting_number);$i++)
                                                <a href="#url"><img src="{{asset('public/frontend/images/rating2.png')}}"></a>
                                            @endfor
                                        </label>
                                        </li>



                                        <li><span> {{__('profile.review_lebel')}}</span> :
                                           {{@$pujaDetails->review->review_message}}
                                        </li>
                                        @endif


                                   </ul>
                                </div>
                            </div>
                        </div>

                        <div class="astro-dash-form">
                            <div class="post-review-sec">
                                <div class="u_ran">
                                    <h1>Customer Details</h1>
                                   <ul>
                                        <li><span>Customer Name </span> <label>: {{@$pujaDetails->customer->first_name}} {{@$pujaDetails->customer->last_name}}</label></li>
                                        {{-- <li><span>Customer Email </span> <label>: {{@$pujaDetails->customer->email}}</label></li> --}}
                                        @if(@$pujaDetails->puja_type=="OFFLINE")
                                        <li><span>Custome Mobile No </span> <label>: {{@$pujaDetails->customer->mobile}}</label></li>


                                        <li><span>Customer Address </span> <label>: @if(@$pujaDetails->customer->address!=""){{@$pujaDetails->customer->address}} @else --- @endif</label></li>

                                        @endif

                                       {{--  @if(@$pujaDetails->customer->profile_img!="")
                                        <li><span>Profile Image </span><img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$pujaDetails->customer->profile_img}}" style="width: 200px;height: 200px;margin-top: 3px"></li>
                                        @endif --}}





                                   </ul>
                                </div>
                            </div>
                        </div>

                        <div class="astro-dash-form">
                            <div class="post-review-sec">
                                <div class="u_ran">
                                    <h1>Person Name For Puja</h1>
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
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if(@$pujaNames->isNotEmpty())
                                                                    @foreach(@$pujaNames as $value)
                                                                    <tr>
                                                                        <td>{{@$value->name}}</td>

                                                                        <td>
                                                                            @if(@$value->gotra!="")
                                                                            {{@$value->gotra}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->janam_rashi_lagna!="")
                                                                            {{@$value->rashis->name}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->janama_nkshatra!="")
                                                                            {{@$value->nakshatras->name}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->dob!="")
                                                                            {{@$value->dob}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>

                                                                        <td>
                                                                            @if(@$value->place_of_residence !="")
                                                                            {{@$value->place_of_residence}}
                                                                            @else
                                                                            --
                                                                            @endif
                                                                        </td>


                                                                    </tr>
                                                                    @endforeach
                                                                    @else
                                                                    <tr><td>No Data</td></tr>
                                                                    @endif

                                                                </tbody>
                                                            </table>
                                                        </div>
                                </div>
                            </div>
                        </div>
						<div class="astro-dash-form">
                            <div class="post-review-sec">
                                <div class="u_ran">
                                    <h1>Additional Mantra Details</h1>
                                       <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Mantra</th>
																		<th>No of Recitals</th>
																		<th>Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(@$pujaDetails->mantraDetails->isNotEmpty())
																@foreach(@$pujaDetails->mantraDetails as $mantra)
																<tr>
																	<td>{{@$mantra->mantra->mantra}}</td>

																	<td>
																	{{@$mantra->no_of_recital}}
																	</td>

																	<td>
																		{{@$pujaDetails->currencyDetails->currency_code}} {{@$mantra->price}}
																	</td>


																</tr>
																@endforeach
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
@endsection
@section('footer')
@include('includes.footer')
@endsection
@section('script')
@include('includes.script')
@endsection
