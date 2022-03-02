@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | EditEdit DataBank</title>
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
                    <h4 class="pull-left page-title">Edit DataBank</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.data.bank')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Edit DataBank</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.data.bank.update')}}" method="POST" id="data_bank" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{@$data->id}}">
                                   <div class="form-group ">
                                                <label for="FullName">Name</label>
                                                <input type="text" placeholder="Name" id="name" name="name" class="form-control" value="{{@$data->name}}">
                                                <div class="error" id="error_name"></div>
                                   </div>

                                   <div class="form-group ">
                                                <label for="FullName">Date Of Birth</label>
                                                <input type="text" placeholder="dob" id="datepicker" name="dob" class="form-control" value="{{@$data->dob}}">
                                                <div class="error" id="error_dob"></div>
                                   </div>

                                   <div class="form-group ">
                                                <label for="FullName">Place Of Birth</label>
                                                <input type="text" placeholder="Place Of Birth" id="place_of_birth" name="place_of_birth" class="form-control" value="{{@$data->place_of_birth}}">
                                                <div class="error" id="error_place_of_birth"></div>
                                   </div>

                                   <div class="clearfix"></div>

                                   

                                  

                                   

                                    <div class="form-group">
                                                <label for="FullName">Country</label>
                                                <select class="form-control rm06 basic-select" name="country" id="country">
                                                  <option value="">Select Country</option>
                                                  @foreach(@$country as $value)
                                                    <option value="{{@$value->id}}" @if(@$data->country_id==@$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach
                                                 </select>
                                                 <div id="error_country"></div>
                                     </div>

                                     <div class="form-group">
                                                <label for="FullName">State</label>
                                                <select class="form-control rm06 basic-select" name="state" id="state">
                                                  <option value="">Select State</option>
                                                  @foreach(@$state as $value)
                                                    <option value="{{@$value->id}}" @if(@$data->state_id==@$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                 <div id="error_state"></div>
                                     </div>

                                     <div class="form-group">
                                                <label for="FullName">City</label>
                                                <select class="form-control rm06 basic-select" name="city" id="city">
                                                  <option value="">Select City</option>
                                                  @foreach(@$city as $value)
                                                    <option value="{{@$value->id}}" @if(@$data->city_id==@$value->id) selected @endif>{{@$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                 <div id="error_city"></div>
                                     </div>
                                     <div class="clearfix"></div>

                                     <div class="form-group">
                                                <label for="FullName">Profession</label>
                                                <select class="form-control rm06 basic-select" name="profession_id" id="profession_id">
                                                  <option value="">Select Profession</option>
                                                  @foreach(@$profession as $value)
                                                  <option value="{{@$value->id}}" @if(@$data->profession_id==@$value->id) selected @endif>{{@$value->name}}</option>
                                                  @endforeach
                                                  <option id="profession_other" value="others">Others</option>
                                                </select>
                                                 <div id="error_profession_id"></div>
                                     </div>

                                     <div class="form-group" id="profession_other_div">
                                      <label for="FullName">Name Of Profession</label>
                                      <input type="text" placeholder="Name Of Profession" id="profession" name="profession" class="form-control">
                                      <div id="error_profession"></div>
                                     </div>

                                     <div class="form-group">
                                                <label for="FullName">Famous For</label>
                                                <select class="form-control rm06 basic-select" name="famous_id" id="famous_id">
                                                  <option value="">Select</option>
                                                  @foreach(@$famous as $value)
                                                  <option value="{{@$value->id}}" @if(@$data->famous_id==@$value->id) selected @endif>{{@$value->name}}</option>
                                                  @endforeach
                                                  <option id="famous_other" value="others">Other</option>
                                                </select>
                                                 <div id="error_famous_id"></div>
                                     </div>

                                     <div class="form-group" id="famous_other_div">
                                      <label for="FullName">Name Of Famous For</label>
                                      <input type="text" placeholder="Name Of Famous For" id="famous" name="famous" class="form-control">
                                      <div id="error_famous"></div>
                                     </div>

                                     <div class="col-sm-12" style="margin-bottom:10px;">
                                      <div class="form-group">
                                        <label for="Email">File Upload</label>
                                        <div class="uplodimg">
                                          <div class="uplodimgfil">
                                            <input type="file" onchange="PreviewImage();" id="file" name="file_upload" class="file_upload" accept="application/pdf">
                                                                  <label for="file">Upload<img src="{{ URL::to('public/frontend/images/clickhe.png')}}" alt="" ></label>
                                          </div>
                                        </div>
                                           </div>  
                                           <div class="form-group " id="file_name_show" style="display: none; width: 100%">
                                             <label >Pdf Name : <b id="file_name"></b></label>
                                           </div>    
                                           @if(@$data->file_upload!="")
                                           <div class="form-group" id="preview">
                                             <label >Download Previous Pdf</label> &nbsp;<a class="del_pdf" data-id="{{@$data->id}}" > <i class="fa fa-times" aria-hidden="true"></i> Delete</a></span>
                                            <a style="color: white" class="btn btn-success" href="{{route('admin.manage.data.bank.download.pdf',['file'=>@$data->file_upload])}}">Download Pdf</a>
                                            <span>
                                            
                                         </div>


                                         @endif         
                                      </div>

                                    
                                       <div class="row">
                                              <div class="col-lg-12">
                                                <input type="hidden" id="image_url" value="{{@$data->image}}">
                                            <div class="form-group">
                                                <label for="Email">Person Image</label>
                                                 <div class="uplodimgfil">
                                                  <input type="file" id="icon" name="image"  class="inputfile inputfile-1">
                                                 <input type="hidden" name="profile_picture" id="profile_picture">
                                                <label for="icon">Upload Person Image<img src="{{ URL::to('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                    </div>
                                                <div class="error" id="image_error"></div>
                                            </div>

                                           <div class="form-group" style="position: relative;">
                                       <a class="del_image del-custom-class" data-id="{{@$data->id}}" @if(@$data->image=='') style="display:none " @endif > <i class="fa fa-times" aria-hidden="true"></i> </a>
                                          <div class="uplodimgfilimg ">
                                            <em><img src="{{ URL::to('storage/app/public/dataBank')}}/{{@$data->image}}" alt="" id="img2"></em>
                                          </div>

                                         
                                        
                                        </div>
                                      </div>
                                    </div>

                                    <div class="form-group rm03">
                                                <label for="AboutMe">Description</label>
                                                <textarea style="height: 400px" id="mytextarea" placeholder="Blog   description" class="form-control" name="description">{{@$data->description}}</textarea>
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
    selector: "#mytextarea",
    forced_root_block : "",
    relative_urls : false,
    entity_encoding: 'raw',

    
     plugins: [
    
    "searchreplace wordcount visualblocks visualchars code fullscreen link",
    "lists",
  
    
    "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft     aligncenter alignright alignjustify | bullist numlist outdent indent | link     image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    toolbar3: "cut,copy,paste,pastetext,pasteword,|outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,insertdate,inserttime,preview",
    toolbar4: "numlist bullist,link",
    image_advtab: true,
    templates: [
    {title: 'Test template 1', content: 'Test 1'},
    {title: 'Test template 2', content: 'Test 2'}
    ]
    });
    
    </script>
<script type="text/javascript">
  $('#famous_other_div').hide();
  $('#profession_other_div').hide();
  // $("#famous").rules("remove","required");
  // $("#profession").rules("remove","required");
</script>

<script type="text/javascript">
  $('.del_image').on('click',function(e){
    if(confirm("Do You want remove this image?")){
    var id = $(this).data('id');
    $('#image_url').val('');
    $('#icon').val('');
    $('#profile_picture').val('');
    $.ajax({
      url:'{{route('admin.manage.data.bank.delete.image')}}',
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

<script type="text/javascript">
  $('.del_pdf').on('click',function(e){
    if(confirm("Do You want remove this pdf ?")){
    var id = $(this).data('id');
    $('#preview').hide();
    $.ajax({
      url:'{{route('admin.manage.data.bank.delete.pdf')}}',
      type: "POST",
      data:{
         id:id,
        _token: '{{ csrf_token() }}',
      },

      success: function(res) {
        $('.del_pdf').hide();
      }  
  });
  }
  })
</script>


<script type="text/javascript">
  $( function() {
        $( "#datepicker" ).datepicker({
           maxDate:'-1D',
          changeYear: true,
          changeMonth: true,
          yearRange: "1930:2021",
        });
   });
</script>

<script type="text/javascript">
              function PreviewImage() {
                pdffile=document.getElementById("file").files[0].name;
                $('#file_name_show').show();
                $('#file_name').html('');
                $('#file_name').append(pdffile);
                pdffile_url=URL.createObjectURL(pdffile);
                
           }
        </script>


        <!-- get-subjects -->
        <script type="text/javascript">
          $(document).ready(function(){
            $('#country').on('change',function(e){
              e.preventDefault();
              var id = $(this).val();
              $.ajax({
                url:'{{route('admin.manage.data-bank.get-state')}}',
                type:'GET',
                data:{id:id},
                success:function(data){
                  console.log(data);
                  $('#state').html(data.state);
                  $('#city').html('<option>Select City</option>');
                }
              })
            })
          })
        </script>

        <!-- get-years -->
         <script type="text/javascript">
          $(document).ready(function(){
            $('#state').on('change',function(e){
              e.preventDefault();
              var id = $(this).val();
              $.ajax({
                url:'{{route('admin.manage.data-bank.get-city')}}',
                type:'GET',
                data:{id:id},
                success:function(data){
                  console.log(data);
                  $('#city').html(data.city);
                }
              })
            })
          })
        </script>

<script type="text/javascript">
  $('#profession_id').on('change',function(e){
    if ($('#profession_id').val()=="others") {
      $('#profession_other_div').show();
      // $("#profession").add("remove", "required");
    }else{
      $('#profession_other_div').hide();
      $('#profession').val('');
      // $("#profession").rules("remove", "required");
    }
  });

    $('#famous_id').on('change',function(e){
    if ($('#famous_id').val()=="others") {
      $('#famous_other_div').show();
      $("#famous").add("remove", "required");
    }else{
      $('#famous_other_div').hide();
      // $("#famous").rules("remove", "required");
      $('#famous').val('');
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
            $('#profile_picture').val('');
            $('#image_url').val('');
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

<script type="text/javascript">
    $("#data_bank").validate({
           rules: {
         
            name: {
                   required:true,
            },
            dob:{
              required:true,
            },
            place_of_birth:{
              required:true,
            },
            country:{
              required:true,
            },
            state:{
              required:true,
            },
            city:{
              required:true,
           },
           profession_id:{
              required:true,
           },
           profession:{
             remote: {
               url: '{{ route("admin.manage.data.bank.check-profession") }}',
               type: "post",
               data: {
                 profession: function() {
                 return $( "#profession" ).val();
                 },
                 _token: '{{ csrf_token() }}'
               }
               }
           },
           famous_id:{
              required:true
           },
           famous:{
              remote: {
               url: '{{ route("admin.manage.data.bank.check-famous") }}',
               type: "post",
               data: {
                 famous: function() {
                 return $( "#famous" ).val();
                 },
                 _token: '{{ csrf_token() }}'
               }
               }
           },
           // image:{
           //  required:true,
           //  extension:'jpg|jpeg|png|gif',
           // },
           
        },
        ignore: [],
        messages: {
      
          name: {
            required:'Please enter the name of person',
          },  
          dob:{
            required:'Please enter date of birth',
          },
          place_of_birth:{
            required:'Please enter place of birth',
          },
          country:{
            required:'Please select country',
          },
          state:{
            required:'Please select state',
          },
          city:{
            required:'Please select city',
          },
          profession_id:{
            required:'Please select profession',
          },
          profession:{
            remote:'Profession name already added',
          },
          famous_id:{
            required:'Please select famous for',
            
          },
          famous:{
            remote:'Famous name already added',
          },

          image: {
           required:'Please upload person image',
           extension:'Please choose valid image files (jpeg, png, gif,jpg) only.',
         },  
           
        },

        submitHandler: function(form){
          var profession = $('#profession_id').val();
          var famous = $('#famous_id').val();
          $("#error_profession").html('');
          $("#error_famous").html('');
          if(tinyMCE.get('mytextarea').getContent()==""){
              alert('Please write description');
              return false;
            }
          if ($('#profile_picture').val()=='' &&  $('#image_url').val()=='') {
              alert('Please upload image');
              return false;
            }

          if (profession=="others" && $('#profession').val()=='') {
            $("#error_profession").html('<p class="error">Please enter profession name</p>');
            return false;
          }
          if (famous=="others" && $('#famous').val()=='') {
            $("#error_famous").html('<p class="error">Please enter famous name</p>');
            return false;
          }
          form.submit();
        }, 
        
        errorPlacement: function(error, element) {
            console.log("Error placement called");
      
          if (element.attr("name") == "name") {
               
                $("#error_name").append(error);
            }
            else if (element.attr("name") == "dob") {
               
                $("#error_dob").append(error);
            }
            else if (element.attr("name") == "place_of_birth") {
               
                $("#error_place_of_birth").append(error);
            }
            else if (element.attr("name") == "country") {
                $("#error_country").append(error);
            }
            else if (element.attr("name") == "state") {
                $("#error_state").append(error);
            }
             else if (element.attr("name") == "city") {
                $("#error_city").append(error);
            }
            else if (element.attr("name") == "profession_id") {
                $("#error_profession_id").append(error);
            }
            else if (element.attr("name") == "profession") {
                $("#error_profession").append(error);
            }
            else if (element.attr("name") == "famous_id") {
                $("#error_famous_id").append(error);
            }
            else if (element.attr("name") == "famous") {
                $("#error_famous").append(error);
            }
            else if (element.attr("name") == "image") {
                $("#image_error").append(error);
            }
            
            


        }
});
   
</script>


@endsection
