@extends('layouts.app')

@section('title')
<title>Puja</title>
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
<?php
 $custom = (new \App\Helpers\CustomHelper)->currencyConversion();
?>
<section class="pad-114">
		<div class="details-banners">
               <div class="banner-inners details-inner">
                  <div class="container">
                     <div class="details-inner-rows">
					 <div class="row row-content">
                        <div class="col-lg-9 col-md-12">
                           <div class="details-captions page_banner_data">
                              <p style="white-space:pre-wrap;">{!!@$content->description!!}</p>
                           </div>
                        </div>
                     </div>
					  <div class="row" style="align-self: flex-end;">
                        <div class="col-12">
                           <ul class="nav nav-tabs" role="tablist">
                              <li class="nav-item">
                                 <a class="nav-link show active" data-toggle="tab" href="#home">Significance and Benifits</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" data-toggle="tab" href="#menu1">Who,How & When </a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" data-toggle="tab" href="#menu2">Related Mantra</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link " data-toggle="tab" href="#menu3">Usage  </a>
                              </li>
                              @if(@$all_faq_cat->isNotEmpty())   
                              <li class="nav-item">
                                 <a class="nav-link" data-toggle="tab" href="#menu5">FAQ</a>
                              </li>
                              @endif
                           </ul>
                        </div>
                     </div>
					 </div>
                  </div>
                  <div class="container">
                    
                  </div>
               </div>
               <div class="container">
                  <div class="row">
                     <div class="col-12">
                        <div class="tab-content">
                           <div id="home" class="container tab-pane show active">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Significance and Benifits </h2>
                                 <p style="white-space:pre-wrap;">{!!@$content->significance!!}</p>
                              </div>
                           </div>
                           <div id="menu1" class="container tab-pane fade">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Who,How & When</h2>
                                 <p style="white-space:pre-wrap;">{!!@$content->who_when!!}</p>
                              </div>
                           </div>
                           <div id="menu2" class="container tab-pane fade">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Related Mantra </h2>
                                 <p style="white-space:pre-wrap;">{!!@$content->related_mantra!!}</p>
                             </div>
                           </div>
                           <div id="menu3" class="container tab-pane fade">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Usage</h2>
                                 <p style="white-space:pre-wrap;">{!!@$content->usages!!}</p>
                                 
                              </div>
                           </div>
                           
                           @if(@$all_faq_cat->isNotEmpty())
                           <div id="menu5" class="container tab-pane fade">
							@foreach(@$all_faq_cat as $faq1)
							<span class="faq-cat-details">{{@$faq1->parent->faq_category}} > {{@$faq1->faq_category}}</span>
                              <div class="accordian-faq">
                                 <div class="accordion" id="faqcat{{@$faq1->id}}">
                                    @php $count= 1@endphp
                                    @foreach(@$faq1->pujaFaqDetails as $faq)
                                    <div class="card">
                                       <div class="card-header" id="faqhead{{@$faq->id}}">
                                          <a href="#" class="btn btn-header-link acco-chap collapsed" data-toggle="collapse" data-target="#faq{{@$faq->id}}" aria-expanded="true" aria-controls="faq{{@$faq->id}}">
                                             <p class="word_wrapper"><span>Q{{@$count++}}. </span>{{@$faq->question}}</p>
                                          </a>
                                       </div>
                                       <div id="faq{{@$faq->id}}" class="collapse" aria-labelledby="faqhead{{@$faq->id}}" data-parent="#faqcat{{@$faq1->id}}">
                                          <div class="card-body horoscope_faq_answer">
                                             <p style="white-space:pre-wrap;">{!!@$faq->answer!!}</p>
                                          </div>
                                       </div>
                                    </div>
                                    @endforeach
                                    
                                 </div>
                              </div>
							  @endforeach
                           </div>
						   @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>
	</section>
<section class="search-bred">
    <div class="container">
        <div class="row">
            
        </div>
    </div>
</section>
<section class="search-list">
    <div class="container">
        <div class="row">
            <form action="@if(@$puja_id) {{route('puja.search.puja-search',['slug'=>@$cat_slug,'id'=>@$puja_id])}} @else {{route('puja.search.puja-search',['slug'=>@$cat_slug])}} @endif" method="POST" id="filter" style="width: 100%">
              @csrf
			  <input type="hidden" name="page" value="" id="page">
            <div class="col-lg-12 product-list">
                <div class="product-list-view">
                    <div class="top-total">
                        <h5>Showing {{$pujas->count()}} of {{@$allPuja}} results for Pujas</h5>
                        <div class="sort-filter">
                            <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> Sort by : </p>
                            <select class="sort-select basic-select" name="sort_by" id="sort_by">
                                <option value="">Select</option>
                                <option value="1" @if(@$request['sort_by']=='1') selected @endif>Price High To Low</option>
                                <option value="2" @if(@$request['sort_by']=='2') selected @endif>Price Low To High</option>
                            </select>
                            <div class="clearfix"></div>
                        </div>

                        <div class="sort-filter">
                            <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> Show Result : </p>
                            <select class="sort-select basic-select" name="show_result" id="show_result">
                                <option value="">Select</option>
                                <option value="12" @if(@$request['show_result']=='12') selected @endif>12</option>
                                <option value="24" @if(@$request['show_result']=='24') selected @endif>24</option>
                                <option value="48" @if(@$request['show_result']=='48') selected @endif>48</option>
                                <option value="96" @if(@$request['show_result']=='96') selected @endif>96</option>
                            </select>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
                    <div class="clearfix"></div>
                    <div class="all-products puja-prod">
                      <div class="row">
                        @if(@$pujas->count()>0)
                        @foreach ($pujas as $puja)
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="pandits-puja book_puja_item puja_card">
                                <div class="book_puja_img">
								<a href="{{route('search.puja.details',['slug'=>@$puja->slug])}}" target="_blank">
                                    <img src="{{ URL::to('storage/app/public/puja_image')}}/{{$puja->puja_image}}">
                                    <em>Price -
                                        @if(@session()->get('currency')==1)
                                        @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                        @php
                                        $old_price = $puja->price_inr;
                                        $discount_value = ($old_price / 100) * @$puja->discount_inr;
                                        $new_price = $old_price - $discount_value;
                                        @endphp
                                        <b><del>₹ {{@$puja->price_inr}} </del> &nbsp;   ₹ {{round(@$new_price,2)}}</b>
                                        @else
                                        <b>₹ {{@$puja->price_inr}}</b>
                                        @endif
                                        @else

                                        @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                        @php
                                        $old_price = @$custom * $puja->price_usd;
                                        $discount_value = ($old_price / 100) * @$puja->discount_usd;
                                        $new_price = $old_price - $discount_value;
                                        @endphp
                                        <b><del>{{@session()->get('currencySym')}} {{round($custom * @$puja->price_usd,2)}} </del> &nbsp;{{@session()->get('currencySym')}} {{round(@$new_price,2)}}</b>
                                        @else
                                        <b>{{@session()->get('currencySym')}} {{round(@$custom * @$puja->price_usd,2)}}</b>
                                        @endif
                                        @endif
                                    </em>
									</a>
                                </div>
                                <div class="book_puja_text">
                                    <h6><a href="{{route('search.puja.details',['slug'=>@$puja->slug])}}" target="_blank">@if(strlen(@$puja->puja_name) > 20)
                                        {!! substr(@$puja->puja_name, 0, 20 ) . '...' !!} @if(@$puja->puja_code!="") / {{@$puja->puja_code}} @endif
                                        @else
                                        {!! @$puja->puja_name !!}  @if(@$puja->puja_code!="") / {{@$puja->puja_code}} @endif
                                        @endif</a></h6>
                                    <p>
                                        @if(strlen(strip_tags(@$puja->puja_description)) > 35)
                                        {{ substr(strip_tags(@$puja->puja_description), 0, 35 ) . '...' }}
                                        @else
                                        {{ strip_tags(@$puja->puja_description) }}
                                        @endif
                                    </p>
                                    <span style="height: auto; border: 0px; text-align:right">
                                        <a href="{{route('search.puja.details',['slug'=>@$puja->slug])}}" class="pag_btn" target="_blank"> View More</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <center > No Puja Found</center>
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
          <ul class="pagination justify-content-end rtg">
            {{@$pujas->links()}}
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
<script>
    $(document).ready(function(){
		$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });
		$(".rtg li a").click(function(){
      
      
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
	$(".mobile-list").click(function() {
		$(".search-filter").slideToggle();
	});
	$(".mobile_filter").click(function() {
		$(".left-rashis").slideToggle();
	});
        $('#sort_by').change(function(){
            $('#filter').submit();
        });
        $('#show_result').change(function(){
            $('#filter').submit();
        });
    });
</script>
@endsection
