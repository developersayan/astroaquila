@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Mantra</title>
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
                    <h4 class="pull-left page-title">Add Mantra</h4>
                    <ol class="breadcrumb pull-right">
                        <li class="active"><a href="{{route('admin.manage.mantra')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></li>
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
                                <h3 class="panel-title">Add Mantra </h3>
                            </div>
                            <div class="panel-body rm02 rm04">
                                <form role="form" action="{{route('admin.manage.mantra.insert')}}"  method="POST" id="mantraForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                    <div class="form-group label_new_class">
                                        <label for="category_name"  class="wid-25">Mantra name</label>
                                        <input type="text" placeholder="Mantra name" id="mantra" class="form-control" name="mantra" required>
                                        <div id="err_category"></div>
                                    </div>
                                </div>
                                     


                                    <div class="row" id="dynamicform"> 
                                        <div class="col-md-12 row_0 p-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-3 col-xs-12">
                                                <div class="form-group rm03 label_new_class">
												<label>No of recitals</label>
                                                <input type="number" placeholder="No of recitals" name="recital[]" id="recitals_0" class="recitals_0 form-control required" min="1">
                                                 </div>
                                                </div>

                                                <div class="col-md-3 col-xs-12">
                                                <div class="form-group rm03 label_new_class">
												<label class="wid-35">Price INR</label>
                                                <input type="text" placeholder="Price INR" name="price_inr[]" id="price_inr_0" class="price_inr_0 form-control required number" min="1">
                                                 </div>
                                                </div>


                                                <div class="col-md-3 col-xs-12">
                                                <div class="form-group rm03 label_new_class">
												<label class="wid-35">Price USD</label>
                                                <input type="text" placeholder="Price USD" name="price_usd[]" id="price_usd_0" class="price_usd_0 form-control required number" min="1">
                                                 </div>
                                                </div>

                                                <div class="col-md-3 col-xs-12">
													<button class="btn btn-primary waves-effect waves-light w-md btn_add new_addmore_btn" type="button" data-id="0">Add More</button>
                                                </div>    


                                             


                                             </div>   

                                         </div>
                                     </div>   
									 <div class="clearfix"></div>
                                  <div class="row">
                                    <div class="form-group">
                                        <label class="error error_price"></label>
                                    </div>
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
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->

@endsection

@section('script')
@include('admin.includes.script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
<script type="text/javascript">
   
    var ix = 0;
	var recitals=[];
       $('body').on('click','.btn_add',function(){
		$('.error_price').html('');
		if($('.recitals_'+ix).val()>0 && $('.price_inr_'+ix).val()>0 && $('.price_usd_'+ix).val()>0)
		{
			console.log($.inArray($('.recitals_'+ix).val(), recitals)===-1);
			if(ix>0)
			{
				if($.inArray($('.recitals_'+ix).val(), recitals)!==-1)
				{
					$('.error_price').html('recital number already added');
					$('.recitals_'+ix).val('');
					return false;
				}
			}
			recitals.push($('.recitals_'+ix).val());
			console.log(recitals);
			$(this).addClass('btn-remove');
			$(this).text('remove');
			$('.row_'+ix).addClass('removeform_'+ix);
			$(this).removeClass('btn_add');
			ix++;
			$("#dynamicform").append('<div class="col-md-12 row_'+ix+' p-0"><div class="row"><div class="col-md-3"><div class="form-group rm03 label_new_class"><label>No Of Recitals</label><input type="number" placeholder="No of recitals" name="recital[]" id="recitals_'+ix+'" class="recitals_'+ix+' form-control required" min="1"></div></div><div class="col-md-3"><div class="form-group rm03 label_new_class"><label class="wid-35">Price INR</label><input type="text" placeholder="Price INR" name="price_inr[]" id="price_inr_'+ix+'" class="price_inr_'+ix+' form-control required number" min="1"></div></div><div class="col-md-3"><div class="form-group rm03 label_new_class"><label class="wid-35">Price USD</label><input type="text" placeholder="Price USD" name="price_usd[]" id="price_usd_'+ix+'" class="price_usd_'+ix+' form-control required number" min="1"></div></div><div class="col-md-3"> <button class="btn btn-primary waves-effect waves-light w-md btn_add new_addmore_btn" type="button" data-id="'+ix+'">Add More</button></div></div></div>');			
		}
		else
		{
			$('.error_price').html('Please fill up all the fields');
			return false;
		}
        
        
    });


   
    $('body').on('click', '.btn-remove', function(){  
         var id = $(this).data("id");
		 console.log(id)
        $('.removeform_'+id+'').remove();  
    });  
   
</script>


<script>
    $(document).ready(function(){
       $("#mantraForm").validate({
            rules: {
                name: {
                   required:true,
                },
           },
        messages: {
                name: {
                    required:'Please enter mantra name',
             },  

        },
		submitHandler:function(form){
			if(ix>0)
			{
				if($.inArray($('.recitals_'+ix).val(), recitals)!==-1)
				{
					$('.error_price').html('recital number already added');
					$('.error_price').show();
					$('.recitals_'+ix).val('');
					return false;
				}
			}
			form.submit();
			
		}

        });
    })
</script>
@endsection
