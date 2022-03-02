@extends('layouts.app')

@section('title')
<title>{{__('auth.seller_title')}}</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
    .file_label{
        height: 47px !important;
        padding: 0 12px !important;
        padding-right: 12px !important;
        padding-right: 20px !important;
        border-radius: 3px !important;
        color: #fff !important;
        font: 400 15px/49px 'Roboto', sans-serif !important;
        background: #fbbc93 !important;
        margin-top: 5px !important;
        text-align: left !important;
        cursor: pointer !important;
    }
</style>
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class="pad-114 pg-saller">
    <div class="login-body">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="main-center-div back_white">@include('includes.message')
                        <form action="{{route('seller.register.save')}}" method="POST" enctype="multipart/form-data" id="signup_form">
                            @csrf
                        <div class="login-from-area">
                            <h2>{{__('auth.seller_header')}}</h2>
                            <p>{{__('auth.seller_content')}}</p>
                            <div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="login-type" placeholder="{{__('auth.name_placeholder')}}" name="name">
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div>
                                <input type="email" class="login-type" placeholder="{{__('auth.email_address_placeholder')}}" name="email">
                                <div class="clearfix"></div>
                            </div>
                            <div>
                                <input type="text" class="login-type" placeholder="{{__('auth.mobile_number_placeholder')}}" name="mobile">
                                <div class="clearfix"></div>
                            </div>
                            <div>
                                <label>{{__('auth.address_placeholder')}}</label>
                                <textarea class="login-type" name="address"></textarea>
                                <div class="clearfix"></div>
                            </div>
                            <div>
                                <label>{{__('auth.sold_item_placeholder')}}</label>
                                <textarea class="login-type" name="description"></textarea>
                                <div class="clearfix"></div>
                            </div>
                            <div>
                                <div class="uplodimg marb-15">
                                    <div class="uplodimgfil signup-img" style="width: calc(100% );">
                                        <input type="file" id="file" name="file">
                                        <label for="file" class="file_label">Upload File<img src="{{ URL::to('public/frontend/images/clickhe.png')}}" alt=""></label>
                                    </div>
                                </div>
                            </div>

                            <div class="remmber-area">
                                    <p class="terms-para">{{__('auth.creating_account')}}<a href="#"> {{__('auth.terms_of_service')}} </a> {{__('auth.and')}} <a href="#"> {{__('auth.privacy_policy')}}</a>
                                    </p>
                                </div>
                                <button type="submit" class="login-submit">{{__('auth.sign_up')}}</button>
                        </div>
                        </form>
                    </div>
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
<!-- Time picek jas -->
<link rel='stylesheet' href='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css'>
<script src='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js'></script>
<script>
    $("input[name=time_of_birth]").clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        default: 'now',
        donetext: "Select",
        init: function() {
            console.log("colorpicker initiated");
        },
        beforeShow: function() {
            console.log("before show");
        },
        afterShow: function() {
            console.log("after show");
        },
        beforeHide: function() {
            console.log("before hide");
        },
        afterHide: function() {
            console.log("after hide");
        },
        beforeHourSelect: function() {
            console.log("before hour selected");
        },
        afterHourSelect: function() {
            console.log("after hour selected");
        },
        beforeDone: function() {
            console.log("before done");
        },
        afterDone: function() {
            console.log("after done");
        }
    });
</script>
<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
    $( "#datepicker" ).datepicker();
  } );
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
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
                name:{
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                    validate_email:true
                },
                mobile:{
                    required: true,
                    number: true ,
                    minlength: 8,
                    maxlength: 10
                },
                description:{
                    required: true,
                },
                address:{
                    required: true,
                }
            },
            messages: {
                name:{
                    required: '{{__('auth.required_name')}}',
                },
                email:{
                    email:'{{__('auth.valid_email')}}',
                    required:'{{__('auth.required_email')}}',
                    // remote:'The email is already exist'
                },
                mobile:{
                    required: '{{__('auth.required_mobile')}}',
                    number: '{{__('auth.number_mobile')}}',
                    minlength: '{{__('auth.minlength_mobile')}}',
                    maxlength: '{{__('auth.maxlength_mobile')}}',
                },
                description:{
                    required: '{{__('auth.required_description')}}',
                },
                address:{
                    required: '{{__('auth.required_address')}}',
                }
            },
        });
    })
</script>
@endsection
