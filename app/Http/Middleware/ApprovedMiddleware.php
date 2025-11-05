<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApprovedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   public function handle($request, Closure $next)
{
    if (auth()->check() && !auth()->user()->is_approved && auth()->user()->role !== 'customer') {
        return redirect()->route('pending');
    }

    return $next($request);
}

}
