<?php

use App\Models\Category;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;

beforeEach(function () {
    $this->withHeader('Accept', 'application/json');
});


it('get reviews of service', function () {
    User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    Service::factory()->create(['id' => 1]);
    Review::factory(10)->create(['service_id' => 1]);
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/api/v1/services/1/reviews');
    $response->assertOk();

});

it('failed to get reviews of service', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get('/api/v1/services/999/reviews');
    $response->assertStatus(404);
});


it('can create review ', function () {
    User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    Service::factory()->create(['id' => 1]);
    Review::factory(10)->create(['service_id' => 1]);
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/api/v1/services/1/reviews', [
        'review' => 'test',
        'rating' => 5
    ]);

    $response->assertCreated();
    $response->assertJsonStructure([
        'data' => [
            'id',
            'service_id',
            'user_id',
            'review',
            'type',
            'rating',
            'created_at',
            'updated_at',
        ]
    ]);
});

it('cant create review: already reviewed', function () {
    User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    Service::factory()->create(['id' => 1]);
    Review::factory(10)->create(['service_id' => 1]);
    $user = User::factory()->create();
    Review::factory()->create(['service_id' => 1, 'user_id' => $user->id]);
    $response = $this->actingAs($user)->post('/api/v1/services/1/reviews', [
        'review' => 'test',
        'rating' => 5
    ]);
    $response->assertStatus(422);
});


it('can update review ', function () {
    User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    Service::factory()->create(['id' => 1]);
    Review::factory(10)->create(['service_id' => 1]);
    $user = User::factory()->create();
    $review = Review::factory()->create(['service_id' => 1, 'user_id' => $user->id]);

    $response = $this->actingAs($user)->patch('/api/v1/services/1/reviews/' . $review->id, [
        'review' => 'test',
        'rating' => 5
    ]);

    $response->assertOk();
    $response->assertJsonStructure([
        'data' => [
            'id',
            'service_id',
            'user_id',
            'review',
            'type',
            'rating',
            'created_at',
            'updated_at',
        ]
    ]);
});

it('failed to update review: review not found', function () {
    User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    Service::factory()->create(['id' => 1]);
    Review::factory(10)->create(['service_id' => 1]);
    $user = User::factory()->create();
    $response = $this->actingAs($user)->patch('/api/v1/services/1/reviews/999', [
        'review' => 'test',
        'rating' => 5
    ]);
    $response->assertStatus(404);
});


it('can delete review', function () {
    User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    Service::factory()->create(['id' => 1]);
    Review::factory(10)->create(['service_id' => 1]);
    $user = User::factory()->create();
    $review = Review::factory()->create(['service_id' => 1, 'user_id' => $user->id]);

    $response = $this->actingAs($user)->delete('/api/v1/services/1/reviews/' . $review->id);
    $response->assertNoContent();
});
