@extends('admin.layouts.app')


@section('title')
    <title>Astroaquila | Manage Area</title>
@endsection

@section('style')
    @include('admin.includes.style')
@endsection

@section('content')
    <!-- Top Bar Start -->
    @include('admin.includes.header')
    <!-- Top Bar End -->


    <!-- ========== Left Sidebar Start ========== -->
    @include('admin.includes.sidebar')
    <!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <!-- Start content -->
        <div class="content">
            <div class="container">

                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">Manage Area</h4>
                        <ol class="breadcrumb pull-right">
                            <li class="active"><a href="{{ route('admin.add.area.add') }}"><i class="fa fa-plus"
                                        aria-hidden="true"></i> Add Area</a></li>

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
                                <form role="form" action="{{ route('admin.manage.area') }}" method="get"
                                    id="search_form">
                                    <input type="hidden" name="page" value="" id="page">
                                    <div class="form-group">
                                        <label for="FullName">Country</label>
                                        <select class="form-control rm06 basic-select" name="country" id="country_id">
                                            <option value="">Select Country</option>
                                            @foreach (@$countries as $value)
                                                <option value="{{ @$value->id }}" @if (request('country') == @$value->id) selected @endif>
                                                    {{ @$value->name }}</option>
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
                                                    <option value="{{@$val2->id}}" @if (request('city') == @$val2->id) selected @endif>{{@$val2->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="FullName">Postcode</label>
                                        <select class="form-control rm06 basic-select" name="postcode" id="postcode_id">
                                            <option value="">Select postcode</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="FullName">Search By Area</label>
                                        <input type="text" id="FullName" class="form-control"
                                            value="{{ request('name') }}" name="name" placeholder="Area">
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
                                                        <th>Area</th>
                                                        <th class="rm07">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($areas->isNotEmpty())
                                                        @foreach (@$areas as $value)
                                                            <tr>
                                                                <td>{{ @$value->countrylist->name }}</td>
                                                                <td>{{ @$value->getState->name }}</td>
                                                                <td>{{ @$value->getCity->name }}</td>
                                                                <td>{{ @$value->getPostcode->zipcode }}</td>
                                                                <td>
                                                                    {{ @$value->area }}
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
                                                                                    href="{{ route('admin.manage.area.edit', ['id' => $value->id]) }}">Edit
                                                                                </a></li>
                                                                            <li><a href="{{ route('admin.delete.area', ['id' => $value->id]) }}"
                                                                                    onclick="return confirm('Do you want to delete this postcode?')">Delete</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else

                                                        <tr>
                                                            <td colspan="4">
                                                                <center> No Data </center>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>


                                        <ul class="pagination rtg">
                                            {{ @$areas->links() }}
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
                @foreach (@$areas as $value)

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
                        url: "{{route('admin.manage.zipcode.get.city')}}",
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
                            $('#city_id').html(response.city)
                        }
                    })
                    .fail(function (error) {
                        $('#city_id').html('<option value="" selected>Select city</option>');
                    });
            } else {
                $('#city_id').html('<option value="" selected>Select state</option>');
            }
        });
        $('#city_id').change(function(){
            var state = $('#state_id').val();
            var city = $(this).val();
            $('#postcode_id').html('');
            if (state != "" && city != "") {
                  $.ajax({
                          url: "{{route('admin.manage.area.get.area')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  state: state,
                                  city: city,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.postcode) {
                            $('#postcode_id').html(response.postcode)
                          }
                      })
                      .fail(function (error) {
                          $('#postcode_id').html('<option value="" selected>Select postcode</option>');
                      });
              } else {
                  $('#postcode_id').html('<option value="" selected>Select postcode</option>');
              }
        });
    })
</script>
    @endsection
