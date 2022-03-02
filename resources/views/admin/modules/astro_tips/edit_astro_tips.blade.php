@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | @if(@$tip)Edit @else Add @endif Astro Tips</title>
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
            <h4 class="pull-left page-title">@if(@$tip)Edit @else Add @endif Astro Tips</h4>
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
                            <h3 class="panel-title">@if(@$tip)Edit @else Add @endif Astro Tips</h3>
                        </div>
                        <div class="panel-body rm02 rm04">
                            <form role="form" id="tips_from" method="post" enctype="multipart/form-data" action="@if(@$tip){{route('admin.update.astro.tips',['id'=>@$tip->id])}} @else {{route('admin.insert.astro.tips')}} @endif">
                                @csrf
                                <input type="hidden" name="tip_id" value="{{@$tip->id}}">
                                <div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 ">
                                    <label for="FullName">Heading</label>
                                    <input type="text" placeholder="Heading" id="heading" name="heading" class="form-control" value="{{@$tip->heading}}">
                                    <div class="error" id="heading_error"></div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-12 col-xs-12 col-md-8 col-lg-8  ">
                                    <label for="description">Description</label>
                                    <textarea style="height: 80px" id="description" name="description"
                                        class="form-control">{{ @$tip->description }}</textarea>
                                    <div class="error" id="description_error"></div>
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

        $.validator.addMethod("wordCount",
            function(value, element, params) {
                var typedWords = jQuery.trim(value).split(' ').length;

                if(typedWords <= params) {
                return true;
                }
            },
        );
        $("#tips_from").validate({
            rules: {
                heading:{
                    required: true,
                    wordCount:10
                },
                description:{
                    required: true,
                    wordCount:200
                },

            },
            messages: {
                heading:{
                    required: 'Please enter heading',
                    wordCount:"Maximum 10 word allowed"
                },
                description:{
                    required: 'Please enter description',
                    wordCount:"Maximum 200 word allowed"
                },
            },
        });
    });
</script>

@endsection
