@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Gemstone Sub Title</title>
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
                    <h4 class="pull-left page-title">Add Gemstone Sub Title</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.gemstone.title')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Gemstone Sub Title</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.gemstone.title.sub-title-update')}}" method="POST" id="pujacat" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{@$data->id}}">
                                    <div class="form-group">
                                    <label for="FullName">Parent Title</label>
                                    <select class="form-control rm06 basic-select" name="title" id="title">
                                        <option value="">Select Title</option>
                                        @foreach(@$title as $value)
                                        <option value="{{@$value->id}}" @if(@$data->parent_id==@$value->id) selected @endif>{{@$value->title}}</option>
                                        @endforeach
                                    </select>
                                  </div>

                                    <div class="form-group">
                                        <label for="category_name">Sub Title</label>
                                        <input type="text" placeholder="Title" id="subtitle" class="form-control" name="subtitle" required value="{{@$data->title}}">
                                        <div id="err_category"></div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <label for="Email">Sub Title Image</label>
                                        <div class="uplodimgfil">
                                            {{-- <input type="file" name="icon" id="icon" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="fun1()" /> --}}
                                            <input type="file" id="icon" name="image"  class="inputfile inputfile-1">
                                             <input type="hidden" name="profile_picture" id="profile_picture">
                                            <label for="icon">Upload Sub Title Image<img src="{{ URL::to('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                        </div>
                                       <div id="err_icon"></div>
                                  </div>

                                   <div class="form-group" style="position: relative;">
                                       <a class="del_image del-custom-class" data-id="{{@$data->id}}" @if(@$data->image=='') style="display:none " @endif > <i class="fa fa-times" aria-hidden="true"></i></a>
                                          <div class="uplodimgfilimg ">
                                            <em><img src="{{ URL::to('storage/app/public/gemstone_title')}}/{{@$data->image}}" alt="" id="img2"></em>
                                          </div>
                                        
                                  </div>


                                        
                                  <div class="clearfix"></div>
                                    
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

<script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
  $('.del_image').on('click',function(e){
    if(confirm("Do You want remove this image?")){
    var id = $(this).data('id');

    $('#icon').val('');
    $('#profile_picture').val('');
    $.ajax({
      url:'{{route('admin.manage.gemstone.title.image.delete')}}',
      type: "POST",
      data:{
         id:id,
        _token: '{{ csrf_token() }}',
      },

      success: function(res) {
        $("#img2").attr("src",'');
        $('.uplodimgfilimg').hide();
        $('.del_image').hide();
      }  
  });
  }
  })
</script>
<script>
    $(document).ready(function(){
       $("#pujacat").validate({
        rules: {
             title: {
                   required:true,
              },
              subtitle:{
                required:true,
              },
          },
            
        messages: {
            title: {
                required:'Please select title',
             },
             subtitle:{
                required:'Please enter sub title',
             },  
          },
          submitHandler: function(form){
            var title = $('#title').val();
            var subtitle = $('#subtitle').val();
            var id = '{{@$data->id}}';
                 $.ajax({
                         url:"{{route('admin.manage.gemstone.subtitle.check.name')}}",
                         method:"GET",
                         data:{'title':title,'subtitle':subtitle,'id':id},
                         success: function(res) {
                         console.log(res);  
                         // return false;
                          if (res=="found") {
                         alert('Sub Title  already exits in this title');
                         return false;
                         }else{
                          form.submit();                  
                        }
                    }
                }); 
          }  

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
             $('.del_image').hide();
            $('#profile_picture').val('');
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
                 $('.del_image').show();

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
