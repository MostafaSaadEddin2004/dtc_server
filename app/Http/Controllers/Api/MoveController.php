<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreMoveRequest;
use App\Http\Resources\Api\MoveResource;
use App\Models\Move;
use Illuminate\Http\Request;

class MoveController extends Controller
{
    public function store(StoreMoveRequest $request)
    {
        $move = Move::create($request->validated());
        return new MoveResource($move);
    }
}
