@extends('layouts.app')

@section('title')
@if(@$data->meta_title)
<meta property="og:title" content="Product Details | {{$data->meta_title}}">
@else
<meta property="og:title" content="Product Details | {{$data->article_title}}">
@endif
@if(@$data->meta_desc)
<meta property="og:description" content="{{strip_tags(@$data->meta_desc)}}">
@else
<meta property="og:description" content="{{ strip_tags(substr(@$data->description,0,150))}}">
@endif
@if(@$data->image)
<meta property="og:image" content="{{ URL::to('storage/app/public/wiki_image')}}/{{@$data->image}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
<title>Wiki Details</title>
@endsection

@section('style')
@include('includes.style')
<style type="text/css">
	.videos-blog-text p{
		word-break: break-all;
	}
	.videos-data-item{
		margin-top: 20px;
		padding: 10px;
		border:1px solid #ccc;
		background: #fff;
		margin-bottom: 25px;
	}
	.videos-data-text{
		margin-top: 15px;
	}
	.videos-data-text a h2{
		font-size:20px;
		color: #000;
		margin-bottom: 8px;
	}
	.videos-data-text p{
		color: #737373;
		word-break: break-all;
	}
</style>
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class="pad-114 data_ban">
		<div class="banner-inner">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="inner-headings">
							<h3>Wiki Details</h3>
							<div class="shareBx">
								<span><i class="fa fa-share-square-o" aria-hidden="true"></i>Share:</span>
								
                              <div class="clearfix"></div>
                              
								<ul style="min-width: 160px">
									<div class="sharethis-inline-share-buttons"></div>
								</ul>		
							</div> 
							<ul>
                                 <li><a href="#" style="color: white"> {{@$data->getCategory->name}} </a> <span style="color: white"></span>
                                 @if(@$data->subcategory)
                                 
                                 <a href="#" style="color: white">  &nbsp; /  &nbsp;{{@$data->getCategory->name}} </a> <span style="color: white"></span>
                                 @endif
                                 <a href="#" style="color: white"> &nbsp; /  &nbsp; {{@$data->getTitle->title}} </a> <span style="color: white"></span>
                                 </li>
								 <div class="clearfix"></div>
                              </ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

<section class="blogSec blog-details">
	<div class="container">
		<div class="blogIner">
			<div class="blogleft">
				<div class="blog-details-iner">					
					<div class="astro_details">
						<div class="ast_det_left">
							<div class="row">
								<div class="col-md-12">
									<div class="videos-blog-item">
										<div class="videos-blog-img">
											<img src="{{ URL::to('storage/app/public/wiki_image')}}/{{@$data->image}}">
										</div>
										<div class="videos-blog-text">
											<h5><a href="#url">{{@$data->article_title}}</a></h5>
											<p>{!!@$data->description!!} </p>
											@if(@$data->pdf)
											<div id="adobe-dc-view" style="height: 800px; width: 100%;"></div>
											@endif											
										</div>
									</div>
								</div>
							</div>
						</div>						
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>

@if(@$similar->isNotEmpty())
<section class="dataSec dataSec_fll data_bot">
	<div class="container">
		<div class="dataIner">
			<div class="dataleft">
				<div class="pghed mb-3">
             		<h3>Similar  <b>Posts</b></h3>
             		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor<br> iullamco laboris nisi ut aliquip ex ea commodo </p>
         		</div>
				<div class="dataleft-inr">
					<div class="row">						
						@if(@$similar->isNotEmpty())
						@foreach(@$similar as $data)
						<div class="col-md-4">
					    <div class="videos-data-item">
					     <a href="{{route('aquila.wiki.details',['slug'=>@$data->slug])}}" target="_blank">
						<div class="videos-data-img">
							<img src="{{ URL::to('storage/app/public/wiki_image')}}/{{@$data->image}}" style="    width: 100%;
    height: 262px;">
						</div>
					   </a>
						<div class="videos-data-text">
							<a href="{{route('aquila.wiki.details',['slug'=>@$data->slug])}}" target="_blank"><h2>
								{{@$data->getTitle->title}}/{{@$data->article_title}}
							</h2></a>
							<p>

								@if(strlen(@$data->description) >200)
								{!!strip_tags(substr(@$data->description, 0, 200 ))!!}...
								@else
								{!!@$data->description!!}

								@endif
							</p>
							<a href="{{route('aquila.wiki.details',['slug'=>@$data->slug])}}" target="_blank" class="red_mor">View more</a>
						</div>
					</div>
				</div>
				@endforeach
			@endif

						
					</div>
				</div>
			</div>			
		</div>
	</div>
</section>
@else
@endif

@endsection
@section('footer')
@include('includes.footer')
@endsection

@section('script')
@include('includes.script')
@if(@$data->pdf)
<script src="https://documentcloud.adobe.com/view-sdk/main.js"></script>
<script type="text/javascript">
	document.addEventListener("adobe_dc_view_sdk.ready", function(){ 
		var adobeDCView = new AdobeDC.View({clientId: "{{env('ADOBE_CLIENT_ID')}}", divId: "adobe-dc-view"});
		adobeDCView.previewFile({
			content:{location: {url: "{{URL::to('storage/app/public/wiki_pdf/'.$data->pdf)}}"}},
			metaData:{fileName: "{{$data->pdf}}"}
		}, {embedMode: "SIZED_CONTAINER", showDownloadPDF: false, showPrintPDF: false});
	});
</script>
@endif
<script>
	$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });
</script>
<script>	
 $(document).on('click', function () {
  var $target = $(event.target);  
  if (!$target.closest('.shopcutBx').length
    && !$target.closest('.shopcut').length
    && $('.shopcutBx').is(":visible")) {
    $('.shopcutBx').slideUp();
  } 
  });
</script>
@endsection
