@extends('layouts.app')

@section('title')
<title>All Gamestone Sub Title</title>
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
							<h3>All Gamestone Sub Title</h3>
							<p>Browse All Gamestone Sub Title </p>
							<div class="mb-breadcrumbs">
                              <ul>
                                 <li><a href="{{route('gemstone.search.category')}}" style="color: white"> {{@$category->category_name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
                                 <li><a href="{{route('gemstone.search.title',['id'=>@$category->id])}}" style="color: white"> {{@$title->title}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
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
			{{-- <div class="row">
                        <div class="col-lg-9 col-md-12">
                           <div class="mb-breadcrumbs">
                              <ul>
                                 <li><a href="{{route('gemstone.search.category')}}"> {{@$category->category_name}} </a> <span>             &nbsp; /  &nbsp;</span></li>
                                 <li><a href="{{route('gemstone.search.title',['id'=>@$category->id])}}"> {{@$title->title}} </a> <span>             &nbsp; /  &nbsp;</span></li>
								 <div class="clearfix"></div>
                              </ul>
                           </div>
                         </div>
                     </div> --}}
			<div class="row">
				<div class="col-md-12">
					<ul class="cayegoies_uls">
						@if(@$subtitle->isNotEmpty())
						@foreach(@$subtitle as $value)
						<a href="{{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}}">
						<li>
							
							<div class="categ-lists">
								
								<a href="{{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}}" class="lists_icons">
									 @if(@@$value->image=='')		
										<img src="{{ URL::to('public/frontend/images/dash-ic1.png')}}">
										@else
										<img src="{{ URL::to('storage/app/public/gemstone_title')}}/{{@$value->image}}">
										@endif
								</a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="{{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}}">{{@$value->title}}</a>
										<?php
										$array = [];
								        $getsub = DB::table('products')->where('product_type','GS')->where('subtitle_id',$value->id)->where('status','!=','D')->where('category_id',@$category->id)->count();
								        ?>
								        <p>{{@$getsub}} Products</p>
									
									</div>
									<a href="{{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}}" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No Gamestone Sub Title Found</li>
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

