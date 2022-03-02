@extends('layouts.app')

@section('title')
<title>Date Exclusion List</title>
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
<div class="dashboard_sec">
    <div class="container">
        <div class="dashboard_iner">
            @include('includes.profile_sidebar')

            <div class="astro-dash-pro-right">
                <h1>Date Exclusion List</h1>@include('includes.message')
                <div class="astro_bac_list">
                    <ul>
                        <li ><a href="{{route('astrologer.profile')}}">
                                <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                                {{__('profile.basic_info')}}</a></li>
                        <li><a href="{{route('astrologer.education')}}">
                                <img src="{{ URL::to('public/frontend/images/bacicon2.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon22.png')}}" class="bacicon2" alt="">
                                {{__('profile.education')}}</a></li>
                        <li><a href="{{route('astrologer.experience')}}">
                                <img src="{{ URL::to('public/frontend/images/bacicon3.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon33.png')}}" class="bacicon2" alt="">
                                {{__('profile.experience_label')}}</a></li>
                        <li><a href="{{route('astrologer.availability')}}">
                                <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                                {{__('profile.availability')}}</a></li>
						<li class="actv"><a href="{{route('astrologer.date.exclusion.list')}}">
                                <img src="{{ URL::to('public/frontend/images/declined-white.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/declined-color.png')}}" class="bacicon2" alt="">
                                Date Exclusion List</a></li>
                    </ul>
                </div>
                <div class="astro-dash-right_iner">
                    <form action="{{route('astrologer.date.exclusion.list')}}" method="post" id="exclusion_from">
                        @csrf
                        <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Exclusion From Date</label>
                                        <input type="text" class="required" placeholder="Choose Date" name="exclusion_from_date" id="exclusion_from_date" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>Exclusion To Date</label>
                                        <input type="text" placeholder="Choose Date" name="exclusion_to_date" id="exclusion_to_date" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <input type="submit" value="add" name="exclusion_date_add" class="res">
                                    </div>
                                    <div class="add_btnbx">
                                        <a href="{{route('astrologer.date.exclusion.list')}}" class="res">Cancel</a>
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
                                    <th scope="col">Exclusion Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
							@if(@$datelist->isNotEmpty())
                                @foreach (@$datelist as $dates)
                                    <tr>
                                        <td>{{date('m/d/Y',strtotime($dates->date))}}</td>
                                        <td>
                                            <ul class="edit_action">
                                                <li><a href="{{route('astrologer.date.exclusion.delete',['id'=>$dates->id])}}" onclick="return confirm('Are you sure you want to delete this exclusion date?')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
								@endif
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
<!-- Time picek jas -->
<link rel='stylesheet' href='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css'>
<script src='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js'></script>

<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#exclusion_from_date , #exclusion_to_date" ).datepicker({
            minDate:new Date(),
            changeYear:true,
            changeMonth:true,
        });
  } );
//   $('.res').click(function(e){
//       e.preventDefault();

//   })
</script>
<!-- End -->
<script>
    $(".shopcut").click(function(){
        $(".shopcutBx").slideToggle();
    });

</script>
{{-- @include('includes.toaster') --}}
<script>
    function fun1(){
    var i=document.getElementById('profile_pic').files[0];
    var b=URL.createObjectURL(i);
    $("#img2").attr("src",b);
    }
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script>
    $(document).ready(function(){
        jQuery.validator.addMethod("greaterThan",
            function(value, element, params) {
                if(value){
                    if (!/Invalid|NaN/.test(new Date(value))) {
                        return (new Date(value) >= new Date($(params).val()))
                    }


                    return isNaN(value) && isNaN($(params).val())
                    || (Number(value) >= Number($(params).val()))
                }else{
                    return true
                }

            },'Must be less than exclusion to date.');
        $("#exclusion_from").validate({
            rules:{
                exclusion_from_date:{
                    required: true
                },
                exclusion_to_date:{
                    greaterThan: "#exclusion_from_date"
                }
            }
        });
	});
</script>

@endsection
