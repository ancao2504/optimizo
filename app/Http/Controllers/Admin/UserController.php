<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index()
    {
        // Super admin can see all users, regular admin can only see admin users
        if (auth()->user()->hasRole('super_admin')) {
            $users = User::with('roleModel')->orderBy('created_at', 'desc')->get();
        } else {
            $users = User::with('roleModel')->admins()->orderBy('created_at', 'desc')->get();
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Only super admin can create users
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403, 'Only super administrators can create users.');
        }

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Only super admin can create users
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403, 'Only super administrators can create users.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Only super admin can edit users
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403, 'Only super administrators can edit users.');
        }

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Only super admin can update users
        if (!auth()->user()->hasRole('super_admin')) {
            abort(403, 'Only super administrators can update users.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', Password::min(8), 'confirmed'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];

        // Only update password if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Only super admin can delete users
        if (!auth()->user()->hasRole('super_admin')) {
            return back()->with('error', 'Only super administrators can delete users!');
        }

        // Prevent deleting currently logged-in user
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        // Check if this is the last super admin
        if ($user->hasRole('super_admin')) {
            $superAdminCount = User::whereHas('roleModel', function ($q) {
                $q->where('slug', 'super_admin');
            })->count();
            if ($superAdminCount <= 1) {
                return back()->with('error', 'Cannot delete the last super administrator!');
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}
