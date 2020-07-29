<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {           
        $language = $request->session()->get('language', config('app.locale'));
        switch ($language) {
         case 'en':
             $language = 'en';
             break;
         
         default:
             $language = 'vi';
             break;
     }
        App::setLocale($language);
     
        return $next($request);
    }
}
