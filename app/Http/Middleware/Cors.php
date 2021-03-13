<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        return $next($request)
            ->headers('Access-Control-Allow-Origin',"*")
            ->headers('Access-Control-Allow-Methods',"PUT, POST, DELETE, GET, OPTIONS")
            ->headers('Access-Control-Allow-Headers',"Accept, Authorization, Content-Type");
    }
}
