@extends('admin.layouts.app')


@section('title')
    <title>Astroaquila | @if(@$wiki) Edit @else Add @endif aquilia wiki</title>
@endsection

@section('style')
    @include('admin.includes.style')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link href="{{ URL::asset('public/frontend/croppie/croppie.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('public/frontend/croppie/croppie.min.css') }}" rel="stylesheet" />
    <style type="text/css">
        .form-group span {
            font-size: 15px;
            color: #8a8a8a;
        }

        .uplodimgfilimg {
            margin-left: 20px;
            padding-top: 20px;
        }

        .uplodimgfilimg em {
            width: 58px;
            height: 58px;
            position: relative;
            display: inline-block;
            overflow: hidden;
            border-radius: 4px;
        }

        .uplodimgfilimg em img {
            position: absolute;
            max-width: 100%;
            max-height: 100%;
        }
        .checkBoxAstroTP {
            width: 33% !important;
            float: left !important;
        }
    </style>
    <style type="text/css">

    </style>
@endsection

@section('content')
    <!-- Top Bar Start -->
    @include('admin.includes.header')
    @include('admin.includes.sidebar')
    <div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="pull-left page-title">@if(@$wiki) Edit @else Add @endif aquilia wiki</h4>
                        <ol class="breadcrumb pull-right">
                            <li class="active"><a href="{{ route('admin.manage.aquilia.wiki') }}"><i
                                        class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                    <h3 class="panel-title">@if(@$wiki) Edit @else Add @endif aquilia wiki</h3>
                                </div>
                                <div class="panel-body rm02 rm04">
                                    <form role="form" id="edit_profile" method="post" enctype="multipart/form-data"
                                        action="@if(@$wiki) {{ route('admin.insert.aquilia.wiki') }} @else {{ route('admin.update.aquilia.wiki') }} @endif">
                                        @csrf
                                        <input type="hidden" name="wiki_id" value="{{ @$wiki->id }}">
                                        <div class="form-group">
                                            <label for="FullName">Title</label>
                                            <select class="form-control rm06 " name="title" id="title">
                                                <option value="">Select Title</option>
                                                @if(@$title)
                                                    @foreach (@$title as $ti)
                                                        <option value="{{ @$ti->id }}" @if(@$wiki->title == @$ti->id)selected @endif>{{ @$ti->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <div class="error" id="title_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="FullName">Category</label>
                                            <select class="form-control rm06 " name="category" id="category">
                                                <option value="">Select Category</option>

                                                @foreach (@$category as $cat)
                                                    <option value="{{ @$cat->id }}" @if(@$wiki->category == @$cat->id)selected @endif>{{ @$cat->name }}</option>
                                                @endforeach

                                            </select>
                                            <div class="error" id="price_error"></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="FullName">Sub category</label>
                                            <select class="form-control rm06 " name="subcategory" id="subcategory">
                                                <option value="">Select Subcategory</option>
                                                @if(@$subcategory)
                                                @foreach (@$subcategory as $sub)
                                                    <option value="{{ @$sub->id }}" @if ($wiki->subcategory == @$sub->id)selected @endif>
                                                        {{ @$sub->name }}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                            <div class="error" id="subcategory_error"></div>
                                        </div>
                                        <div class="form-group rm03">
                                            <label for="FullName">Article Title</label>
                                            <input type="text" placeholder="Article Title" id="article_title" name="article_title" class="form-control" value="{{@$wiki->article_title}}">
                                            <div class="error" id="title_error"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="file">Image</label>
                                            <div class="uplodimgfil" style="margin-top: 5px;">
                                                <input type="hidden" name="astro_image" id="astro_image" value="{{ @$wiki->image}}">
                                                <input type="file" id="image" name="image" accept="image/*">
                                                <label for="image">Upload Image<img
                                                        src="{{ asset('public/admin/assets/images/clickhe.png') }}"
                                                        alt=""></label>
                                            </div>
                                            <label for="image" id="image-error" class="error"></label>
                                        </div>
                                        <input type="hidden" id="prv_image" value="{{@$wiki->image}}">

                                        <div class="form-group" style="position: relative;">
                                        <a class="del_image del-custom-class"  data-id="{{@$wiki->id}}" @if(!@$wiki->image) style="display:none" @endif> <i class="fa fa-times" aria-hidden="true"></i>  </a>
                                            <div class="uplodimgfilimg ">
                                                <em>
                                                    <img src="{{ URL::to('storage/app/public/wiki_image') }}/{{ @$wiki->image }}"
                                                        alt="" id="img2">

                                                </em>

                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <label for="pdf">Pdf</label>
                                            <div class="uplodimgfil" style="margin-top: 5px;">
                                                <input type="hidden" name="astro_pdf" id="astro_pdf" value="{{ @$wiki->pdf}}">
                                                <input type="file" id="pdf" name="pdf" accept="application/pdf">
                                                <label for="pdf">Upload file<img
                                                        src="{{ asset('public/admin/assets/images/clickhe.png') }}"
                                                        alt=""></label>
                                            </div>
                                            <label for="astro_pdf" id="pdf-error" class="error"></label>
                                        </div>
                                        <div class="form-group">
                                            <div class="uplodfile" style="margin-top: 33px">
                                                <em>
                                                    <b>{{ @$wiki->pdf }}</b>&nbsp;&nbsp;
                                                    <a class="del_pdf" data-id="{{@$wiki->id}}" @if(!@$wiki->pdf) style="display:none" @endif> <i class="fa fa-times" aria-hidden="true"></i>Delete </a>
                                                </em>
                                            </div>

                                        </div>
                                        <div class="form-group rm03">
                                            <label for="AboutMe">Description</label>
                                            <textarea style="height: 150px"  name="description" class="form-control description" placeholder="Description" id="description">{{@$wiki->description}}</textarea>
                                            <div class="error" id="error_description_"></div>
                                        </div>


                                        <div class="clearfix"></div>
                                        <div class="col-lg-12"> <button
                                                class="btn btn-primary waves-effect waves-light w-md"
                                                type="submit">Save</button></div>
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
@endsection
@section('script')
    @include('admin.includes.script')
    <script src="{{ URL::asset('public/frontend/croppie/croppie.js') }}"></script>
    <script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    <script>
        function dataURLtoFile(dataurl, filename) {

            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);

            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }

            return new File([u8arr], filename, {
                type: mime
            });
        }

        $("#image").change(function () {
            $('.uplodimgfilimg').html('');
            let files = this.files;
            if (files.length > 0) {
                let exts = ['image/jpeg', 'image/png', 'image/gif'];
                let valid = true;
                $.each(files, function(i, f) {
                    if (exts.indexOf(f.type) <= -1) {
                        valid = false;
                        return false;
                    }
                });
                if (! valid) {
                    alert('Please choose valid image files (jpeg, png, gif) only.');
                    $("#image").val('');
                    return false;
                }
                $.each(files, function(i, f) {
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('#prv_image').val('image');
                        $('.uplodimgfilimg').append('<li><img style="max-width: 100px;" src="' + e.target.result + '"></li>');
                    };
                    reader.readAsDataURL(f);
                });
            }

        });
        $("#pdf").change(function () {
            $('.uplodfile').html('');
            let files = this.files;
            if (files.length > 0) {
                $.each(files, function(i, f) {
                    var reader = new FileReader();

                    reader.onload = function(e){
                        console.log(e.target.result)
                         $('.uplodfile').append('<span><b>'+ files[0]['name'] + '</b></span>');
                    };
                    reader.readAsDataURL(f);
                });
            }

        });
    </script>
    <script type="text/javascript">
        $('.del_image').on('click',function(e){
          if(confirm("Do You want remove this image?")){
          var id = $(this).data('id');
          $('#image_url').val('');
          $('#icon').val('');
          $('#profile_picture').val('');
          $.ajax({
            url:'{{route('admin.delete.aquilia.wiki.image')}}',
            type: "POST",
            data:{
               id:id,
              _token: '{{ csrf_token() }}',
            },

            success: function(res) {
              $("#img2").attr("src",'');
              $('.uplodimgfilimg').hide();
              $('.del_image').hide();
              $("#prv_image").val('');
            }
        });
        }
        })
      </script>

      <script type="text/javascript">
        $('.del_pdf').on('click',function(e){
          if(confirm("Do You want remove this pdf ?")){
          var id = $(this).data('id');
          $('#preview').hide();
          $.ajax({
            url:'{{route('admin.delete.aquilia.wiki.pdf')}}',
            type: "POST",
            data:{
               id:id,
              _token: '{{ csrf_token() }}',
            },

            success: function(res) {
              $('.uplodfile').hide();
            }
        });
        }
        })
      </script>
    <script type="text/javascript">
        tinymce.init({
        //selector: "textarea",
        mode : "specific_textareas",
        editor_selector :/(description)/,
        forced_root_block : "",
        relative_urls : false,
        entity_encoding: 'raw',
            
         plugins: [
        
        "searchreplace wordcount visualblocks visualchars code fullscreen link",
        "lists",
      
        
        "emoticons template paste textcolor colorpicker textpattern imagetools"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft     aligncenter alignright alignjustify | bullist numlist outdent indent | link     image",
        toolbar2: "print preview media | forecolor backcolor emoticons",
        toolbar3: "cut,copy,paste,pastetext,pasteword,|outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,insertdate,inserttime,preview",
        toolbar4: "numlist bullist,link",
        image_advtab: true,
        templates: [
        {title: 'Test template 1', content: 'Test 1'},
        {title: 'Test template 2', content: 'Test 2'}
        ]
        });

        </script>
    <script>
        $(document).ready(function() {

            $("#edit_profile").validate({
                rules: {
                    title: {
                        required: true,
                    },
                    article_title: {
                        required: true,
                    },
                    category: {
                        required: true,
                    },
                    image: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: 'Please select title',
                    },
                    category: {
                        required: 'Please select category',

                    },
                    image: {
                        required: 'Please upload image',
                    },
                    pdf: {
                        required: 'Please upload pdf'
                    },
                    article_title:{
                        required: 'Please enter article title'
                    }
                },
                submitHandler: function(form) {
                    var old_image = "{{@$wiki->image}}";
                    var _old_pdf = "{{@$wiki->pdf}}";

                    if ($('#image').val() == '' && old_image == '') {
                        $('#image-error').html('Please upload your image');
                        $('#image-error').css('display', 'block');
                        return false;
                    }

                     if($('#prv_image').val()==''){
                         alert('Please upload image');
                        return false;
                    }
                    
                    else if (tinyMCE.get('description').getContent()=="") {
                        $('#error_description_one').html('Please enter description');
                        $('#error_description_one').css('display', 'block');
                        alert('Please enter description');
                        return false;
                    } else {
                       
                        form.submit();
                    }
                }
            });

        })
    </script>

    <script>
        jQuery(document).ready(function() {
            // Select2
            jQuery(".select2").select2({
                width: '100%'
            });
        });
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('#category').on('change', function(e) {
                var id = $(this).val();
                $.ajax({
                    url: '{{ route('admin.wiki.subcat') }}',
                    type: 'GET',
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        if (data.subcat) {

                            const res = data.subcat;
                            if(res.length >0){
                                $('#subcategory').addClass('required');
                            }else{
                                $('#subcategory').removeClass('required');
                            }
                            //$('#city').append('<option value="" selected>Select city</option>');
                            $.each(res, function (i, v) {
                                $('#subcategory').append('<option value="' + v.id + '"">' + v.name + '</option>');
                            })
                        }
                        //$('#subcategory').html(data.state);
                    }
                })
            })
        })
    </script>

@endsection
