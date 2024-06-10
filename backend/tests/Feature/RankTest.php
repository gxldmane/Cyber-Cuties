<?php

use App\Models\Rank;

it ('get rank by id', function () {
    Rank::factory(1)->create();

    $response = $this->get('/api/v1/rank/1');

    $response->assertStatus(200);
});


it('failed to get rank by id', function () {
    $response = $this->get('/api/v1/rank/999');

    $response->assertStatus(404);
});
