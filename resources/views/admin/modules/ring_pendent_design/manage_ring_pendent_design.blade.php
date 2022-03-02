@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Ring Pendent Design</title>
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
            <h4 class="pull-left page-title">Manage Ring Pendent Design</h4>
           <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.ring.pendent.design.add-view')}}"><i class="fa fa-plus" aria-hidden="true"></i> Add </a></li>
                        <li class="active"><a href="{{route('admin.gemstone.sub.menu')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back To Menu</a></li>
                    </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                <form role="form" action="{{route('admin.manage.ring.pendent.design')}}" method="post" id="search_form">
                 @csrf
                 
                  <div class="form-group">
                    <label for="FullName">Design Name</label>
                    <input type="text" placeholder="Design Name" class="form-control" name="keyword" value="{{request('keyword')}}">
                  </div>
                 
                  <div class="form-group">
                                                  <label for="FullName">Select Type</label>
                                                 <select class="form-control rm06 basic-select" name="type" id="type">
                                                  <option value="">Select Type</option>
                                                  <option value="P" @if(request('type')=="P") selected @endif>Pendent</option>
                                                  <option value="R" @if(request('type')=="R") selected @endif>Ring</option>
                                                  
                                                 </select>
                                                 <div id="error_type"></div>
                   </div>

                  
                  <div class="rm05">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
                  </div>
                </form>
              </div>
              <div class="panel-body">
                <div class="row">
                	@include('admin.includes.message')
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Type</th>
                            <th>Design Name</th>
                            <th>Image</th>
                            <th class="rm07">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @if(@$design->isNotEmpty())
                        @foreach(@$design as $value)
                          <tr>
                            <td>
                              @if(@$value->type=="R") Ring @else Pendent @endif
                            </td>
                            <td>{{@$value->design_name}}</td>
                            <td>@if(@$value->design_image!="")<img src="{{ URL::to('storage/app/public/ring_pendent_design')}}/{{@$value->design_image}}" class="widthimg80"> @else No Image @endif</td>
                            <td class="rm07">
                            <a href="javascript:void(0);" class="action-dots" id="action{{@$value->id}}"><img src="{{ URL::to('public/admin/assets/images/action-dots.png')}}" alt=""></a>
                               <div class="show-actions" id="show-{{@$value->id}}" style="display: none;">
                                 <span class="angle custom_angle"><img src="{{ URL::to('public/admin/assets/images/angle.png')}}" alt=""></span>
                                <ul>
                                    <li><a href="{{route('admin.manage.ring.pendent.design.edit',['id'=>@$value->id])}}">Edit</a></li>
                                    <li><a href="{{route('admin.manage.ring.pendent.design.delete',['id'=>@$value->id])}}"  onclick="return confirm('Do you want to delete this ?')">Delete</a></li>
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
                    
                    
                    <ul class="pagination rtg">
                      {{@$design->links()}}
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
	  @foreach (@$design as $value)

    $("#action{{$value->id}}").click(function(){
        $('.show-actions:not(#show-{{$value->id}})').slideUp();
        $("#show-{{$value->id}}").slideToggle();
    });
 @endforeach
</script>

@endsection