@extends('layouts.app')

@section('title')
    <title>Add User Information</title>
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
                        <div class="">@include('includes.message')

                            <div class="login-from-area">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                        <h2>Order Details</h2>
                                        <div class="birth-details">
                                            <h3>Order ID :- {{ @$orderDetails->order_id }} </h3>
                                            <div>
                                                <div class="row">
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12" style="text-align: left">
                                                        <div class="form_box_area">
                                                            <label>Astrologer Name:
                                                                {{ @$orderDetails->astrologer->first_name }}
                                                                {{ @$orderDetails->astrologer->last_name }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12" style="text-align: left">
                                                        <div class="form_box_area">
                                                            @if (@$call_details->book_type == 'S')
                                                                <label>Schedule date & Time:
                                                                    {{ date('m/d/Y H:i', strtotime($call_details->call_date_time)) }}
                                                                </label>
                                                            @else
                                                                <label>Duration: @if (@$orderDetails->duration == 1) Per minute @else {{ @$orderDetails->duration }} @endif </label>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="col-md-12" style="text-align: left">
                                                        <div class="form_box_area">
                                                            <label>Rate: @if (@$orderDetails->currency_id == 1) RS. @elseif(@$orderDetails->currency_id==2) $ @elseif(@$orderDetails->currency_id==2) @endif
                                                                {{ @$orderDetails->total_rate }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    {{-- <div class="col-md-12" style="text-align: left">
                                                <div class="form_box_area">
                                                    <label>Total Rate:   @if (@$orderDetails->currency_id == 1) RS. @elseif(@$orderDetails->currency_id==2) $ @endif {{@$orderDetails->total_rate}}</label>
                                                </div>
                                            </div> --}}
                                                    <div class="col-md-12" style="text-align: left">
                                                        <div class="form_box_area">
                                                            <label>Date:
                                                                {{ date('d-m-Y H:i', strtotime(@$call_details->call_date_time)) }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                        <div class="gan_puja_sec back_white mt-0">

                                            <div class="row">
                                            </div>

                                            <div class="row hed_puja_det_taital">
                                                <div class="col-sm-6">
                                                    <h2>Add Person Name For Astro Talk :</h2>
                                                </div>
                                                <div class="col-sm-6">
                                                    @if (@$customers && @count($customers) > 0)
                                                        <a href="javascript:;" class="add-cus" id="add_previous"> <i
                                                                class="fa fa-user"></i> Select Person from My List </a>
                                                        <a href="javascript:;" class="add-cus" id="hide_previous"
                                                            style="display: none;"> <i class="fa fa-user"></i> Hide
                                                            Person from My List </a>
                                                    @endif
                                                </div>


                                            </div>
                                            <form
                                                action="{{ route('astrologer.booking.user.data', ['order_id' => @$orderDetails->order_id]) }}"
                                                method="POST" enctype="multipart/form-data" id="payment">
                                                @csrf
                                                <div class="row">
                                                    <div class="row" id="previous_customer"
                                                        style="display:none;">
                                                        <div class="col-sm-12">
                                                            <div class="add-cus-sec">
                                                                <h2>Previously Added Name For Astro Talk :</h2>
                                                                <div
                                                                    class="checkBox d-flex sign-astro new-cus booking_type_radio">
                                                                    <ul class="add_div">

                                                                        @foreach (@$customers as $customer)
                                                                            <li
                                                                                style="width: 100% !important;height: auto;border: none;">
                                                                                <input type="radio" name="previous"
                                                                                    id="radio{{ @$customer->id }}"
                                                                                    value="{{ @$customer->id }}"> <label
                                                                                    for="radio{{ @$customer->id }}"
                                                                                    style="border: none;">{{ @$customer->name }}
                                                                                    @if (@$customer->relation != '') , {{ @$customer->relation }} @endif @if (@$customer->dob != '') , {{ @$customer->dob }} @endif , {{ @$customer->place_of_residence }} @if (@$customer->janama_nkshatra != '') , {{ @$customer->nakshatras->name }} @endif @if (@$customer->janam_rashi_lagna != '') , {{ @$customer->rashis->name }} @endif  @if (@$customer->gotra != '') , {{ @$customer->gotra }} @endif </label>

                                                                            </li>
                                                                        @endforeach

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 col-sm-12" id="customerForm">
                                                        <div class="custom_div_class">
                                                            <div class="row">
                                                                <input type="hidden" name="astrologer_id" id="astrologer_id"
                                                                    value="{{ @$call_details->astrologer_id }}">
                                                                <input type="hidden" name="user_id_puja" id="user_id_puja"
                                                                    value="{{ auth()->user()->id }}">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">

                                                                        <input type="text" placeholder="Name" name="name"
                                                                            class="customer_name" id="customer_name">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">

                                                                        <input type="text" placeholder="Date of Birth"
                                                                            class="position-relative datepicker_puja"
                                                                            name="dob" class="date_of_birth"
                                                                            id="datepicker" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        <select name="nakshatra" class="customer_nakshatra"
                                                                            id="nakshatra">
                                                                            <option value="">Select Janam Nakshatra</option>
                                                                            @foreach (@$nakshatra as $value)
                                                                                <option value="{{ @$value->id }}">
                                                                                    {{ @$value->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        <select name="rashi" class="customer_rashi"
                                                                            id="rashi">
                                                                            <option value="">Select Rashi</option>
                                                                            @foreach (@$rashi as $value)
                                                                                <option value="{{ @$value->id }}">
                                                                                    {{ @$value->name }}</option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        <input type="text" name="gotra"
                                                                            placeholder="Enter Gotra" class="customer_gotra"
                                                                            id="gotra">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        <input type="text" name="residence"
                                                                            placeholder="Place of residence"
                                                                            class="customer_residence" id="residence">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        <input type="text" name="relation"
                                                                            placeholder="Relation" class="customer_relation"
                                                                            id="relation">
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12 col-sm-12">
                                                                    <div class="form_box_area">
                                                                        <div class="check-box">
                                                                            <input type="checkbox" id="save" name="save"
                                                                                value="1">
                                                                            <label for="save" class="checklabeel">add
                                                                                this name to my saved list</label>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <div class="custom_div_class">
                                                            <div class="row">
                                                                <div class="col-md-6 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        {{-- <select name="consultancy_type" class="customer_rashi" id="consultancy_type">
                                      <option value="">Select Consultancy Type</option>
                                      <option value="Vastu Consultancy">Vastu Consultancy</option>
                                      <option value="Hand Reading">Hand Reading</option>
                                      <option value="Face Reading">Face Reading</option>
                                      <option value="O">Other</option>
                                  </select> --}}
                                                                        <select name="expertise"
                                                                            class="customer_rashi" id="expertise">
                                                                            <option value="">Select expertise
                                                                            </option>
                                                                            @if (@$expertise)
                                                                                @foreach (@$expertise as $ex)
                                                                                    <option value="{{ @$ex->expertise_id }}">
                                                                                        {{ @$ex->experties->expertise_name }}</option>
                                                                                @endforeach
                                                                            @endif
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-md-6 col-sm-6 otherName"
                                                                    style="display:none;">
                                                                    <div class="form_box_area">
                                                                        <input type="text" name="consultancy_type_other"
                                                                            placeholder="Enter consultancy type"
                                                                            class="consultancy_type_other"
                                                                            id="consultancy_type_other">
                                                                    </div>
                                                                </div> --}}

                                                                <div class="col-md-12 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        <input type="text" name="measurement"
                                                                            placeholder="Length X  Breadth X Height"
                                                                            class="measurement" id="measurement">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-sm-6">
                                                                    <div class="form_box_area">
                                                                        {{-- <input type="text" name="order_description"
                                                                            placeholder="Description"
                                                                            class="order_description" id="order_description"> --}}
                                                                            <textarea name="order_description"
                                                                            placeholder="Description"
                                                                            class="order_description" id="order_description"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12" style="margin-bottom:10px;">
                                                                    <div class="uplodimg">
                                                                        <div class="uplodimgfil" style="width:71%;">
                                                                            <b>Accepted file format: image/pdf</b>
                                                                            <input type="file" id="file" name="astro_file"
                                                                                class="astro_file">
                                                                            <label for="file">Attachment<img
                                                                                    src="{{ URL::to('public/frontend/images/clickhe.png') }}"
                                                                                    alt=""></label>
                                                                        </div>
                                                                    </div>
                                                                    <span class="astro_file_names"></span>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                @if (@$orderDetails->status == 'T')
                                                                    <div class="col-md-12 col-sm-6"> <button type="submit"
                                                                            class="login-submit">Book Now</button></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- dynamic-form --}}
                                                </div>
                                            </form>










                                        </div>


                                    </div>
                                </div>

                            </div>


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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker({
                maxDate: 0,
                changeYear: true,
                changeMonth: true,
                yearRange: "1930:{{ date('Y') }}",

            });
            $('.ui-datepicker').addClass('notranslate');
            $('#add_previous').on('click', function(e) {
                $('#previous_customer').css('display', 'block');
                $('#add_previous').css('display', 'none');
                $('#hide_previous').css('display', 'block');
                $('#customerForm').css('display', 'none');
                $('#customer_name').val('');
                $('#datepicker').val('');
                $('#nakshatra').val('');
                $('#rashi').val('');
                $('#gotra').val('');
                $('#residence').val('');
                $('#relation').val('');

            })

            $('#hide_previous').on('click', function(e) {
                $('#previous_customer').css('display', 'none');
                $('#add_previous').css('display', 'block');
                $('#hide_previous').css('display', 'none');
                $('#customerForm').css('display', 'block');
                $('input[name=previous]').prop('checked', false);
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#consultancy_type').change(function() {
                var type = $(this).val();
                if (type == 'O') {
                    $('.otherName').show();
                } else {
                    $('.otherName').hide();
                }
            });
            $('#add_more_form').validate({
                rules: {
                    name: {
                        required: true,
                    },
                    residence: {
                        required: true,
                    },
                    relation: {
                        required: true,
                    },
                },
                submitHandler: function(form) {
                    var name = $('#customer_name').val();
                    var dob = $('#datepicker').val();
                    var nakshatra = $('#nakshatra').val();
                    var rashi = $('#rashi').val();
                    var gotra = $('#gotra').val();
                    var residence = $('#residence').val();
                    var relation = $('#relation').val();
                    var user_id_puja = $('#user_id_puja').val();
                    var astrologer_id = $('#astrologer_id').val();
                    if ($('#save').prop("checked")) {
                        $('#check_val').val(1)
                    } else {
                        $('#check_val').val(0)
                    }
                    var check = $('#check_val').val();

                    $.ajax({
                        url: "{{ route('user.astrologer.add.temp-names') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            user_id_puja: user_id_puja,
                            astrologer_id: astrologer_id,
                            name: name,
                            dob: dob,
                            rashi: rashi,
                            nakshatra: nakshatra,
                            gotra: gotra,
                            residence: residence,
                            relation: relation,
                            check: check,
                        },
                        success: function(data) {
                            console.log(data);
                            // return false;
                            fetch();
                            $('#succss').html(data);
                            $('#add_more_form').trigger('reset');
                        }
                    })
                }
            });
        });

        function fetch() {
            $.get(
                "{{ route('user.astrologer.show.tempnames') }}", {
                    user_id: {{ auth()->user()->id }},
                    astrologer_id: {{ @$call_details->astrologer_id }}
                },
                function(data) {
                    console.log(data.length);

                    $('#live_added_names').html('');
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            var html = `<li id="remove_temp_customer_` + value.id + `">
                                <label class="list_checkBox newdes">
                                <div class="alldata">
                                <div>
                                    <span>` + value.name + `</span>
                                </div>`
                            if (value.relation != null) {
                                html = html + `<div>
                                    <b>, Relation:</b> <span>` + value.relation + `</span>
                                </div>`;
                            }
                            if (value.dob != null) {
                                html = html + `<div>
                                    <b>, Dob:</b> <span>` + value.dob + `</span>
                                </div>`;
                            }
                            html = html + `<div>
                                    <span>, ` + value.place_of_residence + `</span>
                                </div>`;
                            console.log(value.janam_nakshatra);
                            if (value.janam_nakshatra != null) {
                                html = html + `<div>
                                   <span>, ` + value.nakshatras.name + `</span>
                                </div>`;
                            }
                            if (value.janam_rashi != null) {
                                html = html + `<div>
                                   <span>, ` + value.rashis.name + `</span>
                                </div>`;
                            }
                            if (value.gotra != null) {
                                html = html + `<div>
                                   <span>, ` + value.gotra + `</span>
                                </div>`;
                            }
                            html = html + `</div>


                                <div class="new-cross"><div><a name="remove" id="` + value.id + `" class="pag_btn btn_remove" style="color:white"><i class="fa fa-times" aria-hidden="true"></i></a></div></div>


                            </label>

                            </li>


                `;

                            $('#live_added_names').append(html);
                        })
                    } else {
                        $('#live_added_names').append(
                            `
                    <li>
                                <label class="list_checkBox">
                                <div>
                                    <span>No person name added</span>
                                </div> `
                        );
                    }
                }
            );


        }

        function remove() {
            $.get(
                "{{ route('astrologer.delete.data.temp-table') }}", {
                    user_id: {{ auth()->user()->id }},
                    astrologer_id: {{ @$call_details->astrologer_id }}
                },
                function(data) {
                    $('#live_added_names').html('');
                    $('#live_added_names').append(
                        `
                    <li>
                                <label class="list_checkBox">
                                <div>
                                    <span>No person name added</span>
                                </div> `
                    );


                }
            );
        }

        remove();
    </script>
    <script type="text/javascript">
        $(document).on('click', '.btn_remove', function() {
            var id = $(this).attr("id");
            $.ajax({
                url: "{{ route('user.astrologer.delete.tempnames') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    if (data == 0) {
                        $('#remove_temp_customer_' + id + '').remove();
                        fetch();
                    } else {
                        $('#remove_temp_customer_' + id + '').remove();
                        $('#check_box_' + data + '').attr("checked", false);
                        fetch();
                    }
                }
            });

        });
    </script>
    <script type="text/javascript">
        $(document).on('click', '.prv_check', function() {
            var id = $(this).attr("value");
            if ($(this).prop("checked") == true) {
                $.ajax({
                    url: "{{ route('user.astrologer.insert.checkbox') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        user_id: {{ auth()->user()->id }},
                        puja_id: {{ @$call_details->astrologer_id }}
                    },
                    success: function(data) {
                        console.log(data);
                        fetch();
                        // $('#succss').html(data);
                        //  $('#add_more_form').trigger('reset');
                    }
                })
            } else {

                $.ajax({
                    url: "{{ route('user.astrologer.delete.checkbox') }}",
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(data) {
                        console.log(data);
                        fetch();
                    }
                })
            }

        })
    </script>
    <script type="text/javascript">
        $('.astro_file').change(function() {
            $('.astro_file_names').html('');
            var files = $('.astro_file').prop('files');
            $('.astro_file_names').html(files[0].name);
        });
        $('#payment').validate({
            submitHandler: function(form) {
                var err = 0;
                var files = $('.astro_file').prop('files');
                var consultancy_type = $('#consultancy_type').val();
                var expertise = $('#expertise').val();
                var other_name = $('#consultancy_type_other').val();
                var measurement = $('#measurement').val();
                var customer_name = $('#customer_name').val();
                var residence = $('#residence').val();
                var relation = $('#relation').val();
                if ($('#customerForm').is(':visible')) {
                    // if (customer_name == '') {
                    //     alert("Please enter name");
                    //     err = 1;
                    //     return false;
                    // }
                    // if (residence == '') {
                    //     alert("Please enter place of residence");
                    //     err = 1;
                    //     return false;
                    // }
                    // if (relation == '') {
                    //     alert("Please enter relation");
                    //     err = 1;
                    //     return false;
                    // }
                } else {
                    // if (!$('input[name=previous]').is(':checked')) {
                    //     alert("Please select one person from the list");
                    //     err = 1;
                    //     return false;
                    // }
                }
                // if (consultancy_type == '') {
                //     alert("Please select consultancy type");
                //     err = 1;
                //     return false;
                // }
                if (expertise == '') {
                    alert("Please select expertise");
                    err = 1;
                    return false;
                }

                // if (consultancy_type == 'O' && other_name == '') {
                //     alert("Please enter your preferred consultancy type");
                //     err = 1;
                //     return false;
                // }
                // if (measurement == '') {
                //     alert("Please enter measurements");
                //     err = 1;
                //     return false;
                // }
                // $.each(files, function(k, file) {
                //     var fileExt = file.name.split('.').pop();
                //     console.log(fileExt);
                //     if (fileExt != "jpg" && fileExt != "png" && fileExt != "gif" && fileExt != "pdf" &&
                //         fileExt != "PDF" && fileExt != "JPG" && fileExt != "PNG") {
                //         alert("File type must be image or pdf.");
                //         err = 1;
                //         return false;
                //     }
                // });
                // filecnt = Object.keys(files).length;
                // if (filecnt <= 0) {
                //     alert("Please select a file.");
                //     err = 1;
                //     return false;
                // }
                if (err == 0) {
                    form.submit();
                } else {
                    return false;
                }


            }
        });
    </script>
@endsection
