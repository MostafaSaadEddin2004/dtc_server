<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEditMarkRequest;
use App\Http\Resources\Api\EditMarkResource;
use App\Models\EditMark;
use Illuminate\Http\Request;

class EditMarkController extends Controller
{
    public function store(StoreEditMarkRequest $request)
    {
        $editMark = EditMark::create($request->validated());
        return new EditMarkResource($editMark);
    }
}
