<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Seed the lessons table with 5 lessons per course.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            for ($i = 1; $i <= 5; $i++) {
                Lesson::factory()->create([
                    'course_id' => $course->id,
                    'order' => $i,
                    'is_free_preview' => $i === 1,
                ]);
            }
        }
    }
}
