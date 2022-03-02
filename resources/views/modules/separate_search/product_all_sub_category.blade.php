@extends('layouts.app')

@section('title')
<title>All Product Sub Category</title>
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
							<h3>All Product Sub Category</h3>
							<p>Browse All Product Sub Categories </p>
							<div class="mb-breadcrumbs">
                              <ul>
                                 <li><a href="{{route('product.all.categories')}}" style="color: white"> {{@$category->name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
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
						@if(@$sub_category->isNotEmpty())
						@foreach(@$sub_category as $value)
						<?php 
									$array = [];
									$getproduct =  DB::table('products')->where('sub_category_id',@$value->id)->where('status','A')->where('product_type','AP')->pluck('id')->toArray();   
								    $countProduct = count($getproduct);
						?>
						<a href=" {{route('product.separate.search',['id'=>@$value->id])}}">
						<li>
							
							<div class="categ-lists">
								
								<a href="{{route('product.separate.search',['id'=>@$value->id])}}" class="lists_icons">
							    @if(@$value->image=='')		
								<img src="{{ URL::to('public/frontend/images/banerpick1.png')}}">
								@else
								<img src="{{ URL::to('storage/app/public/product_category_image')}}/{{@$value->image}}">
								@endif
							   </a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="{{route('product.separate.search',['id'=>@$value->id])}}">{{@$value->name}}</a>
										
									<p>{{@$countProduct}} Products</p>
									</div>
									
									<a href="{{route('product.separate.search',['id'=>@$value->id])}}" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
									
									
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

