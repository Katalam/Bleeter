<?php

use App\Models\Post;
use App\Models\User;

test('that a user can like a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('like', [
            'post_id' => $post->id,
        ]));

    $response->assertStatus(200);
    $response->assertJson([
        'liked' => true,
    ]);

    $this->assertDatabaseHas('likes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);

    $response = $this->actingAs($user)
        ->post(route('like', [
            'post_id' => $post->id,
        ]));

    $response->assertStatus(200);
    $response->assertJson([
        'liked' => false,
    ]);

    $this->assertDatabaseMissing('likes', [
        'user_id' => $user->id,
        'post_id' => $post->id,
    ]);
})->group('controller', 'like');

test('that a user cannot like a post that does not exist', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('like', [
            'post_id' => 999,
        ]));

    $response->assertStatus(302);
    $response->assertSessionHasErrors('post_id');
})->group('controller', 'like');

test('that a user cannot like a post without a post id', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('like'));

    $response->assertStatus(302);

    $response->assertSessionHasErrors('post_id');
})->group('controller', 'like');

test('that a user cannot like a post without being logged in', function () {
    $post = Post::factory()->create();

    $response = $this->post(route('like', [
        'post_id' => $post->id,
    ]));

    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
})->group('controller', 'like');

