<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function list($category_id){
        $category = Category::findOrFail($category_id);
        $subcategory = Subcategory::where('category_id', $category_id)->get();
     

        return view('home.subcategory.subcategory',compact(['category','subcategory']));
    }
}
