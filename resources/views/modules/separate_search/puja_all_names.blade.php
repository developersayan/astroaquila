@extends('layouts.app')

@section('title')
<title>All Puja Names</title>
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
							<h3>All Puja Names</h3>
							<p>Browse All Puja Names </p>
							<div class="mb-breadcrumbs">
                              <ul>
							  @if(@$category->parent)
								  <li><a href="{{route('puja.search.category')}}" style="color: white"> {{@$category->parent->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
								@else
									<li><a href="{{route('puja.search.category')}}" style="color: white"> {{@$category->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
								@endif                                 
								 @if(@$category->parent)
								 <li><a href="{{route('puja.search.category')}}" style="color: white"> {{@$category->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
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
						@if(@$puja_names->isNotEmpty())
						@foreach(@$puja_names as $value)
						<a href="@if(@$value->puja_count) {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}} @else {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}}  @endif">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if(@$value->puja_count) {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}} @else {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}}  @endif" class="lists_icons">
							    @if(@$value->image=='')		
								<img src="{{ URL::to('public/frontend/images/dash-ic3.png')}}">
								@else
								<img src="{{ URL::to('storage/app/public/puja_name_image')}}/{{@$value->image}}">
								@endif
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if(@$value->puja_count) {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}} @else {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}}  @endif">{{@$value->name}}</a>
									<p>@if(@$value->puja_count) {{@$value->puja_count}} Pujas @else 0 Pujas @endif</p>
									</div>
									<a href="@if(@$value->puja_count) {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}} @else {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>$value->id])}}  @endif" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No Puja Names Found</li>
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

