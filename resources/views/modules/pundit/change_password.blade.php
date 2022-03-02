@extends('layouts.app')

@section('title')
<title>{{__('profile.change_password_title')}}</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
</style>
@endsection

@section('header')
{{-- @include('includes.heder_profile') --}}
@include('includes.header')
@endsection

@section('body')
<div class="dashboard_sec">
    <div class="container">
        <div class="dashboard_iner">
            @include('includes.profile_sidebar')

            <div class="astro-dash-pro-right">
                <h1>{{__('profile.change_password_label')}}</h1>
                <div class="astro-dash-right_iner">@include('includes.message')
                    <form action="{{route('pundit.change.password.save')}}" method="post" id="change_password_from" >
                        @csrf
                        <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.current_password_label')}}</label>
                                        <input type="password" placeholder="{{__('profile.current_password_placeholder')}}" name="old_password" id="old_password" >
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.new_password_label')}}</label>
                                        <input type="password" placeholder="{{__('profile.new_password_placeholder')}}" name="new_password" id="new_password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.confirm _password_label')}}</label>
                                        <input type="password" placeholder="{{__('profile.confirm _password_placeholder')}}" name="new_password_confirmation" id="new_password_confirmation">
                                    </div>
                                </div>
                            </div>

                            <div class="save_coniBx">
                                <div class="save_coniBx_left">
                                    <ul>
                                        <li><input type="submit" value="{{__('profile.save')}}" class="subBtn"></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
<!-- Time picek jas -->
<link rel='stylesheet' href='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css'>
<script src='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js'></script>

<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
    $( "#datepicker" ).datepicker({
        changeYear:true,
        yearRange: "2005:2015"
    });
  } );
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
<script>
    function fun1(){
    var i=document.getElementById('profile_pic').files[0];
    var b=URL.createObjectURL(i);
    $("#img2").attr("src",b);
    }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){
        $("#change_password_from").validate({
            rules: {
                old_password: {
                    required:true,

                },
                new_password: {
                    required:true,

                    minlength: 8
                },
                new_password_confirmation:{
                    required:true,
                    equalTo: "#new_password"
                }
            },
            messages: {
                old_password: {
                    required:"{{__('profile.required_old_password')}}",

                },
                new_password: {
                    required:"{{__('profile.required_new_password')}}",
                    minlength: "{{__('profile.minlength_new_password')}}",
                },
                new_password_confirmation:{
                    required:"{{__('profile.required_new_password_confirmation')}}",
                    equalTo: "{{__('profile.equal_new_password_confirmation')}}"
                }
            },
        });
    });
</script>

@endsection
