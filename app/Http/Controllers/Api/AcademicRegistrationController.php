<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateTypeResource;
use App\Http\Resources\DepartmentResource;
use App\Models\CertificateType;

/**
 * @group AcademicRegistration
 * 
 * @unauthenticated
 */

class AcademicRegistrationController extends Controller
{
    public function certificateType()
    {
        $certificateTypes = CertificateType::all();

        return CertificateTypeResource::collection($certificateTypes);
    }

    /**
     * @urlParam certificateType_id integer The ID of the certificateType. Example: 20
     */

    public function departmentsByCertificateType(CertificateType $certificateType)
    {
        $departments = $certificateType->departments()->with('departmentMarks')->get();

        return DepartmentResource::collection($departments);
    }

    public function store()
    {
    }
}
