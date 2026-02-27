<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\UpdateEnrollmentRequest;

class EnrollmentController extends Controller
{
    protected $enrollmentService;
    protected $progressService;

    public function __construct(
        \App\Services\EnrollmentService $enrollmentService,
        \App\Services\ProgressService $progressService
    ) {
        $this->enrollmentService = $enrollmentService;
        $this->progressService = $progressService;
    }

    /**
     * Display a listing of the user's enrolled courses.
     */
    public function index()
    {
        $user = auth()->user();
        $enrollments = $user->enrollments()
            ->with(['course.level', 'course.creator'])
            ->get();
            
        $courses = $enrollments->pluck('course');

        // Dashboard Stats
        $totalCourses = $courses->count();
        
        $completedLessonsCount = \App\Models\LessonProgress::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->count();
            
        $totalProgress = 0;
        foreach ($courses as $course) {
            $totalProgress += $this->progressService->getCourseProgress($user, $course);
        }
        
        $avgProgress = $totalCourses > 0 ? round($totalProgress / $totalCourses) : 0;

        return view('courses.index', compact('courses', 'totalCourses', 'completedLessonsCount', 'avgProgress'));
    }

    /**
     * Store a newly created enrollment.
     */
    public function enroll(StoreEnrollmentRequest $request, $slug)
    {
        $course = \App\Models\Course::where('slug', $slug)->firstOrFail();
        
        try {
            $this->enrollmentService->enroll(auth()->user(), $course);
            return redirect()->route('courses.play', $course->slug)->with('success', 'Enrolled successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEnrollmentRequest $request, Enrollment $enrollment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        //
    }
}
