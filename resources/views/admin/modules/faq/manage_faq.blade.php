@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage General Faq</title>
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
                    <h4 class="pull-left page-title">Manage General Faq</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.general.faq.add.view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Faq</a></li>
                        <li class="active"><a href="{{route('admin.settings.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.manage.general.faq')}}" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Keyword</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('keyword')}}" name="keyword" placeholder="Keyword">
                                </div>

                                <div class="form-group">
                                                <label for="FullName">Type</label>
                                               <select class="form-control rm06 basic-select" name="type" id="type">
                                                  <option value="">Select Type</option>
                                                  <option value="P" @if(request('type')=="P") selected @endif>Product</option>
                                                  <option value="G" @if(request('type')=="G") selected @endif>Gemstone</option>
                                                  <option value="PU" @if(request('type')=="PU") selected @endif>Puja</option>
                                                  <option value="H" @if(request('type')=="H") selected @endif>Horoscope</option>
                                                  <option value="A" @if(request('type')=="A") selected @endif>Astrologer</option>
                                                  <option value="D" @if(request('type')=="D") selected @endif>Aquila Data Bank</option>
                                               </select>
                                               <label id="type-error" class="error" for="type"></label>
                                    </div>

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
                                  <div class="clearfix"></div>

                                  <div class="form-group">
                                                <label for="FullName">Show In Search</label>
                                               <select class="form-control rm06 basic-select" name="show" id="show">
                                                  <option value="">Select</option>
                                                  <option value="Y" @if(request('show')=="Y") selected @endif>Yes</option>
                                                  <option value="N" @if(request('show')=="N") selected @endif>No</option>
                                                </select>
                                               <label id="type-error" class="error" for="type"></label>
                                    </div>

                                  {{-- <div class="clearfix"></div> --}}
                               
                                <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @include('admin.includes.message')
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Sub Category</th>
                                                    <th>Question</th>
                                                    <th>Answer</th>
                                                    <th>Type</th>
                                                    <th>Display Order</th>
                                                    <th>Show On Search </th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$faq->isNotEmpty())
                                                @foreach (@$faq as $value)
                                                <tr>
                                                    <td>@if(@$value->category_id!=""){{@$value->category->faq_category}} 
                                                    @else -- @endif</td>
                                                    <td>@if(@$value->subcategory_id!=""){{@$value->subcategory->faq_category}} 
                                                    @else -- @endif</td>
                                                    <td> 
                                                      @if(strlen(@$value->question) >60)
                                                        {!! substr(@$value->question, 0, 60 ) . '...' !!}
                                                      @else
                                                      {{@$value->question}}
                                                      @endif
                                                     </td>
                                                    <td class="w80">
                                                        @if(strlen(@$value->answer) >150)
                                                        {!!substr(@$value->answer, 0, 150 ) . '...' !!}
                                                      @else
                                                      {!!$value->answer!!}
                                                      @endif
                                                  </td>
                                                  <td>@if(@$value->type=="P")Product @elseif(@$value->type=="G")Gemstone @elseif(@$value->type=="PU") Puja @elseif(@$value->type=="H") Horoscope @elseif(@$value->type=="D") Aquila Data Bank @else Astrologer @endif</td>
                                                  <td>@if(@$value->display_order!=""){{@$value->display_order}} @else -- @endif</td>
                                                  <td>@if(@$value->show_in_search=="Y")Yes @else No @endif</td>
                                                   <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('admin.manage.general.faq.edit',['id'=>$value->id])}}">Edit </a></li>
                                                                <li><a href="{{route('admin.manage.general.faq.delete',['id'=>$value->id])}}" onclick="return confirm('Do you want to delete this faq ?')">Delete</a></li>

                                                                <li><a href="{{route('admin.manage.general.faq.show-on-search',['id'=>$value->id])}}" @if(@$value->show_in_search=="Y") onclick="return confirm('Do you want to remove this from search page ?')" @else onclick="return confirm('Do you want to add this in search page ?')" @endif>
                                                                  @if(@$value->show_in_search=="Y") Hide From Serach @else Show At Search @endif
                                                                </a></li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr><td colspan="4"><center> No Data </center></td></tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>


                                    <ul class="pagination rtg">
                                        {{@$faq->links()}}
                                    </ul>

                                    


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
                  $(".rtg li a").click(function(){
      
      
      var url = $(this).attr('href');
      
      

      var vars = [], hash;
      var hashes = url.slice(window.location.href.indexOf('?') + 1).split('&');
      for(var i = 0; i < hashes.length; i++)
      {
          hash = hashes[i].split('=');
          vars.push(hash[0]);
          vars[hash[0]] = hash[1];
      }
      // console.log(hash[1]);
      $('#page').val(hash[1]);
      $("#search_form").submit();
      return false;
    });
    @foreach (@$faq as $value)

     $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>
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
