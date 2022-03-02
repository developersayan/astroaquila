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
@include('includes.header')
@endsection

@section('body')
<section class="pad-114">
    <div class="dashboard-customer">
        <div class="container">
            <div class="row">
                @include('includes.profile_sidebar')
                <div class="col-lg-9 col-md-12 col-sm-12">
                    <div class="cus-dashboard-right">
                        <h2>{{__('profile.change_password_label')}} </h2>
                    </div>
                    <div class="cus-rightbody">@include('includes.message')
                        <form action="{{route('customer.change.password.save')}}" method="post" id="change_password_from">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.current_password_label')}}</label>
                                        <input type="password" placeholder="{{__('profile.current_password_placeholder')}}" name="old_password" id="old_password">
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
                            <div class="subbtn-sec">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" value="{{__('profile.save')}}" class="save-change"> </div>
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
