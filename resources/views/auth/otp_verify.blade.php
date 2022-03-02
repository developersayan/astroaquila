@extends('layouts.app')

@section('title')
<title>{{__('auth.otp_title')}}</title>
@endsection


@section('style')
@include('includes.style')
<style>
    .error {
        color: red !important;
    }
</style>
<style>
    input[type=number] {
        height: 45px;
        width: 45px;
        font-size: 25px;
        text-align: center;
        border: 1px solid #000000;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
    -moz-appearance:textfield;
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
                    <form action="{{route('account.otp.submit',['id'=>@$data->id])}}" method="POST" enctype="multipart/form-data" id="signup_form">
                        @csrf
                        <input type="hidden" value="{{$data->id}}" name="id">
                    <div class="main-center-div">@include('includes.message')
                        <div class="login-from-area">
                            <h2>{{__('auth.otp_header')}}</h2>
                            <p>{{__('auth.otp_content')}} {{@$data->mobile}}</p>
                            <p>{{@$data->otp}}</p>

                            <div class="otp-sec">
                                <ul>
                                    <li><input id="codeBox1" name="codeBox1" type="number" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox2" name="codeBox2" type="number" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox3" name="codeBox3" type="number" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox4" name="codeBox4" type="number" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox5" name="codeBox5" type="number" maxlength="1" onkeyup="onKeyUpEvent(5, event)" onfocus="onFocusEvent(5)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                    <li><input id="codeBox6" name="codeBox6" type="number" maxlength="1" onkeyup="onKeyUpEvent(6, event)" onfocus="onFocusEvent(6)" onKeyPress="if(this.value.length==1) return false;" oninput="this.value = this.value.replace(/[^0-9.]/g,'')"></li>
                                </ul>
                            </div>
                            {{-- <label id="codeBox1-error" class="error" for="codeBox1"></label>
                            <label id="codeBox2-error" class="error" for="codeBox2"></label>
                            <label id="codeBox3-error" class="error" for="codeBox3"></label>
                            <label id="codeBox4-error" class="error" for="codeBox4"></label>
                            <label id="codeBox5-error" class="error" for="codeBox5"></label> --}}
                            <label id="codeBox6-error" class="error" for="codeBox6"></label>

                            <button type="submit" class="login-submit">{{__('auth.submit')}}</button>
                            <div class="bottom-account-div">
                                <p id="resendOtpp">{{__('auth.did_not_received')}}, <a href="javascript:;" id="resendOtp">{{__('auth.resend_code')}}</a></p>
                            </div>

                        </div>
                    </div>
                    </form>
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
        $("#signup_form").validate({
            rules: {
                codeBox6:{
                    required: true,
                },
            },
            messages: {
                codeBox6:{
                    required: '{{__('auth.required_otp')}}',
                },
            },
        });
    })
</script>
<script>
    function getCodeBoxElement(index) {
        return document.getElementById('codeBox' + index);
      }
      function onKeyUpEvent(index, event) {
        const eventCode = event.which || event.keyCode;
        if (getCodeBoxElement(index).value.length === 1) {
          if (index !== 6) {
            getCodeBoxElement(index+ 1).focus();
          } else {
            getCodeBoxElement(index).blur();
            // Submit code
            console.log('submit code ');
          }
        }
        if (eventCode === 8 && index !== 1) {
          getCodeBoxElement(index - 1).focus();
        }
      }
      function onFocusEvent(index) {
        for (item = 1; item < index; item++) {
          const currentElement = getCodeBoxElement(item);
          if (!currentElement.value) {
              currentElement.focus();
              break;
          }
        }
      }
</script>
<script>
$('#resendOtp').click(function(){
    $.ajax({
        type:"GET",
        url: "{{ route('account.resend.otp',['id'=>@$data->id]) }}",
        success:function(response) {
            console.log(response['result']);
            // if(response['result']['success']!=null){
            //     toastr.success(response['result']['success']);
            // }
            // if(response['result']['error']!=null){
            //     toastr.error(response['result']['error']);
            // }
            // toastr.success('');
            // $('#resendOtp').hide();
            // $('#resendOtpp').hide();
        }
    });
});
</script>
@endsection
