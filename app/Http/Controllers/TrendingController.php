<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Service\SidebarService;
use Illuminate\Http\Request;

class TrendingController extends Controller
{
    public function __invoke(Request $request, SidebarService $sidebarService)
    {
        $posts = Post::query()
            // With username and likes count
            ->where('parent_id', null)
            // Limit by request parameter
            ->forTimeLine($request)
            ->get()
            ->append(['liked_by_current_user', 'body_html']);


        return inertia('Trending', [
            'posts' => $posts,
            'users' => $sidebarService->getUsers(),
        ]);
    }
}
