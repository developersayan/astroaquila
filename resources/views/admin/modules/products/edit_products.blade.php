@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Product </title>
@endsection

@section('style')
@include('admin.includes.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    #exits_title{
        display: none;
        color: red;
    }
  #required_image{
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
            <h4 class="pull-left page-title">Edit Product </h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.product')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></i> Back</a></li>
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
                                        <h3 class="panel-title">Edit Product</h3>
                                    </div>
                                    <div class="panel-body rm02 rm04">
                                        <form role="form" id="product_form" action="{{route('admin.manage.update-product')}}" method="post"  enctype="multipart/form-data">
                                            @csrf
                                          <input type="hidden" name="product_id" value="{{@$data->id}}">

                                            <div class="form-group rm03">
                                                    <label for="FullName">Product Code</label>
                                                    <input type="text" id="product_code" placeholder="Product code" class="form-control" name="product_code" value="{{@$data->product_code}}" @if(@$dis) disabled @endif>
                                                    <div id="error_code"></div>
                                                    <div id="exits_code"></div>
                                                </div>
                                                <div class="form-group rm03">
                                                    <label for="FullName">Product Title</label>
                                                    <input type="text" id="product_title" placeholder="Product title" class="form-control" name="product_name" value="{{@$data->product_name}}">
                                                    <div id="error_title"></div>
                                                    <div id="exits_title">Product is alread added in this category</div>
                                                </div>




                                          <div class="row">
                                            <div class="col-lg-6">
                                              <div class="form-group rm03">
                                                  <label for="FullName">Category</label>
                                                 <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                    <option value="">Select Category</option>
                                                    @foreach(@$categories as $category)
                                                    <option value="{{@$category->id}}" @if (@$data->category_id == @$category->id) selected @endif>{{@$category->name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_category"></div>
                                              </div>
                                            </div>

                                            <div class="col-lg-6">
                                              <div class="form-group rm03">
                                                  <label for="FullName">Sub Category</label>
                                                 <select class="form-control rm06 basic-select" name="sub_category_id" id="sub_category_id">
                                                    <option value="">Select Category</option>
                                                    @foreach(@$subcategories as $category)
                                                    <option value="{{@$category->id}}" @if (@$data->sub_category_id  == @$category->id) selected @endif>{{@$category->name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_sub_category" style="display: none;color: red">Please select sub category</div>
                                              </div>
                                            </div>

                                          </div>


                                          <div class="form-group rm03">
                                                <label for="AboutMe">Product  Description</label>
                                                <textarea style="height: 80px" name="product_description"  class="form-control" id="description">{{(@$data->description)}}</textarea>
                                                <div id="error_description" class="error"></div>
                                            </div>




                                              <div class="form-group">
                                                  <label for="FullName">Product Weight (gm)</label>
                                                  <input type="text" name="product_weight" placeholder="Product Weight" class="form-control" value="{{@$data->product_weight}}">
                                                  <div id="error_weight"></div>
                                              </div>




                                              <div class="form-group">
                                                  <label for="FullName">Color</label>
                                                  <input type="text" name="color" placeholder="Product Color" class="form-control" value="{{@$data->color}}">
                                                  <div id="error_weight"></div>
                                              </div>



                                              <div class="form-group">
                                                  <label for="FullName">Size (MM)</label>
                                                  <input type="text" name="size" placeholder="Product Size" class="form-control" value="{{@$data->size}}">
                                                  <div id="error_size"></div>
                                              </div>





                                            <div class="form-group">
                                                <label for="FullName">Shape & Cut</label>
                                                <input type="text" name="shape" id="shape" placeholder="Shape & Cut" class="form-control"  value="{{@$data->shape_cut}}">
                                                 <span id="error_discount"></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="FullName">Country of Origin</label>
                                                <select class="form-control rm06 basic-select" name="country_id" id="country_id">
                                                  <option value="">Select Country</option>
                                                  @foreach(@$country as $value)
                                                    <option value="{{@$value->id}}" @if (@$data->country_of_origin == @$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach

                                                 </select>
                                            </div>



                                            <div class="form-group">
                                                <label for="FullName">Placement</label>
                                                <input type="text" name="placement" id="placement" placeholder="Placement" class="form-control"  value="{{@$data->placement}}">
                                                 <span id="error_discount"></span>
                                            </div>

                                            <div class="clearfix"></div>




                                              <div class="form-group">
                                                  <label for="FullName">Price In INR</label>
                                                  <input type="text" id="price" name="price_inr" placeholder="Enter Price In INR" class="form-control" value="{{@$data->price_inr}}">
                                                  <div id="error_price_inr"></div>
                                              </div>




                                              <div class="form-group">
                                                  <label for="FullName">Price In USD</label>
                                                  <input type="text" id="price_usd" name="price_usd" placeholder="Enter Price In USD" class="form-control" value="{{@$data->price_usd}}">
                                                  <div id="error_price_usd"></div>
                                              </div>



                                              <div class="clearfix"></div>



                                            <div class="form-group">
                                                <label for="FullName">Discount Percentage In INR (%) </label>
                                                <input type="text" name="discount_inr"  placeholder="Discounted Percentage" class="form-control"  value="{{@$data->discount_inr}}">
                                                 <span id="error_discount_inr"></span>
                                            </div>



                                            <div class="form-group">
                                                <label for="FullName">Discount Percentage In USD (%) </label>
                                                <input type="text" name="discount_usd"  placeholder="Discounted Percentage" class="form-control"  value="{{@$data->discount_usd}}">
                                                 <span id="error_discount_usd"></span>
                                            </div>

                                            <div class="clearfix"></div>




                                            <div class="form-group">
                                                <label for="FullName">Gift Pack Price In INR</label>
                                                <input type="text" name="gift_price_inr" id="gift_price_inr" placeholder="Gift Pack Price In INR" class="form-control"  value="{{@$data->gift_pack_price_inr}}">
                                                 <span id="error_gift_price_inr"></span>
                                            </div>

                                            

                                            <div class="form-group">
                                                <label for="FullName">Gift Pack Price In USD</label>
                                                <input type="text" name="gift_price_usd" id="gift_price_usd" placeholder="Gift Pack Price In USD" class="form-control"  value="{{@$data->gift_pack_price_usd}}">
                                                 <span id="error_gift_price_usd"></span>
                                            </div>


                                            <div class="clearfix"></div>





                                           <div class="form-group ">
                                            <div class="availability_check">
                                               <span for="FullName">Select Planets </span><input type="checkbox" id="select_planet" > <label for="select_planet">Apply To All</label>
                                             </div>
                                                <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Planets" name="planets[]" id="planets">
                                                @foreach($planets as $value )
                                                <option value="{{ @$value->id }}" {{ @in_array($value->id,@$selected_planet)?'selected':''}}>{{@$value->planet_name}}</option>
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
                                                <option value="{{ @$value->id }}" {{ @in_array($value->id,@$selected_rashi)?'selected':''}}>{{@$value->name}}</option>
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
                                                <option value="{{ @$value->id }}" {{ @in_array($value->id,@$selected_nakshatra)?'selected':''}}>{{@$value->name}}</option>
                                                @endforeach
                                              </select>
                                               {{-- <label id="language-error" class="error" for="language" style="display: none;">{{__('profile.required_language')}}</label> --}}
                                            </div>


                                            <div class="form-group">
                                              <div class="availability_check">
                                                 <span for="FullName">Select Deity</span> 
                                                 <input type="checkbox" id="select_deity"  >
                                                 <label for="select_deity">Apply To All</label> 
                                               </div>                                               
                                               <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Deity" name="deity[]" id="deity">
                                                @foreach($deity as $value )
                                                <option value="{{ @$value->id }}" {{ @in_array($value->id,@$selected_deity)?'selected':''}}>{{@$value->name}}</option>
                                                @endforeach
                                                </select>
                                            </div>

                                            <div class="clearfix"></div>






                                            



                                            <div class="form-group">
                                              <label for="FullName">Lab Certified</label>
                                                <div class="checkBox">

                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio1"  name="lab" value="Y" @if(@$data->lab_certified=='Y') checked="" @endif >
                                                  <label for="radio1">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio2"  name="lab" value="N" @if(@$data->lab_certified=='N') checked="" @endif>
                                                  <label for="radio2">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>

                                            <div class="form-group labName" @if(@$data->lab_certified=='N') style="display:none;" @endif>
                                                {{-- <label for="FullName">Laboratory Name</label>
                                                <input type="text" name="laboratory_name" id="laboratory_name" placeholder="Laboratory Name" class="form-control"  value="{{@$data->laboratory_name}}">
                                                 <span id="error_laboratory_name"></span> --}}
                                                 <label for="FullName">Laboratory Name</label>
                                                <select class="form-control  " name="laboratory_name" id="laboratory_name">
                                                  <option value="">Select Laboratory Name</option>
                                                  @foreach(@$certificate as $value)
                                                    <option value="{{@$value->id}}" @if(@$data->laboratory_name==@$value->id) selected @endif>{{@$value->cert_name}}</option>
                                                    @endforeach

                                                 </select>

                                                 <span id="error_laboratory_name"></span>
                                            </div>





                                       {{--  <div class="row">
                                            <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="FullName">Gift Pack Price In Inr</label>
                                                <input type="text" name="gift_price_inr" id="gift_price_inr" placeholder="Gift Pack Price In Inr" class="form-control"  value="{{@$data->gift_pack_price_inr}}">
                                                 <span id="error_gift_price_inr"></span>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="FullName">Gift Pack Price In Usd</label>
                                                <input type="text" name="gift_price_usd" id="gift_price_usd" placeholder="Gift Pack Price In Usd" class="form-control"  value="{{@$data->gift_pack_price_usd}}">
                                                 <span id="error_gift_price_usd"></span>
                                            </div>
                                          </div>
                                        </div> --}}



                                              <div class="form-group">
                                                  <label for="FullName">Select Seller</label>
                                                 <select class="form-control rm06 basic-select" name="seller_id" id="seller_id">
                                                  <option value="">Select Seller</option>
                                                  @foreach(@$seller as $value)
                                                    <option value="{{@$value->id}}" @if (@$data->seller_id == @$value->id) selected @endif>{{@$value->seller_name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_seller_id"></div>
                                              </div>




                                           






                                              

                                              






                                            

                                            <div class="form-group rm03">
                                                  <label for="FullName">Purpose</label>
                                                 <select class="form-control rm06 basic-select" name="purpose" id="purpose">
                                                  <option value="">Select Purpose</option>
                                                  @foreach(@$purpose as $value)
                                                    <option value="{{@$value->id}}" @if (@$data->purpose_id == @$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach

                                                 </select>
                                                 <div id="error_category"></div>
                                              </div>

                                            <div class="form-group rm03">
                                              <label for="AboutMe">Specific Property </label>
                                              <input type="text" placeholder="Specific Property" name="specific_prosperty" class="form-control new-form" value="{{@$data->specific_prosperty}}">
                                                 <div id="error_specific_prosperty"></div>
                                           </div>


                                             <div class="form-group">
                                              <label for="FullName">Availabilty</label>
                                                <div class="checkBox">

                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio3"  name="avail" value="Y" @if(@$data->availability=='Y') checked="" @endif>
                                                  <label for="radio3">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio4"  name="avail" value="N" @if(@$data->availability=='N') checked="" @endif >
                                                  <label for="radio4">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>

                                            <div class="form-group">
                                              <label for="FullName">Product Shippable</label>
                                                <div class="checkBox">

                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio5"  name="ship" value="Y" @if(@$data->shipable=='Y') checked="" @endif>
                                                  <label for="radio5">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio6"  name="ship" value="N" @if(@$data->shipable=='N') checked="" @endif>
                                                  <label for="radio6">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="FullName">COD Available?</label>
                                                  <div class="checkBox">

                                                  <ul>
                                                    <li>
                                                    <input type="radio" id="radio7"  name="is_cod_available" value="Y" @if(@$data->is_cod_available=='Y') checked="" @endif>
                                                    <label for="radio7">Yes</label>
                                                  </li>
                                                   <li>
                                                  <input type="radio" id="radio8"  name="is_cod_available" value="N" @if(@$data->is_cod_available=='N') checked="" @endif>
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
                                                    <input type="radio" id="radio11"  name="refundable" value="Y" @if(@$data->refundable=="Y") checked @endif>
                                                    <label for="radio11">Yes</label>
                                                  </li>
                                                   <li>
                                                  <input type="radio" id="radio12"  name="refundable" value="N" @if(@$data->refundable=="N"||@$data->refundable==null) checked @endif>
                                                    <label for="radio12">No</label>
                                                  </li>
                                                  </ul>
                                                </div>
                                              </div>

                                              <div class="form-group" id="refundable_status_div" @if(@$data->refundable=="N"||@$data->refundable==null) style="display: none;" @endif>
                                                  <label for="FullName">Refundable Status</label>
                                                 <select class="form-control rm06 basic-select" name="refundable_status" id="refundable_status">
                                                  <option value="">Select Refundable Status</option>
                                                    <option value="E" @if(@$data->refundable_status=="E") selected @endif>Exchange only</option>
                                                    <option value="FR" @if(@$data->refundable_status=="FR") selected @endif>Fully Refundable</option>
                                                    {{-- <option value="NR" @if(@$data->refundable_status=="NR") selected @endif>Non Refundable</option> --}}
                                                    <option value="PR" @if(@$data->refundable_status=="PR") selected @endif>Partially Refundable</option>
                                                    

                                                 </select>
                                                 <div id="error_refundable_status"></div>
                                              </div>


                                              {{-- <div class="clearfix"></div> --}}

                                              <div class="form-group">
                                                <label for="AboutMe">Delivery Days In India</label>
                                                <input type="text"  name="delivery_days_india"  class="form-control" value="{{@$data->delivery_days_india}}" placeholder="Delivery Days In India">
                                                <div id="error_delivery_days_india"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="AboutMe">Delivery Days Outside Of India</label>
                                                <input type="text"  name="delivery_days_outside_india"  class="form-control" value="{{@$data->delivery_days_outside_india}}" placeholder="Delivery Days Outside Of India">
                                                <div id="error_delivery_days_outside_india"></div>
                                            </div>





                                            

                                            
                                          <div class="form-group rm03">
                                                <label for="AboutMe">Mantra To Chant</label>
                                                <input type="text" name="mantra_to_chant" placeholder="Mantra To Chant"  class="form-control" value="{{(@$data->manta_to_chant)}}">
                                               <div id="error_description"></div>
                                            </div>
                                            
                                           <div class="form-group rm03">
                                              <label for="AboutMe">Usage </label>
                                                    <textarea style="height: 80px" placeholder="Usage" name="clarity" class="form-control">{{@$data->clarity}}</textarea>
                                                       <div id="error_clarity"></div>
                                             </div>

                                             <div class="form-group rm03">
                                              <label for="AboutMe">Significance</label>
                                                <textarea style="height: 80px" name="significance" class="form-control">{{@$data->significance}}</textarea>
                                                <div id="error_significance"></div>
                                            </div>

                                            
											<div class="form-group rm03">
                                              <label for="AboutMe">How & When to place/Wear</label>
                                                <textarea style="height: 80px" name="how_to_place" class="form-control">{{(@$data->how_to_place)}}</textarea>
                                                <div id="error_how_to_place"></div>
                                            </div>


                                            <div class="form-group rm03">
                                              <label for="AboutMe">Assurance/ Guarantee / Warranty</label>
                                                <textarea style="height: 80px" name="assurance_guarantee" class="form-control">{{@$data->assurance_guarantee}}</textarea>
                                                <div id="error_assurance_guarantee"></div>
                                            </div>


                                            

                                            

                      
                      <div class="form-group rm03">
                                              <label for="AboutMe">Shipping Policy</label>
                                                <textarea style="height: 80px" name="shipping_policy" class="form-control">{{(@$data->shipping_policy)}}</textarea>
                                                <div id="error_shipping_policy"></div>
                                            </div>
                      <div class="form-group rm03">
                                              <label for="AboutMe">Terms & Conditions of Return/Refund</label>
                                                <textarea style="height: 80px" name="terms_of_refund" class="form-control">{{(@$data->terms_of_refund)}}</textarea>
                                                <div id="error_terms_of_refund"></div>
                                            </div>



                                            <div class="form-group rm03">
                                                <label for="AboutMe">Meta Title / Page Title</label>
                                                <input type="text" placeholder="Title" name="meta_title" class="form-control new-form" value="{{@$data->meta_title}}">
                                                <div id="error_meta_title"></div>
                                            </div>

                                            <div class="form-group rm03">
                                              <label for="AboutMe">Meta  Description</label>
                                                <textarea style="height: 80px" name="meta_description" class="form-control">{{(@$data->meta_description)}}</textarea>
                                                <div id="error_meta_description"></div>
                                            </div>





                                            <div class="form-group">
                                              <label for="FullName">Product Video</label>
                                                <div class="checkBox">

                                                <ul>
                                                  <li>
                                                  <input type="radio" class="product_video" id="video1"  name="product_video" value="Y" @if(@$data->productVideo->video_link || !$data->productVideo) checked="" @endif>
                                                  <label for="video1">Youtube Link</label>
                                                </li>
                                                 <li>
                                                <input type="radio" class="product_video" id="video2"  name="product_video" value="U" @if(@$data->productVideo && @$data->productVideo->video_link==null) checked="" @endif>
                                                  <label for="video2">Upload Video</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>
                                            <div class="form-group rm03 show_link" @if((@$data->productVideo && @$data->productVideo->video_link==null)) style="display:none;" @endif>
                                              <label for="AboutMe">Youtube Video Link</label>
                                                 <input type="text" name="youtube_link" id="youtube_link" value="{{@$data->productVideo->video_link}}">
                                            </div>
                      <div class="clearfix"></div>
                      <div class="form-group show_upload" @if(@$data->productVideo->video_link || !$data->productVideo) style="display:none;" @endif>
                                                <label for="Email">Upload Video (File size must not exceed 10MB)</label>
                                                <div class="uplodimgfil">
                                                   <input type="file"  accept=".mp4"  name="prod_video" id="file-2" class="inputfile-2" />
                                                  <label for="file-2">Upload Video<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                <div id="error_video" class="error"></div>

                                            </div>
                      <div class="col-sm-12 video_gallery" @if(@$data->productVideo->video_link || !$data->productVideo) style="display:none;" @endif>
                      <video src="{{asset('storage/app/public/product_video/'.@$data->productVideo->image)}}" loop muted controls ></video>
                                             </div>

                                             <div class="clearfix"></div>

                                            <div class="form-group">
                                                <label for="Email">Product image (Recommended image dimension : 1920x933)</label>
                                                <div class="uplodimgfil">
                                                 <input type="file"  accept=".jpg,.jpeg,.png"  name="images[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="validateFileType()" multiple />
                                                  <label for="file-1">Upload New Images<img src="assets/images/clickhe.png" alt=""></label>
                                                </div>
                                                <div id="error_image"></div>

                                            </div>

                                             <div class="col-sm-12 gallery">
                                             </div>

                                            

                                            <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                                        </form>





                                      <div class="col-sm-12" style="margin-top: 25px;">
                                          <h5 class="pre_text "> Previous Uploaded Images </h5>
                                             <ul class="img_show">
                                                @foreach(@$data->productimgs as $row)

                                                 <li>
                                                  <div class="upimg">

                                                    <img src="{{ URL::to('storage/app/public/small_product_image')
                                                  }}/{{@$row->image}}">




                                                     @if(@$row->is_default == 'N')
                                                    <a href="{{route('admin.manage.delete-product-product-image',['id'=>$row->id])}}" onclick="return confirm('Do you want to delete this product image?')"><i class="far fa-trash-alt"></i></a>
                                                    @endif
                                                  </div>

                                                  <form method="post" action="{{route('admin.manage.change-default')}}">
                                                    @csrf
                                                     <div class="dash-d das-radio">

                                                    <input type="radio" onChange="this.form.submit()"  id="radio{{$row->id}}" @if(@$row->is_default == 'Y') checked="true" @endif name="is_default" value="{{$row->id}}">

                                                    <label for="radio{{$row->id}}">Set as default</label>
                                                  </div>

                                                  </form>
                                                  </li>

                                                @endforeach
                                                <div class="clearfix"></div>
                                              </ul>
                                            </div>




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
					$('.video_gallery').show();
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
               url: '{{ route("admin.check.product.code") }}',
               type: "post",
               data: {
                 product_code: function() {
                 return $( "#product_code" ).val();
                 },
                 _token: '{{ csrf_token() }}',
                 id:'{{@$data->id}}',
               }
               }
                  },
                product_name: {
                   required:true,
            },
            category_id:{
                required:true,
            },
            product_weight:{
                // required:true,
                number:true,
                min:1,
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
             size:{

            },
            // product_description:{
            //     required:true,
            // },
            'images[]':{
              extension: "png|jpg|jpeg",
           },
           gift_price_inr:{
              number:true,
            },
            gift_price_usd:{
              number:true,
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
            refundable_status:{
              required: function(element){
                var lab = $("input[name='refundable']:checked").val();
              if(lab=="Y")
              return true;
              else
              return false;
             },
            },
            laboratory_name:{
               // required:true,
               required: function(element){
                var lab = $("input[name='lab']:checked").val();
              if(lab=="Y")
              return true;
              else
              return false;
             },
            },

          },
         ignore: [],
         messages: {
             product_code: {
             required:'Please enter product code',
             remote: 'Product code already exists',
                },
               product_name:{
                required:'Please enter product name',
               },
               category_id:{
                required:'Please select a category',
               },
               product_weight:{
                required:'Please enter product weight',
                number:'Please enter product weight properly',
                min:'Minimum product weight should be 1',
               },
                 price_inr:{
                required:'Please enter product price in INR',
                number:'Only number allowed',
                min:'Please enter price properly',
               },
               price_usd:{
                required:'Please enter product price in USDUSD',
                number:'Only number allowed',
                min:'Please enter price properly',
               },
               discount_inr:{
                number:'Only number allowed',
                min:'Please enter price properly',
                lessThan:'Discount price should be less than product price',
               },
               discount_usd:{
                number:'Only number allowed',
                min:'Please enter price properly',
                lessThan:'Discount price should be less than product price',
               },
               product_description:{
                required:'Please enter product description',
               },
               meta_title:{
                required:'Please enter meta title',
               },
               meta_description:{
                required:'Please enter meta description',
               },
               gift_price_inr:{
                  number:'Only numbers are allowed',
                },
                gift_price_usd:{
                  number:'Only numbers are allowed',
                },
                refundable_status:{
                required:'Please select refundable status',
               },
               laboratory_name:{
                required:'Please enter laboratory name',
                },
               size:{

               },
               'images[]':{
                 extension:'Only png,jpg,jpeg allowed',
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
               var subvalue= [];
              @foreach(@$data->productimgs as $item )
              subvalue.push('{{ $item->image }}');
              @endforeach
             var price = $('#price').val();
             var img = $('#file-1').val();
             var youtube_link = $('#youtube_link').val();

             var current_image = $('#file-1').val();
             var discount = $('#discount_price').val();
             console.log(subvalue.length);
             console.log(img);
             var category_id = $('#category_id').val();

              $('#error_description').html('');
                  if(tinyMCE.get('description').getContent()==""){
                      alert('Please enter description of product')
                      $('#error_description').append('<p>Please enter description of product</p>');
                      return false;
                }
                if ($('#sub_category_id option').length > 1){
                    if ($('#sub_category_id').val()=="") {
                      alert('Please Select Sub Category');
                      return false;
                    }else{
                      // var sub_category_id = $('#sub_category_id').val();
                      // var product_name = $('#product_title').val();
                      // var pro_id = '{{@$data->id}}';
                      // // alert(pro_id);
                      // // alert(sub_category_id);
                      // // return false;
                      // $.ajax({
                      //       url:"{{route('admin.manage.check.sub-category-product')}}",
                      //       method:"GET",
                      //       data:{'category_id':category_id,'product_name':product_name,'id':pro_id,'sub_category_id':sub_category_id},
                      //       success: function(res) {

                      //       if (res=="hey") {
                      //         alert('Name already exits in this sub category');
                      //         return false;
                      //      }else{
                             if (youtube_link!="") {
                              var _url = $('#youtube_link').val();
                              if (_url.includes("www.youtube.com/watch?") || _url.includes("https://youtu.be/") ) {
                                 form.submit();
                              }else{
                                alert('Please enter valid url');
                                return false;
                              }
                           }
                           form.submit();

                     //      }

                     //     }
                     // });
                  }
                }else{
                var product_name = $('#product_title').val();
                var pro_id = '{{@$data->id}}';
                // alert(pro_id);
                // $.ajax({
                //       url:"{{route('admin.manage.check-product')}}",
                //       method:"GET",
                //       data:{'category_id':category_id,'product_name':product_name,'id':pro_id},
                //       success: function(res) {

                //       if (res=="hey") {
                //         $('#exits_title').css('display','block');
                //         return false;
                //      }else{
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

               //      }

               //     }
               // });
              }

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
            else if (element.attr("name") == "product_weight") {
                $("#error_weight").append(error);
            }
           else if (element.attr("name") == "price_inr") {
                $("#error_price_inr").append(error);
            }
            else if (element.attr("name") == "price_usd") {
                $("#error_price_usd").append(error);
            }
            else if (element.attr("name") == "discount_inr") {
                $("#error_discount_inr").append(error);
            }
            else if (element.attr("name") == "discount_usd") {
                $("#error_discount_usd").append(error);
            }if (element.attr("name") == "product_description") {
                $("#error_description").append(error);
            }

            else if (element.attr("name") == "meta_description") {
                $("#error_meta_description").append(error);
            }
             else if (element.attr("name") == "size") {
                $("#error_size").append(error);
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
            else if (element.attr("name") == "seller_id") {
                $("#error_seller_id").append(error);
            }
            else if (element.attr("name") == "delivery_days_india") {
                $("#error_delivery_days_india").append(error);
            }
            else if (element.attr("name") == "delivery_days_outside_india") {
                $("#error_delivery_days_outside_india").append(error);
            }
            else if (element.attr("name") == "laboratory_name") {
                $("#error_laboratory_name").append(error);
            }


            else if (element.attr("name") == 'images[]') {
              console.log(error);
                $("#error_image").append(error);
            }
        }

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
        }
    }
</script>
<script type="text/javascript">
  $.validator.addMethod('accept', function () { return true; });
</script>
<script type="text/javascript">
      // refundable
    $('#radio11').click(function(){
      $('#refundable_status_div').show();
      $("#refundable_status").rules("add", "required");
    });

    $('#radio12').click(function(){
      $('#refundable_status_div').hide();
      $("#refundable_status").rules("remove", "required");
    });
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#category_id').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();
      $.ajax({
        url:'{{route('admin.manage.get.sub-category')}}',
        type:'GET',
        data:{category:id,id:'{{@$data->sub_category_id }}'},
         success:function(data){
          console.log(data);
          if (data.subcategories=="<option value=''>Select Sub Category</option>") {
            $('#sub_category_id').html(data.subcategories);
            // $('#sub_category_id').prop('required',false);

          }else{
            $('#sub_category_id').html(data.subcategories);
            // $('#sub_category_id').prop('required',true);
            // if ($('#sub_category_id').prop('required',true)) {
            //   $('#error_sub_category').css('display','block');
            // }
         }
        }
      })
    })
  })
</script>



  <script type="text/javascript">
        $('#radio1').click(function(){
      $('.labName').show();
      $("#laboratory_name").rules("add", "required");
    });
    $('#radio2').click(function(){
      $('.labName').hide();
      $("#laboratory_name").rules("remove", "required");
    });
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
@endsection
