@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Product Category</title>
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
                    <h4 class="pull-left page-title">Manage Product Category</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.product.category.add')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Category</a></li>
                        <li class="active"><a href="{{route('admin.product.sub-category.add')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub Category</a></li>
                        <li class="active"><a href="{{route('admin.product.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.product.category.manage')}}" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Parent Category</label>
                                    <select class="form-control rm06 basic-select" name="category">
                                        <option value="">Select Category</option>
                                        @foreach(@$category as $value)
                                        <option value="{{@$value->id}}" @if(request('category')==@$value->id) selected @endif>{{@$value->name}}</option>
                                        @endforeach
                                    </select>
                                  </div>

                                <div class="form-group">
                                    <label for="FullName">Keyword</label>
                                    <input type="text" id="FullName" class="form-control" value="{{@$key['keyword']}}" name="keyword" placeholder="Keyword">
                                </div>
                                <div class="form-group">
                                    <label for="FullName">Status</label>
                                    <select class="form-control rm06 basic-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="A" @if(@$key['status']=='A') selected @endif>Active</option>
                                        <option value="I" @if(@$key['status']=='I') selected @endif>Inactive</option>

                                    </select>
                                </div>
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
                                                    <th>Category name</th>
                                                    <th>Parent Category Name</th>
                                                    <th> Image</th>
                                                    <th>Status</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$AllProductCategory->isNotEmpty())
                                                @foreach (@$AllProductCategory as $productCategory)
                                                <tr>
                                                    <td>{{$productCategory->name}}</td>
                                                    <td>
                                                        @if($productCategory->label=="C")
                                                        --
                                                        @else
                                                        {{$productCategory->parent->name}}
                                                        @endif
                                                    </td>
                                                    <td class="icon-image">
                                                        @if(@$productCategory->image!="")
                                                        <img src="{{ URL::to('storage/app/public/product_category_image')}}/{{@$productCategory->image}}">
                                                        @else
                                                        No Image
                                                        @endif
                                                    </td>
                                                    <td class=" @if($productCategory->status=='A') green @elseif($productCategory->status=='I') cancel @endif">
                                                        @if($productCategory->status=='A')
                                                        Active
                                                        @elseif($productCategory->status=='I')
                                                        Inactive
                                                        @endif
                                                    </td>

                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$productCategory->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$productCategory->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                @if(@$productCategory->label=="C")
                                                                <li><a href="{{route('admin.product.category.edit',['id'=>$productCategory->id])}}">Edit </a></li>
                                                                @else
                                                                <li><a href="{{route('admin.product.sub-category.edit',['id'=>$productCategory->id])}}">Edit </a></li>
                                                                @endif

                                                                <li><a href="{{route('admin.product.category.delete',['id'=>$productCategory->id])}}" onclick="return confirm('Do you want to delete this product category?')">Delete</a></li>
                                                                <li>
                                                                    <a href="{{route('admin.product.category.status.change',['id'=>$productCategory->id])}}"  onclick="return confirm('Do you want to change status for this product category?')">
                                                                        @if($productCategory->status=='I')
                                                                        Active
                                                                        @elseif($productCategory->status=='A')
                                                                        Inactive
                                                                        @endif
                                                                    </a>
                                                                </li>
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
                                        {{@$AllProductCategory->links()}}
                                        {{-- <li class="paginate_button previous disabled"><a href="#">Previous</a></li>
                                        <li class="paginate_button active"><a href="#">1</a></li>
                                        <li class="paginate_button"><a href="#">2</a></li>
                                        <li class="paginate_button"><a href="#">3</a></li>
                                        <li class="paginate_button"><a href="#">4</a></li>
                                        <li class="paginate_button"><a href="#">5</a></li>
                                        <li class="paginate_button"><a href="#">6</a></li>
                                        <li class="paginate_button next"><a href="#">Next</a></li> --}}
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

<script>
    $(document).ready(function(){
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

  @foreach (@$AllProductCategory as $productCategory)

    $("#action{{$productCategory->id}}").click(function(){
        $('.show-actions:not(#show-{{$productCategory->id}})').slideUp();
        $("#show-{{$productCategory->id}}").slideToggle();
    });
 @endforeach
});
</script>
@endsection
