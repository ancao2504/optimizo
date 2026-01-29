<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index(Request $request)
    {
        $query = BlogCategory::with('parent')
            ->withCount('posts')
            ->latest();

        if ($request->filled('language')) {
            $query->language($request->language);
        }

        $categories = $query->paginate(20)->withQueryString();

        // Fetch potential parents for the dropdown (only top-level)
        $pQuery = BlogCategory::whereNull('parent_id');
        if ($request->filled('language')) {
            $pQuery->language($request->language);
        }
        $parents = $pQuery->orderBy('name')->get();

        $languages = Language::active()->get();
        $type = 'blog';

        return view('admin.blog.categories.index', compact('categories', 'parents', 'languages', 'type'));
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'language_code' => 'required|string|max:10',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
            // Ensure slug is unique if generated
            $count = BlogCategory::where('slug', $validated['slug'])->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        BlogCategory::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'category' => BlogCategory::latest()->first()
            ]);
        }

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(BlogCategory $category)
    {
        $parents = BlogCategory::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->where('language_code', $category->language_code)
            ->orderBy('name')
            ->get();

        $languages = Language::active()->get();

        return view('admin.blog.categories.edit', compact('category', 'parents', 'languages'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, BlogCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug,' . $category->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'parent_id' => 'nullable|exists:blog_categories,id',
            'language_code' => 'required|string|max:10',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        if ($validated['parent_id'] == $category->id) {
            return back()->with('error', 'Category cannot be its own parent.');
        }

        $category->update($validated);

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(BlogCategory $category)
    {
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Cannot delete category with subcategories. Delete them first.');
        }

        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete category with associated posts.');
        }

        $category->delete();

        return redirect()->route('admin.blog.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * AJAX List for Post Editor
     */
    public function list()
    {
        return response()->json(BlogCategory::all());
    }
}
