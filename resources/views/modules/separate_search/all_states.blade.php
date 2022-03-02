@extends('layouts.app')

@section('title')
<title>All States</title>
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
						@if(@$states->isNotEmpty())
						@foreach(@$states as $value)
						@php
							$getexpertise =  DB::table('astrologer_expertise')->join('users','astrologer_expertise.user_id','=','users.id')->where('state',@$value->id)->where('users.status','A')->where('approve_by_admin','Y')->where('user_availability','Y')->groupBy('expertise_id')->pluck('expertise_id');
							$getexpertise=count($getexpertise);
						@endphp
						<a href="@if(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id,'id1'=>$value->country_id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$value->country_id,'id2'=>'sc'])}} @endif">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id,'id1'=>$value->country_id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$value->country_id,'id2'=>'sc'])}} @endif" class="lists_icons">	    	
								<img src="{{ URL::to('public/frontend/images/country.png')}}">
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id,'id1'=>$value->country_id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$value->country_id,'id2'=>'sc'])}} @endif">{{@$value->name}}</a>
									<p>@if(@$getexpertise) {{@$getexpertise}} Expertise @elseif(@$value->user_details_count) {{@$value->user_details_count}} Astrologers @else 0 Astrologer @endif</p>
									</div>
									<a href="@if(@$getexpertise) {{route('astrologer.search.expertise',['id'=>@$value->id,'id1'=>$value->country_id])}}  @else {{route('astrologer.search.all',['id'=>@$value->id,'id1'=>@$value->country_id,'id2'=>'sc'])}} @endif" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No States Found</li>
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
            {{@$states->links()}}
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

