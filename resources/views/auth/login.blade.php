@extends('layouts.app')

@section('title')
<title>{{__('auth.login_title')}}</title>
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
                    <div class="main-center-div back_white">@include('includes.message')
                        <form action="{{route('custom.login')}}" method="POST" id="login_form">
                            @csrf
                            <div class="login-from-area">
                                <h2>{{__('auth.login_header')}}</h2>
                                <p>{{__('auth.login_content')}}</p>

                                <div>
                                    <input type="text" class="login-type" placeholder="{{__('auth.username_placeholder')}}" name="username" value="{{old('username')}}">
                                    <div class="clearfix"></div>
                                </div>
                                <div class="password-in">
                                    <input type="password" class="login-type" name="password" placeholder="{{__('auth.password_placeholder')}}">
                                    <div class="clearfix"></div>
                                </div>
                                
                                <input type="hidden" name="custom_url" value="{{Session::get('customurl')}}">
                                <div class="remmber-area">
                                    <a class="forgot-passwords" href="{{route('password.forgot')}}">{{__('auth.forgot_password_link')}}</a>
                                    <div class="clearfix"></div>
                                </div>
                                <button type="submit" class="login-submit">{{__('auth.sign_in')}}</button>
                                <div class="bottom-account-div">
                                    <p>{{__('auth.do_not_have_an_account')}} <a href="{{route('register')}}">{{__('auth.sign_up')}}</a></p>
                                </div>
                                <div class="logfoot">
                                    <ul>
                                        <li>
                                            <a href="{{route('astrologer.register')}}">{{__('auth.sign_up_as_a_astrologer')}}</a>
                                        </li>
                                        <li>
                                            <a href="{{route('pundit.register')}}">{{__('auth.sign_up_as_a_pundits')}}</a>
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
   <script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){
        $("#login_form").validate({
            rules: {
                password:{
                    required: true,
                    minlength: 8
                },
                username:{
                    required: true,
                }
            },
            messages: {
                password:{
                    required:'{{__('auth.required_password')}}',
                    minlength: '{{__('auth.minlength_password')}}'
                },
                username:{
                    required: '{{__('auth.required_username')}}',
                },

            },
        });
    })
</script>
@endsection
