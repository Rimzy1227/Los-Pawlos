<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    public function index()
    {
        // For now, settings mainly focuses on managing Admin users
        $admins = User::where('role', 'admin')->get();
        return view('admin.settings.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'New admin added successfully.');
    }

    public function edit(User $admin)
    {
        // Safety check to ensure we are editing an admin
        if ($admin->role !== 'admin') {
            return redirect()->route('admin.settings.index')->with('error', 'Cannot edit non-admin users here.');
        }
        return view('admin.settings.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        if ($admin->role !== 'admin') {
            return abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$admin->id,
            'password' => 'nullable|string|min:8|confirmed', // Password nullable if not changing
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.settings.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(User $admin)
    {
        if ($admin->role !== 'admin') {
            return abort(403);
        }

        // Prevent deleting self to avoid lockout
        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.settings.index')->with('error', 'You cannot delete your own account while logged in.');
        }

        $admin->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Admin removed successfully.');
    }
}
