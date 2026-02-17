<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\BlogCategory;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['author', 'categories'])->latest();

        // Status counts for WordPress-style tabs
        $statusCounts = [
            'all' => Post::count(),
            'published' => Post::where('status', 'published')->count(),
            'draft' => Post::where('status', 'draft')->count(),
            'scheduled' => Post::where('status', 'scheduled')->count(),
        ];

        // Apply Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply Category Filter
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('blog_categories.id', $request->category_id);
            });
        }

        // Apply Language Filter
        if ($request->filled('language')) {
            $query->language($request->language);
        }

        $posts = $query->paginate(20)->withQueryString();
        $categories = BlogCategory::all();
        $languages = Language::active()->get();

        return view('admin.posts.index', compact('posts', 'categories', 'languages', 'statusCounts'));
    }

    public function create()
    {
        $categories = BlogCategory::all();
        $languages = Language::active()->get();
        return view('admin.posts.create', compact('categories', 'languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:posts,slug',
            'content' => 'required',
            'featured_image' => 'nullable|url',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'language_code' => 'required|string|max:10',
        ]);

        $validated['author_id'] = auth()->id();
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $post = Post::create($validated);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully!',
                'redirect' => route('admin.posts.index')
            ]);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        $categories = BlogCategory::all();
        $languages = Language::active()->get();
        $post->load(['categories']);

        return view('admin.posts.edit', compact('post', 'categories', 'languages'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'nullable|unique:posts,slug,' . $post->id,
            'content' => 'required',
            'featured_image' => 'nullable',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'categories' => 'nullable|array',
            'language_code' => 'required|string|max:10',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $post->update($validated);

        if ($request->has('categories')) {
            $post->categories()->sync($request->categories);
        } else {
            $post->categories()->detach();
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully!'
            ]);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully!'
            ]);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    public function publish(Post $post)
    {
        $post->update([
            'status' => 'published',
            'published_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post published successfully!'
        ]);
    }

    // AJAX endpoints for categories
    public function categoriesList(Request $request)
    {
        $query = BlogCategory::query();
        if ($request->filled('language_code')) {
            $query->where('language_code', $request->language_code);
        }
        $categories = $query->get();
        return response()->json($categories);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'nullable|unique:blog_categories,slug',
            'language_code' => 'required|string|max:10',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $category = BlogCategory::create($validated);

        return response()->json([
            'success' => true,
            'category' => $category,
            'message' => 'Category created successfully!'
        ]);
    }
}
