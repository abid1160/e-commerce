<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables; 

class UserController extends Controller
{
    public function userList()
    {
    

        return view('admin.user.user');
    }
    public function data() 
    {
        $users = User::all();
    
        return datatables()->of($users)
            ->addColumn('action', function($user) {
                // Edit button
                // $editButton = '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit User" onclick="editUser(' . $user->id . ')"><i class="fas fa-edit"></i></button>';

                $editButton = "<a href='".route('admin.user.edit',Crypt::encryptString($user->id))."' class='btn-sm btn-warning' data-toggle='tooltip' title='Edit User'><i class='fas fa-edit'></i></a>";
                // Delete button
                $deleteButton = '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete User" onclick="deleteUser(' . $user->id . ')"><i class="fas fa-trash-alt"></i></button>';
    
                // Combine both buttons
                return $editButton . ' ' . $deleteButton;
            })
            ->toJson();
    }
    
    public function adduserform()
    {

        return view('admin.user.adduser');
    }

    public function addusersubmit(Request $request)

    {
   
        $request->validate([
            
    'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
            'email' => 'required|email|unique:users,email', // Ensure email is unique
            'password' => 'required|min:8', // Password confirmation
            'phone_number' => [
                'required',
                'digits:10', // Ensures phone number is exactly 10 digits
                'unique:users,phone_number', // Ensures the phone number is unique
            ],
        ], [
            'phone_number.digits' => 'Phone number must be exactly 10 digits.',
            'phone_number.unique' => 'This phone number is already registered.',
        ]);
        
    
        // Create a new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
        ]);
    
        // Flash success message
        session()->flash('success', 'User has been successfully registered.');
    
        // Redirect to the appropriate route
        return redirect()->route('admin.user.form');
    }
    
    

    //delete the user

    public function delete($id)
    {
        // Find the product by ID and delete it
        $users = User::findOrFail($id);
        session()->flash('success', 'user deleted successfully');
        $users->delete();
    
        // Check if the deletion was successful
        if ($users) {
            // Return a success response for AJAX
            session()->flash('success', 'user deleted successfully');
            return response()->json(['success' => true, 'message' => 'user has been successfully deleted.']);
        } else {
            // Return an error response if something went wrong
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting the user.']);
        }
    }


    //user edit form
    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $user = User::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.user.useredit', compact('user'));
    }

     
    public function update(Request $request)
    {
     
     $userid=$request->user_id;
     
        // return $request;
        // Validate the incoming request
  
            
     
        

        // Find the user and update their details
        $user = User::findOrFail($userid);
       
        
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->password),
            'phone_number' => $request->input('phone_number'),
            // Optional: admin/user roles
        ]);
        session()->flash('success', 'user updated successfully');
        // Redirect with success message
        return redirect()->back();
    }


    //search the user
    public function usersearch(Request $request)
{
    // Get the search query from the request
    $search = $request->get('search');

    // Query the users, apply the search filter if a search query exists
    $users = User::where('name', 'like', '%' . $search . '%')
                 ->orWhere('email', 'like', '%' . $search . '%') // If you want to search by email as well
                 ->get();

    return view('admin.user.user', compact('users'));
}




//ajax for the check
 
    public function checkUserExists(Request $request)
    {
        // Get email and phone number from the request
        $email = $request->input('email');
        $phone = $request->input('phone_number');

        // Check if the email exists
        $emailExists = User::where('email', $email)->exists();

        // Check if the phone number exists
        $phoneExists = User::where('phone_number', $phone)->exists();

        // Return a JSON response
        return response()->json([
            'email_exists' => $emailExists,
            'phone_exists' => $phoneExists,
        ]);
    }



}
