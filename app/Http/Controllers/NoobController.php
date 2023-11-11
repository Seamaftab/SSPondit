<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class NoobController extends Controller
{
    function welcome()
    {
        $products = Product::latest()->paginate(12);
        $colors = Color::pluck('name','id')->toArray();

        return view('welcome', compact('products', 'colors'));
    }
    function categoryWiseProducts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(12);
        $colors = Color::pluck('name','id')->toArray();
        
        return view('welcome', compact('products', 'colors'));
    }
    function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $colors = Color::pluck('name','id')->toArray();
        $comments = $product->comments;

        return view('product_details', compact('product', 'colors', 'comments'));
    }
    function home()
    {
        return view('home');
    }

    function about()
    {
        return view('about');
    }

    function contact()
    {
        return view('contact');
    }

    function users()
    {
        $users = User::all();

        return view('users',['users' => $users]);

        //return view('users',compact("users"));
    }
}
