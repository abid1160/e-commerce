<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.Products.category');
    }
    
    // Fetch employee data for DataTable
    public function data()
    {
        $categories = Category::query()->get(); 
    
        return Datatables::of($categories) 
            ->addColumn('action', function($category) { 
                $editButton =  "<a href='".route('admin.product.category.edit',Crypt::encryptString($category->id))."' class='btn-sm btn-warning' data-toggle='tooltip' title='Edit Product category'><i class='fas fa-edit'></i></a>";
    
                $deleteButton = '<a href="javascript:void(0);" onclick="deleteProductCategory(\'' . $category->id . '\')" class="btn btn-sm btn-delete" data-toggle="tooltip" title="Delete product category"><i class="fas fa-trash"></i></a>'; 
    
                return $editButton . ' ' . $deleteButton;
            })
            ->rawColumns(['action']) 
            ->toJson();
    }

    // add new category form

   public function add(){
    return view('admin.Products.categoryform');
   }

   //insert the category
   public function insert(Request $request){

    $customMessages = [
        'image.required' => 'The profile picture is required.',
        'image.image' => 'The profile picture must be a jpeg, png, or jpg image.',
        'image.mimes' => 'The profile picture must be a jpeg, png, or jpg image.',
        'image.max' => 'The profile picture must not exceed 2MB.',
    ];

    $request->validate([
        
    'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],
        'description' => 'required|string',
        
        'image'=>'mimes:jpeg,jpg',
         
    ],$customMessages);
    
    

 
    $fileName = null;
    if ($request->hasFile('image')) {
        $imageFile = $request->file('image');
        $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
    
        // Move the uploaded file to the desired folder
        $imageFile->move(public_path('uploads/categoryimage'), $fileName);
    }

    
    
    Category::create([
        'name' => $request->name,
       
        'description' => $request->description,
      
        'image'=>$fileName,
    ]);
    session()->flash('success', 'category has been successfully added.');
    // Redirect with success message
    return redirect()->back();
}



//here we delete the category
public function delete($id, Request $request)
{
    try {
        $employee = Category::findOrFail($id);
        $employee->delete();

        if ($request->ajax()) {
            return response()->json(['success' => 'Employee has been successfully deleted.']);
        }

        return redirect()->route('admin.product.category.list')->with('success', 'Employee has been successfully deleted.');
    } catch (\Exception $e) {
        if ($request->ajax()) {
            return response()->json(['error' => 'Failed to delete the employee.'], 500);
        }

        return redirect()->route('admin.product.category.list')->with('error', 'Failed to delete the employee.');
    }
}
    

//here edit the category
public function edit($id)
    {
        $id = Crypt::decryptString($id);

        $category= Category::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.Products.categoryeditform', compact('category'));
    }


    //with this code we can update the category
    public function update(Request $request)
    {
        // Define custom validation messages
        $request->validate([
          
            'name'=>'required',
             'description'=>'required',   
            'image'=>'mimes:jpg,jpeg',
          
        ]);
        
    
        // Find the employee
        $category = Category::findOrFail($request->category_id);
    
        // Handle profile image upload if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            $oldImagePath = public_path('uploads/categoryimage/' . $category->image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
    
            // Upload new image
            $imageFile = $request->file('image');
            $fileName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('uploads/categoryimage'), $fileName);
            $category->image = $fileName;
        }
    
        // Update employee data
        $category->update([
            'name'         => $request->name,
            'description'       => $request->description,
            
             
            'image' => $category->image ?? $category->profile_path,  // Keep existing if not updated
        ]);
    
        // Flash success message
        session()->flash('success', 'category has been successfully updated.');
    
        // Redirect back
        return redirect()->back();
    }
    
 
}
