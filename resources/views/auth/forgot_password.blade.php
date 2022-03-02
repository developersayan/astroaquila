@extends('layouts.app')

@section('title')
<title>{{__('auth.forgot_password_title')}}</title>
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
                        <form action="{{route('password.forgot.submit')}}" method="POST" id="login_form">
                            @csrf
                            <div class="login-from-area">
                                <h2>{{__('auth.forgot_password_header')}}</h2>
                                <p>{{__('auth.forgot_password_content')}}</p>

                                <div>
                                    <input type="text" class="login-type"
                                        placeholder="{{__('auth.email_address_placeholder')}}" name="email" value="{{old('email')}}">
                                    <div class="clearfix"></div>
                                </div>
                                <button type="submit" class="login-submit">{{__('auth.forgot_password_button')}}</button>
                                <div class="bottom-account-div">
                                    <p>{{__('auth.already_have_an_account')}} <a href="{{route('login')}}">{{__('auth.sign_in')}}</a></p>
                                </div>
                                <div class="logfoot">
                                    <ul>
                                        <li>
                                            <a
                                                href="{{route('astrologer.register')}}">{{__('auth.sign_up_as_a_astrologer')}}</a>
                                        </li>
                                        <li>
                                            <a
                                                href="{{route('pundit.register')}}">{{__('auth.sign_up_as_a_pundits')}}</a>
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
        $("#login_form").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email:true
                },
            },
            messages: {
                email:{
                    email:'{{__('auth.valid_email')}}',
                    required:'{{__('auth.required_email')}}',
                    // remote:'The email is already exist'
                },
            },
        });
    })
</script>
@endsection
