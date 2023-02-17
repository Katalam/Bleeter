<?php

namespace App\Http\Controllers;

use App\Models\Hashtag;
use App\Models\Post;
use App\Models\User;
use App\Service\SidebarService;
use Illuminate\Http\Request;

class HashtagController extends Controller
{
    public function __invoke(Request $request, string $hashtag, SidebarService $sidebarService)
    {
        $postIds = Hashtag::query()
            ->where('slug', 'LIKE', '%' . $hashtag . '%')
            ->get(['id', 'post_id'])
            ->pluck('post_id');

        // With username and likes count
        $posts = Post::query()
            ->whereIn('id', $postIds)
            ->with(['user:id,name,username', 'likes'])
            ->withCount(['likes', 'answers'])
            // Limit by request parameter
            ->limit($request->get('l', 20)) // l = limit
            ->sortByQueryParam($request)
            ->get()
            ->append(['liked_by_current_user', 'body_html']);

        return inertia('Hashtag', [
            'hashtag' => $request->hashtag,
            'posts' => $posts,
            'users' => $sidebarService->getUsers(),
            'maxPosts' => $postIds->count(),
        ]);
    }
}
