<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class AccessCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        /*if(@Auth::user()->user_type=='A'){
            return redirect()->route('astrologer.dashboard');
        }
        if(@Auth::user()->user_type=='P'){
            return redirect()->route('pundit.dashboard');
        }*/
        if(Session::get('cart_session_id')==null){
            session(['cart_session_id' => str_random(20).'-'.time()]);
        }


        return $next($request);
    }
}
