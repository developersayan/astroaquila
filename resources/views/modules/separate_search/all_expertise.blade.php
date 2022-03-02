@extends('layouts.app')

@section('title')
<title>All Expertise</title>
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
							<h3>All States</h3>
							<p>Browse All States </p>
							<div class="mb-breadcrumbs">
                              <ul>
                                 <li><a href="{{route('astrologer.search.country')}}" style="color: white"> {{@$country->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
								 @if(@$state)
									 <li><a href="{{route('astrologer.search.state',['id'=>$state->country_id])}}" style="color: white"> {{@$state->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
									 @endif
								 <div class="clearfix"></div>
                              </ul>
                           </div>
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
						@if(@$expertise->isNotEmpty())
						@foreach(@$expertise as $value)
					@php
					if(@$state)
					{
						$getusers =  DB::table('users')->join('astrologer_expertise','astrologer_expertise.user_id','=','users.id')->where('state',@$state->id)->where('expertise_id',@$value->id)->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y')->groupBy('user_id')->pluck('users.id');	
					}
					else
					{
						$getusers =  DB::table('users')->join('astrologer_expertise','astrologer_expertise.user_id','=','users.id')->where('country_id',@$country->id)->where('expertise_id',@$value->id)->where('users.status','A')->where('user_availability','Y')->where('approve_by_admin','Y')->groupBy('user_id')->pluck('users.id');	
					}
					$getusers=$getusers->count();
					@endphp
						<a href="@if(@$state) {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$state->id,'id2'=>'es'])}} @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$country->id,'id2'=>'ec'])}} @endif">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if(@$state) {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$state->id,'id2'=>'es'])}} @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$country->id,'id2'=>'ec'])}} @endif" class="lists_icons">	    	
								<img src="{{ URL::to('public/frontend/images/country.png')}}">
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if(@$state) {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$state->id,'id2'=>'es'])}} @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$country->id,'id2'=>'ec'])}} @endif">{{@$value->expertise_name}}</a>
									<p>@if(@$getusers) {{@$getusers}} Astrologers @else 0 Astrologer @endif</p>
									</div>
									<a href="@if(@$state) {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$state->id,'id2'=>'es'])}} @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$country->id,'id2'=>'ec'])}} @endif" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No Expertise Found</li>
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
            {{@$expertise->links()}}
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

