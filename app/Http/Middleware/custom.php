<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class custom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in (using the default guard)
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');  // Continue the request if the user is logged in
        }else{
            return redirect()->route('login.form');
        }

        // Redirect to the login page if the user is not logged in
        
    }
}
