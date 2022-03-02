<?php

namespace App\Http\Controllers\Modules\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Session;
use Auth;
use App\Models\Products;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Area;
use App\Models\ZipMaster;
use App\Models\OrderMaster;
use App\Models\OrderDetails;
use App\Models\CustomerAddressBook;
use Mail;
use App\Mail\ProductOrderEmail;
use App\Mail\ProductOrderShippingEmail;
use App\Models\GemstoneCategory;
use App\Models\Metal;
use App\Models\ProductGemstonePrice;
use App\Models\Cirtificate;
use App\Models\PujaEnergization;
use App\Models\GoldPurity;
use App\Models\RingPendent;
use App\Models\RingSystem;
use App\Models\RingSize;
use App\Models\BraceletDesign;
use App\Models\CurrencyConversion;
use App\Models\RingPendentDesign;
use App\Models\BraceletSize;
use File;
use DB;
class CartController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')->except('addToCart','ajaxdeleteCart','deletecart','viewCart','gemstoneAddToCart','gemstoneMoreInfo','gemstoneCartUpdate');
        $this->middleware('customer.access');

    }
    /**
     *   Method      : addToCart
     *   Description : Add Product in to cart
     *   Author      : Soumojit
     *   Date        : 2021-JUN-20
     **/
    public function addToCart(Request $request){
        $response = [
            'jsonrpc' => '2.0'
        ];
        $productDetails = Products::where('id',$request->params['productId'])->first();
        if($productDetails ){
            if(@auth()->user()->id){
                $isAvailable = Cart::where('product_id',$productDetails->id)->where('user_id',auth()->user()->id)->first();
                if($isAvailable){
                    $upd=[];
					if(@$request->params['from_cart']==1)
					{
						$upd['quantity']=$request->params['quantity'];
					}
                    else
					{
						$upd['quantity']=$isAvailable->quantity+$request->params['quantity'];
					}
                    $upd['price_inr']=$productDetails->price_inr;
                    $upd['price_usd']=$productDetails->price_usd;
                    $upd['gift_pack_price_inr']=@$request->params['gift_pack']?$productDetails->gift_pack_price_inr:0;
                    $upd['gift_pack_price_usd']=@$request->params['gift_pack']?$productDetails->gift_pack_price_usd:0;
                    $upd['total_price_inr']=($productDetails->price_inr*$upd['quantity'])+$upd['gift_pack_price_inr'];
                    $upd['total_price_usd']=($productDetails->price_usd*$upd['quantity'])+$upd['gift_pack_price_usd'];
                    if($isAvailable->gift_pack_price_inr>0 && @$request->params['gift_pack']==null){
                        $upd['gift_pack_price_inr']=$productDetails->gift_pack_price_inr;
                    }
                    if($isAvailable->gift_pack_price_usd>0 && @$request->params['gift_pack']==null){
                        $upd['gift_pack_price_usd']=$productDetails->gift_pack_price_usd;
                    }
                    if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
                        $upd['price_inr']=round($productDetails->price_inr - (($productDetails->price_inr/100))* @$productDetails->discount_inr,2);
                        $upd['total_price_inr']=($upd['price_inr']*$upd['quantity'])+$upd['gift_pack_price_inr'];
                    }
                    if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
                        $upd['price_usd']=round($productDetails->price_usd - (($productDetails->price_usd/100))* @$productDetails->discount_usd,2);
                        $upd['total_price_usd']=($upd['price_usd']*$upd['quantity'])+$upd['gift_pack_price_usd'];
                    }
                    Cart::where('id',$isAvailable->id)->update($upd);
                    $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('user_id',auth()->user()->id)->get();
                    $updateData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('id',$isAvailable->id)->where('user_id',auth()->user()->id)->first();
                    $html ='';
                    if(session()->get('currency')==1){
                        foreach (@$allCartData as $cart){
							if($cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'] && @$cart->product['subtitle'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}

                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".session()->get('currencySym').$allCartData->sum('total_price_inr')."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                        </ul>
                        </div>";
                    } else{
                        foreach (@$allCartData as $cart){
							if($cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'] && @$cart->product['subtitle'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                        </ul>
                        </div>";
                    }
                    $response['result']['cart']=$allCartData;
                    $response['result']['html']=$html;
                    $response['result']['updateData']=$updateData;
                    $response['result']['sum']=session()->get('currency')==1?$allCartData->sum('total_price_inr'):$allCartData->sum('total_price_usd');
					if(session()->get('currency')>=2)
					{
						$response['result']['unit_price']=session()->get('currencySym').round($updateData->price_usd*currencyConversionCustom(),2);
						$response['result']['total_price']=session()->get('currencySym').round($updateData->total_price_usd*currencyConversionCustom(),2);
						$response['result']['subtotal']=@session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2);
						$response['result']['total']=@session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2);
					}
					else
					{
						$response['result']['unit_price']=session()->get('currencySym').$updateData->price_inr;
						$response['result']['total_price']=session()->get('currencySym').$updateData->total_price_inr;
						$response['result']['subtotal']=@session()->get('currencySym').$allCartData->sum('total_price_inr');
						$response['result']['total']=@session()->get('currencySym').$allCartData->sum('total_price_inr');
					}
                    $response['result']['updated']='updated';
                    return response()->json($response);
                }
                $ins=[];
                $ins['user_id']=auth()->user()->id;
                $ins['product_id']=$productDetails->id;
                $ins['quantity']=$request->params['quantity'];
                $ins['price_inr']=$productDetails->price_inr;
                $ins['price_usd']=$productDetails->price_usd;
                $ins['gift_pack_price_inr']=@$request->params['gift_pack']?$productDetails->gift_pack_price_inr:0;
                $ins['gift_pack_price_usd']=@$request->params['gift_pack']?$productDetails->gift_pack_price_usd:0;
                $ins['total_price_inr']=($productDetails->price_inr*$request->params['quantity'])+$ins['gift_pack_price_inr'];
                $ins['total_price_usd']=($productDetails->price_usd*$request->params['quantity'])+$ins['gift_pack_price_usd'];
                if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
                    $ins['price_inr']=round($productDetails->price_inr - (($productDetails->price_inr/100))* @$productDetails->discount_inr,2);
                    $ins['total_price_inr']=($ins['price_inr']*$request->params['quantity'])+$ins['gift_pack_price_inr'];
                }
                if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
                    $ins['price_usd']=round($productDetails->price_usd - (($productDetails->price_usd/100))* @$productDetails->discount_usd,2);
                    $ins['total_price_usd']=($ins['price_usd']*$request->params['quantity'])+$ins['gift_pack_price_usd'];
                }
                Cart::create($ins);
                $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('user_id',auth()->user()->id)->get();
                $html ='';
                if(session()->get('currency')==1){
                    foreach (@$allCartData as $cart){
						if($cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'] && @$cart->product['subtitle'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    // <li><a href='{{route('product.shopping.cart')}}' class='sign_btn'>View Cart</a></li>
                    //     @if(@Auth::user())
                    //     <li><a href='{{route('product.shopping.check.out')}}' class='sign_btn'>Checkout</a></li>
                    //     @endif
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".session()->get('currencySym').$allCartData->sum('total_price_inr')."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                    </ul>
                    </div>";
                }else{
                    foreach (@$allCartData as $cart){
						if($cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'] && @$cart->product['subtitle'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                    </ul>
                    </div>";
                }

                $response['result']['cart']=$allCartData;
                $response['result']['html']=$html;
                $response['result']['insert']='insert';
                return response()->json($response);


            }
			else{
                $cart_id = Session::get('cart_session_id');
                $isAvailable = Cart::where('product_id',$productDetails->id)->where('cart_session_id',$cart_id)->first();
                if($isAvailable){
                    $upd=[];
                    if(@$request->params['from_cart']==1)
					{
						$upd['quantity']=$request->params['quantity'];
					}
                    else
					{
						$upd['quantity']=$isAvailable->quantity+$request->params['quantity'];
					}
                    $upd['price_inr']=$productDetails->price_inr;
                    $upd['price_usd']=$productDetails->price_usd;
                    $upd['gift_pack_price_inr']=@$request->params['gift_pack']?$productDetails->gift_pack_price_inr:0;
                    $upd['gift_pack_price_usd']=@$request->params['gift_pack']?$productDetails->gift_pack_price_usd:0;
                    if($isAvailable->gift_pack_price_inr>0 && @$request->params['gift_pack']==null){
                        $upd['gift_pack_price_inr']=$productDetails->gift_pack_price_inr;
                    }
                    if($isAvailable->gift_pack_price_usd>0 && @$request->params['gift_pack']==null){
                        $upd['gift_pack_price_usd']=$productDetails->gift_pack_price_usd;
                    }
                    $upd['total_price_inr']=($productDetails->price_inr*$upd['quantity'])+$upd['gift_pack_price_inr'] ;
                    $upd['total_price_usd']=($productDetails->price_usd*$upd['quantity'])+$upd['gift_pack_price_usd'];
                    if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
                        $upd['price_inr']=round($productDetails->price_inr - (($productDetails->price_inr/100))* @$productDetails->discount_inr,2);
                        $upd['total_price_inr']=($upd['price_inr']*$upd['quantity'])+$upd['gift_pack_price_inr'];
                    }
                    if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
                        $upd['price_usd']=round($productDetails->price_usd - (($productDetails->price_usd/100))* @$productDetails->discount_usd,2);
                        $upd['total_price_usd']=($upd['price_usd']*$upd['quantity'])+$upd['gift_pack_price_usd'];
                    }
                    Cart::where('id',$isAvailable->id)->update($upd);
                    $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('cart_session_id',$cart_id)->get();
                    $updateData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('id',$isAvailable->id)->where('cart_session_id',$cart_id)->first();
                    $html ='';
                    if(session()->get('currency')==1){
                        foreach (@$allCartData as $cart){
							if($cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'] && @$cart->product['subtitle'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}

                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".session()->get('currencySym').$allCartData->sum('total_price_inr')."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        </ul>
                        </div>";
                    }else{
                        foreach (@$allCartData as $cart){
							if($cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'] && @$cart->product['subtitle'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}

                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        </ul>
                        </div>";
                    }
                    $response['result']['cart']=$allCartData;
                    $response['result']['updateData']=$updateData;
                    $response['result']['sum']= session()->get('currency')==1?$allCartData->sum('total_price_inr'):$allCartData->sum('total_price_usd');
                    $response['result']['html']=$html;
					if(session()->get('currency')>=2)
					{
						$response['result']['unit_price']=session()->get('currencySym').round($updateData->price_usd*currencyConversionCustom(),2);
						$response['result']['total_price']=session()->get('currencySym').round($updateData->total_price_usd*currencyConversionCustom(),2);
						$response['result']['subtotal']=@session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2);
						$response['result']['total']=@session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2);
					}
					else
					{
						$response['result']['unit_price']=session()->get('currencySym').$updateData->price_inr;
						$response['result']['total_price']=session()->get('currencySym').$updateData->total_price_inr;
						$response['result']['subtotal']=@session()->get('currencySym').$allCartData->sum('total_price_inr');
						$response['result']['total']=@session()->get('currencySym').$allCartData->sum('total_price_inr');
					}
                    $response['result']['updated']='updated';
                    return response()->json($response);
                }
                $ins=[];
                $ins['cart_session_id']=$cart_id;
                $ins['product_id']=$productDetails->id;
                $ins['quantity']=$request->params['quantity'];
                $ins['price_inr']=$productDetails->price_inr;
                $ins['price_usd']=$productDetails->price_usd;
                $ins['gift_pack_price_inr']=@$request->params['gift_pack']?$productDetails->gift_pack_price_inr:0;
                $ins['gift_pack_price_usd']=@$request->params['gift_pack']?$productDetails->gift_pack_price_usd:0;
                $ins['total_price_inr']=($productDetails->price_inr*$request->params['quantity'])+$ins['gift_pack_price_inr'];
                $ins['total_price_usd']=($productDetails->price_usd*$request->params['quantity'])+$ins['gift_pack_price_usd'];
                if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
                    $ins['price_inr']=round($productDetails->price_inr - (($productDetails->price_inr/100))* @$productDetails->discount_inr,2);
                    $ins['total_price_inr']=($ins['price_inr']*$request->params['quantity'])+$ins['gift_pack_price_inr'];
                }
                if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
                    $ins['price_usd']=round($productDetails->price_usd - (($productDetails->price_usd/100))* @$productDetails->discount_usd,2);
                    $ins['total_price_usd']=($ins['price_usd']*$request->params['quantity'])+$ins['gift_pack_price_usd'];
                }
                Cart::create($ins);
                $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('cart_session_id',$cart_id)->get();

                $html ='';
                if(session()->get('currency')==1){
                    foreach (@$allCartData as $cart){
						if($cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'] && @$cart->product['subtitle'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".session()->get('currencySym').$allCartData->sum('total_price_inr')."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    </ul>
                    </div>";
                }else{
                    foreach (@$allCartData as $cart){
						if($cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'] && @$cart->product['subtitle'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".session()->get('currencySym').round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2)."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    </ul>
                    </div>";
                }

                $response['result']['cart']=$allCartData;
                $response['result']['html']=$html;
                $response['result']['insert']='insert';
                return response()->json($response);
            }

        }
        $response['result']['error']='Something went wrong';
        return response()->json($response);

    }
    /**
     *   Method      : ajaxdeleteCart
     *   Description : delete Product in to cart
     *   Author      : Sayan
     *   Date        : 2021-JULY-09
     **/
    public function ajaxdeleteCart(Request $request)
    {
       $response = [
            'jsonrpc' => '2.0'
        ];
       $delete = Cart::where('id',$request->params['productId'])->delete();
       if ($delete) {
           $response['result']['success']='success';
           return response()->json($response);
       }else{
           $response['result']['failed']='failed';
           return response()->json($response);
       }

    }
    /**
     *   Method      : deletecart
     *   Description : delete Product in to cart
     *   Author      : Sayan
     *   Date        : 2021-JULY-09
     **/
    public function deletecart($id)
    {
         $delete = Cart::where('id',$id)->delete();
         return redirect()->back();
    }

    /**
     *   Method      : viewCart
     *   Description : view Cart data
     *   Author      : Soumojit
     *   Date        : 2021-AUG-16
     **/
    public function viewCart(){
        if(@auth()->user()->id){
            $data['allCartData']= Cart::with(['product','productDefault','product.title','product.subtitle','cirtificate.certificate_name'])->where('user_id',auth()->user()->id)->get();
        }else{
            $cart_id = Session::get('cart_session_id');
            $data['allCartData']= Cart::with(['product','productDefault','product.title','product.subtitle','cirtificate.certificate_name'])->where('cart_session_id',$cart_id)->get();
        }
        return view('modules.cart.view_cart')->with($data);
    }
    /**
     *   Method      : viewCheckout
     *   Description : Checkout order
     *   Author      : Soumojit
     *   Date        : 2021-AUG-16
     **/
    public function viewCheckout(Request $request){
        // return $request;
        $data['AllCountry']=Country::get();
        if(@auth()->user()->id){
            $data['allCartData']= Cart::with(['product','productDefault','product.title','product.subtitle','cirtificate.certificate_name'])->where('user_id',auth()->user()->id)->get();
        }else{
            $cart_id = Session::get('cart_session_id');
            $data['allCartData']= Cart::with(['product','productDefault','product.title','product.subtitle','cirtificate.certificate_name'])->where('cart_session_id',$cart_id)->get();
        }
        $data['lastOrder']= OrderMaster::where('order_type','PO')->where('customer_id',auth()->user()->id)->orderby('id','DESC')->first();
        if($data['lastOrder']!=null){
            $postcode_shipping = ZipMaster::where([
                'country_id' => $request->shipping_country,
                'state_id' => $request->shipping_state,
                'city_id' => $request->shipping_city,
                'zipcode'=>$request->shipping_pin_code,
            ])->first();

            $postcode_billing = ZipMaster::where([
                'country_id' => $request->billing_country,
                'state_id' => $request->billing_state,
                'city_id' => $request->billing_city,
                'zipcode'=>$request->billing_pin_code,
            ])->first();

            $data['state']=State::where('country_id',$data['lastOrder']->shipping_country)->get();
            $data['bstate']=State::where('country_id',$data['lastOrder']->billing_country)->get();
            $data['city']=City::where('state_id',$data['lastOrder']->shipping_state)->get();
            $data['bcity']=City::where('state_id',$data['lastOrder']->billing_state)->get();
            $data['areas']=Area::where([
                                    'country_id' => $request->shipping_country,
                                    'state_id' => $request->shipping_state,
                                    'city_id' => $request->shipping_city,
                                    'postcode_id'=>@$postcode_shipping->id,
                                ])
                                ->get();
            $data['areas1']=Area::where([
                                'country_id' => $request->billing_country,
                                'state_id' => $request->billing_state,
                                'city_id' => $request->billing_city,
                                'postcode_id'=>@$postcode_billing->id,
                            ])
                            ->get();
        }
        $data['is_cod_available']='Y';
        foreach($data['allCartData'] as $item){
            if($item->product->is_cod_available=='N'){
                $data['is_cod_available']='N';
            }
        }
        $data['addressBook']=CustomerAddressBook::where('user_id',auth()->user()->id)->with('countryDetails','stateDetails','cityDetails','areaDetails')->get();
        //dd($data['addressBook']);
        return view('modules.cart.view_checkout')->with($data);
    }
    /**
     *   Method      : placedOrder
     *   Description : review order
     *   Author      : Soumojit
     *   Date        : 2021-AUG-17
     **/
    public function placedOrder(Request $request)
    {
        $data['AllCountry']=Country::get();

        if($request->all()==null){
            return redirect()->route('product.shopping.check.out');
        }
        if(@auth()->user()->id){
            $data['allCartData']= Cart::with(['product','productDefault','product.title','product.subtitle','cirtificate.certificate_name'])->where('user_id',auth()->user()->id)->get();
        }else{
            $cart_id = Session::get('cart_session_id');
            $data['allCartData']= Cart::with(['product','productDefault','product.title','product.subtitle','cirtificate.certificate_name'])->where('cart_session_id',$cart_id)->get();
        }
        $data['state']=State::where('country_id',$request->country)->get();
        $data['city'] = City::where('state_id',@$request->state)->get();
        $post_id = ZipMaster::where([
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'zipcode'=>$request->zip_code,
        ])->first();
        //dd($post_id);
        $data['areas'] = Area::where([
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'postcode_id'=>@$post_id->id,
        ])
        ->get();
        if(@$request->same_billing){
            $data['bstate']=State::where('country_id',$request->country)->get();
            $data['bcity'] = City::where('state_id',$request->state)->get();
        }else{
            $data['bstate']=State::where('country_id',$request->bcountry)->get();
            $data['bcity'] = City::where('state_id',$request->bstate)->get();
            $data['bareas'] = Area::where([
                'country_id' => $request->country,
                'state_id' => $request->state,
                'city_id' => $request->city,
                'postcode_id'=>@$post_id->id,
            ])
            ->get();
        }

        $data['request']= $request->all();
        if(@$request->address_book){
            $address = CustomerAddressBook::where('user_id',auth()->user()->id)
                                        ->with('countryDetails','stateDetails','cityDetails','areaDetails')
                                        ->where('id',$request->address_book)
                                        ->first();
            if($address){
                $data['request']['fname']=$address->fname;
                $data['request']['lname']=$address->lname;
                $data['request']['phone']=$address->phone;
                $data['request']['email']=$address->email;
                $data['request']['city']=$address->city;
                $data['request']['country']=$address->country;
                $data['request']['state']=$address->state;
                $data['request']['landmark']=$address->landmark;
                $data['request']['st_address']=$address->street;
                $data['request']['zip_code']=$address->zip_code;
            }
            $data['state']=State::where('country_id',$address->country)->get();
            if(@$request->same_billing){
                $data['bstate']=State::where('country_id',$address->country)->get();
            }

        }
        //dd($data);
         //return $data['request'];
        return view('modules.cart.place_order')->with($data);
    }
    /**
     *   Method      : placedOrderSuccess
     *   Description : order successfully plashed
     *   Author      : Soumojit
     *   Date        : 2021-AUG-17
     **/
    public function placedOrderSuccess(Request $request)
    {
        //dd($request->all());
        $allCartData= Cart::with(['product','productDefault','cirtificate.certificate_name'])->where('user_id',auth()->user()->id)->get();
        if($allCartData->count()==0){
            return redirect()->route('product.shopping.cart');
        }
        $ins['customer_id']=auth()->user()->id;
        if(session()->get('currency')==1){
            $ins['total_rate']=$allCartData->sum('total_price_inr');
            $ins['shipping_charge']=0;
            $ins['subtotal']=$allCartData->sum('total_price_inr');
            $ins['currency_id']=session()->get('currency');
        }
        if(session()->get('currency')>=2){
            $ins['total_rate']=round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2);
            $ins['shipping_charge']=0;
            $ins['subtotal']=round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2);
            $ins['currency_id']=session()->get('currency');
        }
        $ins['date']=date('Y-m-d H:i:s');
        $ins['order_type']='PO';
        $ins['payment_status']='P';
        $ins['payment_type']=@$request->payment;
        $ins['status']='N';
        $ins['shipping_fname']=@$request->fname;
        $ins['shipping_lname']=@$request->lname;
        $ins['shipping_phone']=@$request->phone;
        $ins['shipping_email']=@$request->email;
        $ins['shipping_country']=@$request->country;
        $ins['shipping_state']=@$request->state;
        $ins['shipping_landmark']=@$request->landmark;
        $ins['shipping_pin_code']=@$request->zip_code;
        $ins['shipping_city']=@$request->city;
        $ins['shipping_address']=@$request->address;
        $ins['shipping_street']=@$request->st_address;
        $post_id = ZipMaster::where([
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'zipcode'=>$request->zip_code,
        ])->first();
        $insArea['country_id'] = $request->country;
        $insArea['state_id'] = $request->state;
        $insArea['city_id'] = $request->city;
        $insArea['postcode_id'] = @$post_id->id;
        $insArea['area'] = $request->area;
        if($request->area_drop){
            if($request->area_drop == 'O'){
                $area = trim(strtolower($request->area));
                $check = Area::where('state_id',$request->state)
                     ->where('city_id',$request->city)
                     ->where('postcode_id',@$post_id->id)
                     ->where(DB::raw('trim(lower(area))'),$area)
                     ->first();
                if($check){
                    $ins['shipping_area'] = @$check->id;
                }else{
                    $area_ins = Area::create($insArea);
                    $ins['shipping_area'] = @$area_ins->id;
                }
            }else{
                $ins['shipping_area'] = @$request->area_drop;
            }
        }
        $post_id1 = ZipMaster::where([
            'country_id' => $request->bcountry,
            'state_id' => $request->bstate,
            'city_id' => $request->bcity,
            'zipcode'=>$request->bzip_code,
        ])->first();
        $insArea1['country_id'] = $request->bcountry;
        $insArea1['state_id'] = $request->bstate;
        $insArea1['city_id'] = $request->bcity;
        $insArea1['postcode_id'] = @$post_id1->id;
        $insArea1['area'] = $request->area1;
        if($request->area_drop1){
            if($request->area_drop1 == 'O'){
                $area1 = trim(strtolower($request->area1));
                $check1 = Area::where('state_id',$request->bstate)
                     ->where('city_id',$request->bcity)
                     ->where('postcode_id',@$post_id1->id)
                     ->where(DB::raw('trim(lower(area))'),$area1)
                     ->first();
                if($check){
                    $ins['billing_area'] = @$check1->id;
                }else{
                    $area_ins1 = Area::create($insArea1);
                    $ins['billing_area'] = @$area_ins1->id;
                }
            }else{
                $ins['billing_area'] = @$request->area_drop1;
            }
        }
        $ins['billing_fname']=@$request->bfname;
        $ins['billing_lname']=@$request->blname;
        $ins['billing_phone']=@$request->bphone;
        $ins['billing_email']=$request->bemail;
        $ins['billing_country']=@$request->bcountry;
        $ins['billing_state']=@$request->bstate;
        $ins['billing_landmark']=@$request->blandmark;
        $ins['billing_pin_code']=@$request->bzip_code;
        $ins['billing_city']=@$request->bcity;
        $ins['billing_address']=@$request->baddress;
        $ins['billing_street']=@$request->bst_address;
        //dd($ins);
        $createBooking= OrderMaster::create($ins);
		$code='';
		$idlength=strlen($createBooking->id);
		if($idlength>4)
		{
			$code=$createBooking->id;
		}
		else
		{
			for($i=0;$i<(4-$idlength);$i++)
			{
				$code.='0';
			}
			$code=$code.$createBooking->id;
		}
        $upd=[];
		$upd['order_id']='I'.date('y').date('m').date('d').$code;
        OrderMaster::where('id', $createBooking->id)->update($upd);
        $insCart=[];
        foreach($allCartData as $cart){
			$productDetails=Products::where('id',$cart->product_id)->first();
            $insCart['order_master_id']=$createBooking->id;
            $insCart['product_id']=$cart->product_id;
            $insCart['quantity']=$cart->quantity;
            $insCart['product_type']='AP';

            if(session()->get('currency')==1){
                if (@$productDetails->delivery_days_india!="") {
                    $Date = date('Y-m-d');
					if(@$cart->cirtificate['certificate_name'])
					{
						$days = @$productDetails->delivery_days_india+@$cart->cirtificate['certificate_name']->no_of_days+1;
					}
                    else
					{
						$days = @$productDetails->delivery_days_india+1;
					}
                    $insCart['delivery_date'] = date('Y-m-d', strtotime($Date. ' + '.$days.' days'));
                }else{
                    $insCart['delivery_date'] = null;
                }
            }else{
                if (@$productDetails->delivery_days_outside_india!="") {
                    $Date = date('Y-m-d');
					if(@$cart->cirtificate['certificate_name'])
					{
						$days = @$productDetails->delivery_days_outside_india+@$cart->cirtificate['certificate_name']->no_of_days+1;
					}
                    else
					{
						$days = @$productDetails->delivery_days_outside_india+1;
					}
                    $insCart['delivery_date'] = date('Y-m-d', strtotime($Date. ' + '.$days.' days'));
                }else{
                    $insCart['delivery_date'] = null;
                }

            }
			if($cart->cart_type=='GS')
			{
				$insCart['product_type']='GS';
				if(session()->get('currency')==1)
				{
					$insCart['gemstone_weight_price']=$cart->gemstone_weight_price_inr;
					$insCart['gold_purity_price']=$cart->gold_purity_price_inr;
					$insCart['ring_price']=$cart->ring_price_inr;
					$insCart['pendant_price']=$cart->pendant_price_inr;
					$insCart['pendant_chain_price']=$cart->pendant_chain_price_inr;
					$insCart['bracelet_price']=$cart->bracelet_price_inr;
					$insCart['bracelet_design_price']=$cart->bracelet_design_price_inr;
					$insCart['certification_price']=$cart->certification_price_inr;
					$insCart['puja_energization_price']=$cart->puja_energization_price_inr;
				}
				else
				{
					$insCart['gemstone_weight_price']=round($cart->gemstone_weight_price_usd*currencyConversionCustom(),2);
					$insCart['gold_purity_price']=round($cart->gold_purity_price_usd*currencyConversionCustom(),2);
					$insCart['ring_price']=round($cart->ring_price_usd*currencyConversionCustom(),2);
					$insCart['pendant_price']=round($cart->pendant_price_usd*currencyConversionCustom(),2);
					$insCart['pendant_chain_price']=round($cart->pendant_chain_price_usd*currencyConversionCustom(),2);
					$insCart['bracelet_price']=round($cart->bracelet_price_usd*currencyConversionCustom(),2);
					$insCart['bracelet_design_price']=round($cart->bracelet_design_price_usd*currencyConversionCustom(),2);
					$insCart['certification_price']=round($cart->certification_price_usd*currencyConversionCustom(),2);
					$insCart['puja_energization_price']=round($cart->puja_energization_price_usd*currencyConversionCustom(),2);
				}
				if(@$cart->bracelet_design_id)
				{
					$design_details=BraceletDesign::where('id',@$cart->bracelet_design_id)->first();
					$insCart['bracelet_design_name']=@$design_details->design_name;
					$bracelet_design_file_name=time().$design_details->design_picture;
					File::copy('storage/app/public/bracelet_design/'.$design_details->design_picture, 'storage/app/public/order_bracelet_design/'.$bracelet_design_file_name);
					$insCart['bracelet_design_image']=$bracelet_design_file_name;
				}
				if(@$cart->ring_pendant_design_id)
				{
					$design_details=RingPendentDesign::where('id',@$cart->ring_pendant_design_id)->first();
					$insCart['ring_pendant_design_name']=@$design_details->design_name;
					$bracelet_design_file_name=time().$design_details->design_image;
					File::copy('storage/app/public/ring_pendent_design/'.$design_details->design_image, 'storage/app/public/order_ring_pendant_design/'.$bracelet_design_file_name);
					$insCart['ring_pendant_design_image']=$bracelet_design_file_name;
				}
				if(@$cart->certificate_id)
				{
					$certificate_details=Cirtificate::with('certificate_name')->where('id',@$cart->certificate_id)->first();
					$insCart['certificate_name']=@$certificate_details->certificate_name->cert_name;
				}
				if(@$cart->puja_energization_id)
				{
					$puja_details=PujaEnergization::with('puja_name')->where('id',@$cart->puja_energization_id)->first();
					$insCart['puja_energization_name']=@$puja_details->puja_name->puja;
				}
				$insCart['gemstone_weight']=$cart->gemstone_weight;
				$insCart['jewellery_type']=$cart->jewellery_type;
				$insCart['metal_type']=$cart->metal_type;
				$insCart['gold_purity']=$cart->gold_purity;
				$insCart['ring_weight']=$cart->ring_weight;
				$insCart['ring_size_system']=$cart->ring_size_system;
				$insCart['ring_size']=$cart->ring_size;
				$insCart['pendant_weight']=$cart->pendant_weight;
				$insCart['pendant_type']=$cart->pendant_type;
				$insCart['bracelet_weight']=$cart->bracelet_weight;
				$insCart['bracelet_size']=$cart->bracelet_size;
			}
            if(session()->get('currency')==1){
                $insCart['price']=$cart->price_inr;
                $insCart['discount_price']=($cart->gemstone_weight_price_inr-(($cart->gemstone_weight_price_inr*$productDetails->discount_inr)/100));
                $insCart['gift_pack_price']=$cart->gift_pack_price_inr;
                $insCart['subtotal']=$cart->subtotal;
                $insCart['total_price']=$cart->total_price_inr;
            }
            if(session()->get('currency')>=2){
                $insCart['price']=round($cart->price_usd*currencyConversionCustom(),2);
                $insCart['discount_price']=round(($cart->gemstone_weight_price_inr-(($cart->gemstone_weight_price_inr*$productDetails->discount_inr)/100))*currencyConversionCustom(),2);
                $insCart['gift_pack_price']=round($cart->gift_pack_price_usd*currencyConversionCustom(),2);
                $insCart['subtotal']=round($cart->subtotal*currencyConversionCustom(),2);
                $insCart['total_price']=round($cart->total_price_usd*currencyConversionCustom(),2);
            }
            OrderDetails::create($insCart);
        }
        $checkAddress = CustomerAddressBook::where('user_id',auth()->user()->id)
        ->where('fname',@$request->fname)->where('lname',@$request->lname)->where('phone',@$request->phone)->where('email',@$request->email)
        ->where('country',@$request->country)->where('state',@$request->state)->where('city',@$request->city)->where('street',@$request->st_address)
        ->where('postcode',@$request->zip_code)->where('landmark',@$request->landmark)->where('address',@$request->address)->first();
        if(@$checkAddress==null && @$request->save_in_address_book){
            CustomerAddressBook::where('user_id',auth()->user()->id)->update(['is_default'=>'N']);
            $ins1=[];
            $ins1['user_id']=auth()->user()->id;
            $ins1['fname']=@$request->fname;
            $ins1['lname']=@$request->lname;
            $ins1['phone']=@$request->phone;
            $ins1['email']=@$request->email;
            $ins1['country']=@$request->country;
            $ins1['state']=@$request->state;
            $ins1['landmark']=@$request->landmark;
            $ins1['postcode']=@$request->zip_code;
            $ins1['city']=@$request->city;
            $ins1['street']=@$request->st_address;
            $ins1['address']=@$request->address;
            $post_id = ZipMaster::where([
                'country_id' => $request->country,
                'state_id' => $request->state,
                'city_id' => $request->city,
                'zipcode'=>$request->zip_code,
            ])->first();
            if($request->area_drop){
                if($request->area_drop == 'O'){
                    $area = trim(strtolower($request->area));
                    $check = Area::where('state_id',$request->state)
                         ->where('city_id',$request->city)
                         ->where('postcode_id',@$post_id->id)
                         ->where(DB::raw('trim(lower(area))'),$area)
                         ->first();
                    if($check){
                        $ins1['area'] = @$check->id;
                    }else{
                        $area_ins = Area::create($insArea);
                        $ins1['area'] = @$area_ins->id;
                    }
                }else{
                    $ins1['area'] = @$request->area_drop;
                }
            }
            $ins1['is_default']='Y';
            CustomerAddressBook::create($ins1);
        }elseif(@$checkAddress){
            CustomerAddressBook::where('user_id',auth()->user()->id)->update(['is_default'=>'N']);
            CustomerAddressBook::where('user_id',auth()->user()->id)->where('id',$checkAddress->id)->update(['is_default'=>'Y']);
        }
        $order = OrderMaster::where('id', $createBooking->id)->with(['orderDetails','country','state','billingCountry','billingState','currencyDetails'])->first();
		//dd($order);
        $data['data']=$order;
        Mail::send(new ProductOrderEmail($data));
		if($order->customer->email!=$order->shipping_email)
		{
			Mail::send(new ProductOrderShippingEmail($data));
		}
        Cart::where('user_id',auth()->user()->id)->delete();
        session()->flash('success', 'Order Success');
        return redirect()->route('customer.order');

    }
	/**
     *   Method      : gemstoneAddToCart
     *   Description : Add Gemstone in to cart
     *   Author      : Madhuchandra
     *   Date        : 2021-SEPT-23
     **/
    public function gemstoneAddToCart(Request $request)
	{
		//dd(@$request->all());
		$currencySym=session()->get('currencySym');
		$currencyConvertionFactor=currencyConversionCustom();
        $productDetails = Products::where('id',$request->gem_id)->first();
		if(@$request->gemstone_weight)
		{
			$gem_weight=ProductGemstonePrice::where('id',$request->gemstone_weight)->first();
		}
		$gold_purity_price_inr=0;
		$gold_purity_price_usd=0;
		$ring_price_inr=0;
		$ring_price_usd=0;
		$pendant_price_inr=0;
		$pendant_price_usd=0;
		$pendant_chain_price_inr=0;
		$pendant_chain_price_usd=0;
		$bracelet_price_inr=0;
		$bracelet_price_usd=0;
		$bracelet_design_price_inr=0;
		$bracelet_design_price_usd=0;
		$certification_price_inr=0;
		$certification_price_usd=0;
		$puja_energization_price_inr=0;
		$puja_energization_price_usd=0;
		$metal=Metal::where('id',@$request->metal)->first();
		$where=array();
		$where['product_id']=$request->gem_id;
		//$where['gemstone_weight']=@$gem_weight->weight;
		$where['jewellery_type']=$request->jewellery;
		//$where['metal_type']=@$metal->metal_type;
		if(@$request->jewellery!='OS' && @$request->metal)
		{
			if(@$request->jewellery=='R')
			{
				$ring_size_system=RingSystem::where('id',@$request->ring_system)->first();
				$ring_size=RingSize::where('id',@$request->ring_size)->first();
				if(@$metal->metal_type=='G')
				{
					$gold_purity=GoldPurity::where('id',@$request->gold_purity)->first();
					//$where['gold_purity']=@$gold_purity->purity;
					$gold_purity_price_inr=$gold_purity->ring_price_inr;
					$gold_purity_price_usd=$gold_purity->ring_price_usd;
				}
				else
				{
					//$ring_pendant_price=RingPendent::where('metal_type',@$metal->metal_type)->where('type',@$request->jewellery)->first();
					$ring_pendant_price=RingPendent::where('id',@$request->ring_pendant_weight)->first();
					$ring_price_inr=$ring_pendant_price->price_inr;
					$ring_price_usd=$ring_pendant_price->price_usd;
				}
				//$where['ring_size_system']=@$ring_size_system->ring_size_system;
				//$where['ring_size']=@$ring_size->ring_size;
			}
			if(@$request->jewellery=='P')
			{
				if(@$metal->metal_type=='G')
				{
					$gold_purity=GoldPurity::where('id',@$request->gold_purity)->first();
					//$where['gold_purity']=@$gold_purity->purity;
					if(@$request->pendant_chain=='W')
					{
						$gold_purity_price_inr=$gold_purity->pendent_chain_price_inr;
						$gold_purity_price_usd=$gold_purity->pendent_chain_price_usd;
					}
					else
					{
						$gold_purity_price_inr=$gold_purity->pendent_price_inr;
						$gold_purity_price_usd=$gold_purity->pendent_price_usd;
					}

				}
				else
				{
					//$ring_pendant_price=RingPendent::where('metal_type',@$metal->metal_type)->where('type',@$request->jewellery)->first();
					$ring_pendant_price=RingPendent::where('id',@$request->ring_pendant_weight)->first();
					if(@$request->pendant_chain=='W')
					{
						$pendant_chain_price_inr=$ring_pendant_price->with_chain_price_inr;
						$pendant_chain_price_usd=$ring_pendant_price->with_chain_price_usd;
					}
					else
					{
						$pendant_price_inr=$ring_pendant_price->price_inr;
						$pendant_price_usd=$ring_pendant_price->price_usd;
					}
				}

				//$where['pendant_type']=@$request->pendant_chain;
			}
			if(@$request->jewellery=='B')
			{
				if(@$metal->metal_type=='G')
				{
					$gold_purity=GoldPurity::where('id',@$request->gold_purity)->first();
					//$where['gold_purity']=@$gold_purity->purity;
					$gold_purity_price_inr=$gold_purity->bracelet_price_inr;
					$gold_purity_price_usd=$gold_purity->bracelet_price_usd;
				}
				//$where['bracelet_design_id']=@$request->select_design;
				$bracelet_design_price=BraceletDesign::where('id',@$request->select_design)->first();
				$bracelet_design_price_inr=$bracelet_design_price->price_inr;
				$bracelet_design_price_usd=$bracelet_design_price->price_usd;
				$braceletsize=BraceletSize::where('id',@$request->bracelet_size)->first();
			}
		}
		//$where['certificate_id']=$request->certification;
		//$where['puja_energization_id']=$request->puja_energy;
		$certificate=Cirtificate::where('id',$request->certification)->first();
		$puja_energy=PujaEnergization::where('id',$request->puja_energy)->first();
		if(@$certificate)
		{
			$certification_price_inr=@$certificate->price_inr;
			$certification_price_usd=@$certificate->price_usd;
		}
		if(@$puja_energy)
		{
			$puja_energization_price_inr=@$puja_energy->price_inr;
			$puja_energization_price_usd=@$puja_energy->price_usd;
		}
        if($productDetails ){
            if(@auth()->user()->id){
				$where['user_id']=auth()->user()->id;
                $isAvailable = Cart::where($where)->first();
                if(@$isAvailable){
					$total_price_inr=0;
					$total_price_usd=0;
                    $upd=[];
                    $upd['quantity']=$isAvailable->quantity+$request->quantity;
					$upd['gemstone_weight']=@$gem_weight->weight;
					$upd['jewellery_type']=$request->jewellery;
					$upd['metal_type']=@$metal->metal_type;
					$upd['gold_purity']=@$gold_purity->purity;
					$upd['gold_purity_price_inr']=$gold_purity_price_inr;
					$upd['gold_purity_price_usd']=$gold_purity_price_usd;
					if(@$gold_purity->ring_weight_carat)
					{
						$upd['ring_weight']=@$gold_purity->ring_weight_carat;
					}
					else
					{
						$upd['ring_weight']=@$ring_pendant_price->weight;
					}
					$upd['ring_size_system']=@$ring_size_system->ring_size_system;
					$upd['ring_size']=@$ring_size->ring_size;
					$upd['ring_price_inr']=$ring_price_inr;
					$upd['ring_price_usd']=$ring_price_usd;
					if(@$gold_purity->pendent_weight_carat)
					{
						$upd['pendant_weight']=@$gold_purity->pendent_weight_carat;
					}
					else
					{
						$upd['pendant_weight']=@$ring_pendant_price->weight;
					}
					$upd['pendant_type']=$request->pendant_chain;
					$upd['pendant_price_inr']=$pendant_price_inr;
					$upd['pendant_price_usd']=$pendant_price_usd;
					$upd['pendant_chain_price_inr']=$pendant_chain_price_inr;
					$upd['pendant_chain_price_usd']=$pendant_chain_price_usd;
					$upd['bracelet_weight']=@$gold_purity->bracalet_weight_carat;
					if(@$request->jewellery=='B')
					{
						$ins['bracelet_design_id']=@$request->select_design;
					}
					$upd['bracelet_design_price_inr']=$bracelet_design_price_inr;
					$upd['bracelet_design_price_usd']=$bracelet_design_price_usd;
					$upd['bracelet_size']=@$braceletsize->size;
					if(@$request->jewellery=='R' || @$request->jewellery=='P')
					{
						$upd['ring_pendant_design_id']=@$request->select_design;
					}
					$upd['certificate_id']=$request->certification;
					$upd['certification_price_inr']=$certification_price_inr;
					$upd['certification_price_usd']=$certification_price_usd;
					$upd['puja_energization_id']=$request->puja_energy;
					$upd['puja_energization_price_inr']=$puja_energization_price_inr;
					$upd['puja_energization_price_usd']=$puja_energization_price_usd;
					if(@$gem_weight->price_type=='B')
					{
						$upd['price_inr']=$gem_weight->price_inr;
						$upd['price_usd']=$gem_weight->price_usd;
					}
					else
					{
						if(@$gem_weight->price_type=='A')
						{
							$upd['price_inr']=$productDetails->price_inr+$gem_weight->price_inr;
							$upd['price_usd']=$productDetails->price_usd+$gem_weight->price_usd;
						}
						else
						{
							$upd['price_inr']=$productDetails->price_inr-$gem_weight->price_inr;
							$upd['price_usd']=$productDetails->price_usd-$gem_weight->price_usd;
						}
					}
					$upd['gemstone_weight_price_inr']=$upd['price_inr'];
					$upd['gemstone_weight_price_usd']=$upd['price_usd'];
                    $upd['gift_pack_price_inr']=@$request->gift_pack?$productDetails->gift_pack_price_inr:0;
                    $upd['gift_pack_price_usd']=@$request->gift_pack?$productDetails->gift_pack_price_usd:0;
                    if($isAvailable->gift_pack_price_inr>0 && @$request->gift_pack==null){
                        $upd['gift_pack_price_inr']=$productDetails->gift_pack_price_inr;
                    }
                    if($isAvailable->gift_pack_price_usd>0 && @$request->gift_pack==null){
                        $upd['gift_pack_price_usd']=$productDetails->gift_pack_price_usd;
                    }
                    if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
                        $upd['price_inr']=round($upd['price_inr'] - (($upd['price_inr']/100))* @$productDetails->discount_inr);

                    }
                    if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
                        $upd['price_usd']=round($upd['price_usd'] - (($upd['price_usd']/100))* @$productDetails->discount_usd);

                    }
					$total_price_inr=$total_price_inr+$upd['price_inr']+$gold_purity_price_inr+$ring_price_inr+$pendant_price_inr+$pendant_chain_price_inr+$bracelet_design_price_inr+$certification_price_inr+$puja_energization_price_inr;
					$total_price_usd=$total_price_usd+$upd['price_usd']+$gold_purity_price_usd+$ring_price_usd+$pendant_price_usd+$pendant_chain_price_usd+$bracelet_design_price_usd+$certification_price_usd+$puja_energization_price_usd;
					$upd['total_price_inr']=($total_price_inr*$upd['quantity'])+$upd['gift_pack_price_inr'];
					$upd['total_price_usd']=($total_price_usd*$upd['quantity'])+$upd['gift_pack_price_usd'];
                    Cart::where('id',$isAvailable->id)->update($upd);
                    $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('user_id',auth()->user()->id)->get();
                    $updateData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('id',$isAvailable->id)->where('user_id',auth()->user()->id)->first();
                    $html ='';
                    if(session()->get('currency')==1){
                        foreach (@$allCartData as $cart){
							if(@$cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}

                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".$currencySym.$allCartData->sum('total_price_inr')."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                        </ul>
                        </div>";
                    } else{
                        foreach (@$allCartData as $cart){
							if(@$cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}

                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".$currencySym.round($allCartData->sum('total_price_usd')*$currencyConvertionFactor,2)."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                        </ul>
                        </div>";
                    }
                    $response['result']['cart']=$allCartData;
                    $response['result']['html']=$html;
                    $response['result']['updateData']=$updateData;
                    $response['result']['sum']=session()->get('currency')==1?$allCartData->sum('total_price_inr'):$allCartData->sum('total_price_usd');
                    $response['result']['updated']='updated';
                    return response()->json($response);
                }
                $ins=[];
                $ins['user_id']=auth()->user()->id;
                $ins['product_id']=$productDetails->id;
                $ins['quantity']=$request->quantity;
                $ins['gemstone_weight']=@$gem_weight->weight;
				if(@$gem_weight->price_type=='B')
				{
					$ins['price_inr']=$gem_weight->price_inr;
					$ins['price_usd']=$gem_weight->price_usd;
				}
				else
				{
					if(@$gem_weight->price_type=='A')
					{
						$ins['price_inr']=$productDetails->price_inr+$gem_weight->price_inr;
						$ins['price_usd']=$productDetails->price_usd+$gem_weight->price_usd;
					}
					else
					{
						$ins['price_inr']=$productDetails->price_inr-$gem_weight->price_inr;
						$ins['price_usd']=$productDetails->price_usd-$gem_weight->price_usd;
					}
				}
                $ins['gemstone_weight_price_inr']=$ins['price_inr'];
                $ins['gemstone_weight_price_usd']=$ins['price_usd'];
                $ins['jewellery_type']=$request->jewellery;
                $ins['metal_type']=@$metal->metal_type;
                $ins['gold_purity']=@$gold_purity->purity;
                $ins['gold_purity_price_inr']=$gold_purity_price_inr;
                $ins['gold_purity_price_usd']=$gold_purity_price_usd;
				if(@$gold_purity->ring_weight_carat)
				{
					$ins['ring_weight']=@$gold_purity->ring_weight_carat;
				}
                else
				{
					$ins['ring_weight']=@$ring_pendant_price->weight;
				}
                $ins['ring_size_system']=@$ring_size_system->ring_size_system;
                $ins['ring_size']=@$ring_size->ring_size;
                $ins['ring_price_inr']=$ring_price_inr;
                $ins['ring_price_usd']=$ring_price_usd;
				if(@$gold_purity->pendent_weight_carat)
				{
					$ins['pendant_weight']=@$gold_purity->pendent_weight_carat;
				}
				else
				{
					$ins['pendant_weight']=@$ring_pendant_price->weight;
				}
                $ins['pendant_type']=$request->pendant_chain;
                $ins['pendant_price_inr']=$pendant_price_inr;
                $ins['pendant_price_usd']=$pendant_price_usd;
                $ins['pendant_chain_price_inr']=$pendant_chain_price_inr;
                $ins['pendant_chain_price_usd']=$pendant_chain_price_usd;
                $ins['bracelet_weight']=@$gold_purity->bracalet_weight_carat;
				if(@$request->jewellery=='B')
				{
					$ins['bracelet_design_id']=@$request->select_design;
				}
                $ins['bracelet_design_price_inr']=$bracelet_design_price_inr;
                $ins['bracelet_design_price_usd']=$bracelet_design_price_usd;
                $ins['bracelet_size']=@$braceletsize->size;
				if(@$request->jewellery=='R' || @$request->jewellery=='P')
				{
					$ins['ring_pendant_design_id']=@$request->select_design;
				}
                $ins['certificate_id']=$request->certification;
                $ins['certification_price_inr']=$certification_price_inr;
                $ins['certification_price_usd']=$certification_price_usd;
                $ins['puja_energization_id']=$request->puja_energy;
                $ins['puja_energization_price_inr']=$puja_energization_price_inr;
                $ins['puja_energization_price_usd']=$puja_energization_price_usd;
                $ins['cart_type']='GS';
                $ins['gift_pack_price_inr']=@$request->gift_pack?$productDetails->gift_pack_price_inr:0;
				$ins['gift_pack_price_usd']=@$request->gift_pack?$productDetails->gift_pack_price_usd:0;
				$ins['total_price_inr']=($ins['price_inr']*$request->quantity)+$ins['gift_pack_price_inr'];
				$ins['total_price_usd']=($ins['price_usd']*$request->quantity)+$ins['gift_pack_price_usd'];
				if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
					$ins['price_inr']=round($ins['price_inr'] - (($ins['price_inr']/100))* @$productDetails->discount_inr);

				}
				if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
					$ins['price_usd']=round($ins['price_usd'] - (($ins['price_usd']/100))* @$productDetails->discount_usd);

				}
				$total_price_inr=$ins['price_inr']+$gold_purity_price_inr+$ring_price_inr+$pendant_price_inr+$pendant_chain_price_inr+$bracelet_design_price_inr+$certification_price_inr+$puja_energization_price_inr;
				$total_price_usd=$ins['price_usd']+$gold_purity_price_usd+$ring_price_usd+$pendant_price_usd+$pendant_chain_price_usd+$bracelet_design_price_usd+$certification_price_usd+$puja_energization_price_usd;
				$ins['total_price_inr']=($total_price_inr*$request->quantity)+$ins['gift_pack_price_inr'];
				$ins['total_price_usd']=($total_price_usd*$request->quantity)+$ins['gift_pack_price_usd'];
                Cart::create($ins);
                $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('user_id',auth()->user()->id)->get();
                $html ='';
                if(session()->get('currency')==1){
                    foreach (@$allCartData as $cart){
						if(@$cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    // <li><a href='{{route('product.shopping.cart')}}' class='sign_btn'>View Cart</a></li>
                    //     @if(@Auth::user())
                    //     <li><a href='{{route('product.shopping.check.out')}}' class='sign_btn'>Checkout</a></li>
                    //     @endif
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".$currencySym.$allCartData->sum('total_price_inr')."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                    </ul>
                    </div>";
                }else{
                    foreach (@$allCartData as $cart){
						if(@$cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".$currencySym.round($allCartData->sum('total_price_usd')*$currencyConvertionFactor,2)."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                    </ul>
                    </div>";
                }

                $response['result']['cart']=$allCartData;
                $response['result']['html']=$html;
                $response['result']['insert']='insert';
                return response()->json($response);


            }
			else
			{
                $cart_id = Session::get('cart_session_id');
				//dd($cart_id);
                $where['cart_session_id']=$cart_id;
                $isAvailable = Cart::where($where)->first();
                if(@$isAvailable){
					$total_price_inr=0;
					$total_price_usd=0;
                    $upd=[];
                    $upd['quantity']=$isAvailable->quantity+$request->quantity;
					$upd['gemstone_weight']=@$gem_weight->weight;
					$upd['jewellery_type']=$request->jewellery;
					$upd['metal_type']=@$metal->metal_type;
					$upd['gold_purity']=@$gold_purity->purity;
					$upd['gold_purity_price_inr']=$gold_purity_price_inr;
					$upd['gold_purity_price_usd']=$gold_purity_price_usd;
					if(@$gold_purity->ring_weight_carat)
					{
						$upd['ring_weight']=@$gold_purity->ring_weight_carat;
					}
					else
					{
						$upd['ring_weight']=@$ring_pendant_price->weight;
					}
					$upd['ring_size_system']=@$ring_size_system->ring_size_system;
					$upd['ring_size']=@$ring_size->ring_size;
					$upd['ring_price_inr']=$ring_price_inr;
					$upd['ring_price_usd']=$ring_price_usd;
					if(@$gold_purity->pendent_weight_carat)
					{
						$upd['pendant_weight']=@$gold_purity->pendent_weight_carat;
					}
					else
					{
						$upd['pendant_weight']=@$ring_pendant_price->weight;
					}
					$upd['pendant_type']=$request->pendant_chain;
					$upd['pendant_price_inr']=$pendant_price_inr;
					$upd['pendant_price_usd']=$pendant_price_usd;
					$upd['pendant_chain_price_inr']=$pendant_chain_price_inr;
					$upd['pendant_chain_price_usd']=$pendant_chain_price_usd;
					$upd['bracelet_weight']=@$gold_purity->bracalet_weight_carat;
					if(@$request->jewellery=='B')
					{
						$ins['bracelet_design_id']=@$request->select_design;
					}
					$upd['bracelet_design_price_inr']=$bracelet_design_price_inr;
					$upd['bracelet_design_price_usd']=$bracelet_design_price_usd;
					$upd['bracelet_size']=@$braceletsize->size;
					if(@$request->jewellery=='R' || @$request->jewellery=='P')
					{
						$upd['ring_pendant_design_id']=@$request->select_design;
					}
					$upd['certificate_id']=$request->certification;
					$upd['certification_price_inr']=$certification_price_inr;
					$upd['certification_price_usd']=$certification_price_usd;
					$upd['puja_energization_id']=$request->puja_energy;
					$upd['puja_energization_price_inr']=$puja_energization_price_inr;
					$upd['puja_energization_price_usd']=$puja_energization_price_usd;
					if(@$gem_weight->price_type=='B')
					{
						$upd['price_inr']=$gem_weight->price_inr;
						$upd['price_usd']=$gem_weight->price_usd;
					}
					else
					{
						if(@$gem_weight->price_type=='A')
						{
							$upd['price_inr']=$productDetails->price_inr+$gem_weight->price_inr;
							$upd['price_usd']=$productDetails->price_usd+$gem_weight->price_usd;
						}
						else
						{
							$upd['price_inr']=$productDetails->price_inr-$gem_weight->price_inr;
							$upd['price_usd']=$productDetails->price_usd-$gem_weight->price_usd;
						}
					}
					$upd['gemstone_weight_price_inr']=$upd['price_inr'];
					$upd['gemstone_weight_price_usd']=$upd['price_usd'];
                    $upd['gift_pack_price_inr']=@$request->gift_pack?$productDetails->gift_pack_price_inr:0;
                    $upd['gift_pack_price_usd']=@$request->gift_pack?$productDetails->gift_pack_price_usd:0;
                    if($isAvailable->gift_pack_price_inr>0 && @$request->gift_pack==null){
                        $upd['gift_pack_price_inr']=$productDetails->gift_pack_price_inr;
                    }
                    if($isAvailable->gift_pack_price_usd>0 && @$request->gift_pack==null){
                        $upd['gift_pack_price_usd']=$productDetails->gift_pack_price_usd;
                    }
                    if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
                        $upd['price_inr']=round($upd['price_inr'] - (($upd['price_inr']/100))* @$productDetails->discount_inr);

                    }
                    if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
                        $upd['price_usd']=round($upd['price_usd'] - (($upd['price_usd']/100))* @$productDetails->discount_usd);

                    }
					$total_price_inr=$total_price_inr+$upd['price_inr']+$gold_purity_price_inr+$ring_price_inr+$pendant_price_inr+$pendant_chain_price_inr+$bracelet_design_price_inr+$certification_price_inr+$puja_energization_price_inr;
					$total_price_usd=$total_price_usd+$upd['price_usd']+$gold_purity_price_usd+$ring_price_usd+$pendant_price_usd+$pendant_chain_price_usd+$bracelet_design_price_usd+$certification_price_usd+$puja_energization_price_usd;
					$upd['total_price_inr']=($total_price_inr*$upd['quantity'])+$upd['gift_pack_price_inr'];
					$upd['total_price_usd']=($total_price_usd*$upd['quantity'])+$upd['gift_pack_price_usd'];
                    Cart::where('id',$isAvailable->id)->update($upd);
                    $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('cart_session_id',$cart_id)->get();
                    $updateData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('id',$isAvailable->id)->where('cart_session_id',$cart_id)->first();
                    $html ='';
                    if(session()->get('currency')==1){
                        foreach (@$allCartData as $cart){
							if(@$cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.$cart->total_price_inr."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}

                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".$currencySym.$allCartData->sum('total_price_inr')."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                        </ul>
                        </div>";
                    } else{
                        foreach (@$allCartData as $cart){
							if(@$cart->cart_type=='GS')
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>";
								if(@$cart->product['title'])
								{
									$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
								}
								else
								{
									$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
								}
								$html.="<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}
							else
							{
								$html.="<div class='shopcutBx_media'>
								<div class='media'>
								<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
								<div class='media-body'>
								<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
								<p>Quantity - ".$cart->quantity."</p>
								<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
								</div>
								</div>
								<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
								</div>";
							}

                        }
                        $html=$html."<div class='total_cut'>
                        <em>Total</em>
                        <b>".$currencySym.round($allCartData->sum('total_price_usd')*$currencyConvertionFactor,2)."</b>
                        </div>
                        <div class='cutview_btn'>
                        <ul>
                        <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                        <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                        </ul>
                        </div>";
                    }
                    $response['result']['cart']=$allCartData;
                    $response['result']['html']=$html;
                    $response['result']['updateData']=$updateData;
                    $response['result']['sum']=session()->get('currency')==1?$allCartData->sum('total_price_inr'):$allCartData->sum('total_price_usd');
                    $response['result']['updated']='updated';
                    return response()->json($response);
                }
                $ins=[];
                $ins['cart_session_id']=$cart_id;
                $ins['product_id']=$productDetails->id;
                $ins['quantity']=$request->quantity;
                $ins['gemstone_weight']=@$gem_weight->weight;
				if(@$gem_weight->price_type=='B')
				{
					$ins['price_inr']=$gem_weight->price_inr;
					$ins['price_usd']=$gem_weight->price_usd;
				}
				else
				{
					if(@$gem_weight->price_type=='A')
					{
						$ins['price_inr']=$productDetails->price_inr+$gem_weight->price_inr;
						$ins['price_usd']=$productDetails->price_usd+$gem_weight->price_usd;
					}
					else
					{
						$ins['price_inr']=$productDetails->price_inr-$gem_weight->price_inr;
						$ins['price_usd']=$productDetails->price_usd-$gem_weight->price_usd;
					}
				}
                $ins['gemstone_weight_price_inr']=$ins['price_inr'];
                $ins['gemstone_weight_price_usd']=$ins['price_usd'];
                $ins['jewellery_type']=$request->jewellery;
                $ins['metal_type']=@$metal->metal_type;
                $ins['gold_purity']=@$gold_purity->purity;
                $ins['gold_purity_price_inr']=$gold_purity_price_inr;
                $ins['gold_purity_price_usd']=$gold_purity_price_usd;
				if(@$gold_purity->ring_weight_carat)
				{
					$ins['ring_weight']=@$gold_purity->ring_weight_carat;
				}
                else
				{
					$ins['ring_weight']=@$ring_pendant_price->weight;
				}
                $ins['ring_size_system']=@$ring_size_system->ring_size_system;
                $ins['ring_size']=@$ring_size->ring_size;
                $ins['ring_price_inr']=$ring_price_inr;
                $ins['ring_price_usd']=$ring_price_usd;
				if(@$gold_purity->pendent_weight_carat)
				{
					$ins['pendant_weight']=@$gold_purity->pendent_weight_carat;
				}
				else
				{
					$ins['pendant_weight']=@$ring_pendant_price->weight;
				}
                $ins['pendant_type']=$request->pendant_chain;
                $ins['pendant_price_inr']=$pendant_price_inr;
                $ins['pendant_price_usd']=$pendant_price_usd;
                $ins['pendant_chain_price_inr']=$pendant_chain_price_inr;
                $ins['pendant_chain_price_usd']=$pendant_chain_price_usd;
                $ins['bracelet_weight']=@$gold_purity->bracalet_weight_carat;
				if(@$request->jewellery=='B')
				{
					$ins['bracelet_design_id']=@$request->select_design;
				}
                $ins['bracelet_design_price_inr']=$bracelet_design_price_inr;
                $ins['bracelet_design_price_usd']=$bracelet_design_price_usd;
                $ins['bracelet_size']=@$braceletsize->size;
				if(@$request->jewellery=='R' || @$request->jewellery=='P')
				{
					$ins['ring_pendant_design_id']=@$request->select_design;
				}
                $ins['certificate_id']=$request->certification;
                $ins['certification_price_inr']=$certification_price_inr;
                $ins['certification_price_usd']=$certification_price_usd;
                $ins['puja_energization_id']=$request->puja_energy;
                $ins['puja_energization_price_inr']=$puja_energization_price_inr;
                $ins['puja_energization_price_usd']=$puja_energization_price_usd;
                $ins['cart_type']='GS';
                $ins['gift_pack_price_inr']=@$request->gift_pack?$productDetails->gift_pack_price_inr:0;
				$ins['gift_pack_price_usd']=@$request->gift_pack?$productDetails->gift_pack_price_usd:0;
				$ins['total_price_inr']=($ins['price_inr']*$request->quantity)+$ins['gift_pack_price_inr'];
				$ins['total_price_usd']=($ins['price_usd']*$request->quantity)+$ins['gift_pack_price_usd'];
				if(@$productDetails->discount_inr != null || @$productDetails->discount_inr != 0){
					$ins['price_inr']=round($ins['price_inr'] - (($ins['price_inr']/100))* @$productDetails->discount_inr);

				}
				if(@$productDetails->discount_usd != null || @$productDetails->discount_usd != 0){
					$ins['price_usd']=round($ins['price_usd'] - (($ins['price_usd']/100))* @$productDetails->discount_usd);

				}
				$total_price_inr=$ins['price_inr']+$gold_purity_price_inr+$ring_price_inr+$pendant_price_inr+$pendant_chain_price_inr+$bracelet_design_price_inr+$certification_price_inr+$puja_energization_price_inr;
				$total_price_usd=$ins['price_usd']+$gold_purity_price_usd+$ring_price_usd+$pendant_price_usd+$pendant_chain_price_usd+$bracelet_design_price_usd+$certification_price_usd+$puja_energization_price_usd;
				$ins['total_price_inr']=($total_price_inr*$request->quantity)+$ins['gift_pack_price_inr'];
				$ins['total_price_usd']=($total_price_usd*$request->quantity)+$ins['gift_pack_price_usd'];
                Cart::create($ins);
                $allCartData= Cart::with(['product','productDefault','product.title','product.subtitle'])->where('cart_session_id',$cart_id)->get();
                $html ='';
                if(session()->get('currency')==1){
                    foreach (@$allCartData as $cart){
						if(@$cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.$cart->total_price_inr."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    // <li><a href='{{route('product.shopping.cart')}}' class='sign_btn'>View Cart</a></li>
                    //     @if(@Auth::user())
                    //     <li><a href='{{route('product.shopping.check.out')}}' class='sign_btn'>Checkout</a></li>
                    //     @endif
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".$currencySym.$allCartData->sum('total_price_inr')."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                    </ul>
                    </div>";
                }else{
                    foreach (@$allCartData as $cart){
						if(@$cart->cart_type=='GS')
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>";
							if(@$cart->product['title'])
							{
								$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
							}
							else
							{
								$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
							}
							$html.="<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}
						else
						{
							$html.="<div class='shopcutBx_media'>
							<div class='media'>
							<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
							<div class='media-body'>
							<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
							<p>Quantity - ".$cart->quantity."</p>
							<b>".$currencySym.round($cart->total_price_usd*$currencyConvertionFactor,2)."</b>
							</div>
							</div>
							<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
							</div>";
						}

                    }
                    $html=$html."<div class='total_cut'>
                    <em>Total</em>
                    <b>".$currencySym.round($allCartData->sum('total_price_usd')*$currencyConvertionFactor,2)."</b>
                    </div>
                    <div class='cutview_btn'>
                    <ul>
                    <li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
                    <li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
                    </ul>
                    </div>";
                }

                $response['result']['cart']=$allCartData;
                $response['result']['html']=$html;
                 $response['result']['insert']='insert';
                return response()->json($response);
            }

        }
        $response['result']['error']='Something went wrong';
        return response()->json($response);

    }
	/**
	*Method:gemstoneMoreInfo
	*Description:For showing gemstone cart details
	*Author:Madhuchandra
	*Date:2021-SEPT-24
	*/
	public function gemstoneMoreInfo(Request $request)
	{
		$cart_id=@$request->cart_id;
		$cart_details=Cart::where('id',$cart_id)->with(['cirtificate.certificate_name','puja.puja_name'])->first();
		$html="";
		if(@$cart_details)
		{
			if(@$cart_details->jewellery_type=='OS')
			{
				if(Session::get('currency')>=2)
				{
					$html.='<p><span>Gemstone Weight:</span> '.$cart_details->gemstone_weight.' Carat ('.(round($cart_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
				}
				else
				{
					$html.='<p><span>Gemstone Weight:</span> '.$cart_details->gemstone_weight.' Carat ('.(round($cart_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
				}

                if(@$cart_details->certificate_id)
                    {
                        $html.='<p><span>Certification Name : </span>'.@$cart_details->cirtificate->certificate_name->cert_name.'</p>';
                        if(Session::get('currency')>=2)
                        {
                            $html.='<p><span>Certification Price:</span> '.@session()->get('currencySym').round($cart_details->certification_price_usd*currencyConversionCustom(),2).'</p>';
                        }else{
                            $html.='<p><span>Certification Price:</span> '.@session()->get('currencySym').$cart_details->certification_price_inr.'</p>';
                        }

                    }
                    // puja-energization
                if(@$cart_details->puja_energization_id)
                {
                        $html.='<p><span>Puja Energization Name : </span>'.@$cart_details->puja->puja_name->puja.'</p>';
                        if(Session::get('currency')>=2)
                        {
                            $html.='<p><span>Puja Energization Price:</span> '.@session()->get('currencySym').round($cart_details->puja_energization_price_usd*currencyConversionCustom(),2).'</p>';
                        }else{
                            $html.='<p><span>Puja Energization Price:</span> '.@session()->get('currencySym').$cart_details->puja_energization_price_inr.'</p>';
                        }

                }


			}
			else
			{
				if(Session::get('currency')>=2)
				{
					$html.='<p><span>Gemstone Weight:</span> '.$cart_details->gemstone_weight.' Carat ('.(round($cart_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
				}
				else
				{
					$html.='<p><span>Gemstone Weight:</span> '.$cart_details->gemstone_weight.' Carat ('.(round($cart_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
				}
				if(@$cart_details->jewellery_type=='R')
				{
					if(@$cart_details->metal_type=='G')
					{
						$html.='<p><span>Gemstone purchased with:</span> Gold Ring</p>';
						$html.='<p><span>Ring weight:</span> '.$cart_details->ring_weight.' Carat</p>';
						$html.='<p><span>Ring size:</span> '.$cart_details->ring_size_system.' - '.$cart_details->ring_size.'</p>';
						if(Session::get('currency')>=2)
						{
							$html.='<p><span>Ring price:</span> '.@session()->get('currencySym').round($cart_details->gold_purity_price_usd*currencyConversionCustom(),2).'</p>';
						}
						else
						{
							$html.='<p><span>Ring price:</span> '.@session()->get('currencySym').$cart_details->gold_purity_price_inr.'</p>';
						}

					}
					elseif(@$cart_details->metal_type=='S')
					{
						$html.='<p><span>Gemstone purchased with:</span> Silver Ring</p>';
						$html.='<p><span>Ring weight:</span> '.$cart_details->ring_weight.' Gm</p>';
						$html.='<p><span>Ring size:</span> '.$cart_details->ring_size_system.' - '.$cart_details->ring_size.'</p>';
						if(Session::get('currency')>=2)
						{
							$html.='<p><span>Ring price:</span> '.@session()->get('currencySym').round($cart_details->ring_price_usd*currencyConversionCustom(),2).'</p>';
						}
						else
						{
							$html.='<p><span>Ring price:</span> '.@session()->get('currencySym').$cart_details->ring_price_inr.'</p>';
						}
					}
					elseif(@$cart_details->metal_type=='P')
					{
						$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Ring</p>';
						$html.='<p><span>Ring weight:</span> '.$cart_details->ring_weight.' Gm</p>';
						$html.='<p><span>Ring size:</span> '.$cart_details->ring_size_system.' - '.$cart_details->ring_size.'</p>';
						if(Session::get('currency')>=2)
						{
							$html.='<p><span>Ring price:</span> '.@session()->get('currencySym').round($cart_details->ring_price_usd*currencyConversionCustom(),2).'</p>';
						}
						else
						{
							$html.='<p><span>Ring price:</span> '.@session()->get('currencySym').$cart_details->ring_price_inr.'</p>';
						}
					}
					if(@$cart_details->ring_pendant_design_id)
					{
						$design_details=RingPendentDesign::where('id',@$cart_details->ring_pendant_design_id)->first();
						$img_url=\URL::to('/').'/storage/app/public/ring_pendent_design/'.$design_details->design_image;
						$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
						$html.='<p>'.@$design_details->design_name.'</p>';

					}

				}
				elseif(@$cart_details->jewellery_type=='P')
				{

					if(@$cart_details->metal_type=='G')
					{
						if(@$cart_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with: Gold Pendant -</span> with chain</p>';
						}
						else
						{
							$html.='<p><span>Gemstone purchased with: Gold Pendant -</span> without chain</p>';
						}
						$html.='<p>Pendant weight: '.$cart_details->pendant_weight.' Carat</p>';
						if(Session::get('currency')>=2)
						{
							$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').round($cart_details->gold_purity_price_usd*currencyConversionCustom(),2).'</p>';
						}
						else
						{
							$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').$cart_details->gold_purity_price_inr.'</p>';
						}
					}
					elseif(@$cart_details->metal_type=='S')
					{
						if(@$cart_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with: Silver Pendant -</span> with chain</p>';
						}
						else
						{
							$html.='<p><span>Gemstone purchased with: Silver Pendant -</span> without chain</p>';
						}
						$html.='<p>Pendant weight: '.$cart_details->pendant_weight.' Gm</p>';
						if(Session::get('currency')>=2)
						{
							if(@$cart_details->pendant_type=='W')
							{
								$html.='<p><span>Pendant price: </span>'.@session()->get('currencySym').round($cart_details->pendant_chain_price_usd*currencyConversionCustom(),2).'</p>';
							}
							else
							{
								$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').round($cart_details->pendant_price_usd*currencyConversionCustom(),2).'</p>';
							}

						}
						else
						{
							if(@$cart_details->pendant_type=='W')
							{
								$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').$cart_details->pendant_chain_price_inr.'</p>';
							}
							else
							{
								$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').$cart_details->pendant_price_inr.'</p>';
							}
						}
					}
					elseif(@$cart_details->metal_type=='P')
					{
						if(@$cart_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with: Panchdhatu Pendant -</span> with chain</p>';
						}
						else
						{
							$html.='<p><span>Gemstone purchased with: Panchdhatu Pendant -</span> without chain</p>';
						}
						$html.='<p>Pendant weight: '.$cart_details->pendant_weight.' Gm</p>';
						if(Session::get('currency')>=2)
						{
							if(@$cart_details->pendant_type=='W')
							{
								$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').round($cart_details->pendant_chain_price_usd*currencyConversionCustom(),2).'</p>';
							}
							else
							{
								$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').round($cart_details->pendant_price_usd*currencyConversionCustom(),2).'</p>';
							}

						}
						else
						{
							if(@$cart_details->pendant_type=='W')
							{
								$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').$cart_details->pendant_chain_price_inr.'</p>';
							}
							else
							{
								$html.='<p><span>Pendant price:</span> '.@session()->get('currencySym').$cart_details->pendant_price_inr.'</p>';
							}
						}
					}
					if(@$cart_details->ring_pendant_design_id)
					{
						$design_details=RingPendentDesign::where('id',@$cart_details->ring_pendant_design_id)->first();
						$img_url=\URL::to('/').'/storage/app/public/ring_pendent_design/'.$design_details->design_image;
						$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
						$html.='<p>'.@$design_details->design_name.'</p>';

					}
				}
				elseif(@$cart_details->jewellery_type=='B')
				{
					if(@$cart_details->metal_type=='G')
					{
						$html.='<p><span>Gemstone purchased with:</span> Gold Bracelet</p>';
						$html.='<p><span>Bracelet weight:</span> '.$cart_details->bracelet_weight.' Carat</p>';
						if(Session::get('currency')>=2)
						{
							$html.='<p><span>Bracelet price:</span> '.@session()->get('currencySym').round($cart_details->gold_purity_price_usd*currencyConversionCustom(),2).'</p>';
						}
						else
						{
							$html.='<p><span>Bracelet price:</span> '.@session()->get('currencySym').$cart_details->gold_purity_price_inr.'</p>';
						}
						if(@$cart_details->bracelet_design_id)
						{
							$design_details=BraceletDesign::where('id',@$cart_details->bracelet_design_id)->first();
							$img_url=\URL::to('/').'/storage/app/public/bracelet_design/'.$design_details->design_picture;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							if(Session::get('currency')>=2)
							{
								$html.='<p><span>Bracelet design price:</span> '.@session()->get('currencySym').round($cart_details->bracelet_design_price_usd*currencyConversionCustom(),2).'</p>';
							}
							else
							{
								$html.='<p><span>Bracelet design price:</span> '.@session()->get('currencySym').$cart_details->bracelet_design_price_inr.'</p>';
							}

						}
					}
					elseif(@$cart_details->metal_type=='S')
					{
						$html.='<p><span>Gemstone purchased with:</span> Silver Bracelet</p>';
						if(@$cart_details->bracelet_design_id)
						{
							$design_details=BraceletDesign::where('id',@$cart_details->bracelet_design_id)->first();
							$img_url=\URL::to('/').'/storage/app/public/bracelet_design/'.$design_details->design_picture;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							if(Session::get('currency')>=2)
							{
								$html.='<p><span>Bracelet design price:</span> '.@session()->get('currencySym').round($cart_details->bracelet_design_price_usd*currencyConversionCustom(),2).'</p>';
							}
							else
							{
								$html.='<p><span>Bracelet design price:</span> '.@session()->get('currencySym').$cart_details->bracelet_design_price_inr.'</p>';
							}

						}
					}
					elseif(@$cart_details->metal_type=='P')
					{
						$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Bracelet</p>';
						if(@$cart_details->bracelet_design_id)
						{
							$design_details=BraceletDesign::where('id',@$cart_details->bracelet_design_id)->first();
							$img_url=\URL::to('/').'/storage/app/public/bracelet_design/'.$design_details->design_picture;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							if(Session::get('currency')>=2)
							{
								$html.='<p><span>Bracelet design price:</span> '.@session()->get('currencySym').round($cart_details->bracelet_design_price_usd*currencyConversionCustom(),2).'</p>';
							}
							else
							{
								$html.='<p><span>Bracelet design price:</span> '.@session()->get('currencySym').$cart_details->bracelet_design_price_inr.'</p>';
							}

						}
					}
					$html.='<p><span>Bracelet Size:</span> '.$cart_details->bracelet_size.'</p>';
				}
                // Cirtification
                if(@$cart_details->certificate_id)
                {
                        $html.='<p><span>Certification Name : </span>'.@$cart_details->cirtificate->certificate_name->cert_name.'</p>';
                        if(Session::get('currency')>=2)
                        {
                            $html.='<p><span>Certification Price:</span> '.@session()->get('currencySym').round($cart_details->certification_price_usd*currencyConversionCustom(),2).'</p>';
                        }else{
                            $html.='<p><span>Certification Price:</span> '.@session()->get('currencySym').$cart_details->certification_price_inr.'</p>';
                        }

                }

                // puja-energization
                if(@$cart_details->puja_energization_id)
                {
                        $html.='<p><span>Puja Energization Name : </span>'.@$cart_details->puja->puja_name->puja.'</p>';
                        if(Session::get('currency')>=2)
                        {
                            $html.='<p><span>Puja Energization Price:</span> '.@session()->get('currencySym').round($cart_details->puja_energization_price_usd*currencyConversionCustom(),2).'</p>';
                        }else{
                            $html.='<p><span>Puja Energization Price:</span> '.@session()->get('currencySym').$cart_details->puja_energization_price_inr.'</p>';
                        }

                }


			}

		}
		$response['html']=$html;
		return response()->json($response);
	}
	/**
	*Method:gemstoneOrderMoreInfo
	*Description:For showing gemstone order details
	*Author:Madhuchandra
	*Date:2021-SEPT-27
	*/
	public function gemstoneOrderMoreInfo(Request $request)
	{
		$order_details_id=@$request->order_details_id;
		$gemstone_details=OrderDetails::where('id',$order_details_id)->first();
		$order_master_details=OrderMaster::where('id',$gemstone_details->order_master_id)->with('currencyDetails')->first();
		$html="";
		if(@$gemstone_details)
		{
			if(@$gemstone_details->jewellery_type=='OS')
			{
				$html.='<p><span>Gemstone Weight:</span> '.$gemstone_details->gemstone_weight.' Carat ('.(round($gemstone_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
                if(@$gemstone_details->certificate_name!=""){
                    $html.='<p><span>Cirtificate Name:</span> '.@$gemstone_details->certificate_name.' </p>';
                    $html.='<p><span>Cirtificate Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->certification_price.' </p>';
                }
                if(@$gemstone_details->puja_energization_name!=""){
                    $html.='<p><span>Puja Energization Name:</span> '.@$gemstone_details->puja_energization_name.' </p>';
                    $html.='<p><span>Puja Energization Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->puja_energization_price.' </p>';
                }
			}
			else
			{
				$html.='<p><span>Gemstone Weight:</span> '.$gemstone_details->gemstone_weight.' Carat ('.(round($gemstone_details->gemstone_weight/env('RATTI_TO_CARAT'),2)).' Ratti)</p>';
				if(@$gemstone_details->jewellery_type=='R')
				{
					if(@$gemstone_details->metal_type=='G')
					{
						$html.='<p><span>Gemstone purchased with:</span> Gold Ring</p>';
						$html.='<p><span>Ring weight: </span>'.$gemstone_details->ring_weight.' Carat </p>';
						$html.='<p><span>Ring size: </span>'.$gemstone_details->ring_size_system.' - '.$gemstone_details->ring_size.'</p>';
						$html.='<p><span>Ring price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->gold_purity_price.'</p>';
					}
					elseif(@$gemstone_details->metal_type=='S')
					{
						$html.='<p><span>Gemstone purchased with:</span> Silver Ring</p>';
						$html.='<p><span>Ring weight: </span>'.$gemstone_details->ring_weight.' Gm</p>';
						$html.='<p><span>Ring size: </span>'.$gemstone_details->ring_size_system.' - '.$gemstone_details->ring_size.'</p>';
						$html.='<p><span>Ring price: </span>'.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->ring_price.'</p>';
					}
					elseif(@$cart_details->metal_type=='P')
					{
						$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Ring</p>';
						$html.='<p><span>Ring weight: </span>'.$gemstone_details->ring_weight.' Gm</p>';
						$html.='<p><span>Ring size:</span> '.$gemstone_details->ring_size_system.' - '.$gemstone_details->ring_size.'</p>';
						$html.='<p><span>Ring price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->ring_price.'</p>';
					}
					if(@$gemstone_details->ring_pendant_design_name)
					{
						$img_url=\URL::to('/').'/storage/app/public/order_ring_pendant_design/'.$gemstone_details->ring_pendant_design_image;
						$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
						$html.='<p> '.$gemstone_details->ring_pendant_design_name.'</p>';

					}

				}
				elseif(@$gemstone_details->jewellery_type=='P')
				{

					if(@$gemstone_details->metal_type=='G')
					{
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with:</span> Gold Pendant - with chain</p>';
						}
						else
						{
							$html.='<p><span>Gemstone purchased with:</span> Gold Pendant - without chain</p>';
						}
						$html.='<p><span>Pendant weight:</span> '.$gemstone_details->pendant_weight.' Carat</p>';
						$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->gold_purity_price.'</p>';
					}
					elseif(@$gemstone_details->metal_type=='S')
					{
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with:</span> Silver Pendant - with chain</p>';
						}
						else
						{
							$html.='<p><sapn>Gemstone purchased with:</span> Silver Pendant - without chain</p>';
						}
						$html.='<p><span>Pendant weight:</span> '.$gemstone_details->pendant_weight.' Gm</p>';
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_chain_price.'</p>';
						}
						else
						{
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_price.'</p>';
						}
					}
					elseif(@$gemstone_details->metal_type=='P')
					{
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Pendant - with chain</p>';
						}
						else
						{
							$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Pendant - without chain</p>';
						}
						$html.='<p><span>Pendant weight:</span> '.$gemstone_details->pendant_weight.' Gm</p>';
						if(@$gemstone_details->pendant_type=='W')
						{
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_chain_price.'</p>';
						}
						else
						{
							$html.='<p><span>Pendant price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->pendant_price.'</p>';
						}
					}
					if(@$gemstone_details->ring_pendant_design_name)
					{
						$img_url=\URL::to('/').'/storage/app/public/order_ring_pendant_design/'.$gemstone_details->ring_pendant_design_image;
						$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
						$html.='<p> '.$gemstone_details->ring_pendant_design_name.'</p>';

					}
				}
				elseif(@$gemstone_details->jewellery_type=='B')
				{
					if(@$gemstone_details->metal_type=='G')
					{
						$html.='<p><span>Gemstone purchased with:</span> Gold Bracelet</p>';
						$html.='<p><span>Bracelet weight:</span> '.$gemstone_details->bracelet_weight.' Carat</p>';
						$html.='<p><span>Bracelet Size:</span> '.$gemstone_details->bracelet_size.'</p>';
						$html.='<p><span>Bracelet price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->gold_purity_price.'</p>';
						if(@$gemstone_details->bracelet_design_name)
						{
							$img_url=\URL::to('/').'/storage/app/public/order_bracelet_design/'.$gemstone_details->bracelet_design_image;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							$html.='<p><span>Bracelet design price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->bracelet_design_price.'</p>';

						}
					}
					elseif(@$gemstone_details->metal_type=='S')
					{
						$html.='<p><span>Gemstone purchased with:</span> Silver Bracelet</p>';
						$html.='<p><span>Bracelet Size:</span> '.$gemstone_details->bracelet_size.'</p>';
						if(@$gemstone_details->bracelet_design_name)
						{
							$img_url=\URL::to('/').'/storage/app/public/order_bracelet_design/'.$gemstone_details->bracelet_design_image;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							$html.='<p><span>Bracelet design price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->bracelet_design_price.'</p>';

						}
					}
					elseif(@$gemstone_details->metal_type=='P')
					{
						$html.='<p><span>Gemstone purchased with:</span> Panchdhatu Bracelet</p>';
						$html.='<p><span>Bracelet Size:</span> '.$gemstone_details->bracelet_size.'</p>';
						if(@$gemstone_details->bracelet_design_name)
						{
							$img_url=\URL::to('/').'/storage/app/public/order_bracelet_design/'.$gemstone_details->bracelet_design_image;
							$html.='<p><img class="img-responsive" src="'.$img_url.'"/></p>';
							$html.='<p>Bracelet design price: '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->bracelet_design_price.'</p>';

						}
					}
				}
                if(@$gemstone_details->certificate_name!=""){
                    $html.='<p><span>Cirtificate Name:</span> '.@$gemstone_details->certificate_name.' </p>';
                    $html.='<p><span>Cirtificate Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->certification_price.' </p>';
                }
                if(@$gemstone_details->puja_energization_name!=""){
                    $html.='<p><span>Puja Energization Name:</span> '.@$gemstone_details->puja_energization_name.' </p>';
                    $html.='<p><span>Puja Energization Price:</span> '.$order_master_details->currencyDetails->currency_symbol.$gemstone_details->puja_energization_price.' </p>';
                }


			}

		}
		$response['html']=$html;
		return response()->json($response);
	}
	/**
	*Method:gemstoneCartUpdate
	*Description:For updating cart
	*Author:Madhuchandra
	*Date:2021-SEPT-24
	*/
	public function gemstoneCartUpdate(Request $request)
	{
		$response = [
            'jsonrpc' => '2.0'
        ];
		$cart_id=@$request->params['cart_id'];
		$cart_details=Cart::where('id',$cart_id)->first();
		$total_price_inr=0;
		$total_price_usd=0;
		if(@$cart_details)
		{
			$product_details=Products::where('id',$cart_details->product_id)->first();
			if(Session::get('currency')>=2)
			{
				if(@$product_details->discount_usd)
				{
					$total_price_usd=($cart_details->gemstone_weight_price_usd-(($cart_details->gemstone_weight_price_usd*@$product_details->discount_usd)/100));
				}
				else
				{
					$total_price_usd=$cart_details->gemstone_weight_price_usd;
				}
			}
			else
			{
				if(@$product_details->discount_inr)
				{
					$total_price_inr=($cart_details->gemstone_weight_price_inr-(($cart_details->gemstone_weight_price_inr*@$product_details->discount_inr)/100));
				}
				else
				{
					$total_price_inr=$cart_details->gemstone_weight_price_inr;
				}
			}
			$total_price_inr=$total_price_inr+$cart_details->gold_purity_price_inr+$cart_details->ring_price_inr+$cart_details->pendant_price_inr+$cart_details->pendant_chain_price_inr+$cart_details->bracelet_price_inr+$cart_details->bracelet_design_price_inr+$cart_details->certification_price_inr+$cart_details->puja_energization_price_inr+$cart_details->gift_pack_price_inr;
			$total_price_usd=$total_price_usd+$cart_details->gold_purity_price_usd+$cart_details->ring_price_usd+$cart_details->pendant_price_usd+$cart_details->pendant_chain_price_usd+$cart_details->bracelet_price_usd+$cart_details->bracelet_design_price_usd+$cart_details->certification_price_usd+$cart_details->puja_energization_price_usd+$cart_details->gift_pack_price_usd;
			$upd=array();
			$upd['total_price_inr']=$total_price_inr*@$request->params['quantity'];
			$upd['total_price_usd']=$total_price_usd*@$request->params['quantity'];
			$upd['quantity']=@$request->params['quantity'];
			Cart::where('id',$request->params['cart_id'])->update($upd);
			$total_price=0;
			if(@auth()->user()->id)
			{
				$allCartData=Cart::where('user_id',@auth()->user()->id)->get();
			}
			else
			{
				$allCartData=Cart::where('cart_session_id',Session::get('cart_session_id'))->get();
			}
			if(session()->get('currency')>=2)
			{
				$total_price=round($allCartData->sum('total_price_usd')*currencyConversionCustom(),2);
			}
			else
			{
				$total_price=$allCartData->sum('total_price_inr');
			}
			$html="";
			foreach (@$allCartData as $cart){
			if(@$cart->cart_type=='GS')
			{
				$html.="<div class='shopcutBx_media'>
				<div class='media'>
				<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_gemstone_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
				<div class='media-body'>";
				if(@$cart->product['title'] && @$cart->product['subtitle'])
				{
					$html.="<p><a href='javascript:;'>".@$cart->product['title']->title."/".@$cart->product['subtitle']->title."/".$cart->product->product_code."</a></p>";
				}
				else
				{
					$html.="<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>";
				}
				$html.="<p>Quantity - ".$cart->quantity."</p>
				<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
				</div>
				</div>
				<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
				</div>";
			}
			else
			{
				$html.="<div class='shopcutBx_media'>
				<div class='media'>
				<em> <a href='javascript:;'> <img src='".asset('storage/app/public/small_product_image').'/'.@$cart->productdefault->image."' alt='product'> </a></em>
				<div class='media-body'>
				<p><a href='javascript:;'>".$cart->product->product_name."/".$cart->product->product_code."</a></p>
				<p>Quantity - ".$cart->quantity."</p>
				<b>".session()->get('currencySym').round($cart->total_price_usd*currencyConversionCustom(),2)."</b>
				</div>
				</div>
				<a href='".route('product.add.to.cart.delete',['id'=>$cart->id])."' onclick='return confirm('Do you want to delete this product from cart?')' class='closecut'><i class='fa fa-times' aria-hidden='true'></i></a>
				</div>";
			}

		}
		$html.="<div class='total_cut'>
		<em>Total</em>
		<b>".@session()->get('currencySym').$total_price."</b>
		</div>
		<div class='cutview_btn'>
		<ul>
		<li><a href='".route('product.shopping.cart')."' class='sign_btn'>View Cart</a></li>
		<li><a href='".route('product.shopping.check.out')."' class='sign_btn'>Checkout</a></li>
		</ul>
		</div>";
			$updateData=Cart::where('id',$request->params['cart_id'])->first();
			$response['result']['cart']=$allCartData;
			$response['result']['html']=$html;
			$response['result']['updateData']=$updateData;
			$response['result']['sum']=$total_price;
			$response['result']['updated']='updated';
			if(session()->get('currency')>=2)
			{
				$response['result']['unit_price']=session()->get('currencySym').round($updateData->price_usd*currencyConversionCustom(),2);
				$response['result']['total_price']=session()->get('currencySym').round($updateData->total_price_usd*currencyConversionCustom(),2);
			}
			else
			{
				$response['result']['unit_price']=session()->get('currencySym').$updateData->price_inr;
				$response['result']['total_price']=session()->get('currencySym').$updateData->total_price_inr;
			}
			$response['result']['subtotal']=@session()->get('currencySym').$total_price;
			$response['result']['total']=@session()->get('currencySym').$total_price;
		}
		return response()->json($response);
	}
}
