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
<form action="{{route('gemstone.search.filter')}}" method="POST" id="filter">
<section class="search-list pad-114">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 bor-r">
                <div class="mobile-list">
                    <p><i class="fa fa-filter"></i> Show Filter</p>
                </div>
                <div class="search-filter">
                    
                        @csrf
                        <input type="hidden" name="page" value="" id="page" class="search-key">
                    {{-- <h3 class="hed-fil">Filters <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3> --}}
                    <div class="panel-group fliter-list" id="accordion" role="tablist" aria-multiselectable="true">


                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingnew">
                                <h3 class="panel-title"><a {{-- @if(@$request['keyword']==null) --}}class="collapsed" {{-- @endif --}} data-toggle="collapse"  href="#collapsenew" aria-expanded="false" aria-controls="collapsenew">Search Gemstone</a></h3> </div>
                            <div id="collapsenew" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingnew">
                                <div class="diiferent-sec search-key">
                                    <input type="text" placeholder="Type Keyword" value="{{@$request['keyword']}}" name="keyword">
                                    <button><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
            
            <div style="width:100%;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;" class="search_reset"><h3 class="hed-fil">Filters <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3>
             <span style="float:right;"><a href="{{route('gemstone.search')}}">Reset All</a></span></div>
                         

                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="diiferent-sec @if(@$request['gemstoneCategory']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="gemstoneCategory" id="cat">
                                        <option value="">Select Category</option>
                                        @foreach (@$gemstoneCategories as $key=>$category)
                                        <option value="{{$category->id}}" {{ @$request['gemstoneCategory']==$category->id?'selected':'' }}>{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
            @if(@$title->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="diiferent-sec @if(@$request['title']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="title" id="title_filter">
                                        <option value="">Select Title</option>
                                        @foreach (@$title as $key=>$value)
                                        <option value="{{$value->id}}" {{ @$request['title']==$value->id?'selected':'' }}>{{$value->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
            @endif

                        {{-- planets --}}
            @if(@$planets->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec">
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Planets" name="planets[]" id="planets_filter">
                                        @foreach($planets as $planet )
                                        <option value="{{ $planet->id }}" {{ @in_array($planet->id, @$request['planets'])?'selected':''}}>{{@$planet->planet_name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
                        {{--  <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading3">
                                <h3 class="panel-title"><a data-toggle="collapse" href="#collapse_planet" aria-expanded="true" aria-controls="collapse_planet">Planets</a></h3> </div>
                            <div id="collapse_planet" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading3">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        @foreach (@$planets as $key=>$planet)
                                        @if($key<2)
                                        <li>
                                            <label class="list_checkBox">{{$planet->planet_name}}
                                                <input type="checkbox" class="planet" name="planets[]" value="{{$planet->id}}" {{ @in_array($planet->id, @$request['planets'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                        </li>
                                        @else
                                        <div class="moretext-planet" style="display: none;">
                                           <li>
                                                <label class="list_checkBox">{{$planet->planet_name}}
                                                    <input type="checkbox" class="planet" name="planets[]" value="{{$planet->id}}" {{ @in_array($planet->id, @$request['planets'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                            </li>
                                        @endif
                                        @endforeach
                                        </div>
                                    </ul>
                                    @if(count(@$planets)>3)
                                    <a class="see-all moreless-button-planet">View More +</a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}



                        {{-- rashi --}}
            @if(@$rashis->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                               <div class="diiferent-sec">
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Rashi" name="rashi[]" id="rashi_filter">
                                        @foreach($rashis as $rashi )
                                        <option value="{{ $rashi->id }}" {{ @in_array($rashi->id, @$request['rashi'])?'selected':''}}>{{@$rashi->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
            @if(@$nakshatras->isNotEmpty())
                         <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                {{-- <div class="diiferent-sec">
                                    <select class="login-type log-select basic-select" name="nakshatra" class="nakshatra"  id="nakshatra_filter">
                                        <option value="">Select Nakshatra</option>
                                        @foreach (@$nakshatras as $key=>$nakshatra)
                                        <option value="{{$nakshatra->id}}" {{ @$request['nakshatra']==$nakshatra->id?'selected':'' }}>{{$nakshatra->name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="diiferent-sec planets_filter" >
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Nakshatra" name="nakshatra[]" id="nakshatra_filter">
                                        @foreach($nakshatras as $nakshatra )
                                        <option value="{{ $nakshatra->id }}" {{ @in_array($nakshatra->id, @$request['nakshatra'])?'selected':''}}>{{@$nakshatra->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
            @if(@$deity->isNotEmpty())
                    <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                {{-- <div class="diiferent-sec">
                                    <select class="login-type log-select basic-select" name="deity" class="deity"  id="deity_filter">
                                        <option value="">Select Deity</option>
                                        @foreach (@$deity as $key=>$value)
                                        <option value="{{$value->id}}" {{ @$request['deity']==$value->id?'selected':'' }}>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="diiferent-sec planets_filter" >
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Deity" name="deity[]" id="deity_filter">
                                        @foreach($deity as $value )
                                        <option value="{{ $value->id }}" {{ @in_array($value->id, @$request['deity'])?'selected':''}}>{{@$value->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
            @if(@$color->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                {{-- <div class="diiferent-sec">
                                    <select class="login-type log-select basic-select" name="color" class="colors"  id="color_filter">
                                        <option value="">Select Color</option>
                                        @foreach (@$color as $key=>$value)
                                        <option value="{{$value->id}}" {{ @$request['color']==$value->id?'selected':'' }}>{{$value->color}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="diiferent-sec">
                                    <select class="chosen-select  form-control" multiple data-placeholder="Select Color" name="color[]" id="color_filter">
                                        @foreach($color as $value )
                                        <option value="{{ $value->id }}" {{ @in_array($value->id, @$request['color'])?'selected':''}}>{{@$value->color}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
            @if(@$shape->isNotEmpty())
                      <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['shape']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="shape" class="shape"  id="shape_filter">
                                        <option value="">Select Shapes</option>
                                        @foreach (@$shape as $key=>$value)
                                        <option value="{{$value->id}}" {{ @$request['shape']==$value->id?'selected':'' }}>{{$value->shapes}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
            @if(@$cut->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['cut']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="cut" class="cut"  id="cut_filter">
                                        <option value="">Select Cuts</option>
                                        @foreach (@$cut as $key=>$value)
                                        <option value="{{$value->id}}" {{ @$request['cut']==$value->id?'selected':'' }}>{{$value->cuts}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif


                           {{--  <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading4">
                                <h3 class="panel-title"><a data-toggle="collapse" href="#collapseNew3" aria-expanded="true" aria-controls="collapseNew3">Rashis</a></h3> </div>
                            <div id="collapseNew3" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading4">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        @foreach (@$rashis as $key=>$rashi)
                                        @if($key<3)
                                        <li>
                                            <label class="list_checkBox">{{$rashi->name}}
                                                <input type="checkbox" class="rashi" name="rashi[]" value="{{$rashi->id}}" {{ @in_array($rashi->id, @$request['rashi'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                        </li>
                                        @endif
                                        @endforeach
                                        <div class="moretext_rashi"  style="display: none;">
                                             @foreach (@$rashis as $key=>$rashi)
                                            @if($key>2)
                                            <li>
                                                <label class="list_checkBox">{{$rashi->name}}
                                                    <input type="checkbox" class="rashi" name="rashi[]" value="{{$rashi->id}}" {{ @in_array($rashi->id, @$request['rashi'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                            </li>
                                            @endif
                                         @endforeach
                                        </div>
                                    </ul>
                                    @if(count(@$rashis)>3)
                                    <a class="see-all moreless-button_3">View More +</a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}


                        {{-- stone type --}}
            @if(@$stone_types->isNotEmpty())
                         <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="heading4">
                                <h3 class="panel-title"><a data-toggle="collapse" href="#collapse_stone_types" aria-expanded="true" aria-controls="collapse_stone_types">Stone Types</a></h3> </div> --}}
                            <div id="collapse_stone_types" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading4">
                                <div class="diiferent-sec @if(@$request['stone_type']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="stone_type" id="stone_type">
                                        <!--<option value="">Select Stone Type</option>
                    <option value="P" @if(@$request['stone_type']=='P') selected @endif>Precious</option>
                    <option value="SP" @if(@$request['stone_type']=='SP') selected @endif>Semi Precious</option>
                    <option value="UR" @if(@$request['stone_type']=='UR') selected @endif>Up Rattan</option>
                    <option value="G" @if(@$request['stone_type']=='G') selected @endif>General</option>-->
                    <option value="">Select Stone Type</option>
                                        @foreach (@$stone_types as $key=>$value)
                                        <option value="{{$value->slug}}" {{ @$request['stone_type']==$value->slug?'selected':'' }}>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
            @endif


                        {{-- treatment --}}
            @if(@$treatments->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['treatment']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="treatment" class="treatment"  id="treatment_filter">
                                        <option value="">Select Treatment</option>
                                        @foreach (@$treatments as $key=>$value)
                                        <option value="{{$value->slug}}" {{ @$request['treatment']==$value->slug?'selected':'' }}>{{$value->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
                        {{-- <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading5">
                                <h3 class="panel-title"><a @if(@$request['treatment']) @else class="collapsed" @endif data-toggle="collapse" href="#collapse_treatment" aria-expanded="@if(@$request['treatment']) true @else false @endif" aria-controls="collapse_treatment" >Treatment</a></h3> </div>
                            <div id="collapse_treatment" class="panel-collapse collapse @if(@$request['treatment']) show @endif" role="tabpanel" aria-labelledby="heading5">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        @foreach (@$treatments as $key=>$treatment)
                                        @if($key<3)
                                        <li>
                                            <label class="list_checkBox">{{@$treatment->name}}
                                                <input type="checkbox" class="treatment" name="treatment[]" value="{{@$treatment->slug}}" @if(@in_array(@$treatment->slug, @$request['treatment'])) checked @endif> <span class="list_checkmark"></span> </label>
                                            
                                        </li>
                    @endif
                                        @endforeach
                                        <div class="moretext-treatment" style="display: none;">
                                            @foreach (@$treatments as $key=>$treatment)
                                            @if($key>2)
                                            <li>
                        <label class="list_checkBox">{{@$treatment->name}}
                          <input type="checkbox" class="treatment" name="treatment[]" value="{{@$treatment->slug}}" @if(@in_array(@$treatment->slug, @$request['treatment'])) checked @endif> <span class="list_checkmark"></span> </label>
                      </li>
                                            @endif
                                            @endforeach
                                        </div>
                                    </ul>
                                    @if(count(@$treatments)>3)
                                    <a class="see-all moreless-button-treatment">View More +</a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}


                        {{-- seller_name --}}
            @if(@$seller->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['seller']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="seller" class="seller"  id="seller_filter">
                                        <option value="">Select Seller</option>
                                        @foreach (@$seller as $key=>$value)
                                        <option value="{{$value->id}}" {{ @$request['seller']==$value->id?'selected':'' }}>{{$value->seller_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
                        <div class="panel panel-default">
                            
                                <div class="diiferent-sec @if(@$request['avail']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="avail" class="avail"  id="avail_filter">
                                        <option value="">Select Availabilty</option>
                    @if(in_array('Y',$prod_availability))
                                        <option value="Y" @if(@$request["avail"]=="Y") selected @endif>Available</option>
                    @endif
                    @if(in_array('N',$prod_availability))
                                        <option value="N" @if(@$request["avail"]=="N") selected @endif>Out Of Stock</option>
                    @endif
                                    </select>
                                </div>
                           
                        </div>


                        {{-- end-seller-name --}}

                        

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h3 class="panel-title"><a @if(@$request['discount'] == null) class="collapsed"  @endif  data-toggle="collapse"  href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Discounts</a></h3> </div>
                            <div id="collapseThree" class="panel-collapse collapse @if(@$request['discount'] != null)) show  @endif" role="tabpanel" aria-labelledby="headingThree">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        <li>
                                            <label class="list_checkBox">Upto 20%
                                                <input type="checkbox" class="sub" name="discount[]" value="20" @if(@$request['discount'] && in_array(20, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        <li>
                                            <label class="list_checkBox">Upto 35%
                                                <input type="checkbox" class="sub" name="discount[]" value="35" @if(@$request['discount'] && in_array(35, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        <li>
                                            <label class="list_checkBox">Upto 50%

                                                <input type="checkbox" class="sub" name="discount[]" value="50" @if(@$request['discount'] && in_array(50, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                </div>
                            </div>
                        </div>

                        <div class="panel-heading" role="tab" id="headingsix">
                                    <h3 class="panel-title"><a @if(@$request['amount']) @else class="collapsed" @endif data-toggle="collapse" href="#collapsesix" aria-expanded="@if(@$request['amount']) true @else false @endif"
                                            aria-controls="collapsesix">Price Per Carat</a></h3>
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
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            
            
            <div class="col-lg-9 product-list">
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
</section>
<section class="search-bred">
    
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('gemstone.search')}}">Gemstone</a></li>
                </ol>
           
</section>
                
                
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
                      {{@$product->title->title}}@if(@$product->subtitle)/{{@$product->subtitle->title}} @endif/{{@$product->product_code}}
                    @else
                      {{@$product->product_name}}/{{@$product->product_code}}
                    @endif
                                        </a>
                                        </h5>
                                        @if(strlen(strip_tags(@$product->description)) > 35)
                                        <p>{{ substr(strip_tags(@$product->description), 0, 35 ) . '...' }}</p>
                                        @else
                                        <p>
                                            {{ strip_tags(@$product->description) }}
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
</form>

<section class="pagination-sec">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 offset-lg-3">
        <nav aria-label="Page navigation example" class="list-pagination">
          <ul class="pagination justify-content-end">
            {{@$products->links()}}
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
