@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | @if(@$details) Edit @else Add @endif Postcode</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
    #err_state{
        display: none;
        color: red;
    }
</style>
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.sidebar')
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="pull-left page-title">@if(@$details) Edit @else Add @endif Postcode</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.postcode')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                     @include('admin.includes.message')
                    <div>

                        <!-- Personal-Information -->
                        <div class="panel panel-default panel-fill">
                            <div class="panel-heading">
                                <h3 class="panel-title">@if(@$details) Edit @else Add @endif Postcode</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form"  method="POST" action="@if(@$details) {{route('admin.manage.postcode.update')}} @else {{route('admin.manage.postcode.insert')}} @endif" id="stateadd" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="id" id="id" value="{{@$details->id}}">
                                    <div class="form-group">
                                        <label for="FullName">Country</label>
                                        <select class="form-control rm06 basic-select" name="country" id="country">
                                            <option value="">Select Country</option>
                                            @foreach(@$countries as $country)
                                            <option value="{{@$country->id}}" @if(@$country->id == @$details->country_id) selected @endif>{{@$country->name}}</option>
                                            @endforeach
                                        </select>
                                        <label id="country-error" class="error" for="country"></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="state_name">State</label>
                                        <select class="form-control rm06 basic-select" name="state" id="state">
                                            <option value="">Select State</option>
                                            @if(@$states)
                                                @foreach (@$states as $st)
                                                    <option value="{{@$st->id}}" @if(@$st->id == @$details->state_id) selected @endif>{{@$st->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label id="state-error" class="error" for="state_name"></label>
                                    </div>

                                    <div class="form-group">
                                            <label for="city_name">City name</label>
                                            <select class="form-control rm06 basic-select" name="city" id="city">
                                                <option value="">Select City</option>
                                                @if(@$cities)
                                                    @foreach (@$cities as $ct)
                                                        <option value="{{@$ct->id}}" @if(@$ct->id == @$details->city_id) selected @endif>{{@$ct->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label id="city-error" class="error" for="city_name"></label>
                                    </div>
                                    <div class="form-group">
                                            <label for="postcode_name">Postcode</label>
                                            <input id="postcode" type="text" value="{{@$details->postcode}}" name="postcode" placeholder="Post Code">
                                            <label id="postcode-error" class="error" for="postcode_name"></label>
                                    </div>
                                    <div class="col-md-6 col-sm-6" >
                                        <div class="form-group rm03">
                                            <div class="checkBox">
                                                <span><b>Puja Available ?</b></span>
                                                <ul>
                                                    <li>
                                                        <input type="radio" id="radio1" name="puja_available"
                                                            value="Y" @if(@$details->puja_available == 'Y') checked @endif>
                                                        <label for="radio1">Yes</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="radio2" name="puja_available" value="N" @if(@$details->puja_available == 'N') checked @endif>
                                                        <label for="radio2">No</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-6" >
                                        <div class="form-group rm03">
                                            <div class="checkBox">
                                                <span><b>Service Available ?</b></span>
                                                <ul>
                                                    <li>
                                                        <input type="radio" id="radio3" name="service_available" value="Y" @if(@$details->service_available == 'Y') checked @endif>
                                                        <label for="radio3">Yes</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="radio4" name="service_available" value="N" @if(@$details->service_available == 'N') checked @endif>
                                                        <label for="radio4">No</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                <div class="col-lg-12">
                                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @include('admin.includes.footer')
</div>
@endsection

@section('script')
@include('admin.includes.script')


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#stateadd").validate({
            rules: {
                country:{
                    required: true,
                  },
                  state:{
                    required: true,
                  },
                  city:{
                    required: true,
                  },
                  puja_available:{
                    required: true,
                  },
                  service_available:{
                    required: true,
                  },
                  postcode:{
                    required: true,
                    remote:{
                        url:"{{route('admin.manage.postcode.check.postcode')}}",
                        data:{
                            country_id:function(){return $('#country').val()},
                            id:function(){return $('#id').val()}
                        }
                    }
                  },
               },
               messages:{
                    country:{
                        required:'Please select a country',
                    },
                    state:{
                        required:'Please select state',
                    },
                    city:{
                        required:'Please select city',
                    },
                    puja_available:{
                        required:'Please select puja availability',
                    },
                    service_available:{
                        required:'Please select service availibility',
                    },
                    postcode:{
                        required: 'Please enter postcode',
                        remote:"This postcode already exist for this country"
                    },
               },
               submitHandler: function(form){
                    form.submit();
               }
            });
        })

        $('#country').change(function(){
            const countryId = $(this).val();
            $('#state').html('');
            if (countryId != "") {
                  $.ajax({
                          url: "{{route('admin.manage.postcode.get.state')}}",
                          method: 'POST',
                          data: {
                              jsonrpc: 2.0,
                              _token: "{{ csrf_token() }}",
                              params: {
                                  id: countryId,
                              },
                          },
                          dataType: 'JSON'
                      })
                      .done(function (response) {
                          if (response.state) {
                              $('#state').html(response.state)
                          }
                      })
                      .fail(function (error) {
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
</script>


@endsection
