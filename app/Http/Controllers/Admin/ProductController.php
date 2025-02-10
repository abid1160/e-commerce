<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(){
        return view('admin.Products.list');
    }
    public function data()
    {   
      
       
        $products = Product::with(['subcategory','category'])->get();
        return DataTables::of($products)->addColumn('action', function($product) {
            $editButton = '<a href="' . route('admin.product.edit', $product->id) . '" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit product"><i class="fas fa-edit"></i></a>';

            $deleteButton = '<a href="javascript:void(0);" onclick="deleteProduct(\'' . Crypt::encryptString($product->id) . '\')" class="btn btn-sm btn-delete" data-toggle="tooltip" title="Delete product"><i class="fas fa-trash"></i></a>';

            return $editButton . ' ' . $deleteButton;
        })
        ->rawColumns(['action']) // Important: Mark 'action' column as raw HTML
        ->toJson();
    }

    //product form

    public function create()
    {      
        $categories = Category::with('subcategories')->get(); 
       
        return view('admin.Products.add', compact('categories'));
    }


    //feth the subcategories

// Fetch Subcategories (Fixed)
public function getSubcategories($categoryId)
{

    
    $subcategories = Subcategory::where('category_id', $categoryId)->get();
    return response()->json($subcategories);
}


    public function productInsert(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'quantity' => 'required|numeric',
            'description' => 'required|array|min:1', // Ensure 'description' is an array and has at least one element
            'description.*' => 'string', // Validate each description item
            // Image validation
            'color' => 'required|array|min:1', // Ensure 'color' is an array and has at least one element
        'color.*' => 'string', // Validate each color item
        'size' => 'required|array|min:1', // Ensure 'size' is an array and has at least one element
        'size.*' => 'string', // Validate each size item
        ]);
    
        $descriptions = $request->input('description');
    
        // Process the $descriptions array (e.g., join values with a delimiter, store in database)
        $joined_descriptions = implode(', ', $descriptions);


        $colors = $request->input('color');
        $joined_colors = implode(', ', $colors);
    
        // Process the size array (e.g., join values with a delimiter, store in database)
        $sizes = $request->input('size');
        $joined_sizes = implode(', ', $sizes);
    
       
    
        // Create the new product record
        Product::create([
            'product_name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'quantity' => $request->quantity,
            'description' => $joined_descriptions,
            'color' => $joined_colors, // Save the joined colors
        'size' => $joined_sizes, // Save the joined sizes
         // Save the image path if uploaded
        ]);
    
        // Flash a success message to the session
        session()->flash('success', 'Product added successfully');
    
        // Redirect to a page showing the list of products or the created product page
        return redirect()->route('admin.product.list'); // Adjust the route as needed
    }
    

  
    //delete the product
    public function delete($id)
    {
        $id = Crypt::decryptString($id); // Decrypt ID
        $product = Product::findOrFail($id);
        $product->delete();
    
        return response()->json(['success' => 'Employee deleted successfully!']);
    }

  

    public function edit($id)
    {
        // Eager load the category relationship with subcategory
        $Product = Product::findOrFail($id);
     
        
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $descriptions = explode(', ', $Product->description);
    
        // Return the edit view with the product, categories, and subcategories data
        return view('admin.Products.edit', compact('Product', 'categories', 'subcategories','descriptions'));
    }

      // Update product details
      public function update(Request $request)
      {
          // Validate the incoming request
          $request->validate([
              'name' => 'required|string',
              'price' => 'required|numeric',
              'category_id' => 'required',   
              'subcategory_id'=>'required',
              'quantity' => 'required|numeric',
              'description' => 'required|array', // Ensure description has at least 3 items
        'description.*' => 'required|string',
          ]);
  
          // Find the product and update its details
          $product = Product::findOrFail($request->product_id);
          $descriptions = $request->input('description');
    $joined_descriptions = implode(', ', $descriptions);
          $product->update([
              'product_name' => $request->name,
              'price' => $request->price,
              'category_id' => $request->category_id,
              'subcategory_id' => $request->subcategory_id,
              'quantity' => $request->quantity,
              'description' => $joined_descriptions,
          ]);
  
          // Flash success message
          session()->flash('success', 'Product has been successfully updated.');
  
          // Redirect back
          return redirect()->route('admin.product.list');
      }


//code for the product detail

//view the product
public function productDetail($id) {

    
    // Fetch the product by its ID with its category and subcategory relationship
    $Product = Product::with(['subcategory', 'category','images'])->findOrFail($id);
    
    // Pass the product data to the view
    return view('admin.Products.detail', compact('Product'));
}

}    


