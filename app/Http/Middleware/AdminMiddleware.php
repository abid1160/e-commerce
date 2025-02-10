<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Use the 'admin' guard to check if the user is logged in as an admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Redirect to the login page with an access error if the user is not an admin
        return redirect()->route('admin.login')->withErrors(['access' => 'Access denied.']);
    }
}
