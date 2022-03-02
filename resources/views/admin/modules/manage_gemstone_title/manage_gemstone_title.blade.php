@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Gemstone Title</title>
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
                    <h4 class="pull-left page-title">Manage Gemstone Title</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.gemstone.title.add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Title</a></li>
                        <li class="active"><a href="{{route('admin.manage.gemstone.sub-title-add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Sub Title</a></li>
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
                            <form role="form" action="{{route('admin.manage.gemstone.title')}}" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Parent Title</label>
                                    <select class="form-control rm06  basic-select" name="title">
                                        <option value="">Select Title</option>
                                        @foreach(@$title as $value)
                                        <option value="{{@$value->id}}" @if(request('title')==@$value->id) selected @endif>{{@$value->title}}</option>
                                        @endforeach
                                    </select>
                                  </div>

                                <div class="form-group">
                                    <label for="FullName">Keyword</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('keyword')}}" name="keyword" placeholder="Keyword">
                                </div>

                                 <div class="form-group">
                                    <label for="FullName">Type</label>
                                    <select class="form-control rm06" name="type">
                                        <option value="">Select Title</option>
                                        <option value="T" @if(request('type')=='T') selected @endif>Title</option>
                                        <option value="S" @if(request('type')=='S') selected @endif>Sub Title</option>
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
                                                    <th>Title</th>
                                                    <th>Parent Title</th>
                                                    <th>Type</th>
                                                    <th>Image</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$alltitle->isNotEmpty())
                                                @foreach(@$alltitle as $value)
                                                <tr>
                                                    <td>{{@$value->title}}</td>
                                                    <td>
                                                        @if(@$value->parent_id==0)
                                                        ---
                                                        @else
                                                        {{@$value->parent->title}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(@$value->parent_id==0)
                                                        Title
                                                        @else
                                                        Sub Title
                                                        @endif
                                                    </td>
                                                    <td>@if(@$value->image!="")<img src="{{ URL::to('storage/app/public/gemstone_title')}}/{{@$value->image}}" class="widthimg80"> @else No Image @endif</td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('admin.manage.gemstone.title.edit-view',['id'=>$value->id])}}">Edit </a></li>
                                                                <li><a href="{{route('admin.manage.gemstone.title.delete',['id'=>$value->id])}}" onclick="return confirm('Do you want to delete this?')">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr><td>No Data </td></tr>
                                                @endif
                                                
                                            </tbody>
                                        </table>
                                    </div>


                                    <ul class="pagination rtg">
                                        {{@$alltitle->links()}}
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

  @foreach (@$alltitle as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
});
</script>
@endsection
