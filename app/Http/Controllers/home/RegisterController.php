<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('home.auth.register');
    }
    public function register(Request $request)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|numeric|digits_between:10,15|unique:users', // Specify the table for unique validation
            // Validation for the address
            'label' => 'nullable|string', // Optional 'label' field
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
        ]);
    
        // Create the user
        $user = User::create([ // Use the correct model (User instead of Admin)
            'name' => $request->name,
            'email' => $request->email,
            'phone_number'=>$request->phone_number,
            'password' => Hash::make($request->password),
        ]);
    
        // Create the address for the user
        $address = Address::create([
            'user_id' => $user->id,
            'address' => $request->address,
            'label' => $request->label, // Nullable, so this can be left out if not provided
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'country' => $request->country,
        ]);
    
        // Log the user in after registration
        auth()->login($user);
    
        // Redirect to the login form or another page
        return redirect()->route('user.login.form'); 
    }
    
}
