<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use http\Exception\RuntimeException;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function store(PostStoreRequest $request): RedirectResponse
    {
        $post = $request->user()->posts()->create($request->safe()->toArray());

        return back()->with('flash', self::flashMessage('Post created successfully!', 'success'));
    }

    public function show(Post $post)
    {
        throw new RuntimeException('Not implemented yet. :(');
    }

    public function update(PostUpdateRequest $request, Post $post)
    {
        $post->update($request->safe()->toArray());

        return back()->with('flash', self::flashMessage('Post updated successfully!', 'success'));
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back()->with('flash', self::flashMessage('Post deleted successfully!', 'success'));
    }
}
