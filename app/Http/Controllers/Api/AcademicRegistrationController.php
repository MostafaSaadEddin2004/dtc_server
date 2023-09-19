<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAcademicRegisterationRequest;
use App\Http\Resources\CertificateTypeResource;
use App\Http\Resources\DepartmentResource;
use App\Models\CertificateType;
use App\Models\Department;

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

    public function store(StoreAcademicRegisterationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $idImagePath = $request->file('id_image')->store('public/AcademicRegistrationImages');
        $certificateImagePath = $request->file('certificate_image')->store('public/AcademicRegistrationImages');
        $personalImagePath = $request->file('personal_image')->store('public/AcademicRegistrationImages');
        $unImagePath = $request->file('un_image')->store('public/AcademicRegistrationImages');

        $data['id_image'] = $idImagePath;
        $data['certificate_image'] = $certificateImagePath;
        $data['personal_image'] = $personalImagePath;
        $data['un_image'] = $unImagePath;

        foreach ($data['department_ids'] as $departmentId) {
            $department = Department::with('departmentMarks')->find($departmentId);

            if ($department->mark_of_this_year <= $data['avg_mark']) {
                auth()->user()->wishes()->create(['department_id' => $department->id]);
            }
        }
    }
}
