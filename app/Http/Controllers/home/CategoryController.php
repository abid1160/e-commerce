<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('home.index', compact('categories'));
        
    }
}
