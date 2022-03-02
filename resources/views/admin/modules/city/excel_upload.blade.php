@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | City Excel Upload</title>
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
                    <h4 class="pull-left page-title">City Excel Upload</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.city')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">City Excel Upload</h3>
                            </div>
                            <div class="panel-heading">
                            <h4>Instruction</h4>
                            <p>1. Select Coutry and State</p>
                            <p>2. Upload Excel File Of City</p>
                            <p>3. The excel file must match exactly like the demo excel file. </p>
                            <p><a href="{{url('public/admin/assets/city.xlsx')}}" download><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download Demo Excel File</a></p>
                          </div>
                            <div class="panel-body rm02 rm04">
                               <form action="{{route('admin.manage.city.export')}}" method="post" enctype="multipart/form-data" id="excel_form">
                    @csrf
                
                <div class="form-group">
                             <label for="FullName">Country</label>
                                               <select class="form-control rm06 basic-select "  name="country" id="country"  style="width: 100%;">
                                                  <option value="">Select Country</option>
                                                  @foreach(@$countris as $value)
                                                  <option value="{{@$value->id}}" @if(request('country')==@$value->id) selected @endif>{{@$value->name}}</option>
                                                  @endforeach
                                               </select>
                                               <div id="error_country"></div>
                 </div>


                 <div class="form-group">
                             <label for="FullName">State</label>
                                               <select class="form-control rm06 basic-select "  name="state" id="state"  style="width: 100%;">
                                                  <option value="">Select State</option>
                                               </select>
                                               <div id="error_state"></div>
                 </div>


                 

                 <div class="clearfix"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="main-center-div">
                        <div class="form-group ">
                         <div class="uplodimgfil">
                                                  <input type="file"  id="file-2" class="inputfile inputfile-1 astro_file" data-multiple-caption="{count} files selected"  
                                                   name="excel" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                                  <label for="file-2">Upload Excel<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                  
                                                </div>
                                                <span class="astro_file_names" id="astro_file_names" style="margin-right: 2px;"></span>
                                                <div id="error_excel"></div>
                        <div class="col-lg-12">
                            <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </form>

                            </div>
                        </div>
                        <!-- Personal-Information -->

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
<!-- ============================================================== -->

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

               },
               submitHandler: function(form){
                
                var state = $('#state').val();
                var city = $('#city').val();
                
                 $.ajax({
                      url:"{{route('admin.manage.city.check-city')}}",
                      method:"GET",
                      data:{'state':state,'city':city},
                      success: function(res) {
                      console.log(res);  
                      if (res=="found") {
                        $('#err_state').css('display','block');
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
        url:'{{route('admin.manage.city.get-state')}}',
        type:'GET',
        data:{id:id,},
        success:function(data){
          console.log(data);
          $('#state').html(data.state);
          
        }
      })
    })
  })
</script>

<script>
    $(document).ready(function(){
       $("#excel_form").validate({
            rules: {
                excel: {
                   required:true,
            },
            country:{
                required:true,
            },
            state:{
                required:true,
            },
          },
        ignore: [],   
        messages: {
                excel: {
                    required:'Please upload excel file',
            },  
            country:{
                required:'Please select country',
            },
            state:{
                required:'Please select state',
            },

        },
        errorPlacement: function(error, element) {
            console.log("Error placement called");
            if (element.attr("name") == "excel") {
               
                $("#error_excel").append(error);
            }
            if (element.attr("name") == "country") {
               
                $("#error_country").append(error);
            }
            if (element.attr("name") == "state") {
               
                $("#error_state").append(error);
            }
        },
        });
    })
</script>

<script type="text/javascript">
  $('.astro_file').change(function() {
            $('.astro_file_names').html('');
            var files = $('.astro_file').prop('files');
            $('.astro_file_names').html(files[0].name);
        });
</script>
@endsection
