@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage State</title>
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
                    <h4 class="pull-left page-title">Manage State</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('manage.state.add.view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add State</a></li>
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
                            <form role="form" action="{{route('manage.state.search')}}" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Country</label>
                                    <select class="form-control rm06 basic-select" name="country">
                                        <option value="">Select Country</option>
                                        @foreach(@$countris as $country)
                                        <option value="{{@$country->id}}" @if(request('country')==$country->id) selected @endif>{{@$country->name}}</option>
                                        @endforeach
                                     </select>
                                </div>

                                <div class="form-group">
                                    <label for="FullName">State Name</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('name')}}" name="name" placeholder="State Name">
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
                                                    <th>Country Name</th>
                                                    <th> State Name</th>
                                                   <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($states->isNotEmpty())
                                                @foreach(@$states as $state)
                                                <tr>
                                                    <td>{{@$state->countrylist->name}}</td>
                                                    <td>{{@$state->name}}</td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$state->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$state->id}}" style="display: none;">
                                                            <span class="angle custom_angle_state"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('manage.state.edit',['id'=>$state->id])}}">Edit </a></li>
                                                                <li><a href="{{route('manage.state.delete',['id'=>$state->id])}}" onclick="return confirm('Do you want to delete this state?')">Delete</a></li>
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
                                        {{@$states->links()}}
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
  @foreach (@$states as $state)

    $("#action{{$state->id}}").click(function(){
        $('.show-actions:not(#show-{{$state->id}})').slideUp();
        $("#show-{{$state->id}}").slideToggle();
    });
 @endforeach


});
</script>
@endsection
