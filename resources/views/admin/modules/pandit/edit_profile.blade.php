@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Pundit Profile</title>
@endsection

@section('style')
@include('admin.includes.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.min.css') }}" rel="stylesheet" />
<style type="text/css">
  .form-group span {
    font-size: 15px;
    color: #8a8a8a;
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
<style type="text/css">

</style>
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
  <!-- Start right Content here --> 
  <!-- ============================================================== -->
  <div class="content-page"> 
    <!-- Start content -->
    <div class="content">
      <div class="container"> 
        
        <!-- Page-Title -->
        <div class="row">
          <div class="col-sm-12">
            <h4 class="pull-left page-title">Edit Pundit</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.pandit')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                        <div class="col-lg-12"> 
                           <div class="astro_bac_list">
                          <ul>
                            <li class="actv"><a href="{{route('admin.astrologer.edit-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            Basic Info</a></li>
                             <li ><a href="{{route('admin.pundit.edit-puja-view',['id'=>@$data->id])}}">
                                 <img src="{{ URL::to('public/frontend/images/bacicon5.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon55.png')}}" class="bacicon2" alt="">
                                Puja</a></li>

                             <li>
                            <a href="{{route('admin.pundit.edit-zipcode-view',['id'=>@$data->id])}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Service Area</a>
                          </li>   
                            
                            <li><a href="{{route('admin.pundit.edit-avail',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Availability</a></li>
                          </ul>
                        </div>
                        @include('admin.includes.message')  
                        <div> 
                           
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Edit Pundit</h3> 
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                      <form role="form" id="edit_profile" method="post" enctype="multipart/form-data" action="{{route('admin.pundit.update-profile')}}">
                                          @csrf
                                          <input type="hidden" name="user_id" value="{{@$data->id}}">
                                           <div class="row">
                                          <div class="col-lg-12">
                                          <div class="form-group">
                                              <label for="FullName">Availability</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio5" class="avail_select" name="availability" value="Y" @if(@$data->user_availability=='Y') checked="" @endif>
                                                  <label for="radio5">Yes</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio6" class="avail_select" name="availability" value="N" @if(@$data->user_availability=='N') checked="" @endif>
                                                  <label for="radio6">No</label>
                                                </li>
                                                </ul>
                                                {{-- <div><label id="gender-error" class="error" for="gender"></label></div> --}}
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                            <div class="form-group">
                                                <label for="FullName">First name</label>
                                                <input type="text" placeholder="First name" id="name" name="first_name" class="form-control" value="{{@$data->first_name}}">
                                                <div class="error" id="name_error"></div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="FullName">Last Name</label>
                                                <input type="text" placeholder="Last Name" name="last_name" class="form-control" value="{{@$data->last_name}}">
                                                <div class="error" id="price_error"></div>
                                            </div>

                                             <div class="form-group">
                                                <label for="FullName">Email</label>
                                                <input type="text" placeholder="Email" name="email" class="form-control" id="email" value="{{@$data->email}}">
                                                <div class="error" id="price_error"></div>
                                            </div>

                                             <div class="form-group">
                                                <label for="FullName">Mobile No</label>
                                                <input type="text" placeholder="Mobile No" name="mobile" class="form-control" id="mobile" value="{{@$data->mobile}}">
                                                <div class="error" id="price_error"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group">
                                              <label for="FullName">Gender</label>
                                                <div class="checkBox">
                                                
                                                <ul>
                                                  <li>
                                                  <input type="radio" id="radio1" class="gender_select" name="gender" value="M" @if(@$data->gender=='M') checked="" @endif>
                                                  <label for="radio1">Male</label>
                                                </li>
                                                 <li>
                                                <input type="radio" id="radio2" class="gender_select" name="gender" value="F" @if(@$data->gender=='F') checked="" @endif>
                                                  <label for="radio2">Female</label>
                                                </li>
                                                </ul>
                                                <div><label id="gender-error" class="error" for="gender"></label></div>
                                              </div>
                                            </div>

                                            



                                             
                                            
                                            

                                           



                                            <div class="form-group">
                                                <label for="Email">Profile Image</label>
                                                <div class="uplodimgfil" style="margin-top: 10px;">
                                                  {{-- <input type="file" name="image" id="file-1" class="inputfile inputfile-1" onchange="fun1()" data-multiple-caption="{count} files selected" multiple /> --}}
                                                  <input type="hidden" name="profile_picture" id="profile_picture">
                                            <input type="file" id="file-1" name="profile_pic" >
                                                  <label for="file-1">Upload Image<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                 <label for="profile_pic" id="image-error" class="error"></label>
                                            </div>

                                          <div class="form-group" style="position: relative;">
                                        <a class="del_image del-custom-class" data-id="{{@$data->id}}" @if(@$data->profile_img=='') style="display:none " @endif > <i class="fa fa-times" aria-hidden="true"></i> </a>
                                          <div class="uplodimgfilimg ">
                                            <em><img src="{{ URL::to('storage/app/public/profile_picture')}}/{{@$data->profile_img}}" alt="" id="img2"></em>
                                          </div>
                                       
                                        </div>


                                        

                                         
                            
                                          <div class="form-group">
                                              <label>Puja Type</label>
                                              <select name="puja_type" class="form-control">
                                                  <option value="">Select Puja Type</option>
                                                 <option value="ONLINE" @if(old('puja_type')=='ONLINE' || @$data->puja_type =='ONLINE' ) Selected @endif>Online</option>
                                               <option value="OFFLINE" @if(old('puja_type')=='OFFLINE' || @$data->puja_type =='OFFLINE') Selected @endif>Offline</option>
                                               <option value="BOTH" @if(old('puja_type')=='BOTH' || @$data->puja_type =='BOTH') Selected @endif>Both</option>
                                              </select>
                                            </div>
                
                                            
                                            
                                        <div class="form-group rm03">
                                                <label for="AboutMe">About</label>
                                                <textarea style="height: 80px" id="AboutMe" name="about" class="form-control">{{@$data->about}}</textarea>
                                                <div class="error" id="description_error"></div>
                                        </div>

                                    <div class="form-group rm03">   
                                     <h4>Address Information</h4>
                                   </div>

                                   <div class="form-group">
                                                <label for="FullName">Country</label>
                                              <select class="form-control rm06 basic-select" name="country" id="country">
                                               <option value="">Select Country</option>
                                                
                                                @foreach(@$countries as $country)
                                                 <option value="{{@$country->id}}" @if($data->country_id==@$country->id)selected @endif>{{@$country->name}}</option>
                                                 @endforeach
                                                 
                                              </select>
                                                <div class="error" id="price_error"></div>
                                    </div>

                                    <div class="form-group">
                                                <label for="FullName">State</label>
                                                <select class="form-control rm06 basic-select" name="state" id="states">
                                               <option value="">Select State</option>
                                                
                                                @foreach(@$states as $state)
                                                 <option value="{{@$state->id}}" @if($data->state==@$state->id)selected @endif>{{@$state->name}}</option>
                                                 @endforeach
                                                 
                                              </select>
                                                <div class="error" id="price_error"></div>
                                    </div>

                                     <div class="form-group">
                                                <label for="FullName">City</label>
                                                <input type="text" placeholder="City" name="city" class="form-control" value="{{@$data->city}}">
                                                <div class="error" id="price_error"></div>
                                    </div>

                                    <div class="form-group">
                                                <label for="FullName">Pincode</label>
                                                <input type="text" placeholder="Pincode" name="pincode" class="form-control" value="{{@$data->pincode}}">
                                                <div class="error" id="price_error"></div>
                                    </div>

                                    <div class="form-group rm03">
                                                <label for="FullName">Address</label>
                                                <input type="text" placeholder="Address" name="address" class="form-control" value="{{@$data->address}}">
                                                <div class="error" id="price_error"></div>
                                    </div>

                                  <div class="form-group rm03">   
                                     <h4>Account Information</h4>
                                  </div>

                                   <div class="form-group">
                                                <label for="FullName">Bank Name</label>
                                                <input type="text" placeholder="Bank Name" name="bank_name" class="form-control" value="{{@$data->userAccount->bank_name}}">
                                                <div class="error" id="price_error"></div>
                                    </div>

                                    <div class="form-group">
                                                <label for="FullName">A/C No</label>
                                                <input type="text" placeholder="A/C No" name="ac_no" class="form-control" value="{{@$data->userAccount->ac_no}}">
                                                <div class="error" id="price_error"></div>
                                    </div>

                                    <div class="form-group ">
                                                <label for="FullName">IFSC Code</label>
                                                <input type="text" placeholder="IFSC Code" name="ifsc" class="form-control" value="{{@$data->userAccount->ifsc_code}}">
                                                <div class="error" id="price_error"></div>
                                    </div>

                                     <div class="form-group ">
                                                <label for="FullName">Name of account holder</label>
                                                <input type="text" placeholder="Name of account holder" name="name_of_account_holder" class="form-control" value="{{@$data->userAccount->account_holder}}">
                                                <div class="error" id="price_error"></div>
                                    </div>

                                    <div class="clearfix"></div>
                                     <div class="form-group ">
                                                <label for="FullName">Account Type</label>
                                                 <select class="form-control rm06 basic-select" name="profile_type" id="category">
                                               <option value="">Select Account Type</option>
                                                <option value="S" @if(@$data->Ac_Type=="S") selected @endif>Savings</option>
                                                <option value="C" @if(@$data->Ac_Type=="C") selected @endif>Current</option>
                                                 
                                              </select>
                                                <div class="error" id="price_error"></div>
                                    </div>

                                    <div class="form-group ">
                                                <label for="FullName">Gst No (optional)</label>
                                                <input type="text" placeholder="Gst No" name="gst_no" class="form-control" value="{{@$data->gst_no}}">
                                                <div class="error" id="price_error"></div>
                                    </div>


                                            
                            <input type="hidden" name="expertise" id="expertise">
                            <input type="hidden" name="language" id="language">       
                                            

                            <div class="clearfix"></div>
                              <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                        </form>

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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
<script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script type="text/javascript">
  $('.del_image').on('click',function(e){
    if(confirm("Do You want remove this image?")){
    var id = $(this).data('id');
    $('#image_url').val('');
    $('#icon').val('');
    $('#profile_picture').val('');
    $.ajax({
      url:'{{route('admin.astrologer.delete.profile.picture')}}',
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
    $("#file-1").change(function () {
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
                    $("#file").val('');
                    return false;
                }
                
                $("#croppie-modal").modal("show");
                uploadCrop = $('.croppie-div').croppie({
                    viewport: { width: 256, height: 256, type: 'square' },
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
            }

        });
</script>
<script>
    $(document).ready(function(){
      jQuery.validator.addMethod("validate_email", function(value, element) {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }, "Please enter valid email");
        $("#edit_profile").validate({
            rules: {
                first_name:{
                    required: true,
                },
                last_name:{
                    required: true,
                },
                email:{
                  required:true,
                  validate_email:true,
                   remote: {
                          url:  '{{route('admin.pundit.check-email')}}',
                          type: "POST",
                          data: {
                            email: function() {
                              return $( "#email").val() ;
                            },
                            _token: '{{ csrf_token() }}',
                            id:'{{@$data->id}}',
                          }
                   },
                },
                puja_type:{
                  required:true,
                },
                mobile:{
                  required:true,
                  minlength: 10,
                  maxlength: 10,
                  number:true,
                   remote: {
                          url:  '{{route('admin.pundit.check-mobile')}}',
                          type: "POST",
                          data: {
                            mobile: function() {
                              return $( "#mobile").val() ;
                            },
                            _token: '{{ csrf_token() }}',
                            id:'{{@$data->id}}',
                          }
                   },
                },
                state:{
                    required: true,
                },
                city:{
                    required: true,
                },
                address:{
                    required:true,
                },
                country:{
                    required: true,
                },
                profile_pic:{
                    required: true,
                },
                about:{
                    required: true,
                },
                bank_name:{
                    required: true,
                },
                ac_no:{
                    required: true,
                    number: true ,
                    maxlength: 16,
                },
                ifsc:{
                    required: true,
                },
                name_of_account_holder:{
                    required: true,
                },
                
                profile_type:{
                  required:true,
                },
                pincode:{
                  required:true,
                  minlength:6,
                  maxlength:6,
                  number:true,
                },
                 gst_no:{
                  minlength:15,
                  maxlength:20,
                },
            },
            messages: {
                first_name:{
                    required: 'Please enter your first name',
                },
                email:{
                  required:'Please enter your email',
                  validate_email:'Please enter your email properly',
                  remote:'Email already exits.Try another',

                },
                puja_type:{
                  required:'Please select puja type',
                },
                mobile:{
                  required:'Please enter your mobile number',
                  remote:'Mobile no already exits.Try another',
                  minlength:'Mobile number must be 10digits',
                  maxlength:'Mobile number must be 10digits',
                },
                last_name:{
                    required: 'Please enter your last name'
                },
                state:{
                    required: 'please select your state',
                },
                address:{
                    required:'Please enter your address',
                },
                city:{
                    required: 'Please enter your city',
                },
                country:{
                    required: 'Please select your country',
                },
                pincode:{
                  required:'Please enter your pincode',
                  minlength:'Please enter your pincode properly',
                  maxlength:'Please enter your pincode properly',
                  number:'Please enter your pincode properly',  
                },
                profile_pic:{
                    required: 'Please upload an image',
                },
                about:{
                    required: 'Please enter about',
                },
                bank_name:{
                    required: 'Please enter bank name',
                },
                profile_type:{
                    required: 'Please select account type',
                },
                ac_no:{
                    required: 'Please enter account number',
                    number: 'Please enter account number properly' ,
                    maxlength: 'Bank Account number not greater than 16 digit',
                },
                ifsc:{
                    required: 'Please enter ifsc code',
                },
                name_of_account_holder:{
                    required: 'Please enter account holder name',
                },
                 gst_no:{
                  minlength:'Please enter atleast 15 characters',
                  maxlength:'Gst number should not be greater than 20 characters',
                },
                
            },
             submitHandler:function(form){
                var img = $('#profile_picture').val();
                var old ='{{@$data->profile_img}}';
                var expertise = $('#expertise').val();
                var language = $('#language').val();
                console.log(old);

                var gender_select = $('.gender_select').val();
                if ($(".gender_select:checked").length > 1 || $(".gender_select:checked").length == 0){
                  $('#gender-error').html('Please select your gender');
                  $('#gender-error').css('display','block');
                  return false;
                }


                if(img== '' && old==''){
                    $('#image-error').html('Please upload your profile pic');
                    $('#image-error').css('display', 'block');
                    return false;
                }
                
                else {
                   
                        form.submit();
                   
                }
            }
        });

    })
</script>



 <script type="text/javascript">
  $(document).ready(function(){
    $('#country').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.pundit.getstate')}}',
        type:'GET',
        data:{country:id,id:'{{@$data->state}}'},
        success:function(data){
          console.log(data);
      $('#states').html(data.state);
        }
      })
    })
  })
</script>
@endsection  