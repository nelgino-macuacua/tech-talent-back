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

        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin' , '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers', 'X-Requested-With, Accept-Language, Accept-Encoding, Content-Type, Accept, Authorization, Application');

        return $response;
        /* return $next($request)
            ->headers('Access-Control-Allow-Origin',"*")
            ->headers('Access-Control-Allow-Methods',"PUT, POST, DELETE, GET, OPTIONS")
            ->headers('Access-Control-Allow-Headers',"Accept, Authorization, Content-Type"); */
    }
}
