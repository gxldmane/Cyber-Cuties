<?php

use App\Models\User;
use function PHPUnit\Framework\assertEquals;

beforeEach(function (){
   $this->withHeader('Accept', 'application/json');
});



it('successfully register user', function () {
    $response = $this->postJson('/api/v1/register', [
        'role' => 'user',
        'username' => 'test',
        'gender' => 'male',
        'birth_date' => '1990-01-01',
        'email' => 'jGZkA@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $data = $response->json();

    assertEquals('user', $data['data']['user']['role']);

    $response->assertJsonStructure([
        'data' => [
            'user',
            'token'
        ]
    ]);
    $response->assertStatus(201);

});

it('successfully register cutie', function () {
    $response = $this->postJson('/api/v1/register', [
        'role' => 'cutie',
        'username' => 'test',
        'gender' => 'male',
        'birth_date' => '1990-01-01',
        'email' => 'jGZkA@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $data = $response->json();

    assertEquals('cutie', $data['data']['user']['role']);

    $response->assertJsonStructure([
        'data' => [
            'user',
            'token'
        ]
    ]);
    $response->assertStatus(201);
});

it('incorrect data', function () {
    $response = $this->postJson('/api/v1/register', [
        'role' => 'cutiew',
        'username' => 'test1234s',
        'gender' => 'malwe',
        'birth_date' => '1990-01-01',
        'email' => 'jGZkAexample.com',
        'password' => 'paord',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);

});

it('email already exists', function () {
    User::factory()->create([
        'email' => 'jGZkA@example.com'
    ]);

    $response = $this->postJson('/api/v1/register', [
        'role' => 'user',
        'username' => 'test',
        'gender' => 'male',
        'birth_date' => '1990-01-01',
        'email' => 'jGZkA@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertStatus(422);
});
