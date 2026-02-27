<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $enrollmentService;

    public function __construct(\App\Services\EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    public function show(Course $course)
    {
        $course->load(['level', 'creator']);

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = $this->enrollmentService->isEnrolled(auth()->user(), $course);
        }

        $lessons = $course->lessons()
            ->when(!$isEnrolled, function ($query) {
                return $query->where('is_free_preview', true);
            })
            ->orderBy('order')
            ->get();

        return view('courses.show', compact('course', 'lessons', 'isEnrolled'));
    }

}
