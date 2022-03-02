@extends('layouts.app')

@section('title')
<title>{{__('auth.customer_sign_up_title')}}</title>
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
                        <form action="{{route('customer.register.submit')}}" method="POST" enctype="multipart/form-data" id="signup_form">
                            @csrf
                            <div class="login-from-area">
                                <h2>{{__('auth.sign_up_as_a_customer')}}</h2>
                                <p>{{__('auth.sign_up_customer_content')}}</p>
                                <div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="login-type required" placeholder="{{__('auth.first_name_placeholder')}}" name="first_name" value="{{ old('first_name') }}">
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
                                <div class="password-in">
                                    <input type="password" class="login-type" name="{{__('auth.password_placeholder')}}" placeholder="Password">
                                    <div class="clearfix"></div>
                                </div>

                                <div class="birth-details">
                                    <h3>{{__('auth.birth_details')}} <span>({{__('auth.optional')}})</span></h3>
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6 position-relative">
                                                <input type="text" id="datepicker" class="login-type log-date" placeholder="{{__('auth.date_of_birth_placeholder')}}" name="date_of_birth" value="{{ old('date_of_birth') }}" readonly>
                                                <span class="over_llp"><img src="{{ URL::to('public/frontend/images/cal.png')}}" alt=""></span>
                                            </div>
                                            <div class="col-md-6 position-relative">
                                                <input type="text" class="login-type" placeholder="{{__('auth.time_of_birth_placeholder')}}" name="time_of_birth" value="{{ old('time_of_birth') }}" readonly>
                                                <span class="over_llp"><img src="{{ URL::to('public/frontend/images/clock.png')}}" alt=""></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="text" class="login-type" placeholder="{{__('auth.place_of_birth_placeholder')}}" name="place_of_birth" id="place_of_birth" value="{{ old('place_of_birth') }}">
                                        <input type="hidden" name="lat" id="lat">
                                        <input type="hidden" name="lng" id="lng">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div>
                                        <input type="text" class="login-type" placeholder="{{__('auth.select_gotra_placeholder')}}" name="gotra" id="gotra" value="{{ old('gotra') }}">
                                        {{-- <select class="login-type log-select" name="gotra">
                                            <option value="">{{__('auth.select_gotra_placeholder')}}</option>
                                            @foreach ($allGotra as $allGotras)
                                            <option value="{{$allGotras->id}}" @if(old('gotra')==$allGotras->id) selected @endif>{{$allGotras->gotra_name_en}}</option>
                                            @endforeach
                                        </select> --}}
                                        <div class="clearfix"></div>
                                    </div>
                                </div>



                                <div class="remmber-area">
                                    <p class="terms-para">{{__('auth.creating_account')}}<a href="#"> {{__('auth.terms_of_service')}} </a> {{__('auth.and')}} <a href="#"> {{__('auth.privacy_policy')}}</a>
                                    </p>
                                </div>
                                <button type="submit" class="login-submit">{{__('auth.sign_up')}}</button>
                                <div class="bottom-account-div">
                                    <p>{{__('auth.already_have_an_account')}}<a href="{{route('login')}}"> {{__('auth.sign_in')}}</a></p>
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
    function initAutocomplete() {
        // Create the search box and link it to the UI element.
        var input = document.getElementById('place_of_birth');

        var options = {
          types: ['establishment']
        };

        var input = document.getElementById('place_of_birth');
        var autocomplete = new google.maps.places.Autocomplete(input, options);

        autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

        autocomplete.addListener('place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place)
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }

            $('#lat').val(place.geometry.location.lat());
            $('#lng').val(place.geometry.location.lng());
            lat = place.geometry.location.lat();
            lng = place.geometry.location.lng();
            $('.exct_btn').show();

            initMap();
        });
        initMap();
    }
</script>

<script>

    function initMap() {
        geocoder = new google.maps.Geocoder();
        var lat = $('#lat').val();
        var lng = $('#lng').val();
        var myLatLng = new google.maps.LatLng(lat, lng);
        // console.log(myLatLng);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: myLatLng
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: 'Choose hotel location',
          draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(evt,status){
        $('#lat').val(evt.latLng.lat());
        $('#lng').val(evt.latLng.lng());
        var lat_1 = evt.latLng.lat();
        var lng_1 = evt.latLng.lng();
        var latlng = new google.maps.LatLng(lat_1, lng_1);
            geocoder.geocode({'latLng': latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#place_of_birth').val(results[0].formatted_address);
                }
            });


        });
    }
    </script>
    {{-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1A0Zjdpb5eWY6MCTp_8ZOVAlDkUB4MTY&callback=initMap">
    </script> --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRZMuXnvy3FntdZUehn0IHLpjQm55Tz1E&libraries=places&callback=initAutocomplete" async defer></script>
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
    $( "#datepicker" ).datepicker({
        maxDate:'-1D',
        changeYear: true,
        yearRange: "1930:2021",

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
                }
            },
        });
    })
</script>
@endsection
