<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\userModel;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // Register function
    public function Register(Request $request)
    {

        // Check if username already exists
        if (userModel::where('user_username', $request->user_username)->exists()) {
         
            return response()->json(['status' => false, 'message' => 'Username already taken'], 422);
        
        }

        // Other validation rules
        $validator = Validator::make($request->all(), [
            'user_username' => 'required|string|max:50',
            'user_password' => 'required|string|max:255',
            'user_fullname' => 'required|string|max:100',
            'user_email' => 'required|string|max:50',
            'user_nohp' => 'required|string|max:13',
            'user_alamat' => 'required|string|max:200',
            'user_profil_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'user_level' => 'required',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors()->toJson(), 400);
        
        }

        // Handle image upload
        if ($request->hasFile('user_profil_url')) {
            $image = $request->file('user_profil_url');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images/profile', $imageName, 'public');
        }

        // Save user
        $save = userModel::create([
            'user_username' => $request->get('user_username'),
            // 'user_password' => $request->get('user_password'),
            'user_password' => Hash::make($request->get('user_password')),
            'user_fullname' => $request->get('user_fullname'),
            'user_email' => $request->get('user_email'),
            'user_nohp' => $request->get('user_nohp'),
            'user_alamat' => $request->get('user_alamat'),
            'user_profil_url' => $imagePath,
            'user_level' => 'PENGGUNA',
        ]);

        if ($save) {

            return response()->json(['status' => true, 'message' => 'User successfully registered'], 200);
        
        }

        return response()->json(['status' => false, 'message' => 'Failed to register user'], 500);
    
    }

    // Register Admin function
    public function RegisterAdmin(Request $request)
    {

        // Check if username already exists
        if (userModel::where('user_username', $request->user_username)->exists()) {
         
            return response()->json(['status' => false, 'message' => 'Username already taken'], 422);
        
        }

        // Other validation rules
        $validator = Validator::make($request->all(), [
            'user_username' => 'required|string|max:50',
            'user_password' => 'required|string|max:255',
            'user_fullname' => 'required|string|max:100',
            'user_email' => 'required|string|max:50',
            'user_nohp' => 'required|string|max:13',
            'user_alamat' => 'required|string|max:200',
            'user_profil_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors()->toJson(), 400);
        
        }

        // Handle image upload
        if ($request->hasFile('user_profil_url')) {
            $image = $request->file('user_profil_url');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images/profile', $imageName, 'public');
        }

        // Save user
        $save = userModel::create([
            'user_username' => $request->get('user_username'),
            'user_password' => Hash::make($request->get('user_password')),
            'user_fullname' => $request->get('user_fullname'),
            'user_email' => $request->get('user_email'),
            'user_nohp' => $request->get('user_nohp'),
            'user_alamat' => $request->get('user_alamat'),
            'user_profil_url' => $imagePath,
            'user_level' => 'ADMIN',
        ]);

        if ($save) {

            return response()->json(['status' => true, 'message' => 'User successfully registered'], 200);
        
        }

        return response()->json(['status' => false, 'message' => 'Failed to register user'], 500);
    
    }


    //Login Function
    public function Login(Request $request)
    {

        // Gets the username and password from the request
        // $credentials = $request->only('user_username', 'user_password');
        $credentials = [
            'user_username' => $request->user_username,
            'password' => $request->user_password,
        ];

        try {
            // Attempt to authenticate the user using the default guard
            if (!$token = Auth::guard('user_model')->attempt($credentials)) {
                // If the authentication is not successful, return a 401 response
                // with an error message
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // If there is an error when creating the token, return a 500 response
            // with an error message
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // If the authentication is successful, return a response with the token, username, and role\
        $user = Auth::guard('user_model')->user();

        return response()->json([
            'user' => $request->user_username,
            'role' => $user->user_level,
            'token' => $token,
        ]);

    }

    //Logout Function
    public function Logout()
    {

        try {
            // Get the current authenticated user token to invalidate to prevent further uses after logout.
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        } catch (JWTException $e) {
            // Catch any errors during token invalidation process
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

    }


}
