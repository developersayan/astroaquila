@extends('layouts.app')

@section('title')
<title>Blogs</title>
@endsection

@section('style')
@include('includes.style')
<style type="text/css">

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
							<h3>Blog</h3>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@if(@$blogs->isNotEmpty())
<section class="blogSec blogSec_fll">
	<div class="container">
		<div class="blogIner">
			<div class="blogleft">
				<div class="blogleft-inr">
					<div class="row">						
					  @foreach(@$blogs as $blog)
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
							<a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" class="red_mor" target="_blank">Read more</a>
						</div>
					</div>
				</div>
						@endforeach		
					</div>
				</div>
			</div>
			<div class="blogright">
				<div class="blogright-inr">
					<h1>Recent Post</h1>
					<div class="resentpostbx">
						<div class="row">
							@foreach(@$recents as $blog)
							<div class="col-sm-4">
								<div class="media">
									<em><a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank"><img src="{{ URL::to('storage/app/public/SmallBlogImage')}}/{{@$blog->blog_pic}}" alt=""></a></em>
									<div class="media-body">
										<p><a href="{{route('blog.show.details.frontend',['slug'=>@$blog->slug])}}" target="_blank">
											@if(strlen(@$blog->blog_title) >50)
											{!! substr(@$blog->blog_title, 0, 50 )!!}...
											@else
											{!!@$blog->blog_title!!}
											@endif
										</a></p>
										<strong><i class="fa fa-clock-o"></i>{{date('F j, Y',strtotime(@$blog->created_at))}}</strong>
									</div>
								</div>								
							</div>
							@endforeach
						</div>
						
					</div>
					<div class="blogflowus">
                        <h4>Follow us</h4>
                        <ul>
							<li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						</ul>
                    </div>
                    <div class="pagination_bx">
				{{-- <ul>
					{{@$blogs->links('pagination')}}
				</ul> --}}
			</div>
				</div>
			</div>
			
		</div>
	</div>
</section>
@endif
<section class="pagination-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
        <nav aria-label="Page navigation example" class="list-pagination">
          <ul class="pagination justify-content-end">
            {{@$blogs->links()}}
            {{-- <li class="page-item disabled">
              <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true"> <i class="icofont-long-arrow-left"></i>Prev </a>
            </li>
            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a> </li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item page-item-dots"><a class="page-link" href="#">6</a></li>
            <li class="page-item"> <a class="page-link page-link-next" href="#" aria-label="Next">
                      Next<i class="icofont-long-arrow-right"></i></i>
                    </a> </li> --}}
          </ul>
        </nav>
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
