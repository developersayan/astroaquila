@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Home Page Second Slider</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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
                    <h4 class="pull-left page-title">Manage Home Page Second Slider</h4>
                    <ol class="breadcrumb pull-right" id="add_image_icon">
                    <li class="active"><a href="{{route('admin.settings.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                                  </ol>
                     <ol class="breadcrumb pull-right" id="add_image_icon" @if(@$data->setting_type=="I") style="display: block;" @else style="display: none;" @endif>
                        <li class="active"><a href="{{route('admin.manage.home.page.banner.add-image.second')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Images</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    @include('admin.includes.message')
                                    <div class="row">
                             <form action="{{route('admin.manage.home.page.banner.save.settings.second')}}" method="post">
                              @csrf        
                              <div class="col-lg-4">          
                                  <div class="form-group">
                                                        <label for="FullName">Settings</label>
                                                          <div class="checkBox">

                                                          <ul>
                                                            <li>
                                                            <input type="radio" id="radio1"  name="type" value="V" @if(@$data->setting_type=="V") checked @endif>
                                                            <label for="radio1">Video</label>
                                                          </li>
                                                           <li>
                                                          <input type="radio" id="radio2"  name="type" value="I" @if(@$data->setting_type=="I") checked @endif>
                                                            <label for="radio2">Image</label>
                                                          </li>
                                                          </ul>
                                                        </div>
                                  </div>
                                </div>
                                <div class="col-lg-2" id="transition_style_div" @if(@$data->setting_type=="I") style="display: block;" @else style="display: none;" @endif>
                                <div class="form-group">
                                                      <label for="FullName">Transition In Style</label>
                                                     <select class="form-control  " name="transition_in" id="transition_in"  >
                                                      <option value="">Select Transition</option>
                                                      @foreach(@$animation as $value)
                                                      <option value="{{$value->name}}" @if(@$data->transition_in==$value->name) selected @endif>{{@$value->name}}</option>
                                                      @endforeach
                                                    </select>
                                                     <div id="error_category"></div>
                                   </div>
                                 </div>

                                 <div class="col-lg-2" id="transition_style_out_div" @if(@$data->setting_type=="I") style="display: block;" @else style="display: none;" @endif>
                                <div class="form-group">
                                                      <label for="FullName">Transition Out Style</label>
                                                     <select class="form-control  " name="transition_out" id="transition_out"  >
                                                      <option value="">Select Transition</option>
                                                      @foreach(@$animation as $value)
                                                      <option value="{{$value->name}}" @if(@$data->transition_out==$value->name) selected @endif>{{@$value->name}}</option>
                                                      @endforeach
                                                    </select>
                                                     <div id="error_category"></div>
                                   </div>
                                 </div>

                                 <div class="col-lg-2" id="speed_div" @if(@$data->setting_type=="I") style="display: block;" @else style="display: none;" @endif>
                                <div class="form-group">
                                                      <label for="FullName">Slider Speed (M S)</label>
                                                      <input type="number" name="speed" value="{{@$data->speed}}">
                                                     <div id="error_category" ></div>
                                   </div>
                                 </div>
                                 <div class="col-lg-2">
                                 <div class="form-group">
                                  <label for="FullName"></label>
                                  <div class="availability_check">
                                        <input id="disable_check" type="checkbox" value="D" name="disable_check" @if(@$data->enable_disable=="D") checked @endif>
                                        <label for="disable_check">Disable</label>
                                      </div>
                                 </div>
                               </div>
                               <div class="clearfix"></div>
                                 <div class="rm05" style="margin-top: -25px; margin-bottom: 25px;">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Save</button>
                                </div>


                                        
                            </form>
                </div>
                        
                        <div class="panel panel-default panel-fill" id="video_details" @if(@$data->setting_type=="V") style="display: block;" @else style="display: none;" @endif>
                            <div class="panel-heading">
                                <h3 class="panel-title">Video Details</h3>
                            </div>
                                <div class="panel-body rm02 rm04">
                                    <form role="form" action="{{route('admin.manage.home.page.banner.video-upload.second')}}" method="POST" id="video_form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{@$data->id}}">
                                        <div class="form-group rm03">
                                            <label for="category_name">Heading</label>
                                            <input type="text" placeholder="Heading" id="heading" class="form-control" name="heading" value="{{@$data->heading}}">
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="category_name">Sub Heading</label>
                                            <input type="text" placeholder="Sub Heading" id="sub_heading" class="form-control" name="sub_heading" value="{{@$data->sub_heading}}">
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="category_name">Button Link</label>
                                            <input type="text" placeholder="Button Link" id="button_link" class="form-control" name="button_link" value="{{@$data->button_link}}">
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="category_name">Button Caption</label>
                                            <input type="text" placeholder="Button Caption" id="button_caption" class="form-control" name="button_caption" value="{{@$data->button_caption}}">
                                        </div>

                                        <div class="row">
                                           <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="Email">Banner Video (Recommended video dimension : 1598 x 649)</label>
                                                <div class="uplodimgfil">
                                                  <input type="file"  id="file-2" class="inputfile inputfile-1" data-multiple-caption="{count} files selected"  accept="video/mp4
                                                  " name="video" onchange="fun2();">
                                                  <label for="file-2">Upload Video<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                <div class="error" id="video_error"></div>
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


                                    @if(@$data->video!="")
                                      <div class="row">
                                              <div class="col-lg-12">
                                          <div class="form-group">
                                          <label>Previous Uploaded Video</label>
                                          <div class="uplodimgfilimg_video ad_rbn_001 " >
                                              <video  id="video_preview" height="200" width="300" src="{{ URL::to('storage/app/public/banner_video')}}/{{@$data->video}}" controls></video>
                                          </div>
                                       
                                        </div>
                                      </div>
                                    </div>
                                    @endif
                                        
                                    <div class="clearfix"></div>
                                        <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                                    </form>

                                </div>
                            </div>


                                    <div class="table-responsive" id="image_details" @if(@$data->setting_type=="I") style="display: block;" @else style="display: none;" @endif>
                                      


                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Heading</th>
                                                    <th>Image</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$images->isNotEmpty())
                                                @foreach (@$images as $value)
                                                <tr>
                                                    <td>@if(@$value->heading!=""){{$value->heading}} @else -- @endif</td>
                                                   
                                                    <td>
                                                        @if(@$value->image!="")<img src="{{ URL::to('storage/app/public/banner_image')}}/{{@$value->image}}" class="widthimg80"> @else No Image @endif
                                                    </td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>                                                                
                                                                <li><a href="{{route('admin.manage.home.page.banner.edit.second',['id'=>@$value->id])}}">Edit</a></li>
                                                                
                                                                <li><a href="{{route('admin.manage.home.page.banner.delete.second',['id'=>@$value->id])}}"  onclick="return confirm('Do you want to delete this ?')">Delete</a></li>
																
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr><td colspan="4"><center> No Data </center></td></tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>


                                   


                                </div>
                            </div>
                        </div>
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
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    function fun2(){
    var i=document.getElementById('file-2').files[0];
    var b=URL.createObjectURL(i);
    $(".show_video").show();
    $("#video_preview").attr("src",b);
    }
</script>

<script>
    $(document).ready(function(){
       $("#video_form").validate({
            rules: {
            video:{
            required: function(element){
                var video = '{{@$data->video}}';
              if(video=="")
              return true;
              else
              return false;
             },
            
           },

          },
          ignore:[],
          messages: {
                video: {
                    required:'Please upload banner video',
            },  
          },
          errorPlacement: function(error, element) {
            console.log("Error placement called");
            if (element.attr("name") == "video") {

                $("#video_error").append(error);
            }
        }

        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function() {
 $('input[type=radio][name=type]').change(function() {
    if (this.value == 'V') {
      $('#transition_style_div').hide();
      $('#transition_style_out_div').hide();
      $('#speed_div').hide();
     }else{
      $('#transition_style_div').show();
      $('#transition_style_out_div').show();
      $('#speed_div').show();
     } 
   });
});
</script>

{{-- <script type="text/javascript">
$(document).ready(function() {
 $('input[type=radio][name=type]').change(function() {
    if (this.value == 'V') {
                $('#video_details').css('display','block');
                $('#image_details').css('display','none');
                $('#add_image_icon').css('display','none');
               }else{
                 $('#video_details').css('display','none');
                 $('#image_details').css('display','block');
                 $('#add_image_icon').css('display','block');
               }
    $.ajax({
        url:"{{route('admin.manage.home.page.banner.update-settings')}}",
        method:"GET",
        data:{' setting_type':this.value},
        success: function(res) {
            console.log(res);
            // return false;
        }
    });


 });
  
 });
 </script> --}}

<script>
    $(document).ready(function(){
  @foreach (@$images as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
});
</script>


@endsection
