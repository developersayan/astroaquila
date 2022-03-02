@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Why & Who</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  .edit_action li {
    display: inline-block;
    margin: 0 4px;
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
            <h4 class="pull-left page-title">Edit Why & Who</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.astro.tips')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">

            @include('admin.includes.message')
            <div>

                    <!-- Personal-Information -->
                    <div class="panel panel-default panel-fill">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Why & Who</h3>
                        </div>
                        <div class="panel-body rm02 rm04">
                            <form role="form" id="tips_from" method="post" enctype="multipart/form-data" action="{{route('admin.edit.why.who')}}">
                                @csrf
                                <input type="hidden" name="search_id" value="{{@$data->id}}">
                                <div class="clearfix"></div>
                                <div class="col-sm-12 col-xs-12 col-md-8 col-lg-10">
                                    <label for="why_who">Why & Who</label>
                                    <textarea style="height: 150px" id="why_who" name="why_who"
                                        class="form-control">{{ @$data->why_who }}</textarea>
                                    <div class="error" id="why_who_error"></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-lg-12" style="margin-top: 25px"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
      </div>
    </div>
     @include('admin.includes.footer')
  </div>
  <!-- ============================================================== -->
  <!-- End Right content here -->
@endsection
@section('script')
@include('admin.includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function(){
        $("#tips_from").validate({
            rules: {
                heading:{
                    required: true,
                    maxlength:10
                },
                description:{
                    required: true,
                    maxlength:200
                },

            },
            messages: {
                heading:{
                    required: 'Please enter heading',
                },
                description:{
                    required: 'Please enter description',
                },
            },
        });
    });
</script>

@endsection
