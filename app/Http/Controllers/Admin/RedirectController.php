<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redirect;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function index()
    {
        $redirects = Redirect::latest()->paginate(20);
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
