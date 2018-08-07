<?php

namespace App\Http\Middleware;

use Closure;

class ObfuscateId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $param = null)
    {
        $routeParamName = $param ? $param : 'id';

        if ($routeParamValue = $request->route()->parameter($routeParamName)) {
            $request->route()->setParameter($routeParamName, optimus()->decode($routeParamValue));
        }

        return $next($request);
    }
}
