@extends('admin.layouts.app')

@section('title')
<title>Astroaquila | Reset Password</title>
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
        <form class="form-horizontal m-t-20" action="{{route('admin.reset.new.password')}}" method="POST" id="resetpassword">
            @csrf
            <input type="hidden" name="id" value="{{@$data->id}}">
            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control input-lg" type="password" placeholder="New Password" name="password">
                    @if ($errors->has('email'))
                    <span class="invalid-feedback error" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

        <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control input-lg" type="password" placeholder="Confirm Password" name="confirm_password">
                    @if ($errors->has('email'))
                    <span class="invalid-feedback error" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
        </div>




            <div class="form-group text-center m-t-40">
                <div class="col-xs-12">
                     <button class="btn btn-primary btn-lg w-lg waves-effect waves-light rm01" type="submit">Save</button>
                </div>
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
    <script type="text/javascript">
              $(function(){
                $('#resetpassword').validate({
                    rules:{
                        password:{
                            required:true,
                            minlength : 5
                        },
                        confirm_password : {
                          required:true,
                          minlength : 5,
                          equalTo : '[name="password"]'
                     }
                    },
                    messages:{
                      password:{
                        required:'Please enter your new password',
                    },
                    confirm_password:{
                       required:'Please enter your confirm password',
                    }
                    }
                    
                })
              })
          </script>  
@endsection
