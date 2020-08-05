<?php

namespace App\Http\Middleware\Tenant;

use Closure;

class VerifyManager
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
//        dd(config('tenant.main'));
        if(($request->getHost() != config('tenant.main'))){
            return $next($request);
        }

        abort(404);
    }
}
