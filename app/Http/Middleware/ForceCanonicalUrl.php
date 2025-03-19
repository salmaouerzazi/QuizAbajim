<?php

namespace App\Http\Middleware;

use Closure;

class ForceCanonicalUrl
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
        $host = $request->getHost();
        return $next($request);
    }
}
