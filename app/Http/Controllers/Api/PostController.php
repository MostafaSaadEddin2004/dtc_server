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
                ->whereHas('postType', fn ($query)  => $query->where('name', 'public'))->latest()->get();
        } else if ($request->type == 'department') {
            $posts = Post::with(['likes', 'saves'])
                ->whereHas('postType', fn ($query)  => $query->where('name', 'department'))->where('department_id', auth()->user()->department->id)->latest()->get();
        } else {
            $posts = Post::with(['likes', 'saves'])
                ->whereHas('postType', fn ($query)  => $query->where('name', 'course'))->latest()->get();
        }

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['section_id'] = auth()->user()->teacher->section_id;
        if ($request->hasFile('attachment')) {
            $file_path = storeImage($request, 'attachment', 'Attachments'); // Replace with your actual file path

            // Get the file extension
            $file_info = pathinfo($file_path);
            $file_extension = strtolower($file_info['extension']);

            // Define an array of image file extensions
            $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

            // Check if the file extension is in the list of image extensions
            if (in_array($file_extension, $image_extensions)) {
                $data['attachment_type'] = 'image';
            } else {
                $data['attachment_type'] = 'file';
            }
        }
        $data['post_type_id'] = 1;

        $move = Post::create($data);

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

        if (!$post->likes()->where('user_id', auth()->id())->exists()) {
            $post->likes()->create(['user_id' => auth()->id()]);
        }

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function save(Post $post)
    {
        if (!$post->saves()->where('user_id', auth()->id())->exists()) {
            $post->saves()->create(['user_id' => auth()->id()]);
        }

        return response()->noContent();
    }


    /**
     * Display the specified resource.
     */
    public function dislike(Post $post)
    {
        $post->likes()->where('user_id', auth()->id())->delete();

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function unsave(Post $post)
    {
        $post->saves()->where('user_id', auth()->id())->delete();

        return response()->noContent();
    }

    /**
     * Display the specified resource.
     */
    public function saves()
    {
        $posts = auth()->user()->saved_posts;

        return PostResource::collection($posts);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        $post->refresh();
        return new PostResource($post);
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
