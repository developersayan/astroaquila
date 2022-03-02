@extends('layouts.app')

@section('title')
<title>{{__('profile.customer_profile')}}</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }

</style>
<style>
    input[type=number] {
        height: 45px;
        width: 45px;
        font-size: 25px;
        text-align: center;
        border: 1px solid #000000;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.min.css') }}" rel="stylesheet" />
@endsection

@section('header')
{{-- @include('includes.heder_profile') --}}
@include('includes.header')
@endsection

@section('body')
<div class="dashboard_sec">
    <div class="container">
        <div class="dashboard_iner">
            @include('includes.profile_sidebar')

            <div class="astro-dash-pro-right">
				<h1>{{__('profile.basic_information')}}</h1>@include('includes.message')
				<div class="astro_bac_list">
					<ul>
						<li class="actv"><a href="{{route('astrologer.profile')}}">
							<img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
							<img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
						{{__('profile.basic_info')}}</a></li>
						<li><a href="{{route('astrologer.education')}}">
							<img src="{{ URL::to('public/frontend/images/bacicon2.png')}}" class="bacicon1" alt="">
							<img src="{{ URL::to('public/frontend/images/bacicon22.png')}}" class="bacicon2" alt="">
						{{__('profile.education')}}</a></li>
						<li><a href="{{route('astrologer.experience')}}">
							<img src="{{ URL::to('public/frontend/images/bacicon3.png')}}" class="bacicon1" alt="">
							<img src="{{ URL::to('public/frontend/images/bacicon33.png')}}" class="bacicon2" alt="">
						{{__('profile.experience_label')}}</a></li>
						<li><a href="{{route('astrologer.availability')}}">
							<img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
							<img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
						{{__('profile.availability')}}</a></li>
						<li><a href="{{route('astrologer.date.exclusion.list')}}">
                                <img src="{{ URL::to('public/frontend/images/declined-white.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/declined-color.png')}}" class="bacicon2" alt="">
                                Date Exclusion List</a></li>
					</ul>
				</div>
				<div class="astro-dash-right_iner">
					<form action="{{route('astrologer.profile.edit')}}" method="POST" enctype="multipart/form-data" id="edit_profile">
                        @csrf
						<div class="astro-dash-form">
							<div class="row">

								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>Code</label>
										<input type="text"placeholder="{{__('profile.first_name_placeholder')}} " value="{{ @$userData->user_unique_code}}" readonly>
									</div>
								</div>

								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>{{__('profile.first_name_label')}}</label>
										<input type="text"placeholder="{{__('profile.first_name_placeholder')}} " value="{{old('first_name', @$userData->first_name)}}" name="first_name">
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>{{__('profile.last_name_label')}}</label>
										<input type="text" placeholder="{{__('profile.last_name_placeholder')}} " value="{{old('last_name',@$userData->last_name)}}" name="last_name">
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>{{__('profile.email_address_label')}}
											<em class="tick_custom">
                                            @if(@$userData->is_email_verify=='Y')<i class="fa fa-check-circle-o" aria-hidden="true" style="color: green"></i> <span style="color: green">Verified</span> |
                                            <span data-toggle="modal" data-target="#exampleModalLong" style="cursor: pointer;">Edit</span>
                                            @elseif(@$userData->is_email_verify=='N')<i class="fa fa-ban" style="color: red"></i> <span style="color: red">Unverified</span> |
                                            <span data-toggle="modal" data-target="#exampleModalLong" style="cursor: pointer;">Edit</span>
                                            @endif
                                        </em>
                                        </label>
										<input type="text" placeholder="{{__('profile.email_address_placeholder')}} " value="{{@$userData->email}}" disabled>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>{{__('profile.mobile_number_label')}}
											<em class="tick_custom">
                                            @if(@$userData->is_mobile_verify=='Y')<i class="fa fa-check-circle-o" aria-hidden="true" style="color: green"></i> <span style="color: green">Verified</span> |  <a href="javascript:;" id="ch_mo"> Edit</a>
                                            @elseif(@$userData->is_mobile_verify=='N')<i class="fa fa-ban" style="color: red"></i> <span style="color: red">Unverified</span> |  <a href="javascript:;" id="ch_mo" > Edit</a>
                                            @endif
                                        </em>
                                        </label>
										<input type="text" placeholder="{{__('profile.mobile_number_placeholder')}} " value="{{@$userData->mobile}}" disabled>
									</div>
								</div>


								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>Number for Audio Call
											<em class="tick_custom">|
                                            <a href="javascript:;" id="ch_mo_audio" > Edit</a>
                                            </em>
                                        </label>
										<input type="text" placeholder="{{__('profile.mobile_number_placeholder')}} " value="{{@$userData->audio_mobile_no}}" disabled>
									</div>
								</div>








								<div class="col-md-4 col-sm-6">
									<div class="checkBox">
										<span>{{__('profile.gender_placeholder')}}</span>
										<ul>
											<li>
                                                <input type="radio" id="radio1" class="gender_select" name="gender" value="M" @if(@$userData->gender=='M' ||old('gender')=='M') checked="" @endif>
                                                <label for="radio1">{{__('profile.male_placeholder')}}</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio2" class="gender_select" name="gender" value="F" @if(@$userData->gender=='F'||old('gender')=='F') checked=""  @endif>
                                                <label for="radio2">{{__('profile.female_placeholder')}}</label>
                                            </li>
										</ul>
                                         <div><label id="gender-error" class="error" for="gender"></label></div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="form_box_area malti_select">
										<label>{{__('profile.language_speak_label')}} </label>
										<span class="autocomplete-select"></span>
                                        <label id="language-error" class="error" for="language" style="display: none;">{{__('profile.required_language')}}</label>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>{{__('profile.experience_label')}}</label>
										<input type="text" placeholder="{{__('profile.experience_placeholder')}}" value="{{old('experience',@$userData->experience)}}" name="experience">
									</div>
								</div>

								<div class="col-md-4 col-sm-6">
									<div class="form_box_area malti_select">
										<label>{{__('profile.expertise_label')}}</label>
										<span class="autocomplete-select1"></span>
                                        <label id="expertise-error" class="error" style="display: none;">{{__('profile.required_expertise')}}</label>
									</div>
								</div>


                                <div class="col-sm-12">
									<div class="uplodimg">
										<div class="uplodimgfil">
											<b>{{__('profile.upload_image_label')}}</b>
											{{-- <input type="file" name="profile_pic" id="profile_pic" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" accept="image/*" onchange="fun1()"/>
											<label for="profile_pic">{{__('profile.upload_profile_pic')}}<img src="{{ URL::to('public/frontend/images/clickhe.png')}}" alt=""></label> --}}
                                            <input type="hidden" name="profile_picture" id="profile_picture">
                                            <input type="file" id="file" name="profile_pic" >
                                            <label for="file">{{__('auth.upload_profile_pic')}}<img src="{{ URL::to('public/frontend/images/clickhe.png')}}" alt="" ></label>
										</div>
										<div class="uplodimgfilimg">
											<em><img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$userData->profile_img}}" alt="" id="img2"></em>
										</div>
									</div>
                                    <label for="profile_pic" id="image-error" class="error"></label>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="checkBox">
										<span>I want to offer my service</span>
										<ul>
											<li>
                                                <input type="radio" id="user_availability1" name="user_availability" value="Y" @if(@$userData->user_availability=='Y' || old('user_availability')=='Y') checked="" @endif>
                                                <label for="user_availability1">Yes</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="user_availability2" name="user_availability" value="N" @if(@$userData->user_availability=='N'|| old('user_availability')=='N') checked=""  @endif>
                                                <label for="user_availability2">No</label>
                                            </li>
										</ul>
									</div>
								</div>
								<div class="col-md-12 col-sm-12">
									<div class="form_box_area">
										<label>{{__('profile.about_label')}}</label>
										<textarea name="about" placeholder="{{__('profile.about_placeholder')}}">{{@$userData->about}}</textarea>
									</div>
								</div>
                                <div class="col-md-12 col-sm-12">
									<div class="form_box_area">
										<label>{{__('profile.why_who')}}</label>
										<textarea name="why_who" placeholder="{{__('profile.why_who')}}">{{@$userData->why_who}}</textarea>
									</div>
								</div>
							</div>


							<div class="addres_infor">
								<h4>Pricing Information</h4>
								<div class="col-md-12 col-sm-12">
									<div class="form_box_area">
										<div class="availability_check">
                                        <input id="audio_call_check" type="checkbox" value="audio_call_check" name="audio_call_check" @if(@$userData->is_audio_call=="Y") checked @endif>
                                        <label for="audio_call_check">I offer audio call</label>
                                      </div>

								</div>
								</div>



							<div class="row" id="audio_call_div" @if(@$userData->is_audio_call=="N") style="display: none;" @endif >
								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Price For Audio Call / min (Inr)</label>
										<input type="text" placeholder="Price For Audio Call/min (Inr)" @if(@$userData->call_price!=0)value="{{@$userData->call_price}}"   @endif name="call_price">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Price For Audio Call / min (Usd)</label>
										<input type="text" placeholder="Price For Audio Call/min (Usd)" @if(@$userData->call_price_usd!=0) value="{{@$userData->call_price_usd}}" @endif name="call_price_usd">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Discount For Audio Call / min (Inr)(%)</label>
										<input type="text" placeholder="Discount For Audio Call/min (Inr)"  value="{{@$userData->call_discount_inr}}" name="call_discount_inr">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Discount For Audio Call / min (Usd)(%)</label>
										<input type="text" placeholder="Discount For Audio Call/min (Usd)"  value="{{@$userData->call_discount_usd}}" name="call_discount_usd">
									</div>
								</div>



							</div>





							<div class="col-md-12 col-sm-12">
									<div class="form_box_area">
										<div class="availability_check">
                                        <input id="video_call_check" type="checkbox" value="video_call_check" name="video_call_check" @if(@$userData->is_video_call=="Y") checked @endif>
                                        <label for="video_call_check">I offer video call</label>
                                      </div>

								</div>
							</div>


								<div class="row" id="video_call_div" @if(@$userData->is_video_call=="N") style="display: none;" @endif>
								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Price For Video Call /min (Inr)</label>
										<input type="text" placeholder="Price For Video Call/min (Inr)" @if(@$userData->video_call_price_inr!=0) value="{{@$userData->video_call_price_inr}}" @endif name="video_call_price_inr">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Price For Video Call /min (Usd)</label>
										<input type="text" placeholder="Price For Video Call /min (Usd)" @if(@$userData->video_call_price_usd!=0) value="{{@$userData->video_call_price_usd}}" @endif name="video_call_price_usd">
									</div>
								</div>


								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Discount For Video Call / min (Inr)(%)</label>
										<input type="text" placeholder="Discount For Video Call/min (Inr)"  value="{{@$userData->video_call_discount_inr}}" name="video_call_discount_inr">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Discount For Video Call / min (Usd)(%)</label>
										<input type="text" placeholder="Discount For Video Call/min (Usd)"  value="{{@$userData->video_call_discount_usd}}" name="video_call_discount_usd">
									</div>
								</div>
							</div>

							<div class="col-md-12 col-sm-12">
									<div class="form_box_area">
										<div class="availability_check">
                                        <input id="chat_check" type="checkbox" value="chat_check" name="chat_check" @if(@$userData->is_chat=="Y") checked @endif>
                                        <label for="chat_check">I offer chat</label>
                                      </div>

								</div>
								</div>
								<div class="row" id="chat_div" @if(@$userData->is_chat=="N") style="display: none;" @endif>
								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Price For Chat /min (Inr)</label>
										<input type="text" placeholder="Price For Video Chat /min (Inr)" @if(@$userData->chat_price_inr!=0) value="{{@$userData->chat_price_inr}}" @endif name="chat_price_inr">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Price For Chat /min (Usd)</label>
										<input type="text" placeholder="Price For Video Chat /min (Usd)" @if(@$userData->chat_price_usd!=0) value="{{@$userData->chat_price_usd}}" @endif name="chat_price_usd">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Discount For Chat / min (Inr)(%)</label>
										<input type="text" placeholder="Discount For Chat/min (Inr)"  value="{{@$userData->chat_discount_inr}}" name="chat_discount_inr">
									</div>
								</div>

								<div class="col-md-6 col-sm-6">
									<div class="form_box_area">
										<label>Discount For Chat / min (Usd)(%)</label>
										<input type="text" placeholder="Discount For Chat/min (Usd)"  value="{{@$userData->chat_discount_usd}}" name="chat_discount_usd">
									</div>
								</div>
							</div>
                            <div class="col-md-12 col-sm-12" @if(@$userData->is_astrologer_offer_offline=="N") style="display: none;" @endif>
                                <div class="form_box_area">
                                    <div class="availability_check">
                                        <label for="offline_check"><b>I offer offline service<b></label>
                                    </div>

                                </div>
                            </div>

                            <div class="row" id="offline_div" @if(@$userData->is_astrologer_offer_offline=="N") style="display: none;" @endif>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Price For Offline service /min (Inr) : <span> {{@$userData->astrologer_offline_price_inr}}</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Price For Offline service /min (Usd):<span> {{@$userData->astrologer_offline_price_usd}}</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Discount For offline service /min (Inr)(%) : <span> {{@$userData->offline_discount_price_inr}}</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Discount For offline service /min (Usd)(%):<span> {{@$userData->offline_discount_price_usd}}</span></label>
                                    </div>
                                </div>
                            </div>
							</div>
							<div class="addres_infor">
								<h4>{{__('profile.address_information')}}</h4>
								<div class="row">
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.country_label')}}</label>
                                            <select name="country" id="country">
                                                <option value="">{{__('profile.select_country_placeholder')}}</option>
                                                @foreach(@$countries as $country)
                                                <option value="{{@$country->id}}" @if(auth()->user()->country_id==@$country->id)selected @endif>{{@$country->name}}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.state_label')}}</label>
											<select name="state" id="states">
                                            <option value="">{{__('profile.select_state_placeholder')}}</option>
                                            @foreach(@$states as $state)
                                                <option value="{{@$state->id}}" @if(auth()->user()->state==@$state->id)selected @endif>{{@$state->name}}</option>
                                              @endforeach
											</select>
										</div>
									</div>

									{{-- <div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.city_label')}}</label>
                                            <input type="text" placeholder="{{__('profile.city_placeholder')}}" name="city" value="{{old('city',@$userData->city)}}">
										</div>
									</div> --}}
                                    <div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.city_label')}}</label>
                                            <select name="city" id="city">
                                                <option value="">{{__('profile.city_placeholder_select')}}</option>
                                                @foreach(@$cities as $city)
                                                    <option value="{{@$city->id}}" @if(auth()->user()->city==@$city->id)selected @endif>{{@$city->name}}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.pincode_label')}}</label>
                                            <input type="text" placeholder="{{__('profile.pincode_placeholder')}}" name="pincode" id="pincode" value="{{old('pincode',@$userData->pincode)}}">
                                            <label id="pincode-error" class="error" for="pincode"></label>
										</div>
									</div>
                                    <div class="col-md-6 col-lg-4" id="areaDropDiv" @if(!@$userData->area)  style="display: none" @endif>
                                        <div class="form_box_area">
                                            <label>Select Area</label>
                                            <select class="login-type log-select " name="area_drop" id="areaDrop">
                                                <option value="">Select Area</option>
                                                @if(@$areas)
                                                    @foreach (@$areas as $ar)
                                                        <option value="{{$ar->id}}" {{@$userData->area==$ar->id?'selected':''}} >{{@$ar->area}}</option>
                                                    @endforeach
                                                    <option value="O">Other</option>
                                                @endif
                                            </select>
                                            <label id="areaDrop-error" class="error" for="areaDrop"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4" id="areaTextDiv" style="display: none">
                                        <div class="form_box_area">
                                            <label>Area</label>
                                            <input type="text" class="login-type" placeholder="Area" id="areaText" name="area" value="{{ old('area') }}">
                                            <label id="areaText-error" class="error" for="areaText"></label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12">
                                        <div class="form_box_area">
                                            <label>{{__('profile.address_label')}}</label>
                                            <input type="text" placeholder="{{__('profile.address_placeholder')}}" name="address" value="{{old('address',@$userData->address)}}"> </div>
                                    </div>
								</div>
							</div>




							<div class="addres_infor">
								<h4>{{__('profile.account_information')}}</h4>
								<div class="row">
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.bank_name_label')}}</label>
											<input type="text" placeholder="{{__('profile.bank_name_placeholder')}}" name="bank_name" value="{{old('bank_name',@$userData->userAccount->bank_name)}}">
										</div>
									</div>
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.ac_no_label')}}</label>
											<input type="text" placeholder="{{__('profile.ac_no_placeholder')}}" name="ac_no" value="{{old('ac_no',@$userData->userAccount->ac_no)}}">
										</div>
									</div>
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.ifsc_code_label')}}</label>
											<input type="text" placeholder="{{__('profile.ifsc_code_placeholder')}}" name="ifsc" value="{{old('ifsc',@$userData->userAccount->ifsc_code)}}">
										</div>
									</div>
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.name_of_account_holder_label')}}</label>
											<input type="text" placeholder="{{__('profile.name_of_account_holder_placeholder')}}" name="name_of_account_holder" value="{{old('name_of_account_holder',@$userData->userAccount->account_holder)}}">
										</div>
									</div>

									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											<label>{{__('profile.account_type')}}</label>
											<select name="profile_type">
											<option value="">{{__('profile.select_account_tyoe')}}</option>
                                           	<option value="S" @if(auth()->user()->Ac_Type=="S") selected @endif>Savings</option>
                                           	<option value="C" @if(auth()->user()->Ac_Type=="C") selected @endif>Current</option>
											</select>
										</div>
									</div>
									<div class="col-md-4 col-sm-6">
										<div class="form_box_area">
											 <label>{{__('profile.gst_label')}}</label>
                                            <input type="text" placeholder="{{__('profile.gst_placeholder')}}" name="gst_no" value="{{@$userData->gst_no}}">
										</div>
									</div>
								</div>
							</div>
                            <input type="hidden" name="expertise" id="expertise">
                            <input type="hidden" name="language" id="language">
							<div class="save_coniBx">
                                <div class="save_coniBx_left">
                                    <ul>

                                        <li><input type="submit" value="{{__('profile.save')}}" class="subBtn"></li>

                                    </ul>
                                </div>

                            </div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="croppie-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="croppie-div" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="crop-img">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="otp-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">OTP </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="{{route('account.otp.submit',['id'=>auth()->user()->id])}}" method="POST" enctype="multipart/form-data" id="signup_form">
                        @csrf
                        <input type="hidden" value="{{auth()->user()->id}}" name="id">
                    <div class="main-center-div">
                        <div class="login-from-area">
                            {{-- <h2>{{__('auth.otp_header')}}</h2> --}}
                            <p>{{__('auth.otp_content')}} {{auth()->user()->mobile}}</p>
                            <p>{{auth()->user()->otp}}</p>

                            <div class="otp-sec">
                                <ul>
                                    <li><input id="codeBox1" name="codeBox1" type="number" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox2" name="codeBox2" type="number" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox3" name="codeBox3" type="number" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox4" name="codeBox4" type="number" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox5" name="codeBox5" type="number" maxlength="1" onkeyup="onKeyUpEvent(5, event)" onfocus="onFocusEvent(5)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox6" name="codeBox6" type="number" maxlength="1" onkeyup="onKeyUpEvent(6, event)" onfocus="onFocusEvent(6)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                </ul>
                            </div>
                            <label id="codeBox6-error" class="error" for="codeBox6"></label>

                            <button type="submit" class="login-submit">{{__('auth.submit')}}</button>
                            <div class="bottom-account-div">
                                <p id="resendOtpp">{{__('auth.did_not_received')}}, <a href="javascript:;" id="resendOtp">{{__('auth.resend_code')}}</a></p>
                            </div>

                        </div>
                    </div>
                    </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="chenge-mobile-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Change Mobile Nubmer</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="javascript:;" id="changeModal">
                                <div class="login-from-area">
                                <div>
                                    <input type="tel" class="login-type" placeholder="{{__('auth.mobile_number_placeholder')}}" name="mobile" value="{{ old('mobile') }}" id="mobile">
                                    <div class="clearfix"></div>
                                </div>
                                <button type="submit" class="login-submit">Change Mobile Number</button>
                            </div>
                            </form>
                            <form action="{{route('astrologer.change.mobile.submit')}}" method="POST" enctype="multipart/form-data" id="otp_Mobile_form" style="display: none">
                                @csrf
                                <input type="hidden" value="{{auth()->user()->id}}" name="id">
                                <div class="main-center-div">
                                    <div class="login-from-area">
                                        <p id="showData">{{__('auth.otp_content')}} {{auth()->user()->mobile}}</p>
                                        <p id="showOTP">{{auth()->user()->otp}}</p>
                                        <div class="otp-sec">
                                            <ul>
                                                <li><input id="otpBox1" name="otpBox1" type="number" maxlength="1" onkeyup="onKeyUpEvent2(1, event)" onfocus="onFocusEvent2(1)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox2" name="otpBox2" type="number" maxlength="1" onkeyup="onKeyUpEvent2(2, event)" onfocus="onFocusEvent2(2)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox3" name="otpBox3" type="number" maxlength="1" onkeyup="onKeyUpEvent2(3, event)" onfocus="onFocusEvent2(3)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox4" name="otpBox4" type="number" maxlength="1" onkeyup="onKeyUpEvent2(4, event)" onfocus="onFocusEvent2(4)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox5" name="otpBox5" type="number" maxlength="1" onkeyup="onKeyUpEvent2(5, event)" onfocus="onFocusEvent2(5)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox6" name="otpBox6" type="number" maxlength="1" onkeyup="onKeyUpEvent2(6, event)" onfocus="onFocusEvent2(6)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                            </ul>
                                        </div>
                                        <label id="otpBox6-error" class="error" for="otpBox6"></label>
                                        <button type="submit" class="login-submit">{{__('auth.submit')}}</button>
                                        {{-- <div class="bottom-account-div">
                                            <p id="resendOtpp">{{__('auth.did_not_received')}}, <a href="javascript:;" id="resendOtp">{{__('auth.resend_code')}}</a></p>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>














   {{-- audio-call-number --}}
       <div class="modal" tabindex="-1" role="dialog" id="chenge-mobile-audio-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Change Mobile Nubmer For Audio Call</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form action="javascript:;" id="changeModal_audio">
                                <div class="login-from-area">
                                <div>
                                    <input type="tel" class="login-type" placeholder="{{__('auth.mobile_number_placeholder')}}" name="audio_mobile" value="{{ old('mobile') }}" id="audio_mobile">
                                    <div class="clearfix"></div>
                                </div>
                                <button type="submit" class="login-submit">Change Mobile Number</button>
                            </div>
                            </form>
                            <form action="{{route('astrologer.change.aduio.mobile.submit')}}" method="POST" enctype="multipart/form-data" id="otp_Mobile_form_audio" style="display: none">
                                @csrf
                                <input type="hidden" value="{{auth()->user()->id}}" name="id">
                                <div class="main-center-div">
                                    <div class="login-from-area">
                                        <p id="showData_audio">{{__('auth.otp_content')}} {{auth()->user()->mobile}}</p>
                                        <p id="showOTP_aduio">{{auth()->user()->otp}}</p>
                                        <div class="otp-sec">
                                            <ul>
                                                <li><input id="otpBox_audio1" name="otpBox_audio1" type="number" maxlength="1" onkeyup="onKeyUpEvent2(1, event)" onfocus="onFocusEvent2(1)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox_audio2" name="otpBox_audio2" type="number" maxlength="1" onkeyup="onKeyUpEvent2(2, event)" onfocus="onFocusEvent2(2)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox_audio3" name="otpBox_audio3" type="number" maxlength="1" onkeyup="onKeyUpEvent2(3, event)" onfocus="onFocusEvent2(3)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox_audio4" name="otpBox_audio4" type="number" maxlength="1" onkeyup="onKeyUpEvent2(4, event)" onfocus="onFocusEvent2(4)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox_audio5" name="otpBox_audio5" type="number" maxlength="1" onkeyup="onKeyUpEvent2(5, event)" onfocus="onFocusEvent2(5)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                                <li><input id="otpBox_audio6" name="otpBox_audio6" type="number" maxlength="1" onkeyup="onKeyUpEvent2(6, event)" onfocus="onFocusEvent2(6)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                            </ul>
                                        </div>
                                        <label id="otpBox_audio6-error" class="error" for="otpBox_audio6">This field is required.</label>
                                        <button type="submit" class="login-submit">{{__('auth.submit')}}</button>
                                        {{-- <div class="bottom-account-div">
                                            <p id="resendOtpp">{{__('auth.did_not_received')}}, <a href="javascript:;" id="resendOtp">{{__('auth.resend_code')}}</a></p>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>









               {{-- email-change-model --}}
        <div class="modal" tabindex="-1" role="dialog" id="exampleModalLong">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Change Email</h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <form  method="POST" enctype="multipart/form-data" id="change_email_form" action="{{route('astrologer.change.mail')}}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{@$userData->id}}">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="form_box_area">
                                        <input type="text" placeholder="{{__('profile.email_address_placeholder')}} " value="{{old('change_email', @$userData->temp_email)}}" name="change_email" id="change_email_id"> </div>
                                </div>
                            </div>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="submit" value="Change" class="save-change">
                                        </div>
                                    </div>

                        </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
<script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    function dataURLtoFile(dataurl, filename) {

 var arr = dataurl.split(','),
     mime = arr[0].match(/:(.*?);/)[1],
     bstr = atob(arr[1]),
     n = bstr.length,
     u8arr = new Uint8Array(n);

 while(n--){
     u8arr[n] = bstr.charCodeAt(n);
 }

 return new File([u8arr], filename, {type:mime});
}
      var uploadCrop;
    $(document).ready(function(){
      $(".js-example-basic-multiple").select2();
        if($('.type').val()=='C'){
            $(".s_h_hids").slideDown(0);
        } else{
            $(".s_h_hids").slideUp(0);
        }
        $(".ccllk02").click(function(){
            $(".s_h_hids").slideDown();
        });
        $(".ccllk01").click(function(){
            $(".s_h_hids").slideUp();
            $('.cmpy').val('');
        });
        $(".type-radio").change(function(){
           var t= $("input[name=type]:checked").val();
           if(t=="I"){
            $(".comany_name").css('display','none');
           }else{
            $(".comany_name").css('display','block');
           }
        });



    $('#croppie-modal').on('hidden.bs.modal', function() {
            uploadCrop.croppie('destroy');
        });

        $('#crop-img').click(function() {
            uploadCrop.croppie('result', {
                type: 'base64',
                format: 'png'
            }).then(function(base64Str) {
                $("#croppie-modal").modal("hide");
               //  $('.lds-spinner').show();
               let file = dataURLtoFile('data:text/plain;'+base64Str+',aGVsbG8gd29ybGQ=','hello.png');
                  console.log(file.mozFullPath);
                  console.log(base64Str);
                  $('#profile_picture').val(base64Str);
               // $.each(file, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uplodimgfilimg').append('<em><img  src="' + e.target.result + '"><em>');
                    };
                    reader.readAsDataURL(file);

               //  });
                $('.uplodimgfilimg').show();

            });
        });
    });
    $("#file").change(function () {
            $('.uplodimgfilimg').html('');
            let files = this.files;
            console.log(files);
            let img  = new Image();
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (! valid) {
                    alert('Please choose valid image files (jpeg, png, gif) only.');
                    $("#file").val('');
                    return false;
                }
                // img.src = window.URL.createObjectURL(event.target.files[0])
                // img.onload = function () {
                //     if(this.width > 250 || this.height >160) {
                //         flag=0;
                //         alert('Please upload proper image size less then : 250px x 160px');
                //         $("#file").val('');
                //         $('.uploadImg').hide();
                //         return false;
                //     }
                // };
                $("#croppie-modal").modal("show");
                uploadCrop = $('.croppie-div').croppie({
                    viewport: { width: 256, height: 256, type: 'square' },
                    boundary: { width: $(".croppie-div").width(), height: 400 }
                });
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    // console.log(e.target.result)
                    uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
               //  $('.uploadImg').append('<img width="100"  src="' + reader.readAsDataURL(this.files[0]) + '">');
               //  $.each(files, function(i, f) {
               //      var reader = new FileReader();
               //      reader.onload = function(e){
               //          $('.uploadImg').append('<img width="100"  src="' + e.target.result + '">');
               //      };
               //      reader.readAsDataURL(f);
               //  });
               //  $('.uploadImg').show();
            }

        });
</script>
<!-- Time picek jas -->
<link rel='stylesheet' href='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css'>
<script src='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js'></script>

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
<script>
    function fun1(){
    var i=document.getElementById('profile_pic').files[0];
    var b=URL.createObjectURL(i);
    $("#img2").attr("src",b);
    }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){

        $('#states').change(function(){
            const state = $(this).val();
            $('#city').html('');
            if (state != "") {
                  $.ajax({
                          url: "{{route('get.city')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  state_id: state,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.result) {
                              const res = response.result;
                              $('#city').append('<option value="" selected>Select city</option>');
                              $.each(res, function (i, v) {
                                  $('#city').append('<option value="' + v.id + '"">' + v.name + '</option>');
                              })
                          }
                      })
                      .fail(function (error) {
                          $('#city').html('<option value="" selected>Select city</option>');
                      });
              } else {
                  $('#city').html('<option value="" selected>Select state</option>');
              }
        });
    $('#pincode').change(function(){
        var pincode = $(this).val();
        var country = $('#country').val();
        var state = $('#states').val();
        var city = $('#city').val();
        $.ajax({
            url: "{{route('get.area')}}",
            method: 'POST',
            data: {
                jsonrpc: 2.0,
                _token: "{{ csrf_token() }}",
                params: {
                    pincode: pincode,
                    country: country,
                    state: state,
                    city: city,
                },
            },
            dataType: 'JSON'
        })
        .done(function (response) {
            if (response.postcode == 1) {

                $('#pincode-error').html('')
                $('#pincode-error').hide();
                //$('#areaTextDiv').hide()
                const res = response.result;
                var select = '';
                select += '<option value="">Select Area</option>';
                if(response.result.length >0){
                    $.each(res, function (i, v) {
                        select += '<option value="' + v.id + '"">' + v.area + '</option>';
                    })
                }

                select += '<option value="O">Other</option>';
                $('#areaDrop').html(select);
                $('#areaDropDiv').show()
            }else{
                $('#pincode-error').html('This postcode not available , please try other postcode')
                $('#pincode-error').show();
                //$('#areaTextDiv').show()
                $('#areaDropDiv').hide()
                $('#pincode').val('')
            }
        })
    });
    $('#areaDrop').on('change',function(){
        var area = $(this).val();
        if(area == 'O'){
            $('#areaTextDiv').show()
        }else{
            $('#areaTextDiv').hide()
        }
    })
        $("#edit_profile").validate({
            rules: {
                first_name:{
                    required: true,
                },
                last_name:{
                    required: true,
                },
                state:{
                    required: true,
                },
                city:{
                    required: true,
                },
                address:{
                    required:true,
                },
                country:{
                    required: true,
                },
                profile_pic:{
                    required: true,
                },
                // about:{
                //     required: true,
                // },
                bank_name:{
                    required: true,
                },
                ac_no:{
                    required: true,
                    number: true ,
                    maxlength: 16,
                },
                ifsc:{
                    required: true,
                },
                name_of_account_holder:{
                    required: true,
                },
                experience:{
                    required: true,
                    number: true ,
                    min:1,
                    max:99,
                },
                call_price:{
                    required: true,
                    number: true ,
                    min:1,
                },
                call_price_usd:{
                    required: true,
                    number: true ,
                    min:1,
                },
                video_call_price_inr:{
                	required: true,
                    number: true ,
                    min:1,
                },
                video_call_price_usd:{
                	required: true,
                    number: true ,
                    min:1,
                },
                chat_price_inr:{
                	required: true,
                    number: true ,
                    min:1,
                },
                chat_price_usd:{
                	required: true,
                    number: true ,
                    min:1,
                },
                expertise:{
                    required: true,
                },
                language:{
                    required: true,
                },
                profile_type:{
                	required:true,
                },
                pincode:{
                	required:true,
                	minlength:6,
                	maxlength:6,
                	number:true,
                },
                gst_no:{
                    minlength:15,
                    maxlength:20,
                },
            },
            messages: {
                first_name:{
                    required: '{{__('profile.required_first_name')}}',
                },
                last_name:{
                    required: '{{__('profile.required_last_name')}}'
                },
                state:{
                    required: '{{__('profile.required_state')}}',
                },
                address:{
                    required:'{{__('profile.required_address')}}',
                },
                city:{
                    required: '{{__('profile.required_city')}}',
                },
                country:{
                    required: '{{__('profile.required_country')}}',
                },
                pincode:{
                	required:'{{__('profile.pincode_required')}}',
                	minlength:'{{__('profile.pincode_properly')}}',
                	maxlength:'{{__('profile.pincode_properly')}}',
                	number:'{{__('profile.pincode_properly')}}',
                },
                profile_pic:{
                    required: '{{__('profile.required_profile_pic')}}',
                },
                about:{
                    required: '{{__('profile.required_about')}}',
                },
                bank_name:{
                    required: '{{__('profile.required_bank_name')}}',
                },
                profile_type:{
                    required: '{{__('profile.profile_type_required')}}',
                },
                ac_no:{
                    required: '{{__('profile.required_ac_no')}}',
                    number: '{{__('profile.number_ac_no')}}' ,
                    maxlength: '{{__('profile.maxlength_account')}}',
                },
                ifsc:{
                    required: '{{__('profile.required_ifsc')}}',
                },
                name_of_account_holder:{
                    required: '{{__('profile.required_name_of_account_holder')}}',
                },
                experience:{
                    required: '{{__('profile.required_experience')}}',
                    number: '{{__('profile.number_experience')}}' ,
                    min:'{{__('profile.minLength_of_experience')}}',
                    max:'{{__('profile.maxLength_of_experience')}}',
                },
                call_price:{
                    required: 'Please enter audio call price per min inr',
                    number: '{{__('profile.number_call_price')}}' ,
                    min:'Please enter audio call price inr properly',
                },
                call_price_usd:{
                    required: 'Please enter audio call price per min usd',
                    number: 'Only number allowed' ,
                    min:'Please enter audio call price usd properly',
                },
                video_call_price_inr:{
                	required: 'Please enter video call price per min inr',
                    number: 'Only number allowed' ,
                    min:'Please enter video call price inr properly',
                },
                video_call_price_usd:{
                	required: 'Please enter video call price per min usd',
                    number: 'Only number allowed' ,
                    min:'Please enter video call price usd properly',
                },
                chat_price_inr:{
                	required: 'Please enter chat price per min inr',
                    number: 'Only number allowed' ,
                    min:'Please enter chat price inr properly',
                },
                chat_price_usd:{
                	required: 'Please enter chat price per min usd',
                    number: 'Only number allowed' ,
                    min:'Please enter chat price usd properly',
                },
                expertise:{
                    required: '{{__('profile.required_expertise')}}',
                },
                language:{
                    required: '{{__('profile.required_language')}}',
                },
                gst_no:{
                    minlength:'{{__('profile.gst_properly')}}',
                    maxlength:'{{__('profile.gst_max_properly')}}',
                },
            },
            submitHandler:function(form){
                var img = $('#profile_picture').val();
                var old ='{{@$userData->profile_img}}';
                var expertise = $('#expertise').val();
                var language = $('#language').val();
                console.log(old);

                var gender_select = $('.gender_select').val();
                if ($(".gender_select:checked").length > 1 || $(".gender_select:checked").length == 0){
                  $('#gender-error').html('{{__('profile.gender_required')}}');
                  $('#gender-error').css('display','block');
                  return false;
                }


                if(img== '' && old==''){
                    $('#image-error').html('{{__('profile.required_profile_pic')}}');
                    $('#image-error').css('display', 'block');
                    return false;
                }
                else if(expertise == '' && language == ''){
                    $('#expertise-error').html('{{__('profile.required_expertise')}}');
                    $('#expertise-error').css('display', 'block');
                    $('#language-error').html('{{__('profile.required_language')}}');
                    $('#language-error').css('display', 'block');
                    return false;
                } else if(expertise == ''){
                    $('#expertise-error').html('{{__('profile.required_expertise')}}');
                    $('#expertise-error').css('display', 'block');
                    return false;
                }else if(language == ''){
                    $('#language-error').html('{{__('profile.required_language')}}');
                    $('#language-error').css('display', 'block');
                    return false;
                }
                else if($('input[name="chat_check"]').prop("checked") == false && $('input[name="audio_call_check"]').prop("checked") == false &&  $('input[name="video_call_check"]').prop("checked") == false){
                	alert('Please select at least one offer from audio call/video call/Chat');
                	return false;
                }
                else {
                    // var ext=img.substring(img.lastIndexOf("."),img.length);
                    // var extl = ext.toLowerCase();
                    // if(!extl.match(/.(jpg|jpeg|png|gif)$/i) && $('#profile_pic').val().length != 0){
                    //     $('#image-error').html('Please enter an image only');
                    //     $('#image-error').css('display', 'block');
                    //     return false;
                    // } else {
                        form.submit();
                    // }
                }
            }
        });
        // $('#edit_profile').submit(function () {

        // // Get the Login Name value and trim it
        // var expertise = $('#expertise').val();

        // // Check if empty of not
        // if (expertise == '') {
        //     // var name = $(element).attr("name");
        //     $("#expertise-error").css('display', 'block');
        //     // $('#dwn').css('display', 'block');
        // alert('Text-field is empty.');
        // return false;
        // }
        // });
    })
</script>
<script>

</script>
<script>
    $(document).ready(function() {
        /*all expertise data push in array*/
        var data = [];
        @foreach($allExpertise as $allExpertises )
        data.push({ label : '{{ $allExpertises->expertise_name }}', value : '{{ $allExpertises->id }}'});
        @endforeach
        console.log(data);
        /*end*/
        /*user expertise data push in array*/
        var expertisevalue= [];
        @foreach(@$userData->astrologerExpertise as $expertises )
        expertisevalue.push('{{ $expertises->expertise_id }}');
        @endforeach
        console.log(expertisevalue);
        $('#expertise').val(expertisevalue);
        /*end*/

        /* Auto Complete for expertise*/
        var autocomplete = new SelectPure(".autocomplete-select1", {
            options: data,
            value: [],
            multiple: true,
            autocomplete: true,
            icon: "fa fa-times",
            value: expertisevalue,
            onChange: value => {
                console.log({value});
                $('#expertise').val(value);
            },
            classNames: {
                select: "select-pure__select",
                dropdownShown: "select-pure__select--opened",
                multiselect: "select-pure__select--multiple",
                label: "select-pure__label",
                placeholder: "select-pure__placeholder",
                dropdown: "select-pure__options",
                option: "select-pure__option",
                autocompleteInput: "select-pure__autocomplete",
                selectedLabel: "select-pure__selected-label",
                selectedOption: "select-pure__option--selected",
                placeholderHidden: "select-pure__placeholder--hidden",
                optionHidden: "select-pure__option--hidden",
            }
        });
        var resetAutocomplete = function() {
            autocomplete.reset();
        };
        /*end Auto Complete for expertise*/

        /*all language data push in array*/
        var dataLanguage = [];
        @foreach($allLanguage as $allLanguages )
        dataLanguage.push({ label : '{{ $allLanguages->language_name }}', value : '{{ $allLanguages->id }}'});
        @endforeach
        console.log(dataLanguage);
        /*end*/
        /*user language data push in array*/
        var languagevalue= [];
        @foreach(@$userData->astrologerLanguage as $languages )
        languagevalue.push('{{ $languages->language_id }}');
        @endforeach
        console.log(languagevalue);
        /*end*/
        $('#language').val(languagevalue);

        var autocomplete = new SelectPure(".autocomplete-select", {
            options: dataLanguage,
            value: languagevalue,
            multiple: true,
            autocomplete: true,
            icon: "fa fa-times",
            onChange: value => {
                console.log(value);
                $('#language').val(value);
            },
            classNames: {
                select: "select-pure__select",
                dropdownShown: "select-pure__select--opened",
                multiselect: "select-pure__select--multiple",
                label: "select-pure__label",
                placeholder: "select-pure__placeholder",
                dropdown: "select-pure__options",
                option: "select-pure__option",
                autocompleteInput: "select-pure__autocomplete",
                selectedLabel: "select-pure__selected-label",
                selectedOption: "select-pure__option--selected",
                placeholderHidden: "select-pure__placeholder--hidden",
                optionHidden: "select-pure__option--hidden",
            }
        });
        var resetAutocomplete = function() {
            autocomplete.reset();
        };
        $('#un_mo').click(function(){
            $.ajax({
                type:"GET",
                url: "{{ route('account.resend.otp.auth',['id'=>auth()->user()->id]) }}",
                success:function(response) {
                    console.log(response['a']);
                    $("#otp-modal").modal("show");
                }
            });
        });
        $('#ch_mo').click(function(){
            $("#chenge-mobile-modal").modal("show");
        });
        $("#chenge-mobile-modal").on('hidden.bs.modal', function (e) {
            $('#otp_Mobile_form').css('display','none');
            $('#changeModal').css('display','block');
            $('#mobile').val('');
            $('#mobile').val('');
            $('#otpBox1').val('');
            $('#otpBox2').val('');
            $('#otpBox3').val('');
            $('#otpBox4').val('');
            $('#otpBox5').val('');
            $('#otpBox6').val('');
            $('#otpBox6-error').css('display','none');
            console.log('close');
            // $('#myModal .modal-body').empty();
        });

		//change-audio-mobile
		// alert('sayan');
       // $("#chenge-mobile-audio-modal").on('hidden.bs.modal', function (e) {
            $('#otp_Mobile_form_audio').css('display','none');
            $('#changeModal_audio').css('display','block');
            $('#audio_mobile').val('');
            $('#audio_mobile').val('');
            $('#otpBox1_audio').val('');
            $('#otpBox2_audio').val('');
            $('#otpBox3_aduio').val('');
            $('#otpBox4_audio').val('');
            $('#otpBox5_audio').val('');
            $('#otpBox6_audio').val('');
            $('#otpBox_audio6-error').css('display','none');

            // $('#myModal .modal-body').empty();
        // });
    });


	$('#ch_mo_audio').click(function(){
            $("#chenge-mobile-audio-modal").modal("show");
        });
</script>
<script>
    $(document).ready(function(){
        $("#signup_form").validate({
            rules: {
                codeBox6:{
                    required: true,
                },
            },
            messages: {
                codeBox6:{
                    required: '{{__('auth.required_otp')}}',
                },
            },
        });
    });
</script>
<script>
    function getCodeBoxElement(index) {
        return document.getElementById('codeBox' + index);
      }
      function onKeyUpEvent(index, event) {
        const eventCode = event.which || event.keyCode;
        if (getCodeBoxElement(index).value.length === 1) {
          if (index !== 6) {
            getCodeBoxElement(index+ 1).focus();
          } else {
            getCodeBoxElement(index).blur();
            // Submit code
            console.log('submit code ');
          }
        }
        if (eventCode === 8 && index !== 1) {
          getCodeBoxElement(index - 1).focus();
        }
      }
      function onFocusEvent(index) {
        for (item = 1; item < index; item++) {
          const currentElement = getCodeBoxElement(item);
          if (!currentElement.value) {
              currentElement.focus();
              break;
          }
        }
      }

      function getOTPBoxElement(index) {
        return document.getElementById('otpBox' + index);
      }
      function onKeyUpEvent2(index, event) {
        const eventCode = event.which || event.keyCode;
        if (getOTPBoxElement(index).value.length === 1) {
          if (index !== 6) {
            getOTPBoxElement(index+ 1).focus();
          } else {
            getOTPBoxElement(index).blur();
            // Submit code
            console.log('submit code ');
          }
        }
        if (eventCode === 8 && index !== 1) {
          getOTPBoxElement(index - 1).focus();
        }
      }
      function onFocusEvent2(index) {
        for (item = 1; item < index; item++) {
          const currentElement = getOTPBoxElement(item);
          if (!currentElement.value) {
              currentElement.focus();
              break;
          }
        }
      }
</script>


{{-- change-audio-mobile --}}

<script>
     function getOTPBoxElementAudio(index) {
        return document.getElementById('otpBox_audio' + index);
      }
      function onKeyUpEvent2(index, event) {
        const eventCode = event.which || event.keyCode;
        if (getOTPBoxElementAudio(index).value.length === 1) {
          if (index !== 6) {
            getOTPBoxElementAudio(index+ 1).focus();
          } else {
            getOTPBoxElementAudio(index).blur();
            // Submit code
            console.log('submit code ');
          }
        }
        if (eventCode === 8 && index !== 1) {
          getOTPBoxElementAudio(index - 1).focus();
        }
      }
      function onFocusEvent2(index) {
        for (item = 1; item < index; item++) {
          const currentElement = getOTPBoxElementAudio(item);
          if (!currentElement.value) {
              currentElement.focus();
              break;
          }
        }
      }
</script>



<script>
$('#resendOtp').click(function(){
    $.ajax({
        type:"GET",
        url: "{{ route('account.resend.otp.auth',['id'=>auth()->user()->id]) }}",
        success:function(response) {
            console.log(response['result']);
            // if(response['result']['success']!=null){
            //     toastr.success(response['result']['success']);
            // }
            // if(response['result']['error']!=null){
            //     toastr.error(response['result']['error']);
            // }
            // toastr.success('');
            // $('#resendOtp').hide();
            // $('#resendOtpp').hide();
        }
    });
});
</script>
<script>
    $(document).ready(function(){
        $("#otp_Mobile_form").validate({
            rules: {
                otpBox6:{
                    required: true,
                    remote: {
                        url: '{{ route("astrologer.change.mobile.check.otp") }}',
                        dataType: 'json',
                        type:'post',
                        data: {
                            otpBox1: function() {
                                return $('#otpBox1').val();
                            },
                            otpBox2: function() {
                                return $('#otpBox2').val();
                            },
                            otpBox3: function() {
                                return $('#otpBox3').val();
                            },
                            otpBox4: function() {
                                return $('#otpBox4').val();
                            },
                            otpBox5: function() {
                                return $('#otpBox5').val();
                            },
                            otpBox6: function() {
                                return $('#otpBox6').val();
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    },
                },
            },
            messages: {
                otpBox6:{
                    required: '{{__('auth.required_otp')}}',
                    remote: 'Worng OTP'
                },
            },
        });
    });
    $("#changeModal").validate({
            rules: {

                mobile:{
                    required: true,
                    number: true ,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: '{{ route("check.mobile") }}',
                        dataType: 'json',
                        type:'post',
                        data: {
                            mobile: function() {
                                return $('#mobile').val();
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    },
                }
            },
            messages: {
                mobile:{
                    required: '{{__('auth.required_mobile')}}',
                    number: '{{__('auth.number_mobile')}}',
                    minlength: '{{__('auth.minlength_mobile')}}',
                    maxlength: '{{__('auth.maxlength_mobile')}}',
                    remote:'{{__('profile.mobile_number_unique')}}'
                }
            },
            submitHandler: function(form) {
                var mobile= $('#mobile').val();
                $.ajax({
                    url: '{{ route("astrologer.change.mobile") }}',
                    dataType: 'json',
                    type:'post',
                    data: {
                        mobile: mobile,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function( response ) {
                        console.log(response['result']);
                        $('#showData').text( '{{__('auth.otp_content')}}'+ response['result']['data']['temp_mobile']);
                        $('#showOTP').text(response['result']['data']['temp_otp']);
                        $('#otp_Mobile_form').css('display','block');
                        $('#changeModal').css('display','none');
                    }
                })
            },
        });
</script>




{{-- change-audio-mobile --}}

<script>
    $(document).ready(function(){
        $("#otp_Mobile_form_audio").validate({
            rules: {
                otpBox_audio6:{
                    required: true,
                    remote: {
                        url: '{{ route("astrologer.change.mobile.check.otp.aduio-mobile") }}',
                        dataType: 'json',
                        type:'post',
                        data: {
                            otpBox1: function() {
                                return $('#otpBox_audio1').val();
                            },
                            otpBox2: function() {
                                return $('#otpBox_audio2').val();
                            },
                            otpBox3: function() {
                                return $('#otpBox_audio3').val();
                            },
                            otpBox4: function() {
                                return $('#otpBox_audio4').val();
                            },
                            otpBox5: function() {
                                return $('#otpBox_audio5').val();
                            },
                            otpBox6: function() {
                                return $('#otpBox_audio6').val();
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    },
                },
            },
            messages: {
                otpBox_audio6:{
                    required: '{{__('auth.required_otp')}}',
                    remote: 'Worng OTP'
                },
            },
        });
    });
    $("#changeModal_audio").validate({
            rules: {

                audio_mobile:{
                    required: true,
                    number: true ,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: '{{ route("astrologer.check.audio.mboile") }}',
                        dataType: 'json',
                        type:'post',
                        data: {
                            mobile: function() {
                                return $('#audio_mobile').val();
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    },
                }
            },
            messages: {
                audio_mobile:{
                    required: '{{__('auth.required_mobile')}}',
                    number: '{{__('auth.number_mobile')}}',
                    minlength: '{{__('auth.minlength_mobile')}}',
                    maxlength: '{{__('auth.maxlength_mobile')}}',
                    remote:'{{__('profile.mobile_number_unique')}}'
                }
            },
            submitHandler: function(form) {
                var mobile= $('#audio_mobile').val();
                $.ajax({
                    url: '{{ route("astrologer.change.audio.mboile") }}',
                    dataType: 'json',
                    type:'post',
                    data: {
                        mobile: mobile,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function( response ) {
                        console.log(response['result']);
                        $('#showData_audio').text( '{{__('auth.otp_content')}}'+ response['result']['data']['audio_temp_mobile']);
                        $('#showOTP_aduio').text(response['result']['data']['audio_temp_otp']);
                        $('#otp_Mobile_form_audio').css('display','block');
                        $('#changeModal_audio').css('display','none');
                    }
                })
            },
        });
</script>





{{-- change-email-form --}}
<script type="text/javascript">
    $(document).ready(function(){
    	jQuery.validator.addMethod("validate_email", function(value, element) {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }, "{{__('auth.valid_email')}}");
        $("#change_email_form").validate({

            rules: {
                change_email:{
                	validate_email:true,
                    required: true,
                     remote: {
                          url:  '{{route('astrologer.check.email')}}',
                          type: "POST",
                          data: {
                            change_email_id: function() {
                              return $( "#change_email_id").val() ;
                            },
                            _token: '{{ csrf_token() }}',
                          }
                   },
                },
               },
               messages:{
                change_email:{
                    required:'{{__('auth.required_email')}}',
                    remote:'{{__('auth.unique_email')}}',
                },
               }
            });
        })
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#country').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('astrologer.get.state')}}',
        type:'GET',
        data:{country:id,id:'{{auth()->user()->state}}'},
        success:function(data){
          console.log(data);
		  $('#states').html(data.state);
        }
      })
    })
  })
</script>


{{-- pricing-fundamentals --}}

<script type="text/javascript">
	 $(document).ready(function() {
          $('input[name="audio_call_check"]').click(function() {
              if($(this).prop("checked") == true) {
                $('#audio_call_div').css('display','inline-flex');
                $('#avail_now_audio_call_div').css('display','block');
              }
              else if($(this).prop("checked") == false) {
                $('#audio_call_div').css('display','none');
                $('#avail_now_audio_call_div').css('display','none');
              }
            });
        });
</script>

<script type="text/javascript">
	 $(document).ready(function() {
          $('input[name="video_call_check"]').click(function() {
              if($(this).prop("checked") == true) {
                $('#video_call_div').css('display','inline-flex');
                $('#avail_now_video_call_div').css('display','block');
              }
              else if($(this).prop("checked") == false) {
                $('#video_call_div').css('display','none');
                $('#avail_now_video_call_div').css('display','none');
              }
            });
        });
</script>

<script type="text/javascript">
	 $(document).ready(function() {
          $('input[name="chat_check"]').click(function() {
              if($(this).prop("checked") == true) {
                $('#chat_div').css('display','inline-flex');
                $('#avail_now_chat_div').css('display','block');
              }
              else if($(this).prop("checked") == false) {
                $('#chat_div').css('display','none');
                $('#avail_now_chat_div').css('display','none');
              }
            });
        });
</script>



@endsection
