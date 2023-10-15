<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAcademicRegisterationRequest;
use App\Http\Resources\CertificateTypeResource;
use App\Http\Resources\DepartmentResource;
use App\Models\AcademicRegistration;
use App\Models\CertificateType;
use App\Models\Department;
use App\Models\Wish;
use Carbon\Carbon;
use Spatie\Valuestore\Valuestore;

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
        $departments = $certificateType->departmentMarks()->with('department')->get();
        return DepartmentResource::collection($departments);
    }
    /**
     * Send Token For Reset Password
     * @response 204 scenario="Success Process"{
     * }
     *
     */
    public function store(StoreAcademicRegisterationRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $idImagePath = storeImage($request, 'id_image', 'AcademicRegistrationImages');
        $certificateImagePath = storeImage($request, 'certificate_image', 'AcademicRegistrationImages');
        $personalImagePath = storeImage($request, 'personal_image', 'AcademicRegistrationImages');
        $unImagePath = storeImage($request, 'un_image', 'AcademicRegistrationImages');

        $data['id_image'] = $idImagePath;
        $data['certificate_image'] = $certificateImagePath;
        $data['personal_image'] = $personalImagePath;
        $data['un_image'] = $unImagePath;

        $user = auth()->user();


        $academicRegistration = AcademicRegistration::create($data);
        foreach ($data['department_ids'] as $departmentId) {
            $department = Department::with('departmentMarks')->find($departmentId);

            //TODO:: check if department is already full
            if (now()->diffInYears($data['date_of_birth']) > 22) {
                Wish::create(['academic_registration_id' => $academicRegistration->id, 'department_id' => $department->id, 'reserved' => true]);
            } else if ($department->mark_of_this_year <= $data['avg_mark']) {
                if (!isset($data['department_id'])) {
                    $data['department_id'] = $department->id;
                }
                Wish::create(['academic_registration_id' => $academicRegistration->id, 'department_id' => $department->id]);
            } else {
                Wish::create(['academic_registration_id' => $academicRegistration->id, 'department_id' => $department->id, 'reserved' => true]);
            }
        }

        $academicRegistration->update($data);

        $user->update(['role_id' => 2]);

        return response()->noContent();
    }

    /**
     * @response 204
     *
     * @response 400 {
    "message": "التسجيل على المفاضلة غير متاح حالياً. يفتح التسجيل على المفاضلة في 2023-09-22"
}
     */

    public function isOpen()
    {
        $valueStore = ValueStore::make(config('filament-settings.path'));
        if ($valueStore->get('registration_start_at') >= now() || $valueStore->get('registration_end_at') <= now()) {
            return response(
                ['message' => 'التسجيل على المفاضلة غير متاح حالياً. يفتح التسجيل على المفاضلة في ' . Carbon::parse($valueStore->get('registration_start_at'))->toDateString()],
                400
            );
        }

        return response()->noContent();
    }
}
