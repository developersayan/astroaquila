@extends('layouts.app')

@section('title')
<title>Horoscope</title>
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
  <section class="search-list pad-114">
    <div class="container">
      <div class="row">
        

      <div class="col-lg-12 product-list">
        <div class="product-list-view">
        <section class="rm_astro_01">
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
                                 <a class="nav-link" data-toggle="tab" href="#menu1">Who, How & When </a>
                              </li>
                              {{-- <li class="nav-item">
                                 <a class="nav-link" data-toggle="tab" href="#menu2">Related Mantra</a>
                              </li> --}}
                              {{-- <li class="nav-item">
                                 <a class="nav-link " data-toggle="tab" href="#menu3">Usage  </a>
                              </li> --}}
                              @if(@$all_faq_cat->isNotEmpty())   
                              <li class="nav-item">
                                 <a class="nav-link" data-toggle="tab" href="#menu5">FAQ</a>
                              </li>
                              @endif
                              <li class="nav-item">
                                 <a class="nav-link" href="{{route('aquila.data.bank')}}" target="_blank">Aquila Data Bank </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                     </div>
                  </div>
                  <div class="container">
                     
                  </div>
               </div>
              
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
                                    @foreach(@$faq1->horoscopeFaqDetails as $faq)
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
</section>

                <section class="search-bred">
          <div class="container">
            <div class="row">
              <div class="col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                  <li class="breadcrumb-item active"><a href="{{route('search.pandit')}}">Horoscope</a></li>
                </ol>
              </div>
            </div>
          </div>
        </section>
          <div class="top-total">

            <form action="{{route('horoscope.separate.search',['id'=>@$id,'cat'=>@$cat])}}" method="POST" id="filter">
              @csrf
                  <h5>Showing {{$horoscopes->count()}} of {{@$totalhoroscope}} results for Horoscopes</h5>
                  <div class="sort-filter">
                    <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> {{__('search.sort_by')}}: </p>
                    <select class="sort-select basic-select" name="sort_by" id="sort_by">
                      <option value="" >{{__('search.select')}}</option>
                        <option value="1" @if(@$request['sort_by']=='1') selected @endif>High To Low</option>
                      <option value="2" @if(@$request['sort_by']=='2') selected @endif>Low To High</option>
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
                      </form>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <div class="all-products puja-prod">
                      <div class="row">
                        @if(@$horoscopes->count()>0)
                        @foreach ($horoscopes as $hscope)
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                            <div class="pandits-puja book_puja_item puja_card">
                                <div class="book_puja_img">
                <a href="{{route('horoscope.details',['slug'=>$hscope->slug])}}" target="_blank">
                @if(@$hscope->image)
                                    <img src="{{ URL::to('storage/app/public/horoscope_image')}}/{{$hscope->image}}">
                @else
                  <img src="{{ URL::to('public/frontend/images/videos2.jpg')}}">
                @endif
                                    <em>Price -
                                        @if(@session()->get('currency')==1)
                                        @if(@$hscope->discount_inr!=null && @$puja->discount_inr>0)
                                        @php
                                        $old_price = $hscope->price_inr;
                                        $discount_value = ($old_price / 100) * @$hscope->discount_inr;
                                        $new_price = $old_price - $discount_value;
                                        @endphp
                                        <b><del>₹ {{@$hscope->price_inr}} </del> &nbsp;   ₹ {{round(@$new_price,2)}}</b>
                                        @else
                                        <b>₹ {{@$hscope->price_inr}}</b>
                                        @endif
                                        @else

                                        @if(@$hscope->discount_usd!=null && @$hscope->discount_usd>0)
                                        @php
                                        $old_price = @$custom * $hscope->price_usd;
                                        $discount_value = ($old_price / 100) * @$hscope->discount_usd;
                                        $new_price = $old_price - $discount_value;
                                        @endphp
                                        <b><del>{{@session()->get('currencySym')}} {{round($custom * @$hscope->price_usd,2)}} </del> &nbsp;{{@session()->get('currencySym')}} {{round(@$new_price,2)}}</b>
                                        @else
                                        <b>{{@session()->get('currencySym')}} {{round(@$custom * @$hscope->price_usd,2)}}</b>
                                        @endif
                                        @endif
                                    </em>
                  </a>
                                </div>
                                <div class="book_puja_text">
                                    <h6><a href="{{route('horoscope.details',['slug'=>$hscope->slug])}}" target="_blank">@if(strlen(@$hscope->name) > 20)
                                        {!! substr(@$hscope->name, 0, 20 ) . '...' !!} @if(@$hscope->code!="") / {{@$hscope->code}} @endif
                                        @else
                                        {!! @$hscope->name !!}  @if(@$hscope->code!="") / {{@$hscope->code}} @endif
                                        @endif</a></h6>
                                    <p>
                                        @if(strlen(@$hscope->about_report) > 35)
                                        {!! substr(@$hscope->about_report, 0, 35 ) . '...' !!}
                                        @else
                                        {!! @$hscope->about_report !!}
                                        @endif
                                    </p>
                                    <span style="height: auto; border: 0px; text-align:right">
                                        <a href="{{route('horoscope.details',['slug'=>$hscope->slug])}}" class="pag_btn" target="_blank"> Order Now</a>
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
                  {{@$horoscopes->links()}}
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
        $('.sub').click(function(){
            $('#filter').submit();
        });
        $('#sort_by').change(function(){
            $('#filter').submit();
        });
        $('#show_result').change(function(){
            $('#filter').submit();
        });
        $('#expertise_filter').change(function(){
            $('#filter').submit();
        });
    $('.planet').click(function(){
            $('#filter').submit();
        });
        $('.rashi').click(function(){
            $('#filter').submit();
        });
        $('.nakshatra').click(function(){
            $('#filter').submit();
        });
        $('#rashi_filter').change(function(){
            $('#filter').submit();
        });
         $('#planets_filter').change(function(){
            $('#filter').submit();
        });
         $('#category_filter').change(function(){
            $('#filter').submit();
        });
    $('#subcat_filter').change(function(){
            $('#filter').submit();
        });
         $('#nakshatra_filter').change(function(){
            $('#filter').submit();
        });
         $('#deity_filter').change(function(){
            $('#filter').submit();
        });
         $('#purpose_filter').change(function(){
            $('#filter').submit();
        });
         $('#puja_name_search_filter').change(function(){
            $('#filter').submit();
        });
         $('#avail_filter').change(function(){
            $('#filter').submit();
        });
         $('#subcategory_filter').change(function(){
            $('#filter').submit();
        });
         $('#title_filter').change(function(){
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
        @if(@session()->get('currency')==1)
        var currencyIcon ='₹ ';
        @else
        var currencyIcon ='{{session()->get('currencySym')}} ';
        @endif
        // alert(value2);
        if(value1==''){
            value1=0;
        }
        if(value2==''){
            value2 = '@if(@session()->get('currency')==1){{@$max_price?@$max_price:1000}} @else{{@$max_price?@$custom *@$max_price+1:1000}} @endif';
        }
        console.log(value2);
        console.log(value1);
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: '@if(@session()->get('currency')==1){{@$max_price?@$max_price:1000}} @else{{@$max_price?@$custom *@$max_price+1:1000}}     @endif',
            values: [value1, value2],
            slide: function(event, ui) {
                $("#amount").val(currencyIcon + ui.values[0] + " -" +currencyIcon + ui.values[1]);
                $("#amount1").val(ui.values[0]);
                $("#amount2").val(ui.values[1]);
            },change: function(event, ui) {
                 $('#filter').submit();
            }
        });
        $("#amount").val(currencyIcon + $("#slider-range").slider("values", 0) + " - "+currencyIcon + $("#slider-range").slider("values", 1));
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
