@extends('layouts.app')

@section('title')
<title>Gemstones</title>
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
               <div class="banner-inners">
                  <div class="container">
                     <div class="row">
                        <div class="col-lg-9 col-md-12">
                           <div class="details-captions page_banner_data">
                              <p>{{@$content->description}}</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="container">
                     <div class="row">
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
                  <div class="row">
                     <div class="col-12">
                        <div class="tab-content">
                           <div id="home" class="container tab-pane show active">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Significance and Benifits </h2>
                                 <p>{{@$content->significance}}</p>
                              </div>
                           </div>
                           <div id="menu1" class="container tab-pane fade">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Who,How & When</h2>
                                 <p>{{@$content->who_when}}</p>
                              </div>
                           </div>
                           <div id="menu2" class="container tab-pane fade">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Related Mantra </h2>
                                 <p>{{@$content->related_mantra}}</p>
                             </div>
                           </div>
                           <div id="menu3" class="container tab-pane fade">
                              <div class="details-banner-tabs page_banner_data">
                                 <h2>Usage</h2>
                                 <p>{{@$content->usages}}</p>
                                 
                              </div>
                           </div>
                           
                                  @if(@$all_faq_cat->isNotEmpty())
                                                      <div id="menu5" class="container tab-pane fade">
                                        @foreach(@$all_faq_cat as $faq1)
                                        <span class="faq-cat-details">{{@$faq1->parent->faq_category}} > {{@$faq1->faq_category}}</span>
                                                         <div class="accordian-faq">
                                                            <div class="accordion" id="faqcat{{@$faq1->id}}">
                                                               @php $count= 1@endphp
                                                               @foreach(@$faq1->gemFaqDetails as $faq)
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
            {{-- <div class="col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('gemstone.search')}}">Gemstone</a></li>
                </ol>
            </div> --}}
        </div>
    </div>
</section>
<section class="search-list">
    <div class="container">
        <div class="row">
            <form action="{{route('gemstone.search.sub-title-search',['id'=>@$subtitle_id,'cat'=>@$category])}}" method="POST" id="filter" style="width: 100%">
              @csrf
             <input type="hidden" name="page" value="" id="page" class="search-key"> 
            <div class="col-lg-12 product-list">
                <div class="product-list-view">
                    <div class="top-total">
                        <h5>Showing {{$products->count()}} of {{@$totalProduct}} results for Products</h5>
                        <div class="sort-filter">
                            <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> Sort by : </p>
                            <select class="sort-select basic-select" name="sort_by" id="sort_by">
                                <option value="">Select</option>
                                <option value="1" @if(@$request['sort_by']=='1') selected @endif>Price High To Low</option>
                                <option value="2" @if(@$request['sort_by']=='2') selected @endif>Price Low To High</option>
                                <!--<option value="3" @if(@$request['sort_by']=='3') selected @endif>Weight High To Low</option>
                                <option value="4" @if(@$request['sort_by']=='4') selected @endif>Weight Low To High</option>-->
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
                    <div class="all-products search-cat-produ">
                        <div class="row">
                            @foreach (@$products as $product)
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 ">
                                <div class="gem-stone-item product_card back_white">
                                    <span>
									<a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" target="_blank">
                                        @if(@$product->productdefault->image)
                                        <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$product->productdefault->image}}"alt="">
                                        @else
                                        <img src="{{ URL::to('public/frontend/images/ston1.png')}}" alt="">
                                        @endif
										</a>
                                    </span>
                                    <div class="gem-stone-text">
                                        <h5><a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" target="_blank">
										@if(@$product->title)
											{{@$product->title->title}} @if(@$product->subtitle) /{{@$product->subtitle->title}} @endif /{{@$product->product_code}}
										@else
											{{@$product->product_name}}/{{@$product->product_code}}
										@endif
                                        </a>
                                        </h5>
                                        @if(strlen(strip_tags(@$product->description)) > 60)
                                        <p>{{ substr(strip_tags(@$product->description), 0, 60 ) . '...' }}</p>
                                        @else
                                        <p>
                                            {{ @$product->description }}
                                        </p>
                                        @endif
                                        <ul>
                                            <li>
                                                @if(@session()->get('currency')==1)

                                                @if(@$product->discount_inr!=null && @$product->discount_inr>0)
                                                @php
                                                 $old_price = $product->price_per_carat_inr;
                                                  $discount_value = ($old_price / 100) * @$product->discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{@$product->price_per_carat_inr}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{@$product->price_per_carat_inr}}
                                                @endif

                                                @else

                                                @if(@$product->discount_usd!=null && @$product->discount_usd>0)
                                                @php
                                                 $old_price = @$custom * $product->price_per_carat_usd;
                                                  $discount_value = ($old_price / 100) * @$product->discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{@$custom * @$product->price_per_carat_usd}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{@$custom * @$product->price_per_carat_usd}}
                                                @endif

                                                @endif
												<span class="gemstone_carat">@if(@$product->single_product=="N")per carat @endif</span>

                                            </li>

                                            <li>
                                                @if(@$product->availability=="Y")
                                                <a href="{{route('gemstone.details',['slug'=>@$product->slug])}}" class="pag_btn" target="_blank" data-product="{{@$product->id}}">Buy Now</a>
                                                @else
                                                <a href="javascript:;" class="pag_btn">Out Of Stock</a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
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
            {{@$products->links()}}
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
		$(".left-rashis").slideToggle();
	});
	</script>

    {{-- purpose --}}
        <script type="text/javascript">
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
$('.moreless-button-treatment').click(function() {
  $('.moretext-treatment').slideToggle();
  if ($('.moreless-button-treatment').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>

{{-- nakhatras --}}
    <script type="text/javascript">
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
$('.moreless-button-stone-types').click(function() {
  $('.moretext-stone-types').slideToggle();
  if ($('.moreless-button-stone-types').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>

	<script type="text/javascript">
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
$('.moreless-button').click(function() {
  $('.moretext').slideToggle();
  if ($('.moreless-button').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>

{{-- sub-category --}}
    <script type="text/javascript">
// The function toggles more (hidden) text when the user clicks on "Read more". The IF ELSE statement ensures that the text 'read more' and 'read less' changes interchangeably when clicked on.
$('.moreless-subcategory').click(function() {
  $('.moretext-subcategory').slideToggle();
  if ($('.moreless-subcategory').text() == "View More +") {
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

 <script type="text/javascript">

$('.moreless-button1').click(function() {
  $('.moretext1').slideToggle();
  if ($('.moreless-button1').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>
  <script type="text/javascript">

$('.moreless-button2').click(function() {
  $('.moretext2').slideToggle();
  if ($('.moreless-button2').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>

     <script type="text/javascript">

$('.moreless-button3').click(function() {
  $('.moretext3').slideToggle();
  if ($('.moreless-button3').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>




     <script type="text/javascript">

$('.moreless-button4').click(function() {
  $('.moretext4').slideToggle();
  if ($('.moreless-button4').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>
   <script>
	$(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
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
        // $('.cat').click(function(){
        //     $('#filter').submit();
        // });
        $('#cat').change(function(){
            $('#filter').submit();
        });
        $('.planet').click(function(){
            $('#filter').submit();
        });
        // $('.rashi').click(function(){
        //     $('#filter').submit();
        // });
        $('#rashi_filter').change(function(){
            $('#filter').submit();
        });
        $('#planets_filter').change(function(){
            $('#filter').submit();
        });
        $('#stone_type').change(function(){
            $('#filter').submit();
        });
         $('.treatment').click(function(){
            $('#filter').submit();
        });
        $('#sort_by').change(function(){
            $('#filter').submit();
        });
        $('#show_result').change(function(){
            $('#filter').submit();
        });
         $('#color_filter').change(function(){
            $('#filter').submit();
        });
         $('#shape_filter').change(function(){
            $('#filter').submit();
        });
         $('#cut_filter').change(function(){
            $('#filter').submit();
        });
         $('#treatment_filter').change(function(){
            $('#filter').submit();
        });
         $('#seller_filter').change(function(){
            $('#filter').submit();
        });
          $('#avail_filter').change(function(){
            $('#filter').submit();
        });
           $('#deity_filter').change(function(){
            $('#filter').submit();
        });
            $('#nakshatra_filter').change(function(){
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
<script src="{{ URL::to('public/frontend/js/jquery-ui.js')}}"></script>
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
            value2 = '@if(@session()->get('currency')==1){{@$max_price?@$max_price:1000}} @else{{@$max_price?@$custom  *@$max_price+1:1000}} @endif';
        }
        console.log(value2);
        console.log(value1);
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: '@if(@session()->get('currency')==1){{@$max_price?@$max_price:1000}} @else{{@$max_price?@$custom *@$max_price+1:1000}} @endif',
            values: [value1, value2],
            slide: function(event, ui) {
                $("#amount").val(currencyIcon + ui.values[0] + " - "+currencyIcon + ui.values[1]);
                $("#amount1").val(ui.values[0]);
                $("#amount2").val(ui.values[1]);
            },change: function(event, ui) {
                 $('#filter').submit();
            }
        });
        $("#amount").val(currencyIcon + $("#slider-range").slider("values", 0) + " - "+currencyIcon + $("#slider-range").slider("values", 1));
        $("#amount1").val($("#slider-range").slider("values", 0));
        $("#amount2").val($("#slider-range").slider("values", 1));
		
		/*Weight Range*/
		var value3 = '{{@$request['weight1']}}';
        var value4 = '{{@$request['weight2']}}';
        // alert(value2);
        if(value3==''){
            value3=0;
        }
        if(value4==''){
            value4 = '{{@$max_weight?@$max_weight:5}}';
        }
        console.log(value4);
        console.log(value3);
        $("#slider-range1").slider({
            range: true,
            min: 0,
            max: '{{@$max_weight?@$max_weight:5}}',
            values: [value3, value4],
            slide: function(event, ui) {
                $("#weight").val(ui.values[0] + " Carat - " + ui.values[1]+" Carat");
                $("#weight1").val(ui.values[0]);
                $("#weight2").val(ui.values[1]);
            },change: function(event, ui) {
                 $('#filter').submit();
            }
        });
        $("#weight").val($("#slider-range1").slider("values", 0) + " Carat - "+ $("#slider-range1").slider("values", 1)+" Carat");
        $("#weight1").val($("#slider-range1").slider("values", 0));
        $("#weight2").val($("#slider-range1").slider("values", 1));
		/*Weight Range*/
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
{{-- <script>
    var allRadios = document.getElementsByName('productCategory[]');
    var booRadio;
    var x = 0;
    for(x = 0; x < allRadios.length; x++){
        if(allRadios[x].checked == true){
            booRadio = allRadios[x];
        }
        allRadios[x].onclick = function(){
            console.log(this);
            if(booRadio == this){
                 this.checked = false;
                booRadio = null;
                // $('#filter').submit();
            }else{
                booRadio = this;
                // $('#filter').submit();
            }
        };
    }
</script> --}}
<script>
    $(document).ready(function(){
        $('.buynow').click(function(){
            var productId = $(this).data('product');
            var quantity = 1;
            console.log(productId)
            var reqData = {
                'jsonrpc': '2.0',
                '_token': '{{csrf_token()}}',
                'params': {
                    productId: productId,
                    quantity: quantity
                }
            };
            $.ajax({
                  url: '{{ route('product.add.to.cart') }}',
                  type: 'post',
                  dataType: 'json',
                  data: reqData,
              })
            .done(function(response) {
                console.log(response);
                console.log(response.result.cart.length)
                if (response.result.insert=="insert") {
                //   alert('Product added to cart successfully');
                }
                if (response.result.updated=="updated") {
                //   alert('Product quantity updated successfully');
                }

                $('#cartLi .noti').text(response.result.cart.length);
                $('#cartLi .shopcutBx').html();
                $('#cartLi .shopcutBx').html(response.result.html);
                window.location.href="{{route('product.shopping.cart')}}";
            })
            .fail(function(error) {
                console.log("error", error);
            })
            .always(function() {
                console.log("complete");
            })
        })
    })
    </script>

@endsection
