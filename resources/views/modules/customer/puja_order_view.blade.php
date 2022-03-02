@extends('layouts.app')

@section('title')
<title>{{__('profile.puja_order_history_title')}}</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .u_ran ul li span {
        width: 169px;
    }
    span{
        font-weight: 600;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection

@section('body')
@if(Auth::user()->user_type=='C')
<section class="pad-114">
    <div class="dashboard-customer puja_or_pg">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="cus-dashboard-right">
						<div class="view-action-div">
						<h2>{{__('profile.puja_order_history')}}</h2>

						<ul class="view_action_icons">
						 @if(@$pujaDetails->is_customer_review=='N' && @$pujaDetails->user_id!="")
					   <li> <a href="{{route('customer.review.puja.view',['id'=>@$pujaDetails->order_id])}}" ><i class="fa fa-registered" aria-hidden="true"></i></a></li>
						@endif
						
						 </ul>
					   </div>
                    </div>@include('includes.message')
                    <div class="cus-rightbody">
                        <div class="astro-dash-pro-right" style="width: 100%">
							<div class="post-review-sec">
								<div class="u_ran">
                                <h1>Puja Details</h1>@include('includes.message')
								   <ul>
								   		<li><span>{{__('profile.order_no_label')}} </span> <label>: {{@$pujaDetails->order_id}}</label></li>
								   		{{-- <li><span>{{__('profile.pandit_name_label')}} </span> <label>: {{@$pujaDetails->pundit->first_name}} {{@$pujaDetails->pundit->last_name}}</label></li> --}}
                                        @if(@$pujaDetails->pujas->puja_id!="")
                                        <li><span>Puja Name </span> <label>: {{@$pujaDetails->pujas->pujaName->name }}</label></li>
                                        @endif
								   		<li><span>Puja Title </span> <label>: {{@$pujaDetails->pujas->puja_name }}</label></li>
								   		<li><span>Puja Code </span> <label>: {{@$pujaDetails->pujas->puja_code }}</label></li>
								   		<li><span>{{__('profile.puja_date_label')}} </span> <label>: {{date('m/d/Y', strtotime(@$pujaDetails->date))}}</label></li>
									  	<li><span>{{__('profile.order_total_label')}} </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->total_rate}}</label></li>
										<li><span>With Homam </span> <label> : @if(@$pujaDetails->is_homam=='Y') Yes @else No @endif </label></li>
										@if(@$pujaDetails->is_homam=='Y')
										<li><span>Homam Amount </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->homam_price}}</label></li>
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
                                            @elseif(@$pujaDetails->status=='A')
                                            Accepted
                                            @elseif(@$pujaDetails->status=='IP')
                                            Inprocess
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
										@if(@$pujaDetails->puja_type=='OFFLINE')
										<li><span>Puja Address </span> <label>
										{{@$pujaDetails->p_google_address}}
                                        </label></li>

                                        @if(@$pujaDetails->puja_zip!="")
                                        <li><span>Puja Zipcode </span> <label>:
                                        {{@$pujaDetails->puja_zip}}
                                        </label></li>
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

										@endif

                                       <li><span>Refundable </span> <label>:
                                        @if(@$pujaDetails->pujas->refundable=="Y")Yes @else No @endif
                                        </label></li>
                            
                                        @if(@$pujaDetails->pujas->refundable=="Y")
                                        <li><span>Refundable Status </span> <label>:
                                                    @if(@$pujaDetails->pujas->refundable_status=="E")Exchange Only @elseif(@$pujaDetails->pujas->refundable_status=="'FR") Fully Refundable @elseif(@$pujaDetails->pujas->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif
                                                    </label></li>
                                        @endif 


                                         @if(@$pujaDetails->review->ratting_number!="" && @$pujaDetails->review->review_message!="")
                                        <li><span> {{__('profile.rating_lebel')}} : </span> :<label>

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

                                        @if(@$pujaDetails->final_puja_link!="" && @$pujaDetails->final_puja_notes!="")
                                        <li style="margin-top: 25px;"><span>Puja Link</span>
                                           <p><a href="{{@$pujaDetails->final_puja_link}}" class="color_an">{{@$pujaDetails->final_puja_link}}</a></p>
                                        </li>

                                        <li style="margin-top: 15px;"><span>Puja Notes</span>
                                           <p>{{@$pujaDetails->final_puja_notes}}</p>
                                        </li>

                                        @endif
								   </ul>
								</div>
							</div>
						</div>

                   @if(@$pujaDetails->user_id!="" && @$pujaDetails->pundit_accepted=="Y")
                  <div class="astro-dash-pro-right" style="width: 100%">
                        <form>
                        <div class="astro-dash-form">
                            <div class="post-review-sec">
                                <div class="u_ran">
                                    <h1>Pundit Details</h1>@include('includes.message')

                                   <ul>
                                        @if(@$pujaDetails->pundit_accepted=="Y")
                                        <li><span>Pundit Name </span> <label>: {{@$pujaDetails->pundit->first_name}} {{@$pujaDetails->pundit->last_name}}</label></li>
                                        @endif
                                        {{-- <li><span>Pundit Email </span> <label>: {{@$pujaDetails->pundit->email}}</label></li> --}}
                                       {{--  <li><span>Custome Mobile No </span> <label>: {{@$pujaDetails->pundit->mobile}}</label></li>

                                        @if(@$pujaDetails->pundit->address!="")
                                        <li><span>Pundit Address </span> <label>: {{@$pujaDetails->pundit->address}}</label></li>
                                        @endif

                                        @if(@$pujaDetails->pundit->profile_img!="")
                                        <li><span>Profile Image </span><img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$pujaDetails->pundit->profile_img}}" style="width: 200px;height: 200px;margin-top: 3px"></li>
                                        @endif --}}





                                   </ul>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
            @endif

                <div class="astro-dash-pro-right" style="width: 100%; margin-top: 25px;">
                    <form>
                        <div class="astro-dash-form">
                            <div class="post-review-sec">
                                <div class="u_ran">
                                     <h1>Person Name For Puja</h1>@include('includes.message')
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
                    </form>
                </div>
				<div class="astro-dash-pro-right" style="width: 100%; margin-top: 25px;">
                    <form>
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
                    </form>
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
                <div class="post-review-sec">
                    <div class="u_ran">
                    <h1>Puja Details</h1>@include('includes.message')
                       <ul style="margin-top: 16px;">
                               <li><span>{{__('profile.order_no_label')}} </span> <label>: {{@$pujaDetails->order_id}}</label></li>
                               {{-- <li><span>{{__('profile.pandit_name_label')}} </span> <label>: {{@$pujaDetails->pundit->first_name}} {{@$pujaDetails->pundit->last_name}}</label></li> --}}
                               @if(@$pujaDetails->pujas->puja_id!="")
                                        <li><span>Puja Name </span> <label>: {{@$pujaDetails->pujas->pujaName->name }}</label></li>
                                        @endif
                                        <li><span>Puja Title </span> <label>: {{@$pujaDetails->pujas->puja_name }}</label></li>
                               <li><span>Puja Code </span> <label>: {{@$pujaDetails->pujas->puja_code }}</label></li>
                               <li><span>{{__('profile.puja_date_label')}} </span> <label>: {{date('m/d/Y', strtotime(@$pujaDetails->date))}}</label></li>
                              <li><span>{{__('profile.order_total_label')}} </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->total_rate}}</label></li>
                            <li><span>With Homam </span> <label> : @if(@$pujaDetails->is_homam=='Y') Yes @else No @endif </label></li>
                            @if(@$pujaDetails->is_homam=='Y')
                            <li><span>Homam Amount </span> <label> : {{@$pujaDetails->currencyDetails->currency_code}} {{@$pujaDetails->homam_price}}</label></li>
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
                                @elseif(@$pujaDetails->status=='A')
                                Accepted
                                @elseif(@$pujaDetails->status=='IP')
                                Inprocess
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
                            @if(@$pujaDetails->puja_type=='OFFLINE')
                            <li><span>Puja Address </span> <label>
                            {{@$pujaDetails->p_google_address}}
                            </label></li>

                            @if(@$pujaDetails->puja_zip!="")
                                        <li><span>Puja Zipcode </span> <label>:
                                        {{@$pujaDetails->puja_zip}}
                                        </label></li>
                                        @endif

                            @if(@$pujaDetails->puja_landmark!="")
                            <li><span>Puja Landmark </span> <label>:
                            {{@$pujaDetails->puja_landmark}}
                            </label></li>
                            @endif
                            @if(@$pujaDetails->puja_house_no!="")
                            <li><span>House No / Flat No </span> <label> :
                            {{@$pujaDetails->puja_house_no}}
                            </label></li>
                            @endif

                            <li><span>Refundable </span> <label>:
                                        @if(@$pujaDetails->pujas->refundable=="Y")Yes @else No @endif
                                        </label></li>
                            @if(@$pujaDetails->pujas->refundable=="Y")
                            <li><span>Refundable Status </span> <label>:
                                        @if(@$pujaDetails->pujas->refundable_status=="E")Exchange Only @elseif(@$pujaDetails->pujas->refundable_status=="'FR") Fully Refundable @elseif(@$pujaDetails->pujas->refundable_status=="'PR") Partially Refundable @else Non Refundable @endif
                                        </label></li>
                            @endif            

                            @endif
                             @if(@$pujaDetails->review->ratting_number!="" && @$pujaDetails->review->review_message!="")
                            <li><span> {{__('profile.rating_lebel')}} : </span> :<label>

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

                            @if(@$pujaDetails->final_puja_link!="" && @$pujaDetails->final_puja_notes!="")
                            <li style="margin-top: 25px;"><span>Puja Link</span>
                               <p><a href="{{@$pujaDetails->final_puja_link}}" class="color_an">{{@$pujaDetails->final_puja_link}}</a></p>
                            </li>

                            <li style="margin-top: 15px;"><span>Puja Notes</span>
                               <p>{{@$pujaDetails->final_puja_notes}}</p>
                            </li>

                            @endif
                       </ul>
                    </div>
                </div>
                @if(@$pujaDetails->user_id!="" && @$pujaDetails->pundit_accepted=="Y")
                <div class="astro-dash-form">
                    <div class="post-review-sec">
                        <div class="u_ran">
                            <h1>Pundit Details</h1>@include('includes.message')
                            <ul style="margin-top: 16px;">
                                @if(@$pujaDetails->pundit_accepted=="Y")
                                <li><span>Pundit Name </span> <label>: {{@$pujaDetails->pundit->first_name}} {{@$pujaDetails->pundit->last_name}}</label></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                <div class="astro-dash-form">
                    <div class="post-review-sec">
                        <div class="u_ran">
                             <h1>Person Name For Puja</h1>@include('includes.message')
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
@endif
@endsection
@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
<script>
$(document).ready(function(){
	$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });
});
</script>
@endsection
