<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the  user courses.
     */
    public function index()
    {

    }


    public function enroll(StoreEnrollmentRequest $request , $course_id)
    {

    }



    public function show(Course $course)
    {
        $course->load(['level', 'lessons' => function($query) {
            $query->orderBy('order');
        }]);

        $isEnrolled = auth()->check() && auth()->user()->enrollments()->where('course_id', $course->id)->exists();

        if ($isEnrolled) {
            $currentLesson = $course->lessons()->first(); // Default to first lesson for now
            return view('course', compact('course', 'currentLesson'));
        }

        return view('courses.show', compact('course'));
    }

}
