<?php

use App\Models\Post;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('it shows the homepage', function () {
    $user = User::factory()->create();
    $userSecond = User::factory()->create();
    User::factory(3)->create(); // for the sidebar
    $user->follows()->attach($userSecond);
    $posts = Post::factory(100, [
        'user_id' => $userSecond->id,
    ])->create();
    foreach ($posts as $post) {
        $post->likes()->create([
            'user_id' => $user->id,
        ]);
    }

    $response = $this->actingAs($user)
        ->get(route('home'));

    $response->assertStatus(200);
    $response->assertInertia(fn(Assert $page) => $page
        ->component('Homepage')
        ->has('posts', 20, fn(Assert $posts) => $posts
            ->has('id')
            ->has('body')
            ->has('body_html')
            ->has('created_at')
            ->has('updated_at')
            ->has('liked_by_current_user')
            ->has('likes_count')
            ->has('user_id')
            ->has('image')
            ->has('created_at_human')
            ->has('deleted_at')
            ->has('likes.0', fn(Assert $likes) => $likes
                ->has('id')
                ->has('user_id')
                ->has('post_id')
                ->has('created_at')
                ->has('updated_at')
            )
            ->has('user', fn(Assert $user) => $user
                ->has('id')
                ->has('name')
            )
        )
        ->has('users', 3, fn(Assert $users) => $users
            ->has('id')
            ->has('name')
            ->has('username')
        )
    );
})->group('group', 'homepage');
