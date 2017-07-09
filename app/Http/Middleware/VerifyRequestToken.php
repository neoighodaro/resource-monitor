<?php

namespace App\Http\Middleware;

use Closure;

class VerifyRequestToken
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
        if ($request->get('token', false) !== env('APP_ACCESS_TOKEN')) {
            abort(403);
        }

        return $next($request);
    }
}
