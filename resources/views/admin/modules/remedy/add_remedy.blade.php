@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Remedy</title>
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
            <h4 class="pull-left page-title">Manage Remedies </h4>
            <ol class="breadcrumb pull-right">
				<li class="active"><a href="{{route('admin.manage.remedy')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
			</ol>
          </div>
        </div>
         <div class="row">
                        <div class="col-lg-12"> 
                        @include('admin.includes.message')
                        <div> 
                           
                                <!-- Personal-Information -->
                                <div class="panel panel-default panel-fill">
                                    <div class="panel-heading"> 
                                        <h3 class="panel-title">Add Remedies</h3>

                                    </div> 
                                    <div class="panel-body rm02 rm04"> 
                                        <form role="form" id="remedy_form" action="{{route('admin.manage.add-remedy')}}" method="post">
                                        	@csrf
                                            
                                            <div class="form-group">
                                                <label for="FullName">Remedies name</label>
                                                <input type="text" placeholder="Remedies name" value="{{old('name')}}" name="name" class="form-control" id="remedy_name">
                                                <div id="exits_title">Remedy already added in this category</div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="FullName">Type</label>
                                               <select class="form-control rm06" name="type" id="type_id">
                                                  <option value="">Select Type</option>
                                                  @foreach(@$experties as $expertise)
                                                  <option value="{{@$expertise->id}}" @if (old('type') == @$expertise->id) selected @endif>{{@$expertise->expertise_name}}</option>
                                                  @endforeach
                                               </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="FullName">Price</label>
                                                <input type="text" name="price" value="{{old('price')}}" placeholder="Price" class="form-control">
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="form-group rm03">
                                                <label for="AboutMe">Remedies  description</label>
                                                <textarea style="height: 80px" name="description" id="AboutMe" class="form-control">{{old('description')}}</textarea>
                                            </div>

                                           
                                            <div class="clearfix"></div>
                                            <div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>
                                        </form>

                                    </div> 
                                </div>
                                <!-- Personal-Information -->
                           
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
	  $("#remedy_form").validate({
           rules: {
                name: {
                   required:true,
                },
                type: {
                   required:true,
                },
	          price:{
	           	required:true,
	           	number:true,
	           	min:1,
	           },
	           description:{
	           	required:true,
	           },
	      },
       
        messages: {
          name: {
            required:'Please enter remedy name',
            },  
           
           price:{
           	required:'Please enter price',
           	number:'Please enter number',
           	min:'Please enter price properly',
           },
           type:{
           	required:'Please select type of remedy',
           },
           description:{
           	required:'Please enter description of remedy',
           },
        },
        submitHandler: function(form){
               var type_id = $('#type_id').val();
                var remedy_name = $('#remedy_name').val();
              	 $.ajax({
                      url:"{{route('admin.manage.check-remedy')}}",
                      method:"GET",
                      data:{'type_id':type_id,'remedy_name':remedy_name},
                      success: function(res) {
                      console.log(res);  
                      if (res=="found") {
                        $('#exits_title').css('display','block');
                        return false; 
                     }else{
                     	form.submit();
                     }
                   }
               });
          },
	});
   
</script>
@endsection