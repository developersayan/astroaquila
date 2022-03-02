@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Faq Sub Category</title>
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
                    <h4 class="pull-left page-title">Add Faq Sub Category</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.faq.category')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Faq Sub Category</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.faq.subcategory.insert')}}" method="POST" id="category_form" enctype="multipart/form-data">
                                    @csrf

                                     <div class="form-group">
                                    <label for="FullName">Category</label>
                                    <select class="form-control rm06  basic-select" name="category" id="category">
                                        <option value="">Select Category</option>
                                        @foreach(@$category as $value)
                                        <option value="{{@$value->id}}">{{@$value->faq_category}}</option>
                                        @endforeach
                                    </select>
                                    <label id="category-error" class="error" for="category"></label>
                                  </div>


                                    <div class="form-group">
                                        <label for="category_name">Sub Category</label>
                                        <input type="text" placeholder="Sub Category" id="sub_category" class="form-control" name="sub_category" required>
                                        
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
       $("#category_form").validate({
            rules: {
                category: {
                   required:true,
                },
                sub_category:{
                    required:true,
                },

          },
            
        messages: {
                category: {
                    required:'Please select category',
               },  
               sub_category:{
                required:'Please enter sub category',
               },

        },
        submitHandler: function(form){
            var category = $('#category').val();
            var sub_category = $('#sub_category').val();
            // alert(title);
                 $.ajax({
                         url:"{{route('admin.manage.faq.subcategory.check')}}",
                         method:"GET",
                         data:{'category':category,'sub_category':sub_category},
                         success: function(res) {
                         console.log(res);  
                         // return false;
                          if (res=="found") {
                         alert('Sub category  already exits in this category');
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
