<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEditMarkRequest;
use App\Http\Resources\Api\EditMarkResource;
use App\Models\EditMark;
use Illuminate\Http\Request;

/**
 * @group Edit Mark
 *
 * This Api For teacher to Move
 */
class EditMarkController extends Controller
{
    /**
     * Create Move
     * @response 200 scenario="Success Process"{
    "data": {
        "subject": "علوم",
        "mark": "100",
        "reason": "ناجح",
        "teacher": "ديزيجينيتيد",
        "user": {
            "id": 51,
            "first_name_en": "Finn O'Keefe",
            "last_name_en": "Celia Corkery MD",
            "first_name_ar": "Kelton Beer",
            "last_name_ar": "Prof. Verna Simonis Sr.",
            "email": "greg76@example.com",
            "phone": "(845) 458-3243",
            "password": "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"
        }
    }
}
     *
     *
     * @response 422 scenario="Validation errors"{
     *"subject": [
            "The subject field is required."
        ],
        "mark": [
            "The mark field is required."
            "The mark field must not be greater than 100."
            "The mark field must be at least 0."

        ],
        "reason": [
            "The reason field is required."
        ],
        "teacher": [
            "The teacher field is required."
        ]
    }
     * }
     *
     * @response 401 scenario="Account Not teacher"{
      "message": "Unauthenticated."
  }
     *
     */
    public function store(StoreEditMarkRequest $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        $data = $request->validated();
        $data['user_id'] = $userId;
        $move = EditMark::create($data);
        return new EditMarkResource($move);
    }
}
