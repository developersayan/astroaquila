@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Language</title>
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
                    <h4 class="pull-left page-title">Add Language</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.language')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Language</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.language.insert')}}" method="POST" id="cert_name" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="category_name">Language Name</label>
                                        <input type="text" placeholder="Language Name" id="name" class="form-control" name="name" required>
                                        {{-- <div id="err_category"></div> --}}
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
                          url:  '{{route('admin.manage.language.check')}}',
                          type: "POST",
                          data: {
                            name: function() {
                              return $( "#name").val() ;
                            },
                            _token: '{{ csrf_token() }}',
                          }
               },
           },

          },
            
        messages: {
                name: {
                    required:'Please enter language name',
                    remote:'Language already added',
            },  

        },

        });
    })
</script>
@endsection
