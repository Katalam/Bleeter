<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $response = $request->user()->follows()->toggle($request->user_id);

        return response()->json([
            'followed' => in_array($request->user_id, $response['attached'], true),
        ]);
    }
}
