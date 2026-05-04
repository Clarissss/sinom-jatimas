<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    protected $model = \App\Models\Invoice::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'invoice_number' => 'INV-' . fake()->unique()->numerify('######'),
            'amount' => fake()->randomFloat(2, 1000000, 50000000),
            'termin_percentage' => fake()->randomElement([30, 50, 70, 100]),
            'status' => fake()->randomElement(['draft', 'sent', 'overdue', 'paid']),
            'due_date' => fake()->optional()->date(),
            'pdf_path' => null,
            'created_by' => User::factory()->admin(),
            'sent_at' => null,
            'paid_at' => null,
        ];
    }
}
