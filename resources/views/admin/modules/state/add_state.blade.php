@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add State</title>
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
                    <h4 class="pull-left page-title">Add State</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('manage.state')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add State</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form"  method="POST" action="{{route('manage.state.add')}}" id="stateadd" enctype="multipart/form-data">
                                    @csrf
                                   
                                    
                            <div class="form-group">
                                    <label for="FullName">Country</label>
                                    <select class="form-control rm06 basic-select" name="country" id="country">
                                        <option value="">Select Country</option>
                                        @foreach(@$countris as $country)
                                        <option value="{{@$country->id}}">{{@$country->name}}</option>
                                        @endforeach
                                     </select>
                                </div>

                                <div class="form-group">
                                        <label for="category_name">State name</label>
                                        <input type="text" placeholder="State name" id="state" class="form-control" name="state" required>
                                        <div id="err_state">State already added in this county</div>
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
               },
               messages:{
                country:{
                    required:'Please select a country',
                },
                state:{
                    required:'Please enter state name',
                },
               },
               submitHandler: function(form){
                
                var state = $('#state').val();
                var country = $('#country').val();
                
                 $.ajax({
                      url:"{{route('manage.state.check')}}",
                      method:"GET",
                      data:{'state':state,'country':country},
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
@endsection
