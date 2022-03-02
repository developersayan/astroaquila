@extends('layouts.app')

@section('title')
    <title>Horoscope | Order Now</title>
@endsection


@section('style')
    @include('includes.style')
    <style>
        .error {
            color: red !important;
        }

        #tentative {
            display: none;
        }

        .main-center-div {
            max-width: 100%;
        }

        .checkBox span {
            font: 400 16px/20px 'Roboto', sans-serif;
            color: #242522;
            width: 134px;
        }

    </style>
@endsection

@section('header')
    @include('includes.header')
@endsection



@section('body')
    <?php
    $custom = (new \App\Helpers\CustomHelper())->currencyConversion();
    ?>
    <section class="pad-114">
        <div class="login-body">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="main-center-div back_white">
                            <form action="{{ route('horoscope.order.now', ['slug' => $horoscope_details->slug]) }}"
                                method="POST" enctype="multipart/form-data" id="order_now">
                                @csrf
                                <div class="login-from-area">
                                    <h2>Place Order</h2>
                                    <p>{{ @$horoscope_details->name }}/{{ @$horoscope_details->code }}</p>
                                    <p>
                                        @if (@session()->get('currency') == 1)
                                            @if (@$horoscope_details->discount_inr != null && @$horoscope_details->discount_inr > 0)
                                                @php
                                                    $old_price = $horoscope_details->price_inr;
                                                    $discount_value = ($old_price / 100) * @$horoscope_details->discount_inr;
                                                    $new_price = $old_price - $discount_value;
                                                @endphp
                                                {{ @session()->get('currencySym') }}{{ round($new_price, 2) }}
                                                <input type="hidden" id="price" name="price"
                                                    value="{{ round($new_price, 2) }}">
                                            @else
                                                {{ @session()->get('currencySym') }}{{ $horoscope_details->price_inr }}
                                                <input type="hidden" id="price" name="price"
                                                    value="{{ $horoscope_details->price_inr }}">

                                            @endif
                                        @else
                                            @if (@$horoscope_details->discount_usd != null && @$horoscope_details->discount_usd > 0)
                                                @php
                                                    $old_price = @$custom * $horoscope_details->price_usd;
                                                    $discount_value = ($old_price / 100) * @$horoscope_details->discount_usd;
                                                    $new_price = $old_price - $discount_value;
                                                @endphp
                                                {{ @session()->get('currencySym') }}{{ round($new_price, 2) }}
                                                <input type="hidden" id="price" name="price"
                                                    value="{{ round($new_price, 2) }}">
                                            @else
                                                {{ @session()->get('currencySym') }}{{ round(@$custom * @$horoscope_details->price_usd, 2) }}
                                                <input type="hidden" id="price" name="price"
                                                    value="{{ round(@$custom * @$horoscope_details->price_usd, 2) }}">

                                            @endif

                                        @endif
                                    </p>

                                    <div class="payable_price" style="margin-bottom: 10px; display: none;"> You Pay :
                                        @if (@session()->get('currency') == 1){{ @session()->get('currencySym') }} @else {{ @session()->get('currencySym') }} @endif <span id="you_pay_price"></span> </div>

                                    <p> Email Delivery Report will be delivered in 48 Hours.</p>

                                    @if (@session()->get('currency') == 1 && @$horoscope_details->delivery_days_india)
                                        @php
                                            $total_delivery_days = @$horoscope_details->delivery_days_india + 1;
                                        @endphp
                                        @if (@$horoscope_details->is_deliverable == 'Y')
                                            <div class="bill-add">

                                                <label class="list_checkBox dis-checkbox">Do You want physical delivery of
                                                    hororscope ? ({{ @session()->get('currencySym') }}
                                                    {{ $horoscope_details->delivery_price_inr }})
                                                    <input type="checkbox" name="physical_del" id="physical_del"
                                                        value="{{ $horoscope_details->delivery_price_inr }}"> <span
                                                        class="list_checkmark" for="physical_del"></span> </label>
                                            </div>
                                        @endif
                                        <p id="tentative">Tentative Delivery date:
                                            {{ date('F j, Y', strtotime('+ ' . $total_delivery_days . ' days')) }}</p>
                                    @elseif(@$horoscope_details->delivery_days_outside_india)
                                        @php
                                            $total_delivery_days = @$horoscope_details->delivery_days_outside_india + 1;
                                        @endphp
                                        @if (@$horoscope_details->is_deliverable == 'Y')
                                            <p>
                                            <div class="bill-add">
                                                <label class="list_checkBox dis-checkbox">Do You want physical delivery of
                                                    hororscope ? ({{ @session()->get('currencySym') }}
                                                    {{ round($horoscope_details->delivery_price_usd * currencyConversionCustom(), 2) }})
                                                    <input type="checkbox" name="physical_del" id="physical_del"
                                                        value="{{ round($horoscope_details->delivery_price_usd * currencyConversionCustom(), 2) }}">
                                                    <span class="list_checkmark" for="physical_del"></span> </label>
                                            </div>
                                            </p>
                                        @endif

                                        <p id="tentative">Tentative Delivery date :
                                            {{ date('F j, Y', strtotime('+ ' . $total_delivery_days . ' days')) }}</p>
                                    @endif



                                    <input type="hidden" name="delivery_price" id="delivery_price"
                                        value="@if (@session()->get('currency') == 1) {{ $horoscope_details->delivery_price_inr }} @elseif(@session()->get('currency')>=2) {{ round($horoscope_details->delivery_price_usd * currencyConversionCustom(), 2) }} @endif ">


                                    <div class="shipping-head">

                                        @if ($addressBook->count() > 0)
                                            <a href="javascript:;" id="customer_book_view_open"
                                                class="pag_adress">Select person from address book <img
                                                    src="{{ URL::to('public/frontend/images/address-book.png') }}"></a>
                                            <a href="javascript:;" style="display: none" id="add_new_customer"
                                                class="pag_adress"> Add a new person <img
                                                    src="{{ URL::to('public/frontend/images/forms-30.png') }}"></a>
                                        @endif
                                        <div class="clearfix"></div>
                                    </div>

                                    @if ($customers->count() > 0)
                                        <div id="customer_book_view">
                                            <div>
                                                <div class="checkBox newcheck new-cus">
                                                    <ul>
                                                        @foreach ($customers as $key => $item)
                                                            <li style=" width: 100%; margin: 10px;">
                                                                <input type="radio" data-id="{{ $item->id }}"
                                                                    id="customer_book{{ $key }}"
                                                                    name="customer_book" value="{{ $item->id }}"
                                                                    class="customer_book" @if (@$key == 0)checked="" @endif
                                                                    disabled="">

                                                                <label for="customer_book{{ $key }}">Person
                                                                    {{ $key + 1 }}</label>
                                                                <p class="address_p">
                                                                    <b>Name</b> - {{ @$item->name }} ,
                                                                    <b>Place Of Birth</b> -
                                                                    {{ @$item->place_of_residence }}
                                                                    @if (@$item->dob)
                                                                        ,<b>Date Of Birth</b> - {{ @$item->dob }}
                                                                    @endif
                                                                    @if (@$item->dob)
                                                                        ,<b>Time Of Birth</b> -
                                                                        {{ date('H:i a', strtotime(@$item->dob_time)) }}
                                                                    @endif
                                                                    @if (@$item->dob)
                                                                        ,<b>Time Of Birth</b> -
                                                                        {{ date('H:i a', strtotime(@$item->dob_time)) }}
                                                                    @endif




                                                                </p>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    {{-- address-book --}}
                                    <div id="customer_address_book">
                                        <div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="text" class="login-type required" placeholder="Name"
                                                        name="full_name"
                                                        value="{{ old('full_name') ? old('full_name') : auth()->user()->first_name . ' ' . auth()->user()->last_name }}">
                                                </div>



                                                <div class="clearfix"></div>
                                            </div>
                                        </div>

                                        <div class="birth-details">
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-12 position-relative">
                                                        <input type="text" id="date_of_birth" class="login-type log-date"
                                                            placeholder="{{ __('auth.date_of_birth_placeholder') }}"
                                                            name="date_of_birth"
                                                            value="{{ old('date_of_birth') ? old('date_of_birth') : (auth()->user()->dob != '' ? date('m/d/Y', strtotime(auth()->user()->dob)) : '') }}"
                                                            readonly />
                                                        <span class="over_llp"><img
                                                                src="{{ URL::to('public/frontend/images/cal.png') }}"
                                                                alt=""></span>
                                                        <p class="terms-para">
                                                        <div class="availability_check1">
                                                            <input id="birth_date" type="checkbox" value="1"
                                                                name="birth_date">
                                                            <label for="birth_date">Select if (I dont know my birth
                                                                details)</label>
                                                            <div id="birth_date_error"></div>
                                                        </div>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-12 position-relative">
                                                        <input type="text" id="time_of_birth" class="login-type"
                                                            placeholder="{{ __('auth.time_of_birth_placeholder') }}"
                                                            name="time_of_birth"
                                                            value="{{ old('time_of_birth') ? old('time_of_birth') : (auth()->user()->time_of_birth != '' ? date('H:i', strtotime(auth()->user()->time_of_birth)) : '') }}"
                                                            readonly>
                                                        <span class="over_llp"><img
                                                                src="{{ URL::to('public/frontend/images/clock.png') }}"
                                                                alt=""></span>
                                                        <p class="terms-para">
                                                        <div class="availability_check1">
                                                            <input id="birth_time" type="checkbox" value="1"
                                                                name="birth_time">
                                                            <label for="birth_time">Select if (I dont know the time of my
                                                                birth)</label>
                                                            <div id="birth_time_eror"></div>
                                                        </div>
                                                        </p>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div>
                                                <input type="text" class="login-type required" placeholder="Place of Birth"
                                                    name="place" id="place"
                                                    value="{{ old('place') ? old('place') : auth()->user()->place_of_birth }}">
                                                <input type="hidden" name="lat" id="lat">
                                                <input type="hidden" name="lng" id="lng">
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div>
                                            <div class="checkBox d-flex sign-astro new-cus">
                                                <span> Person Gender</span>
                                                <ul>
                                                    <li>
                                                        <input type="radio" id="radio1" name="gender" value="M" checked="">
                                                        <label for="radio1">Male</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="radio2" name="gender" value="F"
                                                            @if (old('gender') == 'F') checked="" @elseif(auth()->user()->gender=='F') checked @endif>
                                                        <label for="radio2">Female</label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>


                                    <div>
                                        <input type="email" class="login-type required email" placeholder="Emaile Address"
                                            name="email" value="{{ old('email') ? old('email') : auth()->user()->email }}"
                                            id="email">
                                        <div class="clearfix"></div>
                                    </div>

                                    <div>
                                        <input type="tel" class="login-type required digits" placeholder="Mobile No."
                                            name="mobile"
                                            value="{{ old('mobile') ? old('mobile') : auth()->user()->mobile }}" id="mobile"
                                            minlength="10" maxlength="10">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div>
                                        <input type="text" class="login-type" placeholder="Problem/Question (optional)"
                                            name="problem_question" id="problem_question"
                                            value="{{ old('problem_question') }}">
                                        <div class="clearfix"></div>
                                    </div>
                                    <div>
                                        <select class="login-type log-select" name="country">
                                            <option value="">Country (optional)</option>
                                            @foreach ($countries as $val)
                                                <option value="{{ $val->id }}" @if (auth()->user()->country_id == $val->id) selected @endif>
                                                    {{ $val->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="shipping-details" id="shipping-details">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="shipping-add back_white">
                                                <div class="shipping-head">
                                                    <h2>Shipping Information</h2>
                                                    @if ($addressBook->count() > 0)
                                                        <a href="javascript:;" id="address_book_view_open"
                                                            class="pag_adress">Select address from address book <img
                                                                src="{{ URL::to('public/frontend/images/address-book.png') }}"></a>
                                                        <a href="javascript:;" style="display: none" id="add_new_address"
                                                            class="pag_adress"> Add a new address <img
                                                                src="{{ URL::to('public/frontend/images/forms-30.png') }}"></a>
                                                    @endif
                                                    <div class="clearfix"></div>
                                                </div>

                                                <hr class="custom-hr">
                                                @if ($addressBook->count() > 0)
                                                    <div id="address_book_view">
                                                        <div>
                                                            <div class="checkBox newcheck new-cus">
                                                                <ul>
                                                                    @foreach ($addressBook as $key => $item)
                                                                        <li style=" width: 100%; margin: 10px;">
                                                                            <input type="radio"
                                                                                id="address_book_label{{ $key }}"
                                                                                name="address_book"
                                                                                value="{{ $item->id }}"
                                                                                @if ($item->is_default == 'Y')checked=""@endif
                                                                                class="address_book" disabled>
                                                                            <label
                                                                                for="address_book_label{{ $key }}">Address
                                                                                {{ $key + 1 }}</label>
                                                                            <p class="address_p">
                                                                                <b>Name</b> - {{ @$item->fname }}
                                                                                {{ @$item->lname }} ,
                                                                                <b>Email</b> - {{ @$item->email }} ,
                                                                                <b>Phone </b> - {{ @$item->phone }} ,
                                                                                <b>Street </b> - {{ @$item->street }} ,
                                                                                <b>Post Code </b> - {{ @$item->postcode }}
                                                                                ,
                                                                                <b>Landmark </b> - {{ @$item->landmark }} ,
                                                                                <b>Address</b> - {{ @$item->address }} ,
                                                                                <b>Country </b> -
                                                                                {{ @$item->countryDetails->name }} ,
                                                                                <b>State </b> -
                                                                                {{ @$item->stateDetails->name }},
                                                                                <b>City </b> - {{ @$item->cityDetails->name }} ,
                                                                                <b>Post Code </b> - {{@$item->postcode}}
                                                                                @if(@$item->areaDetails)
                                                                                ,<b>Area</b> - {{@$item->areaDetails->area}}
                                                                                @endif
                                                                            </p>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="input-section-check" id="normal_address"
                                                    style="text-align: left">
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>First name</label>
                                                                <input type="text" placeholder="Enter your first name  "
                                                                    name="fname" value="{{ @$lastOrder->shipping_fname }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Last Name</label>
                                                                <input type="text" placeholder="Enter your last name "
                                                                    name="lname" value="{{ @$lastOrder->shipping_lname }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Phone No.</label>
                                                                <input type="tel" placeholder="Enter your Phone no."
                                                                    name="phone" value="{{ @$lastOrder->shipping_phone }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Email Address</label>
                                                                <input type="email" placeholder="Enter your email address "
                                                                    name="email_one"
                                                                    value="{{ @$lastOrder->shipping_email }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Country </label>
                                                                <select id="country_one" name="country_one">
                                                                    <option value="">Select Country</option>
                                                                    @foreach ($countries as $country)
                                                                        <option value="{{ $country->id }}"
                                                                            {{ @$lastOrder->shipping_country == $country->id ? 'selected' : '' }}>
                                                                            {{ @$country->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>State </label>
                                                                <select id="state" name="state">
                                                                    <option value="">Select State</option>
                                                                    @if (@$state)
                                                                        @foreach (@$state as $state1)
                                                                            <option value="{{ $state1->id }}"
                                                                                {{ @$lastOrder->shipping_state == $state1->id ? 'selected' : '' }}>
                                                                                {{ @$state1->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>City</label>
                                                                <input type="tel" placeholder="Enter your city" name="city"
                                                                    value="{{ @$lastOrder->shipping_city }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Postal Code</label>
                                                                <input type="text" placeholder="Enter your postal code "
                                                                    name="zip_code"
                                                                    value="{{ @$lastOrder->shipping_pin_code }}">
                                                            </div>
                                                        </div> --}}
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>City</label>
                                                                <select class="login-type log-select " name="city" id="city">
                                                                    <option value="">Select City</option>
                                                                    @if(@$city)
                                                                        @foreach (@$city as $ct)
                                                                            <option value="{{$ct->id}}" {{@$lastOrder->shipping_city==$ct->id?'selected':''}} >{{@$ct->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <label id="city-error" class="error" for="city"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Post Code</label>
                                                                <input type="text" placeholder="Enter your postal code" id="pincode" name="zip_code" value="{{@$lastOrder->shipping_pin_code}}">
                                                                <label id="pincode-error" class="error" for="pincode"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4" id="areaDropDiv" @if(!@$lastOrder->shipping_area)  style="display: none" @endif>
                                                            <div class="form_box_area">
                                                                <label>Select Area</label>
                                                                <select class="login-type log-select " name="area_drop" id="areaDrop">
                                                                    <option value="">Select Area</option>
                                                                    @if(@$areas)
                                                                        @foreach (@$areas as $ar)
                                                                            <option value="{{$ar->id}}" {{@$lastOrder->shipping_area==$ar->id?'selected':''}} >{{@$ar->area}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                     <option value="O">Other</option>
                                                                </select>

                                                                <label id="areaDrop-error" class="error" for="areaDrop"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4" id="areaTextDiv" style="display: none">
                                                            <div class="form_box_area">
                                                                <label>Area</label>
                                                                <input type="text" class="login-type" placeholder="Area" id="areaText" name="area" value="{{ old('area') }}">
                                                                <label id="areaText-error" class="error" for="areaText"></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Street</label>
                                                                <input type="text" placeholder="Enter your street  "
                                                                    name="st_address"
                                                                    value="{{ @$lastOrder->shipping_street }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Nearest Landmark</label>
                                                                <input type="text" placeholder="Enter your nearest landmark"
                                                                    name="landmark"
                                                                    value="{{ @$lastOrder->shipping_landmark }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-4">
                                                            <div class="form_box_area">
                                                                <label>Address</label>
                                                                <input type="text" placeholder="Enter your address"
                                                                    name="address"
                                                                    value="{{ @$lastOrder->shipping_address }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="bill-add">
                                                                <label class="list_checkBox">Save in address book
                                                                    <input type="checkbox" name="save_in_address_book"
                                                                        id="save_in_address_book" value="1" checked> <span
                                                                        class="list_checkmark"
                                                                        for="differentaddress"></span> </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="remmber-area">
                                    <p class="terms-para">
                                    <div class="availability_check1">
                                        <input id="agree_check" type="checkbox" value="1" name="agree_check">
                                        <label for="agree_check">I agree <a href="{{ route('terms.condition') }}"
                                                target="_blank">terms & condition</a> and <a
                                                href="{{ route('privacy.policy') }}" target="_blank">Privacy Policy
                                            </a></label>
                                        <div class="error" id="error_check_term" style="text-align: center;"></div>
                                    </div>
                                    </p>
                                </div>
                                <button type="submit" class="login-submit">Place Order</button>

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
            var input = document.getElementById('place');

            var options = {
                types: ['establishment']
            };

            var input = document.getElementById('place');
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

            google.maps.event.addListener(marker, 'dragend', function(evt, status) {
                $('#lat').val(evt.latLng.lat());
                $('#lng').val(evt.latLng.lng());
                var lat_1 = evt.latLng.lat();
                var lng_1 = evt.latLng.lng();
                var latlng = new google.maps.LatLng(lat_1, lng_1);
                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $('#place').val(results[0].formatted_address);
                    }
                });


            });
        }
    </script>
    {{-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC1A0Zjdpb5eWY6MCTp_8ZOVAlDkUB4MTY&callback=initMap">
    </script> --}}
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRZMuXnvy3FntdZUehn0IHLpjQm55Tz1E&libraries=places&callback=initAutocomplete"
        async defer></script>
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
        $(function() {
            $("#date_of_birth").datepicker({
                maxDate: '-1D',
                changeYear: true,
                yearRange: "1930:2021",

            });
        });
    </script>
    <!-- End -->
    <script>
        $(".shopcut").click(function() {
            $(".shopcutBx").slideToggle();
        });
    </script>
    {{-- @include('includes.toaster') --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    {{-- @if (session()->get('lang') == 2) --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/localization/messages_ar.min.js"></script> --}}
    {{-- @endif --}}
    <script>
        $(document).ready(function() {

            jQuery.validator.addMethod("validate_email", function(value, element) {
                if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
                    return true;
                } else {
                    return false;
                }
            }, "{{ __('auth.valid_email') }}");
            $('#place').keyup(function() {
                $('#lat').val('');
                $('#lng').val('');
            });
            $("#order_now").validate({
                rules: {
                    date_of_birth: {
                        required: function(element) {
                            return !$("#birth_date").is(':checked');
                        }
                    },
                    time_of_birth: {
                        required: function(element) {
                            return !$("#birth_time").is(':checked');
                        }
                    },
                    email: {
                        email: true,
                        validate_email: true,
                        required: true,
                    },
                    fname: {
                        required: true,
                    },
                    lname: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        number: true,
                        minlength: 10,
                        maxlength: 10,
                    },
                    email_one: {
                        required: true,
                        email: true,
                        validate_email: true,
                    },
                    country_one: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                    zip_code: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    st_address: {
                        required: true,
                    },
                    landmark: {
                        required: true,
                    },
                    address: {
                        required: true,
                    },

                },
                submitHandler: function(form) {
                    if (!$('#agree_check').is(':checked')) {
                        $('#error_check_term').html('Please agree to our terms and policy');
                        return false;
                    } else {
                        form.submit();
                    }

                }
            });
            $('#birth_date').click(function() {
                if ($(this).is(':checked')) {
                    $('#date_of_birth').val('');
                    $('#date_of_birth').attr("disabled", "disabled");
                } else {
                    $('#date_of_birth').removeAttr("disabled");
                }
            });
            $('#birth_time').click(function() {
                if ($(this).is(':checked')) {
                    $('#time_of_birth').val('');
                    $('#time_of_birth').attr("disabled", "disabled");
                } else {
                    $('#time_of_birth').removeAttr("disabled");
                }
            });
        })
    </script>

    <script type="text/javascript">
        $('#physical_del').on('click', function(e) {
            if ($('#physical_del').prop("checked") == true) {
                var price = $('#delivery_price').val();
                var hororscope_price = $('#price').val();
                var sum = +price + +hororscope_price;
                $('#you_pay_price').html(sum);
                $('.payable_price').show();
                $('#tentative').show();
                $('#shipping-details').show();
            } else {
                var price = $('#delivery_price').val();
                var hororscope_price = $('#price').val();
                var sum = +price + +hororscope_price;
                var minus = sum - price;
                $('#you_pay_price').html(minus);
                $('.payable_price').show();
                $('#tentative').hide();
                $('#shipping-details').hide();
            }
        })
    </script>

    <script type="text/javascript">
        $('#address_book_view').hide();
        $('#shipping-details').hide();
        $('#address_book_view_open').click(function() {
            $('#address_book_view').show();
            $('#normal_address').hide();
            $('.address_book').prop("disabled", false);
            $('#add_new_address').css('display', 'block');
            $('#address_book_view_open').css('display', 'none');
        });
        $('#add_new_address').click(function() {
            $('#address_book_view').hide();
            $('#normal_address').show();
            $('.address_book').prop("disabled", true);
            $('#add_new_address').css('display', 'none');
            $('#address_book_view_open').css('display', 'block');
        });
    </script>


    <script type="text/javascript">
        $('#customer_book_view').hide();
        $('#customer_book_view_open').click(function() {
            $('#customer_book_view').show();
            $('#customer_address_book').hide();
            $('.customer_book').prop("disabled", false);
            $('#add_new_customer').css('display', 'block');
            $('#customer_book_view_open').css('display', 'none');
        });
        $('#add_new_customer').click(function() {
            $('#customer_book_view').hide();
            $('#customer_address_book').show();
            $('.customer_book').prop("disabled", true);
            $('#add_new_customer').css('display', 'none');
            $('#customer_book_view_open').css('display', 'block');
        });
    </script>





    <script type="text/javascript">
        $('#country_one').change(function() {
            const countryId = $(this).val();
            $('#state').html('');
            if (countryId != "") {
                $.ajax({
                        url: "{{ route('get.state') }}",
                        method: 'POST',
                        data: {
                            jsonrpc: 2.0,
                            _token: "{{ csrf_token() }}",
                            params: {
                                countryId: countryId,
                            },
                        },
                        dataType: 'JSON'
                    })
                    .done(function(response) {
                        if (response.result) {
                            const res = response.result;
                            console.log(res);
                            $('#state').append('<option value="" selected>Select state</option>');
                            $.each(res, function(i, v) {
                                $('#state').append('<option value="' + v.id + '"">' + v.name +
                                    '</option>');
                            })
                        }
                    })
                    .fail(function(error) {
                        $('#state').html('<option value="" selected>Select state</option>');
                    });
            } else {
                $('#state').html('<option value="" selected>Select state</option>');
            }
        });
        $('#state').change(function(){
            const state = $(this).val();
            $('#city').html('');
            if (state != "") {
                  $.ajax({
                          url: "{{route('get.city')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  state_id: state,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.result) {
                              const res = response.result;
                              $('#city').append('<option value="" selected>Select city</option>');
                              $.each(res, function (i, v) {
                                  $('#city').append('<option value="' + v.id + '"">' + v.name + '</option>');
                              })
                          }
                      })
                      .fail(function (error) {
                          $('#city').html('<option value="" selected>Select city</option>');
                      });
              } else {
                  $('#city').html('<option value="" selected>Select state</option>');
              }
        });
        $('#pincode').change(function(){
            var pincode = $(this).val();
            var country = $('#country_one').val();
            var state = $('#state').val();
            var city = $('#city').val();
            $.ajax({
                url: "{{route('get.area')}}",
                method: 'POST',
                data: {
                    jsonrpc: 2.0,
                    _token: "{{ csrf_token() }}",
                    params: {
                        pincode: pincode,
                        country: country,
                        state: state,
                        city: city,
                    },
                },
                dataType: 'JSON'
            })
            .done(function (response) {
                if (response.postcode == 1) {

                    $('#pincode-error').html('')
                    $('#pincode-error').hide();
                    //$('#areaTextDiv').hide()
                    const res = response.result;
                    var select = '';
                    select += '<option value="">Select Area</option>';
                    if(response.result.length >0){
                        $.each(res, function (i, v) {
                            select += '<option value="' + v.id + '"">' + v.area + '</option>';
                        })
                    }

                    select += '<option value="O">Other</option>';
                   $('#areaDrop').html(select);
                   $('#areaDropDiv').show()
                }else{
                    $('#pincode-error').html('This postcode not available , please try other postcode')
                    $('#pincode-error').show();
                    //$('#areaTextDiv').show()
                    $('#areaDropDiv').hide()
                    $('#pincode').val('')
                }
            })
        });
        $('#areaDrop').on('change',function(){
            var area = $(this).val();
            if(area == 'O'){
                $('#areaTextDiv').show()
            }else{
                $('#areaTextDiv').hide()
            }
        })
    </script>

@endsection
