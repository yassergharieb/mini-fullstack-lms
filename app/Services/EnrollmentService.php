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
        if ($this->isEnrolled($user, $course)) {
            throw new Exception("You are already enrolled in this course.");
        }

        return Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);
    }

    public function isEnrolled(User $user, Course $course): bool
    {
        return $user->enrollments()->where('course_id', $course->id)->exists();
    }
}
