@extends('layouts.app')

@section('title')
<title>{{__('auth.change_password_title')}}</title>
@endsection


@section('style')
@include('includes.style')
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
                    <div class="main-center-div">@include('includes.message')
                        <form action="{{route('password.forgot.change')}}" method="POST" id="password_change_form">
                            @csrf
                            <div class="login-from-area">
                                <h2>{{__('auth.change_password_header')}}</h2>
                                <p>{{__('auth.change_password_content')}}</p>
                                <div class="password-in">
                                    <input type="password" class="login-type" name="password" placeholder="{{__('auth.password_placeholder')}}" id="password">
                                    <div class="clearfix"></div>
                                </div>
                                <div class="password-in">
                                    <input type="password" class="login-type" name="password_confirmation" placeholder="{{__('auth.confirm_password_placeholder')}}">
                                    <div class="clearfix"></div>
                                </div>
                                <input type="hidden" class="login-type" name="id" value="{{$id}}">
                                <input type="hidden" class="login-type" name="vcode" value="{{$code}}">
                                <button type="submit"
                                    class="login-submit">{{__('auth.change_password_button')}}</button>
                                <div class="bottom-account-div">
                                    <p>{{__('auth.already_have_an_account')}} <a href="{{route('login')}}">{{__('auth.sign_in')}}</a></p>
                                </div>
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
{{-- @include('includes.toaster') --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){
        jQuery.validator.addMethod("validate_email", function(value, element) {
            if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                return true;
            } else {
                return false;
            }
        }, "{{__('auth.valid_email')}}");
        $("#password_change_form").validate({
            rules: {
                password:{
                    required: true,
                    minlength: 8
                },
                password_confirmation:{
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
            },
            messages: {
                password:{
                    required:'{{__('auth.required_password')}}',
                    minlength: '{{__('auth.minlength_password')}}'
                },
                password_confirmation:{
                    required:'{{__('auth.required_confirm_password')}}',
                    minlength: '{{__('auth.minlength_confirm_password')}}',
                    equalTo: '{{__('auth.equal_confirm_password')}}'
                },
            },
        });
    })
</script>
@endsection
