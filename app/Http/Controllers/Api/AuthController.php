<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\TeacherRequest;
use App\Models\Role;
use App\Models\Teacher;
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
        $user->firebaseTokens()->create(['token' => $request->fcm_token]);
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
        $user->firebaseTokens()->create(['token' => $request->fcm_token]);

        if ($request->hasFile('image')) {
            $photoPath = $request->file('image')->store('public/ProfileImage');
            $user->update(['image' => $photoPath]); // Use update to set the image on the existing user
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 200);
    }
    /**
     * add information for teacher
     * @response 200 scenario="Success Process"{
    "message": "your have old request please wait to accept"
    "message": "your request in wait"
}
     *
     * @response 422 scenario="Validation errors"{
    "message": "The certificate field is required. (and 6 more errors)",
    "errors": {
        "certificate": [
            "The certificate field is required."
        ],
        "specialty": [
            "The specialty field is required."
        ],
        "birth_date": [
            "The birth date field is required."
            "The birth date field must be a date before today."
        ],
        "current_location": [
            "The current location field is required."
        ],
        "permanent_location": [
            "The permanent location field is required."
        ],
        "nationality": [
            "The nationality field is required."
        ],
        "department_id": [
            "The department id field is required."
            "The selected department id is invalid."
        ]
    }
}
     * }
     *
     * @response 401 scenario="Account Not teacher"{
      "message": "Unauthenticated."
  }
     *
     */
    public function teacherInfo(TeacherRequest $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $teacherHasRequest = Teacher::where('user_id', $userId)->get();
        if ($teacherHasRequest->isNotEmpty()) {
            return response()->json([
                'message' => 'your have old request please wait to accept',
            ], 400);
        }
        $data = $request->validated();
        $data['user_id'] = $userId;
        Teacher::create($data);
        return response()->json([
            'message' => 'your request in wait',
        ], 200);
    }

    /**
     * Logout
     *
     *
     * @response 204 scenario="Logout Success"{}
     *
     *
     * @response 401 scenario="User Not Login Yet"{
     *     "message": "Unauthenticated."
     * }
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->noContent();
    }

    public function profile()
    {
        $user = auth()->user();
        $data = ['user' => $user];

        if ($user->department) {
            $data['department'] = $user->department;
            $data['section'] = $user->section;
        }
        return $data;
    }

    public function getRole()
    {
        $role = auth()->user()->role;

        return response([
            'role' => $role->name,
        ]);
    }
}
