@extends('admin.layouts.app')


@section('title')
<title>Astroaquila | Edit Gemstone Price</title>
@endsection

@section('style')
@include('admin.includes.style')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
    #exits_title{
        display: none;
        color: red;
    }
  #required_image{
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
            <h4 class="pull-left page-title">Edit Gemstone Price</h4>
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
                                        <h3 class="panel-title">Edit Gemstone</h3>
                                    </div>
                                    <div class="panel-body rm02 rm04">
                                        <form role="form" id="gemstonePriceForm" method="post" action="{{route('admin.manage.edit-gemstone-price',['id'=>@$data->id])}}" enctype="multipart/form-data">
                                            @csrf
                                          <input type="hidden" name="product_id" value="{{@$data->id}}">

                                            <div class="row">
											<div class="form-group label_new_class">
												<label for="category_name"  class="wid-25">Gemstone</label>
												<select class="form-control rm06" name="gemstone_id" id="gemstone_id" disabled>
													<option value="">Select Gemstone</option>
													@foreach(@$gemstones as $gems)
													<option value="{{@$gems->id}}" @if ($data->id == @$gems->id) selected @endif>@if(@$gems->product_name!=""){{@$gems->product_name}} ({{@$gems->product_code}}) @else {{@$gems->title->title}} ({{@$gems->product_code}}) @endif </option>
													@endforeach

												 </select>
												<div id="err_gemstone_id"></div>
											</div>
										</div>
										<div class="form-group label_new_class base_data" style="display:none;">
								 <label>Weight: <span id="base_weight">{{@$data->product_weight}}</span></label><label>Base Price (In INR): <span id="base_price_inr">{{@$data->price_inr}}</span></label><label>Base Price (In USD): <span id="base_price_usd">{{@$data->price_usd}}</span></label>
								 </div>
										<div class="row" id="dynamicform"> 
									@if(@$gemstone_prices->isNotEmpty())
										@foreach(@$gemstone_prices as $key=>$price)
                                        <div class="col-md-12 row_{{@$key}} p-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                <div class="form-group rm03 label_new_class">
												<label>Weight (In Carat)</label>
                                                <input type="number" placeholder="Weight (In Carat)" name="weight[]" id="weight_{{$key}}" class="weight_{{$key}} form-control required" min="1" value="{{@$price->weight}}">
                                                 </div>
                                                </div>

                                                <div class="col-md-3">
                                                <div class="form-group rm03 label_new_class">
												<label class="wid-35">Price INR</label>
                                                <input type="text" placeholder="Price INR" name="price_inr[]" id="price_inr_{{$key}}" class="price_inr_0 form-control required number" min="1" value="{{@$price->price_inr}}">
                                                 </div>
                                                </div>


                                                <div class="col-md-3">
                                                <div class="form-group rm03 label_new_class">
												<label class="wid-35">Price USD</label>
                                                <input type="text" placeholder="Price USD" name="price_usd[]" id="price_usd_{{$key}}" class="price_usd_0 form-control required number" min="1" value="{{@$price->price_usd}}">
                                                 </div>
                                                </div>

                                                <div class="col-md-3">
													<button class="btn btn-primary waves-effect waves-light w-md btn_add new_addmore_btn" type="button" data-id="{{$key}}" onclick="window.location.href='{{route('admin.manage.delete-gemstone-price',['id',$price->id])}}'">Delete</button>
                                                </div>    

                                             </div>   

                                         </div>
										 @endforeach
										 @endif
										 <div class="col-md-12 row_{{@$key+1}} p-0">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                <div class="form-group rm03 label_new_class">
												<label>Weight (In Carat)</label>
                                                <input type="number" placeholder="Weight (In Carat)" name="weight[]" id="weight_{{@$key+1}}" class="recitals_{{@$key+1}} form-control @if(@$gemstone_prices->isEmpty()) required @endif" min="1">
                                                 </div>
                                                </div>

                                                <div class="col-md-3">
                                                <div class="form-group rm03 label_new_class">
												<label class="wid-35">Price INR</label>
                                                <input type="text" placeholder="Price Inr" name="price_inr[]" id="price_inr_{{@$key+1}}" class="price_inr_{{@$key+1}} form-control @if(@$gemstone_prices->isEmpty()) required @endif number" min="1">
                                                 </div>
                                                </div>


                                                <div class="col-md-3">
                                                <div class="form-group rm03 label_new_class">
												<label class="wid-35">Price USD</label>
                                                <input type="text" placeholder="Price Usd" name="price_usd[]" id="price_usd_{{@$key+1}}" class="price_usd_{{@$key+1}} form-control @if(@$gemstone_prices->isEmpty()) required @endif number" min="1">
                                                 </div>
                                                </div>

                                                <div class="col-md-3">
													<button class="btn btn-primary waves-effect waves-light w-md btn_add new_addmore_btn" type="button" data-id="{{@$key+1}}">Add More</button>
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
<script>
    $(document).ready(function(){
       var ix = '{{@$key+1}}';
	var weights=[];
	@if(@$gemstone_prices->isNotEmpty())
	@foreach(@$gemstone_prices as $key=>$price)
	weights.push('{{@$price->weight}}');
	@endforeach
	@endif
	console.log(recitals);
       $('body').on('click','.btn_add',function(){
		$('.error_price').html('');
		if($('.weight_'+ix).val()>0 && $('.price_inr_'+ix).val()>0 && $('.price_usd_'+ix).val()>0)
		{
			//console.log($.inArray($('.weight_'+ix).val(), recitals)===-1);
			
			if($.inArray($('.weight_'+ix).val(), weights)!==-1)
			{
				$('.error_price').html('recital number already added');
				$('.weight_'+ix).val('');
				return false;
			}
			weights.push($('.weight_'+ix).val());
			console.log(weights);
			$(this).addClass('btn-remove');
			$(this).text('remove');
			$('.row_'+ix).addClass('removeform_'+ix);
			$(this).removeClass('btn_add');
			ix++;
			$("#dynamicform").append('<div class="col-md-12 row_'+ix+' p-0"><div class="row"><div class="col-md-3"><div class="form-group rm03 label_new_class"><label>No Of Recitals</label><input type="number" placeholder="Weight (In Carat)" name="weight[]" id="weight_'+ix+'" class="weight_'+ix+' form-control @if(@$gemstone_prices->isEmpty()) required @endif" min="1"></div></div><div class="col-md-3"><div class="form-group rm03 label_new_class"><label class="wid-35">Price INR</label><input type="text" placeholder="Price INR" name="price_inr[]" id="price_inr_'+ix+'" class="price_inr_'+ix+' form-control @if(@$gemstone_prices->isEmpty()) required @endif number" min="1"></div></div><div class="col-md-3"><div class="form-group rm03 label_new_class"><label class="wid-35">Price USD</label><input type="text" placeholder="Price USD" name="price_usd[]" id="price_usd_'+ix+'" class="price_usd_'+ix+' form-control @if(@$gemstone_prices->isEmpty()) required @endif number" min="1"></div></div><div class="col-md-3"> <button class="btn btn-primary waves-effect waves-light w-md btn_add new_addmore_btn" type="button" data-id="'+ix+'">Add More</button></div></div></div>');			
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
	$("#gemstonePriceForm").validate({
		submitHandler:function(form){
			if(ix>0)
			{
				if($.inArray($('.weight_'+ix).val(), recitals)!==-1)
				{
					$('.error_price').html('Weight already added');
					$('.error_price').show();
					$('.weight_'+ix).val('');
					return false;
				}
			}
			form.submit();
			
		}

        });
    })
</script>
@endsection
