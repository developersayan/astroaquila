@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Seller</title>
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
                    <h4 class="pull-left page-title">Edit Seller</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.selelr-master')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Edit Seller </h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.seller-master-update')}}" method="POST" id="deityForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{@$data->id}}">
                                    <div class="form-group">
                                        <label for="category_name">Seller name</label>
                                        <input type="text" placeholder="Seller name" id="seller" class="form-control" name="name" value="{{@$data->seller_name}}" required>
                                        <div id="err_category"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/Edititional-methods.min.js"></script>
<script>
    $(document).ready(function(){
       $("#deityForm").validate({
            rules: {
                name: {
                   required:true,
                 },
             },
           messages: {
                name: {
                    required:'Please enter seller name',
            },  
         },

        });
    })
</script>
@endsection
