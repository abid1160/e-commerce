<?php

namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show(){
        $categories = Category::all();
        return view('home.index',compact('categories'));
    }
    public function profile()
    {
        // Get the currently authenticated user
        $user = Auth::guard('user')->user();
        
        // Fetch the first address related to the user (if exists)
        $address = Address::where('user_id', $user->id)->first(); 
    
        // If you want to check if an address exists or not, you can return a default message
        $address = $address ?? null;
    
        // Pass user details and address to the profile view
        return view('home.user.profile', compact('user', 'address'));
    }
    
    
    
}
