@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Customer</title>
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
                    <h4 class="pull-left page-title">Manage Customer</h4>
                    <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.site.user.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
            </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading rm02 rm04">
                            <form role="form" action="{{route('admin.manage.search')}}" method="post" id="search_form">
                                @csrf
                                 <input type="hidden" name="page" value="" id="page">
                                <div class="form-group">
                                    <label for="FullName">keyword</label>
                                    <input type="text" placeholder="keyword"  name="keyword" class="form-control" value="{{request('keyword')}}">
                                </div>
                                <div class="form-group">
                                    <label for="FullName">Status</label>
                                    <select class="form-control rm06 basic-select" name="status">
                                        <option value="">Select Status</option>
                                        <option value="A"  @if(request('status')=='A') selected @endif>Active</option>
                                        <option value="I" @if(request('status')=='I') selected @endif>Inactive</option>
                                        <option value="U" @if(request('status')=='U') selected @endif>Unverified</option>
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
                                                    <th>Customer name</th>
                                                    <th> Email</th>
                                                    <th> Mobile No.</th>
                                                    <th> Gender</th>
                                                    <th> City</th>
                                                    <th> Gotra</th>
                                                    <th>Status</th>
                                                    <th class="rm07">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(@$allCustomer->isNotEmpty())
                                                @foreach ($allCustomer as $customer)
                                                <tr>
                                                    <td>{{@$customer->first_name}} {{$customer->last_name}}</td>
                                                    <td>{{$customer->email}}</td>
                                                    <td>{{$customer->mobile}}</td>
                                                    <td>
                                                        @if($customer->gender=='M')
                                                        Male
                                                        @elseif($customer->gender=='M')
                                                        Female
                                                        @else
                                                        Not Select
                                                        @endif
                                                    </td>
                                                    <td>{{@$customer->city ? $customer->city: '-'}}</td>
                                                    <td>{{@$customer->gotra_id ? @$customer->gotra_id : 'Not Select' }}</td>
                                                    <td class="@if($customer->status=='A') green @elseif($customer->status=='I') cancel @elseif($customer->status=='U') waitc @endif">
                                                        @if($customer->status=='A')
                                                        Active
                                                        @elseif($customer->status=='I')
                                                        Inactive
                                                        @elseif($customer->status=='U')
                                                        Unverified
                                                        @endif

                                                    </td>
                                                    <td class="rm07">
                                                        <a href="javascript:void(0);" class="action-dots" id="action{{$customer->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                                                        <div class="show-actions" id="show-{{$customer->id}}" style="display: none;">
                                                            <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                                            <ul>
                                                                
                                                                <li><a href="{{route('admin.customer.view',['id'=>@$customer->id])}}">View </a></li>
                                                               
                                                               {{--  @if(@$customer->status!="U")
                                                                <li><a href="#">View Order</a></li>
                                                                @endif --}}
                                                                <li>
                                                                    @if(@$customer->status=='A')
                                                                   <a href="{{route('admin.customer.status',['id'=>@$customer->id])}}" onclick="return confirm('Do you want to change status for this customer ?')">Inactive</a>
                                                                    @elseif(@$customer->status=='I')
                                                                   <a href="{{route('admin.customer.status',['id'=>@$customer->id])}}" onclick="return confirm('Do you want to change status for this customer ?')"> Active</a>
                                                                   @elseif(@$customer->status=='U')
                                                                    @endif
                                                                    </li>
                                                                <li><a href="{{route('admin.customer.delete',['id'=>@$customer->id])}}" onclick="return confirm('Do you want to remove this customer ?')">Delete</a></li>
																<li><a href="{{route('admin.customer.reset.password',['id'=>@$customer->id])}}" onclick="return confirm('Are you sure you want to reset the password of this customer?')">Reset Password</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="8">
                                                        <center> No Data </center>
                                                    </td>
                                                </tr>
                                                @endif


                                            </tbody>
                                        </table>
                                    </div>


                                   <ul class="pagination rtg">
                                        {{@$allCustomer->links()}}
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

  @foreach (@$allCustomer as $customer)

    $("#action{{$customer->id}}").click(function(){
        $('.show-actions:not(#show-{{$customer->id}})').slideUp();
        $("#show-{{$customer->id}}").slideToggle();
    });
 @endforeach
});
</script>
@endsection
