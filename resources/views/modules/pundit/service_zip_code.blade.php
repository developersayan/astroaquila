@extends('layouts.app')

@section('title')
<title>
    Service Area
</title>
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
{{-- @include('includes.heder_profile') --}}
@include('includes.header')
@endsection

@section('body')
<div class="dashboard_sec">
    <div class="container">
        <div class="dashboard_iner">
            @include('includes.profile_sidebar')

            <div class="astro-dash-pro-right">
                <h1>Service Area</h1>@include('includes.message')
                <div class="astro_bac_list">
                    <ul>
                        <li>
                            <a href="{{route('pundit.profile')}}">
                                <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                                {{__('profile.basic_info')}}
                            </a>
                        </li>
                        <li>
                            <a href="{{route('pundit.puja')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon5.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon55.png')}}" class="bacicon2" alt="">
                            {{__('profile.puja')}}</a>
                        </li>
                        <li class="actv">
                            <a href="{{route('pundit.puja.service')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Service Area</a>
                        </li>

                        <li><a href="{{route('pundit.availability')}}">
                            <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                            <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            {{__('profile.availability')}}</a></li>
                    </ul>
                </div>
                <div class="astro-dash-right_iner">
                    <form method="POST" action="{{route('pundit.puja.service.save')}}" id="addserviceform">
                        @csrf
                        <div class="astro-dash-form">
                            <div class="row">

                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Country</label>
                                        <select name="country" id="country">
                                            <option value="">Select Coountry</option>
                                            @foreach ($country as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Zip Code</label>
                                        <select name="zipcode" id="zipcode">
                                            <option value="">Select ZipCode</option>
                                            {{-- @foreach ($allZipCode as $zipCode)
                                            <option value="{{$zipCode->id}}">{{$zipCode->zipcode}}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <input type="submit" value="{{@$selectPuja?__('profile.edit'):__('profile.add')}}" class="res">
                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="save_coniBx">

                    </div>
                    <div class="table_sec">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Country</th>
                                    <th scope="col">Service Zip Code</th>
                                    <th scope="col">{{__('profile.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( @$zipCodeList as $puja)

                                <tr>
                                    <td>{{@$puja->zip->countrylist->name}}</td>
                                    <td>{{@$puja->zip->zipcode}}</td>
                                    <td>
                                        <ul class="edit_action">
                                            <li><a href="{{route('pundit.puja.service.delete' , ['id' => $puja->id])}}" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you want to delete Service Zip Code ?');"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')

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
        $("#addserviceform").validate({
            rules: {
                zipcode:{
                    required: true,
                },
                country:{
                    required:true,
                },
            },
            messages: {
                zipcode:{
                    required: 'Zip Code Required',
                },
                country:{
                    required:'Please select country',
                },
            },
            submitHandler: function(form){
              var zipcode = $('#zipcode').val();
              var country = $('#country').val();
              $.ajax({
                      url:"{{route('pundit.puja.service.check-zipcode')}}",
                      method:"GET",
                      data:{'zipcode':zipcode,'country':country},
                      success: function(res) {
                      console.log(res);
                      if (res=="found") {
                        alert('Zipcode already added');
                        // $('#err_zip').css('display','block');
                        return false;
                     }else{
                      form.submit();

                     }
                   }
               });
          }
        });
    })
</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#country').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();
      $.ajax({
        url:'{{route('pundit.puja.service.get-zipcode')}}',
        type:'GET',
        data:{country:id},
        success:function(data){
          console.log(data);
          $('#zipcode').html(data.zipcode);
        }
      })
    })
  })
</script>
@endsection
