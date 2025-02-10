<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function showDashboard()

    {
        $userCount = User::count();
        $productcount=Product::count();
        $employee=Employee::all();
        $order=Order::all();  
        // $name = Auth::guard('admin')->user()->name;
        
        // Pass the user count to the view
        return view('admin.dashboard', compact(['userCount','productcount','employee','order']));
       
    }

    public function viewprofile()
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Pass the user to the view
        return view('admin.profile')->with('user', $user);
    }
    public function updateProfile(Request $request)
    {
        // Get the currently authenticated admin user
        $admin = Auth::guard('admin')->user();  // This retrieves the authenticated admin
    
        // Validate the incoming request data
        $request->validate([
       
    'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id, // Ensure the email is unique except for the current user's email
            'phone_number' => [
                'required',
                'digits:10', // Ensures phone number is exactly 10 digits
                'unique:users,phone_number', // Ensures the phone number is unique
            ],
        ], [
            'phone_number.digits' => 'Phone number must be exactly 10 digits.',
            'phone_number.unique' => 'This phone number is already registered.',
        ]);
        

        // Update the logged-in admin's data
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone_number = $request->phone_number;

        // Save the updated admin data
        $admin->save();

        // Redirect back with a success message
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }


    //total user code

   

    // Get the total number of users
 
//change password

public function changepasswordform(){
    return view('admin.auth.changepassword');
}

//change password

public function changePassword(Request $request)
{

     
    // Validate input
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $admin = Auth::guard('admin')->user(); // Get the currently authenticated user

    // Check if the old password matches
    if (!Hash::check($request->old_password, $admin->password)) {
        return back()->withErrors(['old_password' => 'The old password does not match.']);
    }

    // Update the password
    $admin->password = Hash::make($request->new_password);
    $admin->save();

    return back()->with('success', 'Your password has been successfully changed.');
}

}
