@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Pandit</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
  .rm05 {
    float: left;
    margin: 10px 0 0 12px;
}
</style>
@endsection

@section('content')
<!-- Top Bar Start -->
@include('admin.includes.header')
<!-- Top Bar End -->


<!-- ========== Left Sidebar Start ========== -->
@include('admin.includes.sidebar')

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
            <h4 class="pull-left page-title">Manage Pundits</h4>
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
                <form role="form" action="{{route('admin.manage.pandit.search')}}" method="post" id="search_form"> 
                @csrf
                <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                    <label for="FullName">Keyword</label>
                    <input type="text" placeholder="Keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>
                  <div class="form-group">
                    <label for="">City</label>
                    <input type="text" placeholder="Enter City" class="form-control" name="city" value="{{request('city')}}">
                  </div>
                  <div class="form-group">
                    <label for="FullName">Puja</label>
                    <select class="form-control rm06 basic-select" name="type">
                      <option value="">Select</option>
                      <option value="ONLINE" @if(request('type')=='ONLINE') selected @endif >Online</option>
                      <option value="OFFLINE" @if(request('type')=='OFFLINE') selected @endif>Offline</option>
                      <option value="BOTH" @if(request('type')=='BOTH') selected @endif>Both</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="FullName">Status</label>
                   <select class="form-control rm06 basic-select" name="status">
                      <option value="">Select Status</option>
                      <option value="N" @if(request('status')=='N') selected @endif>Awaiting Approval</option>
                        <option value="A" @if(request('status')=='A') selected @endif>Active</option>
                        <option value="I" @if(request('status')=='I') selected @endif>Inactive</option>
                        <option value="U" @if(request('status')=='U') selected @endif>Unverified</option>
                        
                    </select>
                  </div>
                  <div class="clearfix"></div>

                  <div class="form-group">
                    <label for="FullName">Availability</label>
                   <select class="form-control rm06 basic-select" name="avail">
                      <option value="">Select Availability</option>
                        <option value="Y" @if(request('avail')=='Y') selected @endif>Yes</option>
                        <option value="N" @if(request('avail')=='N') selected @endif>No</option>
                    </select>
                  </div>
                  <div class="clearfix"></div>
                  <div class="rm05">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
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
                            <th>Pundit name</th>
                            <th> Email</th>
                            <th> Mobile No.</th>
                            <th> City</th>
                            <th> Puja</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th>Availability</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$pundits->isNotEmpty())
                        @foreach(@$pundits as $pundit)
                          <tr>
                            <td>{{@$pundit->first_name}} {{@$pundit->last_name}}</td>
                            <td>{{@$pundit->email}}</td>
                            <td>{{@$pundit->mobile}}</td>
                            <td>{{@$pundit->city}}</td>
                            <td>{{@$pundit->puja_type}}</td>
                            <td class="@if(@$pundit->status=='A') green @elseif(@$pundit->status=='I') cancel @elseif(@$pundit->status=='U') waitc @endif">
                            	@if(@$pundit->status=='A')
                                Active
                                @elseif(@$pundit->status=='I')
                                Inactive
                                @elseif(@$pundit->status=='U')
                                Unverified
                                @endif
                            </td>
                            <td>
                            	@if(@$pundit->approve_by_admin=="Y")
                            	Yes
                            	@else
                            	No
                            	@endif
                            </td>
                            <td>
                              @if(@$pundit->user_availability=="Y")
                              Yes
                              @else
                              No
                              @endif
                            </td>

                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{@$pundit->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$pundit->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                   <li>
                                		@if(@$pundit->approve_by_admin=='N')
                                    	<a href="{{route('admin.pundit.approve',['id'=>@$pundit->id])}}" onclick="return confirm('Do you want to approve this pundit account ?')">Approve</a>
                                    	@else
                                      
                                    	@endif
                                    </li>
                                    
                                    
                                    <li><a href="{{route('admin.pundit.view',['id'=>@$pundit->id])}}">View </a></li>
                                    <li><a href="{{route('admin.pundit.edit-view',['id'=>@$pundit->id])}}">Edit </a></li>
                                    @if(@$pundit->approve_by_admin!='N')
                                    
                                    
                                    
                                    <li>
                                    	@if(@$pundit->status=='A')
                                         <a href="{{route('admin.pundit.status',['id'=>@$pundit->id])}}" onclick="return confirm('Do you want to change status for this pundit ?')">Inactive</a>
                                         @elseif(@$pundit->status=='I')
                                          <a href="{{route('admin.pundit.status',['id'=>@$pundit->id])}}" onclick="return confirm('Do you want to change status for this pundit ?')"> Active</a>
                                          @elseif(@$pundit->status=='U')
                                          @endif
                                    </li>
                                   
                                   @endif

                                   <li><a href="{{route('admin.pundit.puja.list',['id'=>@$pundit->id])}}" >View Pujas</a></li>

                                   <li><a href="{{route('admin.pundit.delete',['id'=>@$pundit->id])}}" onclick="return confirm('Do you want to delete this pundit account ?')">Delete</a></li>
								   
								   <li><a href="{{route('admin.pundit.reset.password',['id'=>@$pundit->id])}}" onclick="return confirm('Are you sure you want to reset the password of this pundit?')">Reset Password</a></li>
                                  
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
                     {{@$pundits->links()}}
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
	  @foreach (@$pundits as $pundit)

    $("#action{{$pundit->id}}").click(function(){
        $('.show-actions:not(#show-{{$pundit->id}})').slideUp();
        $("#show-{{$pundit->id}}").slideToggle();
    });
 @endforeach
</script>
@endsection