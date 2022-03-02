@extends('layouts.app')

@section('title')
<title>All Category</title>
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
						@if(@$category->isNotEmpty())
						@foreach(@$category as $value)
						<?php 
									$array = [];
									$getsub = DB::table('horoscope_category')->where('parent_id',@$value->id)->pluck('id')->toArray();
									$count = count($getsub);
								    
								    $gettitle =  DB::table('horoscope')->where('category_id',@$value->id)->where('status','A')->pluck('title_id')->toArray();   
								    $common  = array_unique($gettitle);
								    $countTitle = count($common);
						?>
						<a href=" @if($count>0){{route('hororscope.sub.category',['id'=>@$value->id])}} @else {{route('horoscope.category.title.get',['id'=>@$value->id])}} @endif ">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if($count>0){{route('hororscope.sub.category',['id'=>@$value->id])}} @else {{route('horoscope.category.title.get',['id'=>@$value->id])}} @endif" class="lists_icons">
							    @if(@$value->image=='')		
								<img src="{{ URL::to('public/frontend/images/banerpick1.png')}}">
								@else
								<img src="{{ URL::to('storage/app/public/horoscope_category')}}/{{@$value->image}}">
								@endif
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if($count>0){{route('hororscope.sub.category',['id'=>@$value->id])}} @else {{route('horoscope.category.title.get',['id'=>@$value->id])}} @endif">{{@$value->name}}</a>
										
									<p>@if($count>0){{@$count}} Sub Category @else {{$countTitle}} Title @endif</p>
									</div>
									@if($count>0)
									<a href="{{route('hororscope.sub.category',['id'=>@$value->id])}}" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
									@else
									<a href="{{route('horoscope.category.title.get',['id'=>@$value->id])}}" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
									@endif
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

