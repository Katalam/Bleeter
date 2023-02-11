<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            // With username and likes count
            ->with(['user:id,name', 'likes'])
            ->withCount('likes')
            // Limit by request parameter
            ->limit($request->get('l', 20)) // l = limit
            // IF request has s parameter
            ->when($request->has('s'), static function ($query) use ($request) {
                // THEN order by s parameter
                return $query->orderByDesc($request->get('s'));
            }, static function ($query) {
                // ELSe order by created_at
                return $query->orderByDesc('created_at');
            })
            ->get()
            ->append('liked_by_current_user');

        $users = User::query()
            ->whereNot('id', auth()->id())
            ->inRandomOrder()
            ->limit(3)
            ->get(['id', 'name', 'username']);

        return inertia('Homepage', [
            'posts' => $posts,
            'users' => $users,
        ]);
    }
}
