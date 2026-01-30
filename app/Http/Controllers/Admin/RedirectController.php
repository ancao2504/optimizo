<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index(Request $request)
    {
        $query = Redirect::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('from_url', 'like', "%{$search}%")
                    ->orWhere('to_url', 'like', "%{$search}%");
            });
        }

        if ($request->filled('from_url')) {
            $query->where('from_url', 'like', '%' . $request->input('from_url') . '%');
        }

        if ($request->filled('to_url')) {
            $query->where('to_url', 'like', '%' . $request->input('to_url') . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('status', true);
            } elseif ($status === 'inactive') {
                $query->where('status', false);
            }
        }

        $redirects = $query->latest()->paginate(20)->withQueryString();

        return view('admin.redirects.index', compact('redirects'));
    }

    public function create()
    {
        return view('admin.redirects.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'status' => $request->has('status'),
        ]);

        $validated = $request->validate([
            'from_url' => 'required|string',
            'to_url' => 'required|url',
            'type' => 'required|in:301,302',
            'status' => 'boolean',
        ]);

        // Ensure from_url starts with /
        if (!preg_match('#^https?://#', $validated['from_url']) && !str_starts_with($validated['from_url'], '/')) {
            $validated['from_url'] = '/' . $validated['from_url'];
        }

        Redirect::create($validated);

        return redirect()->route('admin.redirects.index')
            ->with('success', 'Redirect created successfully!');
    }

    public function edit(Redirect $redirect)
    {
        return view('admin.redirects.edit', compact('redirect'));
    }

    public function update(Request $request, Redirect $redirect)
    {
        $request->merge([
            'status' => $request->has('status'),
        ]);

        $validated = $request->validate([
            'from_url' => 'required|string',
            'to_url' => 'required|url',
            'type' => 'required|in:301,302',
            'status' => 'boolean',
        ]);

        // Ensure from_url starts with /
        if (!preg_match('#^https?://#', $validated['from_url']) && !str_starts_with($validated['from_url'], '/')) {
            $validated['from_url'] = '/' . $validated['from_url'];
        }

        $redirect->update($validated);

        return redirect()->route('admin.redirects.index')
            ->with('success', 'Redirect updated successfully!');
    }

    public function destroy(Redirect $redirect)
    {
        $redirect->delete();

        return redirect()->route('admin.redirects.index')
            ->with('success', 'Redirect deleted successfully!');
    }
}
