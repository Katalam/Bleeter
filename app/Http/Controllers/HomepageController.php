<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Service\SidebarService;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __invoke(Request $request, SidebarService $sidebarService)
    {
        $userIdsWhichUserFollows = $request->user()
            ->follows()
            ->get(['follow_user_id'])
            ->pluck('follow_user_id');

        $posts = Post::query()
            ->whereIn('user_id', $userIdsWhichUserFollows)
            // With username and likes count
            ->with(['user:id,name,username', 'likes'])
            ->withCount('likes')
            // Limit by request parameter
            ->limit($request->get('l', 20)) // l = limit
            ->sortByQueryParam($request)
            ->get()
            ->append(['liked_by_current_user', 'body_html']);

        $countMaxPosts = Post::query()
            ->whereIn('user_id', $userIdsWhichUserFollows)
            ->count();

        return inertia('Homepage', [
            'posts' => $posts,
            'users' => $sidebarService->getUsers(),
            'maxPosts' => $countMaxPosts,
        ]);
    }
}
