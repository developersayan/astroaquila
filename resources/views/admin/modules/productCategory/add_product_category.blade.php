@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Product Category</title>
@endsection

@section('style')
@include('admin.includes.style')
<link href="{{ URL::asset('public/frontend/croppie/croppie.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.min.css') }}" rel="stylesheet" />
<style type="text/css">
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
                    <h4 class="pull-left page-title">Manage Product Category</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.product.category.manage')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Product Category</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.product.category.add.save')}}" method="POST" id="productCategoryFrom" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="category_name">Category name</label>
                                        <input type="text" placeholder="Category name" id="category_name" class="form-control" name="category_name" required>
                                        <div id="err_category"></div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <label for="Email">Category Image</label>
                                        <div class="uplodimgfil">
                                            {{-- <input type="file" name="icon" id="icon" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="fun1()" /> --}}
                                            <input type="file" id="icon" name="image"  class="inputfile inputfile-1">
                                             <input type="hidden" name="profile_picture" id="profile_picture">
                                            <label for="icon">Upload Category Image<img src="{{ URL::to('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                        </div>
                                       <div id="err_icon"></div>
                                  </div>
                                  <div class="form-group">
                                       
                                          <div class="uplodimgfilimg ">
                                            <em><img src="" alt="" id="img2"></em>
                                          </div>
                                        
                                        </div>
                                  <div class="clearfix"></div>
                                    <div class="form-group rm03">
                                        <label for="description">Category description</label>
                                        <textarea style="height: 80px" id="description" class="form-control" name="description" placeholder="Category description" ></textarea>
                                    </div>



                                    <div class="form-group rm03">
                                        <label for="meta_title">Meta title </label>
                                        <input type="text" placeholder="Meta title" id="meta_title" class="form-control new-form" name="meta_title" >
                                    </div>
                                    <div class="form-group rm03">
                                        <label for="meta_description">Meta description</label>
                                        <textarea style="height: 80px" id="meta_description" class="form-control" name="meta_description" placeholder="Meta description" ></textarea>
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
    var i=document.getElementById('icon').files[0];
    var b=URL.createObjectURL(i);
    $("#img2").attr("src",b);
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
       
        $.validator.addMethod('filesize', function (value, element, arg) {
            // if(element.files[0].size<=arg){
            //     return true;
            // }else{
            //     return false;
            // }
            // console.log(value);
            // console.log(element.files.length);
            // return false;
            if(element.files.length == 0)
                return true;
            else {
                // console.log(element.files[0].size);
                if(element.files[0].size<=arg){
                    return true;
                }else{
                    return false;
                }
                // return false;
            }

        });
        $("#productCategoryFrom").validate({
            rules: {
                category_name: {
                   required:true,
                   remote: {
                          url:  '{{route('admin.product.checkname')}}',
                          type: "POST",
                          data: {
                            category_name: function() {
                              return $( "#category_name").val() ;
                            },
                            _token: '{{ csrf_token() }}',
                          }
               },
           },
           icon: {
            required:false,
            extension:'jpg|jpeg|png|gif',
            // filesize: 2000000, 
           },
          },
              ignore: [],
        messages: {
                category_name: {
                    required:'Please enter category name',
                    remote:'Category name already exits',
            },  
            icon: {
            extension:'Please upload valid image',
            filesize: 'File size should be under 2MB', 
           },  
        },
        errorPlacement: function(error, element) {
            console.log("Error placement called");
            if (element.attr("name") == "category_name") {
               
                $("#err_category").append(error);
            }
            else if (element.attr("name") == "icon") {
                console.log(error);
                console.log($("#err_icon")[0]);
                $("#err_icon").append(error);
            }
        }
          // submitHandler:function(form){
          //       var img = $('#icon').val();
                
          //       var ext=img.substring(img.lastIndexOf("."),img.length);
          //       var extl = ext.toLowerCase();
          //       if(!extl.match(/.(jpg|jpeg|png|gif)$/i) && $('#icon').val().length != 0){
          //               $('#image-error').html('Please enter an image only');
          //               $('#image-error').css('display', 'block');
          //               return false;
          //         }
          //       else if(){

          //       }  

               

          //         else {
          //               form.submit();
          //           }
                
          //   }
        });
    })
</script>
<script type="text/javascript">
    
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
@endsection
