<?php
// app/Http/Controllers/Api/PasswordResetController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    // ── Send reset link ───────────────────────────────────────
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Delete old tokens for this email
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        // In production: send email with reset link
        // Mail::to($request->email)->send(new ResetPasswordMail($token));

        return response()->json([
            'status' => true,
            'message' => 'Password reset link sent to your email.',
            // Remove this in production!
            // 'token' => $token,
        ]);
    }

    // ── Reset password ────────────────────────────────────────
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired reset token.',
            ], 422);
        }

        // Token expires after 60 minutes
        if (now()->diffInMinutes($record->created_at) > 60) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'status' => false,
                'message' => 'Reset token has expired.',
            ], 422);
        }

        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully.',
        ]);
    }
}