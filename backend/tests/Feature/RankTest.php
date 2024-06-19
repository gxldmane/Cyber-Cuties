<?php

use App\Models\Category;
use App\Models\Rank;

beforeEach(function (){
   $this->withoutMiddleware();
   $this->withHeader('Accept', 'application/json');
});


it ('get rank by id', function () {
    Category::factory(1)->create();

    Rank::factory(1)->create();

    $response = $this->get('/api/v1/ranks/1');

    $response->assertOk();
});


it('failed to get rank by id', function () {
    $response = $this->get('/api/v1/ranks/999');

    $response->assertStatus(404);
});
