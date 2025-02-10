<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function home(){
        $categories = Category::all();
        return view('home.index', compact('categories'));
    }
    
}
