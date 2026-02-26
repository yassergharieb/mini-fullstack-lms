<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Exception;

class EnrollmentService
{
    /**
     * @throws Exception
     */
    public function enroll(User $user, Course $course): Enrollment
    {
        if (!$course->is_published) {
            throw new Exception("This course is currently a draft and not open for enrollment.");
        }

        return Enrollment::firstOrCreate([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function isEnrolled(User $user, Course $course): bool
    {
        return $user->enrollments()->where('course_id', $course->id)->exists();
    }
}
