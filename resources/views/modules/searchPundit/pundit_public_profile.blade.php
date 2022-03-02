@extends('layouts.app')

@section('title')
<meta property="og:title" content="{{__('search.pundit_public_profile_title')}} | {{@$userData->first_name}} {{@$userData->last_name}}">
<meta property="og:description" content="{!! substr(@$userData->about,0,150) !!}">
@if(@$userData->profile_img)
<meta property="og:image" content="{{ asset('storage/app/public/profile_picture/'.@$userData->profile_img) }}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
{{-- <meta property="og:url" content="{{route('business.search.view', $business->slug)}}"> --}}
<meta property="og:url" content="{{route('astrologer.search.publicProfile', ['slug'=>@$userData->slug])}}">
<title>{{__('search.pundit_public_profile_title')}} | {{@$userData->first_name}} {{@$userData->last_name}}</title>
@endsection

@section('style')
@include('includes.style')
<style>
    .error {
        color: red;
        text-align: left !important;
    }
    .pac-container {
        z-index: 1060 !important;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection


@section('body')


<section class="pad-114">
		<div class="banner-inner">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="inner-headings">
							<h3>{{__('search.talk_to_pundits')}}</h3>
							<p>{{__('search.browse_filter_pundit')}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<div class="details_sec">
	<div class="container">
		<div class="details_iner">
			<div class="details_left">
				<div class="astro_details">
					<div class="ast_det_left">
						<div class="media">
							{{-- <em><img src="{{ URL::to('public/frontend/images/astro-det1.jpg')}}" alt=""></em> --}}
							<em><img src="{{ asset('storage/app/public/profile_picture/'.@$userData->profile_img) }}" alt=""></em>
							<div class="media-body">
								<h4>{{@$userData->first_name}} {{@$userData->last_name}}<b><i class="fa fa-star"></i>{{@$userData->avg_review}}</b></h4>
								<p>{{@$userData->experience}} + {{__('search.years_of_experience')}}</p>
								<p>{{__('search.puja_type')}} -
                                    @if(@$userData->puja_type=='BOTH')
                                    {{__('search.both')}}
                                    @elseif(@$userData->puja_type=='ONLINE')
                                    {{__('search.online')}}
                                    @elseif(@$userData->puja_type=='OFFLINE')
                                    {{__('profile.offline')}}
                                    @endif
                                </p>
								<p>
                                    @foreach (@$userData->astrologerLanguage as $key=> $language)
                                    @if(@$key+1==$userData->astrologerLanguage->count())
                                    {{@$language->languages->language_name}}
                                    @else
                                    {{@$language->languages->language_name}} ,
                                    @endif
                                    @endforeach

                                    </p>
								<p>{{@$userData->city? $userData->city.',':''}}  {{@$userData->states->name? @$userData->states->name.',':''}}  {{@$userData->countries->name?@$userData->countries->name:''}}</p>
							</div>
						</div>
					</div>
					<div class="shareBx" >
						<span><i class="fa fa-share-square-o" aria-hidden="true"></i>{{__('search.share')}}:</span>

						<ul style="min-width: 160px">
                            <div class="sharethis-inline-share-buttons"></div>
							{{-- <li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon1.png')}}" alt=""></a></li>
							<li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon2.png')}}" alt=""></a></li>
							<li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon3.png')}}" alt=""></a></li>
							<li><a href="#" target="_blank"><img src="{{ URL::to('public/frontend/images/sosicon4.png')}}" alt=""></a></li> --}}
						</ul>

					</div>
				</div>
				<div class="about_astro">
					<h2>{{__('search.about_pundit')}} :</h2>
					<div class="article">
                        @if(strlen(@$userData->about) > 150)
                       <p class="aboutRemaove">{!! substr(@$userData->about, 0, 150 ) . '...' !!}</p>
                        <p class="moretext">
                          {!! @$userData->about !!}
                        </p>

                      <a class="moreless-button">{{__('search.read_more')}} +</a>
                      @else
                      <p>{!! @$userData->about !!}</p>
                      @endif
                      </div>
					<div class="edu_quli">
						<div class="edu_quliitem">
							<strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>{{__('search.puja_list')}}</strong>
                            @if(!@$userData->userAvailable->isEmpty())
                            @foreach ( @$userData->punditPujas as  $puja)
                            <span>{{@$puja->pujas->puja_name}} - {{__('search.puja_charges')}} : Rs. {{@$puja->price}} </span>
                            @endforeach
                            @else
                            <span>{{__('search.puja_not_available')}}</span>
                            @endif
						</div>
					</div>
                    @if(@$userData->offline_puja_location)
					<div class="edu_quli">
						<div class="edu_quliitem">
							<strong><em><img src="{{ URL::to('public/frontend/images/edu_quli1.png')}}" alt=""></em>Ofline puja service area ({{@$userData->offline_puja_radius}} Km radius) </strong>
                            <span> {{@$userData->offline_puja_location}}  </span>
						</div>
					</div>
                    @endif
				</div>
				<div class="customer_review_box">
					<h5>{{__('search.customer_review')}} :</h5>
					<div class="review_box">
						<div class="review_left">
							<b>{{@$userData->avg_review}}</b>
							<ul>
								<li><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></li>
								<li><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></li>
								<li><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></li>
								<li><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></li>
								<li><img src="{{ URL::to('public/frontend/images/star2.png')}}" alt=""></li>
							</ul>
							<strong>(Review {{@$userData->tot_review}})</strong>
						</div>
						<div class="review_right">
							<ul>
								<li>
									<em>5</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>(45 Customers)</b>
								</li>
								<li><em>4</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: 78%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>(20 Customers)</b>
								</li>
								<li><em>3</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>(15 Customers)</b>
								</li>
								<li><em>2</em><i><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></i>
									<span>
										<div class="progress">
											<div class="progress-bar" role="progressbar" style="width: 35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</span>
									<b>(5 Customers)</b>
								</li>
							</ul>
						</div>
					</div>
					<div class="review_person">
						<div class="review_per_item">
							<div class="media">
								<em><img src="{{ URL::to('public/frontend/images/reviewimg1.jpg')}}" alt=""></em>
								<div class="media-body">
									<h2>Akashbev Roys</h2>
									<ul>
										<li>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
										</li>
										<li>
											<i class="fa fa-calendar"></i>
											<strong>20th Sept, 2020</strong>
										</li>
									</ul>
								</div>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing eiusmod tempor incididunt ut laibore dolore magna aliqua.labor dolore magna aliqua.lorem ipsum the dolor sit amet, consectetur adipiscing eiusmod tempordolore.</p>
							<p class="moretext2">
                          Blue sapphire is a very cold and extremely powerful gem stone and represents planet Saturn. It blesses with immense good luck, wealth and prosperity.
                        </p> <a class="moreless-button2 allread">{{__('search.read_more')}} +</a>
						</div>
						<div class="review_per_item">
							<div class="media">
								<em><img src="{{ URL::to('public/frontend/images/reviewimg2.jpg')}}" alt=""></em>
								<div class="media-body">
									<h2>Munmun Roy</h2>
									<ul>
										<li>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
										</li>
										<li>
											<i class="fa fa-calendar"></i>
											<strong>20th Sept, 2020</strong>
										</li>
									</ul>
								</div>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing eiusmod tempor incididunt ut laibore dolore magna aliqua.labor dolore magna aliqua.lorem ipsum the dolor sit amet, consectetur adipiscing eiusmod tempordolore.</p>
							<p class="moretext3">
                          Powerful gem stone and represents planet Saturn. It blesses with immense good luck, wealth and prosperity.
                        </p> <a class="moreless-button3 allread">{{__('search.read_more')}} +</a>
						</div>

						<div class="moretext5">
							<div class="review_per_item">
							<div class="media">
								<em><img src="{{ URL::to('public/frontend/images/reviewimg2.jpg')}}" alt=""></em>
								<div class="media-body">
									<h2>Munmun Roy</h2>
									<ul>
										<li>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
											<span><img src="{{ URL::to('public/frontend/images/star1.png')}}" alt=""></span>
										</li>
										<li>
											<i class="fa fa-calendar"></i>
											<strong>20th Sept, 2020</strong>
										</li>
									</ul>
								</div>
							</div>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing eiusmod tempor incididunt ut laibore dolore magna aliqua.labor dolore magna aliqua.lorem ipsum the dolor sit amet, consectetur adipiscing eiusmod tempordolore.</p>
							<p class="moretext4">
                          Powerful gem stone and represents planet Saturn. It blesses with immense good luck, wealth and prosperity.
                        </p> <a class="moreless-button4 allread">{{__('search.read_more')}} +</a>
						</div>
						</div>
					</div>
					<a class="moreless-button5  show_more">Show More Reviews +</a>
				</div>
			</div>
			<div class="ast_det_right">
				<div class="ast_det_right_inr">
					<h6><img src="{{ URL::to('public/frontend/images/check.png')}}" alt="">{{__('search.availability')}}</h6>
                    @if(!@$userData->userAvailable->isEmpty())
                    @foreach ($userData->userAvailable as $key=>$available)
                    @if($key<3)
                    <div class="ast_time">
                        @if($available->day =='SUNDAY')
                        <strong>{{__('search.sunday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                        @elseif($available->day =='MONDAY')
                        <strong>{{__('search.monday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                        @elseif($available->day =='TUESDAY')
                        <strong>{{__('search.tuesday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                        @elseif($available->day =='WEDNESDAY')
                        <strong>{{__('search.wednesday')}}- <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                        @elseif($available->day =='THURSDAY')
                        <strong>{{__('search.thursday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                        @elseif($available->day =='FRIDAY')
                        <strong>{{__('search.friday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                        @elseif($available->day =='SATURDAY')
                        <strong>{{__('search.saturday')}}- <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                        @endif
                        <ul>
                            <li><a href="javascript:;" data-day="{{$available->day}}" class="day_select">{{date('h:i ',strtotime($available->from_time))}} - {{date('h:i ',strtotime($available->to_time))}}</a></li>
                        </ul>
                    </div>
                    @endif
                    @endforeach
                    @if($userData->userAvailable->count()>3)
                    <div class="moretext1">
                        @foreach ($userData->userAvailable as $key=>$available)
                        @if($key>2)
                        <div class="ast_time">
                            @if($available->day =='SUNDAY')
                            <strong>{{__('search.sunday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                            @elseif($available->day =='MONDAY')
                            <strong>{{__('search.monday')}}- <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                            @elseif($available->day =='TUESDAY')
                            <strong>{{__('search.tuesday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                            @elseif($available->day =='WEDNESDAY')
                            <strong>{{__('search.wednesday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                            @elseif($available->day =='THURSDAY')
                            <strong>{{__('search.thursday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                            @elseif($available->day =='FRIDAY')
                            <strong>{{__('search.friday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                            @elseif($available->day =='SATURDAY')
                            <strong>{{__('search.saturday')}} - <span>{{__('search.at')}} {{$userData->city}}</span></strong>
                            @endif
                            <ul>
                                <li><a href="javascript:;" data-day="{{$available->day}}" class="day_select">{{date('h:i ',strtotime($available->from_time))}} - {{date('h:i ',strtotime($available->to_time))}}</a></li>
                            </ul>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
					{{-- <div class="ast_time">
						<strong>Monday - <span>At Kolkata</span></strong>
						<ul>
							<li><a href="#url">7 AM - 12 PM</a></li>
                            <li><a href="#url">7 AM - 12 PM</a></li>
						</ul>
					</div>
					<div class="ast_time">
						<strong>Tuesday - <span>At Howrah</span></strong>
						<ul>
							<li><a href="#url">8 AM - 11AM</a></li>
							<li><a href="#url">7 AM - 12 PM</a></li>
							<li><a href="#url">7 AM - 12 PM</a></li>
						</ul>
					</div>
					<div class="ast_time">
						<strong>Wednesday  - <span>At Kolkata</span></strong>
						<ul>
							<li><a href="#url">8 AM - 11 PM</a></li>
						</ul>
					</div> --}}

					{{-- <div class="moretext1">
					<div class="ast_time">
						<strong>Thursday  - <span>At Kolkata</span></strong>
						<ul>
							<li><a href="#url">8 AM - 11 PM</a></li>
						</ul>
					</div>
					<div class="ast_time">
						<strong>Friday  - <span>At Kolkata</span></strong>
						<ul>
							<li><a href="#url">8 AM - 11 PM</a></li>
						</ul>
					</div>
					<div class="ast_time">
						<strong>Saturday  - <span>At Kolkata</span></strong>
						<ul>
							<li><a href="#url">8 AM - 11 PM</a></li>
						</ul>
					</div>
					</div> --}}


					@if($userData->userAvailable->count()>3)<a  class="moreless-button1 view_all">{{__('search.view_all')}} +</a>@endif
					<div class="talk_now_fll">
						<a href="javascript:;" class="pag_btn" id="talk_now"><i class="fa fa-envelope-o"></i>{{__('search.book_now')}}</a>
					</div>
                    @else
                    <span>{{__('search.pundit_not_available')}}</span>
                    @endif
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="durarion">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Puja Booking</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form  method="POST" enctype="multipart/form-data" id="puja_from" action="{{route('pundit.puja.booking',['slug'=>@$userData->slug])}}">
                        @csrf
                        <div class="main-center-div">@include('includes.message')
                        <div class="login-from-area">
                            <input type="hidden" name="pundit_id" value="{{@$userData->id}}">
                            <input type="hidden" id="u_id" @if(@auth()->user()->id) value="1" @endif)>
                            {{-- <h2>{{__('auth.otp_header')}}</h2> --}}
                            <div class="marb20">
                                <select class="login-type log-select" name="puja_day">
                                    <option value="">Select Day</option>
                                    @foreach ($userData->userAvailable as $key=>$available)
                                    <option value="{{$available->day}}" >
                                        @if($available->day =='SUNDAY')
                                        {{__('search.sunday')}}
                                        @elseif($available->day =='MONDAY')
                                        {{__('search.monday')}}
                                        @elseif($available->day =='TUESDAY')
                                        {{__('search.tuesday')}}
                                        @elseif($available->day =='WEDNESDAY')
                                        {{__('search.wednesday')}}
                                        @elseif($available->day =='THURSDAY')
                                        {{__('search.thursday')}}
                                        @elseif($available->day =='FRIDAY')
                                        {{__('search.friday')}}
                                        @elseif($available->day =='SATURDAY')
                                        {{__('search.saturday')}}
                                        @endif
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="marb20">
                                <select class="login-type log-select" name="puja_type" id="puja_type">
                                    <option value="">Select Puja Type</option>
                                    @if(@$userData->puja_type=='BOTH')
                                    <option value="ONLINE">{{__('search.online')}}</option>
                                    @if(@$userData->offline_puja_location)<option value="OFFLINE">{{__('profile.offline')}}</option>@endif
                                    {{-- {{__('search.both')}} --}}
                                    @elseif(@$userData->puja_type=='ONLINE')
                                    <option value="ONLINE">{{__('search.online')}}</option>
                                    @elseif(@$userData->puja_type=='OFFLINE')
                                    @if(@$userData->offline_puja_location)<option value="OFFLINE">{{__('profile.offline')}}</option>@endif
                                    @endif
                                </select>
                            </div>
                            <div class="marb20">
                                <select class="login-type log-select" name="puja_name" id="puja_name">
                                    <option value="">Select Puja</option>
                                    @foreach ( @$userData->punditPujas as $puja)
                                    <option value="{{@$puja->puja_id}}" data-price="{{@$puja->price}}">{{@$puja->pujas->puja_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="marb20 offline_puja" id='location'>
                                <h3></h3>
                            </div> --}}
                            <div class="marb20 offline_puja" id='location' style="display: none">
                                <h3></h3>
                                <input class="login-type" type="text" placeholder="Enter Puja Location" id="offline_puja_location" name="offline_puja_location">
                                <label id="offline_puja_location-error" class="error" for="offline_puja_location" style="display: none"></label>
                                <input type="hidden" name="lat" id="lat" >
                                <input type="hidden" name="lng" id="lng" >
                            </div>

                            <div class="marb20 offline_puja" id="checkAddress" style="display: none">
                                <a href="javascript:;" class="login-submit checkAddress" style="display: inline-block; line-height: 45px;">Check offline Service</a>
                            </div>
                            <div class="birth-details" id="amount">
                                <h3>Total Amount: - 0</h3>
                                <div>
                                    {{-- <input type="text" class="login-type" placeholder="0" name="amount" id="amount" readonly> --}}
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <button type="submit" class="login-submit">Booking</button>
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

@endsection

@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

{{-- // The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on. --}}
{{-- <script>
$('.moreless-button').click(function() {
$('.moretext').slideToggle();
if ($('.moreless-button').text() == "Read More +") {
$(this).text("Read Less -")
} else {
$(this).text("Read More +")
}
});
</script> --}}
<script>
    $('.moreless-button').click(function() {

        if ($('.moreless-button').text() == "{{__('search.read_more')}} +") {
            $('.aboutRemaove').hide();
            $('.moretext').show();
            $(this).text("{{__('search.read_less')}} -")
        } else {
            $('.aboutRemaove').show();
            $('.moretext').hide();
            $(this).text("{{__('search.read_more')}} +")
        }
        // $('.moretext').slideToggle();

    });
</script>
<script type="text/javascript">
    $('.moreless-button1').click(function() {
  $('.moretext1').slideToggle();
  if ($('.moreless-button1').text() == "{{__('search.view_all')}} +") {
    $(this).text("{{__('search.view_less')}} -")
  } else {
    $(this).text("{{__('search.view_all')}} +")
  }
});
</script>
<script type="text/javascript">
    $('.moreless-button2').click(function() {
  $('.moretext2').slideToggle();
  if ($('.moreless-button2').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}} +")
  }
});
</script>

<script type="text/javascript">
    $('.moreless-button3').click(function() {
  $('.moretext3').slideToggle();
  if ($('.moreless-button3').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}}e +")
  }
});
</script>


<script type="text/javascript">
    $('.moreless-button4').click(function() {
  $('.moretext4').slideToggle();
  if ($('.moreless-button4').text() == "{{__('search.read_more')}} +") {
    $(this).text("{{__('search.read_less')}} -")
  } else {
    $(this).text("{{__('search.read_more')}} +")
  }
});
</script>


<script type="text/javascript">
    $('.moreless-button5').click(function() {
  $('.moretext5').slideToggle();
  if ($('.moreless-button5').text() == "Show More Reviews +") {
    $(this).text("Show Less Reviews -")
  } else {
    $(this).text("Show More Reviews +")
  }
});
</script>
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
<script>
    $(document).on('click', function () {
        var $target = $(event.target);
        if (!$target.closest('.shopcutBx').length && !$target.closest('.shopcut').length && $('.shopcutBx').is(":visible")) {
            $('.shopcutBx').slideUp();
        }
    });
    $(document).ready(function(){
        $('#full_content').hide();
    });
function showhidepara(){
        if($('#full_content').css('display') == 'none'){
            $('#desc_more').html("{{__('search.read_less')}} -");
            $('#full_content').show();
            $('#short_content').hide();
        } else {
            $('#desc_more').html("{{__('search.read_more')}} +");
            $('#full_content').hide();
            $('#short_content').show();
        }
    }
</script>
<script>
    $(document).ready(function(){

        $('#talk_now').click(function(){
            if(!$('#u_id').val()){
                Swal.fire('Please login to Puja booking');
                return 0;
            }
            $(".log-select option:contains(Select Day)").attr('selected', 'selected');
            $("#durarion").modal("show");
        });
        $('.day_select').click(function(){
            if(!$('#u_id').val()){
            Swal.fire('Please login to Puja booking');
            return 0;
            }
            console.log($(this).data('day'));
            var day = $(this).data('day');
            if(day =='SUNDAY'){
               var select_option ='{{__('search.sunday')}}';
            }
            else if(day =='MONDAY'){
                var select_option ='{{__('search.monday')}}';
            }
            else if(day =='TUESDAY'){
                var select_option ='{{__('search.tuesday')}}';
            }
            else if(day =='WEDNESDAY'){
                var select_option ='{{__('search.wednesday')}}';
            }
            else if(day =='THURSDAY'){
                var select_option ='{{__('search.thursday')}}';
            }
            else if(day =='FRIDAY'){
                var select_option ='{{__('search.friday')}}';
            }
            else if(day =='SATURDAY'){
                var select_option ='{{__('search.saturday')}}';
            }
            else{
                var select_option ='Select Day';
            }
            $(".log-select option:contains(" +select_option+")").attr('selected', 'selected');
            // $("#time_duration").val(0);
            $("#durarion").modal("show");
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
        $("#puja_from").validate({
            rules: {
                puja_day:{
                    required: true,
                },
                puja_type:{
                    required: true,
                },
                puja_name:{
                    required: true,
                },
                offline_puja_location:{
                    required:function(){
                        var puja_type = $('#puja_type').val();
                        if(puja_type=='OFFLINE'){
                            return true
                        }else{
                            return false
                        }
                    },
                },

            },
            messages: {
                puja_day:{
                    required: 'Select puja booking day',
                },
                puja_type:{
                    required: 'Select puja type',
                },
                puja_name:{
                    required: 'Select puja ',
                },
                offline_puja_location:{
                    required:'Enter Puja Location'
                },
            },
        });
        $('#puja_name').change(function(){
            var rate=event.target.options[event.target.selectedIndex].dataset.price;
            console.log(rate);
            if(rate!=null){
                $('#amount h3').html('Total Amount: - '+ rate);
            }else{
                $('#amount h3').html('Total Amount: - '+ 0);
            }
        });
    })
</script>
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
<script>
    $(document).ready(function(){
        $('.checkAddress1 ').click(function(){
            var location = $('#offline_puja_location').val();
            var lat= $('#lat').val();
            var lng= $('#lng').val();
            if(location !=''){
                var reqData = {
                    'jsonrpc': '2.0',
                    '_token': '{{csrf_token()}}',
                    'params': {
                        lat:lat,
                        lng:lng,
                        panditId:'{{@$userData->id}}'
                    }
                };
                $.ajax({
                    url: '{{ route('pundit.puja.online.location.check') }}',
                    type: 'post',
                    dataType: 'json',
                    data: reqData,
                })
                .done(function(response) {
                    if(response.result.error){
                        $('#location h3').html(location);
                        $('#location').css('display','block');
                        $('#offline_puja_location').val('');
                        $('#offline_puja_location-error').html(response.result.error);
                        $('#offline_puja_location-error').css('display','block');
                    }else if(response.result.success){
                        // $('.checkAddress').html('Enter Puja Location');
                        $('.checkAddress').css('display','none');
                    }
                    console.log(response)
                })
                .fail(function(error) {

                })
                .always(function() {

                });
            }else{
                $('#offline_puja_location-error').html('Enter Puja Location');
                $('#offline_puja_location-error').css('display','block');
            }


        });
        $('#puja_type1').change(function(){
            var puja_type = $('#puja_type').val();
            if(puja_type=='OFFLINE' || puja_type=='BOTH' ){
                $('.offline_puja').css('display','block');
            }
            else{
                $('.offline_puja').css('display','none');
                $('#location h3').html('');
                $('#offline_puja_location').val('');
                $('#offline_puja_location-error').html('');
            }
        })
    });
</script>
@endsection

