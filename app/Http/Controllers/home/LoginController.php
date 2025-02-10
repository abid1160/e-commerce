<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Display the login form
    public function loginform()
    {
        return view('home.auth.login');
    }
   


    // Handle the login request
    public function login(Request $request)
    {
 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
 
            
            // Login successful
            return redirect()->route('website');
        }

        // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
// In HomeController.php
public function logout(Request $request)
{
 
    Auth::guard('user')->logout();  // Log the user out

    $request->session()->invalidate();  // Invalidate the session

    $request->session()->regenerateToken();  // Regenerate the CSRF token

    return redirect()->route('website');  // Redirect to homepage or any other route
}

}
