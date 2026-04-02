<?php
// app/Http/Controllers/Api/AdminController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // ── List all users (with search) ──────────────────────────
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->latest()->paginate(15);

        return response()->json([
            'status' => true,
            'data' => $users,
        ]);
    }

    // ── Show single user ──────────────────────────────────────
    public function show(User $user)
    {
        return response()->json(['status' => true, 'user' => $user]);
    }

    // ── Update user ───────────────────────────────────────────
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|in:user,admin',
            'status' => 'sometimes|in:active,inactive',
        ]);

        $user->update($request->only('name', 'email', 'role', 'status'));

        return response()->json([
            'status' => true,
            'message' => 'User updated.',
            'user' => $user->fresh(),
        ]);
    }

    // ── Delete user ───────────────────────────────────────────
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot delete your own account.',
            ], 422);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted.',
        ]);
    }

    // ── Toggle status ─────────────────────────────────────────
    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'active' ? 'inactive' : 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User status updated.',
            'user' => $user->fresh(),
        ]);
    }
}