<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('genre')->latest()->paginate(10);
        return view('admin.pages.products.index', compact('products'));
    }

    public function create()
    {
        $genre = Category::all();
        $colors = Color::pluck('name', 'id')->toArray();
        return view('admin.pages.products.create', compact('genre','colors'));
    }

    public function store(ProductRequest $request)
    {
        //dd($request->all());
        $validatedData = $request->validated();

        $imagePath = '';

        if ($request->hasFile('image')) 
        {
            $timestamp = now()->format('Y_m_d_H_i_s');
            $extension = $request->file('image')->getClientOriginalExtension();
            $imagePath = 'public/products/' . $timestamp . '.' . $extension;
            $request->file('image')->storeAs('public/products', $timestamp . '.' . $extension);
            $imagePath = asset('storage/products/' . $timestamp . '.' . $extension);
        }

        $title = $validatedData['title'];

        $product = Product::create([
            'serial' => $validatedData['serial'],
            'title' => $validatedData['title'],
            'slug' => Str::slug($title),
            'price' => $validatedData['price'],
            'category' => $validatedData['genre'],
            'image' => $imagePath,
            'description' => $validatedData['description'],
            'is_active' => boolval($validatedData['is_active'] ?? false),
        ]);

        $product->colors()->attach($request->color_ID);

        return redirect()->route('products.index')->with('success', 'product added successfully');
    }

    public function show($id)
    {
        $genre = Category::all();
        $product = Product::with('colors', 'genre')->find($id);
        return view('admin.pages.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $genre = Category::all();
        $colors = Color::pluck('name', 'id')->toArray();
        $selectedColors = $product->colors->pluck('id')->all();

        return view('admin.pages.products.edit', compact('product', 'genre', 'colors', 'selectedColors'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validated();

        $imagePath = $product->image;

        if ($request->hasFile('image')) 
        {
            $timestamp = now()->format('Y_m_d_H_i_s');
            $extension = $request->file('image')->getClientOriginalExtension();
            $imagePath = 'public/products/' . $timestamp . '.' . $extension;
            $request->file('image')->storeAs('public/products', $timestamp . '.' . $extension);
            $imagePath = asset('storage/products/' . $timestamp . '.' . $extension);
        }

        // dd($validatedData);
        $title = $validatedData['title'];

        $product->update([
            'serial' => $validatedData['serial'],
            'title' => $validatedData['title'],
            'slug' => Str::slug($title),
            'price' => $validatedData['price'],
            'category' => $validatedData['genre'], 
            'image' => $imagePath,
            'description' => $validatedData['description'],
            'is_active' => boolval($validatedData['is_active'] ?? false),
        ]);

        $product->colors()->sync($request->color_ID);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product sent to trash');
    }

    public function trash()
    {
        $this->authorize('deletion_of_product');
        
        $products = Product::onlyTrashed()->get();
        return view('admin.pages.products.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->restore();
        return redirect()->route('products.trash')->with('success', 'Product restored successfully');
    }

    public function delete($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->forceDelete();
        return redirect()->route('products.trash')->with('success', 'Product deleted successfully');
    }

}
