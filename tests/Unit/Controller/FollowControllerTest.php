<?php

use App\Models\Post;
use App\Models\User;

test('that a user can follow another user', function () {
    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $this->actingAs($userOne)
        ->post(route('follow', [
            'user_id' => $userTwo->id,
        ]));

    $this->assertDatabaseHas('follow_user', [
        'user_id' => $userOne->id,
        'follow_user_id' => $userTwo->id,
    ]);

    $this->actingAs($userOne)
        ->post(route('follow', [
            'user_id' => $userTwo->id,
        ]));

    $this->assertDatabaseMissing('follow_user', [
        'user_id' => $userOne->id,
        'follow_user_id' => $userTwo->id,
    ]);
})->group('controller', 'follow');

test('that a user cannot follow a user that does not exist', function () {
    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $response = $this->actingAs($userOne)
        ->post(route('follow', [
            'user_id' => 999,
        ]));

    $this->assertDatabaseMissing('follow_user', [
        'user_id' => $userOne->id,
        'follow_user_id' => $userTwo->id,
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasErrors('user_id');
})->group('controller', 'follow');

test('that a user cannot follow a user without being logged in', function () {
    $userTwo = User::factory()->create();

    $response = $this
        ->post(route('follow', [
            'user_id' => $userTwo->id,
        ]));

    $this->assertDatabaseMissing('follow_user', [
        'follow_user_id' => $userTwo->id,
    ]);

    $response->assertStatus(302);
    $response->assertRedirect(route('login'));
})->group('controller', 'follow');
