<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Service\SidebarService;
use http\Exception\RuntimeException;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    public function store(PostStoreRequest $request): RedirectResponse
    {
        $attributes = $request->safe()->toArray();
        if ($request->hasFile('image')) {
            $attributes['image'] = $request->file('image')->store('images');
        }

        $request->user()->posts()->create($attributes);

        return back()->with('flash', self::flashMessage('Post created successfully!', 'success'));
    }

    public function show(int $postId, SidebarService $sidebarService)
    {
        $post = Post::query()
            ->with([
                'user',
                'answers' => fn ($query) => $query
                    ->with('user')
                    ->withCount(['likes', 'answers'])
                    ->orderBy('created_at'),
            ])
            ->withCount(['likes', 'answers'])
            ->findOrFail($postId)
            ->append([
                'liked_by_current_user',
                'body_html',
            ]);

        $post->answers->each(fn (Post $answer) => $answer->append('liked_by_current_user', 'body_html'));

        return inertia('Post/PostShowPage', [
            'post' => $post,
            'users' => $sidebarService->getUsers(),
        ]);
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
