<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DailyReportFactory extends Factory
{
    protected $model = \App\Models\DailyReport::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'report_date' => fake()->date(),
            'activity_description' => fake()->paragraph(),
            'weather_condition' => fake()->randomElement(['sunny', 'cloudy', 'rainy', 'storm']),
            'created_by' => User::factory()->admin(),
        ];
    }
}
