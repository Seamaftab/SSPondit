<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ColorsController extends Controller
{

    public function index()
    {
        $colors = Color::all();
        return view('admin.pages.colors.index', compact('colors'));
    }

    public function create()
    {
        return view('admin.pages.colors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|unique:colors|max:25',
            'hex' => 'nullable|max:7',
        ]);

        $name = $request->name;

        Color::create([
            'name'=>$request->name,
            'slug'=>Str::slug($name),
            'hex' => $request->hex ?? '#000000'
        ]);

        return redirect()->route('colors.index')->with('success', 'New Color ID Created');
    }

    public function show(string $color)
    {
        $color = Color::findOrFail($color);
        return view('admin.pages.colors.show');
    }

    public function edit(string $color)
    {
        $color = Color::findOrFail($color);
        return view('admin.pages.colors.edit', compact('color'));
    }

    public function update(Request $request, string $color)
    {
        $color = Color::find($color);

        $request->validate([
            'name'=> ['required','max:25', Rule::unique('colors')->ignore($color)],
            'hex' => 'nullable|max:7',
        ]);

        $name = $request->name;

        $color->update([
            'name'=> $request->name,
            'slug'=> Str::slug($name),
            'hex' => $request->hex ?? $color->hex
        ]);

        return redirect()->route('colors.index')->with('info','Color ID information Updated');
    }

    public function destroy(string $color)
    {
        $color = Color::findOrFail($color);
        $color->delete();

        return redirect()->route('colors.index')->with('info', 'Color ID Deleted');
    }
}
