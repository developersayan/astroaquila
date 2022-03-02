@extends('layouts.app')

@section('title')
<title>Horoscope Sub Categories</title>
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
							<h3>Horoscope Title</h3>
							{{-- <p>Browse All Puja Sub Categories </p> --}}
							<div class="mb-breadcrumbs">
                              <ul>
                              	<li><a href="{{route('hororscope.all.category')}}" style="color: white"> {{@$category->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
                              	@if(@$subCategory)
                              	<li><a href="{{route('hororscope.sub.category',['id'=>@$category->id])}}" style="color: white"> {{@$subCategory->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
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
						@if(@$title->isNotEmpty())
						@foreach(@$title as $value)
						<?php 
									$array = [];
									$horoscope =  DB::table('horoscope')->where('title_id',@$value->id)->where('sub_category_id',@$subCategory->id)->where('status','A')->pluck('id')->toArray();   
									$count = count($horoscope);
						?>
						<a href="{{route('horoscope.separate.search',['id'=>@$value->id,'cat'=>@$subCategory->id])}}">
						<li>
							
							<div class="categ-lists">
								
								<a href="{{route('horoscope.separate.search',['id'=>@$value->id,'cat'=>@$subCategory->id])}}" class="lists_icons">
							    @if(@$value->image=='')		
								<img src="{{ URL::to('public/frontend/images/banerpick1.png')}}">
								@else
								<img src="{{ URL::to('storage/app/public/horoscope_title')}}/{{@$value->image}}">
								@endif
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="{{route('horoscope.separate.search',['id'=>@$value->id,'cat'=>@$subCategory->id])}}">{{@$value->title}}</a>
										
									<p>{{@$count}} Horoscopes</p>
									</div>
									
									<a href="{{route('horoscope.separate.search',['id'=>@$value->id,'cat'=>@$subCategory->id])}}" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No Title Found</li>
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

