@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Aquilia wiki list </title>
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
                    <h4 class="pull-left page-title">Manage Aquilia wiki list </h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.add.aquilia.wiki')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Aquilia wiki list</a></li>
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
                                    <label for="FullName">Category</label>
                                    <select class="form-control rm06 basic-select" name="category">
                                        <option value="">Select category</option>
                                        @foreach (@$category as $cat)
                                            <option value="{{ @$cat->id }}" @if(request('category') == @$cat->id) selected @endif>{{ @$cat->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="FullName">Title</label>
                                    <select class="form-control rm06  basic-select" name="title">
                                        <option value="">Select Title</option>
                                        @if(@$title)
                                            @foreach (@$title as $ti)
                                                <option value="{{ @$ti->id }}" @if(request('title') == @$ti->id) selected @endif>{{ @$ti->title }}</option>
                                            @endforeach
                                        @endif

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
                                                    <th>Article Title</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Subcategory</th>
                                                    {{-- <th>Description</th> --}}
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$wiki->isNotEmpty())
                                                @foreach (@$wiki as $value)
                                                <tr>
                                                    <td >{{$value->article_title}}</td>
                                                    <td>{{$value->getTitle->title}}</td>
                                                    <td >{{$value->getCategory->name}}</td>
                                                    <td class="">
                                                        {{$value->getSubCategory->name}}
                                                    </td>
                                                    {{-- <td class="wid-35">
                                                        {!! substr(@$value->description, 0,100) . '...' !!}
                                                    </td> --}}

                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('admin.edit.aquilia.wiki',['id'=>$value->id])}}">Edit </a></li>
                                                                <li><a href="{{route('admin.delete.aquilia.wiki',['id'=>$value->id])}}" onclick="return confirm('Do you want to delete this Article?')">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr><td colspan="5"><center> No Data </center></td></tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>


                                    <ul class="pagination rtg">
                                        {{@$wiki->links()}}
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
  @foreach (@$wiki as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>
</script>
@endsection
