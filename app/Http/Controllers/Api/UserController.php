<?php
// app/Http/Controllers/Api/UserController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ── Get profile ───────────────────────────────────────────
    public function profile()
    {
        return response()->json([
            'status' => true,
            'user' => auth()->user(),
        ]);
    }

    // ── Update profile ────────────────────────────────────────
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'sometimes|string|max:100',
            'phone' => 'sometimes|string|max:20',
            'profile_image' => 'sometimes|url',
        ]);

        $user->update($request->only('name', 'phone', 'profile_image'));

        return response()->json([
            'status' => true,
            'message' => 'Profile updated.',
            'user' => $user->fresh(),
        ]);
    }

    // ── Change password ───────────────────────────────────────
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Current password is incorrect.',
            ], 422);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully.',
        ]);
    }
}