<?php

use App\Models\Category;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use function PHPUnit\Framework\assertEquals;

beforeEach(function () {
    $this->withHeader('Accept', 'application/json');
});


it('can create a service', function () {
    Category::factory()->create(['id' => 1]);
    $user = User::factory()->create(['role' => 'cutie']);

    $response = $this->actingAs($user)->post('api/v1/services/',
        [
            'category_id' => 1,
            'description' => 'test',
            'image' => UploadedFile::fake()->image('image.png'),
        ]);

    $data = $response->json();

    assertEquals($data['data']['cutie_id'], $user->id);

    $response->assertStatus(201);
});

it('failed to create a service ', function () {
    Category::factory()->create(['id' => 1]);
    $user = User::factory()->create(['role' => 'cutie']);

    $response = $this->withHeader('Accept', 'application/json')->actingAs($user)->post('api/v1/services/',
        [
            'category_id' => 2,
            'description' => '',
            'image' => UploadedFile::fake()->create('www.docx'),
        ]);

    $response->assertStatus(422);
});

it('can update a service', function () {
    Category::factory()->create(['id' => 1]);
    $user = User::factory()->create(['id' => 1, 'role' => 'cutie']);
    Service::factory()->create(['cutie_id' => $user->id, 'id' => 1]);

    $response = $this->actingAs($user)->patch('api/v1/services/1',
        [
            'category_id' => 1,
            'description' => 'testtt',
            'image' => UploadedFile::fake()->image('image.png'),
        ]);

    $data = $response->json();

    assertEquals($data['data']['description'], 'testtt');

    $response->assertStatus(200);
});

it('failed to update a service ', function () {
    Category::factory()->create(['id' => 1]);
    $user = User::factory()->create(['id' => 1, 'role' => 'cutie']);
    Service::factory()->create(['cutie_id' => $user->id, 'id' => 1]);

    $response = $this->actingAs($user)->patch('api/v1/services/1',
        [
            'category_id' => 5,
            'description' => 'testtt',
            'image' => UploadedFile::fake()->image('image.png'),
        ]);

    $data = $response->json();

    $response->assertStatus(422);
});

it('failed to update a service: service belongs to another user', function () {
    Category::factory()->create(['id' => 1]);
    $user = User::factory()->create(['id' => 1, 'role' => 'cutie']);
    Service::factory()->create(['cutie_id' => $user->id, 'id' => 1]);

    $user2 = User::factory()->create(['id' => 2, 'role' => 'cutie']);
    $response = $this->actingAs($user2)->patch('api/v1/services/1',
        [
            'category_id' => 1,
            'description' => 'testtt',
            'image' => UploadedFile::fake()->image('image.png'),
        ]);

    $response->assertStatus(403);
});

it('failed to update a service: service not found', function () {
    Category::factory()->create(['id' => 1]);
    $user = User::factory()->create(['id' => 1, 'role' => 'cutie']);

    $response = $this->actingAs($user)->patch('api/v1/services/33',
        [
            'category_id' => 1,
            'description' => 'testtt',
            'image' => UploadedFile::fake()->image('image.png'),
        ]);

    $response->assertStatus(404);
});


it('can delete a service', function () {
    Category::factory()->create(['id' => 1]);
    $user = User::factory()->create(['id' => 1, 'role' => 'cutie']);
    Service::factory()->create(['cutie_id' => $user->id, 'id' => 1]);

    $response = $this->actingAs($user)->delete('api/v1/services/1');
    $response->assertStatus(204);
});
