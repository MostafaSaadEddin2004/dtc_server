<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckForgetPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Api\TeacherRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Models\PasswordResetToken;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use ResetPasswordEmail;

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
        $data['is_department_head'] = $user->role_id === 5;
        Teacher::create($data);
        $user->update(['role_id' => 2]);
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

        return new UserProfileResource($user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $data = [];
        if ($request->email) {
            $data['email'] = $request->email;
        }
        if ($request->phone) {
            $data['phone'] = $request->phone;
        }
        if ($request->address) {
            $data['address'] = $request->address;
        }
        if ($request->current_password) {
            $data['password'] = $request->new_password;
        }

        $user->update($data);

        return new UserProfileResource($user);
    }

    public function getRole()
    {
        $role = auth()->user()->role;
        return response([
            'role' => $role->name,
        ]);
    }
    public function sendTokenForResetPassword(ResetPasswordRequest $request)
    {
        $currentDateTime = Carbon::now();
        $randomString = Str::random(6);
        $passwordResetToken = PasswordResetToken::where('email', $request->email)->first();
        $newDateTime = $passwordResetToken ? Carbon::parse($passwordResetToken->created_at)->addMinutes(30) : null;

        if ($passwordResetToken && $newDateTime <= $currentDateTime) {
            $passwordResetToken->update([
                'email' => $request->email,
                'token' => $randomString,
                'created_at' => now(),
            ]);
        }

        if (!is_null($newDateTime)) {
            $afterDateTime = $currentDateTime->diffForHumans($newDateTime);
        }

        if ($passwordResetToken && $newDateTime > $currentDateTime) {
            return response()->json([
                'status' => 'error',
                'message' => 'The verification code has already been sent. Try again after ' . $afterDateTime,
            ]);
        }

        if (!$passwordResetToken) {
            PasswordResetToken::create([
                'email' => $request->email,
                'token' => $randomString,
                'created_at' => now(),
            ]);
        }

        $user = User::where('email', $request->email)->first();
        $user->sendResetPasswordEmail($request->email, $randomString);

        return response()->json([
            'status' => 'success',
            'message' => 'Verification code has been sent.',
        ]);
    }
    public function checkCompleteForgetPassword(CheckForgetPasswordRequest $request)
    {
        $userForgetPasswordToken = PasswordResetToken::where('email', $request->email)->first();
        if ($request->token == $userForgetPasswordToken->token) {
            $user = User::where('email',$request->email)->first();
            $token = $user->createToken('authToken')->plainTextToken;
            $user->firebaseTokens()->create(['token' => $request->fcm_token]);
            return response()->json([
                'token' => $token,
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'The verification code not current.',
        ]);
    }
}
