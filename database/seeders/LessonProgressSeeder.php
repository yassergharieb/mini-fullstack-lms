<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Database\Seeder;

class LessonProgressSeeder extends Seeder
{
    /**
     * Seed the lesson_progress table based on existing enrollments.
     */
    public function run(): void
    {
        $enrollments = Enrollment::with('course.lessons')->get();

        foreach ($enrollments as $enrollment) {
            $lessons = $enrollment->course->lessons->sortBy('order');

            // Mark some lessons as started/completed (first 2-3 lessons)
            $progressCount = min(rand(1, 3), $lessons->count());

            foreach ($lessons->take($progressCount) as $index => $lesson) {
                $isCompleted = $index < $progressCount - 1;

                LessonProgress::create([
                    'user_id' => $enrollment->user_id,
                    'lesson_id' => $lesson->id,
                    'started_at' => now()->subDays(rand(1, 30)),
                    'completed_at' => $isCompleted ? now()->subDays(rand(0, 10)) : null,
                    'watch_seconds' => $isCompleted ? $lesson->duration : rand(60, $lesson->duration),
                ]);
            }
        }
    }
}
