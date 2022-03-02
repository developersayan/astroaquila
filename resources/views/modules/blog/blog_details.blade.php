@extends('layouts.app')

@section('title')
@if(@$blog->meta_title)
<meta property="og:title" content="Product Details | {{$blog->meta_title}}">
@else
<meta property="og:title" content="Product Details | {{$blog->product_name}}">
@endif
@if(@$blog->meta_desc)
<meta property="og:description" content="{!! @$blog->meta_desc !!}">
@else
<meta property="og:description" content="{!! substr(@$blog->meta_desc,0,150) !!}">
@endif
@if(@$blog->blog_pic)
<meta property="og:image" content="{{ URL::to('storage/app/public/SmallBlogImage')}}/{{@$blog->blog_pic}}" alt="">
@else
<meta property="og:image" content="{{asset('public/frontend/images/blank_image.jpg')}}" alt="">
@endif
<title>Blog Details</title>
@endsection

@section('style')
@include('includes.style')
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class="pad-114 blog_ban">
		<div class="banner-inner">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="inner-headings">
							<h3>Blog</h3>
							<div class="shareBx">
								<span><i class="fa fa-share-square-o" aria-hidden="true"></i>Share:</span>
								<ul style="min-width: 160px">
									<div class="sharethis-inline-share-buttons"></div>
								</ul>		
							</div>
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
											<img src="{{ URL::to('storage/app/public/BigBlogImage')}}/{{@$blog->blog_pic}}">
										</div>
										<div class="videos-blog-text">
											<div class="videos-post">
												<strong><i><img src="{{ URL::to('public/frontend/images/posticon1.png')}}" alt=""></i>Posted by : <em>{{@$blog->author_name}}</em></strong>
												<span><i class="fa fa-calendar"></i>{{date('d.m.Y',strtotime(@$blog->created_at))}}</span>
											</div>
											<h5><a href="#url">{{@$blog->blog_title}}</a></h5>
											<p>{!!@$blog->blog_desc!!} </p>
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

@if(@$allblog->isNotEmpty())
<section class="blogSec blogSec_fll blog_bot">
	<div class="container">
		<div class="blogIner">
			<div class="blogleft">
				<h1>Recent Post</h1>
				<div class="blogleft-inr">
					<div class="row">						
						@if(@$related->isNotEmpty())
						@foreach(@$related as $blog)
						<div class="col-md-4">
					    <div class="videos-blog-item">
					     <a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
						<div class="videos-blog-img">
							<img src="{{ URL::to('storage/app/public/SmallBlogImage')}}/{{@$blog->blog_pic}}">
						</div>
					   </a>
						<div class="videos-blog-text">
							<div class="videos-post">
								<strong><i><img src="{{ URL::to('public/frontend/images/posticon1.png')}}" alt=""></i>Posted by : <em>{{@$blog->author_name}}</em></strong>
								<span><i class="fa fa-calendar"></i>{{date('d.m.Y',strtotime(@$blog->created_at))}}</span>
							</div>
							<h5><a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
								@if(strlen(@$blog->blog_title) >50)
								{!! substr(@$blog->blog_title, 0, 50 )!!}...
								@else
								{!!@$blog->blog_title!!}
								@endif
							</a></h5>
							<p>

								@if(strlen(@$blog->blog_desc) >200)
								{!!strip_tags(substr(@$blog->blog_desc, 0, 200 ))!!}...
								@else
								{!!@$blog->blog_desc!!}

								@endif
							</p>
							<a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank" class="red_mor">Read more</a>
						</div>
					</div>
				</div>
				@endforeach
						@else
						@foreach(@$allblog as $blog)
						<div class="col-md-4">
					    <div class="videos-blog-item">
					     <a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
						<div class="videos-blog-img">
							<img src="{{ URL::to('storage/app/public/SmallBlogImage')}}/{{@$blog->blog_pic}}">
						</div>
					   </a>
						<div class="videos-blog-text">
							<div class="videos-post">
								<strong><i><img src="{{ URL::to('public/frontend/images/posticon1.png')}}" alt=""></i>Posted by : <em>{{@$blog->author_name}}</em></strong>
								<span><i class="fa fa-calendar"></i>{{date('d.m.Y',strtotime(@$blog->created_at))}}</span>
							</div>
							<h5><a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
								@if(strlen(@$blog->blog_title) >50)
								{!! substr(@$blog->blog_title, 0, 50 )!!}...
								@else
								{!!@$blog->blog_title!!}
								@endif
							</a></h5>
							<p>

								@if(strlen(@$blog->blog_desc) >200)
								{!!strip_tags(substr(@$blog->blog_desc, 0, 200 ))!!}...
								@else
								{!!@$blog->blog_desc!!}

								@endif
							</p>
							<a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank" class="red_mor">Read more</a>
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
</script>
@endsection
