<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('admin.pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.pages.categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|unique:categories|max:255',
                'slug' => 'string',
                'description' => 'nullable',
            ]
        );

        $name = $validatedData['name'];

        Category::create([
            'name' => $validatedData['name'],
            'slug' => Str::slug($name),
            'description' => $validatedData['description'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function show(string $category)
    {
        $category = Category::findOrFail($category);
        return view('admin.pages.categories.show', compact('category'));
    }

    public function edit(string $category)
    {
        $category = Category::findOrFail($category);
        return view('admin.pages.categories.edit', compact('category'));

    }

 
    public function update(Request $request, string $category)
    {
        $category = Category::where('id', $category);

        $request->validate([
            'name' => 'required|string|max:255',
            //'slug' => 'string',
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(string $category)
    {
        $category = Category::findOrFail($category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
