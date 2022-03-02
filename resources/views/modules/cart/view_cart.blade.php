@extends('layouts.app')

@section('title')
<title>Shopping Cart</title>
@endsection

@section('style')
@include('includes.style')
@endsection

@section('header')
@include('includes.header')
@endsection



@section('body')
<section class="pad-114">
    <div class="product-det">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cart-head">
                        <h2>Shopping Cart</h2>
                    </div>
                    <div class="cart-table">
                        <div class="table-cus">
                            <div class="row amnt-tble">
                                <div class="cell amunt cess">Product Details</div>
                                <div class="cell amunt cess">Quantity</div>
                                <div class="cell amunt cess">Unit Price </div>
                                <div class="cell amunt cess">Total </div>
								<div class="cell amunt cess">Tentative date of Delivery</div>
                                <div class="cell amunt cess font0">Action</div>
                            </div>
                            @if($allCartData->count()>0)
                            @foreach ($allCartData as $cart)
                            <div class="row small_screen2 scernexr new-tabc">
                                <div class="cell amunt-detail cess"> <span class="hide_big font0">Product Details</span>
                                    <div class="product">
                                        <figure class="product-media">
										@if($cart->cart_type=='GS')
											<a href="{{route('gemstone.details',['slug'=>$cart->product->slug])}}">
                                                <img src="{{ URL::to('storage/app/public/small_gemstone_image')}}/{{@$cart->productdefault->image}}" alt="Product image">
                                            </a>
										@else
											<a href="{{route('product.search.details',['slug'=>$cart->product->slug])}}">
                                                <img src="{{ URL::to('storage/app/public/small_product_image')}}/{{@$cart->productdefault->image}}" alt="Product image">
                                            </a>
										@endif
                                            
                                        </figure>
                                        <div class="cart-details">
                                            <h3 class="product-title">
											@if($cart->cart_type=='GS')
                                                <a href="{{route('gemstone.details',['slug'=>$cart->product->slug])}}">@if(@$cart->product['title']) {{@$cart->product['title']->title}}@if(@$cart->product['subtitle']) /{{@$cart->product['subtitle']->title}} @endif/{{@$cart->product->product_code}} @else {{@$cart->product->product_name}}/{{@$cart->product->product_code}} @endif</a>
											@else
												<a href="{{route('product.search.details',['slug'=>$cart->product->slug])}}">{{@$cart->product->product_name}}/{{@$cart->product->product_code}}</a>
											@endif
                                            </h3>
											@if($cart->cart_type=='GS')
												<p>@if(@$cart->jewellery_type=='OS') Only Stone @elseif(@$cart->jewellery_type=='R') With Ring @elseif(@$cart->jewellery_type=='P') With Pendant @elseif(@$cart->jewellery_type=='B') With Bracelet @endif</p>
											<p><a href="javascript:void(0);" class="more_info" data-id="{{$cart->id}}">More Info</a></p>
											@endif
                                            @if(@$cart->product->color)
                                            <p>Color : <span>{{$cart->product->color}}</span> </p>
                                            @endif
                                            @if(@$cart->product->size)
                                            <p>Size : <span> {{$cart->product->size}} MM</span> </p>
                                            @endif
                                            @if(@session()->get('currency')==1 && $cart->gift_pack_price_inr>0)
                                            <p>Gift pack added : <span> {{session()->get('currencySym').$cart->gift_pack_price_inr}}</span> </p>
                                            @endif
                                            @if(@session()->get('currency')>=2 && $cart->gift_pack_price_usd>0)
                                            <p>Gift pack added : <span> {{session()->get('currencySym').($cart->gift_pack_price_usd*currencyConversionCustom())}}</span> </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Quantity:</span>
                                    <div class="product-quantity new-quantity">
                                        <div class="product-quantity">
                                            <div class="quantity-selectors">
                                                <button type="button" class="decrement-quantity" id="decrement-quantity{{$cart->id}}" aria-label="Subtract one"
                                                    data-direction="-1" data-id="{{$cart->id}}" data-product="{{$cart->product_id}}" @if(@$cart->quantity<=1) disabled="disabled" @endif data-type="{{$cart->cart_type}}"><span>&#8722;</span></button>

                                                <input data-min="1" data-max="0" type="text" id="quantity{{$cart->id}}" name="quantity" value="{{@$cart->quantity}}" readonly="true">

                                                <button type="button" class="increment-quantity" id="increment-quantity{{$cart->id}}" aria-label="Add one"
                                                    data-direction="1" data-id="{{$cart->id}}" data-product="{{$cart->product_id}}" @if(@$cart->quantity>=10) disabled="disabled" @endif data-type="{{$cart->cart_type}}"><span>&#43;</span></button>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(@session()->get('currency')==1)
                                <div class="cell amunt-detail cess" id="unit_price{{$cart->id}}"> <span class="hide_big">Unit Price: </span> {{session()->get('currencySym').@$cart->price_inr}}</div>
                                <div class="cell amunt-detail cess" id="total_price{{$cart->id}}"> <span class="hide_big">Total:</span>{{session()->get('currencySym').@$cart->total_price_inr}}</div>
                                @elseif(@session()->get('currency')>=2)
                                <div class="cell amunt-detail cess" id="unit_price{{$cart->id}}"> <span class="hide_big">Unit Price: </span> {{session()->get('currencySym').round(@$cart->price_usd*currencyConversionCustom(),2)}}</div>
                                <div class="cell amunt-detail cess" id="total_price{{$cart->id}}"> <span class="hide_big">Total:</span>{{session()->get('currencySym').round(@$cart->total_price_usd*currencyConversionCustom(),2)}}</div>
                                @endif
								<div class="cell amunt-detail cess"> <span class="hide_big">Tentative date of Delivery: </span>
                                  @if(@session()->get('currency')==1)
                                  @if(@$cart->product->delivery_days_india!="")
									  @if(@$cart->cirtificate)
										  <?php $days = @$cart->product->delivery_days_india+@$cart->cirtificate['certificate_name']->no_of_days+1  ?>
										  @else
											  <?php $days = @$cart->product->delivery_days_india+1  ?>
										@endif
                                  Before {{date('F j, Y', strtotime(date('Y-m-d'). ' + '.$days.' days'))}}
                                  @else
                                  --
                                  @endif
                                  @else
                                  @if(@$cart->product->delivery_days_outside_india!="")
									  @if(@$cart->cirtificate)
										  <?php $days = @$cart->product->delivery_days_outside_india+@$cart->cirtificate['certificate_name']->no_of_days+1  ?>
										  @else
											  <?php $days = @$cart->product->delivery_days_outside_india+1  ?>
										@endif
                                 Before {{date('F j, Y', strtotime(date('Y-m-d'). ' + '.$days.' days'))}}
                                  @else
                                  --
                                  @endif

                                  @endif  

                                 </div>
                                <div class="cell amunt-detail cess"> <span class="hide_big">Action:</span>
                                    <p class="table-actions float-right">
                                        <a href="{{route('product.add.to.cart.delete',['id'=>$cart->id])}}" onclick="return confirm('Do you want to delete this product from cart?')" class="del-btn"><img src="{{ URL::to('public/frontend/images/del.png')}}"></a>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            @else
                            No Item in shopping cart
                            @endif

                        </div>
                    </div>
                    <div class="cart-price-box">
                        <div class="pull-right wid-cart">
                            @if(@session()->get('currency')==1)
                            <h4>Subtotal<span class="pull-right"  id="sub_amount">{{session()->get('currencySym').$allCartData->sum('total_price_inr')}}</span></h4>
                            <h4>SHIPPING CHARGES<span class="pull-right ">{{session()->get('currencySym')}} 0</span></h4>
                            <div class="total-pay">
                                <h3 >Total payable amount<span class="pull-right " id="total_amount" >{{session()->get('currencySym').$allCartData->sum('total_price_inr')}}</span></h3>
                            </div>
                            @elseif(@session()->get('currency')>=2)
                            <h4>Subtotal<span class="pull-right " id="sub_amount"> {{session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)}}</span></h4>
                            <h4>SHIPPING CHARGES<span class="pull-right ">{{session()->get('currencySym')}} 0</span></h4>
                            <div class="total-pay">
                                <h3 >Total payable amount<span class="pull-right " id="total_amount">{{session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)}}</span></h3>
                            </div>
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="cart-btn-sec">
                        <button class="cartbtn shpping">Continue Shopping</button>
                        @if($allCartData->count()>0)
                        @if(Auth::user()==null)
                        <button class="cartbtn login_show">Secure Checkout</button>
                        @else
                        <button class="cartbtn checkout">Secure Checkout</button>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="moreInfoModal" tabindex="-1" role="dialog" aria-labelledby="moreInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="moreInfoModalLabel">More Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="gemstone_info"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection




@section('footer')
@include('includes.footer')
@endsection


@section('script')
@include('includes.script')
@include('includes.toaster')
<!---------deatils------->
 <script src="{{ URL::to('public/frontend/js/thumbelina.js')}}"></script>
 <script src="{{ URL::to('public/frontend/js/product-carousel.js')}}"></script>

<!---------input increament---------->
<script type="text/javascript">
@if(@session()->get('currency')==1)
var currencyId= '{{session()->get('currencySym')}}';
@elseif(@session()->get('currency')>=2)
var currencyId= '{{session()->get('currencySym')}}';
@endif
    $(".increment-quantity,.decrement-quantity").on("click", function(ev) {
        var id= $(this).data('id');
        var currentQty = $('#quantity'+id).val();
        // var currentQty = $('input[name="quantity"]').val();
        var qtyDirection = $(this).data("direction");
        var newQty = 0;
        if(qtyDirection == "1") {
            newQty = parseInt(currentQty) + 1;
        } else if(qtyDirection == "-1") {
            newQty = parseInt(currentQty) - 1;
        }
       // make decrement disabled at 1
       if(newQty == 1) {
          $("#decrement-quantity"+id).attr("disabled", "disabled");
       }
       if(newQty == 10) {
          $("#increment-quantity"+id).attr("disabled", "disabled");
       }
       // remove disabled attribute on subtract
       if(newQty > 1) {
          $("#decrement-quantity"+id).removeAttr("disabled");
       }
       if(newQty < 10) {
          $("#increment-quantity"+id).removeAttr("disabled");
       }
       if(newQty > 0) {
           newQty = newQty.toString();
           var productId = $(this).data('product');
           var cartId = $(this).data('id');
           var cartType = $(this).data('type');
           var quantity = newQty;
		   var reqData = {
               'jsonrpc': '2.0',
               '_token': '{{csrf_token()}}',
               'params': {
                   productId: productId,
                   quantity: quantity,
				   cart_id: cartId,
				   from_cart:1,
                }
            };
		   if(cartType=='GS')
		   {
			   $.ajax({
					url: '{{ route('gemstone.update.cart') }}',
					type: 'post',
					dataType: 'json',
					data: reqData,
				})
				.done(function(response){
					if (response.result.updated=="updated") {
						$('#unit_price'+id).html('<span class="hide_big">Unit Price: </span>'+response.result.unit_price);
						$('#total_price'+id).html('<span class="hide_big">Total:</span>'+response.result.total_price);
						$('#sub_amount').html(response.result.subtotal);
						$('#total_amount').html(response.result.total);
					}
					$('#quantity'+id).val(newQty);
					$('#cartLi .noti').text(response.result.cart.length);
					$('#cartLi .shopcutBx').html();
					$('#cartLi .shopcutBx').html(response.result.html);
				})
				.fail(function(error) {
				console.log("error", error);
			})
			.always(function() {
				console.log("complete");
			})
		   }
		   else
		   {
			   $.ajax({
					url: '{{ route('product.add.to.cart') }}',
					type: 'post',
					dataType: 'json',
					data: reqData,
				})
				.done(function(response) {
					
					if (response.result.updated=="updated") {
						$('#unit_price'+id).html('<span class="hide_big">Unit Price: </span>'+response.result.unit_price);
						$('#total_price'+id).html('<span class="hide_big">Total:</span>'+response.result.total_price);
						$('#sub_amount').html(response.result.subtotal);
						$('#total_amount').html(response.result.total);


						// alert('Product quantity updated successfully');
					}

					$('#quantity'+id).val(newQty);
					$('#cartLi .noti').text(response.result.cart.length);
					$('#cartLi .shopcutBx').html();
					$('#cartLi .shopcutBx').html(response.result.html);
				})
				.fail(function(error) {
				console.log("error", error);
			})
			.always(function() {
				console.log("complete");
			})
		   }
           
            

       } else {
        $('#quantity'+id).val("1");
       }
    });
    </script>

  <script>
   $(".shopcut").click(function(){
       $(".shopcutBx").slideToggle();
   });

</script>
<script>
$(document).on('click', function () {
 var $target = $(event.target);
 if(!$target.closest('.shopcutBx').length && !$target.closest('.shopcut').length && $('.shopcutBx').is(":visible")) {
     $('.shopcutBx').slideUp();
    }
})
$('.shpping').click(function(){
    window.location.href="{{route('product.search')}}";
})
$('.checkout').click(function(){
    window.location.href="{{route('product.shopping.check.out')}}";
})
</script>
<script>
$(document).ready(function(){
	$('.more_info').click(function(){
		var cart_id =$(this).data('id');
		$.ajax({
  			url: '{{ route('gemstone.more.info') }}',
  			type: 'get',
  			dataType: 'json',
  			data: {'cart_id':cart_id},
  		})
		.done(function(response) {
			$('#gemstone_info').html(response.html);
			$('#moreInfoModal').modal('show');            
		})
		.fail(function(error) {
			console.log("error", error);
		})
		.always(function() {
			console.log("complete");
		})
	});
})
</script>



@endsection
