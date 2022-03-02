@extends('layouts.app')

@section('title')
<title>Product</title>
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
            <div class="col-lg-3 bor-r">
                <div class="mobile-list">
                    <p><i class="fa fa-filter"></i> Show Filter</p>
                </div>
                <div class="search-filter">
                    <form action="{{route('product.search.filter')}}" method="POST" id="filter">
                        @csrf
                        <input type="hidden" name="page" value="" id="page" class="search-key">
                    {{-- <h3 class="hed-fil">Filters <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3> --}}
                    <div class="panel-group fliter-list" id="accordion" role="tablist" aria-multiselectable="true">


                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingnew">
                                <h3 class="panel-title"><a {{-- @if(@$request['keyword']==null) --}}class="collapsed" {{-- @endif --}} data-toggle="collapse"  href="#collapsenew" aria-expanded="false" aria-controls="collapsenew">Search Product</a></h3> </div>
                            <div id="collapsenew" class="panel-collapse collapse {{-- @if(@$request['keyword']) --}} show {{-- @endif --}}" role="tabpanel" aria-labelledby="headingnew">
                                <div class="diiferent-sec search-key">
                                    <input type="text" placeholder="Type Keyword" value="{{@$request['keyword']}}" name="keyword">
                                    <button><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div style="width:100%;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;" class="search_reset"><h3 class="hed-fil">Filters <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3>
             <span style="float:right;"><a href="{{route('product.search')}}">Reset All</a></span></div>

                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne">
                                <div class="diiferent-sec @if(@$request['productCategory']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="productCategory" id="cat">
                                        <option value="">Select Category</option>
                                        @foreach (@$productCategorys as $key=>$category)
                                        <option value="{{$category->id}}" {{ @$request['productCategory']==$category->id?'selected':'' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    {{-- <ul class="category-ul">

                                        @foreach (@$productCategorys as $key=>$category)
                                        @if($key<2)
                                        <li>
                                            <label class="list_checkBox">{{$category->name}}
                                                <input type="radio" class="cat"  name="productCategory[]" value="{{$category->id}}" {{ @in_array($category->id, @$request['productCategory'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                        </li>
                                        @endif
                                        @endforeach
                                        <div class="moretext" style="display: none;">
                                            @foreach (@$productCategorys as $key=>$category)
                                            @if($key>=2)
                                            <li>
                                                <label class="list_checkBox">{{$category->name}}
                                                    <input type="radio" class="cat" name="productCategory[]" value="{{$category->id}}" {{ @in_array($category->id, @$request['productCategory'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                            </li>
                                            @endif
                                            @endforeach
                                        </div>
                                    </ul>
                                    @if(count(@$productCategorys)>2)
                                    <a class="see-all moreless-button">View More +</a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>



                        {{-- subcategory --}}
                        @if(@$subcategories)
                         @if(@$subcategories->isNotEmpty())
                         <div class="diiferent-sec @if(@$request['subcat']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="subcat" id="subcat_filter">
                                        <option value="">Select Sub Category</option>
                                        @foreach (@$subcategories as $key=>$category)
                                        <option value="{{$category->id}}" {{ @$request['subcat']==$category->id?'selected':'' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>





                         {{-- <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headinsub">
                                <h3 class="panel-title"><a data-toggle="collapse" href="#collapse_two" aria-expanded="true" aria-controls="collapse_two">Sub Category</a></h3> </div>
                            <div id="collapse_two" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headinsub">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        @foreach (@$subcategories as $key=>$category)
                                        @if($key<2)
                                        <li>
                                            <label class="list_checkBox">{{$category->name}}
                                                <input type="checkbox" class="cat"  name="subcat[]" value="{{$category->id}}" {{ @in_array($category->id, @$request['subcat']) && $request['productCategory']?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                        </li>
                                        @endif
                                        @endforeach
                                        <div class="moretext-subcategory" style="display: none;">
                                            @foreach (@$subcategories as $key=>$category)
                                            @if($key>=2)
                                            <li>
                                                <label class="list_checkBox">{{$category->name}}
                                                    <input type="checkbox" class="cat" name="subcat[]" value="{{$category->id}}" {{ @in_array($category->id, @$request['subcat']) && $request['productCategory']?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                            </li>
                                            @endif
                                            @endforeach
                                        </div>
                                    </ul>
                                    @if(count(@$subcategories)>2)
                                    <a class="see-all moreless-subcategory">View More +</a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}
                        @endif
                        @endif



                        {{-- planets --}}
            @if(@$planets->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                {{-- <div class="diiferent-sec">
                                    <select class="login-type log-selec basic-select" name="planets" class="planets"  id="planets_filter">
                                        <option value="">Select Planets</option>
                                        @foreach (@$planets as $key=>$planet)
                                        <option value="{{$planet->id}}" {{ @$request['planets']==$planet->id?'selected':'' }}>{{$planet->planet_name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="diiferent-sec planets_filter" >
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Planets" name="planets[]" id="planets_filter" class="planets_filter">
                                        @foreach($planets as $planet )
                                        <option value="{{ $planet->id }}" {{ @in_array($planet->id, @$request['planets'])?'selected':''}}>{{@$planet->planet_name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
                         {{-- <div class="panel panel-default">
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
                                {{-- <div class="diiferent-sec">
                                    <select class="login-type log-select basic-select" name="rashi" class="rashis"  id="rashi_filter">
                                        <option value="">Select Rashi</option>
                                        @foreach (@$rashis as $key=>$rashi)
                                        <option value="{{$rashi->id}}" {{ @$request['rashi']==$rashi->id?'selected':'' }}>{{$rashi->name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="diiferent-sec  rashi_select" >
                                    <select class="chosen-select form-control  " multiple data-placeholder="Select Rashi" name="rashi[]" id="rashi_filter">
                                        @foreach($rashis as $rashi )
                                        <option value="{{ $rashi->id }}" {{ @in_array($rashi->id, @$request['rashi'])?'selected':''}}>{{@$rashi->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif
                            {{-- <div class="panel panel-default">
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


                        {{-- nakshatras --}}
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


                        {{-- seller --}}
            @if(@$seller->isNotEmpty())
                        <div class="panel panel-default">
                                <div class="diiferent-sec @if(@$request['seller']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="seller" class="seller"  id="seller_filter">
                                        <option value="">Select Seller</option>
                                        @foreach (@$seller as $key=>$value)
                                        <option value="{{$value->id}}" {{ @$request['seller']==$value->id?'selected':'' }}>{{$value->seller_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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


                        {{-- end-seller --}}



                         {{-- <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading4">
                                <h3 class="panel-title"><a data-toggle="collapse" href="#collapse_nakshatras" aria-expanded="true" aria-controls="collapse_nakshatras">Nakshatras</a></h3> </div>
                            <div id="collapse_nakshatras" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="heading4">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        @foreach (@$nakshatras as $key=>$nakshatra)
                                        @if($key<2)
                                        <li>
                                            <label class="list_checkBox">{{$nakshatra->name}}
                                                <input type="checkbox" class="nakshatra" name="nakshatra[]" value="{{$nakshatra->id}}" {{ @in_array($nakshatra->id, @$request['nakshatra'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                        </li>
                                        @endif
                                        @endforeach
                                        <div class="moretext-nakshatra" style="display: none;">
                                            @foreach (@$nakshatras as $key=>$nakshatra)
                                            @if($key>=2)
                                            <li>
                                                <label class="list_checkBox">{{$nakshatra->name}}
                                                    <input type="checkbox" class="nakshatra" name="nakshatra[]" value="{{$nakshatra->id}}" {{ @in_array($nakshatra->id, @$request['nakshatra'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                            </li>
                                            @endif
                                            @endforeach
                                        </div>
                                    </ul>
                                    @if($key>=2)
                                    <a class="see-all moreless-button-nakshatra">View More +</a>
                                    @endif
                                </div>
                            </div>
                        </div> --}}


                        {{-- purpose --}}
            @if(@$purposes->isNotEmpty())
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading5">
                                <h3 class="panel-title"><a @if(@$request['purpose']) @else class="collapsed" @endif data-toggle="collapse" href="#collapse_purpose" aria-expanded="@if(@$request['purpose']) true @else false @endif" aria-controls="collapse_purpose" >Purposes</a></h3> </div>
                            <div id="collapse_purpose" class="panel-collapse collapse @if(@$request['purpose']) show @endif" role="tabpanel" aria-labelledby="heading5">

                                <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['purpose']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" style="width: 100%" name="purpose" class="purpose"  id="purpose_filter">
                                        <option value="">Select Purpose</option>
                                        @foreach (@$purposes as $key=>$purpose)
                                        <option value="{{$purpose->id}}" {{ @$request['purpose']==$purpose->id?'selected':'' }}>{{$purpose->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
                                {{-- <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        @foreach (@$purposes as $key=>$purpose)
                                        @if($key<2)
                                        <li>
                                            <label class="list_checkBox">{{$purpose->name}}
                                                <input type="checkbox" class="purpose" name="purpose[]" value="{{$purpose->id}}" {{ @in_array($purpose->id, @$request['purpose'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                        </li>
                                        @endif
                                        @endforeach
                                        <div class="moretext-purpose" style="display: none;">
                                            @foreach (@$purposes as $key=>$purpose)
                                            @if($key>=2)
                                            <li>
                                                <label class="list_checkBox">{{$purpose->name}}
                                                    <input type="checkbox" class="purpose" name="purpose[]" value="{{$purpose->id}}" {{ @in_array($purpose->id, @$request['purpose'])?'checked':'' }}> <span class="list_checkmark"></span> </label>
                                            </li>
                                            @endif
                                            @endforeach
                                        </div>
                                    </ul>
                                    @if(count(@$purposes)>2)
                                    <a class="see-all moreless-button-purpose">View More +</a>
                                    @endif
                                </div> --}}
                            </div>
                        </div>
            @endif









                        

{{--                         <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h3 class="panel-title"><a  @if(@$request['price'] == null)) class="collapsed"  @endif data-toggle="collapse"  href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Price Range </a></h3> </div>
                            <div id="collapseTwo" class="panel-collapse collapse @if(@$request['price'] != null)) show @endif" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                                        <li>
                                            <label class="list_checkBox">Price doesn't matter
                                                <input type="checkbox" class="sub" name="price[]"  value="0" @if(@$request['price'] && in_array(0, @$request['price'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        <li>
                                            <label class="list_checkBox">Upto Rs. 1500
                                                <input type="checkbox" class="sub" name="price[]" value="1500" @if(@$request['price'] && in_array(1500, @$request['price']) && !in_array(0, @$request['price'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        <li>
                                            <label class="list_checkBox">Upto Rs. 5000
                                                <input type="checkbox" class="sub" name="price[]" value="5000" @if(@$request['price'] && in_array(5000, @$request['price']) && !in_array(0, @$request['price'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        <li>
                                            <label class="list_checkBox">Upto Rs. 8000
                                                <input type="checkbox" class="sub" name="price[]" value="8000" @if(@$request['price'] && in_array(8000, @$request['price']) && !in_array(0, @$request['price'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        <div class="moretext1"  @if(@$request['price'] && (in_array(12000, @$request['price']) ||!in_array(10000, @$request['price']) )&& !in_array(0, @$request['price'])) style="display: block; " @endif>
                                            <li>
                                                <label class="list_checkBox">Upto Rs. 10000
                                                    <input type="checkbox" class="sub" name="price[]" value="10000" @if(@$request['price'] && in_array(10000, @$request['price']) && !in_array(0, @$request['price'])) checked @endif> <span class="list_checkmark"></span> </label>
                                            </li>
                                            <li>
                                                <label class="list_checkBox">Upto Rs. 12000
                                                    <input type="checkbox" class="sub" name="price[]" value="12000" @if(@$request['price'] && in_array(12000, @$request['price']) && !in_array(0, @$request['price'])) checked @endif> <span class="list_checkmark"></span> </label>
                                            </li>
                                        </div>
                                    </ul> <a class="see-all moreless-button1">
                                        @if(@$request['price'] && (in_array(12000, @$request['price']) ||!in_array(10000, @$request['price'])) && !in_array(0, @$request['price']))
                                        View Less -
                                        @else
                                        View More +
                                        @endif

                                    </a>
                                </div>
                            </div>
                        </div> --}}

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
                                        {{-- <li>
                                            <label class="list_checkBox">Upto 25%
                                                <input type="checkbox" class="sub" name="discount[]" value="25" @if(@$request['discount'] && in_array(25, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        <li>
                                            <label class="list_checkBox">Upto 30%
                                                <input type="checkbox" class="sub" name="discount[]" value="30" @if(@$request['discount'] && in_array(30, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li> --}}
                                        <li>
                                            <label class="list_checkBox">Upto 35%
                                                <input type="checkbox" class="sub" name="discount[]" value="35" @if(@$request['discount'] && in_array(35, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        {{-- <li>
                                            <label class="list_checkBox">Upto 45%

                                                <input type="checkbox" class="sub" name="discount[]" value="45" @if(@$request['discount'] && in_array(45, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li> --}}
                                        <li>
                                            <label class="list_checkBox">Upto 50%

                                                <input type="checkbox" class="sub" name="discount[]" value="50" @if(@$request['discount'] && in_array(50, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                                        {{-- <div class="moretext2" @if(@$request['discount'] && in_array(50, @$request['discount'])) style="display: block; " @endif>
                                            <li>
                                                <label class="list_checkBox">Upto 50%

                                                    <input type="checkbox" class="sub" name="discount[]" value="50" @if(@$request['discount'] && in_array(50, @$request['discount'])) checked @endif> <span class="list_checkmark"></span> </label>
                                            </li>

                                        </div> --}}
                                    {{-- </ul> <a class="see-all moreless-button2">
                                        @if(@$request['discount'] && in_array(50, @$request['discount']))
                                        View Less -
                                        @else
                                        View More +
                                        @endif

                                    </a> --}}
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h3 class="panel-title"><a class="collapsed" data-toggle="collapse"  href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">Type</a></h3> </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="diiferent-sec">
                                    <ul class="category-ul">
                  @if(in_array('N',$prod_shippable))
                                        <li>
                                            <label class="list_checkBox">Downloadable
                                                <input type="checkbox" name="shippable[]" value="N" class="type" @if(@$request['shippable'] && in_array('N', @$request['shippable'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                    @endif
                    @if(in_array('Y',$prod_shippable))
                                        <li>
                                            <label class="list_checkBox">Physical
                                                <input type="checkbox" name="shippable[]" value="Y" class="type" @if(@$request['shippable'] && in_array('Y', @$request['shippable'])) checked @endif> <span class="list_checkmark"></span> </label>
                                        </li>
                    @endif

                                    </ul>
                                </div>
                            </div>
                        </div>


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

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-lg-9 product-list">
            
            <section class="">
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
                                    @foreach(@$faq1->astroFaqDetails as $faq)
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
            <div class="col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('product.search')}}">Products</a></li>
                </ol>
            </div>
        </div>
    </div>
</section>
            
                <div class="product-list-view">
                    <div class="top-total">
                        <h5>Showing {{$products->count()}} of {{@$totalProduct}} results for Products</h5>
                        <div class="sort-filter">
                            <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> Sort by : </p>
                            <select class="sort-select basic-select" name="sort_by" id="sort_by">
                                <option value="">Select</option>
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
                  <a href="{{route('product.search.details',['slug'=>@$product->slug])}}" target="_blank">
                                        @if(@$product->productdefault->image)
                                        <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$product->productdefault->image}}"alt="">
                                        @else
                                        <img src="{{ URL::to('public/frontend/images/ston1.png')}}" alt="">
                                        @endif
										</a>
                                    </span>
                                    <div class="gem-stone-text">
                                        <h5><a href="{{route('product.search.details',['slug'=>@$product->slug])}}" target="_blank">
                                            @if(strlen(@$product->product_name) > 45)
                                            {!! substr(@$product->product_name, 0, 45 ) . '..' !!} / {{@$product->product_code}}
                                            @else
                                            {!!@$product->product_name!!} / {{@$product->product_code}}
                                            @endif
                                            {{-- {{@$product->product_name}} --}}

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
                                                 $old_price = $product->price_inr;
                                                  $discount_value = ($old_price / 100) * @$product->discount_inr;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{@$product->price_inr}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{@$product->price_inr}}
                                                @endif

                                                @else

                                                @if(@$product->discount_usd!=null && @$product->discount_usd>0)
                                                @php
                                                 $old_price = @$custom * $product->price_usd;
                                                  $discount_value = ($old_price / 100) * @$product->discount_usd;
                                                  $new_price = $old_price - $discount_value;
                                                @endphp
                                                <del>{{@session()->get('currencySym')}} {{round(@$product->price_usd*currencyConversionCustom(),2)}} </del>

                                                {{@session()->get('currencySym')}} {{round(@$new_price,2)}}
                                                @else
                                                {{@session()->get('currencySym')}} {{round(@$product->price_usd*currencyConversionCustom(),2)}}
                                                @endif

                                               @endif
                                                {{-- @if(@session()->get('currency')==1)
                                                @if(@$product->discount_inr!=null && @$product->discount_inr>0)
                                                @php
                                                $discount_value = 100 - @$product->discount_inr;
                                                @endphp
                                                <del>₹ {{round(@$product->price_inr * 100/$discount_value)}} </del>
                                                @endif
                                                ₹ {{round(@$product->price_inr)}}
                                                @elseif(@session()->get('currency')==2)
                                                @if(@$product->discount_usd!=null && @$product->discount_usd>0)
                                                @php
                                                  $discount_value = 100 - @$product->discount_usd;
                                                @endphp
                                                <del>$ {{round(@$product->price_usd * 100/$discount_value)}} </del>
                                                @endif
                                                $ {{round(@$product->price_usd)}}
                                                @endif --}}

                                            </li>

                                            <li>
                                                @if(@$product->availability=="Y")
                                                <a href="javascript:;" class="pag_btn buynow" data-product="{{@$product->id}}">Buy Now</a>
                                                @else
                                                <a href="javascript:;" class="pag_btn">Out Of Stock</a>
                                                @endif
                                            </li>

                                            {{-- <li><a href="javascript:;" class="pag_btn buynow" data-product="{{@$product->id}}">Buy Now</a></li> --}}
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
$('.moreless-button-purpose').click(function() {
  $('.moretext-purpose').slideToggle();
  if ($('.moreless-button-purpose').text() == "View More +") {
    $(this).text("View Less -")
  } else {
    $(this).text("View More +")
  }
});
   </script>

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
        $('.type').change(function(){
            $('#filter').submit();
        });
        // $('.planet').click(function(){
        //     $('#filter').submit();
        // });
        $('#planets_filter').change(function(){
            $('#filter').submit();
        });
        // $('.rashi').click(function(){
        //     $('#filter').submit();
        // });
        $('#rashi_filter').change(function(){
            $('#filter').submit();
        });
        $('.nakshatra').click(function(){
            $('#filter').submit();
        });
         $('.purpose').click(function(){
            $('#filter').submit();
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
        $('#subcat_filter').change(function(){
            $('#filter').submit();
        });
        $('#nakshatra_filter').change(function(){
            $('#filter').submit();
        });
        $('#purpose_filter').change(function(){
            $('#filter').submit();
        });
        $('#deity_filter').change(function(){
            $('#filter').submit();
        });
        $('#seller_filter').change(function(){
            $('#filter').submit();
        });
        $('#avail_filter').change(function(){
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
            max: '@if(@session()->get('currency')==1){{@$max_price?@$max_price:1000}} @else{{@$max_price?@$custom *@$max_price+1:1000}}     @endif',
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
