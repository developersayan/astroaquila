@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | @if(@$exp)Edit @else Add @endif Astrologer Experience</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  .edit_action li {
    display: inline-block;
    margin: 0 4px;
}
</style>
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
            <h4 class="pull-left page-title">@if(@$exp)Edit @else Add @endif Experience</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.astrologer')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                    <div class="col-lg-12"> 
                        <div class="astro_bac_list">
                          <ul>
                            <li><a href="{{route('admin.astrologer.edit-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon1.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon11.png')}}" class="bacicon2" alt="">
                            Basic Info</a></li>
                            <li ><a href="{{route('admin.astrologer.edit-education-view',['id'=>@$data->id])}}">
                              <img src="{{ URL::to('public/frontend/images/bacicon2.png')}}" class="bacicon1" alt="">
                              <img src="{{ URL::to('public/frontend/images/bacicon22.png')}}" class="bacicon2" alt="">
                            Education</a></li>
                            <li class="actv"><a href="{{route('admin.astrologer.edit-exp-view',['id'=>@$data->id])}}">
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
                                        <h3 class="panel-title">@if(@$exp)Edit @else Add @endif Experience</h3> 
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                        <form role="form" id="experience_from" method="post" enctype="multipart/form-data" action="@if(@$exp) {{route('admin.astrologer.update-experience')}} @else {{route('admin.astrologer.add-experience')}} @endif">
                                        	@csrf
                                          <input type="hidden" name="exp_id" value="{{@$exp->id}}">
                                          <input type="hidden" name="user_id" value="{{@$data->id}}">
                                          <div class="col-lg-6">
                                            <div class="form-group rm03 ">
                                                <label for="FullName">Experience title</label>
                                                <input type="text" placeholder="Experience title" id="experience_title" name="experience_title" value="{{@$exp->experience_title}}" class="form-control">
                                            </div>
                                          </div>
                                            
                                          <div class="col-lg-6">
                                            <div class="form-group rm03">
                                                <label for="FullName">Year of Experience</label>
                                                <input type="text" placeholder="Year of Experience" name="year_of_experience" value="{{@$exp->year_of_experience}}" class="form-control">
                                            </div>
                                          </div>

                                           
                                          <div class="form-group rm03">
                                                <label for="AboutMe">Description</label>
                                                <textarea style="height: 100px" id="description" name="description" class="form-control" placeholder="Description">{{@$exp->description}}</textarea>
                                          </div>


                                          <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="file">Image</label>
                                            <div class="uplodimgfil" style="margin-top: 5px;">
                                                <input type="hidden" name="astro_image" id="astro_image" value="{{ @$exp->image}}">
                                                <input type="file" id="image" name="image" accept="image/*">
                                                <label for="image">Upload Image<img
                                                        src="{{ asset('public/admin/assets/images/clickhe.png') }}"
                                                        alt=""></label>
                                            </div>
                                            <label for="image" id="image-error" class="error"></label>
                                        </div>

                                        <div class="form-group" style="position: relative;">
                                          <a class="del_image del-custom-class" data-id="{{@$exp->id}}" @if(@$exp->image=='') style="display:none " @endif > <i class="fa fa-times" aria-hidden="true"></i></a>
                                            <div class="uplodimgfilimg ">
                                                <em><img src="{{ URL::to('storage/app/public/experience_image') }}/{{ @$exp->image }}"
                                                        alt="" id="img2"></em>
                                            </div>

                                        </div>


                                        

                                             
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">@if(@$exp)Update @else Save @endif</button> <a class="btn btn-primary waves-effect waves-light w-md" type="submit" href="{{route('admin.astrologer.edit-exp-view',['id'=>@$data->id])}}">Cancel</a></div>
                                        </form>

                                    </div> 
                                </div>
                                <!-- Personal-Information -->
                                     <div class="panel panel-default panel-fill">
                                   
                                    <div class="table-responsive">
                                    <table class="table">
                                      <thead>
                                        <tr>
                                          <th>Experience title </th>
                                          <th>  Year of Experience</th>
                                          {{-- <th>Description</th>   --}}
                                          <th class="rm07"> Action</th>                            
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @if(@$experiences->isNotEmpty())
                                        @foreach(@$experiences as $experience)
                                        <tr>
                                          <td>{{@$experience->experience_title}}</td>
                                          <td>{{@$experience->year_of_experience}}</td>
                                         {{--  <td>{{substr(@$experience->description, 0, 120)}}...</td> --}}
                                          <td class="rm07">
                                            <ul class="edit_action">
                                                <li><a href="{{route('admin.astrologer.edit-experience',['exp'=>@$experience->id])}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a></li>
                                                
                                                <li><a href="{{route('admin.astrologer.delete-experience',['exp'=>@$experience->id])}}" onclick="return confirm('Do you want to delete this astrologer experience ?')"  data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                                            </ul>
                                          {{-- <a href="javascript:void(0);" class="action-dots" id="action{{@$experience->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                          <div class="show-actions"  id="show-{{@$experience->id}}" style="display: none;" >
                                              <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                            <ul>
                                              <li><a href="{{route('admin.astrologer.edit-experience',['exp'=>@$experience->id])}}">Edit</a></li>
                                             <li><a  href="{{route('admin.astrologer.delete-experience',['exp'=>@$experience->id])}}" onclick="return confirm('Do you want to delete this astrologer experience ?')">Delete</a></li>
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
      url:'{{route('admin.astrologer.delete.experience.image')}}',
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


<script>
    $(document).ready(function(){
    @foreach (@$experiences as $experience)

    $("#action{{$experience->id}}").click(function(){
        $('.show-actions:not(#show-{{$experience->id}})').slideUp();
        $("#show-{{$experience->id}}").slideToggle();
    });
 @endforeach
        $("#experience_from").validate({
            rules: {
                experience_title:{
                    required: true,
                    remote: {
                          url:  '{{route('admin.astrologer.check-experience')}}',
                          type: "GET",
                          data: {
                            experience_title: function() {
                              return $( "#experience_title").val();
                         },
                         'id':"{{@$exp->id}}",
                         'user_id':"{{@$data->id}}",
                       },
                    },
                },
                description:{
                    required: true,
                },
                year_of_experience:{
                    required: true,
                    number: true ,
                    min:1,
                    max:99,
                },

            },
            messages: {
                experience_title:{
                    required: 'Please enter experience title',
                    remote:'Experience already added.Try another.',
                 },
                description:{
                    required: 'Please enter description',
                },
                year_of_experience:{
                    required: 'Please enter year of experience',
                    number: 'Please enter year of experience properly',
                    min:'Minimum 1year experience required',
                    max:'Experience should not be more than 99',
                },
            },
        });
    });
</script>


@endsection