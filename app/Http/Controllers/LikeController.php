<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __invoke(Request $request)
    {
        $like = $request->user()
            ->likes()
            ->where('post_id', $request->post)
            ->first();

        $added = !$like;
        if ($like) {
            $like->delete();
        } else {
            $request->user()->likes()->create([
                'post_id' => $request->post,
            ]);
        }

        return back();
    }
}
