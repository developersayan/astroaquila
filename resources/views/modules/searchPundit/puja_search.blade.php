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
<?php
 $custom = (new \App\Helpers\CustomHelper)->currencyConversion();
?>

  <section class="search-list pad-114">
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
                           {{--  <h3 class="hed-fil">{{__('search.filters')}} <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3> --}}
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
                                {{-- <div class="panel panel-default">
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
                                                

                                            </ul>
                                            <a class="see-all" href="javascript:;" id="view_mode_category">{{__('search.view_more')}} +</a>
                                            <a class="see-all" href="javascript:;" id="view_less_category" style="display: none">{{__('search.view_less')}} -</a>
                                        </div>
                                    </div>
                                </div> --}}


                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingnew">
                                        <h3 class="panel-title">
                                            <a data-toggle="collapse"  href="#collapsenew" aria-expanded="false" aria-controls="collapsenew">Find Puja</a>
                                        </h3>
                                    </div>
                                    <div id="collapsenew" class="panel-collapse collapse  show" role="tabpanel" aria-labelledby="headingnew">
                                        <div class="diiferent-sec search-key">
                                            <input type="text" placeholder="Type Keyword" value="{{@$request['puja_name']}}" name="puja_name">
                                            <button><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>

                                 <div style="width:100%;display: flex;align-items: center;justify-content: space-between;flex-wrap: wrap;" class="search_reset"><h3 class="hed-fil">Filters <img src="{{ URL::to('public/frontend/images/arrow.png')}}"></h3>
             <span style="float:right;"><a href="{{route('search.pandit')}}">Reset All</a></span></div>


                                 <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['category']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="category" class="category"  id="category_filter">
                                        <option value="">Select Category</option>
                                        @foreach (@$allCategory as $key=>$category)
                                        <option value="{{$category->id}}" {{ @$request['category']==$category->id?'selected':'' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
                         @if(@$subcategory)
                         @if(@$subcategory->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['subcategory']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="subcategory" class="subcategory"  id="subcategory_filter">
                                        <option value="">Select Sub Category</option>
                                        @foreach (@$subcategory as $key=>$category)
                                        <option value="{{$category->id}}" {{ @$request['subcategory']==$category->id?'selected':'' }}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
                        @endif
                        @endif
            
            @if(@$allPuja_name->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['puja_name_search']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="puja_name_search" class="puja_name_search"  id="puja_name_search_filter">
                                        <option value="">Select Puja</option>
                                        @foreach (@$allPuja_name as $key=>$puja)
                                        <option value="{{$puja->id}}" {{ @$request['puja_name_search']==$puja->id?'selected':'' }}>{{$puja->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif

                                
                
                {{-- planets --}}
                @if(@$planets->isNotEmpty())
                                 <div class="panel panel-default">
                               <div class="diiferent-sec">
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Planets" name="planets[]" id="planets_filter">
                                        @foreach($planets as $planet )
                                        <option value="{{ $planet->id }}" {{ @in_array($planet->id, @$request['planets'])?'selected':''}}>{{@$planet->planet_name}}</option>
                                        @endforeach

                                    </select>
                                </div>
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

                                <div class="diiferent-sec">
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Nakshatra" name="nakshatra[]" id="nakshatra_filter">
                                        @foreach($nakshatras as $nakshatra )
                                        <option value="{{ $nakshatra->id }}" {{ @in_array($nakshatra->id, @$request['nakshatra'])?'selected':''}}>{{@$nakshatra->name}}</option>
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
                                        @if(in_array('Y',$puja_availability))
                                        <option value="Y" @if(@$request["avail"]=="Y") selected @endif>Available</option>
                  @endif
                  @if(in_array('N',$puja_availability))
                                        <option value="N" @if(@$request["avail"]=="N") selected @endif>Out Of Stock</option>
                  @endif
                                    </select>
                                </div>
                           
                        </div>




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
            
            
            
            @if(@$allDeity->isNotEmpty())
                        <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                {{-- <div class="diiferent-sec">
                                    <select class="login-type log-select basic-select" name="deity" class="deity"  id="deity_filter">
                                        <option value="">Select Deity</option>
                                        @foreach (@$allDeity as $key=>$deity)
                                        <option value="{{$deity->id}}" {{ @$request['deity']==$deity->id?'selected':'' }}>{{$deity->name}}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                 <div class="diiferent-sec">
                                    <select class="chosen-select form-control " multiple data-placeholder="Select Deity" name="deity[]" id="deity_filter">
                                        @foreach($allDeity as $deity )
                                        <option value="{{ $deity->id }}" {{ @in_array($deity->id, @$request['deity'])?'selected':''}}>{{@$deity->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif

                                {{-- <div class="panel panel-default">
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
                                                

                                            </ul>
                                            <a class="see-all" href="javascript:;" id="view_mode_deity">{{__('search.view_more')}} +</a>
                                            <a class="see-all" href="javascript:;" id="view_less_deity" style="display: none">{{__('search.view_less')}} -</a>
                                        </div>
                                    </div>
                                </div> --}}
                
                
                @if(@$allPurpose->isNotEmpty())
                                <div class="panel panel-default">
                            {{-- <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">Category</h3> </div> --}}
                            {{-- <div id="collapseOne" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="headingOne"> --}}
                                <div class="diiferent-sec @if(@$request['purpose']) selected-single-value @endif">
                                    <select class="login-type log-select basic-select" name="purpose" class="purpose"  id="purpose_filter">
                                        <option value="">Select Purpose</option>
                                        @foreach (@$allPurpose as $key=>$purpose)
                                        <option value="{{$purpose->id}}" {{ @$request['purpose']==$purpose->id?'selected':'' }}>{{$purpose->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            {{-- </div> --}}
                        </div>
            @endif

                                {{-- <div class="panel panel-default">
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
                                                
                                            </ul>
                                            <a class="see-all" href="javascript:;" id="view_mode_purpose">{{__('search.view_more')}} +</a>
                                            <a class="see-all" href="javascript:;" id="view_less_purpose" style="display: none">{{__('search.view_less')}} -</a>
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
                      @if(in_array('ONLINE',$puja_manners) || in_array('BOTH',$puja_manners))
                                                <li>
                                                    <label class="list_checkBox">{{__('search.online_puja')}} <input type="checkbox" name="puja_type[]" class="sub" value="ONLINE" @if(@in_array('ONLINE', @$request['puja_type'])) checked @endif> <span class="list_checkmark"></span> </label>
                                                </li>
                        @endif
                        @if(in_array('OFFLINE',$puja_manners) || in_array('BOTH',$puja_manners))
                                                <li>
                                                    <label class="list_checkBox">{{__('search.offline_puja')}} <input type="checkbox" name="puja_type[]" class="sub" value="OFFLINE" @if(@in_array('OFFLINE', @$request['puja_type'])) checked @endif> <span class="list_checkmark"></span> </label>
                                                </li>
                        @endif
                                            </ul>
                                        </div>
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
        <div class="col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('search.home')}}</a></li>
            <li class="breadcrumb-item active"><a href="{{route('search.pandit')}}">{{__('search.book_your_puja_link')}}</a></li>
          </ol>
        </div>
      </div>
    </div>
  </section>
            
        <div class="product-list-view">

                <div class="top-total">
                  <h5>{{@$pujas->count()}} {{__('search.results_for')}} "{{__('search.browse_filter_puja_content')}}"</h5>
                  <div class="sort-filter">
                    <p><img src="{{ URL::to('public/frontend/images/sort.png')}}" class="sort-img"> {{__('search.sort_by')}}: </p>
                    <select class="sort-select basic-select" name="sort_by" id="sort_by">
                      <option value="" >{{__('search.select')}}</option>
                      <option value="1" @if(@$request['sort_by']=='1') selected @endif>{{__('search.customer_rating')}}</option>
                        <option value="2" @if(@$request['sort_by']=='2') selected @endif>High To Low</option>
                      <option value="3" @if(@$request['sort_by']=='3') selected @endif>Low To High</option>
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
                                       {{--  @if(@session()->get('currency')==1)
                                        @if(@$puja->discount_inr!=null && @$puja->discount_inr>0)
                                        @php
                                        $discount_value = 100- @$puja->discount_inr;
                                        @endphp
                                        <b><del>₹ {{round(@$puja->price_inr*100/$discount_value)}} </del> &nbsp;   ₹ {{round(@$puja->price_inr)}}</b>
                                        @else
                                        <b>₹ {{round(@$puja->price_inr)}}</b>
                                        @endif
                                        @elseif(@session()->get('currency')==2)

                                        @if(@$puja->discount_usd!=null && @$puja->discount_usd>0)
                                        @php
                                        $discount_value = 100-@$puja->discount_usd;
                                        @endphp
                                        <b><del>$ {{round(@$puja->price_usd*100/$discount_value)}} </del> &nbsp;  $ {{round(@$puja->price_usd)}}</b>
                                        @else
                                        <b>$ {{round(@$puja->price_usd)}}</b>
                                        @endif

                                        @endif --}}


                                       







                                        {{-- @if(@session()->get('currency')==1)
                                        <b> ₹ {{(int)$puja->price_inr}}</b>
                                        @elseif(@session()->get('currency')==2)
                                        <b> $ {{(int)$puja->price_usd}}</b>
                                        @endif --}}
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

                          {{-- @if(@$pujas->count()>0)
                          @foreach ($pujas as $puja)
                          <div class="col-lg-4 col-md-4 col-sm-6 col-6 ">
                              <div class="pandits-puja">
                                  <span>
                                      @if(@$puja->profile_img)
                                      <img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$puja->profile_img}}"alt="">
                                      @else
                                      <img src="{{ URL::to('public/frontend/images/pan1.jpg')}}" alt="">
                                      @endif
                                    </span>
                                    <div class="pandit-text">
                                        <h4><a href="{{route('search.pandit.publicProfile',['slug'=>@$puja->slug])}}">{{@$puja->puja_name}} </a></h4> --}}
                                        {{-- <p><img src="{{ URL::to('public/frontend/images/map.png')}}"> {{@$pandit->city}}, {{@$pandit->state}}, {{@$pandit->countries->country_name}}</p> --}}
                                        {{-- <p><img src="{{ URL::to('public/frontend/images/map.png')}}"> {{@$pandit->city? $pandit->city.',':''}}  {{@$pandit->states->name? @$pandit->states->name.',':''}}  {{@$pandit->countries->name?@$pandit->countries->name:''}} </p> --}}

                                        {{-- <p>
                                            ₹ - {{(int)$puja->price_inr}} --}}
                                            {{-- $ - {{(int)$puja->price_usd}} --}}
                                        {{-- </p> --}}

                                        {{-- <p><img src="{{ URL::to('public/frontend/images/puja.png')}}"> Kali Puja - Starting from 1147</p> --}}

                                    {{-- </div>
                                    <div class="pandit-moreinfo">
                                        <ul> --}}
                                            {{-- <li class="wid-40">
                                                <p><img src="{{ URL::to('public/frontend/images/dollIconbag.png')}}"> 1</p>
                                            </li> --}}
                                            {{-- <li class="wid-60">
                                                <p><img src="{{ URL::to('public/frontend/images/lan.png')}}"> Hindi , English</p>
                                            </li> --}}
                                            {{-- <li class="wid-60">
                                                <p><a href="javascript:;" class="tack_new clickon" style="display: block; top: unset;" data-value="ac-as-12" data-id="12" ><i class="fa fa-envelope-o"></i>View Details</a></p>
                                            </li> --}}
                                        {{-- </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <center > {{__('search.no_pandit_found')}} </center>
                            @endif --}}
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
                  {{@$pujas->links()}}
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
