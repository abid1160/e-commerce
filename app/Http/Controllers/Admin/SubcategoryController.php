<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;  
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class SubcategoryController extends Controller
{
    public function index()

    {
      
        return view('admin.Products.subcategory.list');
    }
    
    // Fetch employee data for DataTable
    public function data()
    {
       
        $subcategories = Subcategory::with('category')->get();
        return DataTables::of($subcategories)->addColumn('action', function($subcategory) {
            // Edit button
            // $editButton = '<button class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit User" onclick="editUser(' . $user->id . ')"><i class="fas fa-edit"></i></button>';

            $editButton = "<a href='".route('admin.product.subcategory.edit',Crypt::encryptString($subcategory->id))."' class='btn-sm btn-warning' data-toggle='tooltip' title='Edit Subcategory'><i class='fas fa-edit'></i></a>";
            // Delete button
            $deleteButton = '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete User" onclick="deleteProduct(' . $subcategory->id . ')"><i class="fas fa-trash-alt"></i></button>';

            // Combine both buttons
            return $editButton . ' ' . $deleteButton;
        })
        ->toJson();
    }
  
    //code for add the subcategory

    public function insert(Request $request){
  
        $customMessages = [
            'image.required' => 'The profile picture is required.',
            'image.image' => 'The profile picture must be a jpeg or jpg image.',
            'image.mimes' => 'The profile picture must be a jpeg or jpg image.',
            'image.max' => 'The profile picture must not exceed 20MB.',
        ];
        
        $request->validate([
            'name' => 'required',
            'description' => 'string|required',
            'image' => 'mimes:jpeg,jpg|max:20240', // 10MB limit
            'category_id' => 'required',
        ], $customMessages);
        
        
        
        
    
     
        $fileName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
        
            // Move the uploaded file to the desired folder
            $imageFile->move(public_path('uploads/subcategoryimage'), $fileName);
        }
    
        
        
        Subcategory::create([
            'name' => $request->name,
           
         'description' => $request->description ,

          
            'image'=>$fileName,
            'category_id'=>$request->category_id,
        ]);
        session()->flash('success', 'subcategory has been successfully added.');
        // Redirect with success message
        return redirect()->back();
    }
    
    
    
    public function add(){
        $categories=Category::all();
        return view('admin.Products.subcategory.add')->with('categories',$categories);
       }

       //insert in the sub category table

         

    public function delete($id, Request $request)
{
    try {
        $employee = Subcategory::findOrFail($id);
        $employee->delete();

        if ($request->ajax()) {
            return response()->json(['success' => 'subcategory has been successfully deleted.']);
        }

        return redirect()->route('admin.product.subcategory.insert')->with('success', 'Employee has been successfully deleted.');
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json(['error' => 'Failed to delete the employee.'], 500);
        }

        return redirect()->route('admin.product.subcategory.list')->with('error', 'Failed to delete the employee.');
    }
}
    
   
public function edit($id)
{
    $id = Crypt::decryptString($id);
    $subcategory = Subcategory::with('category')->findOrFail($id);
    $categories=Category::all();
    // Return the edit view with the subcategory data
    return view('admin.Products.subcategory.edit', compact(['subcategory','categories']));
}
   


//code for the update
public function update(Request $request)
{
    // Define custom validation rules and messages
    $request->validate([
        'name'        => 'required',
        'description' => 'required',
        'image'       => 'nullable|mimes:jpg,jpeg,png|max:20024', // Optional and must be a valid image file
    ]);

    // Find the subcategory
    $subcategory = Subcategory::findOrFail($request->subcategory_id);

    // Handle image upload if provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        $oldImagePath = public_path('uploads/subcategoryimage/' . $subcategory->image);
        if (file_exists($oldImagePath) && $subcategory->image) {
            unlink($oldImagePath);
        }

        // Upload new image
        $imageFile = $request->file('image');
        $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->move(public_path('uploads/subcategoryimage'), $fileName);
        $subcategory->image = $fileName;
    }

    // Update subcategory data
    $subcategory->update([
        'name'        => $request->name,
        'description' => $request->description,
        'image'       => $subcategory->image, // Update with new image or keep the existing one
    ]);

    // Flash success message
    session()->flash('success', 'subcategory has been successfully updated.');
    return redirect()->back();
}

}
