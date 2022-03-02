@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add  Faq</title>
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
                    <h4 class="pull-left page-title">Add  Faq <span style="margin-left: 5px;">@if( @$type=="P")(Product Code : {{@$code->product_code}}  |  Product Name: {{@$code->product_name}}) @elseif(@$type=="G") (Product Code : {{@$code->product_code}}  |  Product Name: @if(@$code->title_id==''){{@$code->product_name}} @else {{@$code->title->title}} @endif)  @elseif(@$type=="PU") (Puja Code : {{@$code->puja_code}}  |  Puja Name: {{@$code->puja_name}}) @elseif(@$type=="H") (Horoscope Code : {{@$code->code}}  |  Horoscope Name: {{@$code->name}}) @elseif(@$type=="A")(Astrologer Name : {{@$code->first_name}} {{@$code->last_name}}) @endif</span></h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="@if(@$type=="PU"){{route('admin.manage.faq.puja',['id'=>@$id])}} @elseif(@$type=="G") {{route('admin.manage.faq.gamestone',['id'=>@$id])}} @elseif(@$type=="P")
                        {{route('admin.manage.faq.product',['id'=>@$id])}} @elseif(@$type=="H") {{route('admin.manage.horoscope.faq',['id'=>@$id])}} @elseif(@$type=="A") {{route('admin.manage.astrologer.faq',['id'=>@$id])}} @endif"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Faq</h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.faq.add')}}" method="POST" id="faq_form" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="product_id" value="{{@$id}}">
                                    <input type="hidden" name="type" value="{{@$type}}">

                                    <div class="form-group">
                                                <label for="FullName">Category</label>
                                               <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                  <option value="">Select Category</option>
                                                  @foreach(@$category as $value)
                                                  <option value="{{@$value->id}}">{{@$value->faq_category}}</option>
                                                  @endforeach
                                               </select>
                                               <label id="category_id-error" class="error" for="category_id"></label>
                                    </div>

                                    <div class="form-group">
                                                <label for="FullName">Sub Category</label>
                                               <select class="form-control rm06 basic-select" name="sub_category_id" id="sub_category_id">
                                                  <option value="">Select Sub Category</option>
                                               </select>
                                               <label id="sub_category_id-error" class="error" for="sub_category_id"></label>
                                    </div>

                                    <div class="form-group">
                                                <label for="FullName">Display Order No</label>
                                                <input type="text"  name="display_order"  class="form-control" value="{{old('display_order')}}" placeholder="Display Order No"  id="display_order">
                                     </div>

                                    <div class="form-group rm03">
                                                <label for="AboutMe">Question</label>
                                                <input type="text"  name="question"  class="form-control" value="{{old('question')}}" placeholder="Question">
                                    </div>

                                    <div class="form-group rm03">
                                              <label for="AboutMe">Answer</label>
                                                <textarea style="height: 150px" name="answer" id="answer" class="form-control">{{old('answer')}}</textarea>
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

<script src="{{ URL::to('public/tiny_mce/tinymce.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
    tinymce.init({
    selector: "#answer",
    forced_root_block : "",
    relative_urls : false,
    entity_encoding: 'raw',
    menubar: "",
    
     plugins: [
    
    "searchreplace wordcount visualblocks visualchars code fullscreen link",
    "lists",
  
    
    "emoticons template paste textcolor colorpicker textpattern imagetools"
    ],
    toolbar1: " bold  underline italic |,link,unlink ",
    });
    
    </script>
<script>
    $(document).ready(function(){
       $("#faq_form").validate({
         rules: {
              type: {
                required:true,
               },
               question:{
                required:true,
               },
               answer:{
                required:true,
               },
               category_id:{
                required:true,
               },
               sub_category_id:{
                required:true,
               },
               display_order:{
                required:true,
                number:true,
               //  remote: {
               //            url:  '{{route('admin.manage.check.display.order')}}',
               //            type: "GET",
               //            data: {
               //              display_order: function() {
               //                return $( "#display_order").val() ;
               //              },
                           
               //            }
               // },
               },
          },
            
        messages: {
                type: {
                    required:'Please select type ',
            },
            question:{
              required:'please enter question',
            }, 
            answer:{
              required:'please enter answer',
            }, 
            category_id:{
              required:'Please select category',
            },
            sub_category_id:{
              required:'Please select sub category',
            },
            display_order:{
              required:'Please enter display order no',
              number:'Only number allowed',
              remote:'Display order already exits in faq',
            },
         },
         submitHandler: function(form){
            if(tinyMCE.get('answer').getContent()==""){
              alert('Please write faq answer');
              return false;
            }else{
              form.submit();
            }
          }
      });
    })
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $('#category_id').on('change',function(e){
      e.preventDefault();
      var id = $(this).val();

      $.ajax({
        url:'{{route('admin.manage.general.faq.get-sub-category')}}',
        type:'GET',
        data:{parent_id:id,},
        success:function(data){
          console.log(data);
          $('#sub_category_id').html(data.sub_category);
          
        }
      })
    })
  })
</script>
@endsection
