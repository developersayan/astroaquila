@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Gemstone Category</title>
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
                    <h4 class="pull-left page-title">Manage Gemstone Category</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.gemstone.category.add')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Category</a></li>
                        <li class="active"><a href="{{route('admin.gemstone.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.gemstone.category.manage')}}" method="post" id="search_form">
                                @csrf
                                 <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Keyword</label>
                                    <input type="text" id="FullName" class="form-control" value="{{@$key['keyword']}}" name="keyword" placeholder="Keyword">
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
                                                    <th>Category Image</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$AllGemstoneCategory->isNotEmpty())
                                                @foreach (@$AllGemstoneCategory as $category)
                                                <tr>
                                                    <td>{{$category->category_name}}</td>
                                                    <td>@if(@$category->image!="")<img src="{{ URL::to('storage/app/public/gemstone_category')}}/{{@$category->image}}" class="widthimg80"> @else No Image @endif</td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$category->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$category->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>                                                                
                                                                <li><a href="{{route('admin.gemstone.category.edit',['id'=>$category->id])}}">Edit </a></li>
																<li><a href="{{route('admin.gemstone.category.delete',['id'=>$category->id])}}" onclick="return confirm('Do you want to delete this gemstone category?')">Delete</a></li>
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
                                        {{@$AllGemstoneCategory->links()}}
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
  @foreach (@$AllGemstoneCategory as $category)

    $("#action{{$category->id}}").click(function(){
        $('.show-actions:not(#show-{{$category->id}})').slideUp();
        $("#show-{{$category->id}}").slideToggle();
    });
 @endforeach
});
</script>
@endsection
