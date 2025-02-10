<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;


class EmployeeController extends Controller
{
    public function index()
    {
        return view('admin.employee.list');
    }

    // Fetch employee data for DataTable
    public function data()
    {
        $employees = Employee::all();
    
        return Datatables::of($employees)
            ->addColumn('action', function($employee) {
                $editButton = '<a href="' . route('admin.employee.edit', Crypt::encryptString($employee->id)) . '" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit employee"><i class="fas fa-edit"></i></a>';
    
                $deleteButton = '<a href="javascript:void(0);" onclick="deleteEmployee(\'' . Crypt::encryptString($employee->id) . '\')" class="btn btn-sm btn-delete" data-toggle="tooltip" title="Delete employee"><i class="fas fa-trash"></i></a>';
    
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action']) // Important: Mark 'action' column as raw HTML
            ->toJson(); 
    }

    
    


    public function addemployeeform()
    {

        return view('admin.employee.add');
    }


    public function employeeinsert(Request $request)
    {

        $customMessages = [
            'profile.required' => 'The profile picture is required.',
            'profile.image' => 'The profile picture must be a jpeg, png, or jpg image.',
            'profile.mimes' => 'The profile picture must be a jpeg, png, or jpg image.',
            'profile.max' => 'The profile picture must not exceed 2MB.',
        ];

        $request->validate([

            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
            'salary' => 'required|numeric',
            'city' => 'required|string',
            'role' => 'required|string',
            'profile' => 'mimes:jpeg,jpg',
            'phone_number' => [
                'required',
                'unique:employees,phone_number', // Ensure the phone number is unique in the employees table
                'regex:/^\d{10}$/', // Exactly 10 digits
            ],
        ], [
            'phone_number.regex' => 'Phone number must be exactly 10 digits long.',
            'phone_number.unique' => 'This phone number is already registered.',
        ], $customMessages);




        $fileName = null;
        if ($request->hasFile('profile')) {
            $imageFile = $request->file('profile');
            $fileName = time() . '.' . $imageFile->getClientOriginalExtension();

            // Move the uploaded file to the desired folder
            $imageFile->move(public_path('uploads/employeeimage'), $fileName);
        }

        Employee::create([
            'name' => $request->name,
            'salary' => $request->salary,
            'city' => $request->city,
            'role' => $request->role,
            'phone_number' => $request->phone_number,
            'profile_path' => $fileName,
        ]);
        session()->flash('success', 'employee has been successfully added.');
        // Redirect with success message
        return redirect()->back();
    }
    public function delete($id)
    {
        $id = Crypt::decryptString($id); // Decrypt ID
        $employee = Employee::findOrFail($id);
        $employee->delete();
    
        return response()->json(['success' => 'Employee deleted successfully!']);
    }




    //edit form for the employee
    public function edit($id)
    {

        $id = Crypt::decryptString($id);
      
        $employee = Employee::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.employee.edit', compact('employee'));
    }

    //update the employee
    public function update(Request $request)
    {
        // Define custom validation messages
        $request->validate([

            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
            'salary' => 'required|numeric',
            'city' => 'required|string',
            'role' => 'required|string',
            'profile' => 'mimes:jpg,jpeg',
            'phone_number' => [
                'required',
                // Ensure the phone number is unique in the employees table
                'regex:/^\d{10}$/', // Exactly 10 digits
            ],
        ], [
            'phone_number.regex' => 'Phone number must be exactly 10 digits long.',
            'phone_number.unique' => 'This phone number is already registered.',
        ]);


        // Find the employee
        $employee = Employee::findOrFail($request->employee_id);

        // Handle profile image upload if provided
        if ($request->hasFile('profile')) {
            // Delete the old image if it exists
            $oldImagePath = public_path('uploads/employeeimage/' . $employee->profile_path);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            // Upload new image
            $imageFile = $request->file('profile');
            $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('uploads/employeeimage'), $fileName);
            $employee->profile_path = $fileName;
        }

        // Update employee data   
        $employee->update([
            'name'         => $request->name,
            'salary'       => $request->salary,
            'city'         => $request->city,
            'role'         => $request->role,
            'phone_number' => $request->phone_number,
            'profile_path' => $employee->profile_path ?? $employee->profile_path,  // Keep existing if not updated
        ]);

        // Flash success message
        session()->flash('success', 'Employee has been successfully updated.');

        // Redirect back
        return redirect()->back();
    }



    //ajax for the phone number
    public function checkPhoneNumber(Request $request)
    {
        $phone_number = $request->input('phone_number');

        $exists = Employee::where('phone_number', $phone_number)->exists();

        return response()->json(['phone_exists' => $exists]);
    }
}
