@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Certificate Name</title>
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
                    <h4 class="pull-left page-title">Add Certificate Name</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.cirtificate.name')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Certificate Name</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.cirtificate.name-insert')}}" method="POST" id="cert_name" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="category_name">Certificate Name</label>
                                        <input type="text" placeholder="Certificate Name" id="name" class="form-control" name="name" required>
                                        {{-- <div id="err_category"></div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label for="category_name">No. of days required for Testing</label>
                                        <input type="text" placeholder="No. of days required for Testing" id="days" class="form-control" name="days" required>
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
       $("#cert_name").validate({
            rules: {
                name: {
                   required:true,
                   remote: {
                          url:  '{{route('admin.manage.cirtificate.name.check')}}',
                          type: "POST",
                          data: {
                            name: function() {
                              return $( "#name").val() ;
                            },
                            _token: '{{ csrf_token() }}',
                          }
               },
           },
           days:{
            number:true,
            required:true,
            min:1,
           },

          },
            
        messages: {
                name: {
                    required:'Please enter certificate name',
                    remote:'Certificate name already exits',
            },  
            days:{
            number:'Please enter number only',
            min:'Please enter no of days required for testing properly',
            required:'Please enter no of days required for testing',
           },

        },

        });
    })
</script>
@endsection
