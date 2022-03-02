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
                        <li><a href="{{route('astrologer.profile')}}">
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
                        <li class="actv"><a href="{{route('astrologer.availability')}}">
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
                    <form action="{{route('astrologer.availability.save')}}" method="POST" id="availability_form">
                        @csrf
                        <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day1" type="checkbox" value="MONDAY" name="day1" @if(count(@$monday)>0) checked @endif>
                                        <label for="day1">Monday</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_monday_{{$slot}}" type="checkbox" class="checkMon" value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" @if(count(@$monday)>0) {{ $monday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_monday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_monday_{{$slot}}" type="checkbox" class="checkMon" value="{{date('H:i:s',strtotime(@$slot))}}" name="monday_slot[]" @if(count(@$monday)>0) {{ $monday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_monday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                             @if(count(@$slots)>24)
                                                <a class="see-all moreless-button mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>
                            </div>




                            <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day2" type="checkbox" value="TUESDAY" name="day2" @if(count(@$tuesday)>0) checked @endif>
                                        <label for="day2">Tuesday</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_tuesday_{{$slot}}" type="checkbox" class="checkTue" value="{{date('H:i:s',strtotime(@$slot))}}" name="tuesday_slot[]" @if(count(@$tuesday)>0) {{ $tuesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_tuesday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-tuesday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_tuesday_{{$slot}}" type="checkbox" class="checkTue" value="{{date('H:i:s',strtotime(@$slot))}}" name="tuesday_slot[]" @if(count(@$tuesday)>0) {{ $tuesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_tuesday_{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-tuesday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>



                             <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day3" type="checkbox" value="WEDNESDAY" name="day3" @if(count(@$wednesday)>0) checked @endif>
                                        <label for="day3">{{__('profile.wednesday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_wednesday{{$slot}}" type="checkbox" class="checkWed" value="{{date('H:i:s',strtotime(@$slot))}}" name="wednesday_slot[]" @if(count(@$wednesday)>0) {{ $wednesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_wednesday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-wednesday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_wednesday{{$slot}}" type="checkbox" class="checkWed" value="{{date('H:i:s',strtotime(@$slot))}}" name="wednesday_slot[]"  @if(count(@$wednesday)>0) {{ $wednesday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_wednesday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-wednesday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>



                             <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day4" type="checkbox" value="THURSDAY" name="day4" @if(count(@$thursday)>0) checked @endif>
                                        <label for="day4">{{__('profile.thursday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_thursday{{$slot}}" type="checkbox" class="checkThus" value="{{date('H:i:s',strtotime(@$slot))}}" name="thursday_slot[]"  @if(count(@$thursday)>0) {{ $thursday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_thursday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-thursday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_thursday{{$slot}}" type="checkbox" class="checkThus" value="{{date('H:i:s',strtotime(@$slot))}}" name="thursday_slot[]" @if(count(@$thursday)>0) {{ $thursday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_thursday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-thursday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>


                        <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day5" type="checkbox" value="FRIDAY" name="day5" @if(count(@$friday)>0) checked @endif>
                                        <label for="day5">{{__('profile.friday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_friday{{$slot}}" type="checkbox" class="checkFry" value="{{date('H:i:s',strtotime(@$slot))}}" name="friday_slot[]" @if(count(@$friday)>0) {{ $friday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_friday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-firday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_friday{{$slot}}" type="checkbox" class="checkFry" value="{{date('H:i:s',strtotime(@$slot))}}" name="friday_slot[]" @if(count(@$friday)>0) {{ $friday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_friday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-firday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>







                            <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day6" type="checkbox" value="SATURDAY" name="day6" @if(count(@$saturday)>0) checked @endif>
                                        <label for="day6">{{__('profile.saturday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_saturday{{$slot}}" type="checkbox"  value="{{date('H:i:s',strtotime(@$slot))}}" name="saturday_slot[]" class="checkSat" @if(count(@$saturday)>0) {{ $saturday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_saturday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-saturday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_saturday{{$slot}}" type="checkbox" class="checkSat" value="{{date('H:i:s',strtotime(@$slot))}}" name="saturday_slot[]" @if(count(@$saturday)>0) {{ $saturday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_saturday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-saturday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>




                                                        <div class="col-md-12 col-sm-12">
                                    <div class="avai_check_bx">
                                    <div class="availability_check">
                                        <input id="day7" type="checkbox" value="SUNDAY" name="day7" @if(count(@$sunday)>0) checked @endif>
                                        <label for="day7">{{__('profile.sunday_label')}}</label>
                                      </div>
                                    <div class="slot_check">
                                            <ul>
                                                @php $count = 1 @endphp
                                                @foreach(@$slots as $key=> $slot)
                                                @if($key<24)
                                                <li>
                                                    <input id="chk_sunday{{$slot}}" type="checkbox" class="checkSun" value="{{date('H:i:s',strtotime(@$slot))}}" name="sunday_slot[]" @if(count(@$sunday)>0) {{ $sunday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_sunday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                              <div class="moretext-sunday" style="display: none;">
                                                    @foreach(@$slots as $key=> $slot)
                                                @if($key>=24)
                                                <li>
                                                    <input id="chk_sunday{{$slot}}" type="checkbox" class="checkSun" value="{{date('H:i:s',strtotime(@$slot))}}" name="sunday_slot[]" @if(count(@$sunday)>0) {{ $sunday->contains('from_time', date('H:i:s',strtotime(@$slot)))?'checked':'' }} @endif>
                                                    <label for="chk_sunday{{$slot}}">{{date('H:i A',strtotime(@$slot))}}</label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </div>
                                            </ul>
                                            @if(count(@$slots)>24)
                                                <a class="see-all moreless-button-sunday mt-2">View More +</a>
                                             @endif
                                        </div>
                                </div>
                            </div>




                            </div>

{{--                             <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day2" type="checkbox" value="TUESDAY" name="day2" @if(@$tuesday) checked @endif>
                                        <label for="day2">{{__('profile.tuesday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.from_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="from_time_day2"
                                                        value="{{@$tuesday?date('H:i',strtotime(@$tuesday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.to_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="to_time_day2"
                                                        value="{{@$tuesday?date('H:i',strtotime(@$tuesday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day3" type="checkbox" value="WEDNESDAY" name="day3" @if(@$wednesday) checked @endif>
                                        <label for="day3">{{__('profile.wednesday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.from_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="from_time_day3"
                                                        value="{{@$wednesday?date('H:i',strtotime(@$wednesday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.to_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="to_time_day3"
                                                        value="{{@$wednesday?date('H:i',strtotime(@$wednesday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day4" type="checkbox" value="THURSDAY" name="day4" @if(@$thursday) checked @endif>
                                        <label for="day4">{{__('profile.thursday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.from_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="from_time_day4"
                                                        value="{{@$thursday?date('H:i',strtotime(@$thursday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.to_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="to_time_day4"
                                                        value="{{@$thursday?date('H:i',strtotime(@$thursday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day5" type="checkbox" value="FRIDAY" name="day5" @if(@$friday) checked @endif>
                                        <label for="day5">{{__('profile.friday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.from_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="from_time_day5"
                                                        value="{{@$friday?date('H:i',strtotime(@$friday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.to_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="to_time_day5"
                                                        value="{{@$friday?date('H:i',strtotime(@$friday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day6" type="checkbox" value="SATURDAY" name="day6" @if(@$saturday) checked @endif>
                                        <label for="day6">{{__('profile.saturday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.from_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="from_time_day6"
                                                        value="{{@$saturday?date('H:i',strtotime(@$saturday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.to_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="to_time_day6"
                                                        value="{{@$saturday?date('H:i',strtotime(@$saturday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="availability_check">
                                        <input id="day7" type="checkbox" value="SUNDAY" name="day7" @if(@$sunday) checked @endif>
                                        <label for="day7">{{__('profile.sunday_label')}}</label>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.from_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="from_time_day7"
                                                        value="{{@$sunday?date('H:i',strtotime(@$sunday->from_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6">
                                                <div class="form_box_area">
                                                    <label>{{__('profile.to_time_label')}}</label>
                                                    <input type="text" placeholder="{{__('profile.time_placeholder')}}"
                                                        class="position-relative" name="to_time_day7"
                                                        value="{{@$sunday?date('H:i',strtotime(@$sunday->to_time)):''}}"> <span
                                                        class="over_llp1"><img src="{{ URL::to('public/frontend/images/clock.png')}}"
                                                            alt=""></span>
                                                </div>
                                            </div> --}}
                                        </div>
                                        <div class="save_coniBx">
                                            <div class="save_coniBx_left">
                                                <ul>

                                                    <li><input type="submit" value="Save " class="subBtn"></li>

                                                </ul>
                                            </div>

                                        </div>
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
@endsection
@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')

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
<!-- Time picek jas -->
<link rel='stylesheet' href='{{ URL::to('public/frontend/css/jquery-clockpicker.min.css')}}'>
<script src='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js'></script>
{{-- <script>
    $("input[name=to_time_day1],input[name=to_time_day2],input[name=to_time_day3],input[name=to_time_day4],input[name=to_time_day5],input[name=to_time_day6],input[name=to_time_day7]").clockpicker({
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
    $("input[name=from_time_day1],input[name=from_time_day2],input[name=from_time_day3],input[name=from_time_day4],input[name=from_time_day5],input[name=from_time_day6],input[name=from_time_day7]").clockpicker({
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
</script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script type="text/javascript">
    // The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
    $('.moreless-button').click(function() {
        $('.moretext').slideToggle();
        if ($('.moreless-button').text() == "View More +") {
            $(this).text("View Less -")
        } else {
            $(this).text("View More +")
        }
    });

    $('.moreless-button-tuesday').click(function() {
        $('.moretext-tuesday').slideToggle();
        if ($('.moreless-button-tuesday').text() == "View More +") {
            $(this).text("View Less -")
        } else {
            $(this).text("View More +")
        }
    });

    $('.moreless-button-wednesday').click(function() {
        $('.moretext-wednesday').slideToggle();
        if ($('.moreless-button-wednesday').text() == "View More +") {
            $(this).text("View Less -")
        } else {
            $(this).text("View More +")
        }
    });

    $('.moreless-button-thursday').click(function() {
        $('.moretext-thursday').slideToggle();
        if ($('.moreless-button-thursday').text() == "View More +") {
            $(this).text("View Less -")
        } else {
            $(this).text("View More +")
        }
    });

    $('.moreless-button-firday').click(function() {
        $('.moretext-firday').slideToggle();
        if ($('.moreless-button-firday').text() == "View More +") {
            $(this).text("View Less -")
        } else {
            $(this).text("View More +")
        }
    });

    $('.moreless-button-saturday').click(function() {
        $('.moretext-saturday').slideToggle();
        if ($('.moreless-button-saturday').text() == "View More +") {
            $(this).text("View Less -")
        } else {
            $(this).text("View More +")
        }
    });

    $('.moreless-button-sunday').click(function() {
        $('.moretext-sunday').slideToggle();
        if ($('.moreless-button-sunday').text() == "View More +") {
            $(this).text("View Less -")
        } else {
            $(this).text("View More +")
        }
    });

   </script>

{{-- <script>
    $(document).ready(function(){
        $.validator.addMethod("timemin", function(value, element, min) {
            // var valuestart = $("select[name='timestart']").val();
            // var valuestop = $("select[name='timestop']").val();

            //create date format
            var timeStart = new Date("01/01/2007 " + min);
            var timeEnd = new Date("01/01/2007 " + value);

            var difference = timeEnd - timeStart;

            difference = difference / 60 / 60 / 1000;
            if(value>min){
                return true;
            }
            else if(value==''){
                return true;
            }
        }, "{{__('profile.to_time_gater')}}");
        $("#availability_form").validate({
            rules: {
                from_time_day1:{
                    required: function(){
                        if($('#day1').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day1:{
                    required: function(){
                        if($('#day1').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day1]").val();
                    }
                },
                from_time_day2:{
                    required: function(){
                        if($('#day2').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day2:{
                    required: function(){
                        if($('#day2').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day2]").val();
                    }
                },
                from_time_day3:{
                    required: function(){
                        if($('#day3').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day3:{
                    required: function(){
                        if($('#day3').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day3]").val();
                    }
                },
                from_time_day4:{
                    required: function(){
                        if($('#day4').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day4:{
                    required: function(){
                        if($('#day4').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day4]").val();
                    }
                },
                from_time_day5:{
                    required: function(){
                        if($('#day5').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day5:{
                    required: function(){
                        if($('#day5').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day5]").val();
                    }
                },
                from_time_day6:{
                    required: function(){
                        if($('#day6').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day6:{
                    required: function(){
                        if($('#day6').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day6]").val();
                    }
                },
                from_time_day7:{
                    required: function(){
                        if($('#day7').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                },
                to_time_day7:{
                    required: function(){
                        if($('#day7').prop("checked") == false){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    timemin:function(){
                        return $("input[name=from_time_day7]").val();
                    }
                },

            },
            messages: {
                from_time_day1:{
                    required: '{{__('profile.required_from_time')}}',
                },
                to_time_day1:{
                    required: '{{__('profile.required_to_time')}}',
                },
                from_time_day2:{
                    required: '{{__('profile.required_from_time')}}',
                },
                to_time_day2:{
                    required: '{{__('profile.required_to_time')}}',
                },
                from_time_day3:{
                    required: '{{__('profile.required_from_time')}}'
                },
                to_time_day3:{
                    required:'{{__('profile.required_to_time')}}',
                },
                from_time_day4:{
                    required: '{{__('profile.required_from_time')}}',
                },
                to_time_day4:{
                    required: '{{__('profile.required_to_time')}}',
                },
                from_time_day5:{
                    required: '{{__('profile.required_from_time')}}',
                },
                to_time_day5:{
                    required: '{{__('profile.required_to_time')}}',
                },
                from_time_day6:{
                    required: '{{__('profile.required_from_time')}}',
                },
                to_time_day6:{
                    required: '{{__('profile.required_to_time')}}',
                },
                from_time_day7:{
                    required: '{{__('profile.required_from_time')}}',
                },
                to_time_day7:{
                    required:'{{__('profile.required_to_time')}}',
                },
            },
        });
    })
</script> --}}
<script>
    $(document).ready(function(){
        $('body').on('click','.checkMon',function(){
            if($("#day1").prop("checked") == false){
                alert('Please check the checkbox for monday first');
                return false;
            }

        })
        $('body').on('click','.checkTue',function(){
            if($("#day2").prop("checked") == false){
                alert('Please check the checkbox for tuesday first');
                return false;
            }

        })
        $('body').on('click','.checkWed',function(){
            if($("#day3").prop("checked") == false){
                alert('Please check the checkbox for wednesday first');
                return false;
            }

        })
        $('body').on('click','.checkThus',function(){
            if($("#day4").prop("checked") == false){
                alert('Please check the checkbox for thursday first');
                return false;
            }

        })
        $('body').on('click','.checkFry',function(){
            if($("#day5").prop("checked") == false){
                alert('Please check the checkbox for friday first');
                return false;
            }

        })
        $('body').on('click','.checkSat',function(){
            if($("#day6").prop("checked") == false){
                alert('Please check the checkbox for saturday first');
                return false;
            }

        })
        $('body').on('click','.checkSun',function(){
            if($("#day7").prop("checked") == false){
                alert('Please check the checkbox for sunday first');
                return false;
            }

        })
    })
</script>
<script type="text/javascript">
          $("#availability_form").validate({


          submitHandler: function(form){

           // if($("#day1 input[type=checkbox]").prop(":checked")){
           //      alert('hey');
           //      return false;
           //  }

            if($("#day1").prop("checked") == true) {
                var allRadios = $('[name="monday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from monday');
                    return false;
                }
            }
            if($("#day2").prop("checked") == true){
                var allRadios = $('[name="tuesday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from tuesday');
                    return false;
                }
            }

            if($("#day3").prop("checked") == true){
                var allRadios = $('[name="wednesday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from wednesday');
                    return false;
                }
            }

            if($("#day4").prop("checked") == true){
                var allRadios = $('[name="thursday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from thursday');
                    return false;
                }
            }

            if($("#day5").prop("checked") == true){
                var allRadios = $('[name="friday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from friday');
                    return false;
                }
            }

             if($("#day6").prop("checked") == true){
                var allRadios = $('[name="saturday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from saturday');
                    return false;
                }
            }

            if($("#day7").prop("checked") == true){
                var allRadios = $('[name="sunday_slot[]"]:checked').length;
                if (allRadios==0) {
                    alert('Please select atleast one slot from sunday');
                    return false;
                }
            }


            form.submit();

          },

});


</script>
@endsection
