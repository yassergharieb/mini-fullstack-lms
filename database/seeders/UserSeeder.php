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
        // Create roles
        $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'super_admin']);
        $studentRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'student']);

        // Create an admin/instructor user
        // Credentials: admin@lms.test / password
        $admin = User::firstOrCreate([
            'email' => 'admin@lms.test',
        ], [
            'name' => 'Admin User',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $admin->syncRoles([$superAdminRole]);

        // Create student users
        User::factory(5)->create()->each(function ($user) use ($studentRole) {
            $user->assignRole($studentRole);
        });
    }
}
