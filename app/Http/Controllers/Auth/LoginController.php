<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;      
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        // Validate the login form inputs
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ]);
    
        // Check if 'remember' checkbox is checked
        $remember = $request->has('remember'); // This will return true or false
    
        // Attempt to authenticate the user using the 'admin' guard
        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $remember)) {
            // Redirect to the dashboard
            return redirect()->route('admin.dashboard');
        }
    
        // Redirect back with an error if authentication fails
        return back()->withErrors(['email' => 'The provided credentials are incorrect.'])->withInput();
    }
    
    

    public function logout()
    {
        // Logout the authenticated admin user
        Auth::guard('admin')->logout();

        // Redirect to the admin login page with a success message
        return redirect()->route('login.form')->with('status', 'You have been logged out successfully.');
    }
    
}
