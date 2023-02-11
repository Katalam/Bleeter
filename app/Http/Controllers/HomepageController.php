<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function __invoke(Request $request)
    {
        $posts = Post::query()
            ->with('user:id,name')
            ->limit($request->get('l', 20)) // l = limit
            ->orderByDesc('created_at')
            ->get();

        return inertia('Homepage', [
            'posts' => $posts,
        ]);
    }
}
