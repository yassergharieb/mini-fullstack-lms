<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use Carbon\Carbon;

class ProgressService
{
    public function markLessonAsComplete(User $user, Lesson $lesson): LessonProgress
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($user, $lesson) {
            $progress = LessonProgress::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'completed_at' => Carbon::now(),
                ]
            );

            $this->checkAndMarkCourseAsCompleted($user, $lesson->course);

            return $progress;
        });
    }

    public function getCourseProgress(User $user, Course $course): int
    {
        $totalLessons = $course->lessons()->count();
        if ($totalLessons === 0) return 0;

        $completedLessons = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->whereNotNull('completed_at')
            ->count();

        return (int) (($completedLessons / $totalLessons) * 100);
    }

    public function checkAndMarkCourseAsCompleted(User $user, Course $course): ?CourseCompletion
    {
        $progress = $this->getCourseProgress($user, $course);

        if ($progress === 100) {
            $completion = CourseCompletion::firstOrCreate([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);

            if ($completion->wasRecentlyCreated) {
                \App\Jobs\SendCourseCompletionEmailJob::dispatch($user, $course);
            }

            return $completion;
        }

        return null;
    }

    public function updateProgress(User $user, Lesson $lesson, int $watchSeconds): LessonProgress
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($user, $lesson, $watchSeconds) {
            $progress = LessonProgress::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'lesson_id' => $lesson->id,
                ],
                [
                    'started_at' => Carbon::now(),
                ]
            );

            $progress->update([
                'watch_seconds' => $watchSeconds,
            ]);

            // Mark as complete if 95% or more
            if ($lesson->duration > 0 && ($watchSeconds / $lesson->duration) >= 0.95) {
                if (!$progress->completed_at) {
                    $progress->update(['completed_at' => Carbon::now()]);
                    $this->checkAndMarkCourseAsCompleted($user, $lesson->course);
                }
            }

            return $progress;
        });
    }
}
