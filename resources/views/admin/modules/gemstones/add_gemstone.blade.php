@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Gemstone </title>
@endsection

@section('style')
@include('admin.includes.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
	#exits_title{
		display: none;
		color: red;
	}
  #error_image{
    color: red;
  }
</style>
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
<!-- Left Sidebar End -->
<!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->
  <div class="content-page">
    <!-- Start content -->
    <div class="content">
      <div class="container">

        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <h4 class="pull-left page-title">Add Gemstone </h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.gemstone')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                        <div class="col-lg-12">
                        @include('admin.includes.message')
                        <div>

                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Add Gemstone</h3>
                                    </div>
                                    <div class="panel-body rm02 rm04">
                                        <form role="form" id="product_form" method="post" action="{{route('admin.manage.add-gemstone')}}" enctype="multipart/form-data">
                                        	@csrf
                                          <div class="form-group rm03">
                                                    <label for="FullName">Gemstone Code</label>
                                                    <input type="text" id="product_code" placeholder="Gemstone code" class="form-control" name="product_code" value="{{old('product_code')}}">
                                                    <div id="error_code"></div>
                                                    <div id="exits_code"></div>
                                                </div>
                                                {{-- <div class="form-group rm03">
                                                    <label for="FullName">Gemstone Title</label>
                                                    <input type="text" id="product_title" placeholder="Gemstone title" class="form-control" name="product_name" value="{{old('product_name')}}">
                                                    <div id="error_title"></div>
                                                    <div id="exits_title">Gemstone is already added in this category</div>
                                                </div> --}}
                                                <div class="row">
                                                <div class="col-lg-6">
                                                  <div class="form-group rm03">
                                                  <label for="FullName">Gemstone Title</label>
                                                  <select class="form-control rm06 basic-select" name="title" id="title">
                                                      <option value="">Select Title</option>
                                                      @foreach(@$title as $value)
                                                      <option value="{{@$value->id}}">{{@$value->title}}</option>
                                                      @endforeach
                                                  </select>
                                                  <div id="error_title"></div>
                                                </div>
                                                 </div> 
                                                 
                                                  <div class="col-lg-6">
                                                    <div class="form-group rm03">
                                                    <label for="FullName">Gemstone Sub Title</label>
                                                    <select class="form-control rm06 basic-select" name="sub_title" id="sub_title">
                                                        <option value="">Select Sub Title</option>
                                                    </select>
                                                    <div id="error_sub_title"></div>
                                                  </div>
                                                 </div> 
                                                
                                               </div>
                                          
                                          <div class="form-group rm03">
                                               <div class="availability_check">
                                               <input type="checkbox" id="single_product" name="single_product" value="1"><label for="single_product"> This is a single product </label>
                                             </div>
                                           </div>


                                          <div class="row">
                                            <div class="col-lg-6 ">
                                              <div class="form-group rm03">
                                                  <label for="FullName">Category</label>
                                                 <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                 	<option value="">Select Category</option>
                                                 	@foreach(@$categories as $category)
                                                    <option value="{{@$category->id}}" @if (old('category_id') == @$category->id) selected @endif>{{@$category->category_name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_category"></div>
                                              </div>
                                            </div>
											<div class="col-lg-6 ">
                                              <div class="form-group rm03">
                                                  <label for="FullName">Stone Type</label>
                                                 <select class="form-control rm06 basic-select" name="stone_type" id="stone_type">
                                                 	<option value="">Select Stone Type</option>
                                                  @foreach(@$stone as $value)
                                                  <option value="{{@$value->slug}}">{{@$value->name}}</option>
                                                  @endforeach
													{{-- <option value="P" @if (old('stone_type') == 'P') selected @endif>Precious</option>
													<option value="SP" @if (old('stone_type') == 'SP') selected @endif>Semi Precious</option>
													<option value="UR" @if (old('stone_type') == 'UR') selected @endif>Up Rattan</option>
													<option value="G" @if (old('stone_type') == 'G') selected @endif>Genetral</option> --}}

                                                 </select>
                                                 <div id="error_stone_type"></div>
                                              </div>
                                            </div> 
                                          </div>

                                          <div class="form-group rm03">
                                                <label for="AboutMe">Gemstone Description</label>
                                                <textarea style="height: 80px" name="product_description" placeholder="Gemstone Description"  class="form-control" id="description">{{old('product_description')}}</textarea>
                                                <div id="error_description" class="error"></div>
                                            </div>





                                              <div class="form-group">
                                                  <label for="FullName">Gemstone Weight (Carat)</label>
                                                  <input type="text" name="product_weight" placeholder="Gemstone Weight" class="form-control" value="{{old('product_weight')}}" id="product_weight">
                                                  <div id="error_weight"></div>
                                              </div>

                                              <div class="form-group">
                                                  <label for="FullName">Gemstone Weight (Ratti)</label>
                                                  <input type="text" name="weight_ratti" placeholder="Gemstone Weight In Ratti" class="form-control"  id="weight_ratti" readonly>
                                                  {{-- <div id="error_weight"></div> --}}
                                              </div>



                                              {{-- <div class="form-group">
                                                  <label for="FullName">Color</label>
                                                  <input type="text" name="color" placeholder="Gemstone Color" class="form-control" value="{{old('color')}}">
                                                  <div id="error_weight"></div>
                                              </div> --}}

                                              <div class="form-group ">
                                                  <label for="FullName">Color</label>
                                                  <select class="form-control rm06 basic-select" name="color" id="color">
                                                      <option value="">Select Color</option>
                                                      @foreach(@$color as $value)
                                                      <option value="{{@$value->id}}">{{@$value->color}}</option>
                                                      @endforeach
                                                  </select>
                                                  {{-- <div id="error_title"></div> --}}
                                               </div>




                                              <div class="form-group">
                                                  <label for="FullName">Size (MM)</label>
                                                  <input type="text" name="size" placeholder="Gemstone Size" class="form-control" value="{{old('size')}}">
                                                  <div id="error_size"></div>
                                              </div>
                                               <div class="clearfix"></div>
											  
											  <div class="form-group malti_select add_rmopppp">
                                               <label for="FullName">Select Treatments</label>
                                               <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Treatments" name="treatments[]" id="treatments">
                                                @foreach($treatment as $value )
                                                <option value="{{ @$value->slug}}">{{@$value->name}}</option>
                                                @endforeach
                                              </select>
                                            </div>
											  
											  {{-- <div class="clearfix"></div> --}}

                                              

                      
                      



                                              											


                                            <div class="form-group">
                                                <label for="FullName">Country of Origin</label>
                                                <select class="form-control rm06 basic-select" name="country_id" id="country_id">
                                                  <option value="">Select Country</option>
                                                  @foreach(@$country as $value)
                                                    <option value="{{@$value->id}}" @if (old('country_id') == @$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach

                                                 </select>
                                            </div>
											
											
                     
















                      <div class="clearfix"></div>


                      {{-- Composition --}}
                      <div class="form-group">
                                   <label for="FullName">Composition</label>
                                        <select class="form-control rm06 basic-select" name="composition" id="composition">
                                        <option value="">Select Composition</option>
                                        <option value="A">Artificial</option>
                                        <option value="I">Imitation</option>
                                        <option value="N">Natural</option>
                                        <option value="S">Synthetic</option>
                                      </select>
                      </div>

                      <div class="form-group">
                                   <label for="FullName">Dimension Type</label>
                                        <select class="form-control rm06 basic-select" name="dimention_type" id="dimention_type">
                                        <option value="">Select Dimension Type</option>
                                        <option value="C">Calibrated</option>
                                        <option value="NC">Non- Calibrated</option>
                                      </select>
                      </div>

                      <div class="form-group">
                                   <label for="FullName">Transparency</label>
                                        <select class="form-control rm06 basic-select" name="transparency" id="transparency">
                                        <option value="">Select Transparency</option>
                                        <option value="O">Opaque</option>
                                        <option value="T">Transparent</option>
                                        <option value="TRA">Translucent </option>
                                         
                                      </select>
                      </div>

                      <div class="form-group">
                                   <label for="FullName">HEFT</label>
                                        <select class="form-control rm06 basic-select" name="heft" id="heft">
                                        <option value="">Select HEFT</option>
                                        <option value="H">Heavy</option>
                                        <option value="L">Light</option>
                                        <option value="M">Medium</option>
                                       </select>
                      </div>

                      <div class="form-group rm03">
                        <label for="AboutMe">Gravity </label>
                              <input type="text" placeholder="Gravity" name="gravity" class="form-control new-form" >
                                 <div id="error_gravity"></div>
                          </div>

                        <div class="form-group rm03">
                        <label for="AboutMe">Inclusions </label>
                              <input type="text" placeholder="Inclusions" name="inclusions" class="form-control new-form" >
                                 <div id="error_inclusions"></div>
                          </div>

                          <div class="form-group rm03">
                        <label for="AboutMe">Refractive Index </label>
                              <input type="text" placeholder="Refractive Index" name="refractive_index" class="form-control new-form" >
                                 <div id="error_refractive_index"></div>
                          </div>

                          
                                

                        <div class="form-group rm03">
                        <label for="AboutMe">Optical Phenomena </label>
                              <input type="text" placeholder="Optical Phenomena" name="optical_phenomena" class="form-control new-form" >
                                 <div id="error_clarity"></div>
                          </div>

                          





                                           

                                            {{-- <div class="form-group">
                                                <label for="FullName">Shape & Cut</label>
                                                <input type="text" name="shape" id="shape" placeholder="Shape & Cut" class="form-control"  value="{{old('shape')}}">
                                                 <span id="error_discount"></span>
                                            </div> --}}


                                             <div class="form-group ">
                                                  <label for="FullName">Shape</label>
                                                  <select class="form-control rm06 basic-select" name="shape" id="shape">
                                                      <option value="">Select Shape</option>
                                                      @foreach(@$shape as $value)
                                                      <option value="{{@$value->id}}">{{@$value->shapes}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>

                                              <div class="form-group ">
                                                  <label for="FullName">Cut</label>
                                                  <select class="form-control rm06 basic-select" name="cut" id="cut">
                                                      <option value="">Select Cut</option>
                                                      @foreach(@$cut as $value)
                                                      <option value="{{@$value->id}}">{{@$value->cuts}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>

                                              <div class="clearfix"></div>

                      <div class="form-group">
                                                  <label for="FullName">Base Price In INR</label>
                                                  <input type="text" id="price" name="price_inr" placeholder="Enter Price In INR" class="form-control" value="{{old('price_inr')}}">
                                                  <div id="error_price_inr"></div>
                                              </div>
                        
                        

                                              <div class="form-group">
                                                  <label for="FullName">Base Price In USD</label>
                                                  <input type="text" id="price_usd" name="price_usd" placeholder="Enter Price In USD" class="form-control" value="{{old('price_usd')}}">
                                                  <div id="error_price_usd"></div>
                                              </div>
                        
                        <div class="clearfix"></div>




                                            <div class="form-group">
                                                <label for="FullName">Discount Percentage In INR (%) </label>
                                                <input type="text" name="discount_inr"  placeholder="Discounted Percentage" class="form-control"  value="{{old('discount')}}">
                                                 <span id="error_discount_inr"></span>
                                            </div>



                                            <div class="form-group">
                                                <label for="FullName">Discount Percentage In USD (%) </label>
                                                <input type="text" name="discount_usd"  placeholder="Discounted Percentage" class="form-control"  value="{{old('discount')}}">
                                                 <span id="error_discount_usd"></span>
                                            </div>
                      
                      <div class="clearfix"></div>

                                            <div class="form-group">
                                                <label for="FullName">Gift Pack Price In INR</label>
                                                <input type="text" name="gift_price_inr" id="gift_price_inr" placeholder="Gift Pack Price In INR" class="form-control"  value="{{old('gift_price_inr')}}">
                                                 <span id="error_gift_price_inr"></span>
                                            </div>


                                        
                                            <div class="form-group">
                                                <label for="FullName">Gift Pack Price In USD</label>
                                                <input type="text" name="gift_price_usd" id="gift_price_usd" placeholder="Gift Pack Price In USD" class="form-control"  value="{{old('gift_price_usd')}}">
                                                 <span id="error_gift_price_usd"></span>
                                            </div>
                      
                      <div class="clearfix"></div>
                      
                      <div class="form-group">
                                                <label for="FullName">Price Per Carat In INR</label>
                                                <input type="text" name="price_per_carat_inr" id="price_per_carat_inr" placeholder="Price Per Carat In INR" class="form-control"  value="{{old('price_per_carat_inr')}}" readonly>
                                                 <span id="error_price_per_carat_inr"></span>
                                            </div>

                      
                      <div class="form-group">
                                                <label for="FullName">Price Per Carat In USD</label>
                                                <input type="text" name="price_per_carat_usd" id="price_per_carat_usd" placeholder="Price Per Carat In USD" class="form-control"  value="{{old('price_per_carat_usd')}}" readonly>
                                                 <span id="error_price_per_carat_usd"></span>
                                            </div>
                      
                      <div class="clearfix"></div>


                      <div class="form-group ">
                                            <div class="availability_check">
                                               <span for="FullName">Select Planets </span><input type="checkbox" id="select_planet" > <label for="select_planet">Apply To All</label>
                                             </div>
                                                <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Planets" name="planets[]" id="planets">
                                                @foreach($planets as $value )
                                                <option value="{{ @$value->id }}">{{@$value->planet_name}}</option>
                                                @endforeach
                                                </select>
                                            </div>
                      


                                           <div class="form-group ">
                                             <div class="availability_check">
                                               <span for="FullName">Select Rashi </span>
                                               <input type="checkbox" id="select_rashi" ><label for="select_rashi"> Apply To All</label>
                                             </div>
                                               <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Rashi" name="rashis[]" id="rashis">
                                                @foreach($rashi as $value )
                                                <option value="{{ @$value->id }}">{{@$value->name}}</option>
                                                @endforeach
                                              </select>
                                            </div>



                                            <div class="form-group ">
                                            <div class="availability_check">
                                               <span for="FullName">Select Nakshatras </span>
                                               <input type="checkbox" id="select_nakshtra">
                                               <label for="select_nakshtra">Apply To All</label> 
                                             </div>
                                                <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Nakshatras" name="nakshatra[]" id="nakshatra">
                                                @foreach($nakshatras as $value )
                                                <option value="{{ @$value->id }}">{{@$value->name}}</option>
                                                @endforeach
                                              </select>
                                               {{-- <label id="language-error" class="error" for="language" style="display: none;">{{__('profile.required_language')}}</label> --}}
                                            </div>


                                            <div class="form-group ">
                                              
                                               <div class="availability_check">
                                                 <span for="FullName">Select Deity</span> 
                                                 <input type="checkbox" id="select_deity"  >
                                                 <label for="select_deity">Apply To All</label> 
                                               </div>                                               
                                               <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Deity" name="deity[]" id="deity">
                                                @foreach($deity as $value )
                                                <option value="{{ @$value->id }}">{{@$value->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="form-group">
                                              <label for="FullName">Lab Certified</label>
                                                <div class="checkBox">

                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio1"  name="lab" value="Y" checked="">
                                                  <label for="radio1">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio2"  name="lab" value="N" >
                                                  <label for="radio2">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>
											
											
											<div class="form-group labName">
                                                <label for="FullName">Laboratory Name</label>
                                                {{-- <input type="text" name="laboratory_name" id="laboratory_name" placeholder="Laboratory Name" class="form-control"  value="{{old('laboratory_name')}}"> --}}
                                                 <select class="form-control rm06 basic-select" name="laboratory_name" id="laboratory_name">
                                                  <option value="">Select Laboratory Name</option>
                                                  @foreach(@$certificate as $value)
                                                    <option value="{{@$value->id}}">{{@$value->cert_name}}</option>
                                                    @endforeach

                                                 </select>

                                                 <span id="error_laboratory_name"></span>
                                            </div>
											


                                            

                                              

                                              <div class="form-group">
                                                <label for="FullName">Additional Certification Available ?</label>
                                                  <div class="checkBox">

                                                  <ul>
                                                    <li>
                                                    <input type="radio" id="radio9"  name="additional_certification" value="Y" checked="">
                                                    <label for="radio9">Yes</label>
                                                  </li>
                                                   <li>
                                                  <input type="radio" id="radio10"  name="additional_certification" value="N">
                                                    <label for="radio10">No</label>
                                                  </li>
                                                  </ul>
                                                </div>
                                              </div>



                                              

                        <div class="form-group">
                                                  <label for="FullName">Select Seller</label>
                                                 <select class="form-control rm06 basic-select" name="seller_id" id="seller_id">
                                                  <option value="">Select Seller</option>
                                                  @foreach(@$sellers as $value)
                                                    <option value="{{@$value->id}}" @if (old('seller_id') == @$value->id) selected @endif>{{@$value->seller_name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_seller_id"></div>
                                              </div>








                                    <div class="form-group rm03">
                        <label for="AboutMe">Specific Property </label>
                              <input type="text" placeholder="Specific Property" name="specific_prosperty" class="form-control new-form" >
                                 <div id="error_specific_prosperty"></div>
                          </div>            








                                              <div class="clearfix"></div>

                                      <div class="form-group">
                                              <label for="FullName">Availabilty</label>
                                                <div class="checkBox">

                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio3"  name="avail" value="Y" checked="">
                                                  <label for="radio3">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio4"  name="avail" value="N" >
                                                  <label for="radio4">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>                                            
                        
                                              <div class="form-group">
                                                <label for="FullName">COD Available?</label>
                                                  <div class="checkBox">

                                                  <ul>
                                                    <li>
                                                    <input type="radio" id="radio7"  name="is_cod_available" value="Y" checked="">
                                                    <label for="radio7">Yes</label>
                                                  </li>
                                                   <li>
                                                  <input type="radio" id="radio8"  name="is_cod_available" value="N">
                                                    <label for="radio8">No</label>
                                                  </li>
                                                  </ul>
                                                </div>
                                              </div>

                                              <div class="form-group">
                                                <label for="FullName">Refundable ?</label>
                                                  <div class="checkBox">

                                                  <ul>
                                                    <li>
                                                    <input type="radio" id="radio11"  name="refundable" value="Y" checked="">
                                                    <label for="radio11">Yes</label>
                                                  </li>
                                                   <li>
                                                  <input type="radio" id="radio12"  name="refundable" value="N">
                                                    <label for="radio12">No</label>
                                                  </li>
                                                  </ul>
                                                </div>
                                              </div>

                                              <div class="form-group" id="refundable_status_div">
                                                  <label for="FullName">Refundable Status</label>
                                                 <select class="form-control rm06 basic-select" name="refundable_status" id="refundable_status">
                                                  <option value="">Select Refundable Status</option>
                                                    <option value="E">Exchange only</option>
                                                    <option value="FR">Fully Refundable</option>
                                                    {{-- <option value="NR">Non Refundable</option> --}}
                                                    <option value="PR">Partially Refundable</option>
                                                 </select>
                                                 <div id="error_refundable_status"></div>
                                              </div>
                        
                        <div class="clearfix"></div>

                        <div class="form-group">
                                                <label for="AboutMe">Delivery Days In India</label>
                                                <input type="text"  name="delivery_days_india"  class="form-control" value="{{old('delivery_days_india')}}" placeholder="Delivery Days In India">
                                                <div id="error_delivery_days_india"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="AboutMe">Delivery Days Outside Of India</label>
                                                <input type="text"  name="delivery_days_outside_india"  class="form-control" value="{{old(' delivery_days_outside_india')}}" placeholder="Delivery Days Outside Of India">
                                                <div id="error_delivery_days_outside_india"></div>
                                            </div>
                       <div class="clearfix"></div>


                                    <div class="form-group rm03">
                                              <label for="AboutMe">Usage </label>
                                             <textarea style="height: 80px" placeholder="Usage" name="clarity" class="form-control">{{old('clarity')}}</textarea>
                                                       <div id="error_clarity"></div>
                                </div>
											                

                                      <div class="form-group rm03">
                                              <label for="AboutMe">Who, How & When to Wear/place this Gemstone</label>
                                                <textarea style="height: 80px" name="how_to_place" class="form-control">{{old('how_to_place')}}</textarea>
                                                <div id="error_how_to_place"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe"> Mantra for wearing this Gemstone</label>
                                                <input type="text"  name="mantra_to_chant"  class="form-control" value="{{old('mantra_to_chant')}}" placeholder="Mantra To Chant">
                                                <div id="error_mantra"></div>
                                            </div>

                                            <div class="form-group rm03">
                                              <label for="AboutMe">Significance and benefit of wearing this Gemstone</label>
                                                <textarea style="height: 80px" name="significance" class="form-control">{{old('significance')}}</textarea>
                                                <div id="error_significance"></div>
                                            </div>


                                             <div class="form-group rm03">
                                              <label for="AboutMe">Assurance/ Guarantee / Warranty</label>
                                                <textarea style="height: 80px" name="assurance_guarantee" class="form-control">{{old('assurance_guarantee')}}</textarea>
                                                <div id="error_assurance_guarantee"></div>
                                            </div>

                        
                        
                        
                      <div class="clearfix"></div>

                                            

                      
                      <div class="form-group rm03">
                                              <label for="AboutMe">Shipping Policy</label>
                                                <textarea style="height: 80px" name="shipping_policy" class="form-control">{{old('shipping_policy')}}</textarea>
                                                <div id="error_shipping_policy"></div>
                                            </div>
                      <div class="form-group rm03">
                                              <label for="AboutMe">Terms & Conditions of Return/Refund</label>
                                                <textarea style="height: 80px" name="terms_of_refund" class="form-control">{{old('terms_of_refund')}}</textarea>
                                                <div id="error_terms_of_refund"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Meta Title / Page Title </label>
                                                <input type="text" placeholder="Title" name="meta_title" class="form-control new-form" value="{{old('meta_title')}}">
                                                <div id="error_meta_title"></div>
                                            </div>
                                            <div class="form-group rm03">
                                              <label for="AboutMe">Meta  Description</label>
                                                <textarea style="height: 80px" name="meta_description" class="form-control">{{old('meta_description')}}</textarea>
                                                <div id="error_meta_description"></div>
                                            </div>


                                            <div class="form-group">
                                              <label for="FullName">Gemstone Video</label>
                                                <div class="checkBox">

                                                <ul>
                                                  <li>
                                                  <input type="radio" class="product_video" id="video1"  name="product_video" value="Y" checked="">
                                                  <label for="video1">Youtube Link</label>
                                                </li>
                                                 <li>
                                                <input type="radio" class="product_video" id="video2"  name="product_video" value="U" >
                                                  <label for="video2">Upload Video</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>
                                            <div class="form-group rm03 show_link">
                                              <label for="AboutMe">Youtube Video Link</label>
                                                 <input type="text" name="youtube_link" id="youtube_link">
                                            </div>
                      <div class="clearfix"></div>
                      <div class="form-group show_upload" style="display:none;">
                                                <label for="Email">Upload Video (File size must not exceed 10MB)</label>
                                                <div class="uplodimgfil">
                                                   <input type="file"  accept=".mp4"  name="prod_video" id="file-2" class="inputfile-2" />
                                                  <label for="file-2">Upload Video<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                <div id="error_video" class="error"></div>

                                            </div>
                      <div class="col-sm-12 video_gallery">
                                             </div>


                                            <div class="form-group">
                                                <label for="Email">Gemstone image (Recommended image dimension : 1920x1593)</label>
                                                <div class="uplodimgfil">
                                                   <input type="file"  accept=".jpg,.jpeg,.png"  name="images[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="validateFileType()" multiple />
                                                  <label for="file-1">Upload Images<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                <div id="error_image"></div>

                                            </div>




                                             <div class="col-sm-12 gallery">
                                             </div>



                                            {{-- <input type="hidden" name="planets" id="planets">
                                            <input type="hidden" name="rashis" id="rashis">
                                            <input type="hidden" name="treatments" id="treatments">
                                            <input type="hidden" name="deity" id="deity">
                                            <input type="hidden" name="nakshatra" id="nakshatra"> --}}
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                                        </form>




                                    </div>
                                </div>
                                <!-- Personal-Information -->

                        </div>
                    </div>
                    </div>
        <!-- End row -->

      </div>
      <!-- container -->

    </div>
    <!-- content -->
    @include('admin.includes.footer')
  </div>
  @endsection

@section('script')
@include('admin.includes.script')
<script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
    tinymce.init({
    selector: "textarea",
    forced_root_block : "",
    relative_urls : false,
    entity_encoding: 'raw',
    menubar: "",
    
     plugins: [
    
    "searchreplace wordcount visualblocks visualchars code fullscreen link",
    "lists",
  
    
    "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: ",link,unlink ",
        });
    
    </script>
<script type="text/javascript">
    $(function() {
        // Multiple images preview in browser
        var imagesPreview = function(input, placeToInsertImagePreview) {

            if (input.files) {
                var filesAmount = input.files.length;

                for (i = 0; i < filesAmount; i++) {
                    var file = input.files[i];
                    var fileName = file.name,
                    fileSize = file.size,
                    fileNameExtArr = fileName.split("."),
                    ext = fileNameExtArr[1];
                    console.log("fileSize : "+fileSize);

                    ext = ext.toLowerCase();
                    var reader = new FileReader();


                    reader.onload = function(event) {

                                var new_html = '<ul class="img_show "><li><div class="upimg"><img src="'+event.target.result+'"></div></li></ul>';
                                $('.gallery').append(new_html);

                     }

                            reader.readAsDataURL(input.files[i]);
                  }
            }

        };

        $('#file-1').on('change', function() {


            imagesPreview(this, 'div.gallery');
            $('.gallery').html('');

        });
    });

</script>

<script>
    $(document).ready(function(){
      $('.product_video').click(function(){
		   if($(this).val()=='Y')
			  {
				  $('.show_link').show();
				  $('.show_upload').hide();
				  $('.video_gallery').html('');
			  }
			  else
			  {
				  $('.show_link').hide();
				  $('.show_upload').show();
			  }
	  });
	  $("#file-2").change(function () {
		$('.video_gallery').html('');
		$('#error_video').html('');
		var vdo_size = '';
		var size_limit = '{{env("PRODUCT_VIDEO_LIMIT")}}';
		let files = this.files;
		var ix=0;
		if (files.length > 0) {
			vdo_size=this.files[0].size/1024/1024;
			let exts = ['video/mp4'];
			let valid = true;
			let sizev=true;
			console.log(vdo_size);
			$.each(files, function(i, f) {
				if (exts.indexOf(f.type) <= -1) {
					valid = false;
					return false;
				}
			});
			if(vdo_size>size_limit)
			{
				sizev=false;
			}
			if (! valid) {
				$('#error_video').html('Please choose valid video files (mp4) only.');
				$("#file-2").val('');
				return false;
			}
			if (! sizev) {
				$('#error_video').html('File size must not be more than 10MB');
				$("#file-2").val('');
				return false;
			}
			$.each(files, function(i, f) {
				$('.error_video').html('');
				var reader = new FileReader();
				reader.onload = function(e){
					$('.video_gallery').append('<video src="' + e.target.result + '" autoplay loop muted controls ></video>');
				};
				reader.readAsDataURL(f);
			});
		}

	});
	
       $("#product_form").validate({
            rules: {
			product_code: {
			   required:true,
			   remote: {
				 url: '{{ route("admin.check.gemstone.code") }}',
				 type: "post",
				 data: {
				   product_code: function() {
					 return $( "#product_code" ).val();
				   },
				   _token: '{{ csrf_token() }}'
				 }
			   }
            },
           // product_name: {
           //         required:true,
           //  },
           title:{
            required:true,
           },
           // sub_title:{
           //  required:true,
           // },
            category_id:{
            	required:true,
            },
			stone_type:{
            	required:true,
            },
            product_weight:{
            	required:true,
            	number:true,
            	min:1,
            },
            'images[]':{
           	  required:true,
              extension: "png|jpg|jpeg",
           },
            price_inr:{
            	required:true,
            	number:true,
            	min:1,
            },
            price_usd:{
              required:true,
              number:true,
              min:1,
            },
            discount_inr:{
            	number:true,
            	max:99,
            },
            discount_usd:{
              number:true,
              max:99,
            },
			// price_per_carat_inr:{
   //            required:true,
   //            number:true,
   //            min:1,
   //          },
			// price_per_carat_usd:{
   //            required:true,
   //            number:true,
   //            min:1,
   //          },
            // product_description:{
            // 	required:true,
            // },
            laboratory_name:{
				required:true,
			   },
            gift_price_inr:{
              number:true,
            },
            gift_price_usd:{
              number:true,
            },
            refundable_status:{
              required:true,
            },
            seller_id:{
              required:true,
            },
            delivery_days_india:{
              required:true,
              number:true,
              min:1,
            },
            delivery_days_outside_india:{
              required:true,
              number:true,
              min:1,
            },

          },
              ignore: [],
        messages: {
			product_code: {
			   required:'Please enter gemstone code',
			   remote: 'Gemstone code already exists',
            },
               // product_name:{
               // 	required:'Please enter gemstone name',
               // },
               title:{
                required:'Please select title',
               },
               sub_title:{
                required:'Please select sub title',
               },
               category_id:{
               	required:'Please select a category',
               },
			   stone_type:{
					required:'Please select a stone type',
				},
               product_weight:{
               	required:'Please enter gemstone weight',
               	number:'Only number allowed',
               	min:'Minimum gemstone weight should be 1',
               },
               price_inr:{
               	required:'Please enter gemstone price in INR',
               	number:'Only number allowed',
               	min:'Please enter price properly',
               },
               price_usd:{
                required:'Please enter gemstone price in USD',
                number:'Only number allowed',
                min:'Please enter price properly',
               },
			   price_per_carat_inr:{
               	required:'Please enter gemstone price per carat in INR',
               	number:'Only number allowed',
               	min:'Please enter price properly',
               },
               price_per_carat_usd:{
                required:'Please enter gemstone price per carat in USD',
                number:'Only number allowed',
                min:'Please enter price properly',
               },
               discount_inr:{
               	number:'Only number allowed',
               	min:'Please enter price properly',
               	lessThan:'Discount price should be less than gemstone price',
               },
               discount_usd:{
                number:'Only number allowed',
                min:'Please enter price properly',
                lessThan:'Discount price should be less than gemstone price',
               },
               product_description:{
               	required:'Please enter gemstone description',
               },
               seller_id:{
                required:'please select seller',
               },
               gift_price_inr:{
                  number:'Only numbers are allowed',
                },
                gift_price_usd:{
                  number:'Only numbers are allowed',
                },
               'images[]':{
               	required:'Please upload an gemstone image',
                extension:'Only png,jpg,jpeg allowed',
               },
               laboratory_name:{
                required:'Please select laboratory name',
               },
               refundable_status:{
                required:'Please select refundable status',
               },
               seller_id:{
                required:'please select seller',
               },
               delivery_days_india:{
                required:'Please enter delivery days in india',
                number:'Please enter number only',
                min:'Plese enter days correctly',
               },
               delivery_days_outside_india:{
                required:'Please enter delivery days outside of india',
                number:'Please enter number only',
                min:'Plese enter days correctly',
               },
               
			},
			submitHandler: function(form){
                var category_id = $('#category_id').val();
                var youtube_link = $('#youtube_link').val();
                var product_name = $('#product_title').val();
                var product_code = $('#product_code').val();
                 $('#error_description').html('');
                  if(tinyMCE.get('description').getContent()==""){
                      alert('Please enter description of gemstone')
                      $('#error_description').append('<p>Please enter description of gemstone</p>');
                      return false;
                    }
                if ($('#sub_title option').length > 1 && $('#sub_title').val()==""){
                  alert('Please select sub title');
                  return false;
                }  
                // $.ajax({
                //       url:"",
                //       method:"GET",
                //       data:{'category_id':category_id,'product_name':product_name,'product_code':product_code},
                //       success: function(res) {

                //       if (res=="found") {
                //         alert('Gemstone is already exists in this category');
                //         return false;
                //      }else{
                  var product_weight = $('#product_weight').val();
                  if(product_weight.includes('.')){
                  var nString = String(product_weight);
                  var nArray = nString.split('.');
                  if((nArray[1].length>4)){
                    alert('Weight should be mention up to 4 decimals.');
                    return false;
                  }else{
                    if (youtube_link!="") {
                          var _url = $('#youtube_link').val();
                          if (_url.includes("www.youtube.com/watch?") || _url.includes("https://youtu.be/") ) {
                             form.submit();
                          }else{
                            alert('Please enter valid url');
                            return false;
                          }
                       }else{
                        form.submit();
                       }
                  }
                  }else{
                       if (youtube_link!="") {
                          var _url = $('#youtube_link').val();
                          if (_url.includes("www.youtube.com/watch?") || _url.includes("https://youtu.be/") ) {
                             form.submit();
                          }else{
                            alert('Please enter valid url');
                            return false;
                          }
                       }else{
                        form.submit();
                       }
                     }

               //      }

               //     }
               // });
          },
        errorPlacement: function(error, element) {
            console.log("Error placement called");
			if (element.attr("name") == "product_code") {

                $("#error_code").append(error);
            }
            else if (element.attr("name") == "product_name") {

                $("#error_title").append(error);
            }
            else if (element.attr("name") == "category_id") {
                $("#error_category").append(error);
            }
			else if (element.attr("name") == "stone_type") {
                $("#error_stone_type").append(error);
            }
            else if (element.attr("name") == "product_weight") {
                $("#error_weight").append(error);
            }
            else if (element.attr("name") == "price_inr") {
                $("#error_price_inr").append(error);
            }
            else if (element.attr("name") == "price_usd") {
                $("#error_price_usd").append(error);
            }
			else if (element.attr("name") == "price_per_carat_inr") {
                $("#error_price_per_carat_inr").append(error);
            }
            else if (element.attr("name") == "price_per_carat_usd") {
                $("#error_price_per_carat_usd").append(error);
            }
            else if (element.attr("name") == "discount_inr") {
                $("#error_discount_inr").append(error);
            }
            else if (element.attr("name") == "discount_usd") {
                $("#error_discount_usd").append(error);
            }
            else if (element.attr("name") == "product_description") {
                $("#error_description").append(error);
            }

            else if (element.attr("name") == "meta_description") {
                $("#error_meta_description").append(error);
            }
             else if (element.attr("name") == "size") {
                $("#error_size").append(error);
            }
			else if (element.attr("name") == "laboratory_name") {
                $("#error_laboratory_name").append(error);
            }
            else if (element.attr("name") == "seller_id") {
                $("#error_seller_id").append(error);
            }
            else if (element.attr("name") == "gift_price_inr") {
                $("#error_gift_price_inr").append(error);
            }
            else if (element.attr("name") == "gift_price_usd") {
                $("#error_gift_price_usd").append(error);
            }
            else if (element.attr("name") == "refundable_status") {
                $("#error_refundable_status").append(error);
            }

            else if (element.attr("name") == 'images[]') {
            	console.log(error);
                $("#error_image").append(error);
            }
            else if (element.attr("name") == 'title') {
              console.log(error);
                $("#error_title").append(error);
            }
            else if (element.attr("name") == 'sub_title') {
              console.log(error);
                $("#error_sub_title").append(error);
            }
            else if (element.attr("name") == "seller_id") {
                $("#error_seller_id").append(error);
            }
            else if (element.attr("name") == "delivery_days_india") {
                $("#error_delivery_days_india").append(error);
            }
            else if (element.attr("name") == "delivery_days_outside_india") {
                $("#error_delivery_days_outside_india").append(error);
            }
        }
		

        });
		$('#radio1').click(function(){
			$('.labName').show();
			$("#laboratory_name").rules("add", "required");
		});
		$('#radio2').click(function(){
			$('.labName').hide();
			$("#laboratory_name").rules("remove", "required");
		});


    // refundable
    $('#radio11').click(function(){
      $('#refundable_status_div').show();
      $("#refundable_status").rules("add", "required");
    });

    $('#radio12').click(function(){
      $('#refundable_status_div').hide();
      $("#refundable_status").rules("remove", "required");
    });



    })
</script>
<script type="text/javascript">
    function validateFileType(){
        var fileName = document.getElementById("file-1").value;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="jpg" || extFile=="jpeg" || extFile=="png"){
            //TO DO
        }else{

            alert("Only jpg/jpeg and png files are allowed!");
            return;
        }
    }
</script>
<script type="text/javascript">
  $.validator.addMethod('accept', function () { return true; });
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $('#title').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.manage.gemstone.get-sub-title')}}',
        type:'GET',
        data:{title:id,},
        success:function(data){
          console.log(data);
          $('#sub_title').html(data.sub_title);
          
        }
      })
    })
  })
</script>

 {{-- select-planet-all  --}}
<script type="text/javascript">
        $('#select_planet').click(function(){
        if($(this).prop("checked") == true){  
            $('#planets option').prop('selected', true);  
            $('#planets').trigger('chosen:updated');

        }else{
          $('#planets option').prop('selected', false);  
            $('#planets').trigger('chosen:updated');
        }
      });
   
    
  </script>



  {{-- select-rashi --}}
  <script type="text/javascript">
        $('#select_rashi').click(function(){
        if($(this).prop("checked") == true){  
         $('#rashis option').prop('selected', true);  
          $('#rashis').trigger('chosen:updated');
        }else{
          $('#rashis option').prop('selected', false);  
          $('#rashis').trigger('chosen:updated');
       }
      });
   
    
  </script>

   {{-- nakshatra --}}
      <script type="text/javascript">
        $('#select_nakshtra').click(function(){
        if($(this).prop("checked") == true){  
          $('#nakshatra option').prop('selected', true);  
          $('#nakshatra').trigger('chosen:updated');
       
        }else{
          $('#nakshatra option').prop('selected', false);  
          $('#nakshatra').trigger('chosen:updated');
      }
      });
   
    
  </script>



    {{-- deity --}}
    <script type="text/javascript">
        $('#select_deity').click(function(){
        if($(this).prop("checked") == true){  
           $('#deity option').prop('selected', true);  
            $('#deity').trigger('chosen:updated');
        }else{
          $('#deity option').prop('selected', false);  
            $('#deity').trigger('chosen:updated');
       }
      });
   
 </script>



{{-- price-per-carrat inr calculation --}} 
<script type="text/javascript">
  $('#product_weight,#price').on('keyup',function(e){
    // if the checkbox is checked no need to calculation
    if($('#single_product').prop("checked") == false){
      var product_weight = $('#product_weight').val();
      var price_inr = $('#price').val();
      if (price_inr!="" && product_weight!="" && $.isNumeric(product_weight)) {
        var calculation = price_inr/product_weight;
        $('#price_per_carat_inr').val(calculation.toFixed(2));
      }else{
        $('#price_per_carat_inr').val('');
      }
   }else{
     var price_inr = $('#price').val();
     if (price_inr!="") {
      $('#price_per_carat_inr').val(price_inr);
     }
   }
  })
</script>

<script type="text/javascript">
  $('#product_weight,#price_usd').on('keyup',function(e){
    // if the checkbox is checked no need to calculation
    if($('#single_product').prop("checked") == false){
      var product_weight = $('#product_weight').val();
      var price_usd = $('#price_usd').val();
      if (price_usd!="" && product_weight!="" && $.isNumeric(product_weight)) {
        var calculation = price_usd/product_weight;
        $('#price_per_carat_usd').val(calculation.toFixed(2));
      }else{
        $('#price_per_carat_usd').val('');
      }

      
    }else{
      var price_usd = $('#price_usd').val();
     if (price_usd!="") {
      $('#price_per_carat_usd').val(price_usd);
     }
    }
  })
</script>


{{-- checked of single product event --}} 
<script type="text/javascript">
  $('#single_product').on('click',function(e){ 
  if($('#single_product').prop("checked") == false){
    var product_weight = $('#product_weight').val();
    var price_inr = $('#price').val();
    var price_usd = $('#price_usd').val();
    if (price_inr!="" && product_weight!="" && $.isNumeric(product_weight)) {
        var calculation = price_inr/product_weight;
        $('#price_per_carat_inr').val(calculation.toFixed(2));
    }else{
        $('#price_per_carat_inr').val('');
    }

    if (price_usd!="" && product_weight!="" && $.isNumeric(product_weight)) {
        var calculation = price_usd/product_weight;
        $('#price_per_carat_usd').val(calculation.toFixed(2));
      }else{
        $('#price_per_carat_usd').val('');
    }

  }else{
    var price_inr = $('#price').val();
    var price_usd = $('#price_usd').val();
     $('#price_per_carat_inr').val(price_inr);
     $('#price_per_carat_usd').val(price_usd);
  }  
});
</script>

{{-- ratti-calculation --}} 
<script type="text/javascript">
   $('#product_weight').on('keyup',function(e){
    var product_weight = $('#product_weight').val();
    if ($.isNumeric(product_weight)) {
      var calculation  = product_weight*1.09739;
       $('#weight_ratti').val(calculation.toFixed(2));
    }else{
       $('#weight_ratti').val('');
    }
   }); 
</script>





@endsection
