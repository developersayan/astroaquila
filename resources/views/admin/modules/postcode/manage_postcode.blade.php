@extends('admin.layouts.app')


@section('title')
    <title>Astroaquila | Manage Postcode</title>
@endsection

@section('style')
    @include('admin.includes.style')
@endsection

@section('content')
    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">Manage Postcode</h4>
                        <ol class="breadcrumb pull-right">
                            <li class="active"><a href="{{ route('admin.manage.postcode.add') }}"><i
                                        class="fa fa-plus" aria-hidden="true"></i> Add Postcode</a></li>
                            <li class="active" id="excel_click"><a><i class="fa fa-file-excel-o"
                                        aria-hidden="true"></i> Add Excel</a></li>
                            <li class="active"><a href="{{ route('admin.settings.sub.menu') }}"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="clearfix"></div>
                        <div class="panel panel-default">
                            <div class="panel-heading rm02 rm04">
                                <form role="form" action="{{route('admin.manage.postcode')}}" method="get" id="search_form">
                                {{-- @csrf
                                <input type="hidden" name="page" value="" id="page"> --}}
                                <div class="form-group">
                                    <label for="FullName">Country</label>
                                    <select class="form-control rm06 basic-select" name="country" id="country_id">
                                        <option value="">Select Country</option>
                                        @foreach (@$countries as $country)
                                            <option value="{{@$country->id}}" @if (request('country') == $country->id) selected @endif>{{@$country->name}}</option>
                                        @endforeach
                                     </select>
                                </div>

                                <div class="form-group">
                                    <label for="FullName">State</label>
                                    <select class="form-control rm06 basic-select" name="state" id="state_id">
                                      <option value="">Select State</option>
                                        @if (@$states)
                                            @foreach (@$states as $val)
                                                <option value="{{@$val->id}}" @if (request('state') == @$val->id) selected @endif>{{@$val->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="FullName">City</label>
                                    <select class="form-control rm06 basic-select" name="city" id="city_id">
                                      <option value="">Select city</option>
                                        @if (@$cities)
                                            @foreach (@$cities as $val2)
                                                <option value="{{@$val2->id}}" @if (request('city') == @$val2->id) selected @endif>{{@$val->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="postcode_id">Postcode</label>
                                    <input type="text" id="postcode_id" class="form-control" value="{{request('postcode')}}" name="postcode" placeholder="Postcode">
                                </div>

                                <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Search</button>
                                </div>
                            </form>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        @include('admin.includes.message')
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Country</th>
                                                        <th>State</th>
                                                        <th>City</th>
                                                        <th>Post code</th>
                                                        <th>Puja available</th>
                                                        <th>Service Available</th>
                                                        <th class="rm07">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($postcodes->isNotEmpty())
                                                        @foreach (@$postcodes as $value)
                                                            <tr>
                                                                <td>{{ @$value->getCountry->name }}</td>
                                                                <td>{{ @$value->getState->name }}</td>
                                                                <td>{{ @$value->getCity->name }}</td>
                                                                <td>{{ @$value->postcode }}</td>
                                                                <td>
                                                                    @if (@$value->puja_available == 'Y')
                                                                        Yes
                                                                    @else
                                                                        No
                                                                    @endif

                                                                </td>
                                                                <td>
                                                                    @if (@$value->service_available == 'Y')
                                                                        Yes
                                                                    @else
                                                                        No
                                                                    @endif

                                                                </td>
                                                                <td class="rm07">
                                                                    <a href="javascript:void(0);" class="action-dots"
                                                                        id="action{{ $value->id }}"><img
                                                                            src="{{ URL::to('public/admin/assets/images/action-dots.png') }}"
                                                                            alt=""></a>
                                                                    <div class="show-actions"
                                                                        id="show-{{ $value->id }}"
                                                                        style="display: none;">
                                                                        <span class="angle custom_angle_state"><img
                                                                                src="{{ URL::to('public/admin/assets/images/angle.png') }}"
                                                                                alt=""></span>
                                                                        <ul>
                                                                            <li><a
                                                                                    href="{{ route('admin.manage.postcode.edit', ['id' => $value->id]) }}">Edit
                                                                                </a></li>
                                                                            <li><a href="{{ route('admin.manage.postcode.delete', ['id' => $value->id]) }}" onclick="return confirm('Do you want to delete this Postcode?')">Delete</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else

                                                        <tr>
                                                            <td colspan="7">
                                                                <center> No Data </center>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>


                                        <ul class="pagination rtg">
                                            {{ @$postcodes->links() }}
                                        </ul>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End row -->

            </div>
            <!-- container -->

        </div>
        <!-- content -->

        @include('admin.includes.footer')

        <div class="modal" tabindex="-1" role="dialog" id="excel_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Upload Excel File</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.manage.postcode.export') }}" method="post" enctype="multipart/form-data"
                            id="excel_form">
                            @csrf

                            <div class="form-group">
                                <label for="FullName">Country</label>
                                <select class="form-control rm06 basic-select " name="country" id="country"
                                    style="width: 100%;">
                                    <option value="">Select Country</option>
                                    @foreach (@$countries as $value)
                                        <option value="{{ @$value->id }}" @if (request('country') == @$value->id) selected @endif>{{ @$value->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="error_country"></div>
                            </div>


                            <div class="form-group">
                                <label for="FullName">State</label>
                                <select class="form-control rm06 basic-select " name="state" id="state"
                                    style="width: 100%;">
                                    <option value="">Select State</option>
                                </select>
                                <div id="error_state"></div>
                            </div>
                            <div class="form-group">
                                <label for="FullName">City</label>
                                <select class="form-control rm06 basic-select " name="city" id="city"
                                    style="width: 100%;">
                                    <option value="">Select City</option>
                                </select>
                                <div id="error_city"></div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="main-center-div">
                                        <div class="login-from-area">
                                            <div class="uplodimgfil">
                                                <input type="file" id="file-2" class="inputfile inputfile-1"
                                                    data-multiple-caption="{count} files selected" name="excel"
                                                    accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                                <label for="file-2">Upload Excel<img
                                                        src="{{ asset('public/admin/assets/images/clickhe.png') }}"
                                                        alt=""></label>

                                            </div>
                                            <div id="error_excel"></div>
                                            <div class="form-group">
                                                <input type="submit" name="" value="Submit" class="btn btn-success"
                                                    style="width: 25%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->

@endsection

@section('script')
    @include('admin.includes.script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".rtg li a").click(function() {


                var url = $(this).attr('href');



                var vars = [],
                    hash;
                var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
                for (var i = 0; i < hashes.length; i++) {
                    hash = hashes[i].split('=');
                    vars.push(hash[0]);
                    vars[hash[0]] = hash[1];
                }
                // console.log(hash[1]);
                $('#page').val(hash[1]);
                $("#search_form").submit();
                return false;
            });
            @foreach (@$postcodes as $value)

                $("#action{{ $value->id }}").click(function(){
                $('.show-actions:not(#show-{{ $value->id }})').slideUp();
                $("#show-{{ $value->id }}").slideToggle();
                });
            @endforeach

            $('#excel_click').on('click', function(e) {
                $("#excel_modal").modal("show");
            })

        });
    </script>


    <script>
        $(document).ready(function() {
            $("#excel_form").validate({
                rules: {
                    excel: {
                        required: true,
                    },
                    country: {
                        required: true,
                    },
                    state: {
                        required: true,
                    },
                },
                ignore: [],
                messages: {
                    excel: {
                        required: 'Please upload excel file',
                    },
                    country: {
                        required: 'Please select country',
                    },
                    state: {
                        required: 'Please select state',
                    },

                },
                errorPlacement: function(error, element) {
                    console.log("Error placement called");
                    if (element.attr("name") == "excel") {

                        $("#error_excel").append(error);
                    }
                    if (element.attr("name") == "country") {

                        $("#error_country").append(error);
                    }
                    if (element.attr("name") == "state") {

                        $("#error_state").append(error);
                    }
                },
            });
        })
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#country').on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();

                $.ajax({
                    url: '{{ route('admin.manage.city.get-state') }}',
                    type: 'GET',
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#state').html(data.state);

                    }
                })
            })
            $('#state').change(function(){
                const state = $(this).val();
                $('#city').html('');
                if (state != "") {
                    $.ajax({
                            url: "{{route('admin.manage.postcode.get.city')}}",
                            method: 'POST',
                            data: {
                                jsonrpc: 2.0,
                                _token: "{{ csrf_token() }}",
                                params: {
                                    id: state,
                                },
                            },
                            dataType: 'JSON'
                        })
                        .done(function (response) {
                            if (response.city) {
                                $('#city').html(response.city)
                            }
                        })
                        .fail(function (error) {
                            $('#city').html('<option value="" selected>Select city</option>');
                        });
                } else {
                    $('#city').html('<option value="" selected>Select state</option>');
                }
            });
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#country_id').on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();

                $.ajax({
                    url: '{{ route('admin.manage.city.get-state') }}',
                    type: 'GET',
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        console.log(data);
                        $('#state_id').html(data.state);

                    }
                })
            })
            $('#state_id').change(function(){
                const state = $(this).val();
                $('#city_id').html('');
                if (state != "") {
                    $.ajax({
                            url: "{{route('admin.manage.postcode.get.city')}}",
                            method: 'POST',
                            data: {
                                jsonrpc: 2.0,
                                _token: "{{ csrf_token() }}",
                                params: {
                                    id: state,
                                },
                            },
                            dataType: 'JSON'
                        })
                        .done(function (response) {
                            if (response.city) {
                                $('#city').html(response.city)
                            }
                        })
                        .fail(function (error) {
                            $('#city_id').html('<option value="" selected>Select city</option>');
                        });
                } else {
                    $('#city_id').html('<option value="" selected>Select state</option>');
                }
            });
        })
    </script>
@endsection
