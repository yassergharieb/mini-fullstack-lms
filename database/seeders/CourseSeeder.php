<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Level;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Seed the courses table with 2 courses per level.
     */
    public function run(): void
    {
        $levels = Level::all();
        $creator = User::first();

        foreach ($levels as $level) {
            Course::factory(2)->create([
                'level_id' => $level->id,
                'created_by' => $creator->id,
            ]);
        }
    }
}
