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
    /**
     * Display a listing of the  user courses.
     */
    public function index()
    {
        $courses = auth()->user()->enrollments()
            ->with(['course.level', 'course.creator'])
            ->get()
            ->pluck('course');

        return view('courses.index', compact('courses'));
    }


    protected $enrollmentService;
    protected $progressService;

    public function __construct(
        \App\Services\EnrollmentService $enrollmentService,
        \App\Services\ProgressService $progressService
    ) {
        $this->enrollmentService = $enrollmentService;
        $this->progressService = $progressService;
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

    public function play(Course $course, Lesson $lesson = null)
    {
        $course->load(['lessons' => function($query) {
            $query->orderBy('order');
        }]);

        if (!$lesson || $lesson->course_id !== $course->id) {
            $lesson = $course->lessons->first();
        }

        if (!$lesson) {
            return redirect()->route('courses.show', $course->slug)->with('error', 'No lessons available.');
        }

        $nextLesson = $course->lessons->where('order', '>', $lesson->order)->sortBy('order')->first();
        $previousLesson = $course->lessons->where('order', '<', $lesson->order)->sortByDesc('order')->first();

        $completedLessonsCount = \App\Models\LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->whereNotNull('completed_at')
            ->count();
        
        $percentage = $this->progressService->getCourseProgress(auth()->user(), $course);

        return view('course', [
            'course' => $course,
            'currentLesson' => $lesson,
            'nextLesson' => $nextLesson,
            'previousLesson' => $previousLesson,
            'completedCount' => $completedLessonsCount,
            'percentage' => $percentage,
        ]);
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
