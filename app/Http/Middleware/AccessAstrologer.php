<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccessAstrologer
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

        if (@Auth::user()->user_type == 'C') {
            return redirect()->route('customer.dashboard');
        }
        if (@Auth::user()->user_type == 'P') {
            return redirect()->route('pundit.dashboard');
        }


        return $next($request);
    }
}
