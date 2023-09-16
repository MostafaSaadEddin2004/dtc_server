<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GetPostRequest;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

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
     *
     * @queryParam type string the type of the post (public, department ,course).
     */
    public function index(GetPostRequest $request)
    {
        if ($request->type == 'public') {
            $posts = Post::with(['likes', 'saves'])
                ->whereHas('postType', fn ($query)  => $query->where('name', 'public'))->get();
        } else if ($request->type == 'department') {
            $posts = Post::with(['likes', 'saves'])
                ->whereHas('postType', fn ($query)  => $query->where('name', 'department')->orWhere('name', 'public'))->get();
        } else {
            $posts = Post::with(['likes', 'saves'])
                ->whereHas('postType', fn ($query)  => $query->where('name', 'course'))->get();
        }

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $move = Post::create($request->validated());
        return new PostResource($move);
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
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        $post->refresh();
        return new postResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->noContent();
    }
}
