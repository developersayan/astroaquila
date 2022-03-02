@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Astrologer</title>
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
            <h4 class="pull-left page-title">Manage Astrologer</h4>
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
                <form role="form" action="{{route('admin.manage.astrologer.search')}}" method="post" id="search_form">
                @csrf
                <input type="hidden" name="page" value="" id="page">
                  <div class="form-group">
                    <label for="FullName">Keyword</label>
                    <input type="text" placeholder="Keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>
                  <div class="form-group">
                    <label for="">Expertise</label>
                    <input type="text" placeholder="Enter Expertise" class="form-control" name="expertise" value="{{request('expertise')}}">
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
                            <th>Astrologer name</th>
                            <th> Email</th>
                            <th> Mobile No.</th>
                            <th> Gender</th>
                            <th> City</th>
                            <th> Exprience</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th>Show At Home</th>
                            <th>Availability</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$users->isNotEmpty())
                        @foreach(@$users as $user)
                          <tr>
                            <td>{{@$user->first_name}} {{@$user->last_name}}</td>
                            <td>{{@$user->email}}</td>
                            <td>{{@$user->mobile}}</td>
                            <td>
                            	@if(@$user->gender=="M")
                            	Male
                            	@elseif(@$user->gender=="F")
                            	Famale
                            	@else
                            	--
                            	@endif
							</td>
                            <td>{{@$user->getCity->name}}</td>
                            <td>{{@$user->experience}} Year</td>
                            <td class="@if(@$user->status=='A') green @elseif(@$user->status=='I') cancel @elseif(@$user->status=='U') waitc @endif">
                            	@if(@$user->status=='A')
                                Active
                                @elseif(@$user->status=='I')
                                Inactive
                                @elseif(@$user->status=='U')
                                Unverified
                                @endif
                            </td>
                            <td>
                            	@if(@$user->approve_by_admin=="Y")
                            	Yes
                            	@else
                            	No
                            	@endif
                            </td>
                            <td>
                              @if(@$user->show_at_home=='Y')
                              Yes
                              @else 
                              No 
                              @endif
                            </td>
                            <td>
                              @if(@$user->user_availability=="Y")
                              No
                              @else
                              Yes
                              @endif
                            </td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{@$user->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                            <div class="show-actions" id="show-{{@$user->id}}" style="display: none;">
                                <span class="angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                	<li>
                                		@if(@$user->approve_by_admin=='N')
                                    	<a href="{{route('admin.astrologer.approve',['id'=>@$user->id])}}" onclick="return confirm('Do you want to approve this astrologer account ?')">Approve</a>
                                    	@else

                                    	@endif
                                  </li>
                                  <li><a href="{{route('admin.astrologer.view',['id'=>@$user->id])}}">View</a></li>
                                  <li><a href="{{route('admin.astrologer.edit-view',['id'=>@$user->id])}}">Edit</a></li>
                                    {{-- if the user is in approval process this code exicute --}}
                                  @if(@$user->approve_by_admin!='N')



                                    <li>
                                        @if(@$user->status=='A')
                                         <a href="{{route('admin.astrologer.status',['id'=>@$user->id])}}" onclick="return confirm('Do you want to change status for this astrologer ?')">Inactive</a>
                                         @elseif(@$user->status=='I')
                                          <a href="{{route('admin.astrologer.status',['id'=>@$user->id])}}" onclick="return confirm('Do you want to change status for this astrologer ?')"> Active</a>
                                          @elseif(@$user->status=='U')
                                          @endif
                                    </li>

                                    @endif

                                    <li><a href="{{route('admin.astrologer.delete',['id'=>@$user->id])}}"  onclick="return confirm('Do you want to delete this astrologer account ?')">Delete</a></li>

                                    <li><a href="{{route('admin.manage.astrologer.faq',['id'=>@$user->id])}}"
                                      >Faq</a></li>

                                    @if(@$user->approve_by_admin=='Y')  
                                    @if(@$user->show_at_home=="Y")
                                    <li><a href="{{route('admin.manage.astrologer.show.home',['id'=>@$user->id])}}"  onclick="return confirm('Do you want to hide this astrologer from home ?')">Hide From Home</a></li>
                                    @else
                                    <li><a href="{{route('admin.manage.astrologer.show.home',['id'=>@$user->id])}}"  onclick="return confirm('Do you want to show this astrologer at home ?')">Show At Home</a></li>
                                    @endif
                                    @endif


									<li><a href="{{route('admin.astrologer.reset.password',['id'=>@$user->id])}}" onclick="return confirm('Are you sure you want to reset the password of this astrologer?')">Reset Password</a></li>
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
                        {{@$users->links()}}
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
	  @foreach (@$users as $user)

    $("#action{{$user->id}}").click(function(){
        $('.show-actions:not(#show-{{$user->id}})').slideUp();
        $("#show-{{$user->id}}").slideToggle();
    });
 @endforeach
</script>
@endsection
