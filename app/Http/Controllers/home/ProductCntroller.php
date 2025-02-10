<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCntroller extends Controller
{
    public function product($category_id, $subcategory_id)
    {
        // Fetch products with images
        $products = Product::where([
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
        ])->with('images')->get();
    
        // Get all product IDs
        $productIds = $products->pluck('id');
         
        // Fetch discounts for those products
        $discounts = Discount::whereIn('product_id', $productIds)->get();
        

         
    
        return view('home.product.product', compact('products', 'discounts'));
    }
    
    
    
}
