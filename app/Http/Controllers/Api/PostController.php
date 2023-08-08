<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

/**
 * @group Post
 * 
 * @authenticated
 * 
 */
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetPostRequest $request)
    {
        if ($request->type != 'public' && auth()->user()->hasRole(['department', 'course'])) {
            $posts = Post::with(['likes', 'saves'])->whereHas('postType', fn ($query)  => $query->where('name', 'public'))->get();
        } else if ($request->type == 'department') {
            $posts = Post::with(['likes', 'saves'])->whereHas('postType', fn ($query)  => $query->where('name', 'department')->orWhere('name', 'public'))->get();
        } else {
            $posts = Post::with(['likes', 'saves'])->whereHas('postType', fn ($query)  => $query->where('name', 'course'))->get();
        }

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function like(Post $post)
    {
        $post->likes()->create(['user_id' => auth()->id()]);

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function save(Post $post)
    {
        $post->saves()->create(['user_id' => auth()->id()]);

        return response()->noContent();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
