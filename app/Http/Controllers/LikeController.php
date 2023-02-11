<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $like = $request->user()
            ->likes()
            ->where('post_id', $request->post_id)
            ->first();

        $added = !$like;
        if ($like) {
            $like->delete();
        } else {
            $request->user()->likes()->create([
                'post_id' => $request->post_id,
            ]);
        }

        return response()->json([
            'liked' => $added,
        ]);
    }
}
