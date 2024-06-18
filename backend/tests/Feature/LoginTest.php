<?php

use App\Models\User;

it('successfully logs in', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'password'
    ]);

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            'user',
            'token'
        ]
    ]);
});

it('fails to log in', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/v1/login', [
        'email' => $user->email,
        'password' => 'wrong-password'
    ]);

    $response->assertUnauthorized();
});
