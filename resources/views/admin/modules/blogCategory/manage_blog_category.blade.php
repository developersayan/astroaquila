@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Blog Category</title>
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
                    <h4 class="pull-left page-title">Manage Blog Category</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.add-blog-category-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Category</a></li>
                        <li class="active"><a href="{{route('admin.blog.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.manage.blog.category.search')}}" method="post" id="search_form">>
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Category name</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('category_name')}}" name="category_name" placeholder="Category Name">
                                </div>
                                <div class="form-group">
                                    <label for="FullName">Status</label>
                                    <select class="form-control rm06 basic-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="A" @if(request('status')=='A') selected @endif>Active</option>
                                        <option value="I" @if(request('status')=='I') selected @endif>Inactive</option>

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
                                                    <th>Status</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$category->isNotEmpty())
                                                @foreach (@$category as $value)
                                                <tr>
                                                    <td>{{$value->category}}</td>
                                                    
                                                    <td class=" @if($value->status=='A') green @elseif($value->status=='I') cancel @endif">
                                                        @if($value->status=='A')
                                                        Active
                                                        @elseif($value->status=='I')
                                                        Inactive
                                                        @endif
                                                    </td>

                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('admin.manage.edit-blog-category-view',['id'=>$value->id])}}">Edit </a></li>
                                                                <li><a href="{{route('admin.manage.blog-category-delete',['id'=>$value->id])}}" onclick="return confirm('Do you want to delete this blog category?')">Delete</a></li>
                                                                <li>
                                                                    <a href="{{route('admin.manage.blog-category-status',['id'=>$value->id])}}"  onclick="return confirm('Do you want to change status for this blog category?')">
                                                                        @if($value->status=='I')
                                                                        Active
                                                                        @elseif($value->status=='A')
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
                                        {{@$category->links()}}
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
    @foreach (@$category as $value)

     $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>
</script>
@endsection
