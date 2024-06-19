<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceType>
 */
class ServiceTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::query()->inRandomOrder()->first()->id,
            'name' => $this->faker->word(),
            'price' => $this->faker->numberBetween(100, 1000),
            'duration' => $this->faker->randomElement(['30', '60', 'game'])
        ];
    }
}
