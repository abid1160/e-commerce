<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
  
class DiscountController extends Controller
{
    public function index()
    {
        return view('admin.discount.list');
    }

    public function data() {
        $discounts = Discount::with(['user', 'product'])->get(); // Fixed relationship name
    
        return datatables()->of($discounts)
            ->addColumn('action', function($discount) {
                // Edit button
                $editButton = "<a href='" . route('admin.discount.edit', Crypt::encryptString($discount->id)) . "' class='btn btn-sm btn-warning' data-toggle='tooltip' title='Edit Discount'><i class='fas fa-edit'></i></a>";
    
                // Delete button
                $deleteButton = '<button class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Discount" onclick="deleteDiscount(' . $discount->id . ')"><i class="fas fa-trash-alt"></i></button>';
    
                return $editButton . ' ' . $deleteButton;
            })
            ->addColumn('user', function($discount) {
                return $discount->user?->name ?? 'N/A'; // Handles null values
            })
            ->addColumn('product', function($discount) {
                return $discount->product?->product_name ?? "No Product Assigned"; // Handles null values
            })
            ->toJson();
    }
    
   
    //discount form
    public function create()
{
    $users = User::all();
    $products = Product::with('category')->get();
    return view('admin.discount.create', compact('users', 'products'));
}

    

    //store the discount
    public function store(Request $request)
    {
        // return $request;
        // Validate input data
        $request->validate([
            'type' => 'required|in:percentage,fixed',
            'amount' => 'required|numeric|min:0', // Amount should be numeric and at least 0
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date|after_or_equal:valid_from',
            'active' => 'sometimes|boolean', // 'sometimes' allows checkbox unchecked cases
            'user_id' => 'nullable|exists:users,id', // Ensure user exists
            'product_id' => 'nullable|exists:products,id', // Ensure product exists
        ]);

        // Store the discount in the database
        Discount::create([
            'type' => $request->type,
            'value' => $request->amount, // Ensure it matches the form field
            'start_date' => $request->valid_from ? Carbon::parse($request->valid_from) : null,
            'end_date' => $request->valid_to ? Carbon::parse($request->valid_to) : null,
            'active' => $request->has('active') ? true : false, // Handle checkbox cases
            'user_id' => $request->user_id, // Assign user_id if selected
            'product_id' => $request->product_id, // Assign product_id if selected
        ]);

        // Redirect back with a success message
        return redirect()->route('admin.discount.list')->with('success', 'Discount added successfully.');
    }

//delete the discount
public function delete($id)
{
    $discount= Discount::findOrFail($id);
    $discount->delete();

    return response()->json(['message' => 'Order deleted successfully!']);
}
//edit the discount
public function edit($id) {
    $id = Crypt::decryptString($id);
    $discount = Discount::findOrFail($id);
    $users = User::all();
    $products = Product::with('category')->get();

    return view('admin.discount.edit', compact('discount', 'users', 'products'));
}

//update the discount
public function update(Request $request)
{
    // Decrypt the ID
     

    // Validate the request
    $request->validate([
        'user_id' => 'nullable|exists:users,id',
        'product_id' => 'nullable|exists:products,id',
        'type' => 'required|in:percentage,fixed',
        'value' => 'required|numeric|min:1',
        'start_date' => 'required|date|before_or_equal:end_date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'is_active' => 'required|boolean',
    ]);

    // Find and update the discount
    Discount::findOrFail($request->discount_id)->update([
        'user_id' => $request->user_id,
        'product_id' => $request->product_id,
        'type' => $request->type,
        'value' => $request->value,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'is_active' => $request->is_active,
    ]);

    return redirect()->route('admin.discount.list')->with('success', 'Discount updated successfully.');
}



}
