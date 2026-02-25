<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Seed the enrollments table by enrolling each user in random courses.
     */
    public function run(): void
    {
        $users = User::all();
        $courses = Course::all();

        foreach ($users as $user) {
            // Enroll each user in 2-3 random courses
            $enrolledCourses = $courses->random(min(rand(2, 3), $courses->count()));

            foreach ($enrolledCourses as $course) {
                Enrollment::create([
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
