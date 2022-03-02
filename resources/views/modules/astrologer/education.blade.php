@extends('layouts.app')

@section('title')
<title>{{ @$education ? __('profile.education_update_title') :__('profile.education_title')}}</title>
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
    <style type="text/css">
        .form-group span {
            font-size: 15px;
            color: #8a8a8a;
        }

        .uplodimgfilimg {
            margin-left: 20px;
            padding-top: 20px;
        }

        .uplodimgfilimg em {
            width: 120px;
            height: 58px;
            position: relative;
            display: inline-block;
            overflow: hidden;
            border-radius: 4px;
        }

        .uplodimgfilimg em img {
            position: absolute;
            max-width: 100%;
            max-height: 100%;
        }
        .checkBoxAstroTP {
            width: 33% !important;
            float: left !important;
        }
    </style>
@endsection

@section('body')
<div class="dashboard_sec">
    <div class="container">
        <div class="dashboard_iner">
            @include('includes.profile_sidebar')

            <div class="astro-dash-pro-right">
                <h1>{{__('profile.education')}}</h1>@include('includes.message')
                <div class="astro_bac_list">
                    <ul>
                        <li ><a href="{{route('astrologer.profile')}}">
                                <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                                {{__('profile.basic_info')}}</a></li>
                        <li class="actv"><a href="{{route('astrologer.education')}}">
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
						<li><a href="{{route('astrologer.date.exclusion.list')}}">
                                <img src="{{ URL::to('public/frontend/images/declined-white.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/declined-color.png')}}" class="bacicon2" alt="">
                                Date Exclusion List</a></li>
                    </ul>
                </div>
                <div class="astro-dash-right_iner">
                    <form action="{{@$education?route('astrologer.education.update',['id'=>$education->id]):route('astrologer.education.save')}}" method="post" id="education_from" enctype="multipart/form-data">
                        @csrf
                        <div class="astro-dash-form">
                            <div class="row">
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.education_label')}}</label>
                                        <input type="text" placeholder="{{__('profile.education_placeholder')}}" name="education_title" value="{{@$education->education_title}}" id="education_title">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.institute_label')}}</label>
                                        <input type="text" placeholder="{{__('profile.institute_placeholder')}}" name="institute" value="{{@$education->institute}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <label>{{__('profile.year_of_passing_label')}}</label>
                                        <input type="text" placeholder="{{__('profile.year_of_passing_placeholder')}}" name="year_of_passing" value="{{@$education->year_of_passing}}">
                                    </div>
                                </div>


                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                       <label for="file">Upload Image</label>
                                       <div class="uplodimg">
                                         <div class="uplodimgfil" style="margin-top: 5px;">
                                                <input type="hidden" name="astro_image" id="astro_image" value="{{ @$education->image}}">
                                                <input type="file" id="image" name="image" accept="image/*">
                                                <label for="image">Upload Image<img
                                                        src="{{ asset('public/admin/assets/images/clickhe.png') }}"
                                                        alt=""></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-6">
                                    <div class="form_box_area">
                                        <div class="uplodimgfilimg ">
                                                <em><img src="{{ URL::to('storage/app/public/education_image') }}/{{ @$education->image }}"
                                                        alt="" id="img2"></em>
                                            </div>
                                    </div>
                                </div>
                                





                                <div class="col-md-12 col-sm-12">
                                    <div class="add_btnbx">
                                        <input type="submit" value="{{@$education?__('profile.edit'):__('profile.add')}}" class="res">
                                    </div>
                                    <div class="add_btnbx">
                                        <a href="{{route('astrologer.education')}}" class="res">{{__('profile.cancel')}}</a>
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
                                    <th scope="col">{{__('profile.education_title')}}</th>
                                    <th scope="col">{{__('profile.institute_label')}}</th>
                                    <th scope="col">{{__('profile.year_of_passing_label')}}</th>
                                    <th scope="col">Image</th>

                                    <th scope="col">{{__('profile.action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$educationList as $educations)
                                    <tr>
                                        <td>{{$educations->education_title}}</td>
                                        <td>{{$educations->institute}}</td>
                                        <td>{{$educations->year_of_passing}}</td>
                                        <td class="w80">
                                            @if($educations->image)
                                            <img src="{{ URL::to('storage/app/public/education_image') }}/{{ @$educations->image }}" style="width: 50px;height: 50px;">
                                            @else
                                            ---
                                            @endif
                                        </td>
                                        <td>
                                            <ul class="edit_action">
                                                <li><a href="{{route('astrologer.education.edit',['id'=>$educations->id])}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a></li>
                                                <li><a href="{{route('astrologer.education.delete',['id'=>$educations->id])}}" onclick="return confirm('{{__('profile.confirmation_msg_delete_education')}}')" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
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
<!-- Time picek jas -->
<link rel='stylesheet' href='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.css'>
<script src='https://weareoutman.github.io/clockpicker/dist/jquery-clockpicker.min.js'></script>

<!--date picker-->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
            $("#image").change(function () {
            $('.uplodimgfilimg').html('');
            let files = this.files;
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (! valid) {
                    alert('Please choose valid image files (jpeg, png, gif) only.');
                    $("#image").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('.uplodimgfilimg').append('<li><img style="max-width: 100px;" src="' + e.target.result + '"></li>');
                    };
                    reader.readAsDataURL(f);
                });
            }

        });
</script>
<script>
    $( function() {
    $( "#datepicker" ).datepicker({
        changeYear:true,
        yearRange: "2005:2015"
    });
  } );
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
        $.validator.addMethod("year", function(value, element, max) {
            if(value<= max && value>1900){
                return true;
            }
            else if(value==''){
                return true;
            }
        }, "{{__('profile.year_year_of_passing')}}");
        $("#education_from").validate({
            rules: {
                education_title:{
                    required: true,
                    remote: {
                          url:  '{{route('astrologer.check.education')}}',
                          type: "GET",
                          data: {
                            education_title: function() {
                              return $( "#education_title").val();
                         },
                         'id':"{{@$education->id}}",
                       },
                    },
                },
                institute:{
                    required: true,
                },
                year_of_passing:{
                    required: true,
                    number: true ,
                    year: 2020,
                },

            },
            messages: {
                education_title:{
                    required: '{{__('profile.required_education')}}',
                    remote:'{{__('profile.education_exits')}}'
                },
                institute:{
                    required: '{{__('profile.required_institute')}}',
                },
                year_of_passing:{
                    required: '{{__('profile.required_year_of_passing')}}',
                    number: '{{__('profile.number_year_of_passing')}}' ,
                    year: '{{__('profile.year_year_of_passing')}}' ,
                },
            },
        });
    });
</script>

@endsection
