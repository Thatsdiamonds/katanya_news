<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories',
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
