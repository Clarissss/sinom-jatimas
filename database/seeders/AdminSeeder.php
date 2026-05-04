<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sinomjatimas.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '087771300570',
            'is_active' => true,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@sinomjatimas.com');
        $this->command->info('Password: password');
    }
}
