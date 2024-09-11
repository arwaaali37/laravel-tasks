<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::with('creator')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'creator_id' => Auth::id(),
            'image' => $request->hasFile('image') ? $request->file('image')->store('images') : null,
        ]);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post->load('creator'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validated = $request->validated();

        $post->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'creator_id' => Auth::id(),
            'image' => $request->hasFile('image') ? $request->file('image')->store('images') : $post->image,
        ]);

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
