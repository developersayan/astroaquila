@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Manage Commission</title>
@endsection

@section('style')
@include('admin.includes.style')
<style type="text/css">

  .edit_action li {
    display: inline-block;
    margin: 0 4px;
}

</style>
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
            <h4 class="pull-left page-title">Manage Commission </h4>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              

              <div class="panel-heading rm02 rm04">
              @include('admin.includes.message')
             
                <form role="form"  method="post" id="commission_form" action="{{route('admin.manage.commission.update')}}">
                  @csrf
                  <div class="form-group">
                      <label for="FullName">Astrologer Commission (%)</label>
                            <input type="text" placeholder="Astrologer Commission" name="call_comm" class="form-control" value="{{@$commision->call_comm}}">
                    </div>

                    <div class="form-group">
                      <label for="FullName">Pundit Commission (%)</label>
                            <input type="text" placeholder="Pundit Commission" name="puja_comm" class="form-control" value="{{@$commision->puja_comm}}">
                    </div>
                  <div class="rm05">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Update</button>
                  </div>
               </form>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <h4 class="pull-left page-title">Individual Commissions Of Astrologer/Pundit</h4>
          </div>
        </div>








   <div class="row">
          <div class="col-md-12">
            
              
              
                <div class="row">
                  <div class="col-md-12">
               <div class="panel panel-default">
              <div class="panel-heading rm02 rm04">
                      <form role="form" class="search_filter" method="post" action="{{route('admin.manage.commission.search')}}">
                        @csrf
                       <div class="form-group">
                          <label for="">Keyword</label>
                         <input type="text" placeholder="Keyword" class="form-control" name="keyword" value="{{request('keyword')}}">
                        </div>

                        <div class="form-group">
                                    <label for="FullName">Type</label>
                                    <select class="form-control rm06" name="type">
                                        <option value="">Select Type</option>
                                        <option value="A"  @if(request('type')=='A') selected @endif>Astrologer</option>
                                        <option value="P"  @if(request('type')=='P') selected @endif>Pundit</option>
                                     </select>
                                </div>
                        
                        <div class="rm05">
                          <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Search</button>
                        </div>
                      </form>
                    </div>
                    <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Type</th>
                            <th>Commission</th>
                            <th>Action</th>
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
                              @if(@$user->user_type=="P")
                              Pundit
                              @elseif(@$user->user_type=="A")
                              Astrologer
                              @endif
                            </td>
                            <td>
                              @if(@$user->comission_percentage!="")
                              {{@$user->comission_percentage}} %
                              @else
                              Not Set Yet
                              @endif
                            </td>
                            <td>
                              <ul class="edit_action">
                                     <li><a href="{{route('admin.manage.edit-commission',['id'=>@$user->id])}}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o"></i></a></li>
                                </ul>     
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
                       {{@$users->appends(request()->except(['page', '_token']))->links()}}
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
    </div>
   @include('admin.includes.footer')
  </div>
@endsection
@section('script')
@include('admin.includes.script')  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
   $("#commission_form").validate({
            rules: {
                call_comm:{
                    required: true,
                    number:true,
                    min:1,
                    max:99,
                },
                puja_comm:{
                    required: true,
                    number:true,
                    min:1,
                    max:99, 
                },
              },
              messages:{
                call_comm:{
                    required: "please enter astrologer commision",
                    number:"Please enter astrologer commision properly",
                    min:'Please enter astrologer commision properly',
                    max:'Maximum commision should be less than or equal to 99',
                },
                puja_comm:{
                  required:"please enter pundit commision",
                  number:"Please enter pundit commision properly",
                  min:'Please enter pundit commision properly',
                  max:'Maximum commision should be less than or equal to 99',
                },
              },
            })
</script>

@endsection