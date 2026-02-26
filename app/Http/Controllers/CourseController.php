<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Models\Course;
use  App\Models\Lesson;
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

        return view('course', [
            'course' => $course,
            'currentLesson' => $lesson,
            'nextLesson' => $nextLesson,
            'previousLesson' => $previousLesson,
        ]);
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
