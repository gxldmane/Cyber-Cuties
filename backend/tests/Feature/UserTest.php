<?php

use App\Models\User;

beforeEach(function (){
   $this->withoutMiddleware();
   $this->withHeader('Accept', 'application/json');
});


it('get all cuties', function () {

    User::factory(10)->create();

    $response = $this->get('/api/v1/users');

    $content = $response->getContent();
    $json = json_decode($content, true);

    foreach ($json['data'] as $item) {
        assert($item['role'] === 'cutie', 'Not all users have type "cutie"');
    }

    $response->assertOk();
});

it('get user by id', function () {

    $user = User::factory(1)->create(['id' => 3]);

    $response = $this->get('api/v1/users/3');

    $content = $response->getContent();
    $json = json_decode($content, true);
    assert($json['data']['id'] === $user[0]['id'], 'User id does not match');

    $response->assertOk();
});

it('failed to get user', function () {

    $response = $this->get('api/v1/users/222222');

    $response->assertNotFound();
});
