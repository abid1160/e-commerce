<?php

namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Image;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{


    public function checkout()
    {
        // Check if the user is authenticated
        if (Auth::guard('user')->check()) {
            // Get the authenticated user
            $user = Auth::guard('user')->user();
            $cartItems = $user->carts()->with('product')->get();
            
               
            
            // Now $quantities contains all item quantities
        
            
            
            
            // Fetch the address related to the authenticated user
            $id = $user->id;
            $address = Address::where('user_id', $id)->first();  // Use first() instead of findOrFail()
    
            if ($address) {
                // If address found, return the view

                return view('home.user.addressdetail', compact('user', 'address','cartItems'));
            } else {
                // If no address found, return a JSON response with a status message
                return response()->json([
                    'status'  => false,
                    'message' => 'Address not found',
                ]);
            }
        } else {
            // If the user is not authenticated, redirect to the login page
            return redirect()->route('user.login.form')->with('error', 'Please log in to proceed with the checkout.');
        }
    }


    public function addressmodal(Request $request){
        $request->validate([
            // Specify the table for unique validation
            // Validation for the address
            'label' => 'nullable|string', // Optional 'label' field
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
        ]);
        
       $user=Auth::guard('user')->user();

     
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

    return redirect()->route('user.checkout');
}
    
      //get order and send to the database

      public function orderDetail($userId, $addressId, Request $request)
      {
           
          $cartItems = $request->input('cartItems');
          
          // You can loop over the cartItems and perform actions like creating orders, etc.
           
        foreach ($cartItems as $item) {
            Order::create([
                'user_id' => $userId,
                'product_id' => $item['product_id'],
                'address_id' => $addressId,
                'quantity' => $item['quantity'],
                'total_price' => $item['total_price'],
                'status' => 'pending', // Default status
            ]);
        }

        return redirect()->route('user.checkout')->with('success', 'Order placed successfully!');
      }
      

  // view order
 

 
 
//view order

public function viewOrders()
{
    $user = Auth::guard('user')->user();

    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    $userid = $user->id;

    // Retrieve the authenticated user's orders
    $orders = Order::where('user_id', $userid)->get();

    if ($orders->isEmpty()) {
         return redirect()->route('user.orderdetail');
    }

    $orderDetails = [];

    foreach ($orders as $order) {
        // Retrieve order items for the current order
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        foreach ($orderItems as $orderItem) {
            // Retrieve the product for the current order item
            $product = Product::where('id', $orderItem->product_id)->first();

            if ($product) {
                // Retrieve the image for the current product
                $image = Image::where('product_id', $product->id)->first();
       
                // Add details to the result array
                $orderDetails[] = [
                    'order' => $order,
                    'orderItem' => $orderItem,
                    'product' => $product,
                    'image' => $image,
                    
                ];
            }
        }
    }

    if (empty($orderDetails)) {
        return response()->json(['error' => 'No order details found'], 404);
    }

    return view('home.user.order', compact('orderDetails'));
}
      //delete the order
      
      public function delete(Request $request,$id){

        $order=Order::where('id',$request->id);
        $order->delete();
        return redirect()->back();

      }
    
}

  