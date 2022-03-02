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
						<li class="actv"><a href="{{route('pundit.profile')}}">
							<img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
							<img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            {{__('profile.basic_info')}}</a>
                        </li>
						<li><a href="{{route('pundit.puja')}}">
							<img src="{{ URL::to('public/frontend/images/bacicon5.png')}}" class="bacicon1" alt="">
							<img src="{{ URL::to('public/frontend/images/bacicon55.png')}}" class="bacicon2" alt="">
						{{__('profile.puja')}}</a></li>
                        <li >
                            <a href="{{route('pundit.puja.service')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Service Area</a>
                        </li>
						<li><a href="{{route('pundit.availability')}}">
							<img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
							<img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
						{{__('profile.availability')}}</a></li>
					</ul>
				</div>
				<div class="astro-dash-right_iner">
					<form action="{{route('pundit.profile.edit')}}" method="POST" enctype="multipart/form-data" id="edit_profile">
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
                                            @if(@$userData->is_email_verify=='Y')<i class="fa fa-check-circle-o" aria-hidden="true" style="color: green"></i> <span style="color: green">Verified</span> |

                                            <span data-toggle="modal" data-target="#exampleModalLong" style="cursor: pointer;color: blue;">Edit</span>
                                            @elseif(@$userData->is_email_verify=='N')<i class="fa fa-ban" style="color: red"></i> <span style="color: red">Unverified</span> |

                                            <span data-toggle="modal" data-target="#exampleModalLong" style="cursor: pointer;color: blue;">Edit</span>
                                            @endif
                                        </label>
										<input type="text" placeholder="{{__('profile.email_address_placeholder')}} " value="{{@$userData->email}}" disabled>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>{{__('profile.mobile_number_label')}}
                                            @if(@$userData->is_mobile_verify=='Y')<i class="fa fa-check-circle-o" aria-hidden="true" style="color: green"></i> <span style="color: green">Verified</span> | <a href="javascript:;" id="ch_mo" style="color: blue"> Edit</a>
                                            @elseif(@$userData->is_mobile_verify=='N')<i class="fa fa-ban" style="color: red"></i> <span style="color: red">Unverified</span> <a href="javascript:;" id="ch_mo" style="color: blue"> Edit</a>
                                            @endif
                                        </label>
										<input type="text" placeholder="{{__('profile.mobile_number_placeholder')}} " value="{{@$userData->mobile}}" disabled>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="checkBox">
										<span>{{__('profile.gender_placeholder')}}</span>
										<ul>
											<li>
                                                <input type="radio" id="radio1" name="gender" class="gender_select" value="M" @if(@$userData->gender=='M' ||old('gender')=='M') checked="" @endif>
                                                <label for="radio1">{{__('profile.male_placeholder')}}</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio2" name="gender" class="gender_select" value="F" @if(@$userData->gender=='F'||old('gender')=='F') checked=""  @endif>
                                                <label for="radio2">{{__('profile.female_placeholder')}}</label>
                                            </li>
										</ul>
                                         <div><label id="gender-error" class="error" for="gender"></label></div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<div class="form_box_area">
										<label>{{__('profile.puja_type_label')}}</label>
										<select name="puja_type" id="puja_type">
                                            <option value="">{{__('profile.select_puja_type_placeholder')}}</option>
                                            <option value="ONLINE" @if(old('puja_type')=='ONLINE' || @$userData->puja_type =='ONLINE' ) Selected @endif>{{__('profile.online')}}</option>
                                            <option value="OFFLINE" @if(old('puja_type')=='OFFLINE' || @$userData->puja_type =='OFFLINE') Selected @endif>{{__('profile.offline')}}</option>
                                            <option value="BOTH" @if(old('puja_type')=='BOTH' || @$userData->puja_type =='BOTH') Selected @endif>{{__('profile.both')}}</option>
										</select>
									</div>
								</div>
                                {{-- <div class="col-md-8 col-sm-6 offline_puja" @if(@$userData->puja_type =='ONLINE') style="display: none" @endif >
                                    <div class="form_box_area">
                                        <label>{{__('profile.offline_puja_area_label')}}</label>
                                        <input type="text" placeholder="{{__('profile.offline_puja_area_placeholder')}}" id="offline_puja_location" value="{{old('offline_puja_location',@$userData->offline_puja_location)}}" name="offline_puja_location"> </div>
                                        <input type="hidden" name="lat" id="lat" value="{{ @$userData->offline_lat }}">
                                        <input type="hidden" name="lng" id="lng" value="{{ @$userData->offline_long }}">
                                </div>
                                <div class="col-md-4 col-sm-6  offline_puja" @if(@$userData->puja_type =='ONLINE') style="display: none" @endif>
                                    <div class="form_box_area">
                                        <label>{{__('profile.offline_puja_distance_label')}} </label>
                                        <input type="text" placeholder="{{__('profile.offline_puja_distance_placeholder')}}" id="offline_puja_radius" value="{{old('offline_puja_radius',@$userData->offline_puja_radius)}}" name="offline_puja_radius"> </div>
                                </div> --}}
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
										<span>Available</span>
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
										<textarea name="about" placeholder="{{__('profile.about_placeholder')}}" required>{{@$userData->about}}</textarea>
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

									<div class="col-md-6 col-lg-4">
                                        <div class="form_box_area">
                                            <label>{{__('profile.city_label')}}</label>
                                            <select class="login-type log-select " name="city" id="city">
                                                <option value="">Select City</option>
                                                @if(@$cities)
                                                    @foreach (@$cities as $ct)
                                                        <option value="{{$ct->id}}" {{@$userData->city==$ct->id?'selected':''}} >{{@$ct->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label id="city-error" class="error" for="city"></label>
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
                                                @endif
                                                <option value="O">Other</option>
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
                            <form action="{{route('pundit.change.mobile.submit')}}" method="POST" enctype="multipart/form-data" id="otp_Mobile_form" style="display: none">
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


       {{-- email-change-model --}}
        <div class="modal" tabindex="-1" role="dialog" id="exampleModalLong">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Change Email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     <form  method="POST" enctype="multipart/form-data" id="change_email_form" action="{{route('pundit.change.mail')}}">
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
<script>
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('offline_puja_location');

        var options = {
          types: ['establishment']
        };

        var input = document.getElementById('offline_puja_location');
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place)
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#lat').val(place.geometry.location.lat());
            $('#lng').val(place.geometry.location.lng());
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
            $('.exct_btn').show();
            console.log(place.address_components);
            initMap();
        });
        initMap();
    }
</script>

<script>

    function initMap() {
        geocoder = new google.maps.Geocoder();
        var lat = $('#lat').val();
        var lng = $('#lng').val();
        var myLatLng = new google.maps.LatLng(lat, lng);
        // console.log(myLatLng);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Choose hotel location',
          draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(evt,status){
        $('#lat').val(evt.latLng.lat());
        $('#lng').val(evt.latLng.lng());
        var lat_1 = evt.latLng.lat();
        var lng_1 = evt.latLng.lng();
        var latlng = new google.maps.LatLng(lat_1, lng_1);
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#offline_puja_location').val(results[0].formatted_address);
                }
            });


        });
    }
    </script>
    {{-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1A0Zjdpb5eWY6MCTp_8ZOVAlDkUB4MTY&callback=initMap">
    </script> --}}
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1A0Zjdpb5eWY6MCTp_8ZOVAlDkUB4MTY&libraries=places&callback=initAutocomplete" async defer></script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRZMuXnvy3FntdZUehn0IHLpjQm55Tz1E&libraries=places&callback=initAutocomplete" async defer></script>
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
<script>
    $("input[name=time_of_birth]").clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        default: 'now',
        donetext: "Select",
        init: function() {
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    });
</script>
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
        $.validator.addMethod("minradius", function(value, element, min) {
            if(value>=min){
                return true;
            }
            else if(value==''){
                return true;
            }
        }, '{{__('profile.offline_puja_distance_minimum')}}');
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
                address:{
                    required:true,
                },
                city:{
                    required: true,
                },
                country:{
                    required: true,
                },
                profile_pic:{
                    required: true,
                },
                about:{
                    required: true,
                },
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
                puja_type:{
                    required: true,
                },
                pincode:{
                	required:true,
                	minlength:6,
                	maxlength:6,
                	number:true,
                },
                profile_type:{
                	required:true,
                },
                gst_no:{
                    minlength:15,
                    maxlength:20,
                },
                // offline_puja_location:{
                //     required:function(){
                //         var puja_type = $('#puja_type').val();
                //         if(puja_type=='OFFLINE' || puja_type=='BOTH' ){
                //             return true
                //         }else{
                //             return false
                //         }
                //     },
                // },
                // offline_puja_radius:{
                //     required:function(){
                //         var puja_type = $('#puja_type').val();
                //         if(puja_type=='OFFLINE' || puja_type=='BOTH' ){
                //             return true
                //         }else{
                //             return false
                //         }
                //     },
                //     number:true,
                //     minradius:1
                // },
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
                profile_pic:{
                    required: '{{__('profile.required_profile_pic')}}',
                },
                about:{
                    required: '{{__('profile.required_about')}}',
                },
                bank_name:{
                    required: '{{__('profile.required_bank_name')}}',
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
                puja_type:{
                    required: '{{__('profile.required_puja_type')}}',
                },
                 profile_type:{
                    required: '{{__('profile.profile_type_required')}}',
                },
                 pincode:{
                	required:'{{__('profile.pincode_required')}}',
                	minlength:'{{__('profile.pincode_properly')}}',
                	maxlength:'{{__('profile.pincode_properly')}}',
                	number:'{{__('profile.pincode_properly')}}',
                },
                gst_no:{
                    minlength:'{{__('profile.gst_properly')}}',
                    maxlength:'{{__('profile.gst_max_properly')}}',
                },
                // offline_puja_location:{
                //     required:'{{__('profile.required_offline_puja_location')}}',
                // },
                // offline_puja_radius:{
                //     required:'{{__('profile.required_offline_puja_radius')}}',
                //     number:'{{__('profile.number_offline_puja_radius')}}',
                // },
            },
            submitHandler:function(form){
                var img = $('#profile_picture').val();
                var old ='{{@$userData->profile_img}}';
                console.log(old);

               var gender_select = $('.gender_select').val();
                if ($(".gender_select:checked").length > 1 || $(".gender_select:checked").length == 0){
                  $('#gender-error').html('{{__('profile.gender_required')}}');
                  $('#gender-error').css('display','block');
                  return false;
                }
                if(img =='' && old==''){
                    $('#image-error').html('{{__('profile.required_profile_pic')}}');
                    $('#image-error').css('display', 'block');
                    return false;
                } else {
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
    })
</script>
<script>
    $(document).ready(function(){
        $('#puja_type').change(function(){
            var puja_type = $('#puja_type').val();
            if(puja_type=='OFFLINE' || puja_type=='BOTH' ){
                $('.offline_puja').css('display','block');
            }
            else{
                $('.offline_puja').css('display','none');
            }
        })
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
    })
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
                        url: '{{ route("pundit.change.mobile.check.otp") }}',
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
                    url: '{{ route("pundit.change.mobile") }}',
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
                          url:  '{{route('pundit.check.email')}}',
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
        url:'{{route('pundit.get.state')}}',
        type:'GET',
        data:{country:id,id:'{{auth()->user()->state}}'},
        success:function(data){
          console.log(data);
		  $('#states').html(data.state);
        }
      })
    })
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
  })
</script>
@endsection

