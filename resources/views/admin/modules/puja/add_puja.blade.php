@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Puja</title>
@endsection

@section('style')
@include('admin.includes.style')
<link href="{{ URL::asset('public/frontend/croppie/croppie.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.min.css') }}" rel="stylesheet" />
<style type="text/css">
  .checkBox li {
    width: 33%;
    float: left;
}
.uplodimgfilimg {
    margin-left: 20px;
    padding-top: 20px;
}
.uplodimgfilimg em {
    width: 58px;
    height: 58px;
    position: relative;
    display: inline-block;
    overflow: hidden;
    border-radius: 4px;
}

 .uplodimgfilimg em img{
    position: absolute;
    max-width: 100%;
    max-height: 100%;
  }
/*    .select-pure__option {
    margin-bottom: 65px !important;
 }*/
</style>
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
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
            <h4 class="pull-left page-title">Add Puja</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.puja')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                        <h3 class="panel-title">Add Puja</h3> 
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                        <form role="form" id="add_puja" method="post" enctype="multipart/form-data" action="{{route('admin.manage.puja.register')}}">
                                        	@csrf
											<div class="form-group rm03">
                                                <label for="FullName">Puja code</label>
                                                <input type="text" placeholder="Puja code" id="puja_code" name="puja_code" class="form-control">
                                                <div class="error" id="puja_code_error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                  <label for="FullName">Puja</label>
                                                 <select class="form-control rm06 basic-select" name="puja_id" id="puja_id">
                                                  <option value="">Select Puja</option>
                                                  @foreach(@$pujas as $value)
                                                    <option value="{{@$value->id}}">{{@$value->name}}</option>
                                                    @endforeach
                                                    
                                                 </select>
                                                 <div id="error_puja_id"></div>
                                           </div>
                                          <div class="form-group rm03">
                                                <label for="FullName">Puja title</label>
                                                <input type="text" placeholder="Puja title" id="name" name="name" class="form-control">
                                                <div class="error" id="name_error"></div>
                                            </div>



                                          <div class="form-group">
                                                  <label for="FullName">Puja Category</label>
                                                 <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                  <option value="">Select Category</option>
                                                  @foreach(@$category as $value)
                                                    <option value="{{@$value->id}}">{{@$value->name}}</option>
                                                    @endforeach
                                                    
                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>

                                           <div class="form-group">
                                                  <label for="FullName">Puja Sub Category</label>
                                                 <select class="form-control rm06 basic-select" name="sub_category_id" id="sub_category_id">
                                                  <option value="">Select Sub Category</option>
                                                 </select>
                                                 <div id="error_category"></div>
                                           </div>


                                            
                                            

                                            


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Puja description</label>
                                                <textarea style="height: 80px"  name="description" class="form-control" placeholder="Description" id="description"></textarea>
                                                <div class="error" id="description_error"></div>
                                            </div>


                                            <div class="form-group">
                                                <label for="FullName">Puja Price INR</label>
                                                <input type="text" placeholder="Puja Price" name="price_inr" class="form-control">
                                                <div class="error" id="price_error_inr"></div>
                                            </div>

                                            

                                            <div class="form-group">
                                                <label for="FullName">Puja Price USD</label>
                                                <input type="text" placeholder="Puja Price" name="price_usd" class="form-control">
                                                <div class="error" id="price_error_usd"></div>
                                            </div>

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
                                              <label for="FullName">Homam</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio3"  name="homam" value="Y" checked="">
                                                  <label for="radio3">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio4"  name="homam" value="N" >
                                                  <label for="radio4">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>

                                            <div id="homam_price">
                                            <div class="form-group">
                                                <label for="FullName">Homam Price INR</label>
                                                <input type="text" placeholder="Homam Price INR" name="homam_price_inr" class="form-control">
                                                <div class="error" id="error_homam_price_inr"></div>
                                            </div>

                                             

                                            <div class="form-group">
                                                <label for="FullName">Homam Price USD</label>
                                                <input type="text" placeholder="Homam Price USD" name="homam_price_usd" class="form-control">
                                                <div class="error" id="error_homam_price_usd"></div>
                                            </div>
                                          </div>
                                          <div class="clearfix"></div>

                                          
                                         





                                          

                                               <div class="form-group">
                                              <label for="FullName">CD Recording</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio20"  name="cd" value="Y" checked="">
                                                  <label for="radio20">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio21"  name="cd" value="N" >
                                                  <label for="radio21">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>





                                          <div id="cd_price">
                                            <div class="form-group">
                                                <label for="FullName">CD Recording Price Inr</label>
                                                <input type="text" placeholder="CD Recording Price Inr" name="cd_price_inr" class="form-control">
                                                <div class="error" id="error_cd_price_inr"></div>
                                            </div>

                                             

                                            <div class="form-group">
                                                <label for="FullName">CD Recording Price USD</label>
                                                <input type="text" placeholder="CD Recording Price USD" name="cd_price_usd" class="form-control">
                                                <div class="error" id="error_cd_price_usd"></div>
                                            </div>
                                          </div>


                                          <div class="clearfix"></div>


                                           <div class="form-group">
                                              <label for="FullName">Live streaming available</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio22"  name="live_streaming" value="Y" checked="">
                                                  <label for="radio22">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio23"  name="live_streaming" value="N" >
                                                  <label for="radio23">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>





                                          <div id="live_streaming_price">
                                            <div class="form-group">
                                                <label for="FullName">Live Streaming  Price INR</label>
                                                <input type="text" placeholder="Live Streaming  Price INR" name="liver_streaming_inr" class="form-control">
                                                <div class="error" id="error_liver_streaming_inr"></div>
                                            </div>

                                             

                                            <div class="form-group">
                                                <label for="FullName">Live Streaming Price USD</label>
                                                <input type="text" placeholder="Live Streaming Price USD" name="liver_streaming_usd" class="form-control">
                                                <div class="error" id="error_liver_streaming_usd"></div>
                                            </div>
                                          </div>


                                          <div class="clearfix"></div>

                                              <div class="form-group">
                                              <label for="FullName">Prasad of Puja Available</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio24"  name="prasad" value="Y" checked="">
                                                  <label for="radio24">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio25"  name="prasad" value="N" >
                                                  <label for="radio25">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>





                                          <div id="prasad_price">
                                            <div class="form-group">
                                                <label for="FullName">Prasad Price INR</label>
                                                <input type="text" placeholder="Prasad Price INR" name="prasad_inr" class="form-control">
                                                <div class="error" id="error_prasad_inr"></div>
                                            </div>

                                             

                                            <div class="form-group">
                                                <label for="FullName">Prasad Price USD</label>
                                                <input type="text" placeholder="Prasad Price USD" name="prasad_usd" class="form-control">
                                                <div class="error" id="error_prasad_usd"></div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>


                                        <div class="form-group" id="delivery_of_prasad">
                                              <label for="FullName">Delivery of Prasad  Available</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio30"  name="prasad_delivery" value="Y" checked="">
                                                  <label for="radio30">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio31"  name="prasad_delivery" value="N" >
                                                  <label for="radio31">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>


                                        <div id="prasad_delivery_div">    
                                        <div class="form-group " >
                                                <label for="AboutMe">Prasad Delivery Days In India</label>
                                                <input type="text" name="delivery_days_india" class="form-control" placeholder="Prasad Delivery Days In India" id="delivery_days_india">
                                                <div class="error" id="error_delivery_days_india"></div>
                                            </div>

                                            
                                            <div class="form-group ">
                                                <label for="AboutMe">Prasad Delivery Days Outside  India</label>
                                                <input type="text" name="delivery_days_outside_india" class="form-control" placeholder="Prasad Delivery Outside Of India" id="delivery_days_outside_india">
                                                <div class="error" id="error_delivery_days_outside_india"></div>
                                            </div>
                                          </div>





                                          <div class="clearfix"></div>
                                          <div class="form-group">
                                                <label for="FullName"> No. of Recitals</label>
                                                <input type="text" placeholder=" No. of Recitals" name="recitals" class="form-control">
                                                <div class="error" id="error_recidents"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="FullName">No Of Pundits</label>
                                                <input type="text" placeholder="No Of Pundits" name="pundits" class="form-control">
                                                <div class="error" id="error_pundits"></div>
                                            </div>

                                            
                                            

                                            
                                            

                                            <div class="form-group">
                                              <label for="FullName">Manner Of Puja</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio5"  name="manner" value="ONLINE" checked="">
                                                  <label for="radio5">Online</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio6"  name="manner" value="OFFLINE" >
                                                  <label for="radio6">Offline</label>
                                                </li>
                                                <li>
                                                <input type="radio" id="radio7"  name="manner" value="BOTH" >
                                                  <label for="radio7">Both</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>


                                          <div class="clearfix"></div>
                                          



                                          <div class="form-group">
                                              
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
                                         
                                            {{-- <div class="clearfix"></div> --}}
                                       
                                           <div class="form-group">
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

                                            {{-- <div class="clearfix"></div> --}}
                      
                      <div class="form-group">
                                               <div class="availability_check">
                                               <span for="FullName">Select Nakshatras </span>
                                               <input type="checkbox" id="select_nakshtra"><label for="select_nakshtra">Apply To All</label>
                                             </div>
                                               <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Nakshatras" name="nakshatra[]" id="nakshatra">
                                                @foreach($nakshatras as $value )
                                                <option value="{{ @$value->id }}">{{@$value->name}}</option>
                                                @endforeach
                                              </select>
                                            </div>

                                            <div class="clearfix"></div>

                                         <div class="clearfix"></div>
                                         <div class="form-group rm03">
                                               <label for="FullName">Select Purpose</label>
                                               <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Purpose" name="purpose[]" id="purpose">
                                                @foreach($purpose as $value )
                                                <option value="{{ @$value->id }}">{{@$value->name}}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                            <div class="clearfix"></div>

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


                                              <div class="form-group">
                                                <label for="FullName">Availabilty ?</label>
                                                  <div class="checkBox">

                                                  <ul>
                                                    <li>
                                                    <input type="radio" id="radio13"  name="availability" value="Y" checked="">
                                                    <label for="radio13">Yes</label>
                                                  </li>
                                                   <li>
                                                  <input type="radio" id="radio14"  name="availability" value="N">
                                                    <label for="radio14">No</label>
                                                  </li>
                                                  </ul>
                                                </div>
                                              </div>

                                              <div class="clearfix"></div>

                                          
                                          



                                          

                                            
                                            
                                            
                                            

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Significance/Benefits</label>
                                                <textarea style="height: 80px"  name="significance" class="form-control" placeholder="Significance/Benefits"></textarea>
                                                <div class="error" id="significance_error"></div>
                                            </div>

                                             <div class="form-group rm03">
                                                <label for="AboutMe">Facts/Mythology</label>
                                                <textarea style="height: 80px"  name="mythology" class="form-control" placeholder="Facts/Mythology"></textarea>
                                                <div class="error" id="mythology_error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Puja Mantra</label>
                                                <input type="text" name="mantra" class="form-control" placeholder="Puja Mantra" >
                                                {{-- <textarea style="height: 80px"  name="mantra" class="form-control" placeholder="Puja Mantra"></textarea> --}}
                                                <div class="error" id="mythology_error"></div>
                                            </div>


                                            <div class="form-group rm03">
                                              <label for="AboutMe">Who, How & When</label>
                                                <textarea style="height: 80px" name="who_when_how" class="form-control"></textarea>
                                                <div id="error_assurance_guarantee"></div>
                                            </div>

                                            <div class="form-group rm03">
                                              <label for="AboutMe">Assurance/ Guarantee / Warranty</label>
                                                <textarea style="height: 80px" name="assurance_guarantee" class="form-control"></textarea>
                                                <div id="error_assurance_guarantee"></div>
                                            </div>

                                          <div class="form-group rm03">
                                                <label for="AboutMe">Meta Title / Page Title</label>
                                                <input type="text" placeholder="Title" name="meta_title" class="form-control new-form" value="{{old('meta_title')}}">
                                                <div id="error_meta_title"></div>
                                            </div>
                                            <div class="form-group rm03">
                                              <label for="AboutMe">Meta  Description</label>
                                                <textarea style="height: 80px" name="meta_description" class="form-control">{{old('meta_description')}}</textarea>
                                                <div id="error_meta_description"></div>
                                            </div>   

                                          


                                    <div class="row">
                                              <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="Email">Puja Video</label>
                                                <div class="uplodimgfil">
                                                  <input type="file" name="video" id="file-2" class="inputfile inputfile-1" onchange="fun2()" accept="video/mp4
                                                  " data-multiple-caption="{count} files selected" multiple />
                                                  <label for="file-2">Upload Video<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                
                                            </div>
                                            </div>
                                    </div>


                                      <div class="row">
                                              <div class="col-lg-12">
                                          <div class="form-group">
                                       
                                          <div class="uplodimgfilimg_video ad_rbn_001 show_video" style="display: none">
                                              <video  id="video_preview" height="200" width="300" controls></video>
                                          </div>
                                       
                                        </div>
                                      </div>
                                    </div>


                                    <div class="form-group rm03 show_link">
                                              <label for="AboutMe">Youtube Video Link</label>
                                                 <input type="text" name="youtube_link" id="youtube_link">
                                   </div>
                                      



                                      <div class="row">
                                              <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="Email">Puja Image</label>
                                                 <div class="uplodimgfil">
                                                  <input type="file" id="icon" name="image"  class="inputfile inputfile-1">
                                                 <input type="hidden" name="profile_picture" id="profile_picture">
                                                <label for="icon">Upload Puja Image<img src="{{ URL::to('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                    </div>
                                                <div class="error" id="image_error"></div>
                                            </div>

                                           <div class="form-group">
                                       
                                          <div class="uplodimgfilimg ">
                                            <em><img src="" alt="" id="img2"></em>
                                          </div>
                                        
                                        </div>
                                      </div>
                                    </div>


{{--                                     <div class="row">
                                              <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="Email">Puja Video</label>
                                                <div class="uplodimgfil">
                                                  <input type="file" name="image" id="file-2" class="inputfile inputfile-1" onchange="fun2()" accept="image/*" >
                                                  <label for="file-1">Upload Video<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                <div class="error" id="image_error"></div>
                                            </div>

                                          <div class="form-group">
                                       
                                          <div class="uplodimgfilimg ad_rbn_001 show_image" style="display: none">
                                              <img src="" alt="" id="img2" style="width: 84px;height: 80px">
                                          </div>
                                       
                                        </div>
                                      </div>
                                    </div> --}}



                                            {{-- <input type="hidden" name="deity" id="deity"> --}}
                                            {{-- <input type="hidden" name="purpose" id="purpose"> --}}
											{{-- <input type="hidden" name="planets" id="planets"> --}}
                                            {{-- <input type="hidden" name="rashis" id="rashis"> --}}
											{{-- <input type="hidden" name="nakshatra" id="nakshatra"> --}}
                                             

                                            
                                           
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

                    <div class="modal" tabindex="-1" role="dialog" id="croppie-modal">
                      <div class="modal-dialog" role="document">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title">Crop Image</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              <div class="modal-body">
                                  <div class="row">
                                      <div class="col-12">
                                          <div class="croppie-div" style="width: 100%;"></div>
                                      </div>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-primary" id="crop-img">Save changes</button>
                                  <button type="button" class="btn btn-secondary close_btn" data-dismiss="modal">Close</button>
                              </div>
                          </div>
                      </div>
                  </div>
        
      </div>
      <!-- container --> 
      
    </div>
    <!-- content -->
    
     @include('admin.includes.footer')
  </div>
  <!-- ============================================================== --> 
  <!-- End Right content here --> 
@endsection 
@section('script')
@include('admin.includes.script')
<script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
<script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
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
<script>
    function fun1(){
    var i=document.getElementById('file-1').files[0];
    var b=URL.createObjectURL(i);
    $(".show_image").show();
    $("#img2").attr("src",b);
    }
</script>

<script>
    function fun2(){
    var i=document.getElementById('file-2').files[0];
    var b=URL.createObjectURL(i);
    $(".show_video").show();
    $("#video_preview").attr("src",b);
    }
</script>
<script type="text/javascript">
	  $("#add_puja").validate({
           rules: {
         puja_id:{
          required:true,
         },
			   puja_code: {
                   required:true,
				   remote: {
					 url: '{{ route("admin.check.puja.code") }}',
					 type: "post",
					 data: {
					   puja_code: function() {
						 return $( "#puja_code" ).val();
					   },
					   _token: '{{ csrf_token() }}'
					 }
				   }
            },
                name: {
                   required:true,
            },
            category_id:{
              required:true,
            },
           image:{
            required:true,
            extension:'jpg|jpeg|png|gif',
           },
           // description:{
           // 	required:true,
           // },
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
            recitals:{
            required:true,
           },
            pundits:{
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
            homam_price_inr:{
              number:true,
            },
            homam_price_usd:{
              number:true,
            },
            refundable_status:{
              required:true,
            },

            cd_price_usd:{
               number:true,
             },
             cd_price_inr:{
              number:true,
            },
              liver_streaming_inr:{
               number:true,
             },
             liver_streaming_usd:{
               number:true,
             },
             prasad_inr:{
               number:true,
             },
             prasad_usd:{
               number:true,
             },
             delivery_days_india:{
              
              number:true,
              min:1,
             },
             delivery_days_outside_india:{
              
              number:true,
              min:1,
             },




           //  significance:{
           //  required:true,
           // },
           // mythology:{
           //  required:true,
           // },
          },
        ignore: [],
        messages: {
      puja_id:{
        required:'Please select puja',
      },    
			puja_code: {
                   required:'Please enter puja code',
				   remote: 'Puja code already exists'
            },
          name: {
            required:'Please enter puja title',
            remote:'Puja title already exits',
           },  
           category_id:{
            required:'Please select puja category',
           },
           image: {
           required:'Please upload puja image',
          extension:'Please choose valid image files (jpeg, png, gif,jpg) only.',
           },  
           description: {
           required:'Please enter description',
           },  
           price_inr:{
           	required:'Please enter price in INR',
           	number:'Please enter number',
           	min:'Please enter price properly',
           },
           price_usd:{
            required:'Please enter price in USD',
            number:'Please enter number',
            min:'Please enter price properly',
           },
           recitals:{
            required:'Please enter the number of recitals',
           },
           pundits:{
            required:'Please enter the number of pundits',
            number:'Please enter number',
            min:'Please enter number properly',
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

               homam_price_usd:{
                number:'Only number allowed',
               },
               homam_price_usd:{
                number:'Only number allowed',
               },
               refundable_status:{
                required:'Please select refundable status',
               },
               delivery_days_india:{
              required:'Please enter delivery days in india',
              number:'Only Number allowed',
              min:'Please enter delivery days in india properly',
             },
             delivery_days_outside_india:{
              required:'Please enter delivery days outside of india',
              number:'Only Number allowed',
              min:'Please enter delivery days outside of india properly',
             },
           // significance:{
           //  required:'Please enter significance',
           // },
           // mythology:{
           //  required:'Please enter mythology of the puja',
           // },
        },
        submitHandler: function(form){
          
          var deity = $('#deity :selected').length;
          var purpose = $('#purpose :selected').length;
          $('#description_error').html('');
          if(tinyMCE.get('description').getContent()==""){
              alert('Please enter description of puja')
              $('#description_error').append('<p>Please enter description of puja</p>');
              return false;
            }
          if (purpose==0) {
            alert('Please select atleast one purpose');
            return false;
          }
          else if(deity==0)
          {
            alert('Please select atleast one deity');
            return false;
          }else{
            var prasad_of_puja = $('input[type=radio][name=prasad]:checked').val();
            var prasad = $('input[type=radio][name=prasad_delivery]:checked').val();
            var delivery_days_outside_india = $('#delivery_days_outside_india').val();
            var delivery_days_india = $('#delivery_days_india').val();
            if (prasad=='Y' && prasad_of_puja=='Y') {
              if (delivery_days_india=='') {
                alert('Please enter prasad delivery days in india');
                return false;
              }
              else if(delivery_days_outside_india==''){
                 alert('Please enter prasad delivery days outside of india');
                 return false;
              }else{
                if ($('#sub_category_id option').length > 1){
                    if ($('#sub_category_id').val()=="") {
                      alert('Please Select Sub Category');
                      return false;
                    }else{
                      var youtube_link = $('#youtube_link').val();
                      if (youtube_link!="") {
                        var _url = $('#youtube_link').val();
                         if (_url.includes("www.youtube.com/watch?") || _url.includes("https://youtu.be/") ) {
                               form.submit();
                         }else{
                          alert('Please enter valid url');
                          return false;
                         }
                      } 
                    }
                  }
                  var youtube_link = $('#youtube_link').val();
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
              }
            }else{
              if ($('#sub_category_id option').length > 1){
                    if ($('#sub_category_id').val()=="") {
                      alert('Please Select Sub Category');
                      return false;
                    }else{
                      var youtube_link = $('#youtube_link').val();
                      if (youtube_link!="") {
                        var _url = $('#youtube_link').val();
                         if (_url.includes("www.youtube.com/watch?") || _url.includes("https://youtu.be/") ) {
                               form.submit();
                         }else{
                          alert('Please enter valid url');
                          return false;
                         }
                      } 
                    }
                  }
                  var youtube_link = $('#youtube_link').val();
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
            }
          // var category_id = $('#category_id').val();
          // var name = $('#name').val();
          
          //                    $.ajax({
          //                         url:"{{route('admin.manage.puja.check')}}",
          //                         method:"GET",
          //                         data:{'category_id':category_id,'name':name},
          //                         success: function(res) {
          //                         console.log(res);  
          //                         if (res=="found") {
          //                           alert('Puja  already exits in this category');
          //                           return false;
          //                        }else{
                                     // form.submit();                  
                           //        }
                           //     }
                           // }); 
           }                  
        }, 
        errorPlacement: function(error, element) {
            console.log("Error placement called");
			if (element.attr("name") == "puja_code") {
               
                $("#puja_code_error").append(error);
            }
            if (element.attr("name") == "name") {
               
                $("#name_error").append(error);
            }
            else if (element.attr("name") == "image") {
               
                $("#image_error").append(error);
            }
            else if (element.attr("name") == "puja_id") {
               
                $("#error_puja_id").append(error);
            }
            else if (element.attr("name") == "description") {
               
                $("#description_error").append(error);
            }
            else if (element.attr("name") == "price_inr") {
                $("#price_error_inr").append(error);
            }
            else if (element.attr("name") == "price_usd") {
                $("#price_error_usd").append(error);
            }
             else if (element.attr("name") == "recitals") {
                $("#error_recidents").append(error);
            }
            else if (element.attr("name") == "pundits") {
                $("#error_pundits").append(error);
            }
            // else if (element.attr("name") == "significance") {
            //     $("#significance_error").append(error);
            // }
            // else if (element.attr("name") == "mythology") {
            //     $("#mythology_error").append(error);
            // }
            else if (element.attr("name") == "category_id") {
                $("#error_category").append(error);
            }
             else if (element.attr("name") == "discount_inr") {
                $("#error_discount_inr").append(error);
            }
            else if (element.attr("name") == "discount_usd") {
                $("#error_discount_usd").append(error);
            }
            else if (element.attr("name") == "homam_price_inr") {
                $("#error_homam_price_inr").append(error);
            }
            else if (element.attr("name") == "homam_price_usd") {
                $("#error_homam_price_usd").append(error);
            }
            
            else if (element.attr("name") == "cd_price_usd") {
                $("#error_cd_price_usd").append(error);
            }
            else if (element.attr("name") == "cd_price_inr") {
                $("#error_cd_price_inr").append(error);
            }
            else if (element.attr("name") == "liver_streaming_inr") {
                $("#error_liver_streaming_inr").append(error);
            }
            else if (element.attr("name") == "liver_streaming_usd") {
                $("#error_liver_streaming_usd").append(error);
            }
            else if (element.attr("name") == "prasad_inr") {
                $("#error_prasad_inr").append(error);
            }
            else if (element.attr("name") == "prasad_usd") {
                $("#error_prasad_usd").append(error);
            }
            else if (element.attr("name") == "delivery_days_india") {
                $("#error_delivery_days_india").append(error);
            }
            else if (element.attr("name") == "delivery_days_outside_india") {
                $("#error_delivery_days_outside_india").append(error);
            }
            else if (element.attr("name") == "refundable_status") {
                $("#error_refundable_status").append(error);
            }


        }
});
   
</script>
<script type="text/javascript">
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
/*end Auto Complete for planets*/

        /*all planets data push in array*/
        var dataplanets = [];
        @foreach($planets as $value )
        dataplanets.push({ label : '{{ $value->planet_name }}', value : '{{ $value->id }}'});
        @endforeach
        console.log(dataplanets);
        /*end*/
        /*user planets data push in array*/
        var planetsvalue= [];

        /*end*/
        $('#planets').val(planetsvalue);

        var autocomplete = new SelectPure(".autocomplete-select", {
            options: dataplanets,
            value: [],
            multiple: true,
            autocomplete: true,
            icon: "fa fa-times",
            onChange: value => {
                console.log(value);
                $('#planets').val(value);
            },
            classNames: {
                select: "select-pure__select",
                dropdownShown: "select-pure__select--opened",
                multiselect: "select-pure__select--multiple",
                label: "select-pure__label",
                placeholder: "select-pure__placeholder",
                dropdown: "select-pure__options",
                option: "select-pure__option",
                autocompleteInput: "select-pure__autocomplete",
                selectedLabel: "select-pure__selected-label",
                selectedOption: "select-pure__option--selected",
                placeholderHidden: "select-pure__placeholder--hidden",
                optionHidden: "select-pure__option--hidden",
            }
        });

        


        
                
        var resetAutocomplete = function() {
            autocomplete.reset();
        };
    
</script>


  <script>
    function dataURLtoFile(dataurl, filename) {

 var arr = dataurl.split(','),
     mime = arr[0].match(/:(.*?);/)[1],
     bstr = atob(arr[1]),
     n = bstr.length,
     u8arr = new Uint8Array(n);

 while(n--){
     u8arr[n] = bstr.charCodeAt(n);
 }

 return new File([u8arr], filename, {type:mime});
}
      var uploadCrop;
    $(document).ready(function(){
      $(".js-example-basic-multiple").select2();
        if($('.type').val()=='C'){
            $(".s_h_hids").slideDown(0);
        } else{
            $(".s_h_hids").slideUp(0);
        }
        $(".ccllk02").click(function(){
            $(".s_h_hids").slideDown();
        });
        $(".ccllk01").click(function(){
            $(".s_h_hids").slideUp();
            $('.cmpy').val('');
        });
        $(".type-radio").change(function(){
           var t= $("input[name=type]:checked").val();
           if(t=="I"){
            $(".comany_name").css('display','none');
           }else{
            $(".comany_name").css('display','block');
           }
        });



    $('#croppie-modal').on('hidden.bs.modal', function() {
            uploadCrop.croppie('destroy');
        });
		$('#croppie-modal .close, #croppie-modal .close_btn').on('click', function() {
			$('#icon').val('');
        });

        $('#crop-img').click(function() {
            uploadCrop.croppie('result', {
                type: 'base64',
                format: 'png'
            }).then(function(base64Str) {
                $("#croppie-modal").modal("hide");
               //  $('.lds-spinner').show();
               let file = dataURLtoFile('data:text/plain;'+base64Str+',aGVsbG8gd29ybGQ=','hello.png');
                  console.log(file.mozFullPath);
                  console.log(base64Str);
                  // $('#file').val(base64Str);
                  $('#profile_picture').val(base64Str);
               // $.each(file, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uplodimgfilimg').append('<em><img  src="' + e.target.result + '"><em>');
                    };
                    reader.readAsDataURL(file);

               //  });
                $('.uplodimgfilimg').show();

            });
        });
    });
    $("#icon").change(function () {
            $('.uplodimgfilimg').html('');
            let files = this.files;
            console.log(files);
            let img  = new Image();
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (! valid) {
                    alert('Please choose valid image files (jpeg, png, gif) only.');
                    $("#icon").val('');
                    return false;
                }
                // img.src = window.URL.createObjectURL(event.target.files[0])
                // img.onload = function () {
                //     if(this.width > 250 || this.height >160) {
                //         flag=0;
                //         alert('Please upload proper image size less then : 250px x 160px');
                //         $("#file").val('');
                //         $('.uploadImg').hide();
                //         return false;
                //     }
                // };
                $("#croppie-modal").modal("show");
                uploadCrop = $('.croppie-div').croppie({
                    viewport: { width: 400, height: 376, type: 'square' },
                    boundary: { width: $(".croppie-div").width(), height: 400 }
                });
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');
                    // console.log(e.target.result)
                    uploadCrop.croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
               //  $('.uploadImg').append('<img width="100"  src="' + reader.readAsDataURL(this.files[0]) + '">');
               //  $.each(files, function(i, f) {
               //      var reader = new FileReader();
               //      reader.onload = function(e){
               //          $('.uploadImg').append('<img width="100"  src="' + e.target.result + '">');
               //      };
               //      reader.readAsDataURL(f);
               //  });
               //  $('.uploadImg').show();
            }

        });
</script>   

<script type="text/javascript">
$(document).ready(function() {
 $('input[type=radio][name=homam]').change(function() {
   if (this.value == 'Y') {
    $('#homam_price').css('display','block');
   }else{
     $('#homam_price').css('display','none');
   }
 });
  
 });
 </script>


 <script type="text/javascript">
$(document).ready(function() {
 $('input[type=radio][name=cd]').change(function() {
   if (this.value == 'Y') {
    $('#cd_price').css('display','block');
   }else{
     $('#cd_price').css('display','none');
   }
 });

  $('input[type=radio][name=live_streaming]').change(function() {
   if (this.value == 'Y') {
    $('#live_streaming_price').css('display','block');
   }else{
     $('#live_streaming_price').css('display','none');
   }
 });
  

    $('input[type=radio][name=prasad]').change(function() {
   if (this.value == 'Y') {
    $('#prasad_price').css('display','block');
     $('#delivery_of_prasad').css('display','block');
    
    var prasad = $('input[type=radio][name=prasad_delivery]:checked').val();
    if (prasad=="Y") {
     $('#prasad_delivery_div').css('display','block');
    }else{
      $('#prasad_delivery_div').css('display','none');
    }
    
   }else{
     $('#prasad_price').css('display','none');
     $('#delivery_of_prasad').css('display','none');
      if (prasad=="Y") {
     $('#prasad_delivery_div').css('display','block');
    }else{
      $('#prasad_delivery_div').css('display','none');
    }
   }
 });

        $('input[type=radio][name=prasad_delivery]').change(function() {
   if (this.value == 'Y') {
    $('#prasad_delivery_div').css('display','block');
   }else{
     $('#prasad_delivery_div').css('display','none');
   }
 });
  
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


  <script type="text/javascript">
  $(document).ready(function(){
    $('#category_id').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.manange.puja.get.sub-cat')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#sub_category_id').html(data.sub_cat);
          
        }
      })
    })
  })
</script>
@endsection