@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Horoscope</title>
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
  input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
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
                    <h4 class="pull-left page-title">Add Horoscope</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.horoscope')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Horoscope</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.horoscope.add')}}" method="POST" id="horoscope_form" enctype="multipart/form-data">
                                    @csrf
                                   <div class="form-group ">
                                                <label for="FullName">Horoscope code</label>
                                                <input type="text" placeholder="Horoscope code" id="code" name="code" class="form-control">
                                                <div class="error" id="code_error"></div>
                                   </div>

                                   <div class="form-group">
                                                  <label for="FullName">Select Category</label>
                                                 <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                  <option value="">Select Category</option>
                                                  @foreach(@$category as $value)
                                                    <option value="{{@$value->id}}">{{@$value->name}}</option>
                                                    @endforeach
                                                    
                                                 </select>
                                                 <div id="error_category"></div>
                                    </div>

                                    <div class="form-group">
                                                  <label for="FullName">Select Sub Category</label>
                                                 <select class="form-control rm06 basic-select" name="sub_category_id" id="sub_category_id">
                                                  <option value="">Select Category</option>
                                                 </select>
                                                 <div id="error_category"></div>
                                    </div>

                                    <div class="form-group rm03">
                                                <label for="FullName">Horoscope Title</label>
                                                <select class="form-control rm06 basic-select" name="title_id" id="title_id">
                                                  <option value="">Select Title</option>
                                                  @foreach(@$title as $value)
                                                    <option value="{{@$value->id}}">{{@$value->title}}</option>
                                                    @endforeach
                                                    
                                                 </select>
                                                 <div id="error_title_id"></div>
                                     </div>

                                    <div class="form-group rm03">
                                                <label for="FullName">Horoscope Name</label>
                                                <input type="text" placeholder="Horoscope Name" id="name" name="name" class="form-control">
                                                <div class="error" id="name_error"></div>
                                     </div>

                                     <div class="form-group rm03">
                                                <label for="AboutMe">Horoscope Description</label>
                                                <textarea style="height: 80px"  name="about_report" class="form-control" placeholder="Description" id="description"></textarea>
                                                <div class="error" id="brief_error"></div>
                                     </div>

                                     <div class="form-group">
                                                <label for="FullName">Horoscope Price INR</label>
                                                <input type="text" placeholder="Horoscope Price INR" name="price_inr" class="form-control">
                                                <div class="error" id="price_error_inr"></div>
                                    </div>

                                    <div class="form-group">
                                                <label for="FullName">Horoscope Price USD</label>
                                                <input type="text" placeholder="Horoscope Price USD" name="price_usd" class="form-control">
                                                <div class="error" id="price_error_usd"></div>
                                    </div>

                                     <div class="form-group">
                                                <label for="FullName">Discount Percentage In INR (%) </label>
                                                <input type="text" name="discount_inr"  placeholder="Discounted Percentage INR" class="form-control"  value="{{old('discount')}}">
                                                 <span id="error_discount_inr"></span>
                                            </div>
                                          
                                           

                                        
                                            <div class="form-group">
                                                <label for="FullName">Discount Percentage In USD (%) </label>
                                                <input type="text" name="discount_usd"  placeholder="Discounted Percentage USD" class="form-control"  value="{{old('discount')}}">
                                                 <span id="error_discount_usd"></span>
                                            </div>

                                            
                                            <div class="clearfix"></div>
                                            
                                            

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
                                                    <option value="PR">Partially Refundable</option>
                                                 </select>
                                                 <div id="error_refundable_status"></div>
                                              </div>

                                              {{-- <div class="clearfix"></div> --}}

                                              <div class="form-group">
                                             
                                               <label for="FullName">Select Expertise </label>
                                             
                                             <select class="chosen-select form-control" multiple="multiple" data-placeholder="Select Expertise" name="expertise[]" id="expertise">
                                                @foreach($expertise as $value )
                                                <option value="{{ @$value->id }}">{{@$value->expertise_name}}</option>
                                                @endforeach
                                              </select>
                                            </div>

                                            <div class="clearfix"></div>
                                             <div class="form-group">
                                              <label for="FullName">Horoscope Deliverable</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio22"  name="is_deliverable" value="Y" checked="">
                                                  <label for="radio22">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio23"  name="is_deliverable" value="N" >
                                                  <label for="radio23">No</label>
                                                </li>
                                                </ul>
                                              </div>
                                            </div>





                                          <div id="delivery_price">

                                            <div class="form-group">
                                                <label for="FullName">Delivery Days In India</label>
                                                <input type="number" placeholder="Delivery Days In India" name="delivery_days_india" class="form-control" id="delivery_days_india">
                                                <div class="error" id="delivery_days_india_error"></div>
                                            </div>

                                            <div class="form-group">
                                                <label for="FullName">Delivery Days Outside India</label>
                                                <input type="number" placeholder="Delivery Days Outside India" name="delivery_days_outside_india" class="form-control" id="delivery_days_outside_india">
                                                <div class="error" id="delivery_days_outside_india_error"></div>
                                            </div>


                                            <div class="form-group">
                                                <label for="FullName">Delivery  Price INR</label>
                                                <input type="number" placeholder="Delivery Price INR" name="delivery_price_inr" class="form-control" id="delivery_price_inr">
                                                <div class="error" id="error_delivery_price_inr"></div>
                                            </div>

                                             <div class="clearfix"></div>

                                            <div class="form-group">
                                                <label for="FullName">Delivery Price USD</label>
                                                <input type="number" placeholder="Delivery Price USD" name="delivery_price_usd" class="form-control" id="delivery_price_usd">
                                                <div class="error" id="error_delivery_price_usd"></div>
                                            </div>
                                          </div>

                                            {{-- <div class="form-group rm03">
                                                <label for="AboutMe">Remedy Your Problem</label>
                                                <textarea style="height: 80px"  name="remedy_your_problem" class="form-control" placeholder="Remedy Your Problem"></textarea>
                                                <div class="error" id="remedy_your_problem_error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Personalized Report</label>
                                                <textarea style="height: 80px"  name="personalized_report" class="form-control" placeholder="Personalized Report"></textarea>
                                                <div class="error" id="personalized_report_error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Planetary Movements & Positions</label>
                                                <textarea style="height: 80px"  name="planetary_movements_positions" class="form-control" placeholder="Planetary Movements & Positions"></textarea>
                                                <div class="error" id="planetary_movements_positions_error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Get Report via Email</label>
                                                <textarea style="height: 80px"  name="get_report" class="form-control" placeholder="Get Report via Email"></textarea>
                                                <div class="error" id="get_report_error"></div>
                                            </div> --}}

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading One *</label>
                                                <input type="text" placeholder="Heading One " name="heading_one" class="form-control new-form" value="Remedy Your Problem">
                                                <div id="error_heading_one"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description One *</label>
                                                <textarea style="height: 80px"  name="description_one" class="form-control" placeholder="Description One" id="description_one"></textarea>
                                                <div class="error" id="error_description_one"></div>
                                            </div>




                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading Two *</label>
                                                <input type="text" placeholder="Heading Two " name="heading_two" class="form-control new-form" value="Personalized Report">
                                                <div id="error_heading_two"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description Two *</label>
                                                <textarea style="height: 80px"  name="description_two" class="form-control" placeholder="Description Two" id="description_two"></textarea>
                                                <div class="error" id="error_description_two"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading Three *</label>
                                                <input type="text" placeholder="Heading Three " name="heading_three" class="form-control new-form" value="Planetary Movements & Positions">
                                                <div id="error_heading_three"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description Three *</label>
                                                <textarea style="height: 80px"  name="description_three" class="form-control" placeholder="Description Three" id="description_three"></textarea>
                                                <div class="error" id="error_description_three"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading Four *</label>
                                                <input type="text" placeholder="Heading Four " name="heading_four" class="form-control new-form" value="Get Report via Email">
                                                <div id="error_heading_four"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description Four *</label>
                                                <textarea style="height: 80px"  name="description_four" class="form-control" placeholder="Description Three" id="description_four"></textarea>
                                                <div class="error" id="error_description_four"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading Five</label>
                                                <input type="text" placeholder="Wealth Predictions based on Vedic Astrology" name="heading_five" class="form-control new-form" id="heading_five">
                                                <div id="error_heading_five" class="error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description Five</label>
                                                <textarea style="height: 80px"  name="description_five" class="form-control" placeholder="Description Five" id="description_five"></textarea>
                                                <div class="error" id="error_description_five"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading Six</label>
                                                <input type="text" placeholder=" Best and Accurate Solutions" name="heading_six" class="form-control new-form" id="heading_six">
                                                <div id="error_heading_six" class="error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description Six</label>
                                                <textarea style="height: 80px"  name="description_six" class="form-control" placeholder="Description Six" id="description_six"></textarea>
                                                <div class="error" id="error_description_six"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading Seven</label>
                                                <input type="text" placeholder="Assistance from Experienced Astrologers" name="heading_seven" class="form-control new-form" id="heading_seven">
                                                <div id="error_heading_seven" class="error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description Seven</label>
                                                <textarea style="height: 80px"  name="description_seven" class="form-control" placeholder="Description Seven" id="description_seven"></textarea>
                                                <div class="error" id="error_description_seven"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Heading Eight</label>
                                                <input type="text" placeholder="Get Timely Delivery" name="heading_eight" class="form-control new-form" id="heading_eight">
                                                <div id="error_heading_eight" class="error"></div>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Description Eight</label>
                                                <textarea style="height: 80px"  name="description_eight" class="form-control" placeholder="Description Eight" id="description_eight"></textarea>
                                                <div class="error" id="error_description_eight"></div>
                                            </div>


                                            <div class="form-group rm03">
                                                <label for="AboutMe">Significance</label>
                                                <textarea style="height: 80px"  name="significance" class="form-control" placeholder="Significance" id="significance"></textarea>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Who/How/When</label>
                                                <textarea style="height: 80px"  name="who_how_when" class="form-control" placeholder="Significance" id="who_how_when"></textarea>
                                            </div>

                                            {{-- <div class="form-group rm03">
                                                <label for="AboutMe">Related Mantra</label>
                                                <textarea style="height: 80px"  name="related_mantra" class="form-control" placeholder="Significance" id="related_mantra"></textarea>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Usage</label>
                                                <textarea style="height: 80px"  name="usages" class="form-control" placeholder="Usage" id="usages"></textarea>
                                            </div> --}}



                                            








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
                                                <label for="Email">Horoscope Image</label>
                                                 <div class="uplodimgfil">
                                                  <input type="file" id="icon" name="image"  class="inputfile inputfile-1">
                                                 <input type="hidden" name="profile_picture" id="profile_picture">
                                                <label for="icon">Upload Horoscope Image<img src="{{ URL::to('public/admin/assets/images/clickhe.png')}}" alt=""></label>
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
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')
<script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
<script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
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
    $(document).ready(function(){
       $("#horoscope_form").validate({
            rules: {
                code: {
                   required:true,
                    remote: {
                     url: '{{ route("admin.manage.horoscope.check.code") }}',
                     type: "post",
                     data: {
                       code: function() {
                       return $( "#code" ).val();
                       },
                       _token: '{{ csrf_token() }}'
                     }
                  }
              },
               category_id: {
                   required:true,
              },
              name: {
                   required:true,
              },
              title_id:{
                required:true
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
           // delivery_price_inr:{
           //  // required:true,
           //      number:true,
           //      min:1,
           // },
           // delivery_price_usd:{
           //  // required:true,
           //      number:true,
           //      min:1,
           // },
           discount_inr:{
              number:true,
              max:99,
            },
           discount_usd:{
              number:true,
              max:99,
            },
            // delivery_days_india:{
            //     // required:true,
            //     number:true,
            //     min:1,
            // },
            // delivery_days_outside_india:{
            //     // required:true,
            //     number:true,
            //     min:1,
            // },
            heading_one:{
              required:true,
            },
           
            heading_two:{
              required:true,
            },
           

           heading_three:{
              required:true,
            },
           

           heading_four:{
              required:true,
            },
           

           image:{
            required:true,
            extension:'jpg|jpeg|png|gif',
           },
           refundable_status:{
              required:true,
           },

           



          },
       ignore: [],     
        messages: {
           code: {
                required:'Please enter horoscope code',
                remote:'Horoscope Code Already Exists',
            },
            category_id: {
                required:'Please select horoscope category',
            },
            title_id:{
                required:'Please select title of horoscope',
            },
            name: {
                required:'Please enter horoscope name',
            },
            about_report: {
                required:'Please enter brief about the report',
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

           delivery_price_inr:{
            required:'Please enter delivery price in USD',
            number:'Please enter number',
            min:'Please enter price properly',
           },
           delivery_price_usd:{
            required:'Please enter delivery price in USD',
            number:'Please enter number',
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
           delivery_days_india:{
            required:'Please enter delivery days in india',
            number:'Please enter days properly',
            min:'Please enter days properly',
           },
           delivery_days_outside_india:{
            required:'Please enter delivery days in india',
            number:'Please enter days properly',
            min:'Please enter days properly',
           },
           heading_one:{
            required:'Please enter heading one',
           },
           


           heading_two:{
            required:'Please enter heading two',
           },
           

           heading_three:{
            required:'Please enter heading three',
           },
          

           heading_four:{
            required:'Please enter heading four',
           },
           

           heading_five:{
            required:'Please enter heading five',
           },

           


           image:{
            required:'Please upload horoscope image',
           },
           refundable_status:{
                required:'Please select refundable status',
           },

        },
        errorPlacement: function(error, element) {
            console.log("Error placement called");
            if (element.attr("name") == "code") {
               
                $("#code_error").append(error);
            }
            else if (element.attr("name") == "name") {
               
                $("#name_error").append(error);
            }
            else if (element.attr("name") == "title_id") {
               
                $("#error_title_id").append(error);
            }
            else if (element.attr("name") == "category_id") {
               
                $("#error_category").append(error);
            }
            else if (element.attr("name") == "about_report") {
               
                $("#brief_error").append(error);
            }
            else if (element.attr("name") == "price_inr") {
               
                $("#price_error_inr").append(error);
            }
             else if (element.attr("name") == "price_usd") {
               
                $("#price_error_usd").append(error);
            }
            else if (element.attr("name") == "discount_inr") {
                $("#error_discount_inr").append(error);
            }
            else if (element.attr("name") == "discount_usd") {
                $("#error_discount_usd").append(error);
            }
            else if (element.attr("name") == "delivery_days_india") {
                $("#delivery_days_india_error").append(error);
            }
            else if (element.attr("name") == "delivery_days_outside_india") {
                $("#delivery_days_outside_india_error").append(error);
            }
            else if (element.attr("name") == "heading_one") {
                $("#error_heading_one").append(error);
            }
            
            else if (element.attr("name") == "heading_two") {
                $("#error_heading_two").append(error);
            }
            else if (element.attr("name") == "description_two") {
                $("#error_description_two").append(error);
            }

             else if (element.attr("name") == "heading_three") {
                $("#error_heading_three").append(error);
            }
            else if (element.attr("name") == "description_three") {
                $("#error_description_three").append(error);
            }

             else if (element.attr("name") == "heading_four") {
                $("#error_heading_four").append(error);
            }
            else if (element.attr("name") == "description_four") {
                $("#error_description_four").append(error);
            }

            else if (element.attr("name") == "delivery_price_inr") {
                $("#error_delivery_price_inr").append(error);
            }

            else if (element.attr("name") == "delivery_price_usd") {
                $("#error_delivery_price_usd").append(error);
            }


           


            else if (element.attr("name") == "image") {
                $("#image_error").append(error);
            }
            else if (element.attr("name") == "refundable_status") {
                $("#error_refundable_status").append(error);
            }
        },

        submitHandler: function(form){
            $('#brief_error').html('');
            $('#error_description_one').html('');
            $('#error_description_two').html('');
            $('#error_description_three').html('');
            $('#error_description_four').html('');
            $('#error_description_five').html('');
            $('#error_description_six').html('');
            $('#error_description_seven').html('');
            $('#error_description_eight').html('');
            $('#error_heading_five').html('');
            $('#error_heading_six').html('');
            $('#error_heading_seven').html('');
            $('#error_heading_eight').html('');
            var delivery = $('input[type=radio][name=is_deliverable]:checked').val();
            var expertise = $('#expertise :selected').length;
            if (expertise==0) 
            {
            alert('Please select atleast one expertise');
            return false;
            }
            if (delivery=="Y" && $('#delivery_days_india').val()=='') {
              alert('Plese enter delivery days in india');
              return false;
            }

            if (delivery=="Y" && $('#delivery_days_outside_india').val()=='') {
              alert('Plese enter delivery days outside india');
              return false;
            }

            if (delivery=="Y" && $('#delivery_price_inr').val()=='') {
              alert('Plese enter delivery price india');
              return false;
            }

            if (delivery=="Y" && $('#delivery_price_inr').val()<1) {
              alert('Plese enter delivery price inr properly');
              return false;
            }

            

            if (delivery=="Y" && $('#delivery_price_usd').val()=='') {
              alert('Plese enter delivery price outside india');
              return false;
            }

            if (delivery=="Y" && $('#delivery_price_usd').val()<1) {
              alert('Plese enter delivery price usd properly');
              return false;
            }



            if ($('#sub_category_id option').length > 1 && $('#sub_category_id').val()==""){
                alert('Please select sub category');
                return false;
            }
            if(tinyMCE.get('description').getContent()==""){
              alert('Please enter about of this horoscope')
              $('#brief_error').append('<p>Please enter about of this horoscope</p>');
              return false;
            }

            if(tinyMCE.get('description_one').getContent()==""){
              alert('Please enter description one')
              $('#error_description_one').append('<p>Please enter description one</p>');
              return false;
            }

            if(tinyMCE.get('description_two').getContent()==""){
              alert('Please enter description two')
              $('#error_description_two').append('<p>Please enter description two</p>');
              return false;
            }

            if(tinyMCE.get('description_three').getContent()==""){
              alert('Please enter description three')
              $('#error_description_three').append('<p>Please enter description three</p>');
              return false;
            }

            if(tinyMCE.get('description_four').getContent()==""){
              alert('Please enter description four')
              $('#error_description_four').append('<p>Please enter description four</p>');
              return false;
            }



            // optional
            if($('#heading_five').val()!="" && tinyMCE.get('description_five').getContent()==""){
              alert('Please enter description five as you enter heading five ')
              $('#error_description_five').append('<p>Please enter description five as you enter heading five</p>');
              return false;
            }

            if($('#heading_five').val()=="" && tinyMCE.get('description_five').getContent()!=""){
              alert('Please enter heading five as you enter description five ')
              $('#error_heading_five').append('<p>Please enter heading five as you enter description five</p>');
              return false;
            }



            if($('#heading_six').val()!="" && tinyMCE.get('description_six').getContent()==""){
              alert('Please enter description six as you enter heading six ')
              $('#error_description_six').append('<p>Please enter description six as you enter heading six</p>');
              return false;
            }

            if($('#heading_six').val()=="" && tinyMCE.get('description_six').getContent()!=""){
              alert('Please enter heading six as you enter description six ')
              $('#error_heading_six').append('<p>Please enter heading six as you enter description six</p>');
              return false;
            }


            if($('#heading_seven').val()!="" && tinyMCE.get('description_seven').getContent()==""){
              alert('Please enter description seven as you enter heading seven ')
              $('#error_description_seven').append('<p>Please enter description seven as you enter heading seven</p>');
              return false;
            }

            if($('#heading_seven').val()=="" && tinyMCE.get('description_seven').getContent()!=""){
              alert('Please enter heading seven as you enter description seven ')
              $('#error_heading_seven').append('<p>Please enter heading seven as you enter description seven</p>');
              return false;
            }



            if($('#heading_eight').val()!="" && tinyMCE.get('description_eight').getContent()==""){
              alert('Please enter description eight as you enter heading eight ')
              $('#error_description_eight').append('<p>Please enter description eight as you enter heading eight</p>');
              return false;
            }

            if($('#heading_eight').val()=="" && tinyMCE.get('description_eight').getContent()!=""){
              alert('Please enter heading eight as you enter description eight ')
              $('#error_heading_eight').append('<p>Please enter heading eight as you enter description eight</p>');
              return false;
            }

            form.submit();


          }

        });
    })
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


  $('input[type=radio][name=is_deliverable]').change(function() {
   if (this.value == 'Y') {
    $('#delivery_price').css('display','block');
   }else{
     $('#delivery_price').css('display','none');
   }
 });
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
  $(document).ready(function(){
    $('#category_id').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.manage.horoscope.get-sub-category')}}',
        type:'GET',
        data:{category:id,},
        success:function(data){
          console.log(data);
          $('#sub_category_id').html(data.subcategories);
          
        }
      })
    })
  })
</script>
@endsection
