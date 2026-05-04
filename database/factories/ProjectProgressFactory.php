<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectProgressFactory extends Factory
{
    protected $model = \App\Models\ProjectProgress::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'type' => fake()->randomElement(['before', 'progress', 'after']),
            'photo_path' => 'progress-photos/' . fake()->uuid() . '.jpg',
            'description' => fake()->optional()->sentence(),
            'uploaded_by' => User::factory()->admin(),
        ];
    }
}
