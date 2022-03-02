@extends('layouts.app')

@section('title')
<title>{{ __('profile.astro_tip_title')}}</title>
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
                <h1>{{__('profile.astro_tip_title')}}</h1>@include('includes.message')
                <div class="astro-dash-right_iner">
                    <form action="{{@$tip?route('update.astro.tips',['id'=>$tip->id]):route('add.astro.tips')}}" method="post" id="tips_from">
                        @csrf
                        <input type="hidden" name="tip_id" value="{{@$tip->id}}">
                        <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.astro_tip_heading')}}</label>
                                        <input type="text" placeholder="{{__('profile.astro_tip_heading')}}" name="heading" value="{{@$tip->heading}}" id="heading">
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="form_box_area">
                                        <label>{{__('profile.astro_tip_description')}}</label>
                                        <textarea placeholder="{{__('profile.astro_tip_description')}}" name="description"id="description">{{@$tip->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <input type="submit" value="{{@$tip?__('profile.edit'):__('profile.add')}}" class="res">
                                    </div>
                                    <div class="add_btnbx">
                                        <a href="{{route('manage.astro.tips')}}" class="res">{{__('profile.cancel')}}</a>
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
                                    <th scope="col">{{__('profile.astro_tip_heading')}}</th>
                                    <th scope="col">{{__('profile.astro_tip_description')}}</th>
                                    <th scope="col">{{__('profile.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($tips)>0)
                                    @foreach (@$tips as $tip)
                                        <tr>
                                            <td>{{$tip->heading}}</td>
                                            <td>{{$tip->description}}</td>
                                            <td>
                                                <ul class="edit_action">
                                                    <li><a href="{{route('edit.astro.tips',['id'=>$tip->id])}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a></li>
                                                    <li><a href="{{route('delete.astro.tips',['id'=>$tip->id])}}" onclick="return confirm('{{__('profile.astro_tip_delete_confirm')}}')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3">No data found</td>
                                    </tr>
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
        $("#tips_from").validate({
            rules: {
                heading:{
                    required: true,
                    maxlength:10
                },
                description:{
                    required: true,
                    maxlength:200
                },

            },
            messages: {
                heading:{
                    required: '{{__('profile.required_education')}}',
                },
                description:{
                    required: '{{__('profile.required_institute')}}',
                },
            },
        });
    });
</script>

@endsection
