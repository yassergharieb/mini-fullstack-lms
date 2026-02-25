<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Seed the levels table with predefined levels.
     */
    public function run(): void
    {
        $levels = ['Beginner', 'Intermediate', 'Advanced'];

        foreach ($levels as $name) {
            Level::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
            ]);
        }
    }
}
