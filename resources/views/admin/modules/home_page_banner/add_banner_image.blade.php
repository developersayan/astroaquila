@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Banner Image</title>
@endsection

@section('style')
@include('admin.includes.style')
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
                    <h4 class="pull-left page-title">Add Banner Image</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.home.page.banner')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Banner Image</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.home.page.banner.insert-image')}}" method="POST" id="image_form" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{@$data->id}}">
                                        <div class="form-group rm03">
                                            <label for="category_name">Heading</label>
                                            <input type="text" placeholder="Heading" id="heading" class="form-control" name="heading" >
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="category_name">Sub Heading</label>
                                            <input type="text" placeholder="Sub Heading" id="sub_heading" class="form-control" name="sub_heading" >
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="category_name">Button Link</label>
                                            <input type="text" placeholder="Button Link" id="button_link" class="form-control" name="button_link" >
                                        </div>

                                        <div class="form-group rm03">
                                            <label for="category_name">Button Caption</label>
                                            <input type="text" placeholder="Button Caption" id="button_caption" class="form-control" name="button_caption" >
                                        </div>

                                        <div class="form-group">
                                        <label for="Email">Banner Image (Recommended image dimension W X H : 1598 x 300)</label>
                                        <div class="uplodimgfil">
                                            <input type="file" name="image" accept="image/*" id="image" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="fun1()" />
                                           <label for="image">Upload Banner Image<img src="{{ URL::to('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                        </div>
                                       <div id="err_image"></div>

                                       <div class="uplodimgfilimg banner_image_preview ad_rbn_001" style="display: none;">
                                            <img src="" alt=""id="img2" style="height: 250px;width: 350px !important;margin-top: 25px;">
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
        function fun1(){
        var i=document.getElementById('image').files[0];
        //console.log(i);
        var b=URL.createObjectURL(i);
        $(".banner_image_preview").show();
        $("#img2").attr("src",b);
        }
        </script>


<script>
    $(document).ready(function(){
       $("#image_form").validate({
            rules: {
            image:{
            required:true,
            
           },

          },
          ignore:[],
          messages: {
                image: {
                    required:'Please upload banner image',
            },  
          },
          errorPlacement: function(error, element) {
            console.log("Error placement called");
            if (element.attr("name") == "image") {

                $("#err_image").append(error);
            }
        }

        });
    })
</script>

@endsection
