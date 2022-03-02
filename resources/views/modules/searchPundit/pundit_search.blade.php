@extends('layouts.app')

@section('title')
<title>{{__('search.pundit_search_title')}}</title>
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
<section class="pad-114">
		<div class="banner-inner">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="inner-headings">
							<h3>{{__('search.book_your_puja_heading')}}</h3>
							<p>{{__('search.browse_filter_puja_content')}}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="search-bred">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('home')}}">{{__('search.home')}}</a></li>
						<li class="breadcrumb-item active"><a href="{{route('search.pandit')}}">{{__('search.book_your_puja_link')}}</a></li>
					</ol>
				</div>
			</div>
		</div>
	</section>
	<section class="search-list">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 bor-r">
					<div class="mobile-list">
						<p><i class="fa fa-filter"></i> {{__('search.show_filter')}}</p>
					</div>
					<div class="search-filter">
                        <form action="{{route('search.pandit')}}" method="POST" id="filter">
                            @csrf
                            <input type="hidden" name="page" value="" id="page">
                            <h3 class="hed-fil">{{__('search.filters')}} <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3>
                            <div class="panel-group fliter-list" id="accordion" role="tablist" aria-multiselectable="true">
                                {{-- <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h3 class="panel-title"><a data-toggle="collapse" href="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">{{__('search.puja_name')}}</a></h3>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse @if(@$request['puja']) show @endif" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="diiferent-sec">
                                            <ul class="category-ul">
                                                @foreach (@$allPuja as $key=>$puja)
                                                @if($key<2)
                                                <li>
                                                    <label class="list_checkBox">{{$puja->puja_name}}
                                                        <input type="checkbox" name="puja[]" value="{{$puja->id}}" class="sub" {{ @in_array($puja->id, @$request['puja'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @else
                                                <li class="view_more_checkBox" style="display: none">
                                                    <label class="list_checkBox">{{$puja->puja_name}}
                                                        <input type="checkbox" name="puja[]" value="{{$puja->id}}" class="sub" {{ @in_array($puja->id, @$request['puja'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                            <a class="see-all" href="javascript:;" id="view_mode">{{__('search.view_more')}} +</a>
                                            <a class="see-all" href="javascript:;" id="view_less" style="display: none">{{__('search.view_less')}} -</a>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingSix">
                                        <h3 class="panel-title"><a class="collapsed" data-toggle="collapse" href="#collapseSix"
                                                aria-expanded="false" aria-controls="collapseSix">Puja Category</a></h3>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                        <div class="diiferent-sec">
                                            <ul class="category-ul">
                                                @foreach (@$allCategory as $key=>$category)
                                                @if($key<2)
                                                <li>
                                                    <label class="list_checkBox">{{$category->name}}
                                                        <input type="checkbox" name="category[]" value="{{$category->id}}" class="sub" {{ @in_array($category->id, @$request['category'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @else
                                                <li class="view_more_checkBox_category" style="display: none">
                                                    <label class="list_checkBox">{{$category->name}}
                                                        <input type="checkbox" name="category[]" value="{{$category->id}}" class="sub" {{ @in_array($category->id, @$request['category'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @endif
                                                @endforeach
                                                {{-- <li>
                                                    <label class="list_checkBox">GOD
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li>
                                                <li>
                                                    <label class="list_checkBox">GODESS
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li> --}}

                                            </ul>
                                            <a class="see-all" href="javascript:;" id="view_mode_category">{{__('search.view_more')}} +</a>
                                            <a class="see-all" href="javascript:;" id="view_less_category" style="display: none">{{__('search.view_less')}} -</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingnew">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse"  href="#collapsenew" aria-expanded="false" aria-controls="collapsenew">{{__('search.puja_name')}}</a>
                                        </h3>
                                    </div>
                                    <div id="collapsenew" class="panel-collapse collapse  show" role="tabpanel" aria-labelledby="headingnew">
                                        <div class="diiferent-sec search-key">
                                            <input type="text" placeholder="{{__('search.puja_name')}}" value="{{@$request['puja_name']}}" name="puja_name">
                                            <button><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h3 class="panel-title"><a class="collapsed" data-toggle="collapse" href="#collapseFour"
                                                aria-expanded="false" aria-controls="collapseFour">Diety</a></h3>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                        <div class="diiferent-sec">
                                            <ul class="category-ul">
                                                @foreach (@$allDeity as $key=>$deity)
                                                @if($key<2)
                                                <li>
                                                    <label class="list_checkBox">{{$deity->name}}
                                                        <input type="checkbox" name="deity[]" value="{{$deity->id}}" class="sub" {{ @in_array($deity->id, @$request['deity'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @else
                                                <li class="view_more_checkBox_deity" style="display: none">
                                                    <label class="list_checkBox">{{$deity->name}}
                                                        <input type="checkbox" name="deity[]" value="{{$deity->id}}" class="sub" {{ @in_array($deity->id, @$request['deity'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @endif
                                                @endforeach
                                                {{-- <li>
                                                    <label class="list_checkBox">GOD
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li>
                                                <li>
                                                    <label class="list_checkBox">GODESS
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li> --}}

                                            </ul>
                                            <a class="see-all" href="javascript:;" id="view_mode_deity">{{__('search.view_more')}} +</a>
                                            <a class="see-all" href="javascript:;" id="view_less_deity" style="display: none">{{__('search.view_less')}} -</a>
                                        </div>
                                    </div>
                                </div>


                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h3 class="panel-title"><a class="collapsed" data-toggle="collapse" href="#collapseThree"
                                                aria-expanded="false" aria-controls="collapseThree">Purpose of Puja </a></h3>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                        <div class="diiferent-sec">
                                            <ul class="category-ul">
                                                @foreach (@$allPurpose as $key=>$purpose)
                                                @if($key<2)
                                                <li>
                                                    <label class="list_checkBox">{{$purpose->name}}
                                                        <input type="checkbox" name="purpose[]" value="{{$purpose->id}}" class="sub" {{ @in_array($purpose->id, @$request['purpose'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @else
                                                <li class="view_more_checkBox_purpose" style="display: none">
                                                    <label class="list_checkBox">{{$purpose->name}}
                                                        <input type="checkbox" name="purpose[]" value="{{$purpose->id}}" class="sub" {{ @in_array($purpose->id, @$request['purpose'])?'checked':'' }} > <span class="list_checkmark"></span>
                                                    </label>
                                                </li>
                                                @endif
                                                @endforeach
                                                {{-- <li>
                                                    <label class="list_checkBox">Vastu Puja
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li>
                                                <li>
                                                    <label class="list_checkBox">Birthday Puja
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li>
                                                <li>
                                                    <label class="list_checkBox">Mangalik Puja
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li>
                                                <li>
                                                    <label class="list_checkBox">Kundli Dosh Puja
                                                        <input type="checkbox" name="text"> <span class="list_checkmark"></span> </label>
                                                </li> --}}
                                            </ul>
                                            <a class="see-all" href="javascript:;" id="view_mode_purpose">{{__('search.view_more')}} +</a>
                                            <a class="see-all" href="javascript:;" id="view_less_purpose" style="display: none">{{__('search.view_less')}} -</a>
                                        </div>
                                    </div>
                                </div>


{{--                          <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="headingFive">
                                    <h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">Experience</a></h3> </div>
                                <div id="collapseFive" class="panel-collapse @if(@$request['experience']) @else collapse @endif" role="tabpanel" aria-labelledby="headingFive">
                                    <div class="diiferent-sec">
                                        <ul class="category-ul">

                                            <li>
                                                <label class="list_checkBox">Upto 10 years
                                                    <input type="checkbox" name="experience[]" value="1" onChange="this.form.submit()" @if(@$request['experience'] && in_array(1, @$request['experience'])) checked @endif> <span class="list_checkmark"></span> </label>
                                            </li>
                                            <li>
                                                <label class="list_checkBox">Upto 20 years
                                                    <input type="checkbox"  name="experience[]"  value="2" onChange="this.form.submit()" @if(@$request['experience'] && in_array(2, @$request['experience'])) checked @endif> <span class="list_checkmark"></span> </label>
                                            </li>


                                            <li>
                                                <label class="list_checkBox">20 years & Above
                                                    <input type="checkbox"  name="experience[]"  value="3" onChange="this.form.submit()" @if(@$request['experience'] && in_array(3, @$request['experience'])) checked @endif> <span class="list_checkmark"></span>
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}














                                <div class="panel-heading" role="tab" id="headingsix">
                                    <h3 class="panel-title"><a class="collapsed" data-toggle="collapse" href="#collapsesix" aria-expanded="false"
                                            aria-controls="collapsesix">{{__('price')}}</a></h3>
                                </div>
                                <div id="collapsesix" class="panel-collapse collapse @if(@$request['amount']) show @endif" role="tabpanel" aria-labelledby="headingsix">
                                    <div class="diiferent-sec">
                                        <div class="slider_rnge">
                                            <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                                <div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 100%;"></div>
                                                <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all" style="left: 0%;"></span>
                                                <span tabindex="0" class="ui-slider-handle ui-state-default ui-corner-all"
                                                    style="left: 100%;"></span>
                                            </div> <span class="range-text">
                                                <input type="text" class="price_numb" readonly id="amount" name="amount">
                                                <input type="hidden" class="price_numb" readonly id="amount1" name="amount1">
                                                <input type="hidden" class="price_numb" readonly id="amount2" name="amount2">
                                            </span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h3 class="panel-title"><a class="collapsed" data-toggle="collapse" href="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">{{__('search.type_of_puja')}} </a></h3>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse @if(@$request['puja_type']) show @endif" role="tabpanel" aria-labelledby="headingTwo">
                                        <div class="diiferent-sec">
                                            <ul class="category-ul">
                                                <li>
                                                    <label class="list_checkBox">{{__('search.online_puja')}} <input type="checkbox" name="puja_type[]" class="sub" value="ONLINE" {{ @in_array('ONLINE', @$request['puja_type'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                                </li>
                                                <li>
                                                    <label class="list_checkBox">{{__('search.offline_puja')}} <input type="checkbox" name="puja_type[]" class="sub" value="OFFLINE" {{ @in_array('OFFLINE', @$request['puja_type'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                                </li>
                                                {{-- <li>
                                                    <label class="list_checkBox">{{__('search.both_puja')}} <input type="checkbox" name="puja_type[]" class="sub" value="BOTH" {{ @in_array('BOTH', @$request['puja_type'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                                </li> --}}

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>


					</div>
				</div>

			<div class="col-lg-9 product-list">
				<div class="product-list-view">

	              <div class="top-total">
	                <h5>{{@$allPandit}} {{__('search.results_for')}} "{{__('search.browse_filter_puja_content')}}"</h5>
	                <div class="sort-filter">
	                  <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> {{__('search.sort_by')}}: </p>
	                  <select class="sort-select" name="sort_by" id="sort_by">
	                    <option value="" >{{__('search.select')}}</option>
	                    <option value="1" @if(@$request['sort_by']=='1') selected @endif>{{__('search.customer_rating')}}</option>
                        <option value="2" @if(@$request['sort_by']=='2') selected @endif>High To Low</option>
	                    <option value="3" @if(@$request['sort_by']=='3') selected @endif>Low To High</option>
	                  </select>
	                  <div class="clearfix"></div>
                      </form>
	                </div>
	                <div class="clearfix"></div>
	              </div>
	              <div class="clearfix"></div>
	              <div class="all-products">
                      <div class="row">
                          @if(@$pandits->count()>0)
                          @foreach ($pandits as $pandit)
                          <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
                              <div class="pandits-puja">
                                  <span>
                                      @if(@$pandit->profile_img)
                                      <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$pandit->profile_img}}"alt="">
                                      @else
                                      <img src="{{ URL::to('public/frontend/images/pan1.jpg')}}" alt="">
                                      @endif
                                    </span>
                                    <div class="pandit-text">
                                        <h4><a href="{{route('search.pandit.publicProfile',['slug'=>@$pandit->slug])}}">{{@$pandit->first_name}} {{@$pandit->last_name}}</a></h4>
                                        {{-- <p><img src="{{ URL::to('public/frontend/images/map.png')}}"> {{@$pandit->city}}, {{@$pandit->state}}, {{@$pandit->countries->country_name}}</p> --}}
                                        <p><img src="{{ URL::to('public/frontend/images/map.png')}}"> {{@$pandit->city? $pandit->city.',':''}}  {{@$pandit->states->name? @$pandit->states->name.',':''}}  {{@$pandit->countries->name?@$pandit->countries->name:''}} </p>

                                        <p><img src="{{ URL::to('public/frontend/images/puja.png')}}">
                                            @foreach (@$pandit->punditPujas as $key=>$panditPuja)
                                            @if($key+1 == $pandit->punditPujas->count())
                                            {{$panditPuja->pujas->puja_name}} - Rs {{(int)$panditPuja->price}}
                                            @else
                                            {{$panditPuja->pujas->puja_name}} - Rs {{(int)$panditPuja->price}},
                                            @endif
                                            @endforeach
                                        </p>

                                        {{-- <p><img src="{{ URL::to('public/frontend/images/puja.png')}}"> Kali Puja - Starting from 1147</p> --}}

                                    </div>
                                    <div class="pandit-moreinfo">
                                        <ul>
                                            <li class="wid-40">
                                                <p><img src="{{ URL::to('public/frontend/images/dollIconbag.png')}}"> {{@$pandit->experience}} {{__('search.years')}}</p>
                                            </li>
                                            <li class="wid-60">
                                                <p><img src="{{ URL::to('public/frontend/images/lan.png')}}"> Hindi , English</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <center > {{__('search.no_pandit_found')}} </center>
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
                  {{@$pandits->links()}}
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
        $('.sub').click(function(){
            $('#filter').submit();
        });
        $('#sort_by').change(function(){
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
    $(document).ready(function(){
        var value1 = '{{@$request['amount1']}}';
        var value2 = '{{@$request['amount2']}}';
        // alert(value2);
        if(value1==''){
            value1=0;
        }
        if(value2==''){
            value2 = 10000;
        }
        console.log(value2);
        console.log(value1);
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 15000,
            values: [value1, value2],
            slide: function(event, ui) {
                $("#amount").val("Rs " + ui.values[0] + " - Rs " + ui.values[1]);
                $("#amount1").val(ui.values[0]);
                $("#amount2").val(ui.values[1]);
            },change: function(event, ui) {
                 $('#filter').submit();
            }
        });
        $("#amount").val("Rs " + $("#slider-range").slider("values", 0) + " - Rs " + $("#slider-range").slider("values", 1));
        $("#amount1").val($("#slider-range").slider("values", 0));
        $("#amount2").val($("#slider-range").slider("values", 1));
      /* Menu Start */
      $('#sm').mouseover(function() {
        $(this).show();
      });
      $('#sm').mouseout(function() {
        $(this).hide();
      });
      $('#m1').mouseover(function() {
        $('.all_menu').show();
        $('#sm').show();
      });
      var column = 4
      var wWidth = $(window).width()
      if(wWidth >= 767 && wWidth <= 991) {
        column = 3
      } else if(wWidth >= 575 && wWidth < 767) {
        column = 2
      }
    //   $('#blog-landing').pinterest_grid({
    //     no_columns: column,
    //     padding_x: 0,
    //     padding_y: 0,
    //     margin_bottom: 0,
    //     single_column_breakpoint: 700
    //   });
      $('#m1, #m2 ').mouseleave(function() {
        $('#sm').hide();
        $('#sm1, #sm2').hide();
      });
      /* Menu Start */
      $('#paste-lan').click(function() {
        $('.open-lan').toggle();
        /*var lang = '';// $('.open-lan').children('li').children('a').data('id');
        //alert(lang);
        if(lang == 'english') {
          $('#paste-lan').html('<img src="images/english-flag1.png" alt="">')
          $('.open-lan').css('display', 'none');
        } else {
          if(lang == 'arabic') {
            $('#paste-lan').html('src="images/arabic-flag1.png"')
            $('.open-lan').css('display', 'none');
          } else {
            $('.open-lan').css('display', 'none');
          }
        }*/
      });
      $('.open-lan').find('a').click(function() {
        var lang = $(this).data("id");
        if(lang == 'english') {
          $('#paste-lan').html('<img src="images/english-flag1.png" alt="">');
        } else {
          $('#paste-lan').html('<img src="images/arabic-flag1.png" alt="">');
        }
        $('.open-lan').hide();
      });
});
    </script>
       <script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
@endsection
