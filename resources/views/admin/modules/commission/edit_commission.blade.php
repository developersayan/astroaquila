@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Commission</title>
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
            <h4 class="pull-left page-title">Edit Commission </h4>
             <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.commission')}}"><i
                                    class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
                    </ol>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              

              <div class="panel-heading rm02 rm04">
              @include('admin.includes.message')
             
                <form role="form"  method="post" id="commission_form" action="{{route('admin.manage.update-commission')}}">
                  @csrf
                  <input type="hidden" name="user_id" value="{{@$data->id}}">
                  <div class="form-group">
                      <label for="FullName">Name</label>
                            <input type="text" placeholder="Astrologer Commission" name="call_comm" class="form-control" value="{{@$data->first_name}} {{@$data->last_name}} " disabled>
                    </div>

                    <div class="form-group">
                      <label for="FullName">Set Commission(%)</label>
                            <input type="text" placeholder="Set Commission" name="comission_percentage" class="form-control" value="{{@$data->comission_percentage}}">
                    </div>
                  <div class="rm05">
                    <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Update</button>
                  </div>
               </form>
              </div>
            </div>
          </div>
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
                comission_percentage:{
                    max:100,
                },
                
              },
              messages:{
                comission_percentage:{
                    max: "Commission should not be greater than 100",
                },
              },
            })
</script>

@endsection