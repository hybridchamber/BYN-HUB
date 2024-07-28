<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        $posts = Post::all();

        return Inertia::render('Admin/Posts/PostIndex', [
            'posts' => PostResource::collection($posts)
        ]);
    }

    public function create(): Response
    {
        $this->authorize('create', Post::class);
        return Inertia::render('Admin/Posts/Create');
    }

    public function store(CreatePostRequest $request): RedirectResponse
    {
        $this->authorize('create', Post::class);

        $validatedData = $request->validated();

        if ($request->hasFile('cover_photo')) {
            $validatedData['cover_photo'] = $request->file('cover_photo')->store('public/cover_photos');
        }

        Post::create($validatedData);

        return redirect()->route('posts.index');
    }

    public function edit(Post $post): Response
    {
        $this->authorize('update', $post);
        return Inertia::render('Admin/Posts/Edit', [
            'post' => new PostResource($post)
        ]);
    }

    public function update(CreatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validatedData = $request->validated();

        if ($request->hasFile('cover_photo')) {
            if ($post->cover_photo) {
                Storage::delete($post->cover_photo);
            }
            $validatedData['cover_photo'] = $request->file('cover_photo')->store('public/cover_photos');
        } else {
            // Preserve the existing cover photo if no new file is uploaded
            $validatedData['cover_photo'] = $post->cover_photo;
        }

        $post->update($validatedData);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);
        $post->delete();
        return back();
    }
}
