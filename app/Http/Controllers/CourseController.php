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


    protected $enrollmentService;

    public function __construct(\App\Services\EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    public function enroll(StoreEnrollmentRequest $request, $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        
        try {
            $this->enrollmentService->enroll(auth()->user(), $course);
            return redirect()->route('courses.play', $course->slug)->with('success', 'Enrolled successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function show(Course $course)
    {

        die($course);
    }

}
