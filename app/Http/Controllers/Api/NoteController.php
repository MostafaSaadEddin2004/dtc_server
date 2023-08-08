<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreNoteRequest;
use App\Http\Requests\Api\UpdateNoteRequest;
use App\Http\Resources\NoteCategoryResource;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use App\Models\NoteCategory;

/**
 * @group Note
 * 
 * @authenticated
 * 
 */
class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */
    public function index()
    {
        $notes = auth()->user()->notes()->with('noteCategory')->get();

        return NoteResource::collection($notes);
    }

    /**
     * Display a listing of the resource.
     */
    public function categories()
    {
        $noteCategories = auth()->user()->noteCategories;

        return NoteCategoryResource::collection($noteCategories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        $data = $request->validated();
        if ($request->category_name) {
            $data['note_category_id'] = auth()->user()->noteCategories()->create(['name' => $request->category_name])->id;
        }

        $note = Note::create($data);

        return new NoteResource($note);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $note->load('noteCategory');
        return new NoteResource($note);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note)
    {
        $data = $request->validated();
        if ($request->category_name) {
            $data['note_category_id'] = NoteCategory::create(['name' => $request->category_name])->id;
        }

        $note->update($data);
        $note->refresh();

        $note->load('noteCategory');
        return new NoteResource($note);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return response()->noContent();
    }
}
