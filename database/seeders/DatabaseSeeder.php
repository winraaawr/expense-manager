<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //  Roles //
        // Administrator //
        \App\Models\Role::factory()->create([
            'role_name' => 'Administrator',
            'description' => 'Super User'
        ]);
        // User //
        \App\Models\Role::factory()->create([
            'role_name' => 'User',
            'description' => 'Can Add Expenses'
        ]);


        // Users //
        // Administrator Account //
        \App\Models\User::factory()->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juandelacruz@email.com',
            'role_id' => 1
        ]);
        // Default User Account //
        \App\Models\User::factory()->create([
            'name' => 'Maria Dela Cruz',
            'email' => 'mariadelacruz@email.com',
            'role_id' => 2
        ]);

        //Expense Categories //
        \App\Models\Category::factory()->create([
            'category_name' => 'Food',
            'description' => 'A daily basic necessity.',
        ]);
        \App\Models\Category::factory()->create([
            'category_name' => 'Travel',
            'description' => 'Daily transportation.',
        ]);
        \App\Models\Category::factory()->create([
            'category_name' => 'Clothing',
            'description' => 'A daily basic necessity.',
        ]);
    }
}
