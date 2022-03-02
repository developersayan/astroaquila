@extends('admin.layouts.app')

@section('title')
<title>Astroaquila | Forget Password</title>
@endsection

@section('style')
@include('admin.includes.style')
@endsection



@section('body')
<div class="panel panel-color panel-primary panel-pages">
    <div class="panel-heading rm08">
        <img src="{{ URL::to('public/admin/assets/images/Logo-1.png')}}" alt="">
    </div>


    <div class="panel-body">
         @include('admin.includes.message')
        <form class="form-horizontal m-t-20" action="{{route('admin.forget.password.email')}}" method="POST" id="forgetpassword">
            @csrf

            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control input-lg" type="text" placeholder="Username" name="email">
                    @if ($errors->has('email'))
                    <span class="invalid-feedback error" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>



            <div class="form-group text-center ">
                <div class="col-xs-12">
                     <button class="btn btn-primary btn-lg w-lg waves-effect waves-light rm01" type="submit">Forget Password</button>
                </div>
            </div>
            <div class="col-sm-12 mt-5">
                            
                       <a href="{{route('admin.login')}}" class="rm01" style="color: #fbbc93;;"><< Back to login</a>
               </div>


                <!--<div class="col-sm-5 text-right">
                            <a href="register.html">Create an account</a>
                        </div>-->
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
@include('admin.includes.script')
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
        }, "Enter valid Email");
        $("#forgetpassword").validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                    validate_email:true
                },
            },
            messages:{
                email:{
                    required:'Please enter your email',
                    validate_email:'Please enter your email properly',
                },
            },
        });
       
    })
</script>
@endsection
