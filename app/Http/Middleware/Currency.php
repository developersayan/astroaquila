<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use App\Models\Currencys;
use Cookie;
use Session;
class Currency
{
    public function handle($request, Closure $next)
    {



        //  $ip = $_SERVER['REMOTE_ADDR'];
        // // $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));


        // // $ip_address=$_SERVER['REMOTE_ADDR'];
        // // $geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
        // // $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
        // // dd($addrDetailsArr);
        // $details = json_decode(file_get_contents("https://api.ipgeolocationapi.com/geolocate/{$ip} HTTP/1.1;"));
        // dd($details);    
        // // session()->forget('currencyCode');
        // $ip = $_SERVER['REMOTE_ADDR'];
        // $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
        // dd($ip);
        // $ip_address=$_SERVER['REMOTE_ADDR'];
        // $geopluginURL='http://www.geoplugin.net/php.gp?ip='.$ip_address;
        // $addrDetailsArr = unserialize(file_get_contents($geopluginURL));
        // dd($addrDetailsArr);
        $ip = $_SERVER['REMOTE_ADDR'];
        $currency = session()->get('currency');
        $currencyCode = session()->get('currencyCode');
        

        // api-call

        

        if (session()->get('currency')==null ) {
// dd('Syaa');
        // $ip = $_SERVER['REMOTE_ADDR'];
        // $access_key = '2e90defa67e42f7fce7277c62fae5bf3';

        // // Initialize CURL:
        // $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // // Store the data:
        // $json = curl_exec($ch);
        // curl_close($ch);

        // // Decode JSON response:
        // $api_result = json_decode($json, true);
        // dd($api_result);
        // if ($currency==null) {
            $currencyCode = 'USD';
            session(['currencyCode' => $currencyCode]);
            $currency = '2';
            session(['currency' => $currency]);
        // }else{
        //     $currencyCode = 'INR';
        //     session(['currencyCode' => $currencyCode]);
        //     $currency = '1';
        //     session(['currency' => $currency]);
        // }
           
        }else{

         $currency = session()->get('currency');
         // $currencyCode = session()->get('currencyCode');
         session(['currencyCode' => $currencyCode]);
         session(['currency' => $currency]);

        }


        if (session()->get('currency')!="") {
           $currency = Currencys::where('id',session()->get('currency'))->first();
           session(['currencySym' =>$currency->currency_symbol]);
           session(['currencyCode' =>$currency->currency_code]);
        }

        




        // old-code//////////////////////////////////////////////////

        // $currency = session()->get('currency');
        // $currencyCode = session()->get('currencyCode');
       
        // if ($currencyCode == null) {
        //     $currencyCode = env('CURRENCY');
        //     session(['currencyCode' => $currencyCode]);
        // }
        // if ($currency == null) {
        //     $currency = env('CURRENCY_ID');
        //     session(['currency' => $currency]);
        // }
        return $next($request);
    }
}
