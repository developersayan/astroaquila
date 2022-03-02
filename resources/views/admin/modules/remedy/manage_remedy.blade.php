@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Remedy</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">
	#exits_title{
		display: none;
		color: red;
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
            <h4 class="pull-left page-title">Manage Remedies</h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.add-view-remedy')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add Remedies</a></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="clearfix"></div>
            <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                <form role="form" method="post" action="{{route('admin.manage.remedy.search')}}">
                	@csrf
                  <div class="form-group">
                    <label for="FullName">Remedies name</label>
                    <input type="text" placeholder="Remedies Name" class="form-control" name="remedy" value="{{request('remedy')}}">
                  </div>
                  
                  <div class="form-group">
                    <label for="FullName">Type</label>
                    <select class="form-control rm06" name="expertise">
                      <option value="">Select Type</option>
                      @foreach(@$experties as $expertise)
                      <option value="{{@$expertise->id}}" @if(request('expertise')==@$expertise->id) selected @endif>{{@$expertise->expertise_name}}</option>
                      @endforeach
                    </select>
                  </div>
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
                            <th>Remedies name</th>
                            <th> Description</th>
                            <th> Type</th>
                            <th> Price</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if(@$remedies->isNotEmpty())	
                          @foreach(@$remedies as $remedy)
                          <tr>
                            <td>{{@$remedy->remedies_name}}</td>
                            <td class="wid-35">{{@$remedy->description}}</td>
                            <td>{{@$remedy->remedytype->expertise_name}}</td>
                            <td>₹{{@$remedy->price}}</td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{@$remedy->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                               <div class="show-actions" id="show-{{@$remedy->id}}" style="display: none;">
                                 <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.edit-remedy',['id'=>@$remedy->id])}}">Edit </a></li>
                                    <li><a href="{{route('admin.manage.delete-remedy',['id'=>@$remedy->id])}}"  onclick="return confirm('Do you want to delete this remedy?')">Delete</a></li>
                                </ul>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                          @else
                          <tr><td>No Data</td></tr>
                          @endif
					     </tbody>
                      </table>
                    </div>
                    
                    
                    <ul class="pagination">
                      {{@$remedies->appends(request()->except(['page', '_token']))->links()}}
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
	  @foreach (@$remedies as $remedy)

    $("#action{{$remedy->id}}").click(function(){
        $('.show-actions:not(#show-{{$remedy->id}})').slideUp();
        $("#show-{{$remedy->id}}").slideToggle();
    });
 @endforeach
</script>
@endsection
