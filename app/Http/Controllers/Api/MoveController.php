<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMoveRequest;
use App\Http\Resources\Api\MoveResource;
use App\Models\Move;
use Illuminate\Http\Request;

/**
 * @group Move
 *
 * This Api For teacher to Move
 */
class MoveController extends Controller
{
    /**
     * Create Move
     * @response 200 scenario="Success Process"{
    "data": {
        "id": 6,
        "text": "text",
        "user_id": {
            "id": 1,
            "first_name_en": "Admin",
            "last_name_en": "Admin",
            "first_name_ar": "Admin",
            "last_name_ar": "Admin",
            "email": "super.admin@admin.com",
            "phone": "279-206-5241",
            "password": "$2y$10$cGVmTLp/ZiKauYKZkkJpke03d.dchqpu6r62EWod/JgLpQh5J3m2."
        },
        "department_id": {
            "id": 1,
            "name": "Jarvis Bogisich",
            "mark": null
        }
    }
}
     *
     *
     * @response 422 scenario="Validation errors"{
    "message": "The text field is required. (and 2 more errors)",
    "errors": {
        "text": [
            "The text field is required."
        ],
        "department_id": [
            "The department id field is required."
            "The selected department id is invalid."
        ]
    }
}
     *
     * @response 401 scenario="Account Not teacher"{
      "message": "Unauthenticated."
  }
     *
     */
    public function store(StoreMoveRequest $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        $data = $request->validated();
        $data['user_id'] = $userId;
        $move = Move::create($data);

        return new MoveResource($move);
    }
}
