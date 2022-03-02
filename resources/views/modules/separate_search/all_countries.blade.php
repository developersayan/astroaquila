@extends('layouts.app')

@section('title')
<title>All Countries</title>
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
	<section class="pad-114">
		<div class="banner-inner">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="inner-headings">
							<h3>All Countries</h3>
							<p>Browse All Countries </p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="categys_sec">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<ul class="cayegoies_uls">
						@if(@$countries->isNotEmpty())
						@foreach(@$countries as $value)
					@php
						$getexpertise =  DB::table('astrologer_expertise')->join('users','astrologer_expertise.user_id','=','users.id')->where('country_id',@$value->id)->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y')->groupBy('expertise_id')->pluck('expertise_id')->toArray();
						$getexpertise =count(@$getexpertise);
					@endphp
						<a href="@if(@$value->state_count) {{route('astrologer.search.state',['id'=>@$value->id])}} @elseif(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id])}} @elseif(@$value->user_details_count) {{route('astrologer.search.all',['id'=>@$value->id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id])}} @endif">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if(@$value->state_count) {{route('astrologer.search.state',['id'=>@$value->id])}} @elseif(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id])}}  @elseif(@$value->user_details_count) {{route('astrologer.search.all',['id'=>@$value->id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id])}} @endif" class="lists_icons">
								<img src="{{ URL::to('public/frontend/images/country.png')}}">								
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if(@$value->state_count) {{route('astrologer.search.state',['id'=>@$value->id])}} @elseif(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id])}}  @elseif(@$value->user_details_count) {{route('astrologer.search.all',['id'=>@$value->id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id])}} @endif">{{@$value->name}}</a>
									<p>@if(@$value->state_count) {{@$value->state_count}} States @elseif(@$getexpertise) {{@$getexpertise}} Expertise @elseif(@$value->user_details_count) {{@$value->user_details_count}} Astrologers @else 0 Astrologer @endif</p>
									</div>
									<a href="@if(@$value->state_count) {{route('astrologer.search.state',['id'=>@$value->id])}} @elseif(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id])}}  @elseif(@$value->user_details_count) {{route('astrologer.search.all',['id'=>@$value->id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id])}} @endif" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No Countries Found</li>
						@endif

					</ul>
				</div>
			</div>
		</div>
	</section>

<section class="pagination-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
        <nav aria-label="Page navigation example" class="list-pagination">
          <ul class="pagination justify-content-end rtg">
            {{@$countries->links()}}
          </ul>
        </nav>
      </div>
        </div>
    </div>
</section>
@endsection

@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
@endsection

