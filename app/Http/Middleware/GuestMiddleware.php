<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and if the user is an admin using the 'admin' guard
        if (Auth::guard('admin')->check()) {
            // Redirect to the admin dashboard if the user is an admin and logged in
            return redirect()->route('admin.dashboard'); // You can redirect to any page you prefer
        }

        // If the user is not logged in or not an admin, allow the request to proceed
        return $next($request);
    }
}     
