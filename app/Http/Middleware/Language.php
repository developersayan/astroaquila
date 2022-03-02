<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Language
{
    public function handle($request, Closure $next)
    {
        $lang = session()->get('lang');
        $langCode = session()->get('langCode');
        if ($langCode == null) {
            $langCode = env('LANGUAGE');
            session(['langCode' => $langCode]);
        }
        if ($lang == null) {
            $lang = env('LANGUAGE_ID');
            session(['lang' => $lang]);
        }
        App::setLocale($langCode);

        return $next($request);
    }
}
