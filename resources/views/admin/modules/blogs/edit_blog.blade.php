@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Blog </title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  #exits_title{
    display: none;
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
            <h4 class="pull-left page-title">Edit Blog </h4>
           <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.blog')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
            </ol>
          </div>
        </div>
         <div class="row">
                        <div class="col-lg-12"> 
                        
                        <div> 
                           
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Edit Blog</h3> 
                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                       @include('admin.includes.message')
                                        <form role="form" id="blog" action="{{route('admin.manage.edit.blog')}}" method="post" enctype="multipart/form-data">
                                          @csrf
                                          <input type="hidden" name="blog_id" value="{{@$data->id}}">
                                          <div class="row">
                                            <div class="form-group">
                                                  <label for="FullName">Category</label>
                                                 <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                  <option value="">Select Category</option>
                                                  @foreach(@$category as $value)
                                                    <option value="{{@$value->id}}" @if (@$data->category_id == @$value->id) selected @endif>{{@$value->category}}</option>
                                                    @endforeach
                                                    
                                                 </select>
                                                 <div id="error_category"></div>
                                              </div>
                                            </div>
                                          
                                          <div class="row">
                                            <div class="form-group rm03" >
                                                <label for="FullName">Blog title</label>
                                                <input type="text" placeholder="Blog title" class="form-control" name="blog_title" id="blog_title" value="{{@$data->blog_title}}">
                                                <div id="error_title"></div>
                                                <div id="exits_title">Blog title already exists in this category</div>
                                            </div>
                                          </div>

                                            
                                          <div class="row">
                                            <div class="form-group">
                                                <label for="FullName">Author name</label>
                                                <input type="text" placeholder="Author name" class="form-control" name="author_name" value="{{@$data->author_name}}">
                                                <div id="error_author"></div>
                                            </div>
                                          </div>
                                           
                                            
                                            
                                            
                                            <div class="form-group rm03">
                                                <label for="AboutMe">Blog   description</label>
                                                <textarea style="height: 400px" id="mytextarea" placeholder="Blog   description" class="form-control" name="blog_description">
                                                  {!! @$data->blog_desc!!}
                                                </textarea>
                                            </div>

                                            <div class="form-group rm03">
                                                <label for="AboutMe">Meta  Title</label>
                                                <input type="text" placeholder="Meta title" class="form-control new-form" name="meta_title" value="{{@$data->meta_title}}">
                                              </div>                                                
                                                <div class="form-group rm03">
                                                  <label for="AboutMe">Meta  Description </label>
                                                <textarea style="height: 80px" placeholder="Meta description" class="form-control tiny" name="meta_description">{!! @$data->meta_desc!!}</textarea>
                                            </div>

                                            <div class="row">
                                            <div class="form-group">
                                                <label for="Email">Blog  image (W X H : 1096 X 600)</label>
                                                <div class="uplodimgfil">
                                                  <input type="file" name="image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" onchange="fun1()" multiple />
                                                  <label for="file-1">Upload image<img src="{{asset('public/admin/assets/images/clickhe.png')}}" alt=""></label>
                                                </div>
                                                <div id="error_image"></div>
                                            </div>

                                            @if(@$data->blog_pic!="")
                                            <div class="form-group">
                                              <div class="uplodimgfilimg profile_image ad_rbn_001"  style="margin-top: 20px;">
                                                  <img src="{{ URL::to('storage/app/public/BigBlogImage')}}/{{@$data->blog_pic}}" alt="" id="img2" >
                                              </div>
                                            </div>
                                        @else
                                            <div class="form-group">
                                            <div class="uplodimgfilimg profile_image ad_rbn_001"  style="display: none;margin-top: 20px;">
                                                <img src="" alt="" id="img2" >
                                            </div>
                                            </div>
                                        @endif

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
  <!-- Right Sidebar -->
@section('script')
@include('admin.includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
<script>
    function fun1(){
    var i=document.getElementById('file-1').files[0];
    var b=URL.createObjectURL(i);
    $(".profile_image").show();
    $("#img2").attr("src",b);
    }
</script>

<script type="text/javascript">
    tinymce.init({
    selector: 'textarea.tiny',
    forced_root_block : "",
    relative_urls : false,
    entity_encoding: 'raw',
    menubar: "",
    
     plugins: [
    
    "searchreplace wordcount visualblocks visualchars code fullscreen link",
    "lists",
  
    
    "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: ",link,unlink ",
        });
    
    </script>

    <script type="text/javascript">
    tinymce.init({
    selector: "#mytextarea",
    forced_root_block : "",
    relative_urls : false,
    entity_encoding: 'raw',
    default_link_target:"__blank",
    
     plugins: [
    
    "searchreplace wordcount visualblocks visualchars code fullscreen link",
    "lists",
  
    
    "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft     aligncenter alignright alignjustify | bullist numlist outdent indent | link     image",
    toolbar2: "print preview media | forecolor backcolor emoticons",
    toolbar3: "cut,copy,paste,pastetext,pasteword,|outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,|,insertdate,inserttime,preview",
    toolbar4: "numlist bullist",
    image_advtab: true,
    templates: [
    {title: 'Test template 1', content: 'Test 1'},
    {title: 'Test template 2', content: 'Test 2'}
    ]
    });
    
    </script>


<script>
    $(document).ready(function(){
       $("#blog").validate({
        rules: {
            blog_title:{
              required:true,
            },
            author_name:{
              required:true,
            },
            image:{
              extension:'jpg|jpeg|png|gif',
            },
            category_id:{
              required:true,
            },
        },
        ignore: [],   
        messages: {
            category_id:{
              required:'Please select blog category',
            },
            blog_title:{
              required:'Please enter blog title',
            },
            author_name:{
              required:'Please enter author name',
            },
            image:{
              required:'Please upload blog image',
              extension:'Please upload valid image',
            },
        },
        submitHandler: function(form){
            var category_id = $('#category_id').val();
            var blog_title = $('#blog_title').val();

            if(tinyMCE.get('mytextarea').getContent()==""){
              alert('Please enter blog description');
              return false;
            }
            if(category_id!="" && blog_title!=""){
              var id = '{{@$data->id}}';
              $.ajax({
                      url:"{{route('admin.check.blog-name')}}",
                      method:"GET",
                      data:{'category_id':category_id,'blog_title':blog_title,'id':id},
                      success: function(res) {
                      console.log(res);  
                       if (res=="found") {
                         alert('Blog title already exits in this category');
                         return false;
                      }else{
                  // checking-image-size 
                    var fd= new FormData;
                    var im=document.getElementById("file-1").files[0];
                    fd.append("img",im);
                    if (im!=null ){
                    var file =  $('#file-1').val(); 
                    var ext = file.split(".");
                    ext = ext[ext.length-1].toLowerCase();      
                    var arrayExtensions = ["jpg" ,"jpeg","png"];
                    if (arrayExtensions.lastIndexOf(ext) == -1){
                                alert("Only jpg,jpeg,png allowed.");
                                $("#image").val("");
                                return false;
                    }else{
                     
                     $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                     }
                    });
                    
                    $.ajax({
                        url:"{{route('admin.check.img.size')}}",
                        method:"POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(res) {
                            // console.log(res);
                            if(res.w<1096){
                                alert("Image width should be more than or equal to 1096px");
                                return false;
                            }
                          else if(res.h<600){
                                alert("Image height should be more than or equal to 600px");
                                return false;
                            }
                          else{
                          form.submit();  
                          }
                        }
                    });
                   }
               }else{
                form.submit(); 
               }             
             }
            }
          }); 
        }
       },  
         errorPlacement: function(error, element) {
            console.log("Error placement called");
            if (element.attr("name") == "blog_title") {
               $("#error_title").append(error);
            }
            else if (element.attr("name") == "author_name") {
                $("#error_author").append(error);
            }
            else if (element.attr("name") == "image") {
                $("#error_image").append(error);
            }
            else if (element.attr("name") == "category_id") {
                $("#error_category").append(error);
            }
        } 
       
    })
     });
</script>
@endsection








