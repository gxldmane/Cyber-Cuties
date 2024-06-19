<?php

use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function (){
   $this->withHeader('Accept', 'application/json');
});


it('can create a service type', function () {
    $user = User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    $service = Service::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/services/types', [
        'service_id' => $service->id,
        'name' => 'test',
        'price' => 100
    ]);

    $response->assertStatus(Response::HTTP_CREATED);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'service_id',
            'name',
            'price'
        ]
    ]);
});

it('cant create a service type: service not found', function () {
    $user = User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    $service = Service::factory()->create();

    $response = $this->actingAs($user)->postJson('/api/v1/services/types', [
        'service_id' => 2222,
        'name' => 'test',
        'price' => 100
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('cant create a service type: forbidden', function () {
    $user = User::factory()->create(['role' => 'cutie']);
    $user2 = User::factory()->create(['role' => 'cutie', 'id' => 2]);
    Category::factory()->create();
    $service = Service::factory()->create(['cutie_id' => 2, 'id' => 1]);

    $response = $this->actingAs($user)->postJson('/api/v1/services/types', [
        'service_id' => $service->id,
        'name' => 'test',
        'price' => 100
    ]);

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});

it('cant create a service type: max limit reached', function () {
    $user = User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    $service = Service::factory(1)->create(['cutie_id' => $user->id, 'id' => 1]);

    ServiceType::factory(5)->create(['service_id' => $service[0]->id]);

    $response = $this->actingAs($user)->postJson('/api/v1/services/types', [
        'service_id' => $service[0]->id,
        'name' => 'test',
        'price' => 100
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

});


it('can update a service type', function (){
    $user = User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    $service = Service::factory()->create(['cutie_id' => $user->id]);
    $serviceType = $service->types()->create([
        'service_id' => $service->id,
        'name' => 'test',
        'price' => 100
    ]);

    $response = $this->actingAs($user)->patchJson('/api/v1/services/types/'.$serviceType->id, [
        'service_id' => $service->id,
        'name' => 'test2',
        'price' => 200
    ]);

    $response->assertStatus(Response::HTTP_OK);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'service_id',
            'name',
            'price'
        ]
    ]);
});

it('cant update a service type: forbidden', function () {
    $user = User::factory()->create(['role' => 'cutie']);
    $user2 = User::factory()->create(['role' => 'cutie', 'id' => 2]);
    Category::factory()->create();
    $service = Service::factory()->create(['cutie_id' => 2, 'id' => 1]);
    $serviceType = $service->types()->create([
        'service_id' => $service->id,
        'name' => 'test',
        'price' => 100
    ]);

    $response = $this->actingAs($user)->patchJson('/api/v1/services/types/'.$serviceType->id, [
        'service_id' => $service->id,
        'name' => 'test2',
        'price' => 200
    ]);

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});


it('can delete a service type', function (){
    $user = User::factory()->create(['role' => 'cutie']);
    Category::factory()->create();
    $service = Service::factory()->create(['cutie_id' => $user->id]);
    $serviceType = $service->types()->create([
        'service_id' => $service->id,
        'name' => 'test',
        'price' => 100
    ]);

    $response = $this->actingAs($user)->deleteJson('/api/v1/services/types/'.$serviceType->id);

    $response->assertStatus(Response::HTTP_NO_CONTENT);
});

it('cant delete a service type: forbidden ', function () {
    $user = User::factory()->create(['role' => 'cutie']);
    $user2 = User::factory()->create(['role' => 'cutie', 'id' => 2]);
    Category::factory()->create();
    $service = Service::factory()->create(['cutie_id' => 2, 'id' => 1]);
    $serviceType = $service->types()->create([
        'service_id' => $service->id,
        'name' => 'test',
        'price' => 100
    ]);

    $response = $this->actingAs($user)->deleteJson('/api/v1/services/types/'.$serviceType->id);

    $response->assertStatus(Response::HTTP_FORBIDDEN);
});
