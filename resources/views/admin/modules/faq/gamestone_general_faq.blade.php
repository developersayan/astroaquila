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
                    <h4 class="pull-left page-title">Add  Faq <span style="margin-left: 5px;">@if( @$type=="P")(Product Code : {{@$code->product_code}}  |  Product Name: {{@$code->product_name}}) @elseif(@$type=="G") (Product Code : {{@$code->product_code}}  |  Product Name: @if(@$code->title_id==''){{@$code->product_name}} @else {{@$code->title->title}} @endif)  @elseif(@$type=="PU") (Puja Code : {{@$code->puja_code}}  |  Puja Name: {{@$code->puja_name}}) @endif</span></h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="@if(@$type=="PU"){{route('admin.manage.faq.puja',['id'=>@$id])}} @elseif(@$type=="G") {{route('admin.manage.faq.gamestone',['id'=>@$id])}} @else 
                        {{route('admin.manage.faq.product',['id'=>@$id])}} @endif"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                    </ol>
                </div>
            </div>
            



            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.manage.faq.gamestone.genral.faq.view',['id'=>@$id])}}" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                
                                <div class="form-group">
                                                <label for="FullName">Category</label>
                                               <select class="form-control rm06 basic-select" name="category_id" id="category_id">
                                                  <option value="">Select Category</option>
                                                  @foreach(@$category as $value)
                                                  <option value="{{@$value->id}}" @if(request('category_id')==@$value->id) selected @endif>{{@$value->faq_category}}</option>
                                                  @endforeach
                                               </select>
                                               <label id="category_id-error" class="error" for="category_id"></label>
                                    </div>


                                  <div class="form-group">
                                        <label for="search">Select Sub Category</label>
                                           <select class="form-control rm06 basic-select" name="sub_category_id" id="sub_category_id">
                                                <option value="">Select Sub Category</option>
                                                  @if(@$sub_categories)
                                                     @foreach(@$sub_categories as $scategory)
                                                             <option value="{{@$scategory->id}}" @if(request('sub_category_id')==@$scategory->id) selected @endif>{{@$scategory->faq_category}}</option>
                                                             @endforeach
                                                              @else
                                                              {{-- <option value="">No Category Added</option> --}}
                                                    @endif
                                          </select>
                                  </div>

                                   

                                  {{-- <div class="clearfix"></div> --}}
                               
                                <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                         



                         <form role="form" action="{{route('admin.manage.faq.gamestone.genral.faq.add')}}" method="post" >
                          @csrf
                        <div class="panel-body">
                         
                           <input type="hidden" name="request_status" value="{{@$request_status}}"> 
                           @if(@$request_status=='Y')
                           <?php $implode = implode(',', @$question_get) ?>
                           <input type="hidden" name="question_get" value="{{@$implode}}">
                           @endif
                            <input type="hidden" name="id" value="{{@$id}}">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @include('admin.includes.message')
                                   @foreach(@$questions as $key=> $value)
                                   @if($key<20)
                                    <div class="col-md-12 col-sm-12">
                                      <div class="availability_check">
                                        <input id="ques{{@$value->id}}" type="checkbox" value="{{@$value->id}}" name="question[]" {{ $selected->contains('faq_id',@$value->id)?'checked':'' }}>
                                        <label for="ques{{@$value->id}}">{{@$value->question}} 
                                        </label>
                                      </div>
                                    </div>
                                    @endif
                                    @endforeach

                                    <div class="moretext" style="display: none;">
                                      @foreach(@$questions as $key=> $value)
                                      @if($key>=20)
                                    <div class="col-md-12 col-sm-12">
                                      <div class="availability_check">
                                        <input id="ques{{@$value->id}}" type="checkbox" value="{{@$value->id}}" name="question[]" {{ $selected->contains('faq_id',@$value->id)?'checked':'' }}>
                                        <label for="ques{{@$value->id}}">{{@$value->question}} 
                                        </label>
                                      </div>
                                    </div>
                                    @endif
                                    @endforeach
                                  </div>

                                  @if(count(@$questions)>20)
                                          <a class="see-all moreless-button" >View More Question +</a>
                                  @endif



                                   </div>
                                 </div>
                                 <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Save</button>
                                </div>

                                 
                               </div>
                             </form>



                                </div>
                            </div>
                        </div>
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
<script type="text/javascript">
  $('.moreless-button').click(function() {
  $('.moretext').slideToggle();
  if ($('.moreless-button').text() == "View More Question +") {
    $(this).text("View Less Question -")
  } else {
    $(this).text("View More Question +")
  }
});
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
