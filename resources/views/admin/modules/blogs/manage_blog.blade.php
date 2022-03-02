@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Blog </title>
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
                    <h4 class="pull-left page-title">Manage Blog </h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.add.blog-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Blog</a></li>
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
                            <form role="form" action="{{route('admin.manage.blog.search')}}" method="post" id="search_form">
                                @csrf
                                 <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Keyword</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('keyword')}}" name="keyword" placeholder="Keyword Name">
                                </div>
                                <div class="form-group">
                                    <label for="FullName">Status</label>
                                    <select class="form-control rm06 basic-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="A" @if(request('status')=='A') selected @endif>Active</option>
                                        <option value="I" @if(request('status')=='I') selected @endif>Inactive</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="FullName">Category</label>
                                    <select class="form-control rm06  basic-select" name="category">
                                        <option value="">Select Category</option>
                                        @foreach(@$category as $value)
                                        <option value="{{@$value->id}}" @if(request('category')==@$value->id) selected @endif>{{@$value->category}}</option>
                                         @endforeach

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
                                                    <th>Blog name</th>
                                                    <th>Category name</th>
                                                    <th>Author Name</th>
                                                    <th>Status</th>
                                                    <th>Show At Home</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$blogs->isNotEmpty())
                                                @foreach (@$blogs as $value)
                                                <tr>
                                                    <td class="wid-35">{{$value->blog_title}}</td>
                                                    <td>{{$value->category->category}}</td>
                                                    <td >{{$value->author_name}}{{--  {!! substr(@$value->blog_desc, 0, 150 ) . '...' !!}< --}}</td>
                                                    <td class=" @if($value->status=='A') green @elseif($value->status=='I') cancel @endif">
                                                        @if($value->status=='A')
                                                        Active
                                                        @elseif($value->status=='I')
                                                        Inactive
                                                        @endif
                                                    </td>
                                                    <td class="@if($value->is_show=='Y') green @elseif($value->is_show=='N') cancel @endif">
                                                        @if($value->is_show=='Y')
                                                        Yes
                                                        @elseif($value->is_show=='N')
                                                        No
                                                        @endif
                                                    </td>

                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('admin.manage.edit-blog-view',['id'=>$value->id])}}">Edit </a></li>
                                                                <li><a href="{{route('admin.manage.delete.blog-delete',['id'=>$value->id])}}" onclick="return confirm('Do you want to delete this blog?')">Delete</a></li>

                                                                @if($value->status=='A')
                                                                <li>
                                                                    <a href="{{route('admin.manage.featured.blog-featured',['id'=>$value->id])}}"  onclick="return confirm('Do you want to change status for this blog?')">
                                                                        @if($value->is_show=='N')
                                                                        Show In Home
                                                                        @elseif($value->is_show=='Y')
                                                                        Hide From Home
                                                                        @endif
                                                                    </a>
                                                                </li>
                                                                @endif


                                                                <li>
                                                                    <a href="{{route('admin.manage.change.blog-status',['id'=>$value->id])}}"  onclick="return confirm('Do you want to change status for this blog?')">
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
                                        {{@$blogs->links()}}
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
  @foreach (@$blogs as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>
</script>
@endsection
