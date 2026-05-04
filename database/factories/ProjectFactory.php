<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = \App\Models\Project::class;

    public function definition(): array
    {
        return [
            'client_id' => User::factory()->client(),
            'name' => fake()->company() . ' Project',
            'description' => fake()->paragraph(),
            'location' => fake()->address(),
            'start_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'end_date' => fake()->optional()->dateTimeBetween('+1 day', '+1 year')?->format('Y-m-d'),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'cancelled']),
            'progress_percentage' => fake()->numberBetween(0, 100),
            'contract_value' => fake()->randomFloat(2, 1000000, 100000000),
        ];
    }
}
