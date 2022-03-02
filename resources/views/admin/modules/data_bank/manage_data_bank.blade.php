@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Data Bank</title>
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
                    <h4 class="pull-left page-title">Manage Data Bank</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.data.bank.add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Data</a></li>
                        <li class="active"><a href="{{route('admin.horoscope.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.manage.data.bank')}}" method="post" id="search_form">
                                @csrf
                                <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">Name</label>
                                    <input type="text" id="FullName" class="form-control" value="{{request('name')}}" name="name" placeholder="Name">
                                </div>

                                <div class="form-group">
                                                <label for="FullName">Profession</label>
                                                <select class="form-control rm06 basic-select" name="profession_id" id="profession_id">
                                                  <option value="">Select Profession</option>
                                                  @foreach(@$profession as $value)
                                                  <option value="{{@$value->id}}" @if(request('profession_id')==@$value->id) selected @endif>{{@$value->name}}</option>
                                                  @endforeach
                                                </select>
                                                 
                                     </div>

                                     <div class="form-group">
                                                <label for="FullName">Famous For</label>
                                                <select class="form-control rm06 basic-select" name="famous_id" id="famous_id">
                                                  <option value="">Select Famous For</option>
                                                  @foreach(@$famous as $value)
                                                  <option value="{{@$value->id}}" @if(request('famous_id')==@$value->id) selected @endif>{{@$value->name}}</option>
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
                                                    <th>Name</th>
                                                    <th>Date Of Birth</th>
                                                    <th>Place Of Birth</th>
                                                    <th>Address</th>
                                                    <th>Profession</th>
                                                    <th>Famous For</th>
                                                    <th>Image</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$data->isNotEmpty())
                                                @foreach (@$data as $value)
                                                <tr>
                                                    <td>{{$value->name}}</td>
                                                    <td>{{ date('F j, Y', strtotime(@$value->dob))}}</td>
                                                    <td>{{$value->place_of_birth}}</td>
                                                    <td>{{@$value->countrylist->name}},{{@$value->statelist->name}},{{@$value->citylist->name}}</td>
                                                    <td>{{@$value->professionName->name}}</td>
                                                    <td>{{@$value->famousName->name}}</td>
                                                    <td>@if(@$value->image!="")<img src="{{ URL::to('storage/app/public/dataBank')}}/{{@$value->image}}" class="widthimg80"> @else No Image @endif</td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$value->id}}" style="display: none;">
                                                            <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                <li><a href="{{route('admin.manage.data.bank.edit',['id'=>$value->id])}}">Edit </a></li>
                                                                <li><a href="{{route('admin.manage.data.bank.delete',['id'=>$value->id])}}" onclick="return confirm('Do you want to delete this data ?')">Delete</a></li>
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
                                        {{@$data->links()}}
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
    @foreach (@$data as $value)

     $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>
</script>
@endsection
