<?php

namespace App\Http\Middleware;

use Closure;

class CustomAuth
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
        //check that the user is logged in, if not return custom JSON response
        return response()->json([
            'status' => 'unauthenticated',
            'transactions' => false,
            'balance' => false,
        ]);

        return $next($request);
    }
}
