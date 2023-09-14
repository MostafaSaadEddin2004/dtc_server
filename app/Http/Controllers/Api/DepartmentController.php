<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;

/**
 * @group Department
 *
 * This Api Department
 */
class DepartmentController extends Controller
{
    /**
     * See departments of section
     * @response 200 scenario="Success Process"{
    "data": [
        {
            "id": 40,
            "name": "Stanley Hartmann MD",
            "mark": null
        }
    ]
}
     *
     *
     */
    public function seeDepartmentFromSection($sectionId)
    {
        $department = Department::where('section_id', $sectionId)->get();
        return DepartmentResource::collection($department);
    }
}
