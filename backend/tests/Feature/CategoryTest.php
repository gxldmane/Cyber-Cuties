<?php

use App\Models\Category;

it('get all categories', function () {
    Category::factory(10)->create();
    $response = $this->getJson('/api/v1/categories');
    $response->assertStatus(200);
});

it('get category by id', function () {

    $category = Category::factory(1)->create();

    $response = $this->getJson('/api/v1/categories/1');

    $response->assertOk();
});

it('failed to get category by id', function () {
    $response = $this->getJson('/api/v1/categories/999');

    $response->assertNotFound();
});
