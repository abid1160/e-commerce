<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    
    public function index()
    {
        return view('admin.order.list');
    }
      
    public function data()
    {
        // Load user, orderItems, product, and product images
        $orders = Order::with(['user', 'orderItems.product.images', 'address'])->get();
    
        return DataTables::of($orders)->make(true);
}
public function delete($id)
{
    $order = Order::findOrFail($id);
    $order->delete();

    return response()->json(['message' => 'Order deleted successfully!']);
}


//here we update the shipping status
public function updateStatus(Request $request, $id)
{
    


    $order = Order::find($id);
 
    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    $order->status = $request->status;
    $order->save();

    return response()->json(['message' => 'Order status updated successfully']);
}

public function orderDetail($id) {
    // Fetch the product by its ID with its relationships, including discount
    $Product = Product::with(['subcategory', 'category', 'images', 'discount'])->findOrFail($id);
 
 

    // The discount can be accessed directly via $Product->discount
    return view('admin.Products.detail', compact('Product'));
}


}
