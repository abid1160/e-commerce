<?php
namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{   
    // Display cart
// In CartController

public function cart()
{
    if (Auth::guard('user')->check()) {
        // Get the authenticated user
        $user = Auth::guard('user')->user();
        $cartItems = $user->carts;
         // Fetch the user's cart items
        // Sum the quantities of items in the cart
        return view('home.user.cart', compact('cartItems'));
    }  

    
}


    // Add to cart
    public function addToCart($id)
    {
         

        $product = Product::with('images')->find($id);

        if ($product == null) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ]);
        }

        if (Auth::guard('user')->check()) {
            // For logged-in users, add the product to the database cart table
            $cart = Auth::guard('user')->user()->carts()->where('product_id', $product->id)->first();

            if ($cart) {
                // Product already exists, increment quantity
                $cart->quantity += 1;
                $cart->save();
                // $message = $product->product_name . ' quantity updated in the cart.';
                return redirect()->route('user.cart');
            } else {
                // Add new product to cart
                Auth::guard('user')->user()->carts()->create([
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'image' => $product->images->first() ? $product->images->first()->image_path : null,
                ]);
                return redirect()->route('user.cart');
            }

            return response()->json([
                'status' => true,
                'message' => $message,
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'You need to be logged in to add to the cart.',
        ]);
    }

    // Remove from cart
    public function removeFromCart(Request $request)
    {
        // Get the product ID from the request
        $productId = $request->id;
    
        // Validate the product ID
        if (!$productId) {
            return response()->json([
                'status' => false,
                'message' => 'Product ID is required.',
            ]);
        }
    
        // Check if the user is authenticated
        $user = Auth::guard('user')->user();
    
        if ($user) {
            // For logged-in users, remove the item from the cart table
            $cart = $user->carts()->where('product_id', $productId)->first();
    
            if ($cart) {
                $cart->delete();
    
                return response()->json([
                    'status' => true,
                    'message' => 'Product removed from the cart successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found in your cart.',
                ]);
            }
        }
    
        // If user is not authenticated
        return response()->json([
            'status' => false,
            'message' => 'User is not authenticated.',
        ]);
    }
    
    

    // Update cart
    public function updateCart(Request $request)
    {
        $productId = $request->id;
        $quantity = $request->quantity;



        if (Auth::guard('user')->check()) {
            // For logged-in users, update the cart in the database
            $cart = Auth::guard('user')->user()->carts()->where('product_id', $productId)->first();

            if ($cart && $quantity > 0) {
                $cart->quantity = $quantity;
                $cart->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Cart updated successfully.',
                ]);
            }
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid product or quantity.',
        ]);
    }
}
