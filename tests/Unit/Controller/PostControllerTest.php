<?php

use App\Models\Post;
use App\Models\User;

test('a post can be stored', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('posts.store'), [
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        ]);

    $response->assertStatus(302); // 302 is the redirect status code

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
    ]);

    $this->assertDatabaseCount('posts', 1);
})->group('controller', 'post');

test('a post cannot be stored if body is empty', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('posts.store'), [
            'body' => ''
        ]);

    $response->assertStatus(302); // 302 is the redirect status code

    $this->assertDatabaseMissing('posts', [
        'user_id' => $user->id,
        'body' => ''
    ]);

    $this->assertDatabaseCount('posts', 0);
})->group('controller', 'post');

test('a post cannot be stored if no body is submitted', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('posts.store'));

    $response->assertStatus(302); // 302 is the redirect status code

    $this->assertDatabaseMissing('posts', [
        'user_id' => $user->id,
    ]);

    $this->assertDatabaseCount('posts', 0);
})->group('controller', 'post');

test('a post can be updated', function () {
    $user = User::factory()->create();
    $post = Post::factory([
        'user_id' => $user->id
    ])->create();

    $response = $this->actingAs($user)
        ->patch(route('posts.update', $post), [
            'body' => 'My updated post body'
        ]);

    $response->assertStatus(302); // 302 is the redirect status code

    $this->assertDatabaseHas('posts', [
        'user_id' => $user->id,
        'id' => $post->id,
        'body' => 'My updated post body'
    ]);

    $this->assertDatabaseCount('posts', 1);
})->group('controller', 'post');

test('a post cannot be updated if body is empty', function () {
    $user = User::factory()->create();
    $post = Post::factory([
        'user_id' => $user->id
    ])->create();

    $response = $this->actingAs($user)
        ->patch(route('posts.update', $post), [
            'body' => ''
        ]);

    $response->assertStatus(302); // 302 is the redirect status code

    $this->assertDatabaseMissing('posts', [
        'user_id' => $user->id,
        'id' => $post->id,
        'body' => ''
    ]);
    $this->assertDatabaseHas('posts', [
        'user_id' => $post->user_id,
        'id' => $post->id,
        'body' => $post->body
    ]);

    $this->assertDatabaseCount('posts', 1);
})->group('controller', 'post');

test('a post cannot be updated if no body is submitted', function () {
    $user = User::factory()->create();
    $post = Post::factory([
        'user_id' => $user->id
    ])->create();

    $response = $this->actingAs($user)
        ->patch(route('posts.update', $post));

    $response->assertStatus(302); // 302 is the redirect status code

    $this->assertDatabaseCount('posts', 1);
    $this->assertDatabaseHas('posts', [
        'user_id' => $post->user_id,
        'id' => $post->id,
        'body' => $post->body
    ]);
})->group('controller', 'post');

test('a post cannot be updated if the user is not the author', function () {
    $userRight = User::factory()->create();
    $userWrong = User::factory()->create();
    $post = Post::factory([
        'user_id' => $userRight->id
    ])->create();

    $response = $this->actingAs($userWrong)
        ->patch(route('posts.update', $post));

    $response->assertStatus(403); // 403 is the forbidden status code

    $this->assertDatabaseCount('posts', 1);
    $this->assertDatabaseHas('posts', [
        'user_id' => $post->user_id,
        'id' => $post->id,
        'body' => $post->body
    ]);
})->group('controller', 'post');

