<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request, $productSlug)
    {
        $product = Product::where('slug', $productSlug)->firstOrFail();

        $user_id = auth()->user()->id;

        $product->comments()->create([
            'body' => $request->body,
            'user_id' => $user_id,
        ]);

        $comments = $product->comments;

        return view('product_details', compact('product', 'comments'));
    }

}
