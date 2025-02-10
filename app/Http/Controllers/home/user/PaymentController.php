<?php
namespace App\Http\Controllers\home\user;

use App\Http\Controllers\Controller;
use App\Models\Address;  
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;  
use Illuminate\Http\Request;
 

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $shippingid = $request->address_id;  
        $amount = $request->total_price;
        return view('home.user.payment', compact(['amount', 'shippingid']));
    }

    public function charge(Request $request)
    {
    
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        try {
            // Process the payment with Stripe
            $charge = \Stripe\Charge::create([
                'amount' => $request->amount * 100, // Convert to cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment for Order #' . $request->shipping_id,
            ]);
             
             

            // Create an Order record
            $order = Order::create([
                'user_id' => Auth::id(),
                'address_id' => $request->shipping_id,
                'total_price' => $request->amount,
                'payment_status' => 'Paid',
                'payment_id' => $charge->id,
                'shipping_address'=>Address::where('id',$request->shipping_id)->first()->address,
                 'image_path'=>'null',
              

            ]);

            // Retrieve the cart items before deleting
            $cartItems = Cart::where('user_id', Auth::id())->get();

            // Insert cart items into OrderItem table
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price, // Ensure your Cart model has 'price'
                    
                ]);
            }

            // Clear the user's cart after order is placed
            Cart::where('user_id', Auth::id())->delete();

            return view('home.user.success');

        } catch (Exception $e) {
            return back()->with('error', 'Payment failed. Please try again.');
        }
    }
}



    
      

    

    
    
   
    //after payment suceessfull

   

