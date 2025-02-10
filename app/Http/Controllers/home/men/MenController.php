<?php

namespace App\Http\Controllers\home\men;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;    

class MenController extends Controller
{
    
    public function menjeans($category_id, $subcategory_id)
    {
        // Fetch products based on category and subcategory IDs with their images
        $products = Product::where([
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
        ])->with('images')->get();
    
        // Pass products to the view
        return view('home.subcategory.man.jeans', compact('products'));
    }
    
}
