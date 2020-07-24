<?php

namespace App\Http\Middleware;

use Closure;

class UTF8Formatting
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
        //Solution: https://stackoverflow.com/questions/50717005/laravel-encode-json-responses-in-utf-8
       /** @var array $data */ // you need to return array from controller
       $data = $next($request);

       return response()->json($data, 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
       JSON_UNESCAPED_UNICODE);
    }
}
