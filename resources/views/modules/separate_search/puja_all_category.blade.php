@extends('layouts.app')

@section('title')
<title>All Puja Categories</title>
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
							<h3>All Category</h3>
							<p>Browse All Categories </p>
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
						@if(@$categories->isNotEmpty())
						@foreach(@$categories as $value)
					
						<a href="@if(@$value->subcat_count) {{route('puja.search.sub.category',['slug'=>@$value->slug])}} @elseif(@$value->puja_name_count) {{route('puja.search.puja-name',['slug'=>@$value->slug])}} @elseif(@$value->puja_details_count) {{route('puja.search.puja-search',['slug'=>@$value->slug])}}  @else {{route('puja.search.puja-search',['slug'=>@$value->slug])}} @endif">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if(@$value->subcat_count) {{route('puja.search.sub.category',['slug'=>@$value->slug])}} @elseif(@$value->puja_name_count) {{route('puja.search.puja-name',['slug'=>@$value->slug])}} @elseif(@$value->puja_details_count) {{route('puja.search.puja-search',['slug'=>@$value->slug])}}  @else {{route('puja.search.puja-search',['slug'=>@$value->slug])}} @endif" class="lists_icons">
							    @if(@$value->image=='')		
								<img src="{{ URL::to('public/frontend/images/dash-ic3.png')}}">
								@else
								<img src="{{ URL::to('storage/app/public/puja_cat_image')}}/{{@$value->image}}">
								@endif
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if(@$value->subcat_count) {{route('puja.search.sub.category',['slug'=>@$value->slug])}} @elseif(@$value->puja_name_count) {{route('puja.search.puja-name',['slug'=>@$value->slug])}} @elseif(@$value->puja_details_count) {{route('puja.search.puja-search',['slug'=>@$value->slug])}}  @else {{route('puja.search.puja-search',['slug'=>@$value->slug])}} @endif">{{@$value->name}}</a>
									<p>@if(@$value->subcat_count) {{@$value->subcat_count}} Sub Categories @elseif(@$value->puja_name_count) {{@$value->puja_name_count}} Puja Names @elseif(@$value->puja_details_count) {{@$value->puja_details_count}} Pujas @else 0 Pujas @endif</p>
									</div>
									<a href="@if(@$value->subcat_count) {{route('puja.search.sub.category',['slug'=>@$value->slug])}} @elseif(@$value->puja_name_count) {{route('puja.search.puja-name',['slug'=>@$value->slug])}} @elseif(@$value->puja_details_count) {{route('puja.search.puja-search',['slug'=>@$value->slug])}}  @else {{route('puja.search.puja-search',['slug'=>@$value->slug])}} @endif" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No Category Found</li>
						@endif

					</ul>
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

