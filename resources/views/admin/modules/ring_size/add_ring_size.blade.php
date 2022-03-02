@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Ring Size</title>
@endsection

@section('style')
@include('admin.includes.style')
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
                    <h4 class="pull-left page-title">Add Ring Size</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.ring.size')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Ring Size</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.ring.size.add')}}" method="POST" id="ringForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                                <label for="FullName">Ring System</label>
                                               <select class="form-control rm06 basic-select" name="ring" id="ring">
                                                  <option value="">Select Ring System</option>
                                                  @foreach(@$rings as $value)
                                                  <option value="{{@$value->id}}">{{@$value->ring_size_system}}</option>
                                                  @endforeach
                                               </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_name">Size</label>
                                        <input type="text" placeholder="Ring size" id="name" class="form-control" name="name">
                                        <div id="err_size" style="display: none;color: red;">Size Already Exits In This System</div>
                                    </div>
                                    
                                <div class="clearfix"></div>
                                    <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
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
<script>
    $(document).ready(function(){
       $("#ringForm").validate({
            rules: {
                name: {
                   required:true,
               },
              ring:{
                required:true,
                
              },
        },
            
        messages: {
                name: {
                    required:'Please enter ring size',
                     // number:'Please enter only number',
                },
                ring:{
                    required:'Please select ring system',
                   
                },

        },
        submitHandler: function(form){
              var ring = $('#ring').val();
              var name = $('#name').val();
              $.ajax({
                      url:"{{route('admin.manage.ring.size.check')}}",
                      method:"GET",
                      data:{'ring':ring,'name':name},
                      success: function(res) {
                      console.log(res);  
                      if (res=="found") {
                        $('#err_size').css('display','block');
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
@endsection
