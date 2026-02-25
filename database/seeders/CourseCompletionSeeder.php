<?php

namespace Database\Seeders;

use App\Models\CourseCompletion;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Database\Seeder;

class CourseCompletionSeeder extends Seeder
{
    /**
     * Seed course_completions for enrollments where all lessons are completed.
     */
    public function run(): void
    {
        $enrollments = Enrollment::with('course.lessons')->get();

        foreach ($enrollments as $enrollment) {
            $totalLessons = $enrollment->course->lessons->count();

            if ($totalLessons === 0) {
                continue;
            }

            $completedLessons = LessonProgress::where('user_id', $enrollment->user_id)
                ->whereIn('lesson_id', $enrollment->course->lessons->pluck('id'))
                ->whereNotNull('completed_at')
                ->count();

            if ($completedLessons === $totalLessons) {
                CourseCompletion::create([
                    'course_id' => $enrollment->course_id,
                    'user_id' => $enrollment->user_id,
                ]);
            }
        }
    }
}
