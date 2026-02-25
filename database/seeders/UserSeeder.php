<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table.
     */
    public function run(): void
    {
        // Create an admin/instructor user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@lms.test',
        ]);

        // Create student users
        User::factory(5)->create();
    }
}
