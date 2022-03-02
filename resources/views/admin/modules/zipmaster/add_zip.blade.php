@extends('admin.layouts.app')
@section('title')
<title>Astroaquila | Add Postcode</title>
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
                    <h4 class="pull-left page-title">Add Postcode</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.zip')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                     @include('admin.includes.message')
                    <div>
                        <div class="panel panel-default panel-fill">
                            <div class="panel-heading">
                                <h3 class="panel-title">Add Postcode </h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.add.zip.code')}}" method="POST" id="zipForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="FullName">Country</label>
                                        <select class="form-control rm06 basic-select" name="country" id="country">
                                            <option value="">Select Country</option>
                                            @foreach(@$countries as $value)
                                            <option value="{{@$value->id}}">{{@$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="state_name">State</label>
                                        <select class="form-control rm06 basic-select" name="state" id="state">
                                            <option value="">Select State</option>
                                        </select>
                                        <label id="state-error" class="error" for="state_name"></label>
                                    </div>

                                    <div class="form-group">
                                            <label for="city_name">City</label>
                                            <select class="form-control rm06 basic-select" name="city" id="city">
                                                <option value="">Select City</option>
                                            </select>
                                            <label id="city-error" class="error" for="city_name"></label>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Postcode</label>
                                        <input type="text" placeholder="Enter Zip Code" id="zip" class="form-control" name="name" >
                                       <div id="err_zip" style="color: red;display: none;">Postcode already added for this country</div>
                                    </div>
                                    <div class="col-md-6 col-sm-6" >
                                        <div class="form-group rm03">
                                            <div class="checkBox">
                                                <span><b>Puja Available ?</b></span>
                                                <ul>
                                                    <li>
                                                        <input type="radio" id="radio1" name="puja_available"
                                                            value="Y" >
                                                        <label for="radio1">Yes</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="radio2" name="puja_available" value="N" checked>
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
                                                        <input type="radio" id="radio3" name="service_available" value="Y">
                                                        <label for="radio3">Yes</label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="radio4" name="service_available" value="N" checked>
                                                        <label for="radio4">No</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
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
                name: {
                   required:true,
                   remote:{
                        url:"{{route('admin.manage.zipcode.check.postcode')}}",
                        data:{
                            country_id:function(){return $('#country').val()},
                        }
                    }
                },
                country:{
                    required:true,
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
            },

        messages: {
            name: {
                required:'Please enter zip code',
                remote:"This postcode already exist for this country"
            },
            country:{
                required:'Please select country',
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

        },
        submitHandler: function(form){
              var zip = $('#zip').val();
              var country = $('#country').val();
                //   $.ajax({
                //           url:"{{route('admin.zipcode.check.zipcode')}}",
                //           method:"GET",
                //           data:{'zip':zip,'country':country},
                //           success: function(res) {
                //           console.log(res);
                //           if (res=="found") {
                //             $('#err_zip').css('display','block');
                //             return false;
                //          }else{
                //           form.submit();

                //          }
                //        }
                //    });
                form.submit();

            }

        });

        $('#country').change(function(){
            const countryId = $(this).val();
            $('#state').html('');
            if (countryId != "") {
                  $.ajax({
                          url: "{{route('admin.manage.zipcode.get.state')}}",
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
                  $('#city').html('<option value="" selected>Select state</option>');
              }
        });
    })
</script>
@endsection
