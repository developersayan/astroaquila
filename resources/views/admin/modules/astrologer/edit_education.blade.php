@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | @if(@$edu)Edut @else Add @endif Astrologer Education</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  .edit_action li {
    display: inline-block;
    margin: 0 4px;
}
</style>
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

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')
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
            <h4 class="pull-left page-title">@if(@$edu)Edut @else Add @endif Education</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.astrologer')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                        <div class="col-lg-12"> 
                           <div class="astro_bac_list">
                          <ul>
                            <li ><a href="{{route('admin.astrologer.edit-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            Basic Info</a></li>
                            <li class="actv"><a href="{{route('admin.astrologer.edit-education-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon2.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon22.png')}}" class="bacicon2" alt="">
                            Education</a></li>
                            <li><a href="{{route('admin.astrologer.edit-exp-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon3.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon33.png')}}" class="bacicon2" alt="">
                            Experience</a></li>
                            <li><a href="{{route('admin.astrologer.edit-avail-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon4.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon44.png')}}" class="bacicon2" alt="">
                            Availability</a></li>
							<li><a href="{{route('admin.astrologer.date.exclusion',['id'=>@$data->id])}}">
                                <img src="{{ URL::to('public/frontend/images/declined-white.png')}}" class="bacicon1" alt="">
                                <img src="{{ URL::to('public/frontend/images/declined-color.png')}}" class="bacicon2" alt="">
                                Date Exclusion List</a></li>
                          </ul>
                        </div>
                        @include('admin.includes.message')  
                        <div> 
                           
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">@if(@$edu)Edut @else Add @endif Education</h3> 
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                        <form role="form" id="education_from" method="post" enctype="multipart/form-data" action="@if(@$edu){{route('admin.astrologer.update-education')}} @else {{route('admin.astrologer.add-education')}} @endif">
                                        	@csrf
                                          <input type="hidden" name="user_id" value="{{@$data->id}}">
                                          <input type="hidden" name="edu_id" value="{{@$edu->id}}">
                                            <div class="form-group">
                                                <label for="FullName">Education title</label>
                                                <input type="text" placeholder="Education title" id="education_title" name="education_title" class="form-control" value="@if(@$edu) {{@$edu->education_title}} @endif">
                                                <div class="error" id="name_error"></div>
                                            </div>
                                            

                                            <div class="form-group">
                                                <label for="FullName">Institute</label>
                                                <input type="text" placeholder="Institute" name="institute" class="form-control" value="@if(@$edu) {{@$edu->institute}} @endif">
                                                <div class="error" id="price_error"></div>
                                            </div>

                                             <div class="form-group">
                                                <label for="FullName">Year of Passing</label>
                                                <input type="text" placeholder="Year of Passing" name="year_of_passing" class="form-control" value="@if(@$edu){{@$edu->year_of_passing}}@endif">
                                                <div class="error" id="price_error"></div>
                                            </div>

                                            <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="file">Image</label>
                                            <div class="uplodimgfil" style="margin-top: 5px;">
                                                <input type="hidden" name="astro_image" id="astro_image" value="{{ @$edu->image}}">
                                                <input type="file" id="image" name="image" accept="image/*">
                                                <label for="image">Upload Image<img
                                                        src="{{ asset('public/admin/assets/images/clickhe.png') }}"
                                                        alt=""></label>
                                            </div>
                                            <label for="image" id="image-error" class="error"></label>
                                        </div>



                                        <div class="form-group" style="position: relative;">
                                          <a class="del_image del-custom-class" data-id="{{@$edu->id}}" @if(@$edu->image=='') style="display:none " @endif > <i class="fa fa-times" aria-hidden="true"></i></a>
                                            <div class="uplodimgfilimg ">
                                                <em><img src="{{ URL::to('storage/app/public/education_image') }}/{{ @$edu->image }}"
                                                        alt="" id="img2"></em>
                                            </div>

                                        </div>


                                        

                                           <div class="clearfix"></div>
                                            <div class="col-lg-6"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">@if(@$edu)Update @else Save @endif</button> <a class="btn btn-primary waves-effect waves-light w-md" type="submit" href="{{route('admin.astrologer.edit-education-view',['id'=>@$data->id])}}">Cancel</a> </div>
                                            
                                        </form>

                                    </div> 
                                </div>
                                <!-- Personal-Information -->
                                 <div class="panel panel-default panel-fill">
                                   
                                    <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Education </th>
                                          <th> Institute</th>
                                          <th>Year of Passing</th>
                                          <th>Image</th>  
                                          <th class="rm07"> Action</th>                            
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @if(@$educations->isNotEmpty())
                                        @foreach(@$educations as $education)
                                        <tr>
                                          <td>{{$education->education_title}}</td>
                                          <td>{{$education->institute}}</td>
                                          <td>{{$education->year_of_passing}}</td>
                                          <td class="w80">
                                            @if($education->image)
                                            <img src="{{ URL::to('storage/app/public/education_image') }}/{{ @$education->image }}" style="width: 50px;height: 50px;">
                                            @else
                                            ---
                                            @endif
                                        </td>
                                          <td class="rm07">
                                             <ul class="edit_action">
                                                <li><a href="{{route('admin.astrologer.edit-education',['edu'=>$education->id])}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a></li>
                                                
                                                <li><a href="{{route('admin.astrologer.delete-education',['edu'=>$education->id])}}" onclick="return confirm('Do you want to delete this astrologer education ?')"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                        {{--   <a href="javascript:void(0);" class="action-dots" id="action{{@$education->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                          <div class="show-actions" style="right: 45px;" id="show-{{@$education->id}}" style="display: none;">
                                              <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                            <ul>
                                              <li><a href="{{route('admin.astrologer.edit-education',['edu'=>$education->id])}}">Edit</a></li>
                                             <li><a  href="{{route('admin.astrologer.delete-education',['edu'=>$education->id])}}" onclick="return confirm('Do you want to delete this astrologer education ?')">Delete</a></li>
                                            </ul>
                                            </div> --}}
                                          </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr><td>No Data</td></tr>
                                        @endif
                                      </tbody>
                                    </table>
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
  </div>
  <!-- ============================================================== --> 
  <!-- End Right content here --> 
@endsection 
@section('script')
@include('admin.includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>


<script type="text/javascript">
  $('.del_image').on('click',function(e){
    if(confirm("Do You want remove this image?")){
    var id = $(this).data('id');
    $.ajax({
      url:'{{route('admin.astrologer.delete.eduction.image')}}',
      type: "POST",
      data:{
         id:id,
        _token: '{{ csrf_token() }}',
      },

      success: function(res) {
        $("#img2").attr("src",'');
        $('.uplodimgfilimg').hide();
        $('.del_image').hide();
      }  
  });
  }
  })
</script>


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


<script type="text/javascript">
    @foreach (@$educations as $education)

    $("#action{{$education->id}}").click(function(){
        $('.show-actions:not(#show-{{$education->id}})').slideUp();
        $("#show-{{$education->id}}").slideToggle();
    });
 @endforeach
</script>
<script>
    $(document).ready(function(){
        $.validator.addMethod("year", function(value, element, max) {
            if(value<= max && value>1900){
                return true;
            }
            else if(value==''){
                return true;
            }
        }, "{{__('Should be less than current year')}}");
        $("#education_from").validate({
            rules: {
                education_title:{
                    required: true,
                    remote: {
                          url:  '{{route('admin.astrologer.check-education')}}',
                          type: "GET",
                          data: {
                            education_title: function() {
                              return $( "#education_title").val();
                         },
                         'id':"{{@$edu->id}}",
                         'user_id':"{{@$data->id}}",
                       },
                    },
                },
                institute:{
                    required: true,
                },
                year_of_passing:{
                    required: true,
                    number: true ,
                    year:2020,
              },

            },
            messages: {
                education_title:{
                    required: 'please enter title',
                    remote:'Education is already added',
                },
                institute:{
                    required: 'Please enter institute name',
                },
                year_of_passing:{
                    required: 'Please enter year of passing',
                    year: 'Year should be less than current year and greater than 1900',
                },
            },
        });
    });
</script>

@endsection