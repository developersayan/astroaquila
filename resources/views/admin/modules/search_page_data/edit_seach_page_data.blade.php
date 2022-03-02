@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Search Page Data @if(@$data->type=="G")Gemstone @elseif(@$data->type=="P") Product @elseif(@$data->type=="PU") Puja @elseif(@$data->type=="A") Astrologer @else Hororscope @endif</title>
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
                    <h4 class="pull-left page-title">Edit Search Page Data of @if(@$data->type=="G")Gemstone @elseif(@$data->type=="P") Product @elseif(@$data->type=="PU") Puja @elseif(@$data->type=="A") Astrologer @else Hororscope @endif</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.search.page.data')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Edit Search Page Data of @if(@$data->type=="G")Gemstone @elseif(@$data->type=="P") Product @elseif(@$data->type=="PU") Puja @elseif(@$data->type=="A") Astrologer @else Hororscope @endif</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.search.page.data.update')}}" method="POST" id="searchdata" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{@$data->id}}">

                                    <div class="form-group rm03">
                                        <label for="category_name">Description</label>
                                        <textarea style="height: 80px"  name="description" class="form-control" placeholder="Description">{{@$data->description}}</textarea>
                                        <div id="error_description" class="error"></div>
                                    </div>

                                    <div class="form-group rm03">
                                        <label for="category_name">Significance</label>
                                        <textarea style="height: 80px"  name="significance" class="form-control" placeholder="Significance">{{@$data->significance}}</textarea>
                                        <div id="error_significance" class="error"></div>
                                    </div>

                                    <div class="form-group rm03">
                                        <label for="category_name">Who/When/Where</label>
                                        <textarea style="height: 80px"  name="who_when" class="form-control" placeholder="Who/When/Where">{{@$data->who_when}}</textarea>
                                        <div id="error_who_when" class="error"></div>
                                    </div>

                                    @if(@$data->type!="H")
                                    <div class="form-group rm03">
                                        <label for="category_name">Related Mantra</label>
                                        <textarea style="height: 80px"  name="related_mantra" class="form-control" placeholder="Related Mantra">{{@$data->related_mantra}}</textarea>
                                        <div id="error_mantra" class="error"></div>
                                    </div>

                                    <div class="form-group rm03">
                                        <label for="category_name">Usage</label>
                                        <textarea style="height: 80px"  name="usages" class="form-control" placeholder="Usage">{{@$data->usages}}</textarea>
                                        <div id="error_usages" class="error"></div>
                                    </div>
                                    @endif




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

<script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
    tinymce.init({
    selector: "textarea",
    forced_root_block : "",
    relative_urls : false,
    entity_encoding: 'raw',
    menubar: "",

     plugins: [

    "searchreplace wordcount visualblocks visualchars code fullscreen link",
    "lists",


    "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: "link,unlink ",
        });

    </script>
<script>
    $(document).ready(function(){
       $("#searchdata").validate({
            rules: {

        },

        messages: {
                description: {
                    required:'Please enter description',
                },
                significance:{
                    required:'Please enter significance',
                },
                who_when:{
                    required:'Please enter who/when/where',
                },
                 related_mantra:{
                    required:'Please enter related mantra',
                },
                usages:{
                  required:'Please enter usage',
                },

        },
        submitHandler: function(form){
            $('#error_description').html('');
            $('#error_significance').html('');
            $('#error_who_when').html('');
            $('#error_mantra').html('');
            $('#error_usages').html('');
            if(tinyMCE.get('description').getContent()==""){
              alert('Please enter description');
              $('#error_description').append('<p>Please enter description</p>');
              return false;
            }

            if(tinyMCE.get('significance').getContent()==""){
              alert('Please enter significance');
              $('#error_significance').append('<p>Please enter significance</p>');
              return false;
            }

            if(tinyMCE.get('who_when').getContent()==""){
              alert('Please enter who/when/where');
              $('#error_who_when').append('<p>Please enter who/when/where</p>');
              return false;
            }

            if(tinyMCE.get('related_mantra').getContent()==""){
              alert('Please enter related mantra');
              $('#error_mantra').append('<p>Please enter related mantra</p>');
              return false;
            }

            if(tinyMCE.get('usages').getContent()==""){
              alert('Please enter usages');
              $('#error_usages').append('<p>Please enter usages</p>');
              return false;
            }

            form.submit();


          }

        });
    })
</script>
@endsection
