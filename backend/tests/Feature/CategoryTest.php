<?php

use App\Models\Category;

it('get all categories', function () {
    Category::factory(10)->create();
    $response = $this->get('/api/v1/categories');
    $response->assertOk();
});

it('get category by id', function () {

    Category::factory()->create(['id' => 1, 'name' => 'Category 1']);

    $response = $this->getJson('/api/v1/categories/1');

    $response->assertOk();
});

it('failed to get category by id', function () {
    $response = $this->getJson('/api/v1/categories/999');

    $response->assertNotFound();
});
