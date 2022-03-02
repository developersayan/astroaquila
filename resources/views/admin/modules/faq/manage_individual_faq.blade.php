@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage  Faq</title>
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
                    <h4 class="pull-left page-title">Manage  Faq  <span style="margin-left: 5px;">@if( @$type=="P")(Product Code : {{@$code->product_code}}  |  Product Name: {{@$code->product_name}}) @elseif(@$type=="G") (Product Code : {{@$code->product_code}}  |  Product Name: @if(@$code->title_id==''){{@$code->product_name}} @else {{@$code->title->title}} @endif)  @elseif(@$type=="PU") (Puja Code : {{@$code->puja_code}}  |  Puja Name: {{@$code->puja_name}}) @elseif(@$type=="H") (Horoscope Code : {{@$code->code}}  |  Horoscope Name: {{@$code->name}}) @elseif(@$type=="A")(Astrologer Name : {{@$code->first_name}} {{@$code->last_name}})  @endif</span></h4>


                    <ol class="breadcrumb pull-right">
                        
                        <li class="active"><a href="@if(@$type=="PU"){{route('admin.manage.faq.puja.add-view',['id'=>@$id])}} @elseif(@$type=="G") {{route('admin.manage.faq.gamestone.add-view',['id'=>@$id])}} @elseif(@$type=="P") {{route('admin.manage.faq.product.add-view',['id'=>@$id])}} @elseif(@$type=="H") {{route('admin.manage.horoscope.faq.add',['id'=>@$id])}} @elseif(@$type=="A") {{route('admin.manage.astrologer.faq.add-view',['id'=>@$id])}}  @endif"><i class="fa fa-plus" aria-hidden="true"></i> Add Faq</a> 


                          / <a href="@if(@$type=="G") {{route('admin.manage.faq.gamestone.genral.faq.view',['id'=>@$id])}} @elseif(@$type=="P") {{route('admin.manage.faq.product.genral.faq.view',['id'=>@$id])}} @elseif(@$type=="PU") {{route('admin.manage.faq.puja.genral.faq.view',['id'=>@$id])}} @elseif(@$type=="H") {{route('admin.manage.horoscope.add.general.faq',['id'=>@$id])}}  @elseif(@$type=="A") {{route('admin.manage.astrologer.add.general-faq',['id'=>@$id])}} @endif"><i class="fa fa-plus" aria-hidden="true"></i> Add from General FAQ </a>  </li>
                    </ol>



                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        {{-- <div class="panel-heading rm02 rm04">
                            <form role="form" action="@if(@$type=="PU"){{route('admin.manage.faq.puja',['id'=>@$id]) }} @elseif(@$type=="G") {{route('admin.manage.faq.gamestone',['id'=>@$id])}} @else {{route('admin.manage.faq.product',['id'=>@$id])}} @endif" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Keyword</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('keyword')}}" name="keyword" placeholder="Keyword">
                                </div>

                               <div class="rm05">
                                    <button class="btn btn-primary waves-effect waves-light w-md"
                                        type="submit">Search</button>
                                </div>
                            </form>
                        </div> --}}
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
                                                    <th>Display Order</th>
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
                                                        {!!substr(@$value->answer, 0, 150 )!!}..
                                                      @else
                                                      {!!@$value->answer!!}
                                                      @endif
                                                  </td>
                                                  <td>@if(@$value->display_order!="") {{@$value->display_order}} @else -- @endif</td>
                                                  <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="@if(@$type=="PU"){{route('admin.manage.faq.puja.edit-view',['faq'=>$value->id])}} @elseif(@$type=="G") {{route('admin.manage.faq.gamestone.edit-view',['faq'=>$value->id])}} @elseif(@$type=="P") {{route('admin.manage.faq.product.edit-view',['faq'=>@$value->id])}} @elseif(@$type=="H") {{route('admin.manage.horoscope.faq.edit',['faq'=>@$value->id])}} @elseif(@$type=="A") {{route('admin.manage.astrologer.faq.edit-view',['faq'=>@$value->id])}} @endif">Edit </a></li>
                                                                <li><a href="{{route('admin.manage.faq.delete',['id'=>@$value->id])}}" onclick="return confirm('Do you want to delete this faq ?')">Delete</a></li>
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
@endsection
