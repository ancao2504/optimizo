<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['categories', 'author'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $posts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'slug' => 'nullable|string|unique:posts,slug',
            'status' => 'nullable|in:published,draft,scheduled',
            'published_at' => 'nullable|date',
            'author_id' => 'nullable|exists:users,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'language_code' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (empty($data['status'])) {
            $data['status'] = 'draft';
        }

        // Default author if not provided (fallback to first user)
        if (empty($data['author_id'])) {
            $data['author_id'] = $request->user()?->id ?? \App\Models\User::first()?->id ?? 1;
        }

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        if (!empty($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog post created successfully.',
            'data' => $post->load(['categories'])
        ], 201);
    }

    /**
     * Display the specified resource by ID or slug.
     */
    public function show($idOrSlug)
    {
        $query = Post::with(['categories', 'author']);

        if (is_numeric($idOrSlug)) {
            // Try by ID first, then fall back to slug
            $post = $query->where('id', $idOrSlug)->first()
                ?? Post::with(['categories', 'author'])->where('slug', $idOrSlug)->first();
        } else {
            // Non-numeric: go straight to slug lookup
            $post = $query->where('slug', $idOrSlug)->first();
        }

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Blog post not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Blog post not found.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'featured_image' => 'nullable|string',
            'slug' => 'nullable|string|unique:posts,slug,' . $post->id,
            'status' => 'nullable|in:published,draft,scheduled',
            'published_at' => 'nullable|date',
            'author_id' => 'nullable|exists:users,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:blog_categories,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'language_code' => 'sometimes|required|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        if (isset($data['title']) && empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (isset($data['status']) && $data['status'] === 'published' && empty($post->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post->update($data);

        if (isset($data['categories'])) {
            $post->categories()->sync($data['categories']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Blog post updated successfully.',
            'data' => $post->load(['categories'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Blog post not found.'
            ], 404);
        }

        $post->categories()->detach();
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog post deleted successfully.'
        ]);
    }
}
