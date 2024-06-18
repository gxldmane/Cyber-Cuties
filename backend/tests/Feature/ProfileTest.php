<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;

it('successfully gets profile', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('api/v1/me');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'role',
            'username',
            'gender',
            'birth_data',
            'bio',
            'avatar_path',
            'cover_path',
            'email'
        ]
    ]);
});

it('cant get profile without login', function () {
    $response = $this->withHeader('Accept', 'application/json')->get('api/v1/me');

    $response->assertStatus(401);
});


it('update profile without login', function () {
    $response = $this->withHeader('Accept', 'application/json')->patch('api/v1/me', [
        'bio' => 'new bio'
    ]);

    $response->assertStatus(401);
});

it('update profile wit incorrect data', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->patch('api/v1/me', [
        'password' => 'ne',
        'password_confirmation' => 'new'
    ]);

    $response->assertStatus(302);
});



it('update profile without loading files', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->patch('api/v1/me', [
        'bio' => 'new bio'
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'role',
            'username',
            'gender',
            'birth_data',
            'bio',
            'avatar_path',
            'cover_path',
            'email'
        ]
    ]);
});

it('update profile with loading files', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->patch('api/v1/me', [
        'bio' => 'new bio',
        'avatar' => UploadedFile::fake()->image('avatar.png'),
        'cover' => UploadedFile::fake()->image('cover.png')
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'role',
            'username',
            'gender',
            'birth_data',
            'bio',
            'avatar_path',
            'cover_path',
            'email'
        ]
    ]);
});
