<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = \App\Models\Document::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'type' => fake()->randomElement(['contract', 'technical_drawing', 'bast', 'material_report', 'other']),
            'file_name' => fake()->word() . '.pdf',
            'file_path' => 'documents/' . fake()->uuid() . '.pdf',
            'file_type' => 'application/pdf',
            'file_size' => fake()->numberBetween(1000, 10000000),
            'uploaded_by' => User::factory()->admin(),
        ];
    }
}
