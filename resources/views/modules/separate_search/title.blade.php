@extends('layouts.app')

@section('title')
<title>All Gamestone Title</title>
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
							<h3>All Gamestone Title</h3>
							<p>Browse All Gamestone Title </p>
							<div class="mb-breadcrumbs">
                              <ul>
                                 <li><a href="{{route('gemstone.search.category')}}" style="color: white"> {{@$category->category_name}} </a> <span style="color: white">             &nbsp; /  &nbsp;</span></li>
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
							        $getsub = DB::table('products')->where('product_type','GS')->where('title_id',$value->id)->where('subtitle_id','!=','')->where('status','!=','D')->pluck('subtitle_id')->toArray();
							        $common  = array_unique($getsub);
								    $count = count($common);

								    $getproduct = DB::table('products')->where('product_type','GS')->where('title_id',$value->id)->where('status','!=','D')->pluck('id')->toArray();
								    $product = count($getproduct);

						?>

						<a href="@if($count>0){{route('gemstone.search.sub-title',['id'=>@$value->id,'cat'=>@$category->id])}} @else {{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}} @endif">
						<li>
							
							<div class="categ-lists">
								
								<a href="@if($count>0){{route('gemstone.search.sub-title',['id'=>@$value->id,'cat'=>@$category->id])}} @else {{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}} @endif" class="lists_icons">
									
									@if(@@$value->image=='')		
										<img src="{{ URL::to('public/frontend/images/dash-ic1.png')}}">
										@else
										<img src="{{ URL::to('storage/app/public/gemstone_title')}}/{{@$value->image}}">
										@endif
								</a>
								<div class="lists_li">								
									<div class="text-left">
										<a href="@if($count>0){{route('gemstone.search.sub-title',['id'=>@$value->id,'cat'=>@$category->id])}} @else {{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}} @endif">{{@$value->title}}</a>
									
									<p>@if(@$count>0){{@$count}} Sub titles @else {{@$product}} Gemstone @endif</p>
									
									</div>
									<a href="@if($count>0){{route('gemstone.search.sub-title',['id'=>@$value->id,'cat'=>@$category->id])}} @else {{route('gemstone.search.sub-title-search',['id'=>@$value->id,'cat'=>@$category->id])}} @endif" class="nest"><img src="{{asset('public/frontend/images/submitarw1.png')}}" alt=""></a>
								</div>
								
							</div>
							
						</li>
						</a>
					
						@endforeach
						@else
						<li>No Gamestone Title Found</li>
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

