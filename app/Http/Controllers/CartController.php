<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = auth()->user()->cartproducts()->with('color');
        // dd($cart);

        return view('cartproducts', compact('cart'));
    }

    public function store(Request $request)
    {
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $color_id = $request->color;

        $cart = auth()->user()->cartProducts()->where('product_id', $product_id)->where('color_id', $color_id)->first();

        if($cart)
        {
            $quantity += $cart->quantity;
            $cart->update([
                'quantity'=> $quantity
            ]);
        }
        else
        {
            auth()->user()->cartProducts()->create([
                'user_id' => auth()->id(),
                'product_id' => $product_id,
                'quantity' => $quantity,
                'color_id' => $color_id,
            ]);
        }

        // dd($request->all());
        
        return redirect()->back()->with('info', 'added to cart');

    }

    public function update(Request $request, $cart)
    {
        $cartProduct = auth()->user()->cartProducts()->find($cart);
        $quantity = $request->quantity;

        if($cartProduct) 
        {
            $cartProduct->update([
                'quantity' => $quantity,
            ]);

            return redirect()->route('carts.index')->with('success', 'Quantity updated successfully.');
        }

        return redirect()->route('carts.index')->with('error', 'Failed to update quantity.');
    }

    public function destroy($cart)
    {

        try
        {
            auth()->user()->cartProducts()->where('id', $cart)->delete();

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Cart Item has been removed'
                ]
            );
        }
        catch(\Exception $e)
        {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ]
            );
        }
    }
}
