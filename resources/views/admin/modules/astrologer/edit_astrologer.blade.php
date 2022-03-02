@extends('admin.layouts.app')


@section('title')
    <title>Astroaquila | Edit Astrologer Profile</title>
@endsection

@section('style')
    @include('admin.includes.style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="{{ URL::asset('public/frontend/croppie/croppie.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/frontend/croppie/croppie.min.css') }}" rel="stylesheet" />
    <style type="text/css">
        .form-group span {
            font-size: 15px;
            color: #8a8a8a;
        }

        .uplodimgfilimg {
            margin-left: 20px;
            padding-top: 20px;
        }

        .uplodimgfilimg em {
            width: 58px;
            height: 58px;
            position: relative;
            display: inline-block;
            overflow: hidden;
            border-radius: 4px;
        }

        .uplodimgfilimg em img {
            position: absolute;
            max-width: 100%;
            max-height: 100%;
        }
        .checkBoxAstroTP {
            width: 33% !important;
            float: left !important;
        }
    </style>
    <style type="text/css">

    </style>
@endsection

@section('content')
    <!-- Top Bar Start -->
    @include('admin.includes.header')
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    @include('admin.includes.sidebar')
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">Edit Astrologer</h4>
                        <ol class="breadcrumb pull-right">
                            <li class="active"><a href="{{ route('admin.manage.astrologer') }}"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="astro_bac_list">
                            <ul>
                                <li class="actv"><a
                                        href="{{ route('admin.astrologer.edit-view', ['id' => @$data->id]) }}">
                                        <img src="{{ URL::to('public/frontend/images/bacicon1.png') }}"
                                            class="bacicon1" alt="">
                                        <img src="{{ URL::to('public/frontend/images/bacicon11.png') }}"
                                            class="bacicon2" alt="">
                                        Basic Info</a></li>
                                <li><a href="{{ route('admin.astrologer.edit-education-view', ['id' => @$data->id]) }}">
                                        <img src="{{ URL::to('public/frontend/images/bacicon2.png') }}"
                                            class="bacicon1" alt="">
                                        <img src="{{ URL::to('public/frontend/images/bacicon22.png') }}"
                                            class="bacicon2" alt="">
                                        Education</a></li>
                                <li><a href="{{ route('admin.astrologer.edit-exp-view', ['id' => @$data->id]) }}">
                                        <img src="{{ URL::to('public/frontend/images/bacicon3.png') }}"
                                            class="bacicon1" alt="">
                                        <img src="{{ URL::to('public/frontend/images/bacicon33.png') }}"
                                            class="bacicon2" alt="">
                                        Experience</a></li>
                                <li><a href="{{ route('admin.astrologer.edit-avail-view', ['id' => @$data->id]) }}">
                                        <img src="{{ URL::to('public/frontend/images/bacicon4.png') }}"
                                            class="bacicon1" alt="">
                                        <img src="{{ URL::to('public/frontend/images/bacicon44.png') }}"
                                            class="bacicon2" alt="">
                                        Availability</a></li>
                                <li><a href="{{route('admin.astrologer.date.exclusion',['id'=>@$data->id])}}">
                                        <img src="{{ URL::to('public/frontend/images/declined-white.png') }}"
                                            class="bacicon1" alt="">
                                        <img src="{{ URL::to('public/frontend/images/declined-color.png') }}"
                                            class="bacicon2" alt="">
                                        Date Exclusion List</a></li>
                            </ul>
                        </div>
                        @include('admin.includes.message')
                        <div>

                            <!-- Personal-Information -->
                            <div class="panel panel-default panel-fill">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Edit Astrologer</h3>
                                </div>
                                <div class="panel-body rm02 rm04">
                                    <form role="form" id="edit_profile" method="post" enctype="multipart/form-data"
                                        action="{{ route('admin.astrologer.update-profile') }}">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ @$data->id }}">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="FullName">I want to offer my service</label>
                                                    <div class="checkBox">

                                                        <ul>
                                                            <li>
                                                                <input type="radio" id="radio3" class="avail_select"
                                                                    name="availability" value="Y" @if (@$data->user_availability == 'Y') checked="" @endif>
                                                                <label for="radio3">Yes</label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="radio4" class="avail_select"
                                                                    name="availability" value="N" @if (@$data->user_availability == 'N') checked="" @endif >
                                                                <label for="radio4">No</label>
                                                            </li>
                                                        </ul>
                                                        {{-- <div><label id="gender-error" class="error" for="gender"></label></div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">First name</label>
                                            <input type="text" placeholder="First name" id="name" name="first_name"
                                                class="form-control" value="{{ @$data->first_name }}">
                                            <div class="error" id="name_error"></div>
                                        </div>


                                        <div class="form-group">
                                            <label for="FullName">Last Name</label>
                                            <input type="text" placeholder="Last Name" name="last_name"
                                                class="form-control" value="{{ @$data->last_name }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">Email</label>
                                            <input type="text" placeholder="Email" name="email" class="form-control"
                                                id="email" value="{{ @$data->email }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">Mobile No</label>
                                            <input type="text" placeholder="Mobile No" name="mobile" class="form-control"
                                                id="mobile" value="{{ @$data->mobile }}">
                                            <div class="error" id="price_error"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="FullName">Gender</label>
                                            <div class="checkBox">

                                                <ul>
                                                    <li>
                                                        <input type="radio" id="radio1" class="gender_select" name="gender"
                                                            value="M" @if (@$data->gender == 'M') checked="" @endif>
                                                        <label for="radio1">Male</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="radio2" class="gender_select" name="gender"
                                                            value="F" @if (@$data->gender == 'F') checked="" @endif>
                                                        <label for="radio2">Female</label>
                                                    </li>
                                                </ul>
                                                <div><label id="gender-error" class="error" for="gender"></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group malti_select add_rmopppp">
                                            <label for="FullName">Language Speaks</label>
                                            <span class="autocomplete-select"></span>
                                            <label id="language-error" class="error" for="language"
                                                style="display: none;">{{ __('profile.required_language') }}</label>
                                        </div>



                                        <div class="form-group">
                                            <label for="FullName">Experience</label>
                                            <input type="text" placeholder="Experience" name="experience"
                                                class="form-control" value="{{ @$data->experience }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">Expertise</label>
                                            <span class="autocomplete-select1"></span>
                                            <label id="expertise-error" class="error"
                                                style="display: none;">{{ __('profile.required_expertise') }}</label>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 ">
                                            <label for="FullName">Astrologer Type</label>
                                            <div class="checkBox">

                                                <ul>
                                                    <li class="checkBoxAstroTP">
                                                        <input type="radio" id="astro_p" class="astro_type_select" name="astrologer_type"
                                                            value="1" @if (@$data->astrologer_type == 1) checked="" @endif>
                                                        <label for="astro_p">Platinum</label>
                                                    </li>
                                                    <li class="checkBoxAstroTP">
                                                        <input type="radio" id="astro_g" class="astro_type_select" name="astrologer_type"
                                                            value="2" @if (@$data->astrologer_type == 2) checked="" @endif>
                                                        <label for="astro_g">Gold</label>
                                                    </li>
                                                    <li class="checkBoxAstroTP">
                                                        <input type="radio" id="astro_s" class="astro_type_select" name="astrologer_type"
                                                            value="3" @if (@$data->astrologer_type == 3) checked=""  @endif @if (@$data->astrologer_type == 0) checked=""  @endif>
                                                        <label for="astro_s">Silver</label>
                                                    </li>
                                                </ul>
                                                <div><label id="astrologer_type-error" class="error" for="astrologer_type"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <input type="hidden" id="image_url" value="{{@$data->design_picture}}">
                                            <label for="Email">Profile Image</label>
                                            <div class="uplodimgfil" style="margin-top: 5px;">
                                                {{-- <input type="file" name="image" id="file-1" class="inputfile inputfile-1" onchange="fun1()" data-multiple-caption="{count} files selected" multiple /> --}}
                                                <input type="hidden" name="profile_picture" id="profile_picture">
                                                <input type="file" id="file-1" name="profile_pic">
                                                <label for="file-1">Upload Image<img
                                                        src="{{ asset('public/admin/assets/images/clickhe.png') }}"
                                                        alt=""></label>
                                            </div>
                                            <label for="profile_pic" id="image-error" class="error"></label>
                                        </div>

                                        <div class="form-group" style="position: relative;">
                                            <a class="del_image del-custom-class" data-id="{{@$data->id}}" @if(@$data->profile_img=='') style="display:none " @endif > <i class="fa fa-times" aria-hidden="true"></i> </a>
                                            <div class="uplodimgfilimg ">
                                                <em><img src="{{ URL::to('storage/app/public/profile_picture') }}/{{ @$data->profile_img }}"
                                                        alt="" id="img2"></em>
                                            </div>

                                        </div>


                                        <div class="form-group rm03">
                                            <label for="AboutMe">About</label>
                                            <textarea style="height: 80px" id="AboutMe" name="about"
                                                class="form-control about">{{ @$data->about }}</textarea>
                                            <div class="error" id="description_error"></div>
                                        </div>
                                        <div class="form-group rm03">
                                            <label for="why_who">Why & Who</label>
                                            <textarea style="height: 80px" id="why_who" name="why_who"
                                                class="form-control why_who">{{ @$data->why_who }}</textarea>
                                            <div class="error" id="why_who_error"></div>
                                        </div>
                                        <div class="form-group rm03">
                                            <label for="AboutMe">Heading One *</label>
                                            <input type="text" placeholder="Heading One " name="heading_one" class="form-control new-form" value="Assurance/ Guarantee/Warranties">
                                            <div id="error_heading_one"></div>
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="AboutMe">Description One *</label>
                                            <textarea style="height: 80px"  name="description_one" class="form-control description_one" placeholder="Description One" id="description_one">{{@$data->description_one}}</textarea>
                                            <div class="error" id="error_description_one"></div>
                                        </div>




                                        <div class="form-group rm03">
                                            <label for="AboutMe">Heading Two *</label>
                                            <input type="text" placeholder="Heading Two" name="heading_two" class="form-control new-form" value="{{@$data->heading_two}}">
                                            <div class="error" id="error_heading_two"></div>
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="AboutMe">Description Two *</label>
                                            <textarea style="height: 80px"  name="description_two" class="form-control description_two" placeholder="Description Two" id="description_two">{{@$data->description_two}}</textarea>
                                            <div class="error" id="error_description_two"></div>
                                        </div>


                                        <div class="form-group rm03">
                                            <label for="AboutMe">Heading Three *</label>
                                            <input type="text" placeholder="Heading Three" value="{{@$data->heading_three}}" name="heading_three" class="form-control new-form" value="">
                                            <div class="error" id="error_heading_three"></div>
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="AboutMe">Description Three *</label>
                                            <textarea style="height: 80px"  name="description_three" class="form-control description_three" placeholder="Description Three" id="description_three">{{@$data->description_three}}</textarea>
                                            <div class="error" id="error_description_three"></div>
                                        </div>

                                        <div class="form-group rm03">
                                            <h4>Pricing Information</h4>
                                        </div>

                                        <div class="form-group rm03">
                                            <div class="availability_check">
                                                <input id="audio_call_check" type="checkbox" value="audio_call_check"
                                                    name="audio_call_check" @if (@$data->is_audio_call == 'Y') checked @endif>
                                                <label for="audio_call_check">I offer audio call</label>
                                            </div>

                                        </div>


                                        <div class="row" id="audio_call_div" @if (@$data->is_audio_call == 'N') style="display: none;" @endif>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For Audio Call / min (Inr)</label>
                                                    <input type="text" placeholder="Price For Audio Call/min (Inr)"
                                                        @if (@$data->call_price != 0)value="{{ @$data->call_price }}"   @endif name="call_price">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For Audio Call / min (Usd)</label>
                                                    <input type="text" placeholder="Price For Audio Call/min (Usd)"
                                                        @if (@$data->call_price_usd != 0) value="{{ @$data->call_price_usd }}" @endif name="call_price_usd">
                                                </div>
                                            </div>



                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For Audio Call / min (Inr)(%)</label>
                                                    <input type="text" placeholder="Discount For Audio Call / min (Inr)"
                                                        value="{{ @$data->call_discount_inr }}" name="call_discount_inr">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For Audio Call / min (Usd)(%)</label>
                                                    <input type="text" placeholder="Discount For Audio Call / min (Usd)"
                                                        value="{{ @$data->call_discount_usd }}" name="call_discount_usd">
                                                </div>
                                            </div>



                                        </div>


                                        <div class="col-md-6 col-sm-6" id="avail_now_audio_call_div"
                                            @if (@$data->is_audio_call == 'N') style="display: none;" @endif>
                                            <div class="form-group rm03">
                                                <div class="checkBox">
                                                    <span>I am currently available for audio call ?</span>
                                                    <ul>
                                                        <li>
                                                            <input type="radio" id="radio12" name="avail_now_audio_call"
                                                                value="Y" @if (@$data->avail_now_audio_call == 'Y') checked @endif>
                                                            <label for="radio12">Yes</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="radio13" name="avail_now_audio_call"
                                                                value="N" @if (@$data->avail_now_audio_call == 'N') checked @endif>
                                                            <label for="radio13">No</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>


                                        <div class="form-group rm03">
                                            <div class="availability_check">
                                                <input id="video_call_check" type="checkbox" value="video_call_check"
                                                    name="video_call_check" @if (@$data->is_video_call == 'Y') checked @endif>
                                                <label for="video_call_check">I offer video call</label>
                                            </div>
                                        </div>

                                        <div class="row" id="video_call_div" @if (@$data->is_video_call == 'N') style="display: none;" @endif>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For Video Call /min (Inr)</label>
                                                    <input type="text" placeholder="Price For Video Call/min (Inr)"
                                                        @if (@$data->video_call_price_inr != 0) value="{{ @$data->video_call_price_inr }}" @endif name="video_call_price_inr">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For Video Call /min (Usd)</label>
                                                    <input type="text" placeholder="Price For Video Call /min (Usd)"
                                                        @if (@$data->video_call_price_usd != 0) value="{{ @$data->video_call_price_usd }}" @endif name="video_call_price_usd">
                                                </div>
                                            </div>



                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For Video Call / min (Inr)(%)</label>
                                                    <input type="text" placeholder="Discount For Video Call / min (Inr)"
                                                        value="{{ @$data->video_call_discount_inr }}"
                                                        name="video_call_discount_inr">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For Video Call / min (Usd)(%)</label>
                                                    <input type="text" placeholder="Discount For Video Call / min (Usd)"
                                                        value="{{ @$data->video_call_discount_usd }}"
                                                        name="video_call_discount_usd">
                                                </div>
                                            </div>


                                        </div>


                                        <div class="col-md-6 col-sm-6" id="avail_now_video_call_div"
                                            @if (@$data->is_video_call == 'N') style="display: none;" @endif>
                                            <div class="form-group rm03">
                                                <div class="checkBox">
                                                    <span>I am currently available for video call ?</span>
                                                    <ul>
                                                        <li>
                                                            <input type="radio" id="radio14" name="avail_now_video_call"
                                                                value="Y" @if (@$data->avail_now_video_call == 'Y') checked @endif>
                                                            <label for="radio14">Yes</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="radio15" name="avail_now_video_call"
                                                                value="N" @if (@$data->avail_now_video_call == 'N') checked @endif>
                                                            <label for="radio15">No</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>


                                        <div class="form-group rm03">
                                            <div class="availability_check">
                                                <input id="chat_check" type="checkbox" value="chat_check" name="chat_check"
                                                    @if (@$data->is_chat == 'Y') checked @endif>
                                                <label for="chat_check">I offer chat</label>
                                            </div>
                                        </div>


                                        <div class="row" id="chat_div" @if (@$data->is_chat == 'N') style="display: none;" @endif>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For Chat /min (Inr)</label>
                                                    <input type="text" placeholder="Price For Video Chat /min (Inr)"
                                                        @if (@$data->chat_price_inr != 0) value="{{ @$data->chat_price_inr }}" @endif name="chat_price_inr">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For Chat /min (Usd)</label>
                                                    <input type="text" placeholder="Price For Video Chat /min (Usd)"
                                                        @if (@$data->chat_price_usd != 0) value="{{ @$data->chat_price_usd }}" @endif name="chat_price_usd">
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For Chat / min (Inr)(%)</label>
                                                    <input type="text" placeholder="Discount For Chat / min (Inr)"
                                                        value="{{ @$data->chat_discount_inr }}" name="chat_discount_inr">
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For Chat / min (Usd)(%)</label>
                                                    <input type="text" placeholder="Discount For Chat / min (Usd)"
                                                        value="{{ @$data->chat_discount_usd }}" name="chat_discount_usd">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6" id="avail_now_chat_div" @if (@$data->is_chat == 'N') style="display: none;" @endif>
                                            <div class="form-group rm03">
                                                <div class="checkBox">
                                                    <span>I am currently available for chat ?</span>
                                                    <ul>
                                                        <li>
                                                            <input type="radio" id="radio16" name="avail_now_chat" value="Y"
                                                                @if (@$data->avail_now_chat == 'Y') checked @endif>
                                                            <label for="radio16">Yes</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio" id="radio17" name="avail_now_chat" value="N"
                                                                @if (@$data->avail_now_chat == 'N') checked @endif>
                                                            <label for="radio17">No</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group rm03">
                                            <div class="availability_check">
                                                <input id="offline_check" type="checkbox" value="offline_check" name="offline_check"
                                                    @if (@$data->is_astrologer_offer_offline == 'Y') checked @endif >
                                                <label for="offline_check">I offer offline service</label>
                                            </div>
                                        </div>


                                        <div class="row" id="offline_div" @if (@$data->is_astrologer_offer_offline == 'N') style="display: none;" @endif>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For offline service /min (Inr)</label>
                                                    <input type="text" class="required" placeholder="Price For offline service /min (Inr)"
                                                        @if (@$data->astrologer_offline_price_inr != 0) value="{{ @$data->astrologer_offline_price_inr }}" @endif name="offline_price_inr">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Price For offline service /min (Usd)</label>
                                                    <input type="text" class="required" placeholder="Price For offline service /min (Usd)"
                                                        @if (@$data->astrologer_offline_price_usd != 0) value="{{ @$data->astrologer_offline_price_usd }}" @endif name="offline_price_usd">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For offline service / min (Inr)(%)</label>
                                                    <input type="text" placeholder="Discount For offline service / min (Inr)"
                                                        value="{{ @$data->offline_discount_price_inr }}" name="offline_discount_price_inr">
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-6">
                                                <div class="form-group rm03">
                                                    <label>Discount For offline service / min (Usd)(%)</label>
                                                    <input type="text" placeholder="Discount For offline service / min (Usd)"
                                                        value="{{ @$data->offline_discount_price_usd }}" name="offline_discount_price_usd">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group rm03">
                                            <h4>Address Information</h4>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">Country</label>
                                            <select class="form-control rm06 " name="country" id="country">
                                                <option value="">Select Country</option>

                                                @foreach (@$countries as $country)
                                                    <option value="{{ @$country->id }}" @if ($data->country_id == @$country->id)selected @endif>
                                                        {{ @$country->name }}</option>
                                                @endforeach

                                            </select>
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">State</label>
                                            <select class="form-control rm06 " name="state" id="states">
                                                <option value="">Select State</option>

                                                @foreach (@$states as $state)
                                                    <option value="{{ @$state->id }}" @if ($data->state == @$state->id)selected @endif>
                                                        {{ @$state->name }}</option>
                                                @endforeach

                                            </select>
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        {{-- <div class="form-group">
                                            <label for="FullName">City</label>
                                            <input type="text" placeholder="City" name="city" class="form-control"
                                                value="{{ @$data->city }}">
                                            <div class="error" id="price_error"></div>
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="FullName">City</label>
                                            <select class="form-control rm06 " name="city" id="city">
                                                <option value="">Select City</option>

                                                @foreach (@$cities as $city)
                                                    <option value="{{ @$city->id }}" @if ($data->city == @$city->id)selected @endif>
                                                        {{ @$city->name }}</option>
                                                @endforeach

                                            </select>
                                            <div class="error" id="city_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="FullName">Pincode</label>
                                            <input type="text" placeholder="Pincode" name="pincode" id="pincode" class="form-control"
                                                value="{{ @$data->pincode }}">
                                                <label id="pincode-error" class="error" for="pincode"></label>
                                        </div>
                                        <div class="form-group" id="areaDropDiv" @if(!@$data->area)  style="display: none" @endif>
                                            <label for="FullName">Area</label>
                                            <select class="form-control rm06 " name="area_drop" id="areaDrop">
                                                <option value="">Select Area</option>
                                                @if(@$areas)
                                                    @foreach (@$areas as $ar)
                                                        <option value="{{$ar->id}}" {{@$data->area==$ar->id?'selected':''}} >{{@$ar->area}}</option>
                                                    @endforeach
                                                    <option value="O">Other</option>
                                                @endif
                                            </select>
                                            <label id="areaDrop-error" class="error" for="areaDrop"></label>
                                        </div>
                                        <div class="form-group" id="areaTextDiv" style="display: none">
                                                <label for="FullName">Area</label>
                                                <input type="text" class="login-type" placeholder="Area" id="areaText" name="area" value="{{ old('area') }}">
                                                <label id="areaText-error" class="error" for="areaText"></label>
                                        </div>
                                        <div class="form-group rm03">
                                            <label for="FullName">Address</label>
                                            <input type="text" placeholder="Address" name="address" class="form-control"
                                                value="{{ @$data->address }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group rm03">
                                            <h4>Account Information</h4>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">Bank Name</label>
                                            <input type="text" placeholder="Bank Name" name="bank_name"
                                                class="form-control" value="{{ @$data->userAccount->bank_name }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">A/C No</label>
                                            <input type="text" placeholder="A/C No" name="ac_no" class="form-control"
                                                value="{{ @$data->userAccount->ac_no }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group ">
                                            <label for="FullName">IFSC Code</label>
                                            <input type="text" placeholder="IFSC Code" name="ifsc" class="form-control"
                                                value="{{ @$data->userAccount->ifsc_code }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group ">
                                            <label for="FullName">Name of account holder</label>
                                            <input type="text" placeholder="Name of account holder"
                                                name="name_of_account_holder" class="form-control"
                                                value="{{ @$data->userAccount->account_holder }}">
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="form-group ">
                                            <label for="FullName">Account Type</label>
                                            <select class="form-control rm06" name="profile_type" id="category">
                                                <option value="">Select Account Type</option>
                                                <option value="S" @if (@$data->Ac_Type == 'S') selected @endif>Savings</option>
                                                <option value="C" @if (@$data->Ac_Type == 'C') selected @endif>Current</option>

                                            </select>
                                            <div class="error" id="price_error"></div>
                                        </div>

                                        <div class="form-group ">
                                            <label for="FullName">Gst No (optional)</label>
                                            <input type="text" placeholder="Gst No" name="gst_no" class="form-control"
                                                value="{{ @$data->gst_no }}">
                                            <div class="error" id="price_error"></div>
                                        </div>



                                        <input type="hidden" name="expertise" id="expertise">
                                        <input type="hidden" name="language" id="language">


                                        <div class="clearfix"></div>
                                        <div class="col-lg-12"> <button
                                                class="btn btn-primary waves-effect waves-light w-md"
                                                type="submit">Save</button></div>
                                    </form>

                                    <div class="modal" tabindex="-1" role="dialog" id="croppie-modal">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Crop Image</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
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
                                                    <button type="button" class="btn btn-primary" id="crop-img">Save
                                                        changes</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Personal-Information -->


                        </div>
                    </div>
                </div>
                <!-- End row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

        @include('admin.includes.footer')
    </div>
@endsection
@section('script')
    @include('admin.includes.script')
    <script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
    <script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

    <script type="text/javascript">
  $('.del_image').on('click',function(e){
    if(confirm("Do You want remove this image?")){
    var id = $(this).data('id');
    $('#image_url').val('');
    $('#icon').val('');
    $('#profile_picture').val('');
    $.ajax({
      url:'{{route('admin.astrologer.delete.profile.picture')}}',
      type: "POST",
      data:{
         id:id,
        _token: '{{ csrf_token() }}',
      },

      success: function(res) {
        $("#img2").attr("src",'');
        $('.uplodimgfilimg').hide();
        $('.del_image').hide();
      }
  });
  }
  })
</script>


    <script>
        function dataURLtoFile(dataurl, filename) {

            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {
                type: mime
            });
        }
        var uploadCrop;
        $(document).ready(function() {
            $(".js-example-basic-multiple").select2();
            if ($('.type').val() == 'C') {
                $(".s_h_hids").slideDown(0);
            } else {
                $(".s_h_hids").slideUp(0);
            }
            $(".ccllk02").click(function() {
                $(".s_h_hids").slideDown();
            });
            $(".ccllk01").click(function() {
                $(".s_h_hids").slideUp();
                $('.cmpy').val('');
            });
            $(".type-radio").change(function() {
                var t = $("input[name=type]:checked").val();
                if (t == "I") {
                    $(".comany_name").css('display', 'none');
                } else {
                    $(".comany_name").css('display', 'block');
                }
            });



            $('#croppie-modal').on('hidden.bs.modal', function() {
                uploadCrop.croppie('destroy');
            });

            $('#croppie-modal .close, #croppie-modal .close_btn').on('click', function() {
            $('#icon').val('');
            $('.del_image').hide();
            $('#profile_picture').val('');
          });

            $('#crop-img').click(function() {
                uploadCrop.croppie('result', {
                    type: 'base64',
                    format: 'png'
                }).then(function(base64Str) {
                    $("#croppie-modal").modal("hide");
                    //  $('.lds-spinner').show();
                    let file = dataURLtoFile('data:text/plain;' + base64Str + ',aGVsbG8gd29ybGQ=',
                        'hello.png');
                    console.log(file.mozFullPath);
                    console.log(base64Str);
                    $('#profile_picture').val(base64Str);
                    // $.each(file, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('.uplodimgfilimg').append('<em><img  src="' + e.target.result +
                            '"><em>');
                    };
                    reader.readAsDataURL(file);

                    //  });
                    $('.uplodimgfilimg').show();
                    $('.del_image').show();

                });
            });
        });
        $("#file-1").change(function() {
            $('.uplodimgfilimg').html('');
            let files = this.files;
            console.log(files);
            let img = new Image();
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (!valid) {
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
                    viewport: {
                        width: 256,
                        height: 256,
                        type: 'square'
                    },
                    boundary: {
                        width: $(".croppie-div").width(),
                        height: 400
                    }
                });
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('.upload-demo').addClass('ready');
                    // console.log(e.target.result)
                    uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function() {
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
    <script type="text/javascript">
        tinymce.init({
        //selector: "textarea",
        mode : "specific_textareas",
        editor_selector :/(description_one|description_two|description_three)/,
        forced_root_block : "",
        relative_urls : false,
        entity_encoding: 'raw',
        menubar: "",
         plugins: [

        "searchreplace wordcount visualblocks visualchars code fullscreen link",
        "lists",


        "emoticons template paste textcolor colorpicker textpattern imagetools"
        ],
        toolbar1: ",link,unlink ",
            });

        </script>
    <script>
        $(document).ready(function() {

            jQuery.validator.addMethod("validate_email", function(value, element) {
                if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                    return true;
                } else {
                    return false;
                }
            }, "{{ __('Please enter valid email') }}");
            $("#edit_profile").validate({
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        validate_email: true,
                        remote: {
                            url: '{{ route('admin.astrologer.check-email') }}',
                            type: "POST",
                            data: {
                                email: function() {
                                    return $("#email").val();
                                },
                                _token: '{{ csrf_token() }}',
                                id: '{{ @$data->id }}',
                            }
                        },
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true,
                        remote: {
                            url: '{{ route('admin.astrologer.check-mobile') }}',
                            type: "POST",
                            data: {
                                mobile: function() {
                                    return $("#mobile").val();
                                },
                                _token: '{{ csrf_token() }}',
                                id: '{{ @$data->id }}',
                            }
                        },
                    },
                    state: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },
                    country: {
                        required: true,
                    },
                    profile_pic: {
                        required: true,
                    },
                    // about: {
                    //     required: true,
                    // },
                    bank_name: {
                        required: true,
                    },
                    ac_no: {
                        required: true,
                        number: true,
                        maxlength: 16,
                    },
                    ifsc: {
                        required: true,
                    },
                    name_of_account_holder: {
                        required: true,
                    },
                    experience: {
                        required: true,
                        number: true,
                        min: 1,
                        max: 99,
                    },
                    call_price: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    call_price_usd: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    video_call_price_inr: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    video_call_price_usd: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    chat_price_inr: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    chat_price_usd: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    expertise: {
                        required: true,
                    },
                    language: {
                        required: true,
                    },
                    profile_type: {
                        required: true,
                    },
                    pincode: {
                        required: true,
                        minlength: 6,
                        maxlength: 6,
                        number: true,
                    },
                    gst_no: {
                        minlength: 15,
                        maxlength: 20,
                    },
                    astrologer_type:{
                        required:true
                    },
                    heading_one:{
                        required:true,
                    },
                },
                messages: {
                    first_name: {
                        required: 'Please enter your first name',
                    },
                    email: {
                        required: 'Please enter your email',
                        validate_email: 'Please enter your email properly',
                        remote: 'Email already exits.Try another',

                    },
                    mobile: {
                        required: 'Please enter your mobile number',
                        remote: 'Mobile no already exits.Try another',
                        minlength: 'Mobile number must be 10digits',
                        maxlength: 'Mobile number must be 10digits',
                    },
                    last_name: {
                        required: 'Please enter your last name'
                    },
                    state: {
                        required: 'please select your state',
                    },
                    address: {
                        required: 'Please enter your address',
                    },
                    city: {
                        required: 'Please enter your city',
                    },
                    country: {
                        required: 'Please select your country',
                    },
                    pincode: {
                        required: 'Please enter your pincode',
                        minlength: 'Please enter your pincode properly',
                        maxlength: 'Please enter your pincode properly',
                        number: 'Please enter your pincode properly',
                    },
                    profile_pic: {
                        required: 'Please upload an image',
                    },
                    about: {
                        required: 'Please enter about',
                    },
                    why_who: {
                        required: 'Please enter Why & Who',
                    },
                    bank_name: {
                        required: 'Please enter bank name',
                    },
                    profile_type: {
                        required: 'Please select account type',
                    },
                    ac_no: {
                        required: 'Please enter account number',
                        number: 'Please enter account number properly',
                        maxlength: 'Bank Account number not greater than 16 digit',
                    },
                    ifsc: {
                        required: 'Please enter ifsc code',
                    },
                    name_of_account_holder: {
                        required: 'Please enter account holder name',
                    },
                    experience: {
                        required: 'Please enter experience',
                        number: 'Please enter experience in number',
                        min: 'Please enter your of experience properly',
                        max: 'Year of experience can not be more than 99',
                    },
                    call_price: {
                        required: 'Please enter audio call price per min inr',
                        number: '{{ __('profile.number_call_price') }}',
                        min: 'Please enter audio call price inr properly',
                    },
                    call_price_usd: {
                        required: 'Please enter audio call price per min usd',
                        number: 'Only number allowed',
                        min: 'Please enter audio call price usd properly',
                    },
                    video_call_price_inr: {
                        required: 'Please enter video call price per min inr',
                        number: 'Only number allowed',
                        min: 'Please enter video call price inr properly',
                    },
                    video_call_price_usd: {
                        required: 'Please enter video call price per min usd',
                        number: 'Only number allowed',
                        min: 'Please enter video call price usd properly',
                    },
                    chat_price_inr: {
                        required: 'Please enter chat price per min inr',
                        number: 'Only number allowed',
                        min: 'Please enter chat price inr properly',
                    },
                    chat_price_usd: {
                        required: 'Please enter chat price per min usd',
                        number: 'Only number allowed',
                        min: 'Please enter chat price usd properly',
                    },
                    expertise: {
                        required: 'Pleaser select expertise',
                    },
                    language: {
                        required: 'Please select language',
                    },
                    gst_no: {
                        minlength: 'Please enter atleast 15 characters',
                        maxlength: 'Gst number should not be greater than 20 characters',
                    },
                    astrologer_type:{
                        required:"Please select this field"
                    },
                },
                submitHandler: function(form) {
                    // tinyMCE.triggerSave();
                    // var status;
                    // status = $("#edit_profile").valid();
                    // console.log(status)
                    // return false;
                    var img = $('#profile_picture').val();
                    var old = '{{ @$data->profile_img }}';
                    var expertise = $('#expertise').val();
                    var language = $('#language').val();
                    var heading1 = $('#heading_one').val();
                    var heading2 = $('#heading_two').val();
                    var heading3 = $('#heading_three').val();

                    var gender_select = $('.gender_select').val();
                    if ($(".gender_select:checked").length > 1 || $(".gender_select:checked").length ==
                        0) {
                        $('#gender-error').html('Please select your gender');
                        $('#gender-error').css('display', 'block');
                        return false;
                    }


                    if (img == '' && old == '') {
                        $('#image-error').html('Please upload your profile pic');
                        $('#image-error').css('display', 'block');
                        return false;
                    } else if (expertise == '' && language == '') {
                        $('#expertise-error').html('Please select expertise');
                        $('#expertise-error').css('display', 'block');
                        $('#language-error').html('Please select speaks language');
                        $('#language-error').css('display', 'block');
                        return false;
                    } else if (expertise == '') {
                        $('#expertise-error').html('Please select expertise');
                        $('#expertise-error').css('display', 'block');
                        return false;
                    } else if (language == '') {
                        $('#language-error').html('Please select speaks language');
                        $('#language-error').css('display', 'block');
                        return false;
                    } else if (tinyMCE.get('description_one').getContent()!="" && heading1 === undefined) {
                        $('#error_heading_two').html('Please enter heading one');
                        $('#error_heading_two').css('display', 'block');
                        return false;
                    else if (heading1 !== undefined && tinyMCE.get('description_one').getContent() == '') {
                        $('#error_description_two').html('Please enter description one');
                        $('#error_description_two').css('display', 'block');
                        return false;
                    } else if (heading2 !== undefined && tinyMCE.get('description_two').getContent() == '') {
                        $('#error_description_two').html('Please enter description two');
                        $('#error_description_two').css('display', 'block');
                        return false;
                    } else if (tinyMCE.get('description_two').getContent()!="" && heading2 === undefined) {
                        $('#error_heading_two').html('Please enter heading two');
                        $('#error_heading_two').css('display', 'block');
                        return false;
                    } else if (heading3 !== undefined && tinyMCE.get('description_three').getContent() == '') {
                        $('#error_description_three').html('Please enter description three');
                        $('#error_description_three').css('display', 'block');
                        return false;
                    } else if (tinyMCE.get('description_three').getContent()!="" && heading3 === undefined) {
                        $('#error_description_three').html('Please enter description three');
                        $('#error_description_three').css('display', 'block');
                        return false;
                    } else if ($('input[name="chat_check"]').prop("checked") == false && $(
                            'input[name="audio_call_check"]').prop("checked") == false && $(
                            'input[name="video_call_check"]').prop("checked") == false) {
                        alert('Please select at least one offer from audio call/video call/Chat');
                        return false;
                    } else {

                            form.submit();

                    }
                }
            });

        })
    </script>
    <script>
        $(document).ready(function() {
            /*all expertise data push in array*/
            var data = [];
            @foreach ($allExpertise as $allExpertises)
                data.push({ label : '{{ $allExpertises->expertise_name }}', value : '{{ $allExpertises->id }}'});
            @endforeach
            console.log(data);
            /*end*/
            /*user expertise data push in array*/
            var expertisevalue = [];
            @foreach (@$data->astrologerExpertise as $expertises)
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
                    console.log({
                        value
                    });
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
            @foreach ($allLanguage as $allLanguages)
                dataLanguage.push({ label : '{{ $allLanguages->language_name }}', value : '{{ $allLanguages->id }}'});
            @endforeach
            console.log(dataLanguage);
            /*end*/
            /*user language data push in array*/
            var languagevalue = [];
            @foreach (@$data->astrologerLanguage as $languages)
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
        })
    </script>

    <script>
        jQuery(document).ready(function() {
            // Select2
            jQuery(".select2").select2({
                width: '100%'
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#country').on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();

                $.ajax({
                    url: '{{ route('admin.astrologer.get-state') }}',
                    type: 'GET',
                    data: {
                        country: id,
                        id: '{{ @$data->state }}'
                    },
                    success: function(data) {
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
                            url: "{{route('admin.astrologer.get.city')}}",
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
                    url: "{{route('admin.astrologer.get.area')}}",
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


    {{-- pricing-fundamentals --}}

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name="audio_call_check"]').click(function() {
                if ($(this).prop("checked") == true) {
                    $('#audio_call_div').show();
                    $('#avail_now_audio_call_div').css('display', 'block');
                } else if ($(this).prop("checked") == false) {
                    $('#audio_call_div').css('display', 'none');
                    $('#avail_now_audio_call_div').css('display', 'none');
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name="video_call_check"]').click(function() {
                if ($(this).prop("checked") == true) {
                    $('#video_call_div').show();
                    $('#avail_now_video_call_div').css('display', 'block');
                } else if ($(this).prop("checked") == false) {
                    $('#video_call_div').css('display', 'none');
                    $('#avail_now_video_call_div').css('display', 'none');
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name="chat_check"]').click(function() {
                if ($(this).prop("checked") == true) {
                    $('#chat_div').show();
                    $('#avail_now_chat_div').css('display', 'block');
                } else if ($(this).prop("checked") == false) {
                    $('#chat_div').css('display', 'none');
                    $('#avail_now_chat_div').css('display', 'none');
                }
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input[name="offline_check"]').click(function() {
                if ($(this).prop("checked") == true) {
                    $('#offline_div').show();
                } else if ($(this).prop("checked") == false) {
                    $('#offline_div').css('display', 'none');
                }
            });
        });
    </script>
@endsection
