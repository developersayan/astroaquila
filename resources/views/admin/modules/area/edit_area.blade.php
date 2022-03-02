@extends('admin.layouts.app')
@section('title')
<title>Astroaquila | Edit Area</title>
@endsection

@section('style')
@include('admin.includes.style')
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.sidebar')
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="pull-left page-title">Edit Area</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.area')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                     @include('admin.includes.message')
                    <div>
                        <div class="panel panel-default panel-fill">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit Area </h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.area.update')}}" method="POST" id="zipForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{@$data->id}}">
                                    <div class="form-group">
                                        <label for="FullName">Country</label>
                                        <select class="form-control rm06 basic-select" name="country" id="country">
                                            <option value="">Select Country</option>
                                            @foreach(@$countries as $value)
                                                <option value="{{@$value->id}}" @if(@$data->country_id==@$value->id) selected @endif>{{@$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="state_name">State</label>
                                        <select class="form-control rm06 basic-select" name="state" id="state">
                                            <option value="">Select State</option>
                                            @if(@$states)
                                                @foreach (@$states as $st)
                                                    <option value="{{@$st->id}}" @if(@$st->id == @$data->state_id) selected @endif>{{@$st->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label id="state-error" class="error" for="state_name"></label>
                                    </div>

                                    <div class="form-group">
                                        <label for="city_name">City</label>
                                        <select class="form-control rm06 basic-select" name="city" id="city">
                                            <option value="">Select City</option>
                                            @if(@$cities)
                                                @foreach (@$cities as $ct)
                                                    <option value="{{@$ct->id}}" @if(@$ct->id == @$data->city_id) selected @endif>{{@$ct->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label id="city-error" class="error" for="city_name"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Postcode</label>
                                        <select class="form-control rm06 basic-select" name="postcode" id="postcode">
                                            <option value="">Select Postcode</option>
                                            @if(@$postcodes)
                                                @foreach (@$postcodes as $post)
                                                    <option value="{{@$post->id}}" @if(@$post->id == @$data->postcode_id) selected @endif>{{@$post->zipcode}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label id="postcode-error" class="error" for="postcode_name"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Area</label>
                                        <input type="text" placeholder="Enter Area" id="area" class="form-control" name="area" value="{{@$data->area}}" >
                                        <label id="area-error" class="error" for="area_name"></label>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
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
<script>
    $(document).ready(function(){
       $("#zipForm").validate({
            rules: {
                area: {
                   required:true,
                   remote:{
                        url:"{{route('admin.check.area')}}",
                        data:{
                            state:function(){return $('#state').val()},
                            city:function(){return $('#city').val()},
                            postcode:function(){return $('#postcode').val()},
                            id:function(){return $('#id').val()},
                        }
                    }
                },
                state:{
                    required: true,
                },
                city:{
                    required: true,
                },
                postcode:{
                    required: true,
                },
            },

            messages: {
                area: {
                    required:'Please enter area',
                    remote:"This area already exist for this postcode"
                },
                state:{
                    required:'Please select state',
                },
                city:{
                    required:'Please select city',
                },
                postcode:{
                    required:'Please select postcode',
                }
            },
            submitHandler: function(form){
                    form.submit();

            }

        });
        $('#country').change(function(){
            const countryId = $(this).val();
            $('#state').html('');
            if (countryId != "") {
                  $.ajax({
                          url: "{{route('admin.manage.area.get.state')}}",
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
                            $('#city').html(response.city)
                          }
                      })
                      .fail(function (error) {
                          $('#city').html('<option value="" selected>Select city</option>');
                      });
              } else {
                  $('#city').html('<option value="" selected>Select city</option>');
              }
        });

        $('#city').change(function(){
            var state = $('#state').val();
            var city = $(this).val();
            $('#postcode').html('');
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
                            $('#postcode').html(response.postcode)
                          }
                      })
                      .fail(function (error) {
                          $('#postcode').html('<option value="" selected>Select postcode</option>');
                      });
              } else {
                  $('#postcode').html('<option value="" selected>Select postcode</option>');
              }
        });
    })
</script>
@endsection
