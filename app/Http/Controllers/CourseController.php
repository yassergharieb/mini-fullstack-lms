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
        $course->load(['level', 'creator']);

        $lessons = $course->lessons()
            ->when(!auth()->check(), function ($query) {
                return $query->where('is_free_preview', true);
            })
            ->orderBy('order')
            ->get();

        return view('courses.show', compact('course', 'lessons'));
    }

}
