<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function showforgetpasswordform()
    {
        session()->flash('success', 'Please enter your email to reset your password.');
        return view('admin.auth.forgetpassword.forgetpassword');
    }
 


    public function submitforgetpasswordform(Request $request)
    {
        // Validate the request input
        $request->validate([
            'email' => 'email|required',
        ]);

        // Generate a random token
        $token = Str::random(64);

        // Delete any existing tokens for the provided email
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Insert a new password reset token into the table
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Send the reset password email
        Mail::send('admin.auth.forgetpassword.email', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        // Redirect to the login form with a success message
        return redirect()->route('login.form')->with('success', 'A reset password email has been sent.');
    }
    public function showresetpasswordform($token)
    {
        return view('admin.auth.forgetpassword.resetpassword', ['token' => $token]);
    }


    public function submitresetpasswordform(Request $request)
    {
        // Validate the request input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed', // Ensures the password matches password_confirmation
        ]);
    
        // Check if the token exists for the provided email
        $updatePassword = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token,
        ])->first();
    
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token or email.');
        }
    
        // Update the admin password
        Admin::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);
    
        // Delete the token after successful password reset
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
    
        // Redirect to the login form with a success message
        return redirect()->route('login.form')->with('success', 'Your password has been reset successfully.');
    }
    

}
