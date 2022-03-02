@extends('layouts.app')

@section('title')
<title>Astrologer Search</title>
@endsection

@section('style')
@include('includes.style')
<style>
    /* .clickon{pointer-events:none} */
</style>
@endsection

@section('header')
@include('includes.header')
@endsection


@section('body')
<?php
 $custom = (new \App\Helpers\CustomHelper)->currencyConversion();
?>
<form method="post" action="{{route('astrologer.search')}}" method="POST" id="filter">
<section class="search-list pad-114">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 bor-r">
					<div class="mobile-list">
						<p><i class="fa fa-filter"></i>Show Filter</p>
					</div>
					<div class="search-filter">
					
					<div class="panel-group fliter-list" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingnew">
                                <h3 class="panel-title"><a {{-- @if(@$request['keyword']==null) --}}class="collapsed" {{-- @endif --}} data-toggle="collapse"  href="#collapsenew" aria-expanded="false" aria-controls="collapsenew">Search Astrologer</a></h3> </div>
                            <div id="collapsenew" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingnew">
                                <div class="diiferent-sec search-key">
                                    <input type="text" placeholder="Type Keyword" value="{{@$key['keyword']}}" name="keyword">
                                    <button><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
						<div style="width:100%;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;"><h3 class="hed-fil">Filters <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3>
             <span style="float:right;"><a href="{{route('astrologer.search')}}">Reset All</a></span></div>
						
						@if(@$countries->isNotEmpty())
						<div class="panel panel-default">
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="diiferent-sec @if(@$key['country_id']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="country_id" id="country_id" onChange="this.form.submit()">
                                        <option value="">Select Country</option>
                                        @foreach(@$countries as $country)
										<option value="{{@$country->id}}" @if(@$key['country_id']==@$country->id)selected @endif>{{@$country->name}}</option>
										@endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						@endif
						@if(@$states)
						@if(@$states->isNotEmpty())
						<div class="panel panel-default">
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="diiferent-sec @if(@$key['state_id']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="state_id" id="state_id" onChange="this.form.submit()">
                                        <option value="">Select State</option>
                                        @foreach(@$states as $state)
										<option value="{{@$state->id}}" @if(@$key['state_id']==@$state->id)selected @endif>{{@$state->name}}</option>
									  @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						@endif
						@endif
						@if(@$cities)
						@if(@$cities->isNotEmpty())
						<div class="panel panel-default">
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="diiferent-sec @if(@$key['city_id']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="city_id" id="city_id" onChange="this.form.submit()">
                                        <option value="">Select State</option>
                                        @foreach(@$cities as $city)
										<option value="{{@$city->id}}" @if(@$key['city_id']==@$city->id)selected @endif>{{@$city->name}}</option>
									  @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
						@endif
						@endif
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingOne">
									<h3 class="panel-title"><a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Expertise</a></h3> </div>
								<div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
									<div class="diiferent-sec">

									
									 @csrf
										<ul class="category-ul">
											@foreach(@$expertise as $key1=>$exp)
                                            @if($key1<2)
											<li>
												<label class="list_checkBox">{{@$exp->expertise_name}}
													<input  type="checkbox" name="expertise[]" value="{{@$exp->id}}" onChange="this.form.submit()" {{ @in_array($exp->id, @$key['expertise'])?'checked':''}}> <span class="list_checkmark" ></span> </label>
											</li>
                                            @else
											<li>
												<label class="list_checkBox view_more_checkBox" style="display: none">{{@$exp->expertise_name}}
													<input  type="checkbox" name="expertise[]" value="{{@$exp->id}}" onChange="this.form.submit()" {{ @in_array($exp->id, @$key['expertise'])?'checked':''}}> <span class="list_checkmark" ></span> </label>
											</li>
                                            @endif
											@endforeach
										</ul>
										@if(count(@$expertise)>2)
                                        <a class="see-all" href="javascript:;" id="view_mode">{{__('search.view_more')}} +</a>
                                        <a class="see-all" href="javascript:;" id="view_less" style="display: none">{{__('search.view_less')}} -</a>
                                        @endif
                                    </div>
								</div>
							</div>
							
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingThree">
									<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Language Speaks </a></h3> </div>
								<div id="collapseThree" class="panel-collapse @if(@$key['language']) @else collapse @endif" role="tabpanel" aria-labelledby="headingThree">
									<div class="diiferent-sec">
										<ul class="category-ul">
											@foreach(@$languages as $key2=>$language)
                                            @if($key2<2)
											<li>
												<label class="list_checkBox">{{@$language->language_name}}
													<input @if(@$key['language'] && in_array($language->id, @$key['language'])) checked @endif type="checkbox" name="language[]" value="{{@$language->id}}" onChange="this.form.submit()"><span class="list_checkmark"></span>
												</label>
											</li>
                                            @else
											<li>
												<label class="list_checkBox view_more_checkBox_lan" style="display: none">{{@$language->language_name}}
													<input @if(@$key['language'] && in_array($language->id, @$key['language'])) checked @endif type="checkbox" name="language[]" value="{{@$language->id}}" onChange="this.form.submit()"><span class="list_checkmark"></span>
												</label>
											</li>
                                            @endif
											@endforeach											
										</ul>
										@if(count(@$languages)>2)
                                        <a class="see-all" href="javascript:;" id="view_mode_lan">{{__('search.view_more')}} +</a>
                                        <a class="see-all" href="javascript:;" id="view_less_lan" style="display: none">{{__('search.view_less')}} -</a>
                                        @endif
                                    </div>
								</div>
							</div>


							@if(@$is_chat || @$is_video_call || @$is_audio || @$is_offline)
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="heading_type">
									<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapse_type" aria-expanded="false" aria-controls="collapse_type">Type</a></h3> </div>
								<div id="collapse_type" class="panel-collapse @if(@$key['offer_type']) @else collapse @endif" role="tabpanel" aria-labelledby="heading_type">
									<div class="diiferent-sec">
										<ul class="category-ul">
											@if(@$is_audio)
											<li>
												<label class="list_checkBox">Audio Call
													<input type="checkbox"  name="offer_type[]" value="1" onChange="this.form.submit()" @if(@$key['offer_type'] && in_array(1, @$key['offer_type'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											@endif

											@if(@$is_video_call)
											<li>
												<label class="list_checkBox">Video Call
													<input type="checkbox" name="offer_type[]" value="2" onChange="this.form.submit()" @if(@$key['offer_type'] && in_array(2, @$key['offer_type'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											@endif
											@if(@$is_chat)
											<li>
												<label class="list_checkBox">Chat
													<input type="checkbox" name="offer_type[]" value="3" onChange="this.form.submit()" @if(@$key['offer_type'] && in_array(3, @$key['offer_type'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											@endif
											@if(@$is_offline)
											<li>
												<label class="list_checkBox">Offline
													<input type="checkbox" name="offer_type[]" value="4" onChange="this.form.submit()" @if(@$key['offer_type'] && in_array(4, @$key['offer_type'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											@endif
										</ul>
									</div>
								</div>
							</div>

							@endif


							@if(@$avail_now_audio || @$avail_now_video || @$avail_now_chat)
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="heading_available">
									<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapse_available" aria-expanded="false" aria-controls="collapse_available">Available now for</a></h3> </div>
								<div id="collapse_available" class="panel-collapse @if(@$key['avail_now']) @else collapse @endif" role="tabpanel" aria-labelledby="heading_available">
									<div class="diiferent-sec">
										<ul class="category-ul">
											@if(@$avail_now_audio)
											<li>
												<label class="list_checkBox">Audio Call
													<input type="checkbox"  name="avail_now[]" value="1" onChange="this.form.submit()" @if(@$key['avail_now'] && in_array(1, @$key['avail_now'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											@endif

											@if(@$avail_now_video)
											<li>
												<label class="list_checkBox">Video Call
													<input type="checkbox" name="avail_now[]" value="2" onChange="this.form.submit()" @if(@$key['avail_now'] && in_array(2, @$key['avail_now'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											@endif

											@if(@$avail_now_chat)
											<li>
												<label class="list_checkBox">Chat
													<input type="checkbox" name="avail_now[]" value="3" onChange="this.form.submit()" @if(@$key['avail_now'] && in_array(3, @$key['avail_now'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											@endif
										</ul>
									</div>
								</div>
							</div>
							@endif
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingFour">
									<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Rating</a></h3> </div>
								<div id="collapseFour" class="panel-collapse @if(@$key['rating']) @else collapse @endif" role="tabpanel" aria-labelledby="headingFour">
									<div class="diiferent-sec">
										<ul class="category-ul">
											<li>
												<label class="list_checkBox">All Ratings
													<input type="checkbox"  name="rating[]" value="1" onChange="this.form.submit()" @if(@$key['rating'] && in_array(1, @$key['rating'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											<li>
												<label class="list_checkBox">3 Star & above
													<input type="checkbox" name="rating[]" value="2" onChange="this.form.submit()" @if(@$key['rating'] && in_array(2, @$key['rating'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											<li>
												<label class="list_checkBox">4 Star & above
													<input type="checkbox" name="rating[]" value="3" onChange="this.form.submit()" @if(@$key['rating'] && in_array(3, @$key['rating'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab" id="headingFive">
									<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Experience</a></h3> </div>
								<div id="collapseFive" class="panel-collapse @if(@$key['experience']) @else collapse @endif" role="tabpanel" aria-labelledby="headingFive">
									<div class="diiferent-sec">
										<ul class="category-ul">

											<li>
												<label class="list_checkBox">Upto 10 years
													<input type="checkbox" name="experience[]" value="1" onChange="this.form.submit()" @if(@$key['experience'] && in_array(1, @$key['experience'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>
											<li>
												<label class="list_checkBox">Upto 20 years
													<input type="checkbox"  name="experience[]"  value="2" onChange="this.form.submit()" @if(@$key['experience'] && in_array(2, @$key['experience'])) checked @endif> <span class="list_checkmark"></span> </label>
											</li>


											<li>
												<label class="list_checkBox">20 years & Above
													<input type="checkbox"  name="experience[]"  value="3" onChange="this.form.submit()" @if(@$key['experience'] && in_array(3, @$key['experience'])) checked @endif> <span class="list_checkmark"></span>
												</label>
											</li>
										</ul>
									</div>
								</div>
							</div>
							


							@if(@$is_audio || @$key['call'])
							<div class="panel-heading" role="tab" id="headingsix">

								<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapsesix" aria-expanded="false" aria-controls="collapsesix">Price For Audio Call</a></h3> </div>
							<div id="collapsesix" class="panel-collapse @if(@$key['call']) @else collapse @endif" role="tabpanel" aria-labelledby="headingsix">
								<div class="diiferent-sec">
									<ul class="category-ul">

										<li>
											<label class="list_checkBox">Price doesn't matter
												<input type="checkbox" name="call[]" value="1" onChange="this.form.submit()" @if(@$key['call'] && in_array(1, @$key['call'])) checked @endif>> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Above {{@session()->get('currencySym')}} 100/min
												<input type="checkbox" name="call[]" value="101" onChange="this.form.submit()" @if(@$key['call'] && in_array(101, @$key['call']) && !in_array(1, @$key['call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>



										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 20/Min
												<input type="checkbox" name="call[]" value="20" onChange="this.form.submit()" @if(@$key['call'] && in_array(20, @$key['call']) && !in_array(1, @$key['call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 50/Min
												<input type="checkbox" name="call[]" value="50" onChange="this.form.submit()" @if(@$key['call'] && in_array(50, @$key['call']) && !in_array(1, @$key['call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 80/Min
												<input type="checkbox" name="call[]" value="80" onChange="this.form.submit()" @if(@$key['call'] && in_array(80, @$key['call']) && !in_array(1, @$key['call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>
										<div class="moretext">
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 90/Min
														<input type="checkbox" name="call[]" value="90" onChange="this.form.submit()" @if(@$key['call'] && in_array(90, @$key['call']) && !in_array(1, @$key['call'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 100/Min
														<input type="checkbox" name="call[]" value="100" onChange="this.form.submit()" @if(@$key['call'] && in_array(100, @$key['call']) && !in_array(1, @$key['call'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
										</div>
										</ul> <a class="see-all moreless-button">View More +</a> </div>
							</div>

							@endif

							



							@if(@$is_video_call || @$key['video_call'])
							<div class="panel-heading" role="tab" id="heading_video_price">
								
								<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapse_video_price" aria-expanded="false" aria-controls="collapse_video_price">Price For Video Call</a></h3> </div>
							<div id="collapse_video_price" class="panel-collapse @if(@$key['video_call']) @else collapse @endif" role="tabpanel" aria-labelledby="heading_video_price">
								<div class="diiferent-sec">
									<ul class="category-ul">

										<li>
											<label class="list_checkBox">Price doesn't matter
												<input type="checkbox" name="video_call[]" value="1" onChange="this.form.submit()" @if(@$key['video_call'] && in_array(1, @$key['video_call'])) checked @endif>> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Above {{@session()->get('currencySym')}} 100/min
												<input type="checkbox" name="video_call[]" value="101" onChange="this.form.submit()" @if(@$key['video_call'] && in_array(101, @$key['video_call']) && !in_array(1, @$key['video_call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>



										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 20/Min
												<input type="checkbox" name="video_call[]" value="20" onChange="this.form.submit()" @if(@$key['video_call'] && in_array(20, @$key['video_call']) && !in_array(1, @$key['video_call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 50/Min
												<input type="checkbox" name="video_call[]" value="50" onChange="this.form.submit()" @if(@$key['video_call'] && in_array(50, @$key['video_call']) && !in_array(1, @$key['video_call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 80/Min
												<input type="checkbox" name="video_call[]" value="80" onChange="this.form.submit()" @if(@$key['video_call'] && in_array(80, @$key['video_call']) && !in_array(1, @$key['video_call'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>
										<div class="moretext">
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 90/Min
														<input type="checkbox" name="video_call[]" value="90" onChange="this.form.submit()" @if(@$key['video_call'] && in_array(90, @$key['video_call']) && !in_array(1, @$key['video_call'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 100/Min
														<input type="checkbox" name="video_call[]" value="100" onChange="this.form.submit()" @if(@$key['video_call'] && in_array(100, @$key['video_call']) && !in_array(1, @$key['video_call'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
										</div>
										</ul> <a class="see-all moreless-button">View More +</a> </div>
							</div>
							@endif

							



							@if(@$is_chat || @$key['chat_price'])
							<div class="panel-heading" role="tab" id="heading_chat_price">
								
								<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapse_chat" aria-expanded="false" aria-controls="collapse_chat">Price For Chat</a></h3> </div>
							<div id="collapse_chat" class="panel-collapse @if(@$key['chat_price']) @else collapse @endif" role="tabpanel" aria-labelledby="heading_chat_price">
								<div class="diiferent-sec">
									<ul class="category-ul">

										<li>
											<label class="list_checkBox">Price doesn't matter
												<input type="checkbox" name="chat_price[]" value="1" onChange="this.form.submit()" @if(@$key['chat_price'] && in_array(1, @$key['chat_price'])) checked @endif>> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Above {{@session()->get('currencySym')}} 100/min
												<input type="checkbox" name="chat_price[]" value="101" onChange="this.form.submit()" @if(@$key['chat_price'] && in_array(101, @$key['chat_price']) && !in_array(1, @$key['chat_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>



										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 20/Min
												<input type="checkbox" name="chat_price[]" value="20" onChange="this.form.submit()" @if(@$key['chat_price'] && in_array(20, @$key['chat_price']) && !in_array(1, @$key['chat_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 50/Min
												<input type="checkbox" name="chat_price[]" value="50" onChange="this.form.submit()" @if(@$key['chat_price'] && in_array(50, @$key['chat_price']) && !in_array(1, @$key['chat_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 80/Min
												<input type="checkbox" name="chat_price[]" value="80" onChange="this.form.submit()" @if(@$key['chat_price'] && in_array(80, @$key['chat_price']) && !in_array(1, @$key['chat_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>
										<div class="moretext">
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 90/Min
														<input type="checkbox" name="chat_price[]" value="90" onChange="this.form.submit()" @if(@$key['chat_price'] && in_array(90, @$key['chat_price']) && !in_array(1, @$key['chat_price'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 100/Min
														<input type="checkbox" name="chat_price[]" value="100" onChange="this.form.submit()" @if(@$key['chat_price'] && in_array(100, @$key['chat_price']) && !in_array(1, @$key['chat_price'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
										</div>
										</ul> <a class="see-all moreless-button">View More +</a> </div>
							</div>

							@endif
							@if(@$is_offline || @$key['offline_price'])
							<div class="panel-heading" role="tab" id="heading_chat_price">
								
								<h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapse_chat" aria-expanded="false" aria-controls="collapse_chat">Price For Offline</a></h3> </div>
							<div id="collapse_chat" class="panel-collapse @if(@$key['offline_price']) @else collapse @endif" role="tabpanel" aria-labelledby="heading_chat_price">
								<div class="diiferent-sec">
									<ul class="category-ul">

										<li>
											<label class="list_checkBox">Price doesn't matter
												<input type="checkbox" name="offline_price[]" value="1" onChange="this.form.submit()" @if(@$key['offline_price'] && in_array(1, @$key['offline_price'])) checked @endif>> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Above {{@session()->get('currencySym')}} 100/min
												<input type="checkbox" name="offline_price[]" value="101" onChange="this.form.submit()" @if(@$key['offline_price'] && in_array(101, @$key['offline_price']) && !in_array(1, @$key['offline_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>



										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 20/Min
												<input type="checkbox" name="offline_price[]" value="20" onChange="this.form.submit()" @if(@$key['offline_price'] && in_array(20, @$key['offline_price']) && !in_array(1, @$key['offline_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 50/Min
												<input type="checkbox" name="offline_price[]" value="50" onChange="this.form.submit()" @if(@$key['offline_price'] && in_array(50, @$key['offline_price']) && !in_array(1, @$key['offline_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>

										<li>
											<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 80/Min
												<input type="checkbox" name="offline_price[]" value="80" onChange="this.form.submit()" @if(@$key['offline_price'] && in_array(80, @$key['offline_price']) && !in_array(1, @$key['offline_price'])) checked @endif> <span class="list_checkmark"></span> </label>
										</li>
										<div class="moretext">
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 90/Min
														<input type="checkbox" name="offline_price[]" value="90" onChange="this.form.submit()" @if(@$key['offline_price'] && in_array(90, @$key['offline_price']) && !in_array(1, @$key['offline_price'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
												<li>
													<label class="list_checkBox">Upto {{@session()->get('currencySym')}} 100/Min
														<input type="checkbox" name="offline_price[]" value="100" onChange="this.form.submit()" @if(@$key['offline_price'] && in_array(100, @$key['offline_price']) && !in_array(1, @$key['offline_price'])) checked @endif> <span class="list_checkmark"></span> </label>
												</li>
										</div>
										</ul> <a class="see-all moreless-button">View More +</a> </div>
							</div>

							@endif
						</div>
						<div class="clearfix"></div>
					</div>
				</div>

			


			<div class="col-lg-9 product-list">
				<div class="product-list-view">
				<section class="rm_astro_01">
    <div class="details-banners">
               <div class="banner-inners details-inner">
                  <div class="container">
          <div class="details-inner-rows">
                     <!--<div class="row row-content">
                        <div class="col-lg-9 col-md-12">
                           <div class="details-captions page_banner_data">
                              <p style="white-space:pre-wrap;">{!!@$content->description!!}</p>
                           </div>
                        </div>
                     </div>-->
           <div class="row" style="align-self: flex-end;">
                        <div class="col-12">
                           <ul class="nav nav-tabs" role="tablist">
						   @if(@$astro_tips->isNotEmpty())
                              <li class="nav-item">
                                 <a class="nav-link show active" data-toggle="tab" href="#menu1" id="who_when_tab">Astro Tips </a>
                              </li>
                              @endif
						   @if(@$content->why_who)
                              <li class="nav-item">
                                 <a class="nav-link @if(@$astro_tips->isEmpty()) show active @endif" data-toggle="tab" href="#menu2" id="who_when_tab">Why & Who </a>
                              </li>
                              @endif
                              @if(@$all_faq_cat->isNotEmpty())   
                              <li class="nav-item">
                                 <a class="nav-link @if(@$astro_tips->isEmpty() && !$content->why_who) show active @endif" data-toggle="tab" href="#menu5">FAQ</a>
                              </li>
                              @endif
                           </ul>
                        </div>
                     </div>
                     </div>
                  </div>
                  <div class="container">
                     
                  </div>
               </div>
              
                        <div class="tab-content">
						@if(@$astro_tips->isNotEmpty())
                           <div id="menu1" class="container tab-pane show active">
										  <div class="accordian-tips">
											 <div class="accordion" id="astrotips">
												@php $count= 1@endphp
												@foreach(@$astro_tips as $tips)
												<div class="card">
												   <div class="card-header" id="tipshead{{@$tips->id}}">
													  <a href="#" class="btn btn-header-link acco-chap collapsed" data-toggle="collapse" data-target="#tips{{@$tips->id}}" aria-expanded="true" aria-controls="tips{{@$tips->id}}">
														 <p class="word_wrapper"><span>{{@$count++}}. </span>{{@$tips->heading}}</p>
													  </a>
												   </div>
												   <div id="tips{{@$tips->id}}" class="collapse" aria-labelledby="tipshead{{@$tips->id}}" data-parent="#astrotips">
													  <div class="card-body horoscope_faq_answer">
														 <p style="white-space:pre-wrap;">{!!@$tips->description!!}</p>
													  </div>
												   </div>
												</div>
												@endforeach
												
											 </div>
										  </div>
									   </div>
						   @endif
						@if(@$content->why_who)
						<div id="menu2" class="container tab-pane @if(@$astro_tips->isEmpty()) show active @endif">
                           <div class="details-banner-tabs page_banner_data">
                              <h2>Why & Who  </h2>
                              <p style="white-space:pre-wrap;">{!!@$content->why_who!!}</p>
                           </div>
                        </div>
						@endif
                           @if(@$all_faq_cat->isNotEmpty())
                           <div id="menu5" class="container tab-pane @if(@$astro_tips->isEmpty() && !$content->why_who) show active @else fade @endif">
              @foreach(@$all_faq_cat as $faq1)
              <span class="faq-cat-details">{{@$faq1->parent->faq_category}} > {{@$faq1->faq_category}}</span>
                              <div class="accordian-faq">
                                 <div class="accordion" id="faqcat{{@$faq1->id}}">
                                    @php $count= 1@endphp
                                    @foreach(@$faq1->astrologerFaqDetails as $faq)
                                    <div class="card">
                                       <div class="card-header" id="faqhead{{@$faq->id}}">
                                          <a href="#" class="btn btn-header-link acco-chap collapsed" data-toggle="collapse" data-target="#faq{{@$faq->id}}" aria-expanded="true" aria-controls="faq{{@$faq->id}}">
                                             <p class="word_wrapper"><span>Q{{@$count++}}. </span>{{@$faq->question}}</p>
                                          </a>
                                       </div>
                                       <div id="faq{{@$faq->id}}" class="collapse" aria-labelledby="faqhead{{@$faq->id}}" data-parent="#faqcat{{@$faq1->id}}">
                                          <div class="card-body horoscope_faq_answer">
                                             <p style="white-space:pre-wrap;">{!!@$faq->answer!!}</p>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                    
                                 </div>
                              </div>
                @endforeach
                           </div>
               @endif
                        </div>
                   
            </div>
</section>
<section class="search-bred">
    
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0);">Astrologer</a></li>
                </ol>
           
</section>

	              <div class="top-total">
	              {{-- 	@php
                                $startnum = $endnum = 0;
                                $paginated = 10;
                                if(@$astrologers->total() == 0){
                                    $startnum = $endnum = 0;
                                } elseif($astrologers->currentPage() == 1 && $astrologers->total()>$paginated) {
                                    $startnum = 1;
                                    $endnum = $paginated;
                                } elseif($astrologers->currentPage() == 1 && $astrologers->total()<$paginated){
                                    $startnum = 1;
                                    $endnum = $astrologers->total();
                                } elseif($astrologers->count() == $paginated) {
                                    $startnum = (($astrologers->currentPage()-1) * $paginated) + 1;
                                    $endnum = $astrologers->currentPage() * $paginated;
                                } else {
                                    $startnum = (($astrologers->currentPage()-1) * $paginated) + 1;
                                    $endnum = $astrologers->total();
                                }
                            @endphp --}}
	                 <h5>Showing {{$astrologers->count()}} of {{@$totalAstrologer}} results for Astrologers </h5>

	                <div class="sort-filter">
	                  <p><img src="{{asset('public/frontend/images/sort.png')}}" class="sort-img"> Sort by : </p>
	                  <select class="sort-select" onchange="this.form.submit()" name="sort">
	                    <option value="">Select</option>
	                    <option value="1" @if(@$key['sort']=='1') selected @endif>Rating High To Low</option>
	                    <option value="2" @if(@$key['sort']=='2') selected @endif>Rating Low To High</option>
						<option value="3" @if(@$key['sort']=='3') selected @endif>Experience</option>
						@if(@$is_audio)
	                    <option value="4" @if(@$key['sort']=='4') selected @endif>Audio Call Price Low To High</option>
	                    <option value="5" @if(@$key['sort']=='5') selected @endif>Audio Call Price High To Low</option>
						@endif
						@if(@$is_video_call)
	                    <option value="6" @if(@$key['sort']=='6') selected @endif>Video Call Price Low To High</option>
	                    <option value="7" @if(@$key['sort']=='7') selected @endif>Video Call Price High To Low</option>
						@endif
						@if(@$is_chat)
						<option value="8" @if(@$key['sort']=='8') selected @endif>Chat Price Low To High</option>
	                    <option value="9" @if(@$key['sort']=='9') selected @endif>Chat Price High To Low</option>
						@endif
						@if(@$is_offline)
						<option value="10" @if(@$key['sort']=='10') selected @endif>Offline Price Low To High</option>
	                    <option value="11" @if(@$key['sort']=='11') selected @endif>Offline Price High To Low</option>
						@endif
						<option value="12" @if(@$key['sort']=='12') selected @endif>Alphabetically</option>
	                  </select>
	                  <div class="clearfix"></div>
	                </div>

	                <div class="sort-filter">
                            <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> Show Result : </p>
                            <select class="sort-select" name="show_result" id="show_result" onchange="this.form.submit()">
                                <option value="">Select</option>
                                <option value="12" @if(@$key['show_result']=='12') selected @endif>12</option>
                                <option value="24" @if(@$key['show_result']=='24') selected @endif>24</option>
                                <option value="48" @if(@$key['show_result']=='48') selected @endif>48</option>
                                <option value="96" @if(@$key['show_result']=='96') selected @endif>96</option>
                            </select>
                            <div class="clearfix"></div>
                        </div>

	            



	                <div class="clearfix"></div>
	              </div>
	              <div class="clearfix"></div>
	              <div class="all-products astro-custom-price">
	              	<div class="row">
	              		@if(@$astrologers->isNotEmpty())
	              		@foreach(@$astrologers as $astrologer)
	              		<div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
	              			<div class="take_astro_item">
							 <a href="{{route('astrologer.search.publicProfile',['slug'=>@$astrologer->slug])}}" target="_blank"><span><img src="@if(@$astrologer->profile_img!=""){{ URL::to('storage/app/public/profile_picture')}}/{{@$astrologer->profile_img}} @else {{asset('public/frontend/images/take_astro3.jpg')}} @endif" alt=""></span></a>
							 	<div class="take_astro_text">

							 		<a href="{{route('astrologer.search.publicProfile',['slug'=>@$astrologer->slug])}}" class="tack_new clickon" target="_blank" style="display: none" data-value="{{@$astrologer->slug}}" data-id="{{@$astrologer->id}}" data-profile-image="{{ asset('storage/app/public/profile_picture/'.@$astrologer->profile_img) }}"><i class="fa fa-envelope-o"></i>Talk Now</a>
							 		<h4><a href="{{route('astrologer.search.publicProfile',['slug'=>@$astrologer->slug])}}" target="_blank">{{@$astrologer->first_name}} {{@$astrologer->last_name}}</a><b><i class="fa fa-star"></i>{{@$astrologer->avg_review}}</b></h4>
								 	<ul class="talk_dat">
								 		<li><em><img src="{{asset('public/frontend/images/dollIconbag.png')}}" alt=""></em> {{@$astrologer->experience}} Years</li>
								 		

								 		@if(@$astrologer->is_audio_call=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)

								 			 @if(@$astrologer->call_discount_inr!=null && @$astrologer->call_discount_inr>0)

								 			 @php
                                                  $old_price = $astrologer->call_price;
                                                  $discount_value = ($old_price / 100) * @$astrologer->call_discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Audio Call :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->call_price}}/{{__('search.min')}} </del>-->{{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Audio Call : {{@session()->get('currencySym')}}  {{@$astrologer->call_price}}/{{__('search.min')}}
								 			@endif



								 			@else
								 			
								 			@if(@$astrologer->call_discount_usd!=null && @$astrologer->call_discount_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->call_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->call_discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Audio Call :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->call_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Audio Call : {{@session()->get('currencySym')}} {{round(@$astrologer->call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif
								 			
								 			@endif
								 			


								 		</li>
								 		@endif


								 		@if(@$astrologer->is_video_call=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)
								 			
								 			@if(@$astrologer->video_call_discount_inr!=null && @$astrologer->video_call_discount_inr>0)

								 			 @php
                                                  $old_price = $astrologer->video_call_price_inr;
                                                  $discount_value = ($old_price / 100) * @$astrologer->video_call_discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Video Call :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->video_call_discount_inr}}/{{__('search.min')}} </del>-->
                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Video Call : {{@session()->get('currencySym')}}  {{@$astrologer->call_price}}/{{__('search.min')}}
								 			@endif


								 			@else
								 			


								 			@if(@$astrologer->video_call_discount_usd!=null && @$astrologer->video_call_discount_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->video_call_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->video_call_discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Video Call :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->video_call_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Video Call : {{@session()->get('currencySym')}} {{round(@$astrologer->video_call_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif

											@endif
								 			


								 		</li>
								 		@endif


								 		@if(@$astrologer->is_chat=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)

								 			@if(@$astrologer->chat_discount_inr!=null && @$astrologer->chat_discount_inr>0)

								 			 @php
                                                  $old_price = $astrologer->chat_price_inr;
                                                  $discount_value = ($old_price / 100) * @$astrologer->chat_discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Chat  :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->chat_price_inr}}/{{__('search.min')}} </del>-->
                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Chat : {{@session()->get('currencySym')}} {{@$astrologer->chat_price_inr}}/{{__('search.min')}}
								 			@endif



								 			@else
								 			



								 			@if(@$astrologer->chat_discount_usd!=null && @$astrologer->chat_discount_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->chat_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->chat_discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Chat :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->chat_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Chat : {{@session()->get('currencySym')}} {{round(@$astrologer->chat_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif



								 			
								 			@endif
								 			


								 		</li>
								 		@endif
										
										@if(@$astrologer->is_astrologer_offer_offline=="Y")
								 		<li><em><img src="{{asset('public/frontend/images/dollIcon1.png')}}" alt=""></em>
								 			
								 			@if(@session()->get('currency')==1)

								 			@if(@$astrologer->offline_discount_price_inr!=null && @$astrologer->offline_discount_price_inr>0)

								 			 @php
                                                  $old_price = $astrologer->astrologer_offline_price_inr;
                                                  $discount_value = ($old_price / 100) * @$astrologer->offline_discount_price_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                                Offline  :  <!--<del>{{@session()->get('currencySym')}}  {{@$astrologer->astrologer_offline_price_inr}}/{{__('search.min')}} </del>-->
                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}

								 			 @else
												Offline : {{@session()->get('currencySym')}} {{@$astrologer->astrologer_offline_price_inr}}/{{__('search.min')}}
								 			@endif



								 			@else
								 			



								 			@if(@$astrologer->offline_discount_price_usd!=null && @$astrologer->offline_discount_price_usd>0)

								 			 @php
                                                  $old_price = @$custom * $astrologer->astrologer_offline_price_usd;
                                                  $discount_value = ($old_price / 100) * @$astrologer->offline_discount_price_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp

                                            Offline :   <!--<del>{{@session()->get('currencySym')}} {{@$custom * @$astrologer->astrologer_offline_price_usd}}/{{__('search.min')}} </del>-->
                                            {{@session()->get('currencySym')}} {{round(@$new_price,2)}}/{{__('search.min')}}
                                            @else
											Offline : {{@session()->get('currencySym')}} {{round(@$astrologer->astrologer_offline_price_usd*currencyConversionCustom(),2)}}/{{__('search.min')}}
											@endif



								 			
								 			@endif
								 			


								 		</li>
								 		@endif






								 		<li><em><img src="{{asset('public/frontend/images/icon5.png')}}" alt=""></em> @if(@$astrologer->astrologerExpertise->isNotEmpty())
								 			@foreach(@$astrologer->astrologerExpertise as $key3=>$expertise)
                                             {{-- {{@$expertise->experties->expertise_name}}, --}}
                                             @if($key3+1==@$astrologer->astrologerExpertise->count())
                                             {{@$expertise->experties->expertise_name}}
                                             @else
                                             {{@$expertise->experties->expertise_name}} ,
                                             @endif
                                            @endforeach
                                            @else
                                             No Experties Selected
                                            @endif</li>
								 	</ul>
							 	</div>
							 	<div class="clearfix"></div>
							 </div>
						</div>
					 @endforeach
	              	  @else
	              	  <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">No Data Found</div>
	              	  @endif
	              	  <div class="clearfix"></div>
	              	</div>
	              	<div class="clearfix"></div>
	              </div>
	              <div class="clearfix"></div>
	            </div>
                </div>
           </div>
		</div>
	</section>
</form>


		<section class="pagination-sec">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-3">
            <nav aria-label="Page navigation example" class="list-pagination">
              <ul class="pagination justify-content-end">
              	{{-- @if($astrologers->previousPageUrl() != null)
                <li class="page-item"> <a class="page-link page-link-next" href="{{$astrologers->previousPageUrl()}}" aria-label="Next">Previous<i class="icofont-long-arrow-right"></i></i>
                        </a> </li>
              	@endif --}}
                {{@$astrologers->appends(request()->except(['page', '_token']))->links()}}
                {{-- @if($astrologers->nextPageUrl() != null)
                <li class="page-item"> <a class="page-link page-link-next" href="{{$astrologers->nextPageUrl()}}" aria-label="Next">
                          Next<i class="icofont-long-arrow-right"></i></i>
                        </a> </li>
                @endif --}}
              </ul>
            </nav>
          </div>
			</div>
		</div>
	</section>


    <div class="modal" tabindex="-1" role="dialog" id="durarion">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h2 class="modal-title">Call Booking</h2>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                 <div class="modal-body">
                     <div class="row">
                         <div class="col-12">
                             <form method="POST" enctype="multipart/form-data" id="duration_from"
                                {{-- action="{{route('astrologer.call.booking',['slug'=>@$userData->slug])}}" --}} >
                                 @csrf
                                 <div class="main-center-div">@include('includes.message')
                                     <div class="login-from-area">
                                        <input type="hidden" name="astrologer_id" id="astrologer_id">
                                        <input type="hidden" id="astrologer_rate">
                                        <input type="hidden" id="u_id" @if(@auth()->user()->id) value="1" @endif>
                                        {{-- <h2>{{__('auth.otp_header')}}</h2> --}}
                                        <div class="marb20">
                                            <select class="login-type log-select" name="call_day" id="call_day">
                                                <option value="">Select Day</option>
                                                {{-- @foreach ($userData->userAvailable as $key=>$available)
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
                                                 @endforeach --}}
                                                 </select>
                                             </div>
                                         <div>
                                             <input class="login-type" id="time_duration" name="time_duration"
                                                type="number" placeholder="Duration in Min"
                                                oninput="this.value = this.value.replace(/[^0-9.]/g,'')">
                                             <div class="clearfix"></div>
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
        <div class="modal" tabindex="-1" role="dialog" id="call-duration">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Call Astrologer</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="main-center-div">
                                <div class="login-from-area">
                                    <em><img src="{{ asset('storage/app/public/profile_picture/'.@$userData->profile_img) }}" alt="" style="max-height: 100%; max-width: 100%;" id ="profileImage"></em>
                                    <p>{{ @$userData->first_name }}  {{ @$userData->last_name }}</p>
                                    <span id="timer">Calling...</span>
                                    <button class="hngp" type="button" id="button-hangup"><img src="{{ url('public/frontend/images/hngup.png') }}" /></button>
                                    <button class="callnw" style="display: none;" type="button" id="button-call"><img src="{{ url('public/images/cll.png') }}" /></button>
                                </div>
                            </div>
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
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}
	<script type="text/javascript">
	$(".mobile-list").click(function() {
		$(".search-filter").slideToggle();
	});
	$(".mobile_filter").click(function() {
		$(".left-profle").slideToggle();
	});
	</script>
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
   </script>
     <script type="text/javascript">

$('.moreless-button1').click(function() {
  $('.moretext1').slideToggle();
  if ($('.moreless-button1').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>
  <script type="text/javascript">

$('.moreless-button2').click(function() {
  $('.moretext2').slideToggle();
  if ($('.moreless-button2').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>

     <script type="text/javascript">

$('.moreless-button3').click(function() {
  $('.moretext3').slideToggle();
  if ($('.moreless-button3').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>


     <script type="text/javascript">

$('.moreless-button4').click(function() {
  $('.moretext4').slideToggle();
  if ($('.moreless-button4').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>
   <script>
	$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- <script>
 $(document).on('click', function () {
  var $target = $(event.target);
  if (!$target.closest('.shopcutBx').length
    && !$target.closest('.shopcut').length
    && $('.shopcutBx').is(":visible")) {
    $('.shopcutBx').slideUp();
  }
</script> --}}


<button type="button" id="get-devices"></button>
<input type="hidden" id="phone-number">
<script src="{{URL::to('public/frontend/js/twilio.min.js')}}"></script>
<script src="{{URL::to('public/frontend/js/quickstart.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
        $("#duration_from").validate({
            rules: {
                call_day:{
                    required: true,
                },
                time_duration:{
                    required: true,
                    number: true ,
                    min:5,
                    max:60,
                },
            },
            messages: {
                call_day:{
                    required: 'Select call booking day',
                },
                time_duration:{
                    required: 'Enter duration for call',
                    number: 'Only Number enter' ,
                    min:'Minumum call duration 5 minutes',
                    max:'Maximum call duration 60 minutes',
                },
            },
        });
        // $('.tack_new').click(function(){
        //     if(!$('#u_id').val()){
        //     Swal.fire('Please login to Call booking');
        //     return 0;
        //     }
        //     var slug = $(this).data('slug');
        //     console.log($(this).data('slug'))
        //     $('#call_day').html('');
        //     if (slug != "") {
        //         $.ajax({
        //             url: "astrologer-details/"+slug,
        //             method: 'GET',
        //             dataType: 'JSON'
        //         })
        //         .done(function (response) {
        //             if (response.result) {
        //                 const res = response.result.userData.user_available;
        //                 console.log(res);
        //                 $('#call_day').append('<option value="" selected>Select Day</option>');
        //                 $('#astrologer_rate').val(response.result.userData.call_price);
        //                 $('#astrologer_id').val(response.result.userData.id);
        //                 var url = '{{ route("astrologer.call.booking", ":slug") }}';
        //                 url = url.replace(':slug', response.result.userData.slug)
        //                 $('#duration_from').attr('action', url);
        //                 $.each(res, function (i, v) {
        //                     $('#call_day').append('<option value="' + v.day + '"">' + v.day + '</option>');
        //                 })
        //                 $("#durarion").modal("show");
        //             }else{
        //                 $('#call_day').html('<option value="" selected>Day Not Available</option>');
        //                 Swal.fire('Astrologer Day Not Available');
        //                 return 0;
        //             }
        //         })
        //         .fail(function (error) {
        //             $('#call_day').html('<option value="" selected>Select Day</option>');
        //         });
        //     } else {
        //         $('#call_day').html('<option value="" selected>Select Day</option>');
        //     }
        // })
        $('#time_duration').keyup(function(){
            var duration=$(this).val();
            var rate=$('#astrologer_rate').val();;
            $('#amount h3').html('Total Amount: - '+duration*rate);
            console.log(duration*rate)
        });
        $('#time_duration').blur(function(){
            var duration=$(this).val()
            var rate=$('#astrologer_rate').val();;
            $('#amount h3').html('Total Amount: - '+duration*rate);
            console.log(duration*rate)
        });
    })
</script>
<script>
    $(document).ready(function(){
        $("#view_mode").click(function(){
            $('.view_more_checkBox').css('display','block');
            $('#view_less').css('display','block');
            $('#view_mode').css('display','none');
        });
        $("#view_less").click(function(){
            $('.view_more_checkBox').css('display','none');
            $('#view_less').css('display','none');
            $('#view_mode').css('display','block');
        });
        $("#view_mode_lan").click(function(){
            $('.view_more_checkBox_lan').css('display','block');
            $('#view_less_lan').css('display','block');
            $('#view_mode_lan').css('display','none');
        });
        $("#view_less_lan").click(function(){
            $('.view_more_checkBox_lan').css('display','none');
            $('#view_less_lan').css('display','none');
            $('#view_mode_lan').css('display','block');
        });
    });
</script>

<script>
    var callStatus = 'initiated';
    var day= '{{date("l")}}';
    var astrologerId='';
    function startTimer(duration, display) {
        var minutes = '0'; var seconds = '01';
        var totMin = '0';
        var timer = duration, minutes, seconds;
        updateCustomerWallet(totMin, minutes, seconds);
        myInterval = setInterval(function () {
            updateCustomerWallet(totMin, minutes, seconds);
	    	if(callStatus == 'initiated') {
	    		display.text('Calling...');
			} else if(callStatus == 'ringing') {
	    		display.text('Ringing...');
			} else {
				minutes = parseInt(timer / 60, 10)
		        seconds = parseInt(timer % 60, 10)+2;
		        minutes = minutes < 10 ? "0" + minutes : minutes;
		        seconds = seconds < 10 ? "0" + seconds : seconds;
		        display.text(minutes + ":" + seconds);
		        var totMin = Math.ceil(parseInt(minutes) + (parseFloat(seconds) + 2) / 60);
		        if (timer++ < 0) {
		            timer = duration;
		        }
			}
        }, 1000);
    }
    function insertToOrderMaster(sId) {
		// console.log(sId);

        if(day=='Sunday'){
            var call_day ='SUNDAY';
        }
        if(day=='Monday'){
            var call_day ='MONDAY';
        }
        if(day=='Tuesday'){
            var call_day ='TUESDAY';
        }
        if(day=='Wednesday'){
            var call_day ='WEDNESDAY';
        }
        if(day=='Thursday'){
            var call_day ='THURSDAY';
        }
        if(day=='Friday'){
            var call_day ='FRIDAY';
        }
        if(day=='Saturday'){
            var call_day ='SATURDAY';
        }
		var reqData = {
			'jsonrpc': '2.0',
			'_token': '{{csrf_token()}}',
			'params': {
				astrologer_id: astrologerId,
				sid: sId,
                call_day:call_day
			}
		};
		$.ajax({
			url: '{{ route('customer.insert.order') }}',
			type: 'post',
			dataType: 'json',
			data: reqData,
		})
		.done(function(response) {
			// console.log(response);
		})
		.fail(function(error) {
			// console.log("error", error);
		})
		.always(function() {
			// console.log("complete");
		});
	}

    function disconnectCall() {
        // location.reload();
	}
    function updateCustomerWallet(totMin, minutes, seconds) {
		// console.log(totMin, minutes, seconds);
		var reqData = {
			'jsonrpc': '2.0',
			'_token': '{{csrf_token()}}',
			'params': {

			}
		};
		$.ajax({
			url: '{{ route('customer.order.status') }}',
			type: 'post',
			dataType: 'json',
			data: reqData,
		})
		.done(function(response) {
			if(response.error) {
				toastr.error(response.error);
				console.log(response.error);
			} else {
                if(response.result){

                    callStatus = response.result.call_status;
                }
			}
			// console.log(response);
		})
		.fail(function(error) {
			// console.log("error", error);
		})
		.always(function() {
			// console.log("complete");
		});
	}
</script>
<script>
    $(document).ready(function(){

		// click Call Now button
        $('.tack_new').click(function(){
            if(!$('#u_id').val()){
                Swal.fire('Please login to Call booking');
                return 0;
            }
            var slug = $(this).data('value');
            astrologerId = $(this).data('id');
            var profileImage = $(this).data('profile-image');
            var reqData = {
                'jsonrpc': '2.0',
                '_token': '{{csrf_token()}}',
                'params': {
                    astrologerId: astrologerId,
                }
            };
            $.ajax({
                url: '{{ route('customer.check.astrologer.available') }}',
                type: 'post',
                dataType: 'json',
                data: reqData,
            })
            .done(function(response) {
                if(response.error) {
                    // toastr.error(response.error);
                    console.log(response.error);
                } else {
                    if(response.result){
                        if(response.result.available=='N'){
                            console.log(slug);
                            $('#call_day').html('');
                            if (slug != "") {
                                $.ajax({
                                    url: "astrologer-details/"+slug,
                                    method: 'GET',
                                    dataType: 'JSON'
                                })
                                .done(function (response) {
                                    if (response.result) {
                                        const res = response.result.userData.user_available;
                                        console.log(res);
                                        $('#call_day').append('<option value= "" selected>Select Day</option>');
                                        $('#astrologer_rate').val(response.result.userData.call_price);
                                        $('#astrologer_id').val(response.result.userData.id);
                                        var url = '{{ route("astrologer.call.booking", ":slug") }}';
                                        url = url.replace(':slug', response.result.userData.slug);
                                        $('#duration_from').attr('action', url);
                                        $.each(res, function (i, v) {
                                            $('#call_day').append('<option value="' + v.day + '"">' + v.day + '</option>');
                                        })
                                        $("#durarion").modal("show");
                                    }else{
                                        $('#call_day').html('<option value="" selected>Day Not Available</option>');
                                        Swal.fire('Astrologer Day Not Available');
                                        return 0;
                                    }
                                })
                                .fail(function (error) {
                                    $('#call_day').html('<option value="" selected>Select Day</option>');
                                });
                            } else {
                                $('#call_day').html('<option value="" selected>Select Day</option>');
                            }
                        }else{
                            $('#profileImage').attr("src", profileImage);
                            $("#call-duration").modal("show");
                            $('#phone-number').val('+917980768406');
                            $('#button-call').trigger('click');
                        }
                    }
                }
            })
            .fail(function(error) {

            })
            .always(function() {

            });
        });


        $("#call-duration").on('hidden.bs.modal', function (e) {
            $('#button-hangup').trigger('click');
            clearInterval(myInterval);
        });





        // $('.tack_new').click(function(){
        //     if(!$('#u_id').val()){
        //     Swal.fire('Please login to Call booking');
        //     return 0;
        //     }
        //     var slug = $(this).data('slug');
        //     console.log($(this).data('slug'))
        //     $('#call_day').html('');
        //     if (slug != "") {
        //         $.ajax({
        //             url: "astrologer-details/"+slug,
        //             method: 'GET',
        //             dataType: 'JSON'
        //         })
        //         .done(function (response) {
        //             if (response.result) {
        //                 const res = response.result.userData.user_available;
        //                 console.log(res);
        //                 $('#call_day').append('<option value="" selected>Select Day</option>');
        //                 $('#astrologer_rate').val(response.result.userData.call_price);
        //                 $('#astrologer_id').val(response.result.userData.id);
        //                 var url = '{{ route("astrologer.call.booking", ":slug") }}';
        //                 url = url.replace(':slug', response.result.userData.slug)
        //                 $('#duration_from').attr('action', url);
        //                 $.each(res, function (i, v) {
        //                     $('#call_day').append('<option value="' + v.day + '"">' + v.day + '</option>');
        //                 })
        //                 $("#durarion").modal("show");
        //             }else{
        //                 $('#call_day').html('<option value="" selected>Day Not Available</option>');
        //                 Swal.fire('Astrologer Day Not Available');
        //                 return 0;
        //             }
        //         })
        //         .fail(function (error) {
        //             $('#call_day').html('<option value="" selected>Select Day</option>');
        //         });
        //     } else {
        //         $('#call_day').html('<option value="" selected>Select Day</option>');
        //     }
        // })
    });
</script>
@endsection

