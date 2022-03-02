@extends('layouts.app')

@section('title')
<title>Aquila Wiki</title>
@endsection

@section('style')
@include('includes.style')
<!---------range slider------------>
<link rel="stylesheet" href="{{ URL::to('public/frontend/css/jquery-ui.css')}}">
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')

	<section class="search-list pad-114">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 bor-r">
					<div class="mobile-list">
						<p><i class="fa fa-filter"></i> {{__('search.show_filter')}}</p>
					</div>
					<div class="search-filter">
                        <form action="{{route('aquila.wiki')}}" method="POST" id="filter">
                            @csrf
                            <input type="hidden" name="page" value="" id="page">
                           
                            <div class="panel-group fliter-list" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingnew">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse"  href="#collapsenew" aria-expanded="false" aria-controls="collapsenew">Find</a>
                                        </h3>
                                    </div>
                                    <div id="collapsenew" class="panel-collapse collapse  show" role="tabpanel" aria-labelledby="headingnew">
                                        <div class="diiferent-sec search-key">
                                            <input type="text" placeholder="keyword" value="{{request('keyword')}}" name="keyword">
                                            <button><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>

                                 <div style="width:100%;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;" class="search_reset"><h3 class="hed-fil">Filters <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3>
						 <span style="float:right;"><a href="{{route('aquila.wiki')}}">Reset All</a></span></div>


                      
						
						@if(@$title->isNotEmpty())
						<div class="panel panel-default">
							<div class="diiferent-sec @if(request('title')) selected-single-value @endif">
								<select class="login-type log-select basic-select" name="title" class="title"  id="title">
									<option value="">Select Title</option>
									@foreach (@$title as $key=>$value)
									<option value="{{$value->id}}" {{request('title')==$value->id?'selected':'' }}>{{$value->title}}</option>
									@endforeach
								</select>
							</div>
               </div>	
						@endif

            @if(@$category->isNotEmpty())
            <div class="panel panel-default">
              <div class="diiferent-sec @if(request('category')) selected-single-value @endif">
                <select class="login-type log-select basic-select" name="category" class="category"  id="category">
                  <option value="">Select Category</option>
                  @foreach (@$category as $key=>$value)
                  <option value="{{$value->id}}" {{request('category')==$value->id?'selected':'' }}>{{$value->name}}</option>
                  @endforeach
                </select>
              </div>
               </div> 
            @endif

            @if( @$subcategory)
            @if(@$subcategory->isNotEmpty() )
            <div class="panel panel-default">
              <div class="diiferent-sec @if(request('subcategory')) selected-single-value @endif">
                <select class="login-type log-select basic-select" name="subcategory" class="subcategory"  id="subcategory">
                  <option value="">Select Sub Category</option>
                  @foreach (@$subcategory as $key=>$value)
                  <option value="{{$value->id}}" {{request('subcategory')==$value->id?'selected':'' }}>{{$value->name}}</option>
                  @endforeach
                </select>
              </div>
               </div> 
            @endif
            @endif
          </div>
        
      </div>
    </div>


			



     

           <div class="col-lg-9 product-list">
                <div class="product-list-view">




	              <section class="search-bred">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
									<li class="breadcrumb-item active"><a href="{{route('aquila.wiki')}}">Aquila Wiki</a></li>
								</ol>
							</div>
						</div>
					</div>
				</section>
				  <div class="top-total">
	                <h5>Showing {{$data->count()}} of {{@$totaldata}} results for Aquila Wiki</h5>
	                <div class="sort-filter">
	                  <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> {{__('search.sort_by')}}: </p>
	                  <select class="sort-select basic-select" name="sort_by" id="sort_by">
	                    <option value="" >{{__('search.select')}}</option>
                        <option value="1" @if(@request('sort_by')=='1') selected @endif>Sort By Alphabetically</option>
	                  </select>
	                  <div class="clearfix"></div>
                  </div>

                  <div class="sort-filter">
                            <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> Show Result : </p>
                            <select class="sort-select basic-select" name="show_result" id="show_result">
                                <option value="">Select</option>
                                <option value="12" @if(request('show_result')=='12') selected @endif>12</option>
                                <option value="24" @if(request('show_result')=='24') selected @endif>24</option>
                                <option value="48" @if(request('show_result')=='48') selected @endif>48</option>
                                <option value="96" @if(request('show_result')=='96') selected @endif>96</option>
                            </select>
                            <div class="clearfix"></div>
                        </div>
                      </form>
	                </div>
	                <div class="clearfix"></div>
	              </div>
	              <div class="clearfix"></div>
	              <div class="all-products puja-prod">
                      <div class="row">
                        @if(@$data->count()>0)
                        @foreach ($data as $value)
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="pandits-puja book_puja_item puja_card">
                                <div class="book_puja_img">
								<a href="{{route('aquila.wiki.details',['slug'=>@$value->slug])}}">
								@if(@$value->image)
                                    <img src="{{ URL::to('storage/app/public/wiki_image')}}/{{$value->image}}" style="height: 250px">
								@else
									<img src="{{ URL::to('public/frontend/images/videos2.jpg')}}">
								@endif
                </a>
                                   
								
                                </div>
                                <div class="book_puja_text">
                                    <a href="{{route('aquila.wiki.details',['slug'=>@$value->slug])}}"> <h6>{{@$value->getTitle->title}}/{{@$value->article_title}}</h6></a>
                                    <p>
                                      @if(strlen(@$value->description) > 35)
                                        {{strip_tags(substr(@$value->description, 0, 35 ) . '...' )}}
                                        @else
                                        {{strip_tags(@$value->description)}}
                                        @endif
                                    </p>
                                    <span style="height: auto; border: 0px; text-align:right">
                                        <a href="{{route('aquila.wiki.details',['slug'=>@$value->slug])}}" class="pag_btn" target="_blank">View More</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <center > No data Found</center>
                        @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>

	<section class="pagination-sec">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 offset-lg-3">
            <nav aria-label="Page navigation example" class="list-pagination">

              <ul class="pagination justify-content-end">
                  {{@$data->links()}}
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
@include('includes.toaster')
<script type="text/javascript">
    $(".mobile-list").click(function() {
		$(".search-filter").slideToggle();
	});
	$(".mobile_filter").click(function() {
		$(".left-profle").slideToggle();
	});
</script>
<!---------range slider------------>
<script src="{{ URL::to('public/frontend/js/jquery-ui.js')}}"></script>
{{-- nakhatras --}}
    <script type="text/javascript">
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
$('.moreless-button-nakshatra').click(function() {
  $('.moretext-nakshatra').slideToggle();
  if ($('.moreless-button-nakshatra').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>
{{-- rashi   --}}
    <script type="text/javascript">
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
$('.moreless-button_3').click(function() {
  $('.moretext_rashi').slideToggle();
  if ($('.moreless-button_3').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>

{{-- planets --}}
<script type="text/javascript">

$('.moreless-button-planet').click(function() {
  $('.moretext-planet').slideToggle();
  if ($('.moreless-button-planet').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>
<script>
    $(document).ready(function(){
        $("#view_mode").click(function(){
            $('.view_more_checkBox').css('display','block');
            $('#view_less').css('display','block');
            $('#view_mode').css('display','none');
        });
        $("#view_less").click(function(){
            $('.view_more_checkBox').css('display','none');
            $('#view_less').css('display','none');
            $('#view_mode').css('display','block');
        });
        $("#view_mode_purpose").click(function(){
            $('.view_more_checkBox_purpose').css('display','block');
            $('#view_less_purpose').css('display','block');
            $('#view_mode_purpose').css('display','none');
        });
        $("#view_less_purpose").click(function(){
            $('.view_more_checkBox_purpose').css('display','none');
            $('#view_less_purpose').css('display','none');
            $('#view_mode_purpose').css('display','block');
        });
        $("#view_mode_deity").click(function(){
            $('.view_more_checkBox_deity').css('display','block');
            $('#view_less_deity').css('display','block');
            $('#view_mode_deity').css('display','none');
        });
        $("#view_less_deity").click(function(){
            $('.view_more_checkBox_deity').css('display','none');
            $('#view_less_deity').css('display','none');
            $('#view_mode_deity').css('display','block');
        });
        $("#view_mode_category").click(function(){
            $('.view_more_checkBox_category').css('display','block');
            $('#view_less_category').css('display','block');
            $('#view_mode_category').css('display','none');
        });
        $("#view_less_category").click(function(){
            $('.view_more_checkBox_category').css('display','none');
            $('#view_less_category').css('display','none');
            $('#view_mode_category').css('display','block');
        });
       
         $('#title').change(function(){
            $('#filter').submit();
        });
         $('#category').change(function(){
            $('#filter').submit();
        });
         $('#subcategory').change(function(){
            $('#filter').submit();
        });
         $('#sort_by').change(function(){
            $('#filter').submit();
        });
         
         $('#show_result').change(function(){
            $('#filter').submit();
        });
         

        $(".list-pagination ul li a").click(function(){
            var url = $(this).attr('href');
            var vars = [], hash;
            var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            // console.log(hash[1]);
            $('#page').val(hash[1]);
            $("#filter").submit();
            return false;
        });
    });
</script>


<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
@endsection
