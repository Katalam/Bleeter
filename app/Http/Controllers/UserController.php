<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Service\SidebarService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke(Request $request, string $username, SidebarService $sidebarService)
    {
        $user = User::query()
            ->where('username', $username)
            ->withCount('followers', 'follows')
            ->firstOrFail(['id', 'username', 'name', 'created_at'])
            ->append('created_at_human');

        $posts = $user->posts()
            ->forTimeLine($request)
            ->latest()
            ->get()
            ->append(['liked_by_current_user', 'body_html']);

        $countMaxPosts = Post::query()
            ->where('user_id', $user->id)
            ->count();


        return inertia('User', [
            'user' => $user,
            'posts' => $posts,
            'users' => $sidebarService->getUsers(),
            'maxPosts' => $countMaxPosts,
        ]);
    }
}
