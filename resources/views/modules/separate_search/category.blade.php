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
									$gettitle = DB::table('products')->where('product_type','GS')->where('category_id',$value->id)->where('title_id','!=','')->where('status','!=','D')->pluck('title_id')->toArray();
								     
								        $common  = array_unique($gettitle);
								        $count = count($common);
								        $product = DB::table('products')->where('product_type','GS')->where('category_id',$value->id)->get();
								        $count_product = count($product);
						?>
						<a href="@if(@$count>0){{route('gemstone.search.title',['id'=>@$value->id])}} @else {{route('gemstone.search.category-search',['id'=>@$value->id])}} @endif">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if(@$count>0){{route('gemstone.search.title',['id'=>@$value->id])}} @else {{route('gemstone.search.category-search',['id'=>@$value->id])}} @endif" class="lists_icons">
							    @if(@@$value->image=='')		
								<img src="{{ URL::to('public/frontend/images/dash-ic1.png')}}">
								@else
								<img src="{{ URL::to('storage/app/public/gemstone_category')}}/{{@$value->image}}">
								@endif
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if(@$count>0){{route('gemstone.search.title',['id'=>@$value->id])}} @else {{route('gemstone.search.category-search',['id'=>@$value->id])}} @endif">{{@$value->category_name}}</a>

									<p>@if(@$count>0) {{@$count}} titles @else {{$count_product}} Gemstone @endif</p>
									</div>
									<a href="@if(@$count>0){{route('gemstone.search.title',['id'=>@$value->id])}} @else {{route('gemstone.search.category-search',['id'=>@$value->id])}} @endif" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
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

