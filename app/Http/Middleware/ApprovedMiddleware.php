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
   public function handle(Request $request, Closure $next)
{
    // If user not logged in → block
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $user = auth()->user();

    // Roles that do NOT require approval
    $autoApprovedRoles = ['admin', 'customer'];

    // If role does NOT require approval → allow
    if (in_array($user->role, $autoApprovedRoles)) {
        return $next($request);
    }

    // For cashier/kitchen → block if NOT approved
    if (!$user->is_approved) {
        return redirect()->route('pending');
    }

    return $next($request);
}


}
