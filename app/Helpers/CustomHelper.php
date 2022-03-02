<?php
namespace App\Helpers;
use Auth;
use App\Models\Cart;
use App\Models\Currencys;
use App\Models\CurrencyConversion;
class CustomHelper{
    function getAllCart() {
        if (@auth()->user()->id){
            return Cart::with(['product','productDefault','product.title','product.subtitle'])->where('user_id',auth()->user()->id)->get();
        }
        return Cart::with(['product','productDefault','product.title','product.subtitle'])->where('cart_session_id',session()->get('cart_session_id'))->get();
    }

    function currencyConversion()
    {
    	$conversion = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
    	return $conversion->conversion_factor;
    }



}


?>
