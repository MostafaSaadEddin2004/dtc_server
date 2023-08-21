<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 * 
 * @authenticated
 */

class AuthController extends Controller
{
    // login in some role 
    /**
     * @bodyParam email string The email of the user. Example: my@example.com
     * @bodyParam password string The password of the user. Example: password
     * @bodyParam role string The role of the user. Example: student_browser
     */
    public function login(LoginRequest $request)
    {
        $role = $request->role;
        $user = User::where('email', $request->email)->whereHas('role', fn ($query) => $query->where('name', $role))->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => trans('errors.login')
            ], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'token' => $token,
        ], 200);
    }

    // register a user in some role
    public function register(RegisterRequest $request)
    {
        $role = $request->role;
        $role_id = Role::where('name', $role)->first()->id;
        $user = User::create(array_merge($request->validated(), compact('role_id')));

        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'token' => $token,
        ], 200);
    }
}
