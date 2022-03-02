@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Astrologer</title>
@endsection

@section('style')
@include('admin.includes.style')
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')


 <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">



                <div class="wraper container-fluid">

                    <div class="row">
                      <div class="col-sm-12">
                        <h4 class="pull-left page-title">Astrologer Details</h4>
                        <ol class="breadcrumb pull-right">
                          <li class="active"><a href="{{route('admin.manage.astrologer')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                        </ol>
                      </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-12">

                        <div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Personal Information</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="about-info-p">
                                                    <strong>User Availability</strong>
                                                    <br>
                                                    <p class="text-muted">@if(@$user->user_availability=="Y")Yes @else No @endif</p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Full Name</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$user->first_name}} {{@$user->last_name}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Astrologer Code</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                        @if(@$user->user_unique_code!="")
                                                        {{@$user->user_unique_code}}
                                                        @else
                                                        --
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Mobile</strong>
                                                    <br>
                                                    <p class="text-muted">+91 {{@$user->mobile}}</p>
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Email</strong>
                                                    <br>
                                                    <p class="text-muted">{{@$user->email}}</p>
                                                </div>
                                                 <div class="about-info-p">
                                                    <strong>Gender</strong>
                                                    <br>
                                                   @if(@$user->gender!="")
                                                    <p class="text-muted">
                                                    	@if(@$user->gender=="M")
                                                    	Male
                                                    	@else
                                                    	Female
                                                    	@endif
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Asrtrologer type</strong>
                                                    <br>
                                                   @if(@$user->astrologer_type!="")
                                                    <p class="text-muted">
                                                    	@if(@$user->astrologer_type==1)
                                                    	Platinum
                                                        @elseif(@$user->astrologer_type==2)
                                                        Gold
                                                    	@else
                                                    	Silver
                                                    	@endif
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>
                                                @if(@$user->is_call=="Y")
                                                <div class="about-info-p">
                                                    <strong>Audio Call Charges</strong>
                                                    <br>

                                                    <p class="text-muted">
                                                    Rs.{{@$user->call_price}}/min.
                                                    </p>
                                                    <p class="text-muted">
                                                    Usd.{{@$user->call_price_usd}}/min.
                                                    </p>
                                                </div>
                                                @endif

                                                 @if(@$user->is_video_call=="Y")
                                                <div class="about-info-p">
                                                    <strong>Video Call Charges</strong>
                                                    <br>

                                                    <p class="text-muted">
                                                    Rs.{{@$user->video_call_price_inr}}/min.
                                                    </p>
                                                    <p class="text-muted">
                                                    Usd.{{@$user->video_call_price_usd}}/min.
                                                    </p>
                                                </div>
                                                @endif
                                                @if(@$user->is_astrologer_offer_offline=="Y")
                                                <div class="about-info-p">
                                                    <strong>Offline Service Charges</strong>
                                                    <br>

                                                    <p class="text-muted">
                                                    Rs.{{@$user->astrologer_offline_price_inr}}/min.
                                                    </p>
                                                    <p class="text-muted">
                                                    Usd.{{@$user->astrologer_offline_price_usd}}/min.
                                                    </p>
                                                </div>
                                                @endif

                                                @if(@$user->is_chat=="Y")
                                                <div class="about-info-p">
                                                    <strong>Chat Charges</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    Rs.{{@$user->chat_price_inr}}/min.
                                                    </p>
                                                    <p class="text-muted">
                                                    Usd.{{@$user->chat_price_usd}}/min.
                                                    </p>
                                                </div>
                                                @endif

                                                <div class="about-info-p">
                                                    <strong>Experience</strong>
                                                    <br>
                                                    @if(@$user->experience!="")
                                                    <p class="text-muted">
                                                    {{@$user->experience}} Years
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Country</strong>
                                                    <br>
                                                    @if(@$user->country_id!="")
                                                    <p class="text-muted">
                                                    {{@$user->countries->name}}
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>

                                                 <div class="about-info-p">
                                                    <strong>State</strong>
                                                    <br>
                                                     @if(@$user->state!="")
                                                    <p class="text-muted">{{@$user->states->name}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>City</strong>
                                                    <br>
                                                    @if(@$user->city!="")
                                                    <p class="text-muted">{{@$user->getCity->name}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                    @endif
                                                </div>

                                                   <div class="about-info-p">
                                                    <strong>Address</strong>
                                                    <br>
                                                     @if(@$user->address!="")
                                                    <p class="text-muted">{{@$user->address}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>


                                                <div class="about-info-p">
                                                    <strong>Pincode</strong>
                                                    <br>
                                                     @if(@$user->pincode!="")
                                                    <p class="text-muted">{{@$user->pincode}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Area</strong>
                                                    <br>
                                                     @if(@$user->getArea->area!="")
                                                    <p class="text-muted">{{@$user->getArea->area}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>
                                                <div class="about-info-p">
                                                    <strong>Gst No</strong>
                                                    <br>
                                                     @if(@$user->gst_no!="")
                                                    <p class="text-muted">{{@$user->gst_no}}</p>
                                                    @else
                                                    <p class="text-muted"> -- </p>
                                                     @endif
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Profile Picture</strong>
                                                    <br>
                                                    @if(@$user->profile_img!="")
                                                    <p class="text-muted">
                                                    	<img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$user->profile_img}}" style="width: 200px;height: 200px;margin-top: 3px">
                                                    </p>
                                                    @else
                                                    <p class="text-muted"> No Image </p>
                                                    @endif
                                                </div>

                                                  <div class="about-info-p">
                                                    <strong>Mobile Verified</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    	@if(@$user->is_mobile_verify=="Y")
                                                    	Verified
                                                    	@else
                                                    	Not Verified
                                                    	@endif
                                                    </p>
                                                </div>

                                                <div class="about-info-p">
                                                    <strong>Email Verified</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    	@if(@$user->is_email_verify=="Y")
                                                    	Verified
                                                    	@else
                                                    	Not Verified
                                                    	@endif
                                                    </p>
                                                </div>

                                                 <div class="about-info-p">
                                                    <strong>Status</strong>
                                                    <br>
                                                    <p class="text-muted">
                                                    	@if(@$user->status=="A")
                                                    	Active
                                                    	@elseif(@$user->status=="I")
                                                    	Inactive
                                                    	@elseif(@$user->status=="U")
                                                    	Unverified
                                                    	@endif
                                                    </p>
                                                </div>


                                                {{-- <div class="about-info-p m-b-0">
                                                    <strong>Location</strong>
                                                    <br>
                                                    <p class="text-muted">Bagnan , Howrah , West Bengal , India</p>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <!-- Personal-Information -->

                                        <!-- Languages -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Languages</h3>
                                            </div>
                                            <div class="panel-body">
                                                <ul>
                                                	@if(@$user->astrologerLanguage->isNotEmpty())
                                                	@foreach(@$user->astrologerLanguage as $language)
                                                    <li>{{@$language->languages->language_name}}</li>
                                                    @endforeach
                                                    @else
                                                    <li>No Language Selected</li>
                                                    @endif
                                                </ul>
                                            </div>

                                        </div>

                                         <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Expertise</h3>
                                            </div>
                                            <div class="panel-body">
                                                <ul>
                                                   @if(@$user->astrologerExpertise->isNotEmpty())
                                                	@foreach(@$user->astrologerExpertise as $exp)
                                                    <li>{{@$exp->experties->expertise_name}}</li>
                                                    @endforeach
                                                    @else
                                                    <li>No Experties Selected</li>
                                                    @endif
                                                </ul>
                                            </div>

                                        </div>
                                        <!-- Languages -->

                                    </div>


                                    <div class="col-md-8">
                                        <!-- Personal-Information -->
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">About Astrologer </h3>
                                            </div>
                                            <div class="panel-body">
                                                <p>
                                                    @if(@$user->about!="")
                                                    {{@$user->about}}
                                                    @else
                                                    No Data
                                                    @endif
                                                </p>
											</div>
                                        </div>
                                        <!-- Personal-Information -->

                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Educational Qualification</h3>
                                            </div>
                                            <div class="panel-body">
                                            	@if(@$user->astrologerEducation->isNotEmpty())
                                            	 @foreach(@$user->astrologerEducation as $education)
                                                 <p class="text-muted">{{@$education->education_title}} - {{@$education->institute}} --- {{@$education->year_of_passing}}</p>
                                                 @endforeach
                                                 @else
                                                 <p class="text-muted"> No Education Added </p>
                                                 @endif

                                            </div>
                                        </div>
                                        <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Experience</h3>
                                            </div>
                                            <div class="panel-body">
                                            	@if(@$user->astrologerExperience->isNotEmpty())
                                            	 @foreach(@$user->astrologerExperience as $experience)
                                                 <p class="text-muted">{{@$experience->experience_title}}-- {{@$experience->year_of_experience}} Years
                                                 	<br>
                                                 	{{@$experience->description}}
                                                 </p>
                                                  @endforeach
                                                  @else
                                                 <p class="text-muted">No Experience Added</p>
                                                 @endif
                                            </div>
                                        </div>

                                         {{-- <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Availability</h3>
                                            </div>
                                            <div class="panel-body">
                                                @if(@$user->userAvailable->isNotEmpty())
                                                 @foreach(@$user->userAvailable as $avail)
                                                    <li>{{@$avail->day}} : {{date('H:i ', strtotime($avail->from_time))}} -  {{date('H:i ', strtotime(@$avail->to_time))}}</li>
                                                  @endforeach
                                                  @else
                                                 <p class="text-muted">No Data</p>
                                                 @endif
                                            </div>
                                        </div> --}}

                                         <div class="panel panel-default panel-fill">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Bank Details</h3>
                                            </div>
                                            <div class="panel-body">

                                                 <p class="text-muted"></p>
                                                <li> <strong>Bank Name</strong> : &nbsp;
                                                    @if(@$user->userAccount->bank_name!="")
                                                    {{@$user->userAccount->bank_name}}
                                                    @else
                                                    --
                                                    @endif
                                                </li>
                                                <li> <strong>A/C No</strong> :  &nbsp;
                                                     @if(@$user->userAccount->ac_no!="")
                                                     {{@$user->userAccount->ac_no}}
                                                     @else
                                                     --
                                                     @endif
                                                </li>
                                                <li> <strong>IFSC Code</strong> :  &nbsp;
                                                    @if(@$user->userAccount->ifsc_code!="")
                                                    {{@$user->userAccount->ifsc_code}}</li>
                                                    @else
                                                    --
                                                    @endif
                                                <li> <strong>Name of account holder</strong> :  &nbsp;
                                                    @if(@$user->userAccount->account_holder!="")
                                                    {{@$user->userAccount->account_holder}}
                                                    @else
                                                    --
                                                    @endif
                                                </li>

                                                  <li> <strong>Account Type</strong> :  &nbsp;
                                                    @if(@$user->Ac_Type!="")
                                                    @if(@$user->Ac_Type=='S')
                                                    Savings
                                                    @else
                                                    Current
                                                    @endif
                                                    @else
                                                    --
                                                    @endif
                                                </li>


                                            </div>
                                        </div>

                                    </div>

                                </div>


                             <!-- Personal-Information -->
                                {{-- <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Call History</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th> Name</th>
                                                                        <th> Date</th>
                                                                        <th>Duration</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Sayanti Das</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Moltran Admin</td>
                                                                        <td>01/01/2015</td>
                                                                        <td>14 Minutes  </td>
                                                                        <td>₹129</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                    </div>
                                </div> --}}

                            @if(@$avail->isNotEmpty())
                            <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Availability</h3>
                                    </div>
                                    <div class="panel-body">
                            @if(@$monday->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                       <label for="day1">Monday</label>
                                      </div>
                                      <div class="slot_check">
                                            <ul>
                                                @foreach(@$monday as $key=> $slot)
                                                <li>
                                                    <input id="chk_monday_{{$slot}}" type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" checked disabled="">
                                                    <label for="chk_monday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endforeach
                                                 </ul>
                                          </div>
                                       </div>
                                </div>
                            </div>
                            @endif


                            @if(@$tuesday->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                       <label for="day1">Tuesday</label>
                                      </div>
                                      <div class="slot_check">
                                            <ul>
                                                @foreach(@$tuesday as $key=> $slot)
                                                <li>
                                                    <input type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" checked disabled="">
                                                    <label>{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endforeach
                                                 </ul>
                                          </div>
                                       </div>
                                </div>
                            </div>
                            @endif


                            @if(@$wednesday->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                       <label for="day1">Wednesday</label>
                                      </div>
                                      <div class="slot_check">
                                            <ul>
                                                @foreach(@$wednesday as $key=> $slot)
                                                <li>
                                                    <input type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" checked disabled="">
                                                    <label>{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endforeach
                                                 </ul>
                                          </div>
                                       </div>
                                </div>
                            </div>
                            @endif

                            @if(@$thursday->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                       <label for="day1">Thursday</label>
                                      </div>
                                      <div class="slot_check">
                                            <ul>
                                                @foreach(@$thursday as $key=> $slot)
                                                <li>
                                                    <input type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" checked disabled="">
                                                    <label>{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endforeach
                                                 </ul>
                                          </div>
                                       </div>
                                </div>
                            </div>
                            @endif

                            @if(@$friday->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                       <label for="day1">Friday</label>
                                      </div>
                                      <div class="slot_check">
                                            <ul>
                                                @foreach(@$friday as $key=> $slot)
                                                <li>
                                                    <input type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" checked disabled="">
                                                    <label>{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endforeach
                                                 </ul>
                                          </div>
                                       </div>
                                </div>
                            </div>
                            @endif


                            @if(@$saturday->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                       <label for="day1">Saturday</label>
                                      </div>
                                      <div class="slot_check">
                                            <ul>
                                                @foreach(@$saturday as $key=> $slot)
                                                <li>
                                                    <input type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" checked disabled="">
                                                    <label>{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endforeach
                                                 </ul>
                                          </div>
                                       </div>
                                </div>
                            </div>
                            @endif

                             @if(@$sunday->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                       <label for="day1">Sunday</label>
                                      </div>
                                      <div class="slot_check">
                                            <ul>
                                                @foreach(@$sunday as $key=> $slot)
                                                <li>
                                                    <input type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" checked disabled="">
                                                    <label>{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endforeach
                                                 </ul>
                                          </div>
                                       </div>
                                </div>
                            </div>
                            @endif





                            </div>


                                    </div>
                                    @endif
                                </div>


                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Call History</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div class="table-responsive">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Customer Name</th>
                                                                        <th> Date</th>
                                                                        <th>Duration</th>
                                                                        <th>Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(@$user->orderbookings->isNotEmpty())
                                                                @foreach(@$user->orderbookings as $orders)
                                                                    <tr>
                                                                        <td>{{@$orders->customer->first_name}} {{@$orders->customer->last_name}}</td>
                                                                        <td>{{date('Y-m-d', strtotime(@$orders->date))}}</td>
                                                                        <td>{{-- {{number_format((float)round( @$orders->duration / 60,4), 2, '.', '')}}  --}}{{@$orders->duration}} minutes</td>
                                                                        <td>₹{{@$orders->total_rate}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                @else
                                                                <tr><td>No Bookings</td></tr>
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                        </div>

                                    </div>
                                </div>
                                <!-- Personal-Information -->



                        </div>
                    </div>
                    </div>
                </div> <!-- container -->

                </div> <!-- content -->

                @include('admin.includes.footer')

            </div>
@endsection
@section('script')
@include('admin.includes.script')
@include('includes.toaster')
@endsection
