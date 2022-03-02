@extends('layouts.app')

@section('title')
<title>{{__('auth.pundits_sign_up_title')}}</title>
@endsection

@section('style')
@include('includes.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('public/frontend/croppie/croppie.min.css') }}" rel="stylesheet" />
<style>
    .error {
        color: red;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class="pad-114">
    <div class="login-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main-center-div back_white">@include('includes.message')
                        <form action="{{route('pundit.register.submit')}}" method="POST" enctype="multipart/form-data" id="signup_form">
                            @csrf
                            <div class="login-from-area">
                                <h2>{{__('auth.sign_up_as_a_pundits')}}</h2>
                                <p>{{__('auth.sign_up_pundits_content')}}</p>
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="login-type" placeholder="{{__('auth.first_name_placeholder')}}" name="first_name" value="{{ old('first_name') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="login-type" placeholder="{{__('auth.last_name_placeholder')}}" name="last_name" value="{{ old('last_name') }}">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                                <div>
                                    <input type="email" class="login-type" placeholder="{{__('auth.email_address_placeholder')}}" name="email" value="{{ old('email') }}" id="email">
                                    <div class="clearfix"></div>
                                </div>
                                <div>
                                    <input type="tel" class="login-type" placeholder="{{__('auth.mobile_number_placeholder')}}" name="mobile" value="{{ old('mobile') }}" id="mobile">
                                    <div class="clearfix"></div>
                                </div>
                                {{-- <div>
                                    <input type="text" class="login-type" placeholder="{{__('auth.city_placeholder')}}" name="city" value="{{ old('city') }}">
                                    <div class="clearfix"></div>
                                </div> --}}
                                {{-- <div>
                                    <div class="checkBox d-flex sign-astro new-cus">
                                        <span>{{__('auth.gender_placeholder')}}</span>
                                        <ul>
                                            <li>
                                                <input type="radio" id="radio1" name="gender" value="M" checked="">
                                                <label for="radio1">{{__('auth.male_placeholder')}}</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="radio2" name="gender" value="F" @if(old('gender')=='F' ) checked="" @endif>
                                                <label for="radio2">{{__('auth.female_placeholder')}}</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div> --}}

                                <div>
                                    <input type="text" class="login-type" placeholder="{{__('auth.experience_placeholder')}}" name="experience" value="{{ old('experience') }}">

                                </div>
                                <div class="marb20">
                                    <select class="login-type log-select " name="puja_type">
                                        <option value="" >{{__('auth.select_puja_type_placeholder')}}</option>
                                        <option value="ONLINE" @if(old('puja_type')=='ONLINE')  Selected @endif>{{__('auth.online')}}</option>
                                        <option value="OFFLINE"@if(old('puja_type')=='OFFLINE')  Selected @endif>{{__('auth.offline')}}</option>
                                        <option value="BOTH" @if(old('puja_type')=='BOTH')  Selected @endif>{{__('auth.both')}}</option>
                                    </select>
                                </div>

                                <div>
                                    <div class="uplodimg marb-15">
                                        <div class="uplodimgfil signup-img">

                                            {{-- <input type="file" name="profile_pic" id="profile_pic" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" accept="image/*" onchange="fun1()">
                                            <input type="file" id="file" name="profile_pic"> --}}
                                            <input type="hidden" name="profile_picture" id="profile_picture">
                                            <input type="file" id="file" name="profile_pic" >
                                            <label for="file">{{__('auth.upload_profile_pic')}}<img src="{{ URL::to('public/frontend/images/clickhe.png')}}" alt="" ></label>
                                        </div>

                                        <div class="uplodimgfilimg newupimg pad0">
                                            <em><img  alt="" id="img2"></em>
                                        </div>
                                    </div>
                                    <label for="profile_pic" id="image-error" class="error"></label>
                                </div>
                                <div class="password-in">
                                    <input type="password" class="login-type" name="password" placeholder="{{__('auth.password_placeholder')}}">
                                    <div class="clearfix"></div>
                                </div>
                                <div class="birth-details">
                                    <h3>{{__('auth.address_information')}}</h3>
                                    <div>
                                        <select class="login-type log-select " name="country" id="country">
                                            <option value="">{{__('auth.select_country_placeholder')}}</option>
                                            @foreach ($allCountry as $country)
                                            <option value="{{$country->id}}" @if(old('country')==$country->id) selected @endif>{{$country->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="birth-details">
                                        <select class="login-type log-select " name="state" id="state">
                                            <option value="">Select State</option>

                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="birth-details">
                                        <select class="login-type log-select " name="city" id="city">
                                            <option value="">Select City</option>

                                        </select>
                                        <label id="city-error" class="error" for="city"></label>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div>
                                                    <input type="text" class="login-type" placeholder="Post code" id="pincode" name="pincode" value="{{ old('pincode') }}">
                                                    <label id="pincode-error" class="error" for="pincode"></label>
                                                </div>

                                            </div>
                                            <div class="col-md-12" id="areaDropDiv" style="display: none">
                                                <select class="login-type log-select " name="area_drop" id="areaDrop">
                                                    <option value="">Select Area</option>

                                                </select>
                                                <label id="areaDrop-error" class="error" for="areaDrop"></label>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="col-md-12" id="areaTextDiv" style="display: none">
                                                <input type="text" class="login-type" placeholder="Area" id="areaText" name="area" value="{{ old('area') }}">
                                                <label id="areaText-error" class="error" for="areaText"></label>
                                                <div class="clearfix"></div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div>
                                                <input type="text" class="login-type" placeholder="{{__('auth.city_placeholder')}}" name="city" value="{{ old('city') }}">
                                                </div>
                                            </div> --}}
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>

                                    <div>
                                        <input type="text" class="login-type" placeholder="Address " name="address">
                                        <div class="clearfix"></div>
                                    </div>
                                </div>




                                <div class="remmber-area">
                                    <p class="terms-para">{{__('auth.creating_account')}} <a href="#">{{__('auth.terms_of_service')}}</a>
                                        {{__('auth.and')}} <a href="#"> {{__('auth.privacy_policy')}}</a>
                                    </p>
                                </div>
                                <button type="submit" id="signup" class="login-submit">{{__('auth.sign_up')}}</button>
                                <div class="bottom-account-div">
                                    <p>{{__('auth.already_have_an_account')}}<a href="{{route('login')}}"> {{__('auth.sign_in')}}</a></p>
                                </div>
                                <div class="logfoot">
                                    <ul>
                                        <li>
                                            <a href="{{route('astrologer.register')}}">{{__('auth.sign_up_as_a_astrologer')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{route('register')}}">{{__('auth.sign_up_as_a_customer')}}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
</section>

@endsection



@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
<script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
   <script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
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

            });
        });
    });
    $("#file").change(function () {
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
{{-- @include('includes.toaster') --}}
<script>
    function fun1(){
    var i=document.getElementById('file').files[0];
    var b=URL.createObjectURL(i);
    $("#img2").attr("src",b);
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
{{-- @if(session()->get('lang')==2) --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_ar.min.js"></script> --}}
{{-- @endif --}}
<script>
    $(document).ready(function(){
        jQuery.validator.addMethod("validate_email", function(value, element) {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }, "{{__('auth.valid_email')}}");
        $("#signup_form").validate({
            rules: {
                first_name:{
                    required: true,
                },
                last_name:{
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                    validate_email:true,
                    remote: {
                        url: '{{ route("check.email") }}',
                        dataType: 'json',
                        type:'post',
                        data: {
                            email: function() {
                                return $('#email').val();
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    },
                },
                password:{
                    required: true,
                    minlength: 8
                },
                mobile:{
                    required: true,
                    number: true ,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: '{{ route("check.mobile") }}',
                        dataType: 'json',
                        type:'post',
                        data: {
                            mobile: function() {
                                return $('#mobile').val();
                            },
                            _token: '{{ csrf_token() }}'
                        }
                    },
                },
                experience:{
                    required: true,
                    number: true ,
                    min:1,
                    max:99,
                },
                call_price:{
                    required: true,
                    number: true ,
                },
                state:{
                    required: true,
                },
                city:{
                    required: true,
                },
                country:{
                    required: true,
                },
                profile_pic:{
                    required: true,
                },
                puja_type:{
                    required: true,
                },
                address:{
                    required:true,
                },
                pincode:{
                    required:true,
                    minlength:6,
                    maxlength:6,
                    number:true,
                }
            },
            messages: {
                first_name:{
                    required: '{{__('auth.required_first_name')}}',
                },
                last_name:{
                    required: '{{__('auth.required_last_name')}}'
                },
                email:{
                    email:'{{__('auth.valid_email')}}',
                    required:'{{__('auth.required_email')}}',
                    remote:'{{__('auth.unique_email')}}'
                },
                password:{
                    required:'{{__('auth.required_password')}}',
                    minlength: '{{__('auth.minlength_password')}}'
                },
                mobile:{
                    required: '{{__('auth.required_mobile')}}',
                    number: '{{__('auth.number_mobile')}}',
                    minlength: '{{__('auth.mobile_properly')}}',
                    maxlength: '{{__('auth.mobile_properly')}}',
                    remote:'{{__('auth.unique_mobile')}}'
                },
                experience:{
                    required: '{{__('auth.required_experience')}}',
                    number: '{{__('auth.number_experience')}}' ,
                    min:'{{__('profile.minLength_of_experience')}}',
                    max:'{{__('profile.maxLength_of_experience')}}',
                },
                call_price:{
                    required: '{{__('auth.required_call_price')}}',
                    number: '{{__('auth.number_call_price')}}' ,
                },
                state:{
                    required: 'Please Select your state',
                },
                city:{
                    required: '{{__('auth.required_city')}}',
                },
                country:{
                    required: '{{__('auth.required_country')}}',
                },
                profile_pic:{
                    required: '{{__('auth.required_profile_pic')}}',
                },
                puja_type:{
                    required: '{{__('auth.required_puja_type')}}',
                },
                address:{
                    required:'Enter your address',
                },
                pincode:{
                    required:'{{__('profile.pincode_required')}}',
                    minlength:'{{__('profile.pincode_properly')}}',
                    maxlength:'{{__('profile.pincode_properly')}}',
                    number:'{{__('profile.pincode_properly')}}',
                }
            },
            // submitHandler:function(form){
            //     var img = $('#profile_picture').val();
            //     if(img== '' ){
            //         $('#image-error').html('{{__('profile.required_profile_pic')}}');
            //         $('#image-error').css('display', 'block');
            //         return false;
            //     } else {
            //         // var ext=img.substring(img.lastIndexOf("."),img.length);
            //         // var extl = ext.toLowerCase();
            //         // if(!extl.match(/.(jpg|jpeg|png|gif)$/i)){
            //         //     $('#image-error').html('Please enter an image only');
            //         //     $('#image-error').css('display', 'block');
            //         //     return false;
            //         // } else {
            //             form.submit();
            //         // }
            //     }
            // }
        });


        $('#country').change(function(){
            const countryId = $(this).val();
            $('#state').html('');
            if (countryId != "") {
                  $.ajax({
                          url: "{{route('get.state')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  countryId: countryId,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.result) {
                              const res = response.result;
                              console.log(res);
                              $('#state').append('<option value="" selected>Select state</option>');
                              $.each(res, function (i, v) {
                                  $('#state').append('<option value="' + v.id + '"">' + v.name + '</option>');
                              })
                          }
                      })
                      .fail(function (error) {
                          $('#state').html('<option value="" selected>Select state</option>');
                      });
              } else {
                  $('#state').html('<option value="" selected>Select state</option>');
              }
        });

        $('#state').change(function(){
            const state = $(this).val();
            $('#city').html('');
            if (state != "") {
                  $.ajax({
                          url: "{{route('get.city')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  state_id: state,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.result) {
                              const res = response.result;
                              $('#city').append('<option value="" selected>Select city</option>');
                              $.each(res, function (i, v) {
                                  $('#city').append('<option value="' + v.id + '"">' + v.name + '</option>');
                              })
                          }
                      })
                      .fail(function (error) {
                          $('#city').html('<option value="" selected>Select city</option>');
                      });
              } else {
                  $('#city').html('<option value="" selected>Select state</option>');
              }
        });
        $('#pincode').change(function(){
            var pincode = $(this).val();
            var country = $('#country').val();
            var state = $('#state').val();
            var city = $('#city').val();
            $.ajax({
                url: "{{route('get.area')}}",
                method: 'POST',
                data: {
                    jsonrpc: 2.0,
                    _token: "{{ csrf_token() }}",
                    params: {
                        pincode: pincode,
                        country: country,
                        state: state,
                        city: city,
                    },
                },
                dataType: 'JSON'
            })
            .done(function (response) {
                if (response.postcode == 1) {

                    $('#pincode-error').html('')
                    $('#pincode-error').hide();
                    //$('#areaTextDiv').hide()
                    const res = response.result;
                    var select = '';
                    select += '<option value="">Select Area</option>';
                    if(response.result.length >0){
                        $.each(res, function (i, v) {
                            select += '<option value="' + v.id + '"">' + v.area + '</option>';
                        })
                    }

                    select += '<option value="O">Other</option>';
                    $('#areaDrop').html(select);
                    $('#areaDropDiv').show()
                    $('#signup').show();
                }else{
                    $('#pincode-error').html('This postcode not available , please try other postcode')
                    $('#pincode-error').show();
                    //$('#areaTextDiv').show()
                    $('#areaDropDiv').hide()
                    $('#signup').hide();
                }
            })
        });
        $('#areaDrop').on('change',function(){
            var area = $(this).val();
            if(area == 'O'){
                $('#areaTextDiv').show()
            }else{
                $('#areaTextDiv').hide()
            }
        })
    })
</script>
@endsection
