<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\userModel;

class userController extends Controller
{
    // Function to update user profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'user_fullname' => 'nullable|string|max:100',
            'user_username' => 'nullable|string|max:100',
            'user_email' => 'nullable|string|email|max:50|unique:user,user_email,' . $user->user_id . ',user_id',
            'user_nohp' => 'nullable|string|max:13',
            'user_alamat' => 'nullable|string|max:200',
            'user_profil_url' => 'nullable|string|max:255',
        ]);

        $user->update([
            'user_fullname' => $request->user_fullname ?? $user->user_fullname,
            'user_username' => $request->user_username ?? $user->user_username,
            'user_email' => $request->user_email ?? $user->user_email,
            'user_nohp' => $request->user_nohp ?? $user->user_nohp,
            'user_alamat' => $request->user_alamat ?? $user->user_alamat,
            'user_profil_url' => $request->user_profil_url ?? $user->user_profil_url,
        ]);

        return response()->json(['status' => true, 'message' => 'Profile updated successfully', 'data' => $user], 200);
    }

    // Function to reset user password
    public function resetPassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->user_password)) {
            return response()->json(['status' => false, 'message' => 'Current password is incorrect'], 400);
        }

        $user->update([
            'user_password' => Hash::make($request->new_password),
        ]);

        return response()->json(['status' => true, 'message' => 'Password reset successfully'], 200);
    }

    // Function to get user profile
    public function getProfile()
    {
        $user = Auth::user();
        return response()->json(['status' => true, 'data' => $user], 200);
    }
}
