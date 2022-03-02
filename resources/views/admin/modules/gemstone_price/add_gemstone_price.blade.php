@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Add Gemstone Price </title>
@endsection

@section('style')
@include('admin.includes.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
	#exits_title{
		display: none;
		color: red;
	}
  #error_image{
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
            <h4 class="pull-left page-title">Add Gemstone </h4>
            <ol class="breadcrumb pull-right">
              <li class="active"><a href="{{route('admin.manage.gemstone.price')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></i> Back</a></li>
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
                                        <h3 class="panel-title">Add Gemstone Price</h3>
                                    </div>
                                    <div class="panel-body rm02 rm04">
                                        <form role="form" id="gemstonePriceForm" method="post" action="{{route('admin.manage.add-gemstone-price')}}" enctype="multipart/form-data">
                                        	@csrf
                                          <div class="row">
                                    <div class="form-group label_new_class">
                                        <label for="category_name"  class="wid-25">Gemstone</label>
                                        <select class="form-control rm06 required basic-select" name="gemstone_id" id="gemstone_id" @if(@$gemstone_details->id) disabled @endif>
											<option value="">Select Gemstone</option>
											@foreach(@$gemstones as $gems)
											<option value="{{@$gems->id}}" @if(@$gemstone_details->id == @$gems->id) selected @endif>@if(@$gems->product_name!=""){{@$gems->product_name}} ({{@$gems->product_code}}) @else {{@$gems->title->title}} ({{@$gems->product_code}}) @endif</option>
											@endforeach

										 </select>
										 <input type="hidden" name="gemstone_id" value="{{@$gemstone_details->id}}"/>
                                    </div>
									<label id="gemstone_id-error" class="error" for="gemstone_id" generated="true" style="display:none;"></label>
                                </div>
								 
                                     


                                    <div class="row" id="dynamicform"> 
                                        <div class="col-md-12">
                                            <div class="row align-items-center">
                                                <div class="col-md-6 col-xs-12">
                                                <div class="form-group rm03">
												<label>Weight (In Carat)</label>
                                                <input type="text" placeholder="Weight" name="weight" id="weight" class="weight_0 form-control required number" min="1">
                                                 </div>
                                                </div>
												
												<div class="col-md-6 col-xs-12">
                                                <div class="form-group rm03">
												<label class="">Price Type</label>
                                                <select class="form-control rm06" name="price_type" id="price_type">
													<option value="A"> Add with Base Price</option>
													<option value="D"> Deduct from Base Price</option>
												</select>
                                                 </div>
                                                </div>
												<div class="clearfix"></div>

                                                <div class="col-md-6 col-xs-12">
                                                <div class="form-group rm03">
												<label class="inr_price_type">Add Price INR</label>
                                                <input type="text" placeholder="Price INR" name="price_inr" id="price_inr" class="price_inr_0 form-control required number" min="1">
                                                 </div>
                                                </div>


                                                <div class="col-md-6 col-xs-12">
                                                <div class="form-group rm03">
												<label class="usd_price_type">Add Price USD</label>
                                                <input type="text" placeholder="Price USD" name="price_usd" id="price_usd" class="price_usd_0 form-control required number" min="1">
                                                 </div>
                                                </div>

                                                <div class="col-md-3 col-xs-12">
													<button class="btn btn-primary waves-effect waves-light w-md btn_add new_addmore_btn" type="button" data-id="0">Add More</button>
                                                </div>    


                                             


                                             </div>
                                             <div class="clearfix"></div>   

                                         </div>
										 <div id="added_data">
										 @if(@$gemstone_price_details && @$gemstone_price_details->isNotEmpty())

										 	<div class="table-responsive">
											  <table class="table">
												<thead>
												  <tr>
													<th>Weight (In Carat):</th>
													<th>Price (In INR):</th>
													<th>Price (In USD):</th>
													<th>Price Type:</th>
													<th></th>
												  </tr>
												</thead>
												<tbody class="added_table_data">
												@foreach(@$gemstone_price_details as $value)
													<tr class="added_data_{{@$value->id}}">
														<td>{{@$value->weight}}</td>
														<td>@if(@$value->price_type=='A') + @elseif(@$value->price_type=='D') - @endif {{@$value->price_inr}} </td>
														<td>@if(@$value->price_type=='A') + @elseif(@$value->price_type=='D') - @endif {{@$value->price_usd}}</td>
														<td>@if(@$value->price_type=='A') Increasing @elseif(@$value->price_type=='D') Decreasing @else Base @endif</td>
														<td>@if(@$value->price_type!='B')<i class="fa fa-times remove_price" data-id="{{@$value->id}}"></i>@endif</td>
													</tr>
													@endforeach
													
												</tbody>
											  </table>
											</div>
										@endif
										</div>
										 
                                     </div>   
									 <div class="clearfix"></div>
                                  <div class="row">
                                    <div class="form-group">
                                        <label class="error error_price"></label>
                                    </div>
                                </div>
                                            <!--<div class="col-lg-12"> <button class="btn btn-primary waves-effect waves-light w-md" type="submit">Save</button></div>-->
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
   $(document).ready(function(){
       $('body').on('click','.btn_add',function(){
		   $("#gemstonePriceForm").valid();
		$('.error_price').html('');
		var weight=$('#weight').val();
		var price_inr=$('#price_inr').val();
		var price_usd=$('#price_usd').val();
		var price_type=$('#price_type').val();
		/*if($('#gemstone_id').val()!='' && $('#weight').val()>0 && $('#price_inr').val()>0 && $('price_usd').val()>0)
		{*/
			var data={
			jsonrpc:"2.0",
			_token:"{{csrf_token()}}",
			'gemstone_id':$('#gemstone_id').val(),
			'weight':weight,
			'price_inr':price_inr,
			'price_usd':price_usd,
			'price_type':price_type,
			}
			$.ajax({
			url:'{{route('admin.manage.save-gemstone-price')}}',
			type:'POST',
			dataType:'JSON',
			data:data,
			success:function(data){
			  if(data.error=='error')
			  {
				  if(data.message)
				  {
					  $('.error_price').html(data.message);
					  $('.error_price').show();
				  }
				  
			  }
			  else
			  {
				  if(price_type=='A')
				  {
					  var html='<tr class="added_data_'+data.price_id+'"><td>'+weight+'</td><td>+ '+price_inr+'</td><td>+ '+price_usd+'</td><td>Increasing</td><td><i class="fa fa-times remove_price" data-id="'+data.price_id+'"></i></td></tr>';
					  
				  }
				  else
				  {
					  var html='<tr class="added_data_'+data.price_id+'"><td>'+weight+'</td><td>- '+price_inr+'</td><td>- '+price_usd+'</td><td>Decreasing</td><td><i class="fa fa-times remove_price" data-id="'+data.price_id+'"></i></td></tr>';
				  }				  
					$('.added_table_data').append(html);
			  }
			}
		  })
		/*}
		else
		{
			$('.error_price').html('Please fill up all the fields');
			return false;
		}*/
        
        
    });


   
    $('body').on('click', '.remove_price', function(){  
         var id = $(this).data("id");
		 if(confirm('Are you sure you want to delete the gemstone price?'))
		 {
			 var data={
			jsonrpc:"2.0",
			_token:"{{csrf_token()}}",
			'id':id,
			}
			 $.ajax({
				url:'{{route('admin.manage.delete-gemstone-price')}}',
				type:'POST',
				dataType:'JSON',
				data:data,
				success:function(data){
				  //console.log(data);
				  if(data.success=='success')
				  {
					  $('.added_data_'+id+'').remove();
				  }
				}
			  })
		 }         
    });
	
	$('#price_type').change(function(){
		var price_type=$(this).val();
		if(price_type=='A')
		{
			$('.inr_price_type').html('Add Price INR');
			$('.usd_price_type').html('Add Price USD');
		}
		else
		{
			$('.inr_price_type').html('Deduct Price INR');
			$('.usd_price_type').html('Deduct Price USD');
		}
	});
	
		$('#gemstone_id').change(function(){
			$('#added_data').html('');
			var gemstone_id=$(this).val();
			var data={
			jsonrpc:"2.0",
			_token:"{{csrf_token()}}",
			'gemstone_id':gemstone_id,
			}
			$.ajax({
			url:'{{route('admin.fetch.gemstone.price')}}',
			type:'POST',
			dataType:'JSON',
			data:data,
			success:function(data){
			  //console.log(data);
			  if(data.success=='success')
			  {
				  $('#added_data').append(data.html);
			  }
			}
		  })
		});
   });
    
   
</script>
@endsection
